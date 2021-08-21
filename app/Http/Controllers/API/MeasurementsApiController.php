<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Http\Requests\MeasurementRequest;
use App\Http\Resources\MeasurementResource;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserMeasurements;
use Auth;
use App\User;
use File;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use DB;
use DateTime;
use App\Models\MeasurementVariables;
use App\Models\Projectimages;
use App\Models\Project;
use Carbon\Carbon;

class MeasurementsApiController extends Controller
{

    function dashboard(){
		if(Auth::user()->remainingDays() == 0){
            Auth::user()->subscription()->detach();
            Auth::user()->subscription()->attach(['1']);
        }
        //return MeasurementResource::collection(Auth::user()->measurements()->latest()->take(5)->get());
		$firstProject = Project::where('user_id',Auth::user()->id)->where('is_archive',0)->where('is_deleted',0)->first();
		$jsonArray = array();
        $projects = Auth::user()->projects()->where('is_archive',0)->where('is_deleted',0)->select('id','name','pattern_type','created_at','updated_at','measurement_profile','downloaded_offline','project_sync','downloaded_at','status')->orderBy('updated_at','DESC')->take(3)->get();
        $measurements = MeasurementResource::collection(Auth::user()->measurements()->orderBy('updated_at','DESC')->take(3)->get());
		$app_rating = (Auth::user()->app_rating == 1) ? true : false;

        for ($j=0; $j < count($projects); $j++){
            $id = $projects[$j]->id;
            $jsonArray[$j]['id'] = $projects[$j]->id;
            $jsonArray[$j]['name'] = $projects[$j]->name;
            $jsonArray[$j]['pattern_type'] = $projects[$j]->pattern_type;
            $measurement = UserMeasurements::where('id',$projects[$j]->measurement_profile)->select('m_title')->first();
            if($measurement){
                $jsonArray[$j]['measurement_profile'] = $measurement->m_title;
            }else{
                $jsonArray[$j]['measurement_profile'] = '';
            }
            $jsonArray[$j]['created_at'] = $projects[$j]->created_at;
            $jsonArray[$j]['updated_at'] = $projects[$j]->updated_at;
            $image = Projectimages::where('project_id',$id)->select('image_path')->first();
            $jsonArray[$j]['image'] = $image ? $image->image_path : '';
			if(Auth::user()->remainingDays() == 0){
				if($firstProject->id == $projects[$j]->id){
					$jsonArray[$j]['show'] = true;
				}else{
					$jsonArray[$j]['show'] = false;
				}
			}else{
				$jsonArray[$j]['show'] = true;
			}
			
			if($projects[$j]->status == 1){
				$jsonArray[$j]['project_status'] = 'generated';
			}else if($projects[$j]->status == 2){
				$jsonArray[$j]['project_status'] = 'workinprogress';
			}else{
				$jsonArray[$j]['project_status'] = 'completed';
			}
			
			$jsonArray[$j]['downloaded'] = ($projects[$j]->downloaded_offline == 1) ? true : false;
            $jsonArray[$j]['project_sync'] = ($projects[$j]->project_sync == 1) ? 'sync' : 'notsync';
            $jsonArray[$j]['downloaded_at'] = ($projects[$j]->downloaded_at == '') ? NULL :
                Carbon::parse($projects[$j]->downloaded_at)->diffForHumans();
        }
		$sub = (Auth::user()->remainingDays() == 0) ? true : false;
        $array = array('projects' => $jsonArray,'measurements' => $measurements,'subscription_expired' => $sub,'app_rating' => $app_rating,'app_version' => '1.6');

        return response()->json(['data' => $array]);
    } 
	
	function update_app_rating(Request $request){
		$request->validate(['app_rating' => 'required']);
		$user = User::find(Auth::user()->id);
		$user->app_rating = $request->app_rating;
		$save = $user->save();
		if($save){
			return response()->json(['status' => 'success']);
		}else{
			return response()->json(['status' => 'fail','message' => 'Unable to update rating for the app.']);
		}
		
	}

    function check_measurement_name(Request $request){
        $name =  $request->m_title;
        $check = UserMeasurements::where('m_title',$name)->count();
        if($check != 0){
            return response()->json(['success' => false,'message' => 'Measurement name already exists.Please select another one.']);
        }else{
            return response()->json(['success' => true]);
        }
    }

    function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
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
         return response()->json(['path' => 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath,'ext' => $ext]);
     }else{
        echo 'error';
     }
        }
    }

    public function index(){
		
		if(Auth::user()->remainingDays() == 0){
            Auth::user()->subscription()->detach();
            Auth::user()->subscription()->attach(['1']);
        }
		
    	return MeasurementResource::collection(Auth::user()->measurements()->latest()->get());
    }

    public function store(MeasurementRequest $request){
		//return response()->json(['data' => $request->all()]);
		//exit;
		//$m = json_encode($request->all());
    	$measurement = Auth::user()->measurements()->create($request->all());
   //return response(new MeasurementResource($measurement), Response::HTTP_CREATED);
    	return response()->json(['created' => true,'id' => $measurement->id],Response::HTTP_CREATED);
    }

    public function show(UserMeasurements $measurement){
    	return new MeasurementResource($measurement);
    }
	
	function editMeasurements(Request $request){
        $jsonArray = array();
        $measurements = UserMeasurements::where('id',$request->id)->get();
        $columns = DB::getSchemaBuilder()->getColumnListing('user_measurements');
        $aa = array('hips','waist','waist_front','bust','bust_front','bust_back','waist_to_underarm','armhole_depth','wrist_circumference',
'forearm_circumference','upperarm_circumference','shoulder_circumference','wrist_to_underarm','wrist_to_elbow','elbow_to_underarm',
'wrist_to_top_of_shoulder','depth_of_neck','neck_width','neck_circumference','neck_to_shoulder','shoulder_to_shoulder');
        for ($i=0; $i < count($measurements); $i++) { 
            $jsonArray[$i]['id'] = $measurements[$i]->id;
            $jsonArray[$i]['m_title'] = $measurements[$i]->m_title;
            $jsonArray[$i]['slug'] = $measurements[$i]->slug;
            $jsonArray[$i]['m_description'] = $measurements[$i]->m_description;
            $jsonArray[$i]['m_date'] = $measurements[$i]->m_date;
            $jsonArray[$i]['measurement_preference'] = $measurements[$i]->measurement_preference;
            $jsonArray[$i]['user_meas_image'] = $measurements[$i]->user_meas_image;
            $jsonArray[$i]['ext'] = $measurements[$i]->ext;

            for ($j=0; $j < count($aa); $j++) { 
                $a = $aa[$j];
                $jsonArray[$i][$a] = (object) array('id' => $measurements[$i]->$a ? $measurements[$i]->$a : 0,'name' => $measurements[$i]->$a ? $measurements[$i]->$a : 0);
            }
            $jsonArray[$i]['in_preview'] = $measurements[$i]->in_preview;
            
        }
        return response()->json(['measurements' => $jsonArray]);
    }

    public function update(Request $request, UserMeasurements $measurement){
    	$measurement->update($request->all());
        return response()->json(['updated' => true], Response::HTTP_ACCEPTED);
    }

    public function destroy(UserMeasurements $measurement){
		$projectsCount = Project::where('measurement_profile',$measurement->id)->where('is_deleted',0)->count();
		if($projectsCount > 0){
			return response()->json(['deleted' => false,'message' => 'There are few projects associated with this measurement profile.Delete the projects created with this profile and then delete this measurement.']);
			exit;
		}
    	$measurement->delete();
        return response()->json(['deleted' => true]);
    }
	
	public function show_measurement_images(Request $request){

        $uom = $request->uom;
        
        $jsonArray = array();
        $variables = MeasurementVariables::orderBy('sort','ASC')->get();

        for ($i=0; $i < count($variables); $i++) { 
            $name = $variables[$i]->variable_name;
            $nam = strtolower($name);
            $na = str_replace(' ', '_', $nam);

            $jsonArray[$i]['id'] = $variables[$i]->id;
            $jsonArray[$i]['variable_type'] = $variables[$i]->variable_type;
            $jsonArray[$i]['variable_title'] = ucfirst($variables[$i]->variable_name);
            $jsonArray[$i]['variable_name'] = $na;
            $jsonArray[$i]['variable_image'] = $variables[$i]->variable_image;
            $jsonArray[$i]['variable_description'] = $variables[$i]->variable_description;
            $jsonArray[$i]['position'] = $variables[$i]->sort;
			
            if($uom == 'inches'){
				$jsonArray[$i]['uom'] = 'Inches';
                $jsonArray[$i]['min_value'] = $variables[$i]->v_inch_min;
                $jsonArray[$i]['max_value'] = $variables[$i]->v_inch_max;
            }else{
				$jsonArray[$i]['uom'] = 'Centimeters';
                $jsonArray[$i]['min_value'] = $variables[$i]->v_cm_min;
                $jsonArray[$i]['max_value'] = $variables[$i]->v_cm_max;
            }
        }

        $array = array('variables' => $jsonArray);
        return response()->json(['data' => $array]);

    }
}
