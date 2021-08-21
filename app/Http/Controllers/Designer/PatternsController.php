<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\ProductYarnQuantities;
use App\Models\WorkStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\User;
use App\Models\Products;
use App\Models\Product_images;
use Auth;
use Image;
use Illuminate\Support\Str;
use DB;
use File;
use Validator;
use Paginate;
use Redirect;
use Carbon\Carbon;
use App\Models\ProductWorkStatus;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Country;
use App\Models\Filters;
use App\Models\Product_attribute;
use App\Models\GarmentType;
use App\Models\GarmentConstruction;
use App\Models\NeedleSizes;
use App\Models\GaugeConversion;
use App\Models\ProductDesignerMeasurements;
use App\Models\ProductPdf;
use App\Models\MasterList;
use App\Models\PaypalCredentials;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Config;
use App\Mail\TraditionalPatternNotificationMail;
use Mail;
use Log;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\ProductReferenceImages;
use App\Notifications\ProductCreationMailToAdmin;
use App\Notifications\ProductCreationMailToDesigner;
use App\Models\ProductYarnRecommendations;
use App\Models\ProductYarnRecommendationImages;
use App\Models\ProductInstruction;
use App\Models\ProductNeedles;
use App\Notifications\ProductDataSubmissionByDesigner;
use App\Notifications\TraditionalPatternReleasedForSale;

class PatternsController extends Controller
{
    function __construct(){
        $this->middleware(['auth']);
    }

    function my_patterns(Request $request){

        if($request->ajax()){
            $jsonArray = array();
            $products = Products::where('designer_name',Auth::user()->id)->get();
            for ($i=0;$i< $products->count();$i++){
                $jsonArray[$i]['sku'] = $products[$i]->sku;
                $jsonArray[$i]['product_name'] = $products[$i]->product_name;
                $jsonArray[$i]['price'] = ($products[$i]->price == '0.00') ? '' : number_format($products[$i]->price,2);
                $jsonArray[$i]['sale_price'] = ($products[$i]->sale_price == '0.00') ? '' : number_format($products[$i]->sale_price,2);
                $jsonArray[$i]['updated_at'] = $products[$i]->updated_at->diffForHumans();
                $wStatus = ProductWorkStatus::where('product_id',$products[$i]->id)->orderBy('id','desc')->first();
				if($wStatus){
                $jsonArray[$i]['status'] = '<a href="javascript:;" data-id="'.base64_encode($products[$i]->id).'" class="workstatus" data-toggle="modal" data-target="#workflow-Modal">'.$wStatus->w_status.'</a>';
				}else{
					$jsonArray[$i]['status'] = '';
				}
                $jsonArray[$i]['action'] = '<a href="'.url('designer/pattern/'.base64_encode($products[$i]->id).'/edit').'" class="fa fa-pencil"></a>';
            }
            return response()->json(['data' => $jsonArray]);
        }

        return view('Pages.DesignerPatterns.index');
    }

    function create_pattern(){
        return view('Pages.DesignerPatterns.create');
    }

    function save_pattern(Request $request){
        $request->validate([
            'product_name' => 'required|regex:/^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/',
            'pattern_image' => 'required',
            'about_description' => 'required'
        ]);

        try {
            $productsCount = Products::orderBy('id','desc')->first();
            $pcount = $productsCount->id + 1;

            $product = new Products;
            $product->pid = md5($pcount);
            $product->user_id = Auth::user()->id;
            $product->sku = 'KFC00'.$pcount;
            $product->product_name = $request->product_name;
            $product->slug = Str::slug($request->product_name);
            $product->designer_name = Auth::user()->id;
            $product->product_information = $request->about_description;
            $product->is_custom = 0;
            $product->category_id = 1;
            $product->design_type = 1;
            $product->status = 0;
            $product->created_at = Carbon::now();
            $product->updated_at = Carbon::now();
            $save = $product->save();

            if($save){
                $wStatus = new ProductWorkStatus;
                $wStatus->user_id = Auth::user()->id;
                $wStatus->product_id = $product->id;
                $wStatus->w_status = 'Pattern submitted';
                $wStatus->w_status_description = 'Pattern submitted for acceptance';
                $wStatus->w_date = Carbon::now();
                $wStatus->created_at = Carbon::now();
                $wStatus->updated_at = Carbon::now();
                $wStatus->save();

                if($request->pattern_image){
                    for($i=0;$i<count($request->pattern_image);$i++){
                        $image = new Product_images;
                        $image->user_id = Auth::user()->id;
                        $image->product_id = $product->id;
                        $image->image_small = $request->pattern_image[$i];
                        $image->image_medium = $request->pattern_image[$i];
                        $image->image_large = $request->pattern_image[$i];
                        $image->image_ext = $request->pattern_ext[$i];
                        $image->created_at = Carbon::now();
                        $image->updated_at = Carbon::now();
                        $image->save();
                    }
                }
                $details = Products::where('id',$product->id)->first();
                $user = User::find(8);
                $user->notify(new ProductCreationMailToAdmin($details));

                $when = now()->addMinutes(1);
                $user2 = User::find(Auth::user()->id);
                $user2->notify((new ProductCreationMailToDesigner($details))->delay($when));
            }
            return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }


    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-.]/', '', $string); // Removes special chars.
    }

    function upload_pattern_images(Request $request){
        if($request->file('reference_images')) {
            $image = $request->file('reference_images');
        }else{
            $image = $request->file('product_images');
        }


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

    function upload_designer_pattern_instructions(Request $request){

        $image = $request->file('instruction_file');

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

    function upload_designer_recomondation_images(Request $request){
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

    function get_work_status(Request $request){
        $id = base64_decode($request->id);
        $status1 = ProductWorkStatus::where('product_id',$id)->where('w_status','Pattern submitted')->first();
        $status2 = ProductWorkStatus::where('product_id',$id)->where('w_status','Approved for upload')->first();
        $status3 = ProductWorkStatus::where('product_id',$id)->where('w_status','Design rejected')->first();
        $status4 = ProductWorkStatus::where('product_id',$id)->where('w_status','Files uploaded')->first();
        $status5 = ProductWorkStatus::where('product_id',$id)->where('w_status','Released for review')->first();
        $status6 = ProductWorkStatus::where('product_id',$id)->where('w_status','Approved for release')->first();
        return view('Pages.DesignerPatterns.workstatus',compact('status1','status2','status3','status4','status5','status6'));
    }

    function edit_pattern(Request $request){
        $id = base64_decode($request->id);
        $product = Products::where('id',$id)->first();
        $status1 = ProductWorkStatus::where('product_id',$id)->where('w_status','Pattern submitted')->first();
        $status2 = ProductWorkStatus::where('product_id',$id)->where('w_status','Approved for upload')->first();
        $status3 = ProductWorkStatus::where('product_id',$id)->where('w_status','Design rejected')->first();
        $status4 = ProductWorkStatus::where('product_id',$id)->where('w_status','Files uploaded')->first();
        $status5 = ProductWorkStatus::where('product_id',$id)->where('w_status','Released for review')->first();
        $status6 = ProductWorkStatus::where('product_id',$id)->where('w_status','Approved for release')->first();
        $subcategory = Subcategory::where('category_id',1)->get();
        $garmentType = MasterList::where('type','garment_type')->get();
        $garmentConstruction = MasterList::where('type','garment_construction')->get();
        $designElements = MasterList::where('type','design_elements')->get();
        $shoulderConstruction = MasterList::where('type','shoulder_construction')->get();
        $designers = MasterList::where('type','designers')->get();
        $needlesizes = NeedleSizes::all();
        $gaugeconversion = GaugeConversion::all();
        $materialNeeded = MasterList::where('type','material_needed')->get();
        $yarnWeight = MasterList::where('type','yarn_weight')->get();
        $pdf = ProductPdf::where('product_id',$id)->first();
        if(!$status2){
            return view('Pages.DesignerPatterns.edit-step1',compact('product','status1','status2','status3','status4','status5','status6','subcategory','garmentType',
                'garmentConstruction','needlesizes','gaugeconversion','designElements','shoulderConstruction',
                'designers','materialNeeded','yarnWeight','pdf'));
            exit;
        }
        return view('Pages.DesignerPatterns.edit',compact('product','status1','status2','status3','status4','status5','status6','subcategory','garmentType',
            'garmentConstruction','needlesizes','gaugeconversion','designElements','shoulderConstruction',
            'designers','materialNeeded','yarnWeight','pdf'));
    }

    function update_pattern_step(Request $request){
        $request->validate([
            'product_name' => 'required|regex:/^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/',
            'about_description' => 'required'
        ]);

        try {
            $id = base64_decode($request->product_id);

            $product = Products::find($id);
            $product->product_name = $request->product_name;
            $product->slug = Str::slug($request->product_name);
            $product->designer_name = Auth::user()->id;
            $product->product_information = $request->about_description;
            $product->updated_at = Carbon::now();
            $save = $product->save();

            if($save){
                if($request->pattern_image){
                    for($i=0;$i<count($request->pattern_image);$i++){
                        $image = new Product_images;
                        $image->user_id = Auth::user()->id;
                        $image->product_id = $product->id;
                        $image->image_small = $request->pattern_image[$i];
                        $image->image_medium = $request->pattern_image[$i];
                        $image->image_large = $request->pattern_image[$i];
                        $image->image_ext = $request->pattern_ext[$i];
                        $image->created_at = Carbon::now();
                        $image->updated_at = Carbon::now();
                        $image->save();
                    }
                }
            }
            return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function deletePatternImages(Request $request){
        $id = $request->id;
        $image = Product_images::find($id);
        $deleted = $image->delete();

        if($deleted){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete , Try again after some time.']);
        }
    }

    function make_image_default(Request $request){
        $id = $request->id;
        $product_id = base64_decode($request->pattern_id);
        $check = Product_images::where('product_id',$product_id)->where('main_photo',1)->count();

        if($check > 0){
            $array = array('main_photo' => 0);
            Product_images::where('pattern_id',$product_id)->update($array);
        }

        $image = Product_images::find($id);
        $image->main_photo = 1;
        $save = $image->save();

        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete , Try again after some time.']);
        }
    }

    function update_full_product_data(Request $request){
        /*echo '<pre>';
        print_r($request->all());
        echo '</pre>';
        exit;*/
        $request->validate([
            'name' => 'required|regex:/^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/',
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
            'product_price' => 'required'
        ]);

        try{
            $var2 = array();
            if($request->shoulder_construction){
                for ($sc=0;$sc<count($request->shoulder_construction);$sc++){
                    $var = strtolower($request->shoulder_construction[$sc]);
                    $var1 = Str::slug($var);
                    $var2[] = Str::slug($var);
                    $check = MasterList::where('type','shoulder_construction')->where('slug',$var1)->count();

                    if($check == 0){
                        $ml = new MasterList;
                        $ml->user_id = Auth::user()->id;
                        $ml->type = 'shoulder_construction';
                        $ml->name = ucfirst($var);
                        $ml->slug = $var1;
                        $ml->save();
                    }
                }
                $shoulder_construction = implode(',',$var2);
            }else{
                $shoulder_construction = '';
            }


            $varr2 = array();
            if($request->design_elements){
                for ($de=0;$de<count($request->design_elements);$de++){
                    $varr = strtolower($request->design_elements[$de]);
                    $varr1 = Str::slug($varr);
                    $varr2[] = Str::slug($varr);
                    $check1 = MasterList::where('type','design_elements')->where('slug',$varr1)->count();

                    if($check1 == 0){
                        $ml = new MasterList;
                        $ml->user_id = Auth::user()->id;
                        $ml->type = 'design_elements';
                        $ml->name = ucfirst($varr);
                        $ml->slug = $varr1;
                        $ml->save();
                    }
                }
                $design_elements = implode(',',$varr2);
            }else{
                $design_elements = '';
            }

            $varra2 = array();
            if($request->garment_construction){
                for ($gc=0;$gc<count($request->garment_construction);$gc++){
                    $varra = strtolower($request->garment_construction[$gc]);
                    $varra1 = Str::slug($varra);
                    $varra2[] = Str::slug($varra);
                    $check2 = MasterList::where('type','garment_construction')->where('slug',$varra1)->count();

                    if($check2 == 0){
                        $ml = new MasterList;
                        $ml->user_id = Auth::user()->id;
                        $ml->type = 'garment_construction';
                        $ml->name = ucfirst($varra);
                        $ml->slug = $varra1;
                        $ml->save();
                    }
                }
                $garment_construction = implode(',',$varra2);
            }else{
                $garment_construction = '';
            }

            $varrab2 = array();
            if($request->garment_type){
                for ($gt=0;$gt<count($request->garment_type);$gt++){
                    $varrab = strtolower($request->garment_type[$gt]);
                    $varrab1 = Str::slug($varrab);
                    $varrab2[] = Str::slug($varrab);
                    $check3 = MasterList::where('type','garment_type')->where('slug',$varrab1)->count();

                    if($check3 == 0){
                        $ml = new MasterList;
                        $ml->user_id = Auth::user()->id;
                        $ml->type = 'garment_type';
                        $ml->name = ucfirst($varrab);
                        $ml->slug = $varrab1;
                        $ml->save();
                    }
                }
                $garment_type = implode(',',$varrab2);
            }else{
                $garment_type = '';
            }

            $pattern_type = 0;

            $product_id = base64_decode($request->product_id);
            $pattern = Products::find($product_id);
            $pattern->product_name = $request->name;
            $pattern->slug = Str::slug($request->name);
            $pattern->brand_name = $request->brand_name;
            $pattern->skill_level = $request->skill_level;
            $pattern->sizes = $request->sizes;
            $pattern->product_description = $request->pattern_description;
            $pattern->short_description = $request->short_description;
            $pattern->gauge_description = $request->gauge_description;
            $pattern->material_needed = $request->material_needed;
            $pattern->design_elements = $design_elements;
            $pattern->garment_construction = $garment_construction;
            $pattern->garment_type = $garment_type;
            $pattern->shoulder_construction = $shoulder_construction;
            $pattern->designer_recommended_uom = 'in';
            $pattern->recommended_stitch_gauge_in = $request->stitch_gauge_in;
            $pattern->recommended_row_gauge_in = $request->row_gauge_in;
            $pattern->designer_recommended_ease_in = $request->ease_in;
            $pattern->recommended_stitch_gauge_cm = $request->stitch_gauge_cm;
            $pattern->recommended_row_gauge_cm = $request->row_gauge_cm;
            $pattern->designer_recommended_ease_cm = $request->ease_cm;
            $pattern->price = $request->product_price;
            $pattern->sale_price = $request->sale_price;
            $pattern->sale_price_start_date = $request->sale_price_start_date;
            $pattern->sale_price_end_date = $request->sale_price_end_date;
            $pattern->finished_measurements = $request->finished_measurements;
            $pattern->email_marketing = $request->email_marketing;
            $pattern->updated_at = Carbon::now();
            $save = $pattern->save();

            if($save){

                $status4 = ProductWorkStatus::where('product_id',$pattern->id)->where('w_status','Files uploaded')->count();
                if($status4 == 0){
                    $wStatus = new ProductWorkStatus;
                    $wStatus->user_id = Auth::user()->id;
                    $wStatus->product_id = $pattern->id;
                    $wStatus->w_status = 'Files uploaded';
                    $wStatus->w_status_description = 'Designer submits description and files';
                    $wStatus->w_date = Carbon::now();
                    $wStatus->created_at = Carbon::now();
                    $wStatus->updated_at = Carbon::now();
                    $wStatus->save();
                }


                if($request->pattern_image){
                    for($i=0;$i<count($request->pattern_image);$i++){
                        $image = new Product_images;
                        $image->user_id = Auth::user()->id;
                        $image->product_id = $pattern->id;
                        $image->image_small = $request->pattern_image[$i];
                        $image->image_medium = $request->pattern_image[$i];
                        $image->image_large = $request->pattern_image[$i];
                        if($i == 0){
                            $image->main_photo = 1;
                        }
                        $image->status = 1;
                        $image->created_at = Carbon::now();
                        $image->save();
                    }
                }

                if($request->reference_image){
                    for($ri=0;$ri<count($request->reference_image);$ri++){
                        $refImage = new ProductReferenceImages;
                        $refImage->user_id = Auth::user()->id;
                        $refImage->product_id = $pattern->id;
                        $refImage->image = $request->reference_image[$ri];
                        $refImage->ext = $request->reference_ext[$ri];
                        $refImage->status = 1;
                        $refImage->created_at = Carbon::now();
                        $refImage->save();
                    }
                }

                if($request->yarn_company){
                    for ($j=0;$j<count($request->yarn_company);$j++){
                        if ($request->product_yarn_recommendations_id[$j] == 0) {
                            $yarn = new ProductYarnRecommendations;
                            $yarn->user_id = Auth::user()->id;
                            $yarn->product_id = $pattern->id;
                            $yarn->yarn_company = $request->yarn_company[$j];
                            $yarn->yarn_name = $request->yarn_name[$j];
                            $yarn->fiber_type = $request->fiber_type[$j];
                            $yarn->yarn_weight = $request->yarn_weight[$j];
                            $yarn->yarn_url = $request->yarn_url[$j];
                            $yarn->coupon_code = $request->coupon_code[$j];
                            $yarn->created_at = Carbon::now();
                            $yarn->save();
                        }else{
                            $yarn = ProductYarnRecommendations::find($request->product_yarn_recommendations_id[$j]);
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
                                $yimage = new ProductYarnRecommendationImages;
                                $yimage->user_id = Auth::user()->id;
                                $yimage->product_id = $pattern->id;
                                $yimage->product_yarn_recommendation_id = $yarn->id;
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
                            $needles = new ProductNeedles;
                            $needles->user_id = Auth::user()->id;
                            $needles->product_id = $pattern->id;
                            $needles->needle_size = $request->needle_size[$l];
                            $needles->created_at = Carbon::now();
                            $needles->save();
                        }else{
                            $needles = ProductNeedles::find($request->needle_size_id[$l]);
                            $needles->needle_size = $request->needle_size[$l];
                            $needles->updated_at = Carbon::now();
                            $needles->save();
                        }
                    }
                }

                if(isset($request->yarn_quantity)){
                    for ($n=0;$n<count($request->yarn_quantity);$n++){
                    
                        if($request->yarn_quantity_id[$n] == 0) {
                            $needles = new ProductYarnQuantities;
                            $needles->user_id = Auth::user()->id;
                            $needles->product_id = $pattern->id;
                            $needles->yarn_quantity = $request->yarn_quantity[$n];
                            $needles->created_at = Carbon::now();
                            $needles->save();
                        }else{
                            $needles = ProductYarnQuantities::find($request->yarn_quantity_id[$n]);
                            $needles->yarn_quantity = $request->yarn_quantity[$n];
                            $needles->updated_at = Carbon::now();
                            $needles->save();
                        }
                    }
                }

                if($request->instructions_file){
                    for ($m=0;$m<count($request->instructions_file);$m++){
                        $instruction = new ProductInstruction;
                        $instruction->user_id = Auth::user()->id;
                        $instruction->product_id = $pattern->id;
                        $instruction->instructions_file = $request->instructions_file[$m];
                        $instruction->type = $request->instructions_ext[$m];
                        $instruction->created_at = Carbon::now();
                        $instruction->save();
                    }
                }
            }

            if($status4 == 0){
                $details= Products::where('id',$pattern->id)->first();
                $user = User::find(8);
                $user->notify(new ProductDataSubmissionByDesigner($details));
            }
            return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function deleteReferenceImages(Request $request){
        $id = $request->id;
        $image = ProductReferenceImages::find($id);
        $deleted = $image->delete();

        if($deleted){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete , Try again after some time.']);
        }
    }

    function deleteNeedles(Request $request){
        $id = $request->id;
        $needles = ProductNeedles::find($id);
        $deleted = $needles->delete();

        if($deleted){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete , Try again after some time.']);
        }
    }

    function deleteYarnRecommmendations(Request $request){
        $id = $request->id;
        $yarn = ProductYarnRecommendations::find($id);
        $deleted = $yarn->delete();

        if($deleted){
            ProductYarnRecommendationImages::where('product_yarn_recommendation_id',$id)->delete();
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete , Try again after some time.']);
        }
    }

    function deleteYarnRecommmendationsImages(Request $request){
        $id = $request->id;
        $yarn = ProductYarnRecommendationImages::find($id);
        $deleted = $yarn->delete();

        if($deleted){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete , Try again after some time.']);
        }
    }

    function change_pattern_status(Request $request){
        $id = base64_decode($request->id);

        $details = Products::where('id',$id)->first();


        $wStatus = new ProductWorkStatus;
        $wStatus->user_id = Auth::user()->id;
        $wStatus->product_id = $id;
        $wStatus->w_status = 'Approved for release';
        $wStatus->w_status_description = 'Pattern released for sale';
        $wStatus->w_date = Carbon::now();
        $wStatus->created_at = Carbon::now();
        $wStatus->updated_at = Carbon::now();
        $save = $wStatus->save();

        $pro = Products::find($id);
        $pro->status = 1;
        $pro->save();

        $user = User::find(8);
        $user->notify(new TraditionalPatternReleasedForSale($details));
        Auth::user()->notify(new TraditionalPatternReleasedForSale($details));

        if($save){
            return response()->json(['status' => 'success','message' => 'Pattern sent for review.']);
        }else{
            return response()->json(['status' => 'error','message' => 'Pattern sent for review. Error in sending email.']);
        }
    }
}
