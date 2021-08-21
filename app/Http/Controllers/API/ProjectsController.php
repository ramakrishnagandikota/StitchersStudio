<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectsResource;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use App\User;
//use App\Models\User;
use App\Models\Project;
use DB;
use App\Models\UserMeasurements;
use Carbon\Carbon;
use Image;
use File;
use App\Models\Projectimages;
use App\Models\Projectneedle;
use App\Models\Projectyarn;
use App\Models\NeedleSizes;
use App\Models\GaugeConversion;
use Illuminate\Support\Str;
use App\Models\ProjectNotes;
use App\Models\Products;
use App\Models\Product_images;
use App\Models\ProductPdf;
use App\Models\ProductDesignerMeasurements;
use App\Models\ProjectsDesignerMeasurements;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\MeasurementResource;
use App\Models\MasterList;
use App\Models\Booking_process;
use PDF;
use COM;
use App\Traits\UserAgentTrait;
use Log;
use DOMDocument;
use App\Models\ProductInstruction;
use App\Models\ProjectGeneratedCount;
use App\Models\ProductReferenceImages;
use App\Models\SubscriptionLimits;

class ProjectsController extends Controller
{
	use UserAgentTrait;
	
	function __construct(User $user){
		/*if($user->remainingDays() == 0){
            $user->subscription()->detach();
            $user->subscription()->attach(['1']);
        }*/
	}

	function sendJsonData($data){
		return response()->json(['data' => $data]);
	}

	public function get_project_library(){
		
		if((Auth::user()->remainingDays() == 0) && (Auth::user()->isBasic() == true)){
			Auth::user()->subscription()->detach();
			Auth::user()->subscription()->attach(['1']);
        }

		$jsonArray = array();
		$jsonArray1 = array();
		$jsonArray2 = array();
		$jsonArray3 = array();
		$jsonArray4 = array();

		/*$products = DB::table('booking_process')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.id as order_id','booking_process.created_at','products.id','products.product_name')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive', 0)
		->get();*/
		
		$products = DB::table('orders')
		->leftJoin('booking_process', 'booking_process.order_id', 'orders.id')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.id as order_id','booking_process.created_at','products.id','products.product_name','products.is_custom')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive', 0)
		->where('booking_process.show_product', 1)
		->where('orders.order_status', 'Success')
		//->where('products.status', 1)
		->orderBy('orders.id','DESC')
		->get();
		
		$products_archive = DB::table('orders')
		->leftJoin('booking_process', 'booking_process.order_id', 'orders.id')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.id as order_id','booking_process.created_at','products.id','products.product_name','products.is_custom')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive', 1)
		->where('booking_process.show_product', 1)
		->where('orders.order_status', 'Success')
		->where('products.status', 1)
		->orderBy('id','desc')
		->count();

		for ($i=0; $i < count($products); $i++) {
			$jsonArray[$i]['order_id'] = $products[$i]->order_id;
			$jsonArray[$i]['id'] = $products[$i]->id;
			$jsonArray[$i]['product_name'] = $products[$i]->product_name;
			$jsonArray[$i]['pattern_type'] = ($products[$i]->is_custom == 1) ? 'custom' : 'non-custom';
			$jsonArray[$i]['created_at'] = Carbon::parse($products[$i]->created_at);
			$jsonArray[$i]['images'] = Product_images::where('product_id',$products[$i]->id)->select('image_medium')->first();
		}

		$data = array();

		$jsonArray1 = $this->get_generated_patterns();
		$jsonArray2 = $this->get_workinprogress_patterns();
		$jsonArray3 = $this->get_completed_patterns();
		
		$measurements = UserMeasurements::where('user_id',Auth::user()->id)->count();
		$projects = Auth::user()->projects()->where('is_archive',0)->where('is_deleted',0)->count();
		$projectLimit = SubscriptionLimits::where('subscription_type','Free')->where('subscription_property','Projects')->first();
		
		if(Auth::user()->isFree() == true){
			if($measurements == 0){
				$jsonArray4['measurements'] = true;
			}else{
				$jsonArray4['measurements'] = false;
			}
			
			if($projects >= $projectLimit->subscription_limit){
				$jsonArray4['projects'] = false;
			}else{
				$jsonArray4['projects'] = true;
			}
			
		}else{
			$jsonArray4['measurements'] = true;
			$jsonArray4['projects'] = true;
			
		}

		$array = array('new_patterns' => $jsonArray,'generated_patterns' => $jsonArray1,'work_in_progress' => $jsonArray2,'completed' => $jsonArray3,'projects_measurements' => [$jsonArray4],'archive_count' => $products_archive);
		return $this->sendJsonData($array);
	}

	function get_project_library_archive(){
			$jsonArray = array();
		$jsonArray1 = array();
		$jsonArray2 = array();
		$jsonArray3 = array();

		/*$products = DB::table('booking_process')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.id as order_id','booking_process.created_at','products.id','products.product_name')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive', 1)
		->get();*/
		$products = DB::table('orders')
		->leftJoin('booking_process', 'booking_process.order_id', 'orders.id')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.id as order_id','booking_process.created_at','products.id','products.product_name')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive', 1)
		->where('orders.order_status', 'Success')
		->where('products.status', 1)
		->get();

		for ($i=0; $i < count($products); $i++) {
			$jsonArray[$i]['order_id'] = $products[$i]->order_id;
			$jsonArray[$i]['id'] = $products[$i]->id;
			$jsonArray[$i]['product_name'] = $products[$i]->product_name;
			$jsonArray[$i]['created_at'] = Carbon::parse($products[$i]->created_at);
			$jsonArray[$i]['images'] = Product_images::where('product_id',$products[$i]->id)->select('image_medium')->first();
		}

		$data = array();

		$jsonArray1 = $this->get_generated_patterns_archive();
		$jsonArray2 = $this->get_workinprogress_patterns_archive();
		$jsonArray3 = $this->get_completed_patterns_archive();
		
		$measurements = UserMeasurements::where('user_id',Auth::user()->id)->count();
		$projects = Auth::user()->projects()->where('is_archive',0)->where('is_deleted',0)->count();
		
		if(Auth::user()->isFree() == true){
			if($measurements == 0){
				$jsonArray4['measurements'] = true;
			}else{
				$jsonArray4['measurements'] = false;
			}
			
			if($projects == 0){
				$jsonArray4['projects'] = true;
			}else{
				$jsonArray4['projects'] = false;
			}
			
		}else{
			$jsonArray4['measurements'] = true;
			$jsonArray4['projects'] = true;
			
		}

		$array = array('new_patterns' => $jsonArray,'generated_patterns' => $jsonArray1,'work_in_progress' => $jsonArray2,'completed' => $jsonArray3,'projects_measurements' => [$jsonArray4]);
		return $this->sendJsonData($array);
	}


	function get_generated_patterns(){
		$jsonArray = array();
		
		$firstProject = Project::where('user_id',Auth::user()->id)->where('is_archive',0)->where('is_deleted',0)->first();

$jsonA = Auth::user()->projects()->where('status',1)->where('is_archive',0)->where('is_deleted',0)->select('id','name','pattern_type','created_at','updated_at','measurement_profile','downloaded_offline','project_sync','downloaded_at')->orderBy('updated_at','DESC')->get();
//$jq = $jsonArray1['generated_patterns'];
for ($i=0; $i < count($jsonA); $i++){
	$id = $jsonA[$i]->id;
	$jsonArray[$i]['id'] = $jsonA[$i]->id;
	$jsonArray[$i]['name'] = $jsonA[$i]->name;
    $jsonArray[$i]['pattern_type'] = $jsonA[$i]->pattern_type;
    $measurement = UserMeasurements::where('id',$jsonA[$i]->measurement_profile)->select('m_title')->first();
    if($measurement){
        $jsonArray[$i]['measurement_profile'] = $measurement->m_title;
    }else{
        $jsonArray[$i]['measurement_profile'] = '';
    }

$jsonArray[$i]['downloaded'] = ($jsonA[$i]->downloaded_offline == 1) ? true : false;
    $jsonArray[$i]['project_sync'] = ($jsonA[$i]->project_sync == 1) ? 'sync' : 'notsync';
    $jsonArray[$i]['downloaded_at'] = ($jsonA[$i]->downloaded_at == '') ? NULL :
        Carbon::parse($jsonA[$i]->downloaded_at)->diffForHumans();
	$jsonArray[$i]['created_at'] = $jsonA[$i]->created_at;
	$jsonArray[$i]['updated_at'] = $jsonA[$i]->updated_at;
	$jsonArray[$i]['image'] = Projectimages::where('project_id',$id)->select('image_ext','image_path')->first();
	if(Auth::user()->remainingDays() == 0){
		if($firstProject->id == $jsonA[$i]->id){
			$jsonArray[$i]['show'] = true;
		}else{
			$jsonArray[$i]['show'] = false;
		}
	}else{
		$jsonArray[$i]['show'] = true;
	}
}

if(count($jsonA) > 0){
		return $jsonArray;
		}else{
		return $jsonArray;
		}
		//return response()->json(['generated_patterns' => [$jsonArray]]);
	}

	function get_workinprogress_patterns(){
		$jsonArray = array();
		
		$firstProject = Project::where('user_id',Auth::user()->id)->where('is_archive',0)->where('is_deleted',0)->first();

		$winp = Auth::user()->projects()->where('status',2)->where('is_archive',0)->where('is_deleted',0)->select('id','product_id','name','pattern_type','created_at','updated_at','measurement_profile','downloaded_offline','project_sync','downloaded_at')->orderBy('updated_at','DESC')->get();

for ($j=0; $j < count($winp); $j++){
	$id = $winp[$j]->id;
	$jsonArray[$j]['id'] = $winp[$j]->id;
	$jsonArray[$j]['product_id'] = $winp[$j]->product_id;
	$jsonArray[$j]['name'] = $winp[$j]->name;
    $jsonArray[$j]['pattern_type'] = $winp[$j]->pattern_type;
    $measurement = UserMeasurements::where('id',$winp[$j]->measurement_profile)->select('m_title')->first();
    if($measurement){
        $jsonArray[$j]['measurement_profile'] = $measurement->m_title;
    }else{
        $jsonArray[$j]['measurement_profile'] = '';
    }
	$jsonArray[$j]['downloaded'] = ($winp[$j]->downloaded_offline == 1) ? true : false;
    $jsonArray[$j]['project_sync'] = ($winp[$j]->project_sync == 1) ? 'sync' : 'notsync';
    $jsonArray[$j]['downloaded_at'] = ($winp[$j]->downloaded_at == '') ? NULL :
        Carbon::parse($winp[$j]->downloaded_at)->diffForHumans();
	$jsonArray[$j]['created_at'] = $winp[$j]->created_at;
	$jsonArray[$j]['updated_at'] = $winp[$j]->updated_at;
	$jsonArray[$j]['image'] = Projectimages::where('project_id',$id)->select('image_ext','image_path')->first();
	$getProjects = DB::table('projects')->where('user_id',Auth::user()->id)->where('is_archive',0)->where('is_deleted',0)->orderBy('updated_at','ASC')->select('id','name','updated_at')->take(5)->get();
	$parray = array();
	
	if(Auth::user()->remainingDays() == 0){
		if($getProjects->count() > 0){
			foreach($getProjects as $gp){
				array_push($parray,$gp->id);
			}
		}else{
			$parray = array();
		}
		
		if(in_array($winp[$j]->id,$parray)){
			$jsonArray[$j]['show'] = true;
		}else{
			$jsonArray[$j]['show'] = false;
		}
	}else{
		$jsonArray[$j]['show'] = true;
	}
}

if(count($winp) > 0){
		return $jsonArray;
		}else{
		return $jsonArray;
		}
		//return response()->json(['work_in_progress' => [$jsonArray]]);

	}

	function get_completed_patterns(){
		$jsonArray = array();
		
		$firstProject = Project::where('user_id',Auth::user()->id)->where('is_archive',0)->where('is_deleted',0)->first();

		$comp = Auth::user()->projects()->where('status',3)->where('is_archive',0)->where('is_deleted',0)->select('id','product_id','name','pattern_type','created_at','updated_at','downloaded_offline','project_sync','downloaded_at')->orderBy('updated_at','DESC')->get();

		for ($k=0; $k < count($comp); $k++){
			$id = $comp[$k]->id;
			$jsonArray[$k]['id'] = $comp[$k]->id;
			$jsonArray[$k]['product_id'] = $comp[$k]->product_id;
			$jsonArray[$k]['name'] = $comp[$k]->name;
            $jsonArray[$k]['pattern_type'] = $comp[$k]->pattern_type;
            $measurement = UserMeasurements::where('id',$comp[$k]->measurement_profile)->select('m_title')->first();
    if($measurement){
        $jsonArray[$k]['measurement_profile'] = $measurement->m_title;
    }else{
        $jsonArray[$k]['measurement_profile'] = '';
    }
	$jsonArray[$k]['downloaded'] = ($comp[$k]->downloaded_offline == 1) ? true : false;
            $jsonArray[$k]['project_sync'] = ($comp[$k]->project_sync == 1) ? 'sync' : 'notsync';
            $jsonArray[$k]['downloaded_at'] = ($comp[$k]->downloaded_at == '') ? NULL :
                Carbon::parse($comp[$k]->downloaded_at)->diffForHumans();
			$jsonArray[$k]['created_at'] = $comp[$k]->created_at;
			$jsonArray[$k]['updated_at'] = $comp[$k]->updated_at;
			$jsonArray[$k]['image'] = Projectimages::where('project_id',$id)->select('image_ext','image_path')->first();
			if(Auth::user()->remainingDays() == 0){
				if($firstProject->id == $comp[$k]->id){
					$jsonArray[$k]['show'] = true;
				}else{
					$jsonArray[$k]['show'] = false;
				}
			}else{
				$jsonArray[$k]['show'] = true;
			}
		}
		if(count($comp) > 0){
		return $jsonArray;
		}else{
		return $jsonArray;
		}
	}

	function move_to_generated(Request $request){
		$jsonArray = array();

		$project = Project::find($request->id);
		$project->status = 1;
		$project->updated_at = Carbon::now();
		$save = $project->save();

		if($save){
			$gp = Auth::user()->projects()->where('status',1)->where('is_archive',0)->where('is_deleted',0)->where('id',$request->id)->select('id','name','pattern_type','created_at','updated_at','measurement_profile')->get();
		for ($i=0; $i < count($gp); $i++){
	$id = $gp[$i]->id;
	$jsonArray['id'] = $gp[$i]->id;
	$jsonArray['name'] = $gp[$i]->name;
    $jsonArray['pattern_type'] = $gp[$i]->pattern_type;
    $measurement = UserMeasurements::where('id',$gp[$i]->measurement_profile)->select('m_title')->first();
    if($measurement){
        $jsonArray[$i]['measurement_profile'] = $measurement->m_title;
    }else{
        $jsonArray[$i]['measurement_profile'] = '';
    }
	$jsonArray['created_at'] = $gp[$i]->created_at;
	$jsonArray['updated_at'] = $gp[$i]->updated_at;
	$jsonArray['image'] = Projectimages::where('project_id',$id)->select('image_ext','image_path')->first();
}
$array = array('generated_patterns' => [$jsonArray]);
return $this->sendJsonData($array);
			//return response()->json(['data' => $jsonArray]);
		}else{
			return response()->json(['error' => true,'message' => 'unable to load data']);
		}
	}

	function move_to_workinprogress(Request $request){
		$jsonArray = array();

		$project = Project::find($request->id);
		$project->status = 2;
		$project->project_sync = 0;
		$project->updated_at = Carbon::now();
		$save = $project->save();



		if($save){
			$winp = Auth::user()->projects()->where('status',2)->where('is_archive',0)->where('is_deleted',0)->where('id',$request->id)->select('id','name','pattern_type','created_at','updated_at','measurement_profile')->get();
		for ($j=0; $j < count($winp); $j++){
	$id = $winp[$j]->id;
	$jsonArray['id'] = $winp[$j]->id;
	$jsonArray['name'] = $winp[$j]->name;
    $jsonArray['pattern_type'] = $winp[$j]->pattern_type;
    $measurement = UserMeasurements::where('id',$winp[$j]->measurement_profile)->select('m_title')->first();
    if($measurement){
        $jsonArray[$j]['measurement_profile'] = $measurement->m_title;
    }else{
        $jsonArray[$j]['measurement_profile'] = '';
    }
	$jsonArray['created_at'] = $winp[$j]->created_at;
	$jsonArray['updated_at'] = $winp[$j]->updated_at;
	$jsonArray['image'] = Projectimages::where('project_id',$id)->select('image_ext','image_path')->first();
}
			//return response()->json(['data' => [$jsonArray]]);
			$array = array('work_in_progress' => [$jsonArray]);
			return $this->sendJsonData($array);
		}else{
			return response()->json(['error' => true,'message' => 'unable to load data']);
		}
	}

	function move_to_completed(Request $request){
		$jsonArray = array();

		$project = Project::find($request->id);
		$project->status = 3;
		$project->updated_at = Carbon::now();
		$save = $project->save();

		if($save){
			$com = Auth::user()->projects()->where('status',3)->where('is_archive',0)->where('is_deleted',0)->where('id',$request->id)->select('id','name','pattern_type','created_at','updated_at')->get();
		for ($k=0; $k < count($com); $k++){
			$id = $com[$k]->id;
			$jsonArray['id'] = $com[$k]->id;
			$jsonArray['name'] = $com[$k]->name;
            $jsonArray['pattern_type'] = $com[$k]->pattern_type;
            $measurement = UserMeasurements::where('id',$com[$k]->measurement_profile)->select('m_title')->first();
    if($measurement){
        $jsonArray[$k]['measurement_profile'] = $measurement->m_title;
    }else{
        $jsonArray[$k]['measurement_profile'] = '';
    }
			$jsonArray['created_at'] = $com[$k]->created_at;
			$jsonArray['updated_at'] = $com[$k]->updated_at;
			$jsonArray['image'] = Projectimages::where('project_id',$id)->select('image_ext','image_path')->first();
		}
			$array = array('completed' => [$jsonArray]);
			return $this->sendJsonData($array);
		}else{
			return response()->json(['error' => true,'message' => 'unable to load data']);
		}
	}


	function move_to_archive(Request $request){
		$project = Project::find($request->id);
		$project->is_archive = 1;
		$project->updated_at = Carbon::now();
		$save = $project->save();
		if($save){
			return response()->json(['success' => true]);
		}else{
			return response()->json(['error' => true,'message' => 'unable to load data']);
		}
	}

	function move_to_project_library(Request $request){
		$project = Project::find($request->id);
		$project->is_archive = 0;
		$project->updated_at = Carbon::now();
		$save = $project->save();
		if($save){
			return response()->json(['success' => true]);
		}else{
			return response()->json(['error' => true,'message' => 'unable to load data']);
		}
	}
	
	function order_to_archive(Request $request){
		
        $id = $request->order_id;
        $order = Booking_process::find($id);
        $order->is_archive = 1;
        $save = $order->save();
        if($save){
			return response()->json(['success' => true]);
		}else{
			return response()->json(['error' => true,'message' => 'unable to load data']);
		}
    }

    function order_to_library(Request $request){
		
        $id = $request->order_id;
        $order = Booking_process::find($id);
        $order->is_archive = 0;
        $save = $order->save();
        if($save){
			return response()->json(['success' => true]);
		}else{
			return response()->json(['error' => true,'message' => 'unable to load data']);
		}
    }


	function get_generated_patterns_archive(){
		$jsonArray = array();
		$firstProject = Project::where('user_id',Auth::user()->id)->where('is_archive',1)->where('is_deleted',0)->first();
$jsonA = Auth::user()->projects()->where('status',1)->where('is_archive',1)->where('is_deleted',0)->select('id','name','pattern_type','created_at','updated_at','measurement_profile')->get();
//$jq = $jsonArray1['generated_patterns'];
for ($i=0; $i < count($jsonA); $i++){
	$id = $jsonA[$i]->id;
	$jsonArray[$i]['id'] = $jsonA[$i]->id;
	$jsonArray[$i]['name'] = $jsonA[$i]->name;
    $jsonArray[$i]['pattern_type'] = $jsonA[$i]->pattern_type;
    $measurement = UserMeasurements::where('id',$jsonA[$i]->measurement_profile)->select('m_title')->first();
    if($measurement){
        $jsonArray[$i]['measurement_profile'] = $measurement->m_title;
    }else{
        $jsonArray[$i]['measurement_profile'] = '';
    }
	$jsonArray[$i]['created_at'] = $jsonA[$i]->created_at;
	$jsonArray[$i]['updated_at'] = $jsonA[$i]->updated_at;
	$jsonArray[$i]['image'] = Projectimages::where('project_id',$id)->select('image_ext','image_path')->first();
	
	if(Auth::user()->remainingDays() == 0){
		if($firstProject->id == $jsonA[$i]->id){
			$jsonArray[$i]['show'] = true;
		}else{
			$jsonArray[$i]['show'] = false;
		}
	}else{
		$jsonArray[$i]['show'] = true;
	}
}

if(count($jsonA) > 0){
		return $jsonArray;
		}else{
		return $jsonArray;
		}
		//return response()->json(['generated_patterns' => [$jsonArray]]);
	}

	function get_workinprogress_patterns_archive(){
		$jsonArray = array();
		$firstProject = Project::where('user_id',Auth::user()->id)->where('is_archive',1)->where('is_deleted',0)->first();
		$winp = Auth::user()->projects()->where('status',2)->where('is_archive',1)->where('is_deleted',0)->select('id','name','pattern_type','created_at','updated_at','measurement_profile')->get();

for ($j=0; $j < count($winp); $j++){
	$id = $winp[$j]->id;
	$jsonArray[$j]['id'] = $winp[$j]->id;
	$jsonArray[$j]['name'] = $winp[$j]->name;
    $jsonArray[$j]['pattern_type'] = $winp[$j]->pattern_type;
    $measurement = UserMeasurements::where('id',$winp[$j]->measurement_profile)->select('m_title')->first();
    if($measurement){
        $jsonArray[$j]['measurement_profile'] = $measurement->m_title;
    }else{
        $jsonArray[$j]['measurement_profile'] = '';
    }
	$jsonArray[$j]['created_at'] = $winp[$j]->created_at;
	$jsonArray[$j]['updated_at'] = $winp[$j]->updated_at;
	$jsonArray[$j]['image'] = Projectimages::where('project_id',$id)->select('image_ext','image_path')->first();
	
	if(Auth::user()->remainingDays() == 0){
		if($firstProject->id == $winp[$j]->id){
			$jsonArray[$j]['show'] = true;
		}else{
			$jsonArray[$j]['show'] = false;
		}
	}else{
		$jsonArray[$j]['show'] = true;
	}
}

if(count($winp) > 0){
		return $jsonArray;
		}else{
		return $jsonArray;
		}
		//return response()->json(['work_in_progress' => [$jsonArray]]);

	}

	function get_completed_patterns_archive(){
		$jsonArray = array();
		
		$firstProject = Project::where('user_id',Auth::user()->id)->where('is_archive',1)->where('is_deleted',0)->first();
		$comp = Auth::user()->projects()->where('status',3)->where('is_archive',1)->where('is_deleted',0)->select('id','name','pattern_type','created_at','updated_at','measurement_profile')->get();

		for ($k=0; $k < count($comp); $k++){
			$id = $comp[$k]->id;
			$jsonArray[$k]['id'] = $comp[$k]->id;
			$jsonArray[$k]['name'] = $comp[$k]->name;
            $jsonArray[$k]['pattern_type'] = $comp[$k]->pattern_type;
            $measurement = UserMeasurements::where('id',$comp[$k]->measurement_profile)->select('m_title')->first();
    if($measurement){
        $jsonArray[$k]['measurement_profile'] = $measurement->m_title;
    }else{
        $jsonArray[$k]['measurement_profile'] = '';
    }
			$jsonArray[$k]['created_at'] = $comp[$k]->created_at;
			$jsonArray[$k]['updated_at'] = $comp[$k]->updated_at;
			$jsonArray[$k]['image'] = Projectimages::where('project_id',$id)->select('image_ext','image_path')->first();
			
			if(Auth::user()->remainingDays() == 0){
				if($firstProject->id == $comp[$k]->id){
					$jsonArray[$k]['show'] = true;
				}else{
					$jsonArray[$k]['show'] = false;
				}
			}else{
				$jsonArray[$k]['show'] = true;
			}
	
		}
		if(count($comp) > 0){
		return $jsonArray;
		}else{
		return $jsonArray;
		}
	}

	function project_delete(Request $request){
		$id = $request->id;
		$project = Project::where('id',$id)->where('user_id',Auth::user()->id)->count();
		if($project == 0){
			return response()->json(['error' => true,'message' => 'Unable to access this project']);
		}else{
			$project = Project::find($id);
			$project->is_deleted = 1;
			$save = $project->save();
			if($save){
				if($project->pattern_type != 'external'){
					$bp= array('show_product' => 1);
					Booking_process::where('product_id',$project->product_id)->update($bp);
				}
				return response()->json(['success' => true]);
			}else{
				return response()->json(['error' => true,'message' => 'unable to delete project']);
			}
		}
	}


	/* create custom project */

	function available_products(Request $request){
		$jsonArray = array();
		$projects = Project::where('user_id',Auth::user()->id)->where('is_deleted',0)->count();
		if(($projects > 0) && (Auth::user()->remainingDays() == 0)){
			$jsonArray = array('error' => 'Your subscription is ended.');
			return response()->json(['data' => $jsonArray]);
			exit;
		}
		
		
		if($request->type == 'custom'){
			$type = 1;
		}else{
			$type = 0;
		}

		$products = DB::table('booking_process')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.created_at','products.id','products.product_name')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('products.is_custom',$type)
		->where('products.status', 1)
		->get();

		if($products){
		for ($i=0; $i < count($products); $i++) {
			$jsonArray[$i]['id'] = $products[$i]->id;
			$jsonArray[$i]['product_name'] = $products[$i]->product_name;
		}
		}else{
			$jsonArray = array();
		}
		return $this->sendJsonData(['products' => $jsonArray]);

	}

	function get_products_data(Request $request){
		$jsonArray = array();
		$jsonArray1 = array();
		$jsonArray2 = array();
		$jsonArray3 = array();
		$jsonArray4 = array();
		$jsonArray4 = array();
		$uom = $request->get('uom');

		$id = $request->id;
		$products = Products::where('id',$id)->where('status',1)->take(1)->get();
		$needlesizes = NeedleSizes::all();
        $gaugeconversion = GaugeConversion::all();
        $measurements = Auth::user()->measurements;
        $images = Product_images::where('product_id',$id)->select('image_small')->take(1)->get();
        $yarn_weight = MasterList::where('type','yarn_weight')->select('name')->get();
        $product_measurements = ProductDesignerMeasurements::where('product_id',$id)->select('measurement_name','measurement_description','measurement_image','min_value_inches','max_value_inches','min_value_cm','max_value_cm')->get();

		for ($i=0; $i < count($products); $i++) {
			$jsonArray[$i]['id'] = $products[$i]->id;
			$jsonArray[$i]['product_name'] = $products[$i]->product_name;
			$jsonArray[$i]['product_description'] = $products[$i]->product_description;
			$jsonArray[$i]['additional_information'] = $products[$i]->additional_information;
			$jsonArray[$i]['skill_level'] = $products[$i]->skill_level;
			$jsonArray[$i]['recommended_yarn'] = $products[$i]->recommended_yarn;
			$jsonArray[$i]['recommended_fiber_type'] = $products[$i]->recommended_fiber_type;
			$jsonArray[$i]['recommended_yarn_weight'] = $products[$i]->recommended_yarn_weight;
			$jsonArray[$i]['recommended_needle_size'] = $products[$i]->recommended_needle_size;
			$jsonArray[$i]['additional_tools'] = $products[$i]->additional_tools;
			$jsonArray[$i]['designer_recommended_uom'] = $products[$i]->designer_recommended_uom;
			$jsonArray[$i]['designer_recommended_ease_in'] = $products[$i]->designer_recommended_ease_in;
			$jsonArray[$i]['designer_recommended_ease_cm'] = $products[$i]->designer_recommended_ease_cm;
			$jsonArray[$i]['recommended_stitch_gauge_in'] = $products[$i]->recommended_stitch_gauge_in;
			$jsonArray[$i]['recommended_stitch_gauge_cm'] = $products[$i]->recommended_stitch_gauge_cm;
			$jsonArray[$i]['recommended_row_gauge_in'] = $products[$i]->recommended_row_gauge_in;
			$jsonArray[$i]['recommended_row_gauge_cm'] = $products[$i]->recommended_row_gauge_cm;
			$jsonArray[$i]['shaped_unshaped'] = ($products[$i]->shaped_unshaped == 1) ? true : false;
			$jsonArray[$i]['is_custom'] = ($products[$i]->is_custom == 1) ? true : false;
            $jsonArray[$i]['images'] = $images;
            for ($j=0; $j < count($product_measurements); $j++) { 
            	$jsonArray[$i]['pattern_specific_measurements'][$j]['measurement_title'] = str_replace('_',' ',ucfirst($product_measurements[$j]->measurement_name));
            	$jsonArray[$i]['pattern_specific_measurements'][$j]['measurement_name'] = $product_measurements[$j]->measurement_name;
            	$jsonArray[$i]['pattern_specific_measurements'][$j]['measurement_description'] = $product_measurements[$j]->measurement_description;
            	$jsonArray[$i]['pattern_specific_measurements'][$j]['measurement_image'] = $product_measurements[$j]->measurement_image;
				if($uom == 'inches'){
					$jsonArray[$i]['pattern_specific_measurements'][$j]['min_value_inches'] = $product_measurements[$j]->min_value_inches;
					$jsonArray[$i]['pattern_specific_measurements'][$j]['max_value_inches'] = $product_measurements[$j]->max_value_inches;
				}else if($uom == 'cm'){
					$jsonArray[$i]['pattern_specific_measurements'][$j]['min_value_cm'] = $product_measurements[$j]->min_value_cm;
					$jsonArray[$i]['pattern_specific_measurements'][$j]['max_value_cm'] = $product_measurements[$j]->max_value_cm;
				}else{
            	$jsonArray[$i]['pattern_specific_measurements'][$j]['min_value_inches'] = $product_measurements[$j]->min_value_inches;
            	$jsonArray[$i]['pattern_specific_measurements'][$j]['max_value_inches'] = $product_measurements[$j]->max_value_inches;
            	$jsonArray[$i]['pattern_specific_measurements'][$j]['min_value_cm'] = $product_measurements[$j]->min_value_cm;
            	$jsonArray[$i]['pattern_specific_measurements'][$j]['max_value_cm'] = $product_measurements[$j]->max_value_cm;
				}
            }
		}

		for ($j=0; $j < count($measurements); $j++) {
			$jsonArray1[$j]['id'] = $measurements[$j]->id;
			$jsonArray1[$j]['m_title'] = $measurements[$j]->m_title;
			$jsonArray1[$j]['uom'] = ($measurements[$j]->measurement_preference == 'inches') ? 'in' : 'cm';
		}

		for ($k=0; $k < count($needlesizes); $k++) {
			$jsonArray2[$k]['us_size'] = $needlesizes[$k]->us_size;
			$jsonArray2[$k]['mm_size'] = $needlesizes[$k]->mm_size;
		}

		for ($l=0; $l < count($gaugeconversion); $l++) {
			$jsonArray3[$l]['id'] = $needlesizes[$l]->id;
			$jsonArray3[$l]['stitch_gauge_inch'] = $needlesizes[$l]->stitch_gauge_inch;
			$jsonArray3[$l]['stitches_10_cm'] = $needlesizes[$l]->stitches_10_cm;
			$jsonArray3[$l]['row_gauge_inch'] = $needlesizes[$l]->row_gauge_inch;
			$jsonArray3[$l]['rows_10_cm'] = $needlesizes[$l]->rows_10_cm;
		}
		
		for ($m=-2; $m <= 20; $m+= 0.25) {
			$jsonArray4[]['value'] = $m;
		}
		for ($n=-5; $n <= 20; $n+= 0.5) {
			$jsonArray5[]['value'] = $n;
		}
		/*if($uom == 'in' || $uom == 'inches'){
			for ($m=-2; $m <= 20; $m+= 0.25) {
				$jsonArray4[]['value_in'] = $m;
			}
		}else if($uom == 'cm' || $uom == 'centimeters'){
			for ($m=-5; $m <= 20; $m+= 0.5) {
				$jsonArray4[]['value_cm'] = $m;
			}
		}else{
			for ($m=-2; $m <= 20; $m+= 0.25) {
				$jsonArray4[]['value_in'] = $m;
			}
		}*/

		return $this->sendJsonData(['products' => $jsonArray,'measurements' => $jsonArray1,'needlesizes' => $jsonArray2,'gaugeconversion' => $gaugeconversion,'yarn_weight' => $yarn_weight,'ease_in' => $jsonArray4,'ease_cm' => $jsonArray5]);
	}

	function get_external_data(Request $request){
		$jsonArray1 = array();
		$jsonArray2 = array();
		$jsonArray3 = array();
		$jsonArray4 = array();
		$jsonArray5 = array();
		$uom = $request->uom;
		
		

		$needlesizes = NeedleSizes::all();
        $gaugeconversion = GaugeConversion::all();
        $measurements = Auth::user()->measurements;
		$yarn_weight = MasterList::where('type','yarn_weight')->select('name')->get();

        for ($j=0; $j < count($measurements); $j++) {
			$jsonArray1[$j]['id'] = $measurements[$j]->id;
			$jsonArray1[$j]['m_title'] = $measurements[$j]->m_title;
			$jsonArray1[$j]['uom'] = ($measurements[$j]->measurement_preference == 'inches') ? 'in' : 'cm';
		}

		for ($k=0; $k < count($needlesizes); $k++) {
			$jsonArray2[$k]['us_size'] = $needlesizes[$k]->us_size;
			$jsonArray2[$k]['mm_size'] = $needlesizes[$k]->mm_size;
		}

		for ($l=0; $l < count($gaugeconversion); $l++) {
			$jsonArray3[$l]['id'] = $needlesizes[$l]->id;
			$jsonArray3[$l]['stitch_gauge_inch'] = $needlesizes[$l]->stitch_gauge_inch;
			$jsonArray3[$l]['stitches_10_cm'] = $needlesizes[$l]->stitches_10_cm;
			$jsonArray3[$l]['row_gauge_inch'] = $needlesizes[$l]->row_gauge_inch;
			$jsonArray3[$l]['rows_10_cm'] = $needlesizes[$l]->rows_10_cm;
		}
		
		
			for ($m=-2; $m <= 20; $m+= 0.25) {
				$jsonArray4[]['value'] = $m;
			}
		
			for ($n=-5; $n <= 20; $n+= 0.5) {
				$jsonArray5[]['value'] = $n;
			}

		return $this->sendJsonData(['measurements' => $jsonArray1,'needlesizes' => $jsonArray2,'gaugeconversion' => $gaugeconversion,'yarn_weight' => $yarn_weight,'ease_in' => $jsonArray4,'ease_cm' => $jsonArray5]);
	}

	function create_custom_project(Request $request){
		//return response()->json(['data' => $request->all()]);
		//exit;
		
		$validate_array = [
			'product_id' => 'required',
			'pattern_type' => 'required',
			'uom' => 'required',
			'stitch_gauge' => 'required',
			'row_gauge' => 'required',
			'measurement_profile' => 'required',
			'ease' => 'required',
			
		];
		 foreach($request->get('m_name') as $name){
			 $validate_array[$name] = 'required';
		 }
		 
		$this->validate($request, $validate_array );
		
		$projectsCount = Project::count() +1;

		$product = Products::where('id',$request->product_id)->first();
		$product_images = Product_images::where('product_id',$request->product_id)->first();
		if($product_images){
			$image = $product_images->image_small;
		}else{
			$image = 'https://via.placeholder.com/200?text='.$product->product_name;
		}

		$project = new Project;
		$project->token_key = md5($projectsCount);
		$project->user_id = Auth::user()->id;
		$project->product_id = $request->product_id;
		$project->name = $product->product_name;
		$project->description = $product->product_description;
		$project->pattern_type = 'custom';
		$project->uom = $request->uom;
		$project->stitch_gauge = $request->stitch_gauge;
		$project->row_gauge = $request->row_gauge;
		$project->measurement_profile = $request->measurement_profile;
		$project->ease = $request->ease;
		$project->product_shaped = $request->product_shaped;
		$project->status = 2;
		$project->created_at = Carbon::now();
		$project->ipaddress = $_SERVER['REMOTE_ADDR'];
		$save = $project->save();

		if($save){
			$bp= array('show_product' => 0);
			Booking_process::where('product_id',$project->product_id)->update($bp);

            if($request->yarn_used){
				for ($i=0; $i < count($request->yarn_used); $i++) {
					$yarn = new Projectyarn;
					$yarn->user_id = Auth::user()->id;
					$yarn->project_id = $project->id;
					$yarn->yarn_used = $request->yarn_used[$i];
					$yarn->fiber_type = $request->fiber_type[$i];
					$yarn->yarn_weight = $request->yarn_weight[$i];
					$yarn->colourway = $request->colourway[$i];
					$yarn->dye_lot = $request->dye_lot[$i];
					$yarn->skeins = $request->skeins[$i];
					$yarn->created_at = Carbon::now();
					$yarn->ipaddress = $_SERVER['REMOTE_ADDR'];
					$yarn->save();
				}
            }

            if($request->needle_size){
			for ($j=0; $j < count($request->needle_size); $j++) {
				$needle = new Projectneedle;
				$needle->user_id = Auth::user()->id;
				$needle->project_id = $project->id;
				$needle->needle_size = $request->needle_size[$j];
				$needle->created_at = Carbon::now();
				$needle->ipaddress = $_SERVER['REMOTE_ADDR'];
				$needle->save();
            }
            }


			$projectimage =  new Projectimages;
			$projectimage->user_id = Auth::user()->id;
			$projectimage->project_id = $project->id;
			$projectimage->image_path = $image;
			$projectimage->created_at = Carbon::now();
			$projectimage->ipaddress = $_SERVER['REMOTE_ADDR'];
			$projectimage->save();

            if($request->m_name){
			for ($l=0; $l < count($request->m_name); $l++) {
                $mname = $request->m_name[$l];
                $pdm = new ProjectsDesignerMeasurements;
                $pdm->user_id = Auth::user()->id;
                $pdm->project_id = $project->id;
                $pdm->measurement_name = $request->m_name[$l];
                $pdm->measurement_value = $request->$mname;
                $pdm->created_at = Carbon::now();
                $pdm->ipaddress = $_SERVER['REMOTE_ADDR'];
                $pdm->save();
            }
            }
            return response()->json(['status' => 'success','project_id' => $project->id]);
		}else{
			return response()->json(['status' => 'fail']);
		}
	}


	function create_non_custom_project(Request $request){
		$projectsCount = Project::count() +1;

		$product = Products::where('id',$request->product_id)->first();
		$product_images = Product_images::where('product_id',$request->product_id)->first();
		if($product_images){
			$image = $product_images->image_small;
		}else{
			$image = 'https://via.placeholder.com/200?text='.$product->product_name;
		}

		$project = new Project;
		$project->token_key = md5($projectsCount);
		$project->user_id = Auth::user()->id;
		$project->product_id = $request->product_id;
		$project->name = $product->product_name;
		$project->description = $product->product_description;
		$project->pattern_type = 'non-custom';
		$project->uom = $request->uom;
		$project->stitch_gauge = $request->stitch_gauge;
		$project->row_gauge = $request->row_gauge;
		$project->measurement_profile = $request->measurement_profile;
		$project->ease = $request->ease;
		$project->status = 2;
		$project->created_at = Carbon::now();
		$project->ipaddress = $_SERVER['REMOTE_ADDR'];
		$save = $project->save();

		if($save){
			$bp= array('show_product' => 0);
			Booking_process::where('product_id',$project->product_id)->update($bp);

            if($request->yarn_used){
			for ($i=0; $i < count($request->yarn_used); $i++) {
				$yarn = new Projectyarn;
				$yarn->user_id = Auth::user()->id;
				$yarn->project_id = $project->id;
				$yarn->yarn_used = $request->yarn_used[$i];
				$yarn->fiber_type = $request->fiber_type[$i];
				$yarn->yarn_weight = $request->yarn_weight[$i];
				$yarn->colourway = $request->colourway[$i];
				$yarn->dye_lot = $request->dye_lot[$i];
				$yarn->skeins = $request->skeins[$i];
				$yarn->created_at = Carbon::now();
				$yarn->ipaddress = $_SERVER['REMOTE_ADDR'];
				$yarn->save();
            }
            }

            if($request->needle_size){
			for ($j=0; $j < count($request->needle_size); $j++) {
				$needle = new Projectneedle;
				$needle->user_id = Auth::user()->id;
				$needle->project_id = $project->id;
				$needle->needle_size = $request->needle_size[$j];
				$needle->created_at = Carbon::now();
				$needle->ipaddress = $_SERVER['REMOTE_ADDR'];
				$needle->save();
            }
            }

			$projectimage =  new Projectimages;
			$projectimage->user_id = Auth::user()->id;
			$projectimage->project_id = $project->id;
			$projectimage->image_path = $image;
			$projectimage->created_at = Carbon::now();
			$projectimage->ipaddress = $_SERVER['REMOTE_ADDR'];
			$projectimage->save();

            return response()->json(['status' => 'success','project_id' => $project->id]);
		}else{
			return response()->json(['status' => 'fail']);
		}
	}


	function create_external_project(Request $request){

		$request->validate([
			'product_name' => 'required',
			'description'  => 'required',
			'user_verify'  => 'required'
		]);

		$projectsCount = Project::count() +1;


		$project = new Project;
		$project->token_key = md5($projectsCount);
		$project->user_id = Auth::user()->id;
		$project->name = $request->product_name;
		$project->description = $request->description;
		$project->pattern_type = 'external';
		$project->uom = $request->uom;
		$project->stitch_gauge = $request->stitch_gauge;
		$project->row_gauge = $request->row_gauge;
		$project->measurement_profile = $request->measurement_profile;
		$project->ease = $request->ease;
		$project->user_verify = $request->user_verify;
		$project->status = 2;
		$project->created_at = Carbon::now();
		$project->ipaddress = $_SERVER['REMOTE_ADDR'];
		$save = $project->save();

		if($save){
			
			if($request->external_image) {
				$pi = new Projectimages;
				$pi->user_id = Auth::user()->id;
				$pi->project_id = $project->id;
				$pi->image_path = $request->external_image;
				$pi->image_ext = 'jpg';
				$pi->created_at = Carbon::now();
				$pi->ipaddress = $_SERVER['REMOTE_ADDR'];
				$pi->save();
            }

            if($request->yarn_used){
			for ($i=0; $i < count($request->yarn_used); $i++) {
				$yarn = new Projectyarn;
				$yarn->user_id = Auth::user()->id;
				$yarn->project_id = $project->id;
				$yarn->yarn_used = $request->yarn_used[$i];
				$yarn->fiber_type = $request->fiber_type[$i];
				$yarn->yarn_weight = $request->yarn_weight[$i];
				$yarn->colourway = $request->colourway[$i];
				$yarn->dye_lot = $request->dye_lot[$i];
				$yarn->skeins = $request->skeins[$i];
				$yarn->created_at = Carbon::now();
				$yarn->ipaddress = $_SERVER['REMOTE_ADDR'];
				$yarn->save();
            }
            }

            if($request->needle_size){
			for ($j=0; $j < count($request->needle_size); $j++) {
				$needle = new Projectneedle;
				$needle->user_id = Auth::user()->id;
				$needle->project_id = $project->id;
				$needle->needle_size = $request->needle_size[$j];
				$needle->created_at = Carbon::now();
				$needle->ipaddress = $_SERVER['REMOTE_ADDR'];
				$needle->save();
            }
            }

            if($request->image){
			for ($k=0; $k < count($request->image); $k++) {
				$projectimage =  new Projectimages;
				$projectimage->user_id = Auth::user()->id;
				$projectimage->project_id = $project->id;
				$projectimage->image_path = $request->image[$k];
				$projectimage->image_ext = $request->ext[$k];
				$projectimage->created_at = Carbon::now();
				$projectimage->ipaddress = $_SERVER['REMOTE_ADDR'];
				$projectimage->save();
            }
            }

            return response()->json(['status' => 'success','project_id' => $project->id]);
		}else{
			return response()->json(['status' => 'fail']);
		}
    }

    function generate_external_pattern(Request $request){
        $id = $request->id;
        $check = Project::where('id',$id)->first();
        if($check->pattern_type != 'external'){
            return response()->json(['success' => false,'message' => 'The product selected is not external product.']);
            exit;
        }
        $jsonArray = array();
        $project = Project::where('id',$id)->get();
        for ($i=0; $i < count($project); $i++) {
            $jsonArray[$i]['id'] = $project[$i]->id;
            $jsonArray[$i]['name'] = $project[$i]->name;
            $jsonArray[$i]['description'] = $project[$i]->description;
            $jsonArray[$i]['pattern_type'] = $project[$i]->pattern_type;
            $jsonArray[$i]['uom'] = ($project[$i]->uom == 'in' || $project[$i]->uom == 'inches') ? 'Inches' : 'Centimeters';
            if($project[$i]->uom == 'in'){
				
                $sgauge = GaugeConversion::where('id',$project[$i]->stitch_gauge)->select('stitch_gauge_inch as stitch_gauge')->first();
				$rgauge = GaugeConversion::where('id',$project[$i]->row_gauge)->select('row_gauge_inch as row_gauge')->first();
				
				$jsonArray[$i]['gauge'] = [array('stitch_gauge' => $sgauge ? $sgauge->stitch_gauge : 0,'row_gauge' => $rgauge ? $rgauge->row_gauge : 0)];

            }else{
                $sgauge = GaugeConversion::where('id',$project[$i]->stitch_gauge)->select('stitches_10_cm as stitch_gauge')->first();
				$rgauge = GaugeConversion::where('id',$project[$i]->row_gauge)->select('rows_10_cm as row_gauge')->first();
				
				$jsonArray[$i]['gauge'] = [array('stitch_gauge' => $sgauge ? $sgauge->stitch_gauge : 0,'row_gauge' => $rgauge ? $rgauge->row_gauge : 0)];
            }

            $jsonArray[$i]['measurement_profile'] = UserMeasurements::where('id',$project[$i]->measurement_profile)->select('m_title')->take(1)->get();
            $jsonArray[$i]['yarn_details'] = Projectyarn::where('project_id',$project[$i]->id)->select('yarn_used','fiber_type','yarn_weight','colourway','dye_lot','skeins')->get();
            $jsonArray[$i]['ease'] = $project[$i]->ease;
            $jsonArray[$i]['verified'] = ($project[$i]->user_verify == 1) ? true : false;
            $jsonArray[$i]['images'] = Projectimages::where('project_id',$project[$i]->id)->select('image_ext','image_path')->get();
			$jsonArray[$i]['needle_size'] = Projectneedle::where('project_id',$project[$i]->id)->select('needle_size')->get();
			$jsonArray[$i]['downloaded'] = ($project[$i]->downloaded_offline == 1) ? true : false;
            $jsonArray[$i]['project_sync'] = ($project[$i]->project_sync == 1) ? 'sync' : 'notsync';
            $jsonArray[$i]['downloaded_at'] = ($project[$i]->downloaded_at == '') ? NULL :
                Carbon::parse($project[$i]->downloaded_at)->diffForHumans();
			
			$generatedCount = ProjectGeneratedCount::where('project_id',$project[$i]->id)->count();
			if($generatedCount > 0){
				$jsonArray[$i]['showSuccessMsg'] = false;
			}else{
				$jsonArray[$i]['showSuccessMsg'] = true;
			}
        }

		$gcount = new ProjectGeneratedCount;
		$gcount->user_id = Auth::user()->id;
		$gcount->project_id = $check->id;
		$gcount->device = 'Mobile';
		$gcount->created_at = Carbon::now();
		$gcount->updated_at = Carbon::now();
		$gcount->save();
		
        $array = array('project' => $jsonArray);
        return $this->sendJsonData($array);
    }
	
	function updateDownloadStatus(Request $request){
	    $request->validate([
	       'project_id' => 'required'
        ]);
	    $id = $request->project_id;
	    $project = Project::find($id);
	    $project->downloaded_offline = 1;
        $project->project_sync = 1;
        $project->downloaded_at = Carbon::now();
        $save = $project->save();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail','message' => 'Unable to upload download status.']);
        }
    }

/*
    function generate_custom_pattern(Request $request){
		
		//exit;
        $id = $request->id;
        $check = Project::where('id',$id)->first();
        if($check->pattern_type != 'custom'){
            return response()->json(['success' => false,'message' => 'The product selected is not a custom product.']);
            exit;
        }
        $jsonArray = array();
        $projects = Project::where('id',$id)->get();
        $project = Project::where('id',$id)->first();

        $upddate = array('updated_at' => Carbon::now());
        Project::where('id', $id)->update($upddate);
		


$product = Products::where('id',$project->product_id)->first();

$measurements = UserMeasurements::where('id',$project->measurement_profile)->select('m_title as title','hips','waist','waist_front','bust','bust_front','bust_back','waist_to_underarm','armhole_depth','wrist_circumference',
        'forearm_circumference','upperarm_circumference','shoulder_circumference','wrist_to_underarm','wrist_to_elbow','elbow_to_underarm',
        'wrist_to_top_of_shoulder','depth_of_neck','neck_width','neck_circumference','neck_to_shoulder','shoulder_to_shoulder')->first();
$project_notes = $project->project_notes;
$stitch_gauge = GaugeConversion::where('id',$project->stitch_gauge)->first();
$row_gauge = GaugeConversion::where('id',$project->row_gauge)->first();
$pdm = ProjectsDesignerMeasurements::where('project_id',$project->id)->get();
$pdf = ProductPdf::where('product_id',$project->product_id)->first();
$array = array('TITLE' => $measurements->title);
if($project->uom == 'in' || $project->uom == 'inches'){
$array1 = array('STITCH_GAUGE' =>$stitch_gauge->stitch_gauge_inch,'ROW_GAUGE' => $row_gauge->row_gauge_inch,'EASE' => $project->ease,'NEEDLE_SIZE' => 3);
}else{
$array1 = array('STITCH_GAUGE' =>$stitch_gauge->stitches_10_cm,'ROW_GAUGE' => $row_gauge->rows_10_cm,'EASE' => $project->ease,'NEEDLE_SIZE' => 3);
}
if($project->designer_recommended_uom == 'in' || $project->uom == 'inches'){
$dstitch = $product->recommended_stitch_gauge_in;
$drow = $product->recommended_row_gauge_in;
$designer_stitch_gauge = GaugeConversion::where('id',$dstitch)->first();
$designer_row_gauge = GaugeConversion::where('id',$drow)->first();

$stitchg = $designer_stitch_gauge->stitch_gauge_inch.' / 1';
$rowg = $designer_row_gauge->row_gauge_inch.' / 1';

}else{
$dstitch = $product->recommended_stitch_gauge_cm;
$drow = $product->recommended_row_gauge_cm;

$designer_stitch_gauge = GaugeConversion::where('id',$dstitch)->first();
$designer_row_gauge = GaugeConversion::where('id',$drow)->first();

$stitchg = $designer_stitch_gauge->stitches_10_cm.' / 10';
$rowg = $designer_row_gauge->rows_10_cm.' / 10';
}

if($product->designer_recommended_uom == 'in'){
	$designer_uom = 'inch';
}else{
	$designer_uom = 'Centimeter';
}

            /* Adding  a file 

if($project->uom == 'in' || $project->uom == 'inches'){
	$uom = 'in';
	$filename = $product->measurement_file.'_in.xlsx';
}else{
	$uom = 'cm';
	$filename = $product->measurement_file.'_cm.xlsx';
}


if($project->uom == 'in' || $project->uom == 'inches'){
    $rows = DB::table('pattern_measurements')->where('uom','in')->where('status',1)->get();
}else{
    $rows = DB::table('pattern_measurements')->where('status',1)->get();
}




    $columns = DB::getSchemaBuilder()->getColumnListing('user_measurements');
    $data = '';

            $i=2;
            foreach ($rows as $row) {
                //echo $row->name."<br>";

                foreach ($columns as $key) {
                   $key1 = strtoupper($key);
                    if($row->name == $key1){
                    //echo $i.')'.$row->name.' - '.$measurements->$key."<br>";
                    $value = $measurements->$key;
                    //$worksheet->getCell("C".$i)->setValue($value);
						if(isset($value)){
							//$data.=' "'.$row->name.' - '.$value.'" ';
							$data.=' "'.$value.'" ';
						}else{
							$data.=' "0" ';
							//$data.=' "'.$row->name.' - 0" ';
						}
                    }
                }


                foreach ($array as $k => $val) {
                    if($row->name == $k){
                    //echo $i.')'.$row->name.' -- '.$val."<br>";
                    //$worksheet->getCell("C".$i)->setValue($val);
                        if(isset($val)){
							//$data.=' "'.$row->name.' - '.$val.'" ';
							$data.=' "'.$val.'" ';
						}else{
							$data.=' "0" ';
							//$data.=' "'.$row->name.' - 0" ';
						}
                    }
                }

                //echo $row['B']."<br>";
                foreach ($array1 as $ky => $va) {
                    //echo $ky."<br>";
                    if($row->name == $ky){
                     //echo $i.')'.$row->name.' -- '.$va."<br>";
                    //$worksheet->getCell("C".$i)->setValue($va);
                        if(isset($va)){
							//$data.=' "'.$row->name.' - '.$va.'" ';
							$data.=' "'.$va.'" ';
						}else{
							$data.=' "0" ';
							//$data.=' "'.$row->name.' - 0" ';
						}
                    }
                }
				
				
                foreach ($pdm as $pm => $mdp) {
					 
                    $mname = strtoupper($mdp->measurement_name);
                    if($row->name == $mname){
					//echo $i.')'.$row->name.' -- '.$mdp->measurement_value."<br>";
                    //$worksheet->getCell("C".$i)->setValue($mdp->measurement_value);
                        if(isset($mdp->measurement_value)){
							//$data.=' "'.$row->name.' - '.$mdp->measurement_value.'" ';
							$data.=' "'.$mdp->measurement_value.'" ';
						}else{
							$data.=' "0" ';
							//$data.=' "'.$row->name.' - 0" ';
						}
						
                    }
					
					
						
					
                }
				
				if(count($pdm) == 1){
					if($i == 8){
						//echo $i.') LOWER_EDGE_CIRCUMFERENCE -- 0<br>';
						//$data.=' "0" ';
						//$data.=' LOWER_EDGE_CIRCUMFERENCE - "0" ';
						$data.=' "0" ';
					}
				
				
					if($i == 10){
						//echo $i.') LOWER_EDGE_TO_WAIST -- 0<br>';
						//$data.=' "0" ';
						//$data.=' LOWER_EDGE_TO_WAIST - "0" ';
						$data.=' "0" ';
					}
				}
				

               /* if($i == count($rows)+1){
                    echo $i.')'.$row->name.' -- 0 <br>';
                } 
                $i++;
            }
			
	Log::channel('stack')->info('Projects: ',['data' => $data,'GeneratedFrom' => 'Mobile','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR'],'Method' => 'GET','URL' => '/generate-custom-pattern/'.$request->id]);		

          //  exit;
$path = storage_path($filename);
$time = time().'-'.Auth::user()->id;
$targetPath = storage_path($time.'.Xlsx');

if($project->uom == 'in' || $project->uom == 'inches'){
$command = 'wscript.exe '.storage_path('new.vbs').' "C:\\laragon\\www\\knitfitnew\\storage\\'.$filename.'" "C:\\laragon\\www\\knitfitnew\\storage\\'.$time.'.Xlsx" '.$data; 
}else{
$command = 'wscript.exe '.storage_path('new_cm.vbs').' "C:\\laragon\\www\\knitfitnew\\storage\\'.$filename.'" "C:\\laragon\\www\\knitfitnew\\storage\\'.$time.'.Xlsx" '.$data; 
}
//Log::channel('stack')->info('Projects: ',['data' => $command,'GeneratedFrom' => 'Mobile','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR'],'Method' => 'GET','URL' => '/generate-custom-pattern/'.$request->id]);
//exit;
//$originalPath = 'write'.$time.'.Xlsx';


$wait = true; 

$obj = new COM ( 'WScript.Shell' ); 
if ( is_object ( $obj ) ) { 
    $obj->Run ( 'cmd /C ' . $command, 0, $wait ); 
} else { 
    echo 'can not create wshell object'; 
} 
$obj = null;



       // $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
       // $writer->setPreCalculateFormulas(true);
       // $save = $writer->save($targetPath);

        //sleep(3);

    //exit;

    /* Adding a file */

           

           

           //$rows = $worksheet->toArray();
/* $WshShell = new \COM("WScript.Shell");
$obj = $WshShell->Run("cscript ".storage_path('test.vbs'), 0, true); */

/* command to run shell script for load excel*/ 
/* $originalPath = $time.'.Xlsx';
$command = 'wscript.exe '.storage_path('test.vbs').' D:\laragon\www\knitfitnew\storage\\'.$originalPath; 
$wait = true; 

$obj = new COM ( 'WScript.Shell' ); 
if ( is_object ( $obj ) ) { 
    $obj->Run ( 'cmd /C ' . $command, 0, $wait ); 
} else { 
    echo 'can not create wshell object'; 
} 
$obj = null;
/* command to run shell script for load excel
//sleep(3); 

$filename = storage_path('write'.$time.'.Xlsx');
$str = '';

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
$worksheet = $spreadsheet->getSheetByName('KnitVariables');
            $rows = $worksheet->rangeToArray(
                'B2:B150',     // The worksheet range that we want to retrieve
                NULL,        // Value that should be returned for empty cells
                TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
                TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
                TRUE         // Should the array be indexed by cell row and cell column
            );


$rows1 = $worksheet->rangeToArray(
                'M2:M150',     // The worksheet range that we want to retrieve
                NULL,        // Value that should be returned for empty cells
                TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
                TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
                TRUE         // Should the array be indexed by cell row and cell column
            );



$pdf->content = str_replace('[[DESIGNER_STITCH_GAUGE]]',$stitchg,$pdf->content);
$pdf->content = str_replace('[[DESIGNER_ROW_GAUGE]]',$rowg,$pdf->content);
$pdf->content = str_replace('[[DESIGNERS_MEASUREMENT_PREFERENCE]]',$designer_uom,$pdf->content);
//echo '<pre>';
            $i=2;
    foreach ($rows as $row) {
       // echo $row['B'].' = '.$rows1[$i]['M']."<br>";
    $pdf->content=str_replace('[['.$row['B'].']]',$rows1[$i]['M'],$pdf->content);
        $i++;
    }

$array12 = array('content' => $pdf->content);
//$cont = $pdf->content;
//exit;


        for ($i=0; $i < count($projects); $i++) {
            $jsonArray[$i]['id'] = $projects[$i]->id;
            $jsonArray[$i]['name'] = $projects[$i]->name;

            $jsonArray[$i]['description'] = $projects[$i]->description;

            $jsonArray[$i]['skill_level'] = $product->skill_level;
            $jsonArray[$i]['pattern_type'] = $projects[$i]->pattern_type;
            $jsonArray[$i]['uom'] = ($projects[$i]->uom == 'in' || $projects[$i]->uom == 'inches') ? 'Inches' : 'Centimeters';
            if($projects[$i]->uom == 'in' || $projects[$i]->uom == 'inches'){
                $jsonArray[$i]['gauge'] = GaugeConversion::where('id',$projects[$i]->stitch_gauge)->select('stitch_gauge_inch as stitch_gauge','row_gauge_inch as row_gauge')->take(1)->get();

            }else{
                $jsonArray[$i]['gauge'] = GaugeConversion::where('id',$projects[$i]->row_gauge)->select('stitches_10_cm as stitch_gauge','rows_10_cm as row_gauge')->take(1)->get();
            }

            $jsonArray[$i]['measurement_profile'] = UserMeasurements::where('id',$projects[$i]->measurement_profile)->select('m_title')->take(1)->get();
            $jsonArray[$i]['ease'] = $projects[$i]->ease;
            $jsonArray[$i]['yarn_details'] = Projectyarn::where('project_id',$projects[$i]->id)->select('yarn_used','fiber_type','yarn_weight','colourway','dye_lot','skeins')->get();
            $jsonArray[$i]['needle_size'] = Projectneedle::where('project_id',$projects[$i]->id)->select('needle_size')->get();
            $measurements = ProjectsDesignerMeasurements::where('project_id',$projects[$i]->id)->select('measurement_name','measurement_value')->get();
            for ($j=0; $j < count($measurements); $j++) {
                $jsonArray[$i]['project_measurements'][$j]['measurement_name'] = str_replace('_',' ',$measurements[$j]->measurement_name);
                $jsonArray[$i]['project_measurements'][$j]['measurement_value'] = str_replace('_',' ',$measurements[$j]->measurement_value);
            }
          $jsonArray[$i]['pdf_content'] = [$array12];
        }

        $array = array('project' => $jsonArray);
        unlink($targetPath);
        return $this->sendJsonData($array);
    }
*/

function generate_custom_pattern(Request $request){
	info($request->all());
        $id = $request->id;
		$again = $request->get('again');
        $check = Project::where('id',$id)->first();
		
       if($check->pattern_type != 'custom'){
            return response()->json(['success' => false,'message' => 'The product selected is not a custom product.']);
            exit;
	   }
        $jsonArray = array();
        $projects = Project::where('id',$id)->get();
        $project = Project::where('id',$id)->first();

        if($again){
			$upddate = array('project_sync' => 0,'updated_at' => Carbon::now());
		}else{
			$upddate = array('updated_at' => Carbon::now());
		}
        Project::where('id', $id)->update($upddate);
		
		$varient = $request->get('varient');
		$again = $request->get('again');
		if(($again == 'yes') && ($varient != $project->product_shaped)){
			$array = array('product_shaped' => $varient);
			Project::where('id', $project->id)->update($array);
		}

if($project->uom == 'in' || $project->uom == 'inches'){
	$uom = 'in';
}else{
	$uom = 'cm';
}
		
$product = Products::where('id',$project->product_id)->first();

$measurements = UserMeasurements::where('id',$project->measurement_profile)->select('m_title as title','hips','waist','waist_front','bust','bust_front','bust_back','waist_to_underarm','armhole_depth','wrist_circumference',
        'forearm_circumference','upperarm_circumference','shoulder_circumference','wrist_to_underarm','wrist_to_elbow','elbow_to_underarm',
        'wrist_to_top_of_shoulder','depth_of_neck','neck_width','neck_circumference','neck_to_shoulder','shoulder_to_shoulder')->first();

if(!$measurements){
	return response()->json(['success' => false,'message' => 'The measurement profile selected was no longer exists.']);
	exit;
}
$project_notes = $project->project_notes;
$stitch_gauge = GaugeConversion::where('id',$project->stitch_gauge)->first();
$row_gauge = GaugeConversion::where('id',$project->row_gauge)->first();
$pdmNotused = DB::table('product_designer_measurements_notused')->where('product_id',$project->product_id)->get();
$pdm = ProjectsDesignerMeasurements::where('project_id',$project->id)->get();
$pdf = ProductPdf::where('product_id',$project->product_id)->where('uom',$uom)->first();
$array = array('TITLE' => $measurements->title);
if($project->uom == 'in' || $project->uom == 'inches'){
$array1 = array('STITCH_GAUGE' =>$stitch_gauge->stitch_gauge_inch,'ROW_GAUGE' => $row_gauge->row_gauge_inch,'EASE' => $project->ease,'NEEDLE_SIZE' => 3);
}else{
$array1 = array('STITCH_GAUGE' =>$stitch_gauge->stitches_10_cm,'ROW_GAUGE' => $row_gauge->rows_10_cm,'EASE' => $project->ease,'NEEDLE_SIZE' => 3);
}


if($project->uom == 'in' || $project->uom == 'inches'){
$dstitch = $product->recommended_stitch_gauge_in;
$drow = $product->recommended_row_gauge_in;

if($dstitch){
	$designer_stitch_gauge = GaugeConversion::where('id',$dstitch)->first();
	$stitchg = $designer_stitch_gauge->stitch_gauge_inch.' / 1';
}else{
	$stitchg = '0 / 1';
}

if($drow){
	$designer_row_gauge = GaugeConversion::where('id',$drow)->first();
	$rowg = $designer_row_gauge->row_gauge_inch.' / 1';
}else{
	$rowg = '0 / 1';
}


}else{
$dstitch = $product->recommended_stitch_gauge_cm;
$drow = $product->recommended_row_gauge_cm;

if($dstitch){
	$designer_stitch_gauge = GaugeConversion::where('id',$dstitch)->first();
	$stitchg = $designer_stitch_gauge->stitches_10_cm.' / 10';
}else{
	$stitchg = '0 / 10';
}

if($drow){
	$designer_row_gauge = GaugeConversion::where('id',$drow)->first();
	$rowg = $designer_row_gauge->rows_10_cm.' / 10';
}else{
	$rowg = '0 / 10';
}

}

            /* Adding  a file */
/*
if($project->uom == 'in' || $project->uom == 'inches'){
    $uom = 'in';
    $path = storage_path($product->measurement_file.'_in.xlsx');
    $filename = $product->measurement_file.'_in.xlsx';
}else{
    $uom = 'cm';
    $path = storage_path($product->measurement_file.'_cm.xlsx');
    $filename = $product->measurement_file.'_cm.xlsx';
}*/

if($project->uom == 'in' || $project->uom == 'inches'){
    $uom = 'in';
    $path = storage_path($product->measurement_file.'_in.xlsx');
    //$filename = $product->measurement_file.'_in.xlsx';
	if($project->product_shaped == 0){
		$filename = $product->measurement_file.'_in.xlsx';
	}else{
		$filename = $product->measurement_file.'-unshaped_in.xlsx';
	}
}else{
    $uom = 'cm';
    $path = storage_path($product->measurement_file.'_cm.xlsx');
    //$filename = $product->measurement_file.'_cm.xlsx';
	if($project->product_shaped == 0){
		$filename = $product->measurement_file.'_cm.xlsx';
	}else{
		$filename = $product->measurement_file.'-unshaped_cm.xlsx';
	}
}

if($project->uom == 'in' || $project->uom == 'inches'){
    $rows = DB::table('pattern_measurements')->where('status',1)->get();
}else{
    $rows = DB::table('pattern_measurements')->where('status',1)->get();
}

$instructionCount = DB::table('pattern_instructions')->where('project_id',$project->id)->count();



if(!$again){
    if($instructionCount > 0){
        $instruction = DB::table('pattern_instructions')->where('project_id',$project->id)->select('content')->take(1)->get();
        //$cont = $instruction->content;
        $filename = '';
        for ($i=0; $i < count($projects); $i++) {
            $jsonArray[$i]['id'] = $projects[$i]->id;
            $jsonArray[$i]['name'] = $projects[$i]->name;

            $jsonArray[$i]['description'] = $projects[$i]->description;

            $jsonArray[$i]['skill_level'] = $product->skill_level;
            $jsonArray[$i]['pattern_type'] = $projects[$i]->pattern_type;
			$jsonArray[$i]['shaped_unshaped'] = ($product->shaped_unshaped == 1) ? true : false;
            $jsonArray[$i]['uom'] = ($projects[$i]->uom == 'in' || $projects[$i]->uom == 'inches') ? 'Inches' : 'Centimeters';
			$stitch_gauge = GaugeConversion::where('id',$projects[$i]->stitch_gauge)->select('stitch_gauge_inch as stitch_gauge')->take(1)->first();
			$row_gauge = GaugeConversion::where('id',$projects[$i]->row_gauge)->select('row_gauge_inch as row_gauge')->take(1)->first();
            if($projects[$i]->uom == 'in' || $projects[$i]->uom == 'inches'){
				$stitch_gauge = GaugeConversion::where('id',$projects[$i]->stitch_gauge)->select('stitch_gauge_inch as stitch_gauge')->first();
				$row_gauge = GaugeConversion::where('id',$projects[$i]->row_gauge)->select('row_gauge_inch as row_gauge')->first();
			
                $jsonArray[$i]['gauge'] = [array('stitch_gauge' => $stitch_gauge->stitch_gauge,'row_gauge' => $row_gauge->row_gauge)];

            }else{
				$stitch_gauge = GaugeConversion::where('id',$projects[$i]->stitch_gauge)->select('stitches_10_cm as stitch_gauge')->first();
				$row_gauge = GaugeConversion::where('id',$projects[$i]->row_gauge)->select('rows_10_cm as row_gauge')->first();
				
                $jsonArray[$i]['gauge'] = [array('stitch_gauge' => $stitch_gauge ? $stitch_gauge->stitch_gauge : 0,'row_gauge' => $row_gauge ? $row_gauge->row_gauge : 0)];
            }

            $jsonArray[$i]['measurement_profile'] = UserMeasurements::where('id',$projects[$i]->measurement_profile)->select('m_title')->take(1)->get();
            $jsonArray[$i]['ease'] = $projects[$i]->ease;
            $jsonArray[$i]['yarn_details'] = Projectyarn::where('project_id',$projects[$i]->id)->select('yarn_used','fiber_type','yarn_weight','colourway','dye_lot','skeins')->get();
            $jsonArray[$i]['needle_size'] = Projectneedle::where('project_id',$projects[$i]->id)->select('needle_size')->get();
            $measurements = ProjectsDesignerMeasurements::where('project_id',$projects[$i]->id)->select('measurement_name','measurement_value')->get();
            for ($j=0; $j < count($measurements); $j++) {
                $jsonArray[$i]['project_measurements'][$j]['measurement_name'] = str_replace('_',' ',$measurements[$j]->measurement_name);
                $jsonArray[$i]['project_measurements'][$j]['measurement_value'] = str_replace('_',' ',$measurements[$j]->measurement_value);
            }
          $instruction1 = '<!DOCTYPE html><head></head><body>'.$instruction.'</body></html>';
            $doc = new \DOMDocument('1.0');
            @$doc->loadHTML($instruction[0]->content);
            $tags = $doc->getElementsByTagName('img');
            for ($k=0;$k<count($tags);$k++){
                $kCount = $k + 1;
                $old_src = $tags[$k]->getAttribute('src');
                $jsonArray[$i]['instruction_images'][$k]['image_tag'] = 'image'.$kCount;
                $jsonArray[$i]['instruction_images'][$k]['image_server_url'] = $old_src;
                $new_src_url = 'image'.$kCount;
                $tags[$k]->setAttribute('src', $new_src_url);
            }

            //$data['description'] = $doc->saveHTML();

          $jsonArray[$i]['instructions'] = [$doc->saveHTML()];
		  $jsonArray[$i]['downloaded'] = ($projects[$i]->downloaded_offline == 1) ? true : false;
            $jsonArray[$i]['project_sync'] = ($projects[$i]->project_sync == 1) ? 'sync' : 'notsync';
            $jsonArray[$i]['downloaded_at'] = ($projects[$i]->downloaded_at == '') ? NULL :
                Carbon::parse($projects[$i]->downloaded_at)->diffForHumans();
			$jsonArray[$i]['showSuccessMsg'] = false;
        }
		
		//PDF::loadHTML($instruction)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf')->stream(url('myfile.pdf'));
		
		$gcount = new ProjectGeneratedCount;
		$gcount->user_id = Auth::user()->id;
		$gcount->project_id = $project->id;
		$gcount->device = 'Mobile';
		$gcount->created_at = Carbon::now();
		$gcount->updated_at = Carbon::now();
		$gcount->save();
		
        $array = array('project' => $jsonArray);
        return $this->sendJsonData($array);
        exit;
    }
}



$columns = DB::getSchemaBuilder()->getColumnListing('user_measurements');
 $data = '';
$i=2;
foreach ($rows as $row) {
                //echo $row->name."<br>";

                foreach ($columns as $key) {
                   $key1 = strtoupper($key);
                    if($row->name == $key1){
                    //echo $i.')'.$row->name.' - '.$measurements->$key."<br>";
                    $value = $measurements->$key;
                    //$worksheet->getCell("C".$i)->setValue($value);
                        if(isset($value)){
                            $data.=' "'.$value.'" ';
                        }else{
                            $data.=' "0" ';
                        }
                        
                    }
                }


                foreach ($array as $k => $val) {
                    if($row->name == $k){
                    //echo $i.')'.$row->name.' -- '.$val."<br>";
                    //$worksheet->getCell("C".$i)->setValue($val);
                        if(isset($val)){
                            $data.=' "'.$val.'" ';
                        }else{
                            $data.=' "0" ';
                        }
                    }
                }

                //echo $row['B']."<br>";
                foreach ($array1 as $ky => $va) {
                    //echo $ky."<br>";
                    if($row->name == $ky){
                     //echo $i.')'.$row->name.' -- '.$va."<br>";
                    //$worksheet->getCell("C".$i)->setValue($va);
                        if(isset($va)){
                            $data.=' "'.$va.'" ';
                        }else{
                            $data.=' "0" ';
                        }
                    }
                }
                
                
                foreach ($pdm as $pm => $mdp) {
                     
                    $mname = strtoupper($mdp->measurement_name);
                    if($row->name == $mname){
                    //echo $i.')'.$row->name.' -- '.$mdp->measurement_value."<br>";
                    //$worksheet->getCell("C".$i)->setValue($mdp->measurement_value);
                        
                        if(isset($mdp->measurement_value)){
                            $data.=' "'.$mdp->measurement_value.'" ';
                        }else{
                            $data.=' "0" ';
                        }
                        
                    }
                }
                
				foreach ($pdmNotused as $prm => $pdmnu) {
                    $mname = strtoupper($pdmnu->measurement_name);
                    if($row->name == $mname){
					//echo $i.')'.$row->name.' -- '.$mdp->measurement_value."<br>";
						$data.=' "0" ';
                    }
	
                }
                
				
				/* if($product->id == 5){ // peakaboo
					if($row->name == 'LOWER_EDGE_TO_BASE_OF_NECK'){
						//echo $i.') LOWER_EDGE_TO_BASE_OF_NECK -- 0<br>';
						$data.=' "0" ';
					}
				}
				
				if($product->id == 7){ // The Boyfriend Sweater
					if($row->name == 'LOWER_EDGE_TO_BASE_OF_NECK'){
						//echo $i.') LOWER_EDGE_TO_BASE_OF_NECK -- 0<br>';
						$data.=' "0" ';
					}
				}
				
				if($product->id == 8){ // Marsha's Lacey Tee
					if($row->name == 'LOWER_EDGE_TO_BASE_OF_NECK'){
						//echo $i.') LOWER_EDGE_TO_BASE_OF_NECK -- 0<br>';
						$data.=' "0" ';
					}
				}
				
				if($product->id == 9){ // Off-the-Shoulder Ruffle Top
					if($row->name == 'LOWER_EDGE_TO_BASE_OF_NECK'){
						//echo $i.') LOWER_EDGE_TO_BASE_OF_NECK -- 0<br>';
						$data.=' "0" ';
					}
				}
				
				if($product->id == 10){ // Emily's Sweater
					if($row->name == 'LOWER_EDGE_TO_BASE_OF_NECK'){
						//echo $i.') LOWER_EDGE_TO_BASE_OF_NECK -- 0<br>';
						$data.=' "0" ';
					}
				}
				
				if($product->id == 11){ // Trevor's V-neck Sweater
					if($row->name == 'LOWER_EDGE_CIRCUMFERENCE'){ // need to remove if required.
						//echo $i.') LOWER_EDGE_CIRCUMFERENCE -- 0<br>';
						$data.=' "0" ';
					}
					
					if($row->name == 'LOWER_EDGE_TO_WAIST'){
						//echo $i.') LOWER_EDGE_TO_WAIST -- 0<br>';
						$data.=' "0" ';
					}
					
					if($row->name == 'LOWER_EDGE_TO_BASE_OF_NECK'){
						//echo $i.') LOWER_EDGE_TO_BASE_OF_NECK -- 0<br>';
						$data.=' "0" ';
					}
				}
				
				if($product->id == 13){
					if($row->name == 'LOWER_EDGE_TO_WAIST'){
						//echo $i.') LOWER_EDGE_TO_WAIST -- 0<br>';
						$data.=' "0" ';
					}
					
				}
				
				
				if($product->id == 14){
					if($row->name == 'LOWER_EDGE_TO_WAIST'){
						//echo $i.') LOWER_EDGE_TO_WAIST -- 0<br>';
						$data.=' "0" ';
					}
				}
				
				if($product->id == 15){
					
					if($row->name == 'LOWER_EDGE_TO_BASE_OF_NECK'){
						//echo $i.') LOWER_EDGE_TO_BASE_OF_NECK -- 0<br>';
						$data.=' "0" ';
					}
				}
				
				if($product->id == 16){
					
					if($row->name == 'LOWER_EDGE_TO_BASE_OF_NECK'){
						//echo $i.') LOWER_EDGE_TO_BASE_OF_NECK -- 0<br>';
						$data.=' "0" ';
					}
					if($row->name == 'LOWER_EDGE_TO_UNDERARM'){
						//echo $i.') LOWER_EDGE_TO_UNDERARM -- 0<br>';
						$data.=' "0" ';
					}
				}
				
				if($product->id == 17){
					
					if($row->name == 'LOWER_EDGE_TO_BASE_OF_NECK'){
						//echo $i.') LOWER_EDGE_TO_BASE_OF_NECK -- 0<br>';
						$data.=' "0" ';
					}
					if($row->name == 'LOWER_EDGE_TO_WAIST'){
						//echo $i.') LOWER_EDGE_TO_UNDERARM -- 0<br>';
						$data.=' "0" ';
					}
					if($row->name == 'SLEEVE_EASE'){
						//echo $i.') SLEEVE_EASE -- 0<br>';
						$data.=' "0" ';
					}
				} */
				
                $i++;
            }


$path = storage_path($filename);
$time = time().'-'.Auth::user()->id;
$targetPath = storage_path($time.'.Xlsx');

if($project->uom == 'in' || $project->uom == 'inches'){
$command = 'wscript.exe '.storage_path("new.vbs").' "C:\\laragon\\www\\web\\storage\\'.$filename.'" "C:\\laragon\\www\\web\\storage\\'.$time.'.Xlsx" '.$data; 
}else{
$command = 'wscript.exe '.storage_path("new_cm.vbs").' "C:\\laragon\\www\\web\\storage\\'.$filename.'" "C:\\laragon\\www\\web\\storage\\'.$time.'.Xlsx" '.$data; 
}
//return response()->json(['datas' => $command]);
//exit;
//Log::channel('stack')->info('Projects: ',['data' => $command,'GeneratedFrom' => 'Mobile','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR'],'Method' => 'GET','URL' => '/generate-custom-pattern/'.$request->id]);	
//exit;
//$originalPath = 'write'.$time.'.Xlsx';


$wait = true; 

$obj = new COM ( 'WScript.Shell' ); 
if ( is_object ( $obj ) ) { 
    $obj->Run ( 'cmd /C ' . $command, 0, $wait ); 
} else { 
    //echo 'can not create wshell object'; 
	return response()->json(['success' => false,'message' => 'Unable to generate pattern.Try again after sometime.']);
    exit;
} 
$obj = null;


$filename = storage_path($time.'.Xlsx');
$str = '';

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);

$worksheet = $spreadsheet->getSheetByName('KnitVariables');

$rows = $worksheet->rangeToArray(
'B2:B250',     // The worksheet range that we want to retrieve
NULL,        // Value that should be returned for empty cells
TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
TRUE         // Should the array be indexed by cell row and cell column
);


$rows1 = $worksheet->rangeToArray(
'M2:M250',     // The worksheet range that we want to retrieve
NULL,        // Value that should be returned for empty cells
TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
TRUE         // Should the array be indexed by cell row and cell column
);

$pdf->content = str_replace('[[DESIGNER_STITCH_GAUGE]]',$stitchg,$pdf->content);
$pdf->content = str_replace('[[DESIGNER_ROW_GAUGE]]',$rowg,$pdf->content);
    $i=2;
foreach ($rows as $row) {
$pdf->content=str_replace('[['.$row['B'].']]',$rows1[$i]['M'],$pdf->content);
$i++;
}

$array12 = array('content' => $pdf->content);

if($instructionCount > 0){
    $contents = array('content' => $pdf->content,'updated_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
    DB::table('pattern_instructions')->where('user_id',Auth::user()->id)->where('project_id',$project->id)->update($contents);
}else{
    
$contents = array('user_id' => Auth::user()->id,'project_id' => $project->id,'content' => $pdf->content,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
DB::table('pattern_instructions')->insert($contents);
}



//$cont = $pdf->content;
//exit;

//PDF::loadHTML($pdf->content)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf')->stream(url('myfile.pdf'));

        for ($i=0; $i < count($projects); $i++) {
            $jsonArray[$i]['id'] = $projects[$i]->id;
            $jsonArray[$i]['name'] = $projects[$i]->name;

            $jsonArray[$i]['description'] = $projects[$i]->description;

            $jsonArray[$i]['skill_level'] = $product->skill_level;
            $jsonArray[$i]['pattern_type'] = $projects[$i]->pattern_type;
			$jsonArray[$i]['shaped_unshaped'] = ($product->shaped_unshaped == 1) ? true : false;
            $jsonArray[$i]['uom'] = ($projects[$i]->uom == 'in' || $projects[$i]->uom == 'inches') ? 'Inches' : 'Centimeters';
            if($projects[$i]->uom == 'in' || $projects[$i]->uom == 'inches'){
                $sgauge = GaugeConversion::where('id',$projects[$i]->stitch_gauge)->select('stitch_gauge_inch as stitch_gauge')->first();
				$rgauge = GaugeConversion::where('id',$projects[$i]->row_gauge)->select('row_gauge_inch as row_gauge')->first();
				
				$jsonArray[$i]['gauge'] = [array('stitch_gauge' => $sgauge ? $sgauge->stitch_gauge : 0,'row_gauge' => $rgauge ? $rgauge->row_gauge : 0)];
				

            }else{
                $sgauge = GaugeConversion::where('id',$projects[$i]->stitch_gauge)->select('stitches_10_cm as stitch_gauge')->first();
				$rgauge = GaugeConversion::where('id',$projects[$i]->row_gauge)->select('rows_10_cm as row_gauge')->first();
				
				$jsonArray[$i]['gauge'] = [array('stitch_gauge' => $sgauge ? $sgauge->stitch_gauge : 0,'row_gauge' => $rgauge ? $rgauge->row_gauge : 0)];
            }

            $jsonArray[$i]['measurement_profile'] = UserMeasurements::where('id',$projects[$i]->measurement_profile)->select('m_title')->take(1)->get();
            $jsonArray[$i]['ease'] = $projects[$i]->ease;
            $jsonArray[$i]['yarn_details'] = Projectyarn::where('project_id',$projects[$i]->id)->select('yarn_used','fiber_type','yarn_weight','colourway','dye_lot','skeins')->get();
            $jsonArray[$i]['needle_size'] = Projectneedle::where('project_id',$projects[$i]->id)->select('needle_size')->get();
            $measurements = ProjectsDesignerMeasurements::where('project_id',$projects[$i]->id)->select('measurement_name','measurement_value')->get();
            for ($j=0; $j < count($measurements); $j++) {
                $jsonArray[$i]['project_measurements'][$j]['measurement_name'] = str_replace('_',' ',$measurements[$j]->measurement_name);
                $jsonArray[$i]['project_measurements'][$j]['measurement_value'] = str_replace('_',' ',$measurements[$j]->measurement_value);
            }
          $instruction1 = '<!DOCTYPE html><head></head><body>'.$array12['content'].'</body></html>';
            $doc = new \DOMDocument('1.0');
            @$doc->loadHTML($instruction1);
            $tags = $doc->getElementsByTagName('img');
            for ($k=0;$k<count($tags);$k++){
                $kCount = $k + 1;
                $old_src = $tags[$k]->getAttribute('src');
                $jsonArray[$i]['instruction_images'][$k]['image_tag'] = 'image'.$kCount;
                $jsonArray[$i]['instruction_images'][$k]['image_server_url'] = $old_src;
                $new_src_url = 'image'.$kCount;
                $tags[$k]->setAttribute('src', $new_src_url);
            }

            //$data['description'] = $doc->saveHTML();

          $jsonArray[$i]['instructions'] = [$doc->saveHTML()];
		  $jsonArray[$i]['downloaded'] = ($projects[$i]->downloaded_offline == 1) ? true : false;
            $jsonArray[$i]['project_sync'] = ($projects[$i]->project_sync == 1) ? 'sync' : 'notsync';
            $jsonArray[$i]['downloaded_at'] = ($projects[$i]->downloaded_at == '') ? NULL :
                Carbon::parse($projects[$i]->downloaded_at)->diffForHumans();
				$jsonArray[$i]['showSuccessMsg'] = true;
        }

		$gcount = new ProjectGeneratedCount;
		$gcount->user_id = Auth::user()->id;
		$gcount->project_id = $project->id;
		$gcount->device = 'Mobile';
		$gcount->created_at = Carbon::now();
		$gcount->updated_at = Carbon::now();
		$gcount->save();
		
        $array = array('project' => $jsonArray);
        //unlink($targetPath);
        return $this->sendJsonData($array);
    }

    function generate_non_custom_pattern(Request $request){
        $id = $request->id;
        $check = Project::where('id',$id)->first();
        $again = $request->get('again');
        if($check->pattern_type != 'non-custom'){
            return response()->json(['success' => false,'message' => 'The product selected is not a non custom product.']);
            exit;
        }
		
		if($again){
			$upddate = array('project_sync' => 0,'updated_at' => Carbon::now());
		}else{
			$upddate = array('updated_at' => Carbon::now());
		}
        Project::where('id', $id)->update($upddate);
		
		$instructionsCount = DB::table('pattern_instructions')->where('user_id',Auth::user()->id)->where('project_id',$check->id)->count();
		if(!$again){
			if($instructionsCount > 0){
				$pdf = DB::table('pattern_instructions')->where('user_id',Auth::user()->id)->where('project_id',$check->id)->first();
			}else{
				$pdf = ProductPdf::where('product_id',$check->product_id)->first();
			}
		}else{
			$pdf = ProductPdf::where('product_id',$check->product_id)->first();
		}
		$pdf = ProductPdf::where('product_id',$check->product_id)->first();
        $jsonArray = array();
        $project = Project::where('id',$id)->get();
        for ($i=0; $i < count($project); $i++) {
            $jsonArray[$i]['id'] = $project[$i]->id;
            $jsonArray[$i]['name'] = $project[$i]->name;
            $jsonArray[$i]['description'] = $project[$i]->description;
            $product = Products::where('id',$project[$i]->product_id)->first();
            $jsonArray[$i]['skill_level'] = $product->skill_level;
            $jsonArray[$i]['pattern_type'] = $project[$i]->pattern_type;
            $jsonArray[$i]['uom'] = ($project[$i]->uom == 'in') ? 'Inches' : 'Centimeters';
            if($project[$i]->uom == 'in'){
                $sgauge = GaugeConversion::where('id',$project[$i]->stitch_gauge)->select('stitch_gauge_inch as stitch_gauge')->first();
				$rgauge = GaugeConversion::where('id',$project[$i]->row_gauge)->select('row_gauge_inch as row_gauge')->first();
				
				$jsonArray[$i]['gauge'] = [array('stitch_gauge' => $sgauge ? $sgauge->stitch_gauge : 0,'row_gauge' => $rgauge ? $rgauge->row_gauge : 0)];

            }else{
                $sgauge = GaugeConversion::where('id',$project[$i]->stitch_gauge)->select('stitches_10_cm as stitch_gauge')->first();
				$rgauge = GaugeConversion::where('id',$project[$i]->row_gauge)->select('rows_10_cm as row_gauge')->first();
				
				$jsonArray[$i]['gauge'] = [array('stitch_gauge' => $sgauge ? $sgauge->stitch_gauge : 0,'row_gauge' => $rgauge ? $rgauge->row_gauge : 0)];
            }

            $jsonArray[$i]['measurement_profile'] = UserMeasurements::where('id',$project[$i]->measurement_profile)->select('m_title')->take(1)->get();
            $jsonArray[$i]['ease'] = $project[$i]->ease;
            $jsonArray[$i]['yarn_details'] = Projectyarn::where('project_id',$project[$i]->id)->select('yarn_used','fiber_type','yarn_weight','colourway','dye_lot','skeins')->get();
            $jsonArray[$i]['needle_size'] = Projectneedle::where('project_id',$project[$i]->id)->select('needle_size')->get();
			
			$instruction1 = '<!DOCTYPE html><head></head><body>'.$pdf->content.'</body></html>';
            $doc = new \DOMDocument('1.0');
            @$doc->loadHTML($instruction1);
            $tags = $doc->getElementsByTagName('img');
            for ($k=0;$k<count($tags);$k++){
                $kCount = $k + 1;
                $old_src = $tags[$k]->getAttribute('src');
                $jsonArray[$i]['instruction_images'][$k]['image_tag'] = 'image'.$kCount;
                $jsonArray[$i]['instruction_images'][$k]['image_server_url'] = $old_src;
                $new_src_url = 'image'.$kCount;
                $tags[$k]->setAttribute('src', $new_src_url);
            }

            //$data['description'] = $doc->saveHTML();

			$jsonArray[$i]['instructions'] = [$doc->saveHTML()];
		  
            //$jsonArray[$i]['instructions'] = [$pdf->content];
			
			$generatedCount = ProjectGeneratedCount::where('project_id',$project[$i]->id)->count();
			if($generatedCount > 0){
				$jsonArray[$i]['showSuccessMsg'] = false;
			}else{
				$jsonArray[$i]['showSuccessMsg'] = true;
			}
			
        }

		$gcount = new ProjectGeneratedCount;
		$gcount->user_id = Auth::user()->id;
		$gcount->project_id = $check->id;
		$gcount->device = 'Mobile';
		$gcount->created_at = Carbon::now();
		$gcount->updated_at = Carbon::now();
		$gcount->save();
		
        $array = array('project' => $jsonArray);
        return $this->sendJsonData($array);
    }


    function get_project_notes(Request $request){
        $jsonArray = array();
        $id = $request->project_id;
        $notes = ProjectNotes::where('project_id',$id)->get();
        for ($i=0; $i < count($notes); $i++) {
            $jsonArray[$i]['id'] = $notes[$i]->id;
            $jsonArray[$i]['notes'] = $notes[$i]->notes;
            $jsonArray[$i]['completed'] = ($notes[$i]->status == 2) ? true : false;
            $jsonArray[$i]['created_at'] = $notes[$i]->created_at->diffForHumans();
            $jsonArray[$i]['updated_at'] = $notes[$i]->updated_at->diffForHumans();
        }
        $array = array('notes' => $jsonArray);
        return $this->sendJsonData($array);
    }

    function check_project_notes($id){
        $jsonArray = array();
        $notes = ProjectNotes::where('id',$id)->get();
        for ($i=0; $i < count($notes); $i++) {
            $jsonArray[$i]['id'] = $notes[$i]->id;
            $jsonArray[$i]['notes'] = $notes[$i]->notes;
            $jsonArray[$i]['completed'] = ($notes[$i]->status == 2) ? true : false;
            $jsonArray[$i]['created_at'] = $notes[$i]->created_at->diffForHumans();
            $jsonArray[$i]['updated_at'] = $notes[$i]->updated_at->diffForHumans();
        }
        $array = array('status' => 'success','notes' => $jsonArray);
        return $array;
    }

    function add_project_notes(Request $request){
        $notes = new ProjectNotes;
        $notes->user_id = Auth::user()->id;
        $notes->project_id = $request->project_id;
        $notes->notes = $request->notes;
        $notes->status = 1;
        $notes->ipaddress = $_SERVER['REMOTE_ADDR'];
        $save = $notes->save();
        if($save){
            $array = $this->check_project_notes($notes->id);
            return $this->sendJsonData($array);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function delete_project_notes(Request $request){
        $notes = ProjectNotes::find($request->id);
        $save = $notes->delete();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function delete_all_project_notes(Request $request){
        $check = ProjectNotes::where('user_id',Auth::user()->id)->where('project_id',$request->project_id)->count();
        if($check == 0){
            return response()->json(['status' => 'fail','message' => 'There are no notes to delete.']);
            exit;
        }
        $save = ProjectNotes::where('user_id',Auth::user()->id)->where('project_id',$request->project_id)->delete();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function mark_project_complete(Request $request){
        $notes = ProjectNotes::find($request->id);
        $notes->status = 2;
        $notes->completed_at = Carbon::now();
        $notes->ipaddress = $_SERVER['REMOTE_ADDR'];
        $save = $notes->save();
        if($save){
            $array = $this->check_project_notes($request->id);
            return $this->sendJsonData($array);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function project_image_library(Request $request){
        $jsonArray = array();
        $id = $request->id;
        $project = Project::where('id',$id)->get();
        for ($i=0; $i < count($project); $i++) {
            $jsonArray[$i]['name'] = $project[$i]->name;
            $jsonArray[$i]['reference_images'] = ProductReferenceImages::where('product_id',$project[$i]->product_id)->select('image as image_small')->get();
            $myimages = Projectimages::where('project_id',$project[$i]->id)->select('id','image_ext','image_path')->get();
			$myfirstImage = Projectimages::where('project_id',$project[$i]->id)->select('id','image_ext','image_path')->first();
			for($j=0;$j<count($myimages);$j++){
				if($project[$i]->pattern_type == 'custom' || $project[$i]->pattern_type == 'non-custom'){
					//if($j != 0){
						$jsonArray[$i]['my_images'][$j]['id'] = $myimages[$j]->id;
						$jsonArray[$i]['my_images'][$j]['image_ext'] = $myimages[$j]->image_ext;
						$jsonArray[$i]['my_images'][$j]['image_path'] = $myimages[$j]->image_path;
					//}
				}else{
					$jsonArray[$i]['my_images'][$j]['id'] = $myimages[$j]->id;
					$jsonArray[$i]['my_images'][$j]['image_ext'] = $myimages[$j]->image_ext;
					$jsonArray[$i]['my_images'][$j]['image_path'] = $myimages[$j]->image_path;
				}
			}
        }

        $array = array('project' => $jsonArray);
        return $this->sendJsonData($array);
    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }

    function project_image_upload(Request $request){
		//return response()->json(['status' => $request->all()]);
		//exit;
        $image = $request->file;
		$id = $request->project_id;
        if(!$id){
            return response()->json(['status' => 'fail','message' => 'Project id is not provided']);
            exit;
        }

        $path = array();

        for ($i=0; $i < count($image); $i++) {
        $path = $image[$i];

        $pro = new Projectimages;
        $pro->user_id = Auth::user()->id;
        $pro->project_id = $id;
        $pro->image_path = $image[$i];
        $pro->image_ext = '';
        $pro->created_at = Carbon::now();
        $pro->ipaddress = $_SERVER['REMOTE_ADDR'];
        $pu = $pro->save();

		}
       if($pu){
         return response()->json(['status' => 'success','my_images' => $path]);
     }else{
        return response()->json(['status' => 'error']);
     }

    }
	
	
	function delete_project_image(Request $request){
		$request->validate([
		'image_id' => 'required'
		]);
		$image = Projectimages::find($request->image_id);
		$save = $image->delete();
		if($save){
			return response()->json(['status' => 'success']);
		}else{
			return response()->json(['status' => 'error','message' => 'Unable to delete the project image.']);
		}
		
	}
	
	
	/* download project */

    function downloadPatternPDF(Request $request){
    	$user_id = base64_decode($request->get('user_id'));
    	if(!$user_id){
            return redirect('login');
        }

    	$id = $request->id;
        $slug = $request->slug;
        $project = Project::where('id', $id)->first();


     $instructions = DB::table('pattern_instructions')->where('user_id',$user_id)->where('project_id',$project->id)->first();
	 if($instructions){
	 $pdf = PDF::loadView('API.pdf', compact('instructions'));
	 return $pdf->download($project->name.'.pdf');
	 }else{
		 return response()->json(['error' => 'Unable to download file.This file may not belong to you.']);
	 }
	}
	

}
