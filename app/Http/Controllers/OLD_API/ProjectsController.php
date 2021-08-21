<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\ProjectsResource;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use App\Models\User;
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

class ProjectsController extends Controller
{

	function sendJsonData($data){
		return response()->json(['data' => $data]);
	}

	public function get_project_library(){

		$jsonArray = array();
		$jsonArray1 = array();
		$jsonArray2 = array();
		$jsonArray3 = array();

		$products = DB::table('booking_process')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.id as order_id','booking_process.created_at','products.id','products.product_name')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive', 0)
		->get();

		for ($i=0; $i < count($products); $i++) {
			$jsonArray[$i]['order_id'] = $products[$i]->order_id;
			$jsonArray[$i]['id'] = $products[$i]->id;
			$jsonArray[$i]['product_name'] = $products[$i]->product_name;
			$jsonArray[$i]['created_at'] = $products[$i]->created_at;
			$jsonArray[$i]['images'] = Product_images::where('product_id',$products[$i]->id)->select('image_medium')->first();
		}

		$data = array();

		$jsonArray1 = $this->get_generated_patterns();
		$jsonArray2 = $this->get_workinprogress_patterns();
		$jsonArray3 = $this->get_completed_patterns();

		$array = array('new_patterns' => $jsonArray,'generated_patterns' => $jsonArray1,'work_in_progress' => $jsonArray2,'completed' => $jsonArray3);
		return $this->sendJsonData($array);
	}

	function get_project_library_archive(){
			$jsonArray = array();
		$jsonArray1 = array();
		$jsonArray2 = array();
		$jsonArray3 = array();

		$products = DB::table('booking_process')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.id as order_id','booking_process.created_at','products.id','products.product_name')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive', 1)
		->get();

		for ($i=0; $i < count($products); $i++) {
			$jsonArray[$i]['order_id'] = $products[$i]->order_id;
			$jsonArray[$i]['id'] = $products[$i]->id;
			$jsonArray[$i]['product_name'] = $products[$i]->product_name;
			$jsonArray[$i]['created_at'] = $products[$i]->created_at;
			$jsonArray[$i]['images'] = Product_images::where('product_id',$products[$i]->id)->select('image_medium')->first();
		}

		$data = array();

		$jsonArray1 = $this->get_generated_patterns_archive();
		$jsonArray2 = $this->get_workinprogress_patterns_archive();
		$jsonArray3 = $this->get_completed_patterns_archive();

		$array = array('new_patterns' => $jsonArray,'generated_patterns' => $jsonArray1,'work_in_progress' => $jsonArray2,'completed' => $jsonArray3);
		return $this->sendJsonData($array);
	}


	function get_generated_patterns(){
		$jsonArray = array();

$jsonA = Auth::user()->projects()->where('status',1)->where('is_archive',0)->where('is_deleted',0)->select('id','name','pattern_type','created_at','updated_at','measurement_profile')->get();
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
	$jsonArray[$i]['image'] = Projectimages::where('project_id',$id)->select('image_path')->first();
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

		$winp = Auth::user()->projects()->where('status',2)->where('is_archive',0)->where('is_deleted',0)->select('id','name','pattern_type','created_at','updated_at','measurement_profile')->get();

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
	$jsonArray[$j]['image'] = Projectimages::where('project_id',$id)->select('image_path')->first();
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

		$comp = Auth::user()->projects()->where('status',3)->where('is_archive',0)->where('is_deleted',0)->select('id','name','pattern_type','created_at','updated_at')->get();

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
			$jsonArray[$k]['image'] = Projectimages::where('project_id',$id)->select('image_path')->first();
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
			$gp = Auth::user()->projects()->where('status',1)->where('is_archive',0)->where('is_deleted',0)->where('id',$request->id)->select('id','name','pattern_type','created_at','updated_at','measurement_profile')->orderBy('id','DESC')->get();
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
	$jsonArray['image'] = Projectimages::where('project_id',$id)->select('image_path')->first();
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
		$project->updated_at = Carbon::now();
		$save = $project->save();



		if($save){
			$winp = Auth::user()->projects()->where('status',2)->where('is_archive',0)->where('is_deleted',0)->where('id',$request->id)->select('id','name','pattern_type','created_at','updated_at','measurement_profile')->orderBy('id','DESC')->get();
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
	$jsonArray['image'] = Projectimages::where('project_id',$id)->select('image_path')->first();
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
			$com = Auth::user()->projects()->where('status',3)->where('is_archive',0)->where('is_deleted',0)->where('id',$request->id)->select('id','name','pattern_type','created_at','updated_at')->orderBy('id','DESC')->get();
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
			$jsonArray['image'] = Projectimages::where('project_id',$id)->select('image_path')->first();
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
		$request->validate([
			'order_id' => 'required'
		]);
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
		$request->validate([
			'order_id' => 'required'
		]);
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
	$jsonArray[$i]['image'] = Projectimages::where('project_id',$id)->select('image_path')->first();
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
	$jsonArray[$j]['image'] = Projectimages::where('project_id',$id)->select('image_path')->first();
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
			$jsonArray[$k]['image'] = Projectimages::where('project_id',$id)->select('image_path')->first();
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
				return response()->json(['success' => true]);
			}else{
				return response()->json(['error' => true,'message' => 'unable to delete project']);
			}
		}
	}


	/* create custom project */

	function available_products(Request $request){
		$jsonArray = array();
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
		$uom = $request->get('uom');

		$id = $request->id;
		$products = Products::where('id',$id)->take(1)->get();
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

		for ($m=1; $m <= 20; $m+= 0.25) {
			$jsonArray4[]['value'] = $m;
		}

		return $this->sendJsonData(['products' => $jsonArray,'measurements' => $jsonArray1,'needlesizes' => $jsonArray2,'gaugeconversion' => $gaugeconversion,'yarn_weight' => $yarn_weight,'ease' => $jsonArray4]);
	}

	function get_external_data(){
		$jsonArray1 = array();
		$jsonArray2 = array();
		$jsonArray3 = array();

		$needlesizes = NeedleSizes::all();
        $gaugeconversion = GaugeConversion::all();
        $measurements = Auth::user()->measurements;

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

		return $this->sendJsonData(['measurements' => $jsonArray1,'needlesizes' => $jsonArray2,'gaugeconversion' => $gaugeconversion]);
	}

	function create_custom_project(Request $request){
        $request->validate([
			'product_id' => 'required',
			'pattern_type' => 'required',
			'uom' => 'required',
			'stitch_gauge' => 'required',
			'row_gauge' => 'required',
			'measurement_profile' => 'required',
			'ease' => 'required'
		]);
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
		$project->pattern_type = $request->pattern_type;
		$project->uom = $request->uom;
		$project->stitch_gauge = $request->stitch_gauge;
		$project->row_gauge = $request->row_gauge;
		$project->measurement_profile = $request->measurement_profile;
		$project->ease = $request->ease;
		$project->status = 1;
		$project->created_at = Carbon::now();
		$project->ipaddress = $_SERVER['REMOTE_ADDR'];
		$save = $project->save();

		if($save){
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
		$project->pattern_type = $request->pattern_type;
		$project->uom = $request->uom;
		$project->stitch_gauge = $request->stitch_gauge;
		$project->row_gauge = $request->row_gauge;
		$project->measurement_profile = $request->measurement_profile;
		$project->ease = $request->ease;
		$project->status = 1;
		$project->created_at = Carbon::now();
		$project->ipaddress = $_SERVER['REMOTE_ADDR'];
		$save = $project->save();

		if($save){
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
		$project->pattern_type = $request->pattern_type;
		$project->uom = $request->uom;
		$project->stitch_gauge = $request->stitch_gauge;
		$project->row_gauge = $request->row_gauge;
		$project->measurement_profile = $request->measurement_profile;
		$project->ease = $request->ease;
		$project->user_verify = $request->user_verify;
		$project->status = 1;
		$project->created_at = Carbon::now();
		$project->ipaddress = $_SERVER['REMOTE_ADDR'];
		$save = $project->save();

		if($save){

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
                $jsonArray[$i]['gauge'] = GaugeConversion::where('id',$project[$i]->stitch_gauge)->select('stitch_gauge_inch as stitch_gauge','row_gauge_inch as row_gauge')->take(1)->get();

            }else{
                $jsonArray[$i]['gauge'] = GaugeConversion::where('id',$project[$i]->row_gauge)->select('stitches_10_cm as stitch_gauge','rows_10_cm as row_gauge')->take(1)->get();
            }

            $jsonArray[$i]['measurement_profile'] = UserMeasurements::where('id',$project[$i]->measurement_profile)->select('m_title')->take(1)->get();
            $jsonArray[$i]['yarn_details'] = Projectyarn::where('project_id',$project[$i]->id)->select('yarn_used','fiber_type','yarn_weight','colourway','dye_lot','skeins')->get();
            $jsonArray[$i]['ease'] = $project[$i]->ease;
            $jsonArray[$i]['verified'] = ($project[$i]->user_verify == 1) ? true : false;
            $jsonArray[$i]['images'] = Projectimages::where('project_id',$project[$i]->id)->select('image_path')->get();
        }

        $array = array('project' => $jsonArray);
        return $this->sendJsonData($array);
    }


    function generate_custom_pattern(Request $request){
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

            /* Adding  a file */

$path = storage_path($product->measurement_file);
$time = time().'-'.Auth::user()->id;
$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
$worksheet = $spreadsheet->getSheetByName('KnitVariables');

$rows = $worksheet->rangeToArray(
'B2:B26',     // The worksheet range that we want to retrieve
NULL,        // Value that should be returned for empty cells
TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
TRUE         // Should the array be indexed by cell row and cell column
);

$columns = DB::getSchemaBuilder()->getColumnListing('user_measurements');
$i=2;
foreach ($rows as $row) {
//echo $row['B']."<br>";

foreach ($columns as $key) {
   $key1 = strtoupper($key);
    if($row['B'] == $key1){
    //echo $row['B'].' - '.strtoupper($key).' - '.$i."<br>";
    $value = $measurements->$key;
    $worksheet->getCell("C".$i)->setValue($value);
    }
}


foreach ($array as $k => $val) {
    if($row['B'] == $k){
    // echo $row['B'].' -- '.$k."<br>";
    $worksheet->getCell("C".$i)->setValue($val);
    }
}

foreach ($array1 as $ky => $va) {
    if($row['B'] == $ky){
    // echo $row['B'].' -- '.$ky."<br>";
    $worksheet->getCell("C".$i)->setValue($va);
    }
}

$i++;
}
//exit;
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->setPreCalculateFormulas(true);
$save = $writer->save(storage_path('write'.$time.'.xlsx'));

/* Adding a file */

$filename = storage_path('write'.$time.'.xlsx');
$str = '';

        //$ss = DB::table('pattern_pdf')->where('product_id',58)->first();

$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);
//$worksheet = $spreadsheet->getActiveSheet();
$worksheet = $spreadsheet->getSheetByName('KnitVariables');

$rows = $worksheet->rangeToArray(
'B2:B150',     // The worksheet range that we want to retrieve
NULL,        // Value that should be returned for empty cells
TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
TRUE         // Should the array be indexed by cell row and cell column
);


$rows1 = $worksheet->rangeToArray(
'C2:C150',     // The worksheet range that we want to retrieve
NULL,        // Value that should be returned for empty cells
TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
TRUE         // Should the array be indexed by cell row and cell column
);

$pdf->content = str_replace('[[DESIGNER_STITCH_GAUGE]]',$stitchg,$pdf->content);
$pdf->content = str_replace('[[DESIGNER_ROW_GAUGE]]',$rowg,$pdf->content);
    $i=2;
foreach ($rows as $row) {
$pdf->content=str_replace('[['.$row['B'].']]',$rows1[$i]['C'],$pdf->content);
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
        unlink($filename);
        return $this->sendJsonData($array);
    }


    function generate_non_custom_pattern(Request $request){
        $id = $request->id;
        $check = Project::where('id',$id)->first();
        if($check->pattern_type != 'non-custom'){
            return response()->json(['success' => false,'message' => 'The product selected is not a non custom product.']);
            exit;
        }
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
                $jsonArray[$i]['gauge'] = GaugeConversion::where('id',$project[$i]->stitch_gauge)->select('stitch_gauge_inch as stitch_gauge','row_gauge_inch as row_gauge')->take(1)->get();

            }else{
                $jsonArray[$i]['gauge'] = GaugeConversion::where('id',$project[$i]->row_gauge)->select('stitches_10_cm as stitch_gauge','rows_10_cm as row_gauge')->take(1)->get();
            }

            $jsonArray[$i]['measurement_profile'] = UserMeasurements::where('id',$project[$i]->measurement_profile)->select('m_title')->take(1)->get();
            $jsonArray[$i]['ease'] = $project[$i]->ease;
            $jsonArray[$i]['yarn_details'] = Projectyarn::where('project_id',$project[$i]->id)->select('yarn_used','fiber_type','yarn_weight','colourway','dye_lot','skeins')->get();
            $jsonArray[$i]['needle_size'] = Projectneedle::where('project_id',$project[$i]->id)->select('needle_size')->get();
            $jsonArray[$i]['pdf_content'] = ProductPdf::where('product_id',$project[$i]->product_id)->select('content')->get();
        }

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
            $jsonArray[$i]['reference_images'] = Product_images::where('product_id',$project[$i]->product_id)->select('image_small')->get();
            $jsonArray[$i]['my_images'] = Projectimages::where('project_id',$project[$i]->id)->select('image_path')->get();
        }

        $array = array('project' => $jsonArray);
        return $this->sendJsonData($array);
    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }

    function project_image_upload(Request $request){
        $image = $request->file('file');
        $id = $request->project_id;
        if(!$id){
            return response()->json(['status' => 'fail','message' => 'Project id is not provided']);
            exit;
        }

        $path = array();

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

        $path[$i]['image_path'] = 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath;

        $path1 = 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath;

        $pro = new Projectimages;
        $pro->user_id = Auth::user()->id;
        $pro->project_id = $id;
        $pro->image_path = $path1;
        $pro->image_ext = $ext;
        $pro->created_at = Carbon::now();
        $pro->ipaddress = $_SERVER['REMOTE_ADDR'];
        $pro->save();

    }
       if($pu){
         return response()->json(['status' => 'success','my_images' => $path]);
     }else{
        return response()->json(['status' => 'error']);
     }

    }
	
	
	
	/* download project */

    function downloadPatternPDF(Request $request){
    	$user_id = base64_decode($request->get('user_id'));
    	if($user_id){
            Auth::loginUsingId($user_id, true);
            session(['user_id' => Auth::user()->id]);
        }else{
            return redirect('login');
        }

    	$id = $request->id;
        $slug = $request->slug;
        $project = Project::where('id', $id)->first();


        $upddate = array('updated_at' => Carbon::now());
        Project::where('id', $id)->update($upddate);

        $product = Products::where('id',$project->product_id)->first();

        if($project->uom == 'in' || $project->uom == 'inches'){
            $uom = 'in';
            $filename = $product->measurement_file.'_in.xlsx';
        }else{
            $uom = 'cm';
            $filename = $product->measurement_file.'_cm.xlsx';
        }

        if($product->designer_recommended_uom == 'in'){
            $designer_uom = 'inch';
        }else{
            $designer_uom = 'Centimeter';
        }

        //echo $filename;
        //exit;


        $project_images = $project->project_images;
        $project_yarn = $project->project_yarn;
        $project_needle = $project->project_needle()->leftJoin('needle_sizes','needle_sizes.id','projects_needle.needle_size')->select('needle_sizes.us_size','needle_sizes.mm_size','projects_needle.id as pnid')->get();
    $stitch_gauge = GaugeConversion::where('id',$project->stitch_gauge)->first();
    $row_gauge = GaugeConversion::where('id',$project->row_gauge)->first();

    $measurements = UserMeasurements::where('id',$project->measurement_profile)->first(['m_title as title','hips','waist','waist_front','bust','bust_front','bust_back','waist_to_underarm','armhole_depth','wrist_circumference',
'forearm_circumference','upperarm_circumference','shoulder_circumference','wrist_to_underarm','wrist_to_elbow','elbow_to_underarm',
'wrist_to_top_of_shoulder','depth_of_neck','neck_width','neck_circumference','neck_to_shoulder','shoulder_to_shoulder']);
    $project_notes = $project->project_notes;


    $pdm = ProjectsDesignerMeasurements::where('project_id',$project->id)->get();
    $pdf = ProductPdf::where('product_id',$project->product_id)->where('uom',$uom)->first();

    $array = array('TITLE' => $measurements->title);
    if($project->uom == 'in' || $project->uom == 'inches'){
        $array1 = array('STITCH_GAUGE' =>$stitch_gauge->stitch_gauge_inch,'ROW_GAUGE' => $row_gauge->row_gauge_inch,'EASE' => $project->ease,'NEEDLE_SIZE' => 3,"MEASUREMENT_PREF" => 'inches');
    }else{
        $array1 = array('STITCH_GAUGE_PER_10_CM' =>$stitch_gauge->stitches_10_cm,'ROW_GAUGE_PER_10_CM' => $row_gauge->rows_10_cm,'EASE' => $project->ease,'NEEDLE_SIZE' => 3,"MEASUREMENT_PREF" => "centimeters");
    }


    if($project->uom == 'in' || $project->uom == 'inches'){
        $dstitch = $product->recommended_stitch_gauge_in;
        $drow = $product->recommended_row_gauge_in;
        $designer_stitch_gauge = GaugeConversion::where('id',$dstitch)->first();
        $designer_row_gauge = GaugeConversion::where('id',$drow)->first();

    $stitchg = $designer_stitch_gauge->stitch_gauge_inch;
    $rowg = $designer_row_gauge->row_gauge_inch;

    }else{
        $dstitch = $product->recommended_stitch_gauge_cm;
        $drow = $product->recommended_row_gauge_cm;

        $designer_stitch_gauge = GaugeConversion::where('id',$dstitch)->first();
        $designer_row_gauge = GaugeConversion::where('id',$drow)->first();

        $stitchg = $designer_stitch_gauge->stitches_10_cm;
        $rowg = $designer_row_gauge->rows_10_cm;
    }

    /* Adding  a file */
            //$product->measurement_file
            $path = storage_path($filename); //$filename;
            //$url = Storage::url('Emily_s Sweater Variables.xlsx');
            $time = time().'-'.Auth::user()->id;

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $worksheet = $spreadsheet->getSheetByName('KnitVariables');

            $rows = $worksheet->rangeToArray(
                'B2:B29',     // The worksheet range that we want to retrieve
                NULL,        // Value that should be returned for empty cells
                TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
                TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
                TRUE         // Should the array be indexed by cell row and cell column
            );

    $columns = DB::getSchemaBuilder()->getColumnListing('user_measurements');

            $i=2;
            foreach ($rows as $row) {
                //echo $row['B']."<br>";

                foreach ($columns as $key) {
                   $key1 = strtoupper($key);
                    if($row['B'] == $key1){
                    //echo $row['B'].' - '.strtoupper($key).' - '.$i."<br>";
                    $value = $measurements->$key;
                    $worksheet->getCell("C".$i)->setValue($value);
                    }
                }


                foreach ($array as $k => $val) {
                    if($row['B'] == $k){
                    // echo $row['B'].' -- '.$k."<br>";
                    $worksheet->getCell("C".$i)->setValue($val);
                    }
                }

                //echo $row['B']."<br>";
                foreach ($array1 as $ky => $va) {
                    //echo $ky."<br>";
                    if($row['B'] == $ky){
                     //echo $row['B'].' -- '.$ky."<br>";
                    $worksheet->getCell("C".$i)->setValue($va);
                    }
                }

                foreach ($pdm as $pm => $mdp) {
                    $mname = strtoupper($mdp->measurement_name);
                    if($row['B'] == $mname){
                    //echo $mname.' -- '.$mdp->measurement_value."<br>";
                    $worksheet->getCell("C".$i)->setValue($mdp->measurement_value);
                    }
                }
                $i++;
            }
            //exit;
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->setPreCalculateFormulas(true);
            $save = $writer->save(storage_path('write'.$time.'.xlsx'));



    /* Adding a file */

    $filename = storage_path('write'.$time.'.xlsx');

            $str = '';

            //$ss = DB::table('pattern_pdf')->where('product_id',58)->first();

            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filename);
            //$worksheet = $spreadsheet->getActiveSheet();
            $worksheet = $spreadsheet->getSheetByName('KnitVariables');

            $rows = $worksheet->rangeToArray(
                'B2:B150',     // The worksheet range that we want to retrieve
                NULL,        // Value that should be returned for empty cells
                TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
                TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
                TRUE         // Should the array be indexed by cell row and cell column
            );


$rows1 = $worksheet->rangeToArray(
                'C2:C150',     // The worksheet range that we want to retrieve
                NULL,        // Value that should be returned for empty cells
                TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
                TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
                TRUE         // Should the array be indexed by cell row and cell column
            );

$pdf->content = str_replace('[[DESIGNER_STITCH_GAUGE]]',$stitchg,$pdf->content);
$pdf->content = str_replace('[[DESIGNER_ROW_GAUGE]]',$rowg,$pdf->content);
$pdf->content = str_replace('[[DESIGNERS_MEASUREMENT_PREFERENCE]]',$designer_uom,$pdf->content);
            $i=2;
    foreach ($rows as $row) {
    $pdf->content=str_replace('[['.$row['B'].']]',$rows1[$i]['C'],$pdf->content);
        $i++;
    }


    $cont = $pdf->content;
            //exit;
    unlink($filename);

    $pdf = PDF::loadView('API.pdf', compact('id','slug','project','project_images','project_yarn','project_needle','stitch_gauge','row_gauge','measurements','project_notes','product','pdf','pdm','filename','cont'));

    return $pdf->download('custom-pattern.pdf');
    }

}
