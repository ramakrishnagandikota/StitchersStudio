<?php

namespace App\Http\Controllers\Knitter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
use PDF;
use App\Models\Booking_process;
use COM;
use Log;
use App\Models\ProductReferenceImages;
use App\Models\SubscriptionLimits;

class ProjectController extends Controller
{
	function __construct(){
		$this->middleware('auth');
	}

    function home(){
		if(!Auth::user()->hasRole('Knitter')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
		if((Auth::user()->remainingDays() == 0) && (Auth::user()->isBasic() == true)){
			Auth::user()->subscription()->detach();
			Auth::user()->subscription()->attach(['1']);
        }
		
    	/*$orders = DB::table('booking_process')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.id','booking_process.created_at','products.id as pid','products.product_name')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive',0)
		->orderBy('booking_process.updated_at','DESC')
		->get(); */
		
		$orders = DB::table('orders')
		->leftJoin('booking_process', 'booking_process.order_id', 'orders.id')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.id','booking_process.created_at','products.id as pid','products.product_name','products.is_custom')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive', 0)
		->where('booking_process.show_product', 1)
		->where('orders.order_status', 'Success')
		->orderBy('orders.id','desc')
		->get();


		$generatedpatterns = Auth::user()->projects()->where('status',1)->where('is_archive',0)->where('is_deleted',0)->select('id as pid','name','token_key','pattern_type','measurement_profile','created_at','updated_at','product_id')->orderBy('updated_at','DESC')->get();

		$workinprogress = Auth::user()->projects()->where('status',2)->where('is_archive',0)->where('is_deleted',0)->select('id as pid','name','token_key','measurement_profile','pattern_type','created_at','updated_at','product_id')->orderBy('updated_at','DESC')->get();

		$completed = Auth::user()->projects()->where('status',3)->where('is_archive',0)->where('is_deleted',0)->select('id as pid','name','token_key','measurement_profile','pattern_type','created_at','updated_at','product_id')->orderBy('updated_at','DESC')->get();
		
		$projectsCount = Auth::user()->projects()->where('is_archive',0)->where('is_deleted',0)->count();
        $projectLimit = SubscriptionLimits::where('subscription_type','Free')->where('subscription_property','Projects')->first();
        
		
    	return view('knitter.projects.index',compact('orders','generatedpatterns','workinprogress','completed','projectsCount','projectLimit'));
    }

    function archive(){
		
		if((Auth::user()->remainingDays() == 0) && (Auth::user()->isBasic() == true)){
			Auth::user()->subscription()->detach();
			Auth::user()->subscription()->attach(['1']);
        }
		
    	$orders = DB::table('booking_process')
		->join('products', 'booking_process.product_id', '=', 'products.id')
		->select('booking_process.id','booking_process.created_at','products.id as pid','products.product_name','products.is_custom')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive',1)
        ->where('booking_process.show_product', 1)
		->orderBy('booking_process.updated_at','DESC')
		->get();

		$generatedpatterns = Auth::user()->projects()->where('status',1)->where('is_archive',1)->where('is_deleted',0)->select('id as pid','name','measurement_profile','token_key','pattern_type','created_at','updated_at')->orderBy('updated_at','DESC')->get();

		$workinprogress = Auth::user()->projects()->where('status',2)->where('is_archive',1)->where('is_deleted',0)->select('id as pid','name','token_key','measurement_profile','pattern_type','created_at','updated_at')->orderBy('updated_at','DESC')->get();

		$completed = Auth::user()->projects()->where('status',3)->where('is_archive',1)->where('is_deleted',0)->select('id as pid','name','token_key','measurement_profile','pattern_type','created_at','updated_at')->orderBy('updated_at','DESC')->get();

        $projectLimit = SubscriptionLimits::where('subscription_type','Free')->where('subscription_property','Projects')->first();

    	return view('knitter.projects.archive',compact('orders','generatedpatterns','workinprogress','completed','projectLimit'));
    }
	
	function getProjectInfo(Request $request){
        $id = $request->id;
        $project = Project::where('id',$id)->first();
        $stitch_gauge = GaugeConversion::where('id',$project->stitch_gauge)->first();
        $row_gauge = GaugeConversion::where('id',$project->row_gauge)->first();
        $measurements = UserMeasurements::where('id',$project->measurement_profile)->first();
        return view('knitter.projects.project-info',compact('project','stitch_gauge','row_gauge','measurements'));
    }

    function project_to_archive(Request $request){
    	$id = $request->id;
    	$project = Project::find($id);
    	$project->is_archive = 1;
    	$save = $project->save();
    	if($save){
    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
    }

    function project_to_library(Request $request){
    	$id = $request->id;
    	$project = Project::find($id);
    	$project->is_archive = 0;
    	$save = $project->save();
    	if($save){
    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
    }
	
	function order_to_archive(Request $request){
        $id = $request->id;
        $order = Booking_process::find($id);
        $order->is_archive = 1;
        $save = $order->save();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function order_to_library(Request $request){
        $id = $request->id;
        $order = Booking_process::find($id);
        $order->is_archive = 0;
        $save = $order->save();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function project_change_status(Request $request){
    	$id = $request->id;
    	$project = Project::find($id);
    	$project->status = $request->status;
    	$project->updated_at = Carbon::now();
    	$save = $project->save();
    	if($save){
    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
    }

    function create_project(Request $request){
		if((Auth::user()->remainingDays() == 0) && (Auth::user()->isBasic() == true)){
			Auth::user()->subscription()->detach();
			Auth::user()->subscription()->attach(['1']);
        }
		
    	$measurements = Auth::user()->measurements->count();
    	$needlesizes = NeedleSizes::all();
		$custom = DB::table('orders')
		->leftJoin('booking_process', 'booking_process.order_id', 'orders.id')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.id','booking_process.created_at','products.id as pid','products.product_name')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive', 0)
		->where('products.is_custom', 1)
		->where('orders.order_status', 'Success')
		->get();
        /*$custom = DB::table('booking_process')
        ->join('products', 'booking_process.product_id', '=', 'products.id')
        ->select('products.id as pid','products.product_name')
        ->where('booking_process.category_id', 1)
        ->where('products.is_custom', 1)
        ->where('booking_process.user_id', Auth::user()->id)
        ->get();*/
		
		$noncustom = DB::table('orders')
		->leftJoin('booking_process', 'booking_process.order_id', 'orders.id')
		->leftJoin('products', 'booking_process.product_id', 'products.id')
		->select('booking_process.id','booking_process.created_at','products.id as pid','products.product_name')
		->where('booking_process.category_id', 1)
		->where('booking_process.user_id', Auth::user()->id)
		->where('booking_process.is_archive', 0)
		->where('products.is_custom', 0)
		->where('orders.order_status', 'Success')
		->get();
		
        /*$noncustom = DB::table('booking_process')
        ->join('products', 'booking_process.product_id', '=', 'products.id')
        ->select('products.id as pid','products.product_name')
        ->where('booking_process.category_id', 1)
        ->where('products.is_custom', 0)
        ->where('booking_process.user_id', Auth::user()->id)
        ->get();*/
        $projects = Auth::user()->projects()->where('is_deleted',0)->count();
        $projectLimit = SubscriptionLimits::where('subscription_type','Free')->where('subscription_property','Projects')->first();
    	return view('knitter.projects.create-project',compact('measurements','needlesizes','custom','noncustom','projects','projectLimit'));
    }

    function delete_project(Request $request){
    	$id = $request->id;
    	$project = Project::find($id);
    	$project->is_deleted = 1;
    	$save = $project->save();
		if($project->pattern_type != 'external'){
            $check = Project::where('user_id',Auth::user()->id)->where('product_id',$project->product_id)->where('is_deleted',0)->count();
            if($check == 0){
                $bp= array('show_product' => 1);
            Booking_process::where('product_id',$project->product_id)->update($bp);
            }
		}
		
    	if($save){
    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
    }

    function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    function project_images(Request $request){
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
        $ext = 'jpg';
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

    function remove_project_image(Request $request){
    	//print_r($request->all());
    	//exit;
    }

    function project_external(Request $request){
    	$needlesizes = NeedleSizes::all();
    	$gaugeconversion = GaugeConversion::all();
    	$measurements = Auth::user()->measurements;
    	return view('knitter.projects.external',compact('needlesizes','gaugeconversion','measurements'));
    }

    function upload_project(Request $request){
    	//echo '<pre>';
    	//print_r($request->all());
    	//echo '</pre>';
    	//exit;

    	$projectsCount = Project::count();
    	$token = $projectsCount + 1;

    	$key = md5($token);
    	$slug = Str::slug($request->project_name,'-');

    	$project = new Project;
    	$project->token_key = $key;
    	$project->user_id = Auth::user()->id;
    	$project->product_id = 0;
    	$project->name = $request->project_name;
    	$project->description = $request->description;
    	$project->pattern_type = 'external';
    	$project->uom = $request->uom;
    	if($request->uom == 'cm'){
    		$project->stitch_gauge = $request->stitch_gauge_cm;
    		$project->row_gauge = $request->row_gauge_cm;
    	}else{
    		$project->stitch_gauge = $request->stitch_gauge_in;
    		$project->row_gauge = $request->row_gauge_in;
    	}
    	$project->measurement_profile = $request->measurement_profile;
    	if($request->uom == 'cm'){
    		$project->ease = $request->ease_cm;
    	}else{
    		$project->ease = $request->ease_in;
    	}
    	$project->user_verify = $request->user_verify;
        $project->status = 2;
    	$project->created_at = Carbon::now();
    	$project->updated_at = Carbon::now();
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

		if($request->image){
			for ($i=0; $i < count($request->image); $i++) {
				$pi = new Projectimages;
				$pi->user_id = Auth::user()->id;
				$pi->project_id = $project->id;
				$pi->image_path = $request->image[$i];
				$pi->image_ext = $request->ext[$i];
				$pi->created_at = Carbon::now();
				$pi->ipaddress = $_SERVER['REMOTE_ADDR'];
				$pi->save();
			}
		}

		if($request->yarn_used){
    		for ($j=0; $j < count($request->yarn_used); $j++) {
    			$py = new Projectyarn;
    			$py->user_id = Auth::user()->id;
    			$py->project_id = $project->id;
    			$py->yarn_used = $request->yarn_used[$j];
    			$py->fiber_type = $request->fiber_type[$j];
    			$py->yarn_weight = $request->yarn_weight[$j];
    			$py->colourway = $request->colourway[$j];
    			$py->dye_lot = $request->dye_lot[$j];
    			$py->skeins = $request->skeins[$j];
    			$py->created_at = Carbon::now();
    			$py->ipaddress = $_SERVER['REMOTE_ADDR'];
    			$py->save();
    		}
		}
		
		if($request->needle_size){
    		for ($k=0; $k < count($request->needle_size); $k++) {
    			$pn = new Projectneedle;
    			$pn->user_id = Auth::user()->id;
    			$pn->project_id = $project->id;
    			$pn->needle_size = $request->needle_size[$k];
    			$pn->created_at = Carbon::now();
    			$pn->ipaddress = $_SERVER['REMOTE_ADDR'];
    			$pn->save();
    		}
		}

    		return response()->json(['status' => 'success','key' => $key,'slug' => $slug]);
    	}else{
			return response()->json(['status' => 'fail']);
		}
    }

    function generate_external_pattern(Request $request){
    	$id = $request->id;
    	$slug = $request->slug;
        $project = Project::where('token_key', $id)->where('is_deleted',0)->first();
		
		if(!$project){
			return view('errors.no-measurement');
			exit;
		}

$upddate = array('updated_at' => Carbon::now());
Project::where('token_key', $id)->update($upddate);

    	$project_images = $project->project_images;
    	$project_yarn = $project->project_yarn;
    	$project_needle = $project->project_needle()->leftJoin('needle_sizes','needle_sizes.id','projects_needle.needle_size')->select('needle_sizes.us_size','needle_sizes.mm_size','projects_needle.id as pnid')->get();

    $stitch_gauge = GaugeConversion::where('id',$project->stitch_gauge)->first();
    $row_gauge = GaugeConversion::where('id',$project->row_gauge)->first();
    $measurements = UserMeasurements::where('id',$project->measurement_profile)->first();
    $project_notes = $project->project_notes;
    $product = Products::where('id',$project->product_id)->first();
    return view('knitter.projects.generate-external-pattern',compact('project','project_images','project_yarn','project_needle','stitch_gauge','row_gauge','measurements','project_notes','product'));
    }

    function project_notes_add(Request $request){
    	$notes = new ProjectNotes;
    	$notes->user_id = Auth::user()->id;
    	$notes->project_id = $request->project_id;
    	$notes->notes = $request->note;
    	$notes->created_at = Carbon::now();
    	$notes->status = 1;
    	$notes->ipaddress = $_SERVER['REMOTE_ADDR'];
    	$save = $notes->save();
    	if($save){
    		return response()->json(['status' => 'success','id' => $notes->id]);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
    }

    function project_notes_completed(Request $request){
    	$id = $request->id;
    	$check = ProjectNotes::where('id',$id)->first();
    	if($check->status == 1){
    		$notes = ProjectNotes::find($id);
    		$notes->status = 2;
    		$notes->completed_at = Carbon::now();
    		$save = $notes->save();
    	}else{
    		$notes = ProjectNotes::find($id);
    		$notes->status = 1;
    		$notes->completed_at = NULL;
    		$notes->updated_at = Carbon::now();
    		$save = $notes->save();
    	}

    	if($save){
    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
    }

    function project_notes_delete(Request $request){
    	$id = $request->id;
    	$notes = ProjectNotes::find($id);
    	$save = $notes->delete();
    	if($save){
    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
    }

    function project_notes_delete_all(Request $request){
    	$delete = ProjectNotes::where('project_id',$request->project_id)->delete();
    	if($delete){
    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
    }

    function upload_more_images(Request $request){
    	$id = $request->id;
    	$project = Project::where('token_key',$id)->first();
		$project_images = $project->project_images()->where('image_ext','jpg')->get();
		$product_images = ProductReferenceImages::where('product_id',$project->product_id)->get();
    	return view('knitter.projects.project-images',compact('project','project_images','product_images'));
    }

    function get_all_project_images(Request $request){
    	$id = $request->id;
    	$project = Project::where('token_key',$id)->first();

    $project_images = $project->project_images()->where('image_ext','jpg')->get();
    return response()->json(['images' => $project_images]);
    }

    function upload_project_images_own(Request $request){
    	$id = $request->id;

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
        $ext = 'jpg';
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

       	$path = 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath;
       	$pimages = new Projectimages;
       	$pimages->user_id = Auth::user()->id;
       	$pimages->project_id = $id;
       	$pimages->image_path = $path;
       	$pimages->image_ext = $ext;
       	$pimages->created_at = Carbon::now();
       	$pimages->ipaddress = $_SERVER['REMOTE_ADDR'];
       	$pimages->save();

         return response()->json(['path1' => $filepath, 'path' => 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath,'ext' => $ext]);
     }else{
        echo 'error';
     }
        }
    }


    /* custom pattern */

    function create_project_custom(Request $request){
        $id = $request->id;
        $product = Products::where('id',$id)->first();
        $needlesizes = NeedleSizes::all();
        $gaugeconversion = GaugeConversion::all();
        $measurements = Auth::user()->measurements;
        $orders = DB::table('booking_process')
        ->join('products', 'booking_process.product_id', '=', 'products.id')
        //->join('product_images', 'products.id', '=', 'product_images.product_id')
        ->select('products.id as pid','products.product_name')
        ->where('booking_process.category_id', 1)
        ->where('products.is_custom',1)
        ->where('booking_process.user_id', Auth::user()->id)
        ->get();
        $product_image = Product_images::where('product_id',$id)->first();
        $pmeasurements = ProductDesignerMeasurements::where('product_id',$id)->get();
        $projectLimit = SubscriptionLimits::where('subscription_type','Free')->where('subscription_property','Projects')->first();

        return view('knitter.projects.custom',compact('orders','product','needlesizes','gaugeconversion','measurements','product_image','pmeasurements','projectLimit'));
    }
	
	function getPatternSpecificvalues(Request $request){
        $pid = $request->pid;
        $uom = $request->uom;
        $pmeasurements = ProductDesignerMeasurements::where('product_id',$pid)->get();
        if($uom == 'in'){
            return view('knitter.projects.pattern-measurements.custom-pattern-in',compact('pmeasurements'));
        }else{
            return view('knitter.projects.pattern-measurements.custom-pattern-cm',compact('pmeasurements'));
        }
        
    }

    function create_project_noncustom(Request $request){
        $id = $request->id;
        $product = Products::where('id',$id)->first();
        $needlesizes = NeedleSizes::all();
        $gaugeconversion = GaugeConversion::all();
        $measurements = Auth::user()->measurements;
        $orders = DB::table('booking_process')
        ->join('products', 'booking_process.product_id', '=', 'products.id')
        //->join('product_images', 'products.id', '=', 'product_images.product_id')
        ->select('products.id as pid','products.product_name')
        ->where('booking_process.category_id', 1)
        ->where('products.is_custom',0)
        ->where('booking_process.user_id', Auth::user()->id)
        ->get();

        $product_image = Product_images::where('product_id',$id)->first();
        return view('knitter.projects.noncustom',compact('orders','product','needlesizes','gaugeconversion','measurements','product_image'));
    }

    function create_custom_project(Request $request){
        //print_r($request->all());
        //exit;
        $projectsCount = Project::count();
        $token = $projectsCount + 1;

        $key = md5($token);
        $slug = Str::slug($request->project_name,'-');

        $project = new Project;
        $project->token_key = $key;
        $project->user_id = Auth::user()->id;
        $project->product_id = $request->product_id;
        $project->name = $request->project_name;
        $project->description = $request->description;
        $project->pattern_type = $request->pattern_type;
        $project->uom = $request->uom;
        if($request->uom == 'cm'){
            $project->stitch_gauge = $request->stitch_gauge_cm;
            $project->row_gauge = $request->row_gauge_cm;
        }else{
            $project->stitch_gauge = $request->stitch_gauge_in;
            $project->row_gauge = $request->row_gauge_in;
        }
        $project->measurement_profile = $request->measurement_profile;
        if($request->uom == 'cm'){
            $project->ease = $request->ease_cm;
        }else{
            $project->ease = $request->ease_in;
        }
		 
		$project->product_shaped = $request->product_shaped ? $request->product_shaped : 0;
        $project->status = 2;
        $project->created_at = Carbon::now();
        $project->updated_at = Carbon::now();
        $save = $project->save();

        if($save){
			
			$bp= array('show_product' => 0);
			Booking_process::where('product_id',$request->product_id)->update($bp);

            if($request->image) {
                $pi = new Projectimages;
                $pi->user_id = Auth::user()->id;
                $pi->project_id = $project->id;
                $pi->image_path = $request->image;
                $pi->image_ext = 'jpg';
                $pi->created_at = Carbon::now();
                $pi->ipaddress = $_SERVER['REMOTE_ADDR'];
                $pi->save();
            }

			if($request->yarn_used){
				for ($j=0; $j < count($request->yarn_used); $j++) {
					$py = new Projectyarn;
					$py->user_id = Auth::user()->id;
					$py->project_id = $project->id;
					$py->yarn_used = $request->yarn_used[$j];
					$py->fiber_type = $request->fiber_type[$j];
					$py->yarn_weight = $request->yarn_weight[$j];
					$py->colourway = $request->colourway[$j];
					$py->dye_lot = $request->dye_lot[$j];
					$py->skeins = $request->skeins[$j];
					$py->created_at = Carbon::now();
					$py->ipaddress = $_SERVER['REMOTE_ADDR'];
					$py->save();
				}
			}

			if($request->needle_size){
				for ($k=0; $k < count($request->needle_size); $k++) {
					$pn = new Projectneedle;
					$pn->user_id = Auth::user()->id;
					$pn->project_id = $project->id;
					$pn->needle_size = $request->needle_size[$k];
					$pn->created_at = Carbon::now();
					$pn->ipaddress = $_SERVER['REMOTE_ADDR'];
					$pn->save();
				}
			}

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

            return response()->json(['status' => 'success','key' => $key,'slug' => $slug]);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function create_noncustom_project(Request $request){

        $slug = Str::slug($request->project_name,'-');

        $project = new Project;
        $project->user_id = Auth::user()->id;
        $project->product_id = $request->product_id;
        $project->name = $request->project_name;
        $project->description = $request->description;
        $project->pattern_type = $request->pattern_type;
        $project->uom = $request->uom;
        if($request->uom == 'cm'){
            $project->stitch_gauge = $request->stitch_gauge_cm;
            $project->row_gauge = $request->row_gauge_cm;
        }else{
            $project->stitch_gauge = $request->stitch_gauge_in;
            $project->row_gauge = $request->row_gauge_in;
        }
        $project->measurement_profile = $request->measurement_profile;
        if($request->uom == 'cm'){
            $project->ease = $request->ease_cm;
        }else{
            $project->ease = $request->ease_in;
        }

        $project->status = 2;
        $project->created_at = Carbon::now();
        $project->updated_at = Carbon::now();
        $save = $project->save();

        if($save){
			
			$bp= array('show_product' => 0);
			Booking_process::where('product_id',$request->product_id)->update($bp);
			
			$key = md5($project->id);
            $project1 = Project::find($project->id);
            $project1->token_key = $key;
            $project1->save();

            if($request->image) {
                $pi = new Projectimages;
                $pi->user_id = Auth::user()->id;
                $pi->project_id = $project->id;
                $pi->image_path = $request->image;
                $pi->image_ext = 'jpg';
                $pi->created_at = Carbon::now();
                $pi->ipaddress = $_SERVER['REMOTE_ADDR'];
                $pi->save();
            }

			if($request->yarn_used){
				for ($j=0; $j < count($request->yarn_used); $j++) {
					$py = new Projectyarn;
					$py->user_id = Auth::user()->id;
					$py->project_id = $project->id;
					$py->yarn_used = $request->yarn_used[$j];
					$py->fiber_type = $request->fiber_type[$j];
					$py->yarn_weight = $request->yarn_weight[$j];
					$py->colourway = $request->colourway[$j];
					$py->dye_lot = $request->dye_lot[$j];
					$py->skeins = $request->skeins[$j];
					$py->created_at = Carbon::now();
					$py->ipaddress = $_SERVER['REMOTE_ADDR'];
					$py->save();
				}
			}

			if($request->needle_size){
				for ($k=0; $k < count($request->needle_size); $k++) {
					$pn = new Projectneedle;
					$pn->user_id = Auth::user()->id;
					$pn->project_id = $project->id;
					$pn->needle_size = $request->needle_size[$k];
					$pn->created_at = Carbon::now();
					$pn->ipaddress = $_SERVER['REMOTE_ADDR'];
					$pn->save();
				}
			}

            return response()->json(['status' => 'success','key' => $key,'slug' => $slug]);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }
	
	
	function generate_noncustom_pattern(Request $request){
        $id = $request->id;
        $slug = $request->slug;
        $project = Project::where('token_key', $id)->where('is_deleted',0)->first();
		
		if(!$project){
			return view('errors.no-measurement');
			exit;
		}

        $upddate = array('updated_at' => Carbon::now());
        Project::where('id', $project->id)->update($upddate);
		
		

        $product = Products::where('id',$project->product_id)->first();
		

        $project_images = $project->project_images;
        $project_yarn = $project->project_yarn;
        $project_needle = $project->project_needle()->leftJoin('needle_sizes','needle_sizes.id','projects_needle.needle_size')->select('needle_sizes.us_size','needle_sizes.mm_size','projects_needle.id as pnid')->get();
        $stitch_gauge = GaugeConversion::where('id',$project->stitch_gauge)->first();
        $row_gauge = GaugeConversion::where('id',$project->row_gauge)->first();

        $measurements = UserMeasurements::where('id',$project->measurement_profile)->first(['m_title as title']);
        $project_notes = $project->project_notes;
		
		$instructions = ProductPdf::where('product_id',$project->product_id)->first();
		
		$instructionsCount = DB::table('pattern_instructions')->where('user_id',Auth::user()->id)->where('project_id',$project->id)->count();
		
		if($instructionsCount > 0){
			$cont = $instructions->content;
			$contents = array('content' => $cont,'updated_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
			DB::table('pattern_instructions')->where('user_id',Auth::user()->id)->where('project_id',$project->id)->update($contents);
		}else{
			$cont = $instructions->content;
			$contents = array('user_id' => Auth::user()->id,'project_id' => $project->id,'content' => $cont,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
			DB::table('pattern_instructions')->insert($contents);
		}
		
		$again = $request->get('again');
		
			if(!$again){
				if($instructionsCount > 0){
					$instruction = DB::table('pattern_instructions')->where('user_id',Auth::user()->id)->where('project_id',$project->id)->first();
					$cont = $instruction->content;
					if($request->get('type') == 'print'){	
						$cont = $instruction->content;
						try{
							$pdf = PDF::loadView('knitter.projects.generate-non-custom-pattern-pdf',compact('cont','project'));
							return $pdf->download($project->name.'.pdf');
							exit;
						}catch(\Throwable $e){
							
						}
						
					}
					return view('knitter.projects.generate-noncustom-pattern',compact('cont','project','project_images','project_yarn','project_needle','stitch_gauge','row_gauge','measurements','project_notes','product','instructions'));
					exit;
				}
			}
			
			
			
			if($request->type == 'print'){	
				$instruction = DB::table('pattern_instructions')->where('user_id',Auth::user()->id)->where('project_id',$project->id)->first();
				$cont = $instruction->content;
				$filename = '';
				try{
				$pdf = PDF::loadView('knitter.projects.generate-non-custom-pattern-pdf',compact(compact('cont','project')));
				return $pdf->download($project->name.'.pdf');
				//PDF::loadHTML($cont)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf')->stream(url('myfile.pdf'));
				//return url('myfile.pdf');
				exit;
				}catch(\Throwable $e){
					
				}
			}

        return view('knitter.projects.generate-noncustom-pattern',compact('project','project_images','project_yarn','project_needle','stitch_gauge','row_gauge','measurements','project_notes','product','instructions','cont'));
    }

    function generate_noncustom_pattern_old(Request $request){
        $id = $request->id;
        $slug = $request->slug;
        $project = Project::where('token_key', $id)->first();

        $upddate = array('updated_at' => Carbon::now());
		Project::where('token_key', $id)->update($upddate);

        $product = Products::where('id',$project->product_id)->first();

		if(!$product){
			return view('errors.no-measurement');
			exit;
		}

        $filename = storage_path($product->measurement_file);


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
    $pdf = ProductPdf::where('product_id',$project->product_id)->first();

    $array = array('TITLE' => $measurements->title);
    if($project->uom == 'in' || $project->uom == 'inches'){
        $array1 = array('STITCH_GAUGE' =>$stitch_gauge->stitch_gauge_inch,'ROW_GAUGE' => $row_gauge->row_gauge_inch,'EASE' => $project->ease,'NEEDLE_SIZE' => 3);
    }else{
        $array1 = array('STITCH_GAUGE' =>$stitch_gauge->stitches_10_cm,'ROW_GAUGE' => $row_gauge->rows_10_cm,'EASE' => $project->ease,'NEEDLE_SIZE' => 3);
    }



    if($product->designer_recommended_uom == 'in'){
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
            //$url = Storage::url('Emily_s Sweater Variables.xlsx');
            $time = Auth::user()->id;

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


    $cont = $pdf->content;
            //exit;
    unlink($filename);

    if($request->ajax()){
        PDF::loadHTML($cont)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf')->stream(url('myfile.pdf'));
        return url('myfile.pdf');
        exit;
    }

    return view('knitter.projects.generate-noncustom-pattern',compact('project','project_images','project_yarn','project_needle','stitch_gauge','row_gauge','measurements','project_notes','product','pdf','cont'));
    }

function generate_custom_pattern(Request $request){
        
        

        $id = $request->id;
        $slug = $request->slug;
        
		$check = Project::where('token_key', $id)->where('user_id',Auth::user()->id)->count();
		if($check == 0){
			return redirect('knitter/dashboard');
		}
		
		$project = Project::where('token_key', $id)->where('user_id',Auth::user()->id)->first();
		
		$varient = $request->get('varient');
		$again = $request->get('again');
		if(($again == 'yes') && ($varient != $project->product_shaped)){
			$array = array('product_shaped' => $varient);
			Project::where('id', $project->id)->update($array);
		}

		if($again == 'yes'){
			$array = array('project_sync' => 0,'updated_at' => Carbon::now());
			Project::where('id', $project->id)->update($array);
		}else{
			$upddate = array('updated_at' => Carbon::now());
        	Project::where('token_key', $id)->update($upddate);
		}

        $product = Products::where('id',$project->product_id)->first();

       /* if($project->uom == 'in' || $project->uom == 'inches'){
            $uom = 'in';
            $filename = $product->measurement_file.'_in.xlsx';
        }else{
            $uom = 'cm';
            $filename = $product->measurement_file.'_cm.xlsx';
        } */
		
		//echo $project->uom;
		
		if($project->uom == 'in' || $project->uom == 'inches'){
            $uom = 'in';
			if($project->product_shaped == 0){
				$filename = $product->measurement_file.'_in.xlsx';
			}else{
				$filename = $product->measurement_file.'-unshaped_in.xlsx';
			}
            
        }else{
            $uom = 'cm';
			if($project->product_shaped == 0){
				$filename = $product->measurement_file.'_cm.xlsx';
			}else{
				$filename = $product->measurement_file.'-unshaped_cm.xlsx';
			}
        }
		
		
		
		if(!file_exists(storage_path($filename))){
			return view('errors.no-measurement');
			exit;
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

	//print_r($measurements);
	//exit;
if(!$measurements){
	return view('errors.no-measurement');
	exit;
}

//echo $uom;

    $pdm = ProjectsDesignerMeasurements::where('project_id',$project->id)->get();
	$pdmNotused = DB::table('product_designer_measurements_notused')->where('product_id',$project->product_id)->get();
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
		
		if($designer_stitch_gauge){
			$stitchg = $designer_stitch_gauge->stitch_gauge_inch;
		}else{
			$stitchg = 0;
		}
		
		if($designer_stitch_gauge){
			$rowg = $designer_row_gauge->row_gauge_inch;
		}else{
			$rowg = 0;
		}
		
		

    }else{
        $dstitch = $product->recommended_stitch_gauge_cm;
        $drow = $product->recommended_row_gauge_cm;

        $designer_stitch_gauge = GaugeConversion::where('id',$dstitch)->first();
        $designer_row_gauge = GaugeConversion::where('id',$drow)->first();
		
		if($designer_stitch_gauge){
			$stitchg = $designer_stitch_gauge->stitches_10_cm;
		}else{
			$stitchg = 0;
		}
		
		if($designer_row_gauge){
			 $rowg = $designer_row_gauge->rows_10_cm;
		}else{
			 $rowg = 0;
		}
        
       
    }




    /* Adding  a file */
            //$product->measurement_file
             //$filename;
            //$url = Storage::url('Emily_s Sweater Variables.xlsx');
            

         /*   $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getSheetByName('KnitVariables');

            $rows = $worksheet->rangeToArray(
                'B2:B29',     // The worksheet range that we want to retrieve
                NULL,        // Value that should be returned for empty cells
                TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
                TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
                TRUE         // Should the array be indexed by cell row and cell column
            ); */

if($project->uom == 'in' || $project->uom == 'inches'){
    $rows = DB::table('pattern_measurements')->where('uom','in')->where('status',1)->get();
}else{
    $rows = DB::table('pattern_measurements')->where('status',1)->get();
}

$instructionCount = DB::table('pattern_instructions')->where('project_id',$project->id)->count();

$again = $request->get('again');

if(!$again){
	if($instructionCount > 0){
		$instruction = DB::table('pattern_instructions')->where('user_id',Auth::user()->id)->where('project_id',$project->id)->first();
		$cont = $instruction->content;
		$filename = '';
		
		if($request->type == 'print'){
			$pdf = PDF::loadView('knitter.projects.generate-custom-pattern-pdf',compact('id','slug','project','project_images','project_yarn','project_needle','stitch_gauge','row_gauge','measurements','project_notes','product','pdf','pdm','filename','cont'));
        //return $pdf->download('pattern.pdf');
        return $pdf->download('pattern.pdf');
			//PDF::loadHTML($cont)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf')->stream(url('myfile.pdf'));
			//return url('myfile.pdf');
			exit;
		}
		return view('knitter.projects.generate-custom-pattern',compact('id','slug','project','project_images','project_yarn','project_needle','stitch_gauge','row_gauge','measurements','project_notes','product','pdf','pdm','filename','cont'));
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
				
				
				
                $i++;
            }
			
	//echo $data;
//exit;	

            //exit;
$path = storage_path($filename);
$time = time().'-'.Auth::user()->id;
$targetPath = storage_path($time.'.Xlsx');

if($project->uom == 'in' || $project->uom == 'inches'){
$command = 'wscript.exe '.storage_path('new.vbs').' "C:\\laragon\\www\\web\\storage\\'.$filename.'" "C:\\laragon\\www\\web\\storage\\'.$time.'.Xlsx" '.$data; 
}else{
$command = 'wscript.exe '.storage_path('new_cm.vbs').' "C:\\laragon\\www\\web\\storage\\'.$filename.'" "C:\\laragon\\www\\web\\storage\\'.$time.'.Xlsx" '.$data; 
}
//echo $command;
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
/* command to run shell script for load excel*/ 
//sleep(3); */

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
$pdf->content = str_replace('[[DESIGNERS_MEASUREMENT_PREFERENCE]]',$designer_uom,$pdf->content);
//echo '<pre>';
            $i=2;
    foreach ($rows as $row) {
       // echo $row['B'].' = '.$rows1[$i]['M']."<br>";
    $pdf->content=str_replace('[['.$row['B'].']]',$rows1[$i]['M'],$pdf->content);
        $i++;
    }
//echo '</pre>';
//exit;

    $cont = $pdf->content;
	
if($instructionCount > 0){
	$contents = array('content' => $cont,'updated_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
	DB::table('pattern_instructions')->where('user_id',Auth::user()->id)->where('project_id',$project->id)->update($contents);
}else{
	
$contents = array('user_id' => Auth::user()->id,'project_id' => $project->id,'content' => $cont,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
DB::table('pattern_instructions')->insert($contents);
}
            //exit;
    unlink($targetPath);

    if($request->type == 'print'){
		$pdf = PDF::loadView('knitter.projects.generate-custom-pattern',compact('id','slug','project','project_images','project_yarn','project_needle','stitch_gauge','row_gauge','measurements','project_notes','product','pdf','pdm','filename','cont'));
        return $pdf->download($project->name.'.pdf');
        //PDF::loadHTML($cont)->setPaper('a4', 'landscape')->setWarnings(false)->save('myfile.pdf')->stream(url('myfile.pdf'));
        //return url('myfile.pdf');
        exit;
    }

    

    return view('knitter.projects.generate-custom-pattern',compact('id','slug','project','project_images','project_yarn','project_needle','stitch_gauge','row_gauge','measurements','project_notes','product','pdf','pdm','filename','cont'));
    }
	
	function checkMeasurementUOM(Request $request){
        $id = $request->m_id;

        $check = UserMeasurements::where('id',$id)->first();

        if($check){
            if($check->measurement_preference == 'inches'){
                $uom = 'in';
            }else{
                $uom = 'cm';
            }
            return response()->json(['status' => 0,'uom' => $uom,'uom_full' => $check->measurement_preference]);
        }else{
            return response()->json(['status' => 1,'error' => 'The measurement profile selected does not exists.']);
        }
    }
	
	
	    /* project library new routes */

    function show_custom_project_page(Request $request){
        $id = base64_decode($request->pid);
        $type = $request->type;
        $product = Products::where('id',$id)->first();
        $needlesizes = NeedleSizes::all();
        $gaugeconversion = GaugeConversion::all();
        $measurements = Auth::user()->measurements;
        $measurementsCount = Auth::user()->measurements()->count();

        $product_image = Product_images::where('product_id',$id)->first();
        $pmeasurements = ProductDesignerMeasurements::where('product_id',$id)->get();
        $projects = Auth::user()->projects()->where('is_deleted',0)->count();
        $projectLimit = SubscriptionLimits::where('subscription_type','Free')->where('subscription_property','Projects')->first();
        $measurementsLimit = SubscriptionLimits::where('subscription_type','Free')->where('subscription_property','Projects')->first();

        if($type == 'custom'){
            $orders = DB::table('booking_process')
                ->join('products', 'booking_process.product_id', '=', 'products.id')
                //->join('product_images', 'products.id', '=', 'product_images.product_id')
                ->select('products.id as pid','products.product_name')
                ->where('booking_process.category_id', 1)
                ->where('products.is_custom',1)
                ->where('booking_process.user_id', Auth::user()->id)
                ->get();

            return view('knitter.projects.custom.index',compact('orders','product','needlesizes','gaugeconversion','measurements','product_image','pmeasurements','projects','measurementsCount','projectLimit','measurementsLimit'));
        }else if($type == 'traditional'){
            $orders = DB::table('booking_process')
                ->join('products', 'booking_process.product_id', '=', 'products.id')
                //->join('product_images', 'products.id', '=', 'product_images.product_id')
                ->select('products.id as pid','products.product_name')
                ->where('booking_process.category_id', 1)
                ->where('products.is_custom',0)
                ->where('booking_process.user_id', Auth::user()->id)
                ->get();
            return view('knitter.projects.custom.traditional',compact('orders','product','needlesizes',
                'gaugeconversion','measurements','product_image','pmeasurements','projects','measurementsCount','projectLimit','measurementsLimit'));
        }else{
            return view('knitter.projects.custom.external',compact('product','needlesizes',
                'gaugeconversion','measurements','product_image','pmeasurements','projects','measurementsCount','projectLimit','measurementsLimit'));
        }
    }

}
