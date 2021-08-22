<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use App\Models\Patterns\MeasurementVariables;
use App\Models\Patterns\MeasurementProfile;
use App\Models\Patterns\MeasurementValues;
use DB;
use Session;
use Image;

class MeasurementsController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    function index(){
        $measurements = MeasurementProfile::where('user_id',Auth::user()->id)->get();
        return view('designer.Measurements.index',compact('measurements'));
    }

    function view_measurement_profile(Request $request){
        $id = base64_decode($request->id);
        $measurements = MeasurementProfile::where('id',$id)->first();
        $measurementVariables = MeasurementVariables::orderBy('id','ASC')->groupBy('variable_type')->get();
        $body_size = MeasurementVariables::where('variable_type','body_size')->get();
        $body_length = MeasurementVariables::where('variable_type','body_length')->get();
        $arm_size = MeasurementVariables::where('variable_type','arm_size')->get();
        $arm_length = MeasurementVariables::where('variable_type','arm_length')->get();
        $neck_and_shoulders = MeasurementVariables::where('variable_type','neck_and_shoulders')->get();
        $pattern_specific = MeasurementVariables::where('variable_type','pattern_specific')->get();
        $measurementValues = MeasurementValues::where('measurement_profile_id',$id)->get();
        return view('designer.Measurements.edit',compact('measurementVariables','measurements','measurementValues','body_size','body_length','arm_size','arm_length','neck_and_shoulders','pattern_specific'));
    }

    function check_measurement_name(Request $request){
        $m_title = $request->m_title;
        $measurementCount = MeasurementProfile::where('m_title',$m_title)->where('user_id',Auth::user()->id)->count();
        if($measurementCount > 0){
            return response()->json(['valid' => false]);
        }else{
            return response()->json(['valid' => true]);
        }
    }

    function create_measurement_profile(Request $request){
        $measurement = new MeasurementProfile;
        $measurement->user_id = Auth::user()->id;
        $measurement->m_title = $request->m_title;
        $measurement->uom = $request->uom;
        $measurement->created_at = Carbon::now();
        $save = $measurement->save();

        if($save){
            return response()->json(['status' => 'success','URL' => url('designer/measurements/'.base64_encode($measurement->id).'/show')]);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function update_measurement_profile(Request $request){
        //print_r($request->all());
        //exit;
        $measurement = MeasurementProfile::find($request->m_id);
        $measurement->m_title = $request->m_title;
        $measurement->uom = $request->uom;
        if($request->image){
            $measurement->m_image = $request->image;
        }
        $measurement->updated_at = Carbon::now();
        $save = $measurement->save();

        $check =  DB::table('p_measurement_values')->where('measurement_profile_id',$request->m_id)->count();

        if($save){
            if($request->uom == 'in'){
                $measurement_variable_id = $request->measurement_variable_id_in;
            }else{
                $measurement_variable_id = $request->measurement_variable_id_cm;
            }
            for ($i=0;$i<count($measurement_variable_id);$i++){
                if($request->uom == 'in'){
                    if($check > 0){
                        $mvalue = $request->measurement_value_in[$i] ? $request->measurement_value_in[$i] : 0;
                        $array = array('measurement_value' => $mvalue);
                        DB::table('p_measurement_values')->where('measurement_profile_id',$request->m_id)->where('measurement_variable_id',$request->measurement_variable_id_in[$i])->update($array);
                    }else{
                        $mvalue = $request->measurement_value_in[$i] ? $request->measurement_value_in[$i] : 0;
                        $array = array('user_id' => Auth::user()->id,'measurement_profile_id' => $request->m_id,'measurement_variable_id' => $request->measurement_variable_id_in[$i],'measurement_value' => $mvalue);
                        DB::table('p_measurement_values')->insert($array);
                    }

                }else{
                    if($check > 0){
                        $mvalue = $request->measurement_value_cm[$i] ? $request->measurement_value_cm[$i] : 0;
                        $array = array('measurement_value' => $mvalue);
                        DB::table('p_measurement_values')->where('measurement_profile_id',$request->m_id)->where('measurement_variable_id',$request->measurement_variable_id_cm[$i])->update($array);
                    }else{
                        $mvalue = $request->measurement_value_cm[$i] ? $request->measurement_value_cm[$i] : 0;
                        $array = array('user_id' => Auth::user()->id,'measurement_profile_id' => $request->m_id,'measurement_variable_id' => $request->measurement_variable_id_cm[$i],'measurement_value' => $mvalue);
                        DB::table('p_measurement_values')->insert($array);
                    }

                }


            }
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function delete_measurement_profile(Request $request){
        $id = $request->id;
        $measurement = MeasurementProfile::find($request->m_id);
        $del = $measurement->delete();
        if($del){
            MeasurementValues::where('measurement_profile_id',$id)->delete();
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete profile , try again after some time.']);
        }
    }

    /* Pattern specific measurements */

    function pattern_specific_measurements(Request $request){
        $measurementVariables = MeasurementVariables::where('variable_type','pattern_specific')->get();
        return view('designer.PatternSpecificMeasurements.index',compact('measurementVariables'));
    }

    function add_pattern_specific_measurements(Request $request){
        $request->validate([
            'variable_name' => 'required',
            'v_inch_min' => 'required',
            'v_inch_max' => 'required',
            'v_cm_min' => 'required',
            'v_cm_max' => 'required',
        ]);

        $mvariables = new MeasurementVariables;
        $mvariables->variable_type = 'pattern_specific';
        $mvariables->variable_name = $request->variable_name;
        $mvariables->variable_description = $request->variable_description;
        $mvariables->variable_image = $request->variable_image;
        $mvariables->v_inch_min = $request->v_inch_min;
        $mvariables->v_inch_max = $request->v_inch_max;
        $mvariables->v_cm_min = $request->v_cm_min;
        $mvariables->v_cm_max = $request->v_cm_max;
        $save = $mvariables->save();
        if($save){
            Session::flash('success','Measurement variable added successfully');
        }else{
            Session::flash('error','Unable to add measurement variable.');
        }
        return redirect()->back();
    }


    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-.]/', '', $string); // Removes special chars.
    }

    function image_upload(Request $request){
        $image = $request->file('file');

        for ($i=0; $i < count($image); $i++) {
            $oname = $this->clean($image[$i]->getClientOriginalName());
            $filename = time().'-'.$oname;
            $ext = $image[$i]->getClientOriginalExtension();

            $s3 = \Storage::disk('s3');
            //exit;
            $filepath = 'knitfit/'.$filename;

            //$ext = 'jpg';
            $img = Image::make($image[$i]);
            $height = Image::make($image[$i])->height();
            $width = Image::make($image[$i])->width();
            $img->orientate();
            $img->resize($width, $height, function ($constraint) {
                //$constraint->aspectRatio();
            });
            $img->encode('jpg');
            $pu = $s3->put('/'.$filepath, $img->__toString(), 'public');


            if($pu){
                return response()->json(['path1' => $filepath, 'path' => 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath,'ext' => $ext]);
            }else{
                echo 'error';
            }
        }
    }

    function delete_image(Request $request){
        $id= $request->id;
        $measurement = MeasurementProfile::find($id);
        $measurement->m_image = '';
        $save = $measurement->save();

        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete image, try again after sometime']);
        }
    }
}
