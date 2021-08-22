<?php

namespace App\Http\Controllers\AdminNew;

use App\Http\Controllers\Controller;
use App\Models\GaugeConversion;
use App\Models\MasterList;
use App\Models\NeedleSizes;
use App\Models\PatternImage;
use App\Models\PatternInstruction;
use App\Models\PatternNeedles;
use App\Models\PatternWorkStatus;
use App\Models\YarnRecommendationImages;
use App\Models\YarnRecommendations;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Str;
use Laravolt\Avatar\Facade as Avatar;
use Carbon\Carbon;
use DB;
use App\User;
use App\Models\Pattern;
use Image;

class ProductsController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    public function products_list(){
        $patterns = Pattern::leftJoin('users','users.id','p_patterns.user_id')
                    ->select('p_patterns.*','users.first_name','users.last_name')
                    ->where('pattern_type','traditional')
                    ->latest()->get();
        return view('adminnew.Products.index',compact('patterns'));
    }

    public function add_pattern(Request $request){
        $pattern_type = $request->pattern_type;
        $productsCount = Pattern::orderBy('id','desc')->count();
        $pcount = $productsCount + 1;
        $garmentConstruction = MasterList::where('type','garment_construction')->get();
        $garmentType = MasterList::where('type','garment_type')->get();
        $materialNeeded = MasterList::where('type','material_needed')->get();
        $designElements = MasterList::where('type','design_elements')->get();
        $shoulderConstruction = MasterList::where('type','shoulder_construction')->get();
        $designers = MasterList::where('type','designers')->get();
        $yarnWeight = MasterList::where('type','yarn_weight')->get();
        $needlesizes = NeedleSizes::all();
        $gaugeconversion = GaugeConversion::all();

        if($pattern_type == 'custom'){
            $message = 'New admin panel will not support '.$pattern_type.' pattern creation.';
            return view('adminnew.notfound',compact('message'));
        }else if($pattern_type == 'traditional'){
            return view('adminnew.Products.traditional',compact('garmentConstruction','pcount','materialNeeded','designElements','shoulderConstruction','designers','yarnWeight','needlesizes','gaugeconversion','garmentType'));
        }else{
            $message = 'New admin panel will not support '.$pattern_type.' pattern creation.';
            return view('adminnew.notfound',compact('message'));
        }
    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-.]/', '', $string); // Removes special chars.
    }

    function upload_admin_pattern_images(Request $request){
        $image = $request->file('product_images');

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

    function upload_admin_recomondation_images(Request $request){
        $image = $request->file('yarn_image');

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

    function upload_admin_pattern_instructions(Request $request){
        $image = $request->file('product_instructions');

        for ($i=0; $i < count($image); $i++) {
            $oname = $this->clean($image[$i]->getClientOriginalName());
            $filename = time().'-'.$oname;
            $ext = $image[$i]->getClientOriginalExtension();

            $s3 = \Storage::disk('s3');
            $filepath = 'knitfit/'.$filename;
            $pu = $s3->put('/'.$filepath, file_get_contents($image[$i]),'public');


            if($pu){
                return response()->json(['path1' => $filepath, 'path' => 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath,'ext' => $ext]);
            }else{
                echo 'error';
            }
        }
    }


    function add_traditional_pattern(Request $request){
        $request->validate([
            'sku' => 'required|alpha_num',
            'pattern_go_live_date' => 'required',
            'status' => 'required',
            'name' => 'required|regex:/^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/',
            'designer_name' => 'required|regex:/^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/',
            'skill_level' => 'required',
            'pattern_description' => 'required',
            'short_description' => 'required',
            'gauge_description' => 'required',
            'material_needed' => 'required',
            'design_elements' => 'required',
            'garment_construction' => 'required',
            'garment_type' => 'required',
            'shoulder_construction' => 'required',
            'stitch_gauge_in' => 'required',
            'row_gauge_in' => 'required',
            'ease_in' => 'required',
            'stitch_gauge_cm' => 'required',
            'row_gauge_cm' => 'required',
            'ease_cm' => 'required',
            'pattern_image' => 'required',
            'pattern_ext' => 'required',
            'product_price' => 'required'
        ]);

        try{

            $productsCount = Pattern::orderBy('id','desc')->count();
            $pcount = $productsCount + 1;

            $designerCount = MasterList::where('type','designers')->where('name',$request->designer_name)->count();

            if($designerCount > 0){
                $designer = MasterList::where('type','designers')->where('name',$request->designer_name)->first();
            }else{
                $designer = new MasterList;
                $designer->user_id = Auth::user()->id;
                $designer->type = 'designers';
                $designer->name = $request->designer_name;
                $designer->slug = Str::slug($request->designer_name);
                $designer->created_at = Carbon::now();
                $designer->save();
            }



            if($request->shoulder_construction){
                $shoulder_construction = implode(',',$request->shoulder_construction);
            }else{
                $shoulder_construction = '';
            }

            if($request->design_elements){
                $design_elements = implode(',',$request->design_elements);
            }else{
                $design_elements = '';
            }

            if($request->garment_construction){
                $garment_construction = implode(',',$request->garment_construction);
            }else{
                $garment_construction = '';
            }

            if($request->garment_type){
                $garment_type = implode(',',$request->garment_type);
            }else{
                $garment_type = '';
            }

            $pattern = new Pattern;
            $pattern->pid = md5($pcount);
            $pattern->user_id = Auth::user()->id;
            $pattern->sku = $request->sku;
            $pattern->pattern_go_live_date = date('Y-m-d',strtotime($request->pattern_go_live_date));
            $pattern->status = $request->status;
            $pattern->name = $request->name;
            $pattern->slug = Str::slug($request->name);
            $pattern->pattern_type = $request->pattern_type;
            $pattern->designer_name = $designer->id;
            $pattern->brand_name = $request->brand_name;
            $pattern->skill_level = $request->skill_level;
            $pattern->pattern_description = $request->pattern_description;
            $pattern->short_description = $request->short_description;
            $pattern->gauge_description = $request->gauge_description;
            $pattern->material_needed = $request->material_needed;
            $pattern->design_elements = $design_elements;
            $pattern->construction_technique = $garment_construction;
            $pattern->garment_type = $garment_type;
            $pattern->shoulder_construction = $shoulder_construction;
            $pattern->stitch_gauge_in = $request->stitch_gauge_in;
            $pattern->row_gauge_in = $request->row_gauge_in;
            $pattern->ease_in = $request->ease_in;
            $pattern->stitch_gauge_cm = $request->stitch_gauge_cm;
            $pattern->row_gauge_cm = $request->row_gauge_cm;
            $pattern->ease_cm = $request->ease_cm;
            $pattern->product_price = $request->product_price;
            $pattern->sale_price = $request->sale_price;
            $pattern->sale_price_start_date = $request->sale_price_start_date;
            $pattern->sale_price_end_date = $request->sale_price_end_date;
            /*$pattern->template_id = decrypt($request->template_id);*/
            $pattern->save();

            $st = array(1,2);

            for($s=0;$s<count($st);$s++){
                $wstatus = new PatternWorkStatus;
                $wstatus->user_id = Auth::user()->id;
                $wstatus->pattern_id = $pattern->id;
                $wstatus->w_status = $st[$s];
                if($st[$s] == 1){
                    $wstatus->w_date = Carbon::now();
                }
                if($st[$s] == 2){
                    $wstatus->w_date = Carbon::now();
                }
                $wstatus->created_at = Carbon::now();
                $wstatus->save();
            }


            if($request->pattern_image){
                for($i=0;$i<count($request->pattern_image);$i++){
                    $image = new PatternImage;
                    $image->user_id = Auth::user()->id;
                    $image->pattern_id = $pattern->id;
                    $image->image_small = $request->pattern_image[$i];
                    $image->image_medium = $request->pattern_image[$i];
                    $image->image_large = $request->pattern_image[$i];
                    $image->image_ext = $request->pattern_ext[$i];
                    $image->created_at = Carbon::now();
                    $image->save();
                }
            }


            if($request->yarn_company){
                for ($j=0;$j<count($request->yarn_company);$j++){
                    $yarn = new YarnRecommendations;
                    $yarn->user_id = Auth::user()->id;
                    $yarn->pattern_id = $pattern->id;
                    $yarn->yarn_company = $request->yarn_company[$j];
                    $yarn->yarn_name = $request->yarn_name[$j];
                    $yarn->fiber_type = $request->fiber_type[$j];
                    $yarn->yarn_weight = $request->yarn_weight[$j];
                    $yarn->yarn_url = $request->yarn_url[$j];
                    $yarn->coupon_code = $request->coupon_code[$j];
                    $yarn->created_at = Carbon::now();
                    $yarn->save();

                    if(isset($request->image[$j])) {

                        $image = $request->image[$j];
                        $ext = $request->ext[$j];

                        for ($k = 0; $k < count($image); $k++) {
                            $yimage = new YarnRecommendationImages;
                            $yimage->user_id = Auth::user()->id;
                            $yimage->pattern_id = $pattern->id;
                            $yimage->p_pattern_yarn_recommendation_id = $yarn->id;
                            $yimage->yarn_image = $image[$k];
                            $yimage->yarn_ext = $ext[$k];
                            $yimage->created_at = Carbon::now();
                            $yimage->save();
                        }
                    }
                }
            }

            if($request->needle_size){
                for ($l=0;$l<count($request->needle_size);$l++){
                    $needles = new PatternNeedles;
                    $needles->user_id = Auth::user()->id;
                    $needles->pattern_id = $pattern->id;
                    $needles->needle_size = $request->needle_size[$l];
                    $needles->created_at = Carbon::now();
                    $needles->save();
                }
            }

            if($request->image_instructions){
                for ($m=0;$m<count($request->image_instructions);$m++){
                    $instruction = new PatternInstruction;
                    $instruction->user_id = Auth::user()->id;
                    $instruction->pattern_id = $pattern->id;
                    $instruction->instructions_file = $request->image_instructions[$m];
                    $instruction->type = $request->instructions_ext[$m];
                    $instruction->created_at = Carbon::now();
                    $instruction->save();
                }
            }

            if($request->submit_type == 'save'){
                $url = url('adminnew/products');
            }else{
                $url = url('adminnew/products');
            }
            return response()->json(['status' => 'success','url' => $url]);
        }catch(\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    public function edit_pattern(Request $request){
        $id = $request->id;
        try{
            $pattern = Pattern::where('pid',$id)->first();
            $garmentType = MasterList::where('type','garment_type')->get();
            $materialNeeded = MasterList::where('type','material_needed')->get();
            $designElements = MasterList::where('type','design_elements')->get();
            $shoulderConstruction = MasterList::where('type','shoulder_construction')->get();
            $designers = MasterList::where('type','designers')->get();
            $yarnWeight = MasterList::where('type','yarn_weight')->get();
            $needlesizes = NeedleSizes::all();
            $gaugeconversion = GaugeConversion::all();
            $designer = MasterList::where('id',$pattern->designer_name)->first();
            return view('adminnew.Products.edit-traditional',compact('pattern','materialNeeded','designElements','shoulderConstruction',
                'designers','yarnWeight','needlesizes','gaugeconversion','garmentType','designer'));
        }catch (\Throwable $e){
            dd($e->getMessage());
        }
    }

    function update_traditional_pattern(Request $request){


        $request->validate([
            'pattern_go_live_date' => 'required',
            'status' => 'required',
            'name' => 'required|regex:/^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/',
            'designer_name' => 'required|regex:/^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/',
            'skill_level' => 'required',
            'pattern_description' => 'required',
            'short_description' => 'required',
            'gauge_description' => 'required',
            'material_needed' => 'required',
            'design_elements' => 'required',
            'garment_construction' => 'required',
            'garment_type' => 'required',
            'shoulder_construction' => 'required',
            'stitch_gauge_in' => 'required',
            'row_gauge_in' => 'required',
            'ease_in' => 'required',
            'stitch_gauge_cm' => 'required',
            'row_gauge_cm' => 'required',
            'ease_cm' => 'required',
            'product_price' => 'required',
        ]);

        try{

            $productsCount = Pattern::orderBy('id','desc')->count();
            $pcount = $productsCount + 1;

            $designerCount = MasterList::where('type','designers')->where('name',$request->designer_name)->count();

            if($designerCount > 0){
                $designer = MasterList::where('type','designers')->where('name',$request->designer_name)->first();
            }else{
                $designer = new MasterList;
                $designer->user_id = Auth::user()->id;
                $designer->type = 'designers';
                $designer->name = $request->designer_name;
                $designer->slug = Str::slug($request->designer_name);
                $designer->created_at = Carbon::now();
                $designer->save();
            }



            if($request->shoulder_construction){
                $shoulder_construction = implode(',',$request->shoulder_construction);
            }else{
                $shoulder_construction = '';
            }

            if($request->design_elements){
                $design_elements = implode(',',$request->design_elements);
            }else{
                $design_elements = '';
            }

            if($request->garment_construction){
                $garment_construction = implode(',',$request->garment_construction);
            }else{
                $garment_construction = '';
            }

            if($request->garment_type){
                $garment_type = implode(',',$request->garment_type);
            }else{
                $garment_type = '';
            }

            $pattern_id = decrypt($request->pattern_id);
            $pattern = Pattern::find($pattern_id);
            $pattern->pattern_go_live_date = date('Y-m-d',strtotime($request->pattern_go_live_date));
            $pattern->status = $request->status;
            $pattern->name = $request->name;
            $pattern->slug = Str::slug($request->name);
            $pattern->designer_name = $designer->id;
            $pattern->brand_name = $request->brand_name;
            $pattern->skill_level = $request->skill_level;
            $pattern->pattern_description = $request->pattern_description;
            $pattern->short_description = $request->short_description;
            $pattern->gauge_description = $request->gauge_description;
            $pattern->material_needed = $request->material_needed;
            $pattern->design_elements = $design_elements;
            $pattern->construction_technique = $garment_construction;
            $pattern->garment_type = $garment_type;
            $pattern->shoulder_construction = $shoulder_construction;
            $pattern->stitch_gauge_in = $request->stitch_gauge_in;
            $pattern->row_gauge_in = $request->row_gauge_in;
            $pattern->ease_in = $request->ease_in;
            $pattern->stitch_gauge_cm = $request->stitch_gauge_cm;
            $pattern->row_gauge_cm = $request->row_gauge_cm;
            $pattern->ease_cm = $request->ease_cm;
            $pattern->product_price = $request->product_price;
            $pattern->sale_price = $request->sale_price;
            $pattern->sale_price_start_date = $request->sale_price_start_date;
            $pattern->sale_price_end_date = $request->sale_price_end_date;
            $pattern->updated_at = Carbon::now();
            $pattern->save();


            if($request->pattern_image){
                for($i=0;$i<count($request->pattern_image);$i++){
                    $image = new PatternImage;
                    $image->user_id = Auth::user()->id;
                    $image->pattern_id = $pattern->id;
                    $image->image_small = $request->pattern_image[$i];
                    $image->image_medium = $request->pattern_image[$i];
                    $image->image_large = $request->pattern_image[$i];
                    $image->image_ext = $request->pattern_ext[$i];
                    $image->created_at = Carbon::now();
                    $image->save();
                }
            }


            if($request->yarn_company){
                for ($j=0;$j<count($request->yarn_company);$j++){
                    if ($request->p_pattern_yarn_recommendations_id[$j] == 0) {
                        $yarn = new YarnRecommendations;
                        $yarn->user_id = Auth::user()->id;
                        $yarn->pattern_id = $pattern->id;
                        $yarn->yarn_company = $request->yarn_company[$j];
                        $yarn->yarn_name = $request->yarn_name[$j];
                        $yarn->fiber_type = $request->fiber_type[$j];
                        $yarn->yarn_weight = $request->yarn_weight[$j];
                        $yarn->yarn_url = $request->yarn_url[$j];
                        $yarn->coupon_code = $request->coupon_code[$j];
                        $yarn->created_at = Carbon::now();
                        $yarn->save();
                    }else{
                        $yarn = YarnRecommendations::find($request->p_pattern_yarn_recommendations_id[$j]);
                        $yarn->yarn_company = $request->yarn_company[$j];
                        $yarn->yarn_name = $request->yarn_name[$j];
                        $yarn->fiber_type = $request->fiber_type[$j];
                        $yarn->yarn_weight = $request->yarn_weight[$j];
                        $yarn->yarn_url = $request->yarn_url[$j];
                        $yarn->coupon_code = $request->coupon_code[$j];
                        $yarn->updated_at = Carbon::now();
                        $yarn->save();
                    }

                    if(isset($request->image[$j])) {

                        $image = $request->image[$j];
                        $ext = $request->ext[$j];

                        for ($k = 0; $k < count($image); $k++) {
                            $yimage = new YarnRecommendationImages;
                            $yimage->user_id = Auth::user()->id;
                            $yimage->pattern_id = $pattern->id;
                            $yimage->p_pattern_yarn_recommendation_id = $yarn->id;
                            $yimage->yarn_image = $image[$k];
                            $yimage->yarn_ext = $ext[$k];
                            $yimage->created_at = Carbon::now();
                            $yimage->save();
                        }
                    }
                }
            }

            if($request->needle_size){
                for ($l=0;$l<count($request->needle_size);$l++){
                    if($request->needle_size_id[$l] == 0) {
                        $needles = new PatternNeedles;
                        $needles->user_id = Auth::user()->id;
                        $needles->pattern_id = $pattern->id;
                        $needles->needle_size = $request->needle_size[$l];
                        $needles->created_at = Carbon::now();
                        $needles->save();
                    }else{
                        $needles = PatternNeedles::find($request->needle_size_id[$l]);
                        $needles->needle_size = $request->needle_size[$l];
                        $needles->updated_at = Carbon::now();
                        $needles->save();
                    }
                }
            }

            if($request->image_instructions){
                for ($m=0;$m<count($request->image_instructions);$m++){
                    $instruction = new PatternInstruction;
                    $instruction->user_id = Auth::user()->id;
                    $instruction->pattern_id = $pattern->id;
                    $instruction->instructions_file = $request->image_instructions[$m];
                    $instruction->type = $request->instructions_ext[$m];
                    $instruction->created_at = Carbon::now();
                    $instruction->save();
                }
            }

            if($request->submit_type == 'save'){
                $url = url('adminnew/products');
            }else{
                $url = url('adminnew/products');
            }
            return response()->json(['status' => 'success','url' => $url]);
        }catch(\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function deleteYarnRecommmendations(Request $request){
        $id = $request->id;
        $yarn = YarnRecommendations::find($id);
        $deleted = $yarn->delete();

        if($deleted){
            YarnRecommendationImages::where('p_pattern_yarn_recommendation_id',$id)->delete();
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete , Try again after some time.']);
        }
    }

    function deleteYarnRecommmendationsImages(Request $request){
        $id = $request->id;
        $yarn = YarnRecommendationImages::find($id);
        $deleted = $yarn->delete();

        if($deleted){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete , Try again after some time.']);
        }
    }

    function deletePatternImages(Request $request){
        $id = $request->id;
        $image = PatternImage::find($id);
        $deleted = $image->delete();

        if($deleted){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete , Try again after some time.']);
        }
    }

    function deleteNeedles(Request $request){
        $id = $request->id;
        $needles = PatternNeedles::find($id);
        $deleted = $needles->delete();

        if($deleted){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete , Try again after some time.']);
        }
    }

    function make_image_default(Request $request){
        $id = $request->id;
        $pattern_id = decrypt($request->pattern_id);
        $check = PatternImage::where('pattern_id',$pattern_id)->where('main_photo',1)->count();

        if($check > 0){
            $array = array('main_photo' => 0);
            PatternImage::where('pattern_id',$pattern_id)->update($array);
        }

        $image = PatternImage::find($id);
        $image->main_photo = 1;
        $save = $image->save();

        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete , Try again after some time.']);
        }
    }
}
