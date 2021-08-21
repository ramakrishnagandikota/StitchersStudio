<?php

namespace App\Http\Controllers\Knitter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserMeasurements;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use Redirect;
use Validator;
use File;
use Image;
use DB;
use DateTime;
use Carbon\Carbon;
use Log;
use App\Models\Project;
use App\Models\SubscriptionLimits;

class KnitterMeasurementController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    function load_measurements(){
        if(!Auth::user()->hasRole('Knitter')){
            return response()->json(['error' => 'You have loggedin with a different role.']);
            exit;
        }
        $measurements = User::find(Auth::user()->id)->measurements()->orderBy('updated_at','DESC')->take(3)->get();
        $projects = User::find(Auth::user()->id)->projects()->where('is_deleted',0)->orderBy('updated_at','DESC')->take(3)->get();
        return view('knitter.measurements.load-measurements',compact('measurements','projects'));
    }

    function add_measurements(Request $request){
        //$request->session()->forget('measurement_id');
    if(Auth::user()->subscription_type == 1){
    $count = DB::table('user_measurements')->where('user_id',Auth::user()->id)->count();
        if($count == 1){
            Session::flash('error','You are in Free subscription. Please upgrade to Basic to add more measurement profiles.');
            return redirect('knitter/measurements');
        }

    }
        $mid = $request->session()->get('measurement_id');
        $check = UserMeasurements::where('id',$mid)->count();
        if($check){
            return redirect('knitter/measurements/edit/'.base64_encode($mid));
        }
        return view('knitter.measurements.add-measurement');
    }

    function get_my_measurements(){
        if(!Auth::user()->hasRole('Knitter')){
            return response()->json(['error' => 'You have loggedin with a different role.']);
            exit;
        }

        if((Auth::user()->remainingDays() == 0) && (Auth::user()->isBasic() == true)){
            Auth::user()->subscription()->detach();
            Auth::user()->subscription()->attach(['1']);
        }
        
        $meas = User::find(Auth::user()->id)->measurements;
        $measurementsLimit = SubscriptionLimits::where('subscription_type','Free')->where('subscription_property','Projects')->first();
        return view('knitter.measurements.measurements',compact('meas','measurementsLimit'));
    }

    function edit_measurements(Request $request){
        $id = base64_decode($request->id);
        try {
            $me = UserMeasurements::find($id);
            return view('knitter.measurements.edit-measurements',compact('me','id'));
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    function create_measurements(Request $request){



        if(isset($request->image)){
            $imagepath = $request->image[0];
            $imageext = $request->ext[0];
        }else{
            $imagepath = "https://via.placeholder.com/200X250";
            $imageext = '';
        }

        $mp = $request->measurement_preference;

        $array = array('user_id' => Auth::user()->id,'m_title' => $request->m_title,'m_date' => date('Y-m-d',strtotime($request->m_date)),'measurement_preference' => $request->measurement_preference,'user_meas_image' => $imagepath,'ext' => $imageext,'created_at' => Carbon::now());
        $data = DB::table('user_measurements')->insertGetId($array);

        if($data){
$body_size = DB::table('measurement_variables')->where('variable_type','body_size')->get();
$body_length = DB::table('measurement_variables')->where('variable_type','body_length')->get();
$arm_size = DB::table('measurement_variables')->where('variable_type','arm_size')->orderBy('sort','ASC')->get();
$arm_length = DB::table('measurement_variables')->where('variable_type','arm_length')->get();
$neck_and_shoulders = DB::table('measurement_variables')->where('variable_type','neck_and_shoulders')->get();
$request->session()->put('measurement_id', $data);
            return view('knitter.measurements.getmeasurements',compact('data','mp','body_size','body_length','arm_size','arm_length','neck_and_shoulders'));
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function update_variables(Request $request){
        //print_r($request->all());
        //echo count($request->all());
        //exit;

        if($request->type == 'add'){
            $id = base64_decode($request->id);

       $array = array('hips' => $request->hips,'waist' => $request->waist,'waist_front' => $request->waist_front,'bust' => $request->bust,'bust_front' => $request->bust_front,'bust_back' => $request->bust_back,'waist_to_underarm' => $request->waist_to_underarm,'armhole_depth' => $request->armhole_depth,'wrist_circumference' => $request->wrist_circumference,'forearm_circumference' => $request->forearm_circumference,'upperarm_circumference' => $request->upperarm_circumference,'shoulder_circumference' => $request->shoulder_circumference,'wrist_to_underarm' => $request->wrist_to_underarm,'wrist_to_elbow' => $request->wrist_to_elbow,'elbow_to_underarm' => $request->elbow_to_underarm,'wrist_to_top_of_shoulder' => $request->wrist_to_top_of_shoulder,'depth_of_neck' => $request->depth_of_neck,'neck_width' => $request->neck_width,'neck_circumference' => $request->neck_circumference,'neck_to_shoulder' => $request->neck_to_shoulder,'shoulder_to_shoulder' => $request->shoulder_to_shoulder,'updated_at' => Carbon::now());
        }else{
            $id = base64_decode($request->id);

            if(isset($request->image)){
            $imagepath = $request->image;
            $imageext = $request->ext;

            $array = array('m_title' => $request->m_title,'m_date' => date('Y-m-d',strtotime($request->m_date)) ,'measurement_preference' => $request->measurement_preference ,'user_meas_image' => $imagepath,'ext' => $imageext,'hips' => $request->hips,'waist' => $request->waist,'waist_front' => $request->waist_front,'bust' => $request->bust,'bust_front' => $request->bust_front,'bust_back' => $request->bust_back,'waist_to_underarm' => $request->waist_to_underarm,'armhole_depth' => $request->armhole_depth,'wrist_circumference' => $request->wrist_circumference,'forearm_circumference' => $request->forearm_circumference,'upperarm_circumference' => $request->upperarm_circumference,'shoulder_circumference' => $request->shoulder_circumference,'wrist_to_underarm' => $request->wrist_to_underarm,'wrist_to_elbow' => $request->wrist_to_elbow,'elbow_to_underarm' => $request->elbow_to_underarm,'wrist_to_top_of_shoulder' => $request->wrist_to_top_of_shoulder,'depth_of_neck' => $request->depth_of_neck,'neck_width' => $request->neck_width,'neck_circumference' => $request->neck_circumference,'neck_to_shoulder' => $request->neck_to_shoulder,'shoulder_to_shoulder' => $request->shoulder_to_shoulder,'updated_at' => Carbon::now());

            }else{
                $array = array('m_title' => $request->m_title,'m_date' => date('Y-m-d',strtotime($request->m_date)) ,'measurement_preference' => $request->measurement_preference ,'hips' => $request->hips,'waist' => $request->waist,'waist_front' => $request->waist_front,'bust' => $request->bust,'bust_front' => $request->bust_front,'bust_back' => $request->bust_back,'waist_to_underarm' => $request->waist_to_underarm,'armhole_depth' => $request->armhole_depth,'wrist_circumference' => $request->wrist_circumference,'forearm_circumference' => $request->forearm_circumference,'upperarm_circumference' => $request->upperarm_circumference,'shoulder_circumference' => $request->shoulder_circumference,'wrist_to_underarm' => $request->wrist_to_underarm,'wrist_to_elbow' => $request->wrist_to_elbow,'elbow_to_underarm' => $request->elbow_to_underarm,'wrist_to_top_of_shoulder' => $request->wrist_to_top_of_shoulder,'depth_of_neck' => $request->depth_of_neck,'neck_width' => $request->neck_width,'neck_circumference' => $request->neck_circumference,'neck_to_shoulder' => $request->neck_to_shoulder,'shoulder_to_shoulder' => $request->shoulder_to_shoulder,'updated_at' => Carbon::now());
            }


        }


      $ins = DB::table('user_measurements')->where('id',$id)->update($array);


        if($ins){
            $request->session()->forget('measurement_id');
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    function upload_measurement_picture(Request $request){

        $image = $request->file('file');
        for ($i=0; $i < count($image); $i++) {
            $fname = $this->clean($image[$i]->getClientOriginalName());
            $filename = time().'-'.$fname;
            $ext = $image[$i]->getClientOriginalExtension();

         $s3 = \Storage::disk('s3');
        //exit;
        $filepath = 'knitfit/'.$filename;

        if($ext == 'pdf'){
            $pu = $s3->put('/'.$filepath, file_get_contents($image[$i]),'public');
        }else{
        $ext = $ext;
        $img = Image::make($image[$i]);
        $height = Image::make($image[$i])->height();
        $width = Image::make($image[$i])->width();
        $img->orientate();
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->encode('jpg');
        $pu = $s3->put('/'.$filepath, $img->__toString(), 'public');
        }

       if($pu){
         return response()->json(['path1' => $filepath, 'path' => 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath,'ext' => $ext]);
     }else{
        echo 'error';
     }
        }
    }


    function measurement_confirmation(Request $request){
        $id = base64_decode($request->id);
$us = DB::table('user_measurements')->where('id',$id)->first();
$mp = $us->measurement_preference;
$body_size = DB::table('measurement_variables')->where('variable_type','body_size')->get();
$body_length = DB::table('measurement_variables')->where('variable_type','body_length')->get();
$arm_size = DB::table('measurement_variables')->where('variable_type','arm_size')->orderBy('sort','ASC')->get();
$arm_length = DB::table('measurement_variables')->where('variable_type','arm_length')->get();
$neck_and_shoulders = DB::table('measurement_variables')->where('variable_type','neck_and_shoulders')->get();
return view('knitter.measurements.measurements-add-confirm',compact('us','mp','body_size','body_length','arm_size','arm_length','neck_and_shoulders'));
    }


    function get_measurement_variables(Request $request){
         $id = base64_decode($request->id);
//$us = DB::table('user_measurements')->where('id',$id)->first();
if($request->mp =='inches'){
    $mp = 'inches';
}else{
    $mp = 'centimeters';
}

$us = DB::table('user_measurements')->where('id',$id)->where('measurement_preference',$mp)->first();

$body_size = DB::table('measurement_variables')->where('variable_type','body_size')->get();
$body_length = DB::table('measurement_variables')->where('variable_type','body_length')->get();
$arm_size = DB::table('measurement_variables')->where('variable_type','arm_size')->orderBy('sort','ASC')->get();
$arm_length = DB::table('measurement_variables')->where('variable_type','arm_length')->get();
$neck_and_shoulders = DB::table('measurement_variables')->where('variable_type','neck_and_shoulders')->get();
return view('knitter.measurements.edit-measurement-variables',compact('id','us','mp','body_size','body_length','arm_size','arm_length','neck_and_shoulders'));
    }

    function delete_measurements(Request $request){
        $projectsCount = Project::where('measurement_profile',$request->id)->where('is_deleted',0)->count();
        if($projectsCount > 0){
            return 'There are few projects associated with this measurement profile.Delete the projects created with this profile and then delete this measurement.';
            exit;
        }
        $id = $request->id;
        $me = UserMeasurements::find($id);
        $del = $me->delete();
        if($del){
            return 0;
        }else{
            return 1;
        }
    }

    function delete_picture(Request $request){
        if($request->type == 'insert'){
            $s3 = \Storage::disk('s3');
            if($s3->exists($request->path)){
                $s3->delete($request->path);
            }else{
                $del = 'no';
            }
            //exit;
        }else{
            $id = $request->id;
            $s3 = \Storage::disk('s3');
            $delete = $s3->delete($request->path);
            $me = UserMeasurements::find($id);
            $me->user_meas_image = 'https://via.placeholder.com/200X250';
            $del = $me->save();
        }

        if($del){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }


    function delete_only_picture(Request $request){
        $s3 = \Storage::disk('s3');
        $del = $s3->delete($request->path);
        if($del){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }
}
