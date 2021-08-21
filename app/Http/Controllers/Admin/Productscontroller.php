<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductInstruction;
use App\Models\ProductNeedles;
use App\Models\ProductYarnRecommendationImages;
use App\Models\ProductYarnRecommendations;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\Products;
use Illuminate\Http\Response;
use DB;
use App\Models\Category;
use App\Models\Subcategory;
use Paginate;
use Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Validator;
use File;
use Schema;
use App\Models\Country;
use App\Models\Filters;
use App\Models\Product_attribute;
use App\Models\Product_images;
use Session;
use Image;
use Illuminate\Support\Str;
use App\Models\GarmentType;
use App\Models\GarmentConstruction;
use App\Models\NeedleSizes;
use App\Models\GaugeConversion;
use App\Models\ProductDesignerMeasurements;
use Carbon\Carbon;
use App\Models\ProductPdf;
use App\Models\MasterList;
use App\Models\PaypalCredentials;
use Srmklive\PayPal\Services\ExpressCheckout;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Config;
use App\Models\PatternImage;
use App\Mail\TraditionalPatternNotificationMail;
use Mail;
use Log;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Models\ProductReferenceImages;
use App\Models\ProductWorkStatus;
use App\Notifications\TraditionalPatternApproved;
use App\Notifications\TraditionalPatternRejected;
use App\Notifications\TraditionalPatternReleasedForReviewToDesigner;
use App\Notifications\TraditionalPatternReleasedForSale;

class Productscontroller extends Controller
{
    public function __construct(){
		$this->middleware('auth');
	}

	function my_products(Request $request){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
		
		/*$products = Products::all();
		
		for($i=0;$i<count($products);$i++){
			//echo $products[$i]->id.' - '.$products[$i]->product_name.' - '.$products[$i]->status.' - '.$products[$i]->in_review.' - '.$products[$i]->in_review_designer.'<br>';
			
			if($products[$i]->id == 37 || $products[$i]->id == 40 || $products[$i]->id == 41 || $products[$i]->id == 56 || $products[$i]->id == 57){
				
			$status1 = new ProductWorkStatus;
			$status1->user_id = $products[$i]->designer_name;
			$status1->product_id = $products[$i]->id;
			$status1->w_status = 'Pattern submitted';
			$status1->w_status_description = 'Pattern submitted for acceptance';
			$status1->w_date = date('Y-m-d H:i:s');
			$status1->created_at = date('Y-m-d H:i:s');
			$status1->save();
			
			$status2 = new ProductWorkStatus;
			$status2->user_id = $products[$i]->designer_name;
			$status2->product_id = $products[$i]->id;
			$status2->w_status = 'Approved for upload';
			$status2->w_status_description = 'Design accepted';
			$status2->w_date = date('Y-m-d H:i:s');
			$status2->created_at = date('Y-m-d H:i:s');
			$status2->save();
			
			$status3 = new ProductWorkStatus;
			$status3->user_id = $products[$i]->designer_name;
			$status3->product_id = $products[$i]->id;
			$status3->w_status = 'Files uploaded';
			$status3->w_status_description = 'Submit description and files';
			$status3->w_date = date('Y-m-d H:i:s');
			$status3->created_at = date('Y-m-d H:i:s');
			$status3->save();
			
			$status4 = new ProductWorkStatus;
			$status4->user_id = $products[$i]->designer_name;
			$status4->product_id = $products[$i]->id;
			$status4->w_status = 'Released for review';
			$status4->w_status_description = 'Pattern released for review';
			$status4->w_date = date('Y-m-d H:i:s');
			$status4->created_at = date('Y-m-d H:i:s');
			$status4->save();
			
			$status5 = new ProductWorkStatus;
			$status5->user_id = $products[$i]->designer_name;
			$status5->product_id = $products[$i]->id;
			$status5->w_status = 'Approved for release';
			$status5->w_status_description = 'Pattern released for sale';
			$status5->w_date = date('Y-m-d H:i:s');
			$status5->created_at = date('Y-m-d H:i:s');
			$status5->save();
			
			}
		}
		exit;*/
		
        $type = $request->type;
        if($type == 'all'){
            $products = Products::all();
        }else if($type == 'active'){
            $products = Products::where('status',1)->get();
        }else if($type == 'inactive'){
            $products = Products::where('status','!=',1)->get();
        }else{
            $products = Products::all();
        }
    	return view('admin.products.index',compact('products'));
    }

    function add_new_pattern(){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
        $pcount = DB::table('products')->count();
        $subcategory = Subcategory::where('category_id',1)->get();
        $garmentType = MasterList::where('type','garment_type')->get();
        $garmentConstruction = MasterList::where('type','garment_construction')->get();
        $designElements = MasterList::where('type','design_elements')->get();
        $shoulderConstruction = MasterList::where('type','shoulder_construction')->get();
        $needlesizes = NeedleSizes::all();
        $gaugeconversion = GaugeConversion::all();
		$designers = MasterList::where('type','designers')->get();
		$measurement_variables = DB::table('measurement_variables')->where('variable_type','pattern_specific')->get();
		$users = User::where('status',1)->get();
		$designerUsers = User::whereHas( 'roles', function($q){
            $q->where('role_name', 'Designer');
        })->where('status',1)->get();
        return view('admin.products.add-product',compact('pcount','subcategory','garmentType','garmentConstruction','needlesizes','gaugeconversion','designElements','shoulderConstruction','designers','measurement_variables','users','designerUsers'));
    }

    function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '.', $string); // Removes special chars.
    }

    function upload_image(Request $request){
        $image = $request->file('file');
        $oname = $this->clean($image->getClientOriginalName());
            $filename = time().'-'.$oname;
            $ext = $image->getClientOriginalExtension();

         $s3 = \Storage::disk('s3');
        //exit;
        $filepath = 'knitfit/'.strtolower($filename);


        $ext = 'jpg';
        $img = Image::make($image);
        $height = Image::make($image)->height();
        $width = Image::make($image)->width();
        $img->orientate();
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->encode('jpg');
        $pu = $s3->put('/'.$filepath, $img->__toString(), 'public');


       if($pu){
         return response()->json(['path1' => $filepath, 'path' => 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath,'ext' => $ext]);
     }else{
        echo 'error';
     }

    }

    function product_images(Request $request){
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
         return response()->json(['path1' => $filepath, 'path' => 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath,'ext' => $ext]);
     }else{
        echo 'error';
     }
        }
    }

    function upload_product(Request $request){
    	$productcount = Products::orderBy('id','desc')->first();
        $pcount = $productcount->id + 1;

        if($request->garment_type){
            $garmentType = implode(',',$request->garment_type);
        }else{
            $garmentType = '';
        }

        if($request->garment_construction){
            $garmentConstruction = implode(',',$request->garment_construction);
        }else{
            $garmentConstruction = '';
        }

        if($request->design_elements){
            $designElements = implode(',',$request->design_elements);
        }else{
            $designElements = '';
        }

        if($request->shoulder_construction){
        $shoulderConstruction = implode(',',$request->shoulder_construction);
        }else{
        $shoulderConstruction = '';
        }

		$slug = Str::slug($request->name);

    	$pro = new Products;
    	$pro->user_id = Auth::user()->id;
    	$pro->pid = md5($pcount);
    	$pro->product_name = $request->name;
    	$pro->slug = Str::slug($request->name);
    	$pro->short_description = $request->short_description;
    	$pro->product_description = $request->description;
    	//$pro->additional_information = $request->additional_information;
    	$pro->gauge_description = $request->gauge_description;
    	$pro->material_needed = $request->material_needed;
    	$pro->skill_level = $request->skill_level;
    	$pro->category_id = 1;
    	$pro->sku = $request->sku;
    	$pro->is_custom = $request->is_custom;
    	$pro->design_type = $request->sub_category_name;
		$pro->designer_name = $request->designer_name;
    	$pro->product_go_live_date = date('Y-m-d',strtotime($request->set_product_new_to_date));
    	$pro->status = $request->status;
		if($request->status == 1){
			$pro->visible = 1;
		}
    	$pro->price = $request->price;
    	$pro->sale_price = $request->special_price;
    	$pro->sale_price_start_date = date('Y-m-d',strtotime($request->special_price_start_date));
    	$pro->sale_price_end_date = date('Y-m-d',strtotime($request->special_price_end_date));
    	$pro->recommended_yarn = $request->recommended_yarn;
    	$pro->recommended_fiber_type = $request->recommended_fiber_type;
    	$pro->recommended_yarn_weight = $request->recommended_yarn_weight;
    	$pro->recommended_needle_size = $request->recommended_needle_size;
    	$pro->additional_tools = $request->additional_tools;
    	$pro->designer_recommended_uom = $request->designer_recommended_uom;
    	if($request->designer_recommended_uom == 'in'){
    		$pro->designer_recommended_ease_in = $request->designer_recommended_ease_in;
    		$pro->recommended_stitch_gauge_in = $request->recommended_stitch_gauge_in;
    		$pro->recommended_row_gauge_in = $request->recommended_row_gauge_in;
    	}else{
    		$pro->designer_recommended_ease_cm = $request->designer_recommended_ease_cm;
    		$pro->recommended_stitch_gauge_cm = $request->recommended_stitch_gauge_cm;
    		$pro->recommended_row_gauge_cm = $request->recommended_row_gauge_cm;
    	}


    	$pro->garment_type = $garmentType;
    	$pro->garment_construction = $garmentConstruction;
        $pro->design_elements = $designElements;
        $pro->shoulder_construction = $shoulderConstruction;
		$pro->measurement_file = $slug;
    	$pro->created_at = Carbon::now();
    	$pro->ipaddress = $_SERVER['REMOTE_ADDR'];
    	$save = $pro->save();

    	if($save){
			
			/*if($request->paypal_username != ''){
                $checkPaypal = Products::where('user_id',$request->designer_name)->count();
                if($checkPaypal == 0){
                    $paypal = new PaypalCredentials;
                    $paypal->user_id = $request->designer_name;
                    $paypal->customer_email = Auth::user()->email;
                    $paypal->store_name = trim($request->store_name);
                    $paypal->store_status = trim($request->store_status);
                    $paypal->account_type = trim($request->account_type);
                    $paypal->paypal_email = trim($request->paypal_email);
                    $paypal->created_at = Carbon::now();
                    $paypal->save();
                }
            }*/

	    	for ($i=0; $i < count($request->measurement_name); $i++) {
	    		$name = $request->measurement_name[$i];
	    		$str_to_lower = strtolower($name);
	    		$underscore = str_replace(' ', '_', $str_to_lower);

	    		$measurements = new ProductDesignerMeasurements;
	    		$measurements->user_id = Auth::user()->id;
	    		$measurements->product_id = $pro->id;
	    		$measurements->measurement_name = $underscore;
	    		$measurements->measurement_value = '';
	    		$measurements->measurement_type = 'text';
	    		$measurements->measurement_description = $request->measurement_description[$i];
	    		$measurements->measurement_image = $request->measurement_image[$i];
				$measurements->min_value_inches = $request->min_value_inches[$i];
                $measurements->max_value_inches = $request->max_value_inches[$i];
                $measurements->min_value_cm = $request->min_value_cm[$i];
                $measurements->max_value_cm = $request->max_value_cm[$i];
	    		$measurements->status = 1;
	    		$measurements->created_at = Carbon::now();
	    		$measurements->ipaddress = $_SERVER['REMOTE_ADDR'];
	    		$measurements->save();
	    	}
			
			if($request->measurements_not_in_use){
				for($m=0;$m<count($request->measurements_not_in_use);$m++){
					$marray = array('user_id' => Auth::user()->id,'product_id' => $pro->id,'measurement_name' => $request->measurements_not_in_use[$m],'created_at' => Carbon::now());
				DB::table('product_designer_measurements_notused')->insert($marray);
				}
			}
			
			if($request->users_list){
				for($ul=0;$ul<count($request->users_list);$ul++){
					$ularray = array('user_id' => $request->users_list[$ul],'product_id' => $pro->id);
					DB::table('product_access')->insert($ularray);
				}
			}

            if($request->images){
				for ($j=0; $j < count($request->images); $j++) {
					$image = new Product_images;
					$image->user_id = Auth::user()->id;
					$image->product_id = $pro->id;
					$image->image_small = $request->images[$j];
					$image->image_medium = $request->images[$j];
					$image->image_large = $request->images[$j];
					if($j == 0){
						$image->main_photo = 1;
					}
					$image->status = 1;
					$image->save();
				}
			}
			
			if($request->reference_image){
                for($ri=0;$ri<count($request->reference_image);$ri++){
                    $refImage = new ProductReferenceImages;
                    $refImage->user_id = Auth::user()->id;
                    $refImage->product_id = $pro->id;
                    $refImage->image = $request->reference_image[$ri];
                    $refImage->ext = $request->reference_ext[$ri];
                    $refImage->status = 1;
                    $refImage->created_at = Carbon::now();
                    $refImage->save();
                }
            }

	    	return response()->json(['status' => 'Success']);

    	}else{
    		return response()->json(['status' => 'Fail']);
    	}
    }


    function update_product(Request $request){
        //echo '<pre>';
        //print_r($request->all());
        //echo '</pre>';
        //exit;
    	$pcount = Products::count() + 1;

    	if($request->garment_type){
            $garmentType = implode(',',$request->garment_type);
        }else{
            $garmentType = '';
        }

        if($request->garment_construction){
            $garmentConstruction = implode(',',$request->garment_construction);
        }else{
            $garmentConstruction = '';
        }

        if($request->design_elements){
            $designElements = implode(',',$request->design_elements);
        }else{
            $designElements = '';
        }

        if($request->shoulder_construction){
        $shoulderConstruction = implode(',',$request->shoulder_construction);
        }else{
        $shoulderConstruction = '';
        }
		
		$slug = Str::slug($request->name);
		


    	$pro = Products::find($request->id);
    	//$pro->user_id = Auth::user()->id;
    	//$pro->pid = md5($pcount);
    	$pro->product_name = $request->name;
    	$pro->slug = Str::slug($request->name);
    	$pro->short_description = $request->short_description;
    	$pro->product_description = $request->description;
    	//$pro->additional_information = $request->additional_information;
		$pro->gauge_description = $request->gauge_description;
    	$pro->material_needed = $request->material_needed;
    	$pro->skill_level = $request->skill_level;
    	$pro->category_id = 1;
    	$pro->sku = $request->sku;
    	$pro->is_custom = $request->is_custom;
    	$pro->design_type = $request->sub_category_name;
		$pro->designer_name = $request->designer_name;
    	$pro->product_go_live_date = date('Y-m-d',strtotime($request->set_product_new_to_date));
    	$pro->status = $request->status;
		if($request->status == 1){
			$pro->visible = 1;
		}
    	$pro->price = $request->price;
    	$pro->sale_price = $request->special_price;
    	$pro->sale_price_start_date = date('Y-m-d',strtotime($request->special_price_start_date));
    	$pro->sale_price_end_date = date('Y-m-d',strtotime($request->special_price_end_date));
    	$pro->recommended_yarn = $request->recommended_yarn;
    	$pro->recommended_fiber_type = $request->recommended_fiber_type;
    	$pro->recommended_yarn_weight = $request->recommended_yarn_weight;
    	$pro->recommended_needle_size = $request->recommended_needle_size;
    	$pro->additional_tools = $request->additional_tools;
    	$pro->designer_recommended_uom = $request->designer_recommended_uom;
    	if($request->designer_recommended_uom == 'in'){
    		$pro->designer_recommended_ease_in = $request->designer_recommended_ease_in;
    		$pro->recommended_stitch_gauge_in = $request->recommended_stitch_gauge_in;
    		$pro->recommended_row_gauge_in = $request->recommended_row_gauge_in;
    	}else{
    		$pro->designer_recommended_ease_cm = $request->designer_recommended_ease_cm;
    		$pro->recommended_stitch_gauge_cm = $request->recommended_stitch_gauge_cm;
    		$pro->recommended_row_gauge_cm = $request->recommended_row_gauge_cm;
    	}


    	$pro->garment_type = $garmentType;
    	$pro->garment_construction = $garmentConstruction;
        $pro->design_elements = $designElements;
        $pro->shoulder_construction = $shoulderConstruction;
		$pro->measurement_file = $slug;
    	$pro->updated_at = Carbon::now();
    	$pro->ipaddress = $_SERVER['REMOTE_ADDR'];
    	$save = $pro->save();

    	if($save){
			
			/*$checkPaypal = PaypalCredentials::where('user_id',$request->designer_name)->count();
            if(($checkPaypal > 0) && $request->paypal_id){
                $paypal = PaypalCredentials::find($request->paypal_id);
				$paypal->store_name = trim($request->store_name);
				$paypal->store_status = trim($request->store_status);
				$paypal->account_type = trim($request->account_type);
				$paypal->paypal_email = trim($request->paypal_email);
                $paypal->updated_at = Carbon::now();
                $paypal->save();
            }else{
                $paypal = new PaypalCredentials;
                $paypal->user_id = $request->designer_name;
                $paypal->customer_email = Auth::user()->email;
				$paypal->store_name = trim($request->store_name);
				$paypal->store_status = trim($request->store_status);
				$paypal->account_type = trim($request->account_type);
				$paypal->paypal_email = trim($request->paypal_email);
                $paypal->created_at = Carbon::now();
                $paypal->save();
            }*/

	    	for ($i=0; $i < count($request->measurement_name); $i++) {
	    		$name = $request->measurement_name[$i];
	    		$str_to_lower = strtolower($name);
	    		$underscore = str_replace(' ', '_', $str_to_lower);

	    		if($request->measurement_id[$i] != 0){
	    		$measurements = ProductDesignerMeasurements::find($request->measurement_id[$i]);
	    		$measurements->measurement_name = $underscore;
	    		$measurements->measurement_description = $request->measurement_description[$i];
	    		if($request->measurement_image[$i] != ''){
	    			$measurements->measurement_image = $request->measurement_image[$i];
	    		}
				$measurements->min_value_inches = $request->min_value_inches[$i];
                $measurements->max_value_inches = $request->max_value_inches[$i];
                $measurements->min_value_cm = $request->min_value_cm[$i];
                $measurements->max_value_cm = $request->max_value_cm[$i];
	    		$measurements->updated_at = Carbon::now();
	    		$measurements->ipaddress = $_SERVER['REMOTE_ADDR'];
	    		$measurements->save();
	    		}else{
	    		$measurements = new ProductDesignerMeasurements;
	    		$measurements->user_id = Auth::user()->id;
	    		$measurements->product_id = $pro->id;
	    		$measurements->measurement_name = $underscore;
	    		$measurements->measurement_type = 'text';
	    		$measurements->measurement_description = $request->measurement_description[$i];
	    		$measurements->measurement_image = $request->measurement_image[$i];
				$measurements->min_value_inches = $request->min_value_inches[$i];
                $measurements->max_value_inches = $request->max_value_inches[$i];
                $measurements->min_value_cm = $request->min_value_cm[$i];
                $measurements->max_value_cm = $request->max_value_cm[$i];
	    		$measurements->status = 1;
	    		$measurements->created_at = Carbon::now();
	    		$measurements->ipaddress = $_SERVER['REMOTE_ADDR'];
	    		$measurements->save();
	    		}


	    	}
			
			if($request->measurements_not_in_use){
				DB::table('product_designer_measurements_notused')->where('product_id',$pro->id)->delete();
				for($m=0;$m<count($request->measurements_not_in_use);$m++){
					$mcheck = DB::table('product_designer_measurements_notused')->where('product_id',$pro->id)->where('measurement_name',$request->measurements_not_in_use[$m])->count();
					
					if($mcheck == 0){
						$marray = array('user_id' => Auth::user()->id,'product_id' => $pro->id,'measurement_name' => $request->measurements_not_in_use[$m],'created_at' => Carbon::now());
						DB::table('product_designer_measurements_notused')->insert($marray);
					}

				}
			}
			
			
			if($request->users_list){
				DB::table('product_access')->where('product_id',$pro->id)->delete();
				for($ul=0;$ul<count($request->users_list);$ul++){
					$ulcheck = DB::table('product_access')->where('user_id',$request->users_list[$ul])->where('product_id',$pro->id)->count();
					
					if($ulcheck == 0){
						$ularray = array('user_id' => $request->users_list[$ul],'product_id' => $pro->id);
						DB::table('product_access')->insert($ularray);
					}
				}
			}else{
				$ulcount = DB::table('product_access')->where('product_id',$pro->id)->count();
				if($ulcount > 0){
					DB::table('product_access')->where('product_id',$pro->id)->delete();
				}
			}

	    	if($request->images){
				for ($j=0; $j < count($request->images); $j++) {
					$image = new Product_images;
					$image->user_id = Auth::user()->id;
					$image->product_id = $pro->id;
					$image->image_small = $request->images[$j];
					$image->image_medium = $request->images[$j];
					$image->image_large = $request->images[$j];
					if($j == 0){
						$image->main_photo = 1;
					}
					$image->status = 1;
					$image->save();
				}
			}
			
			if($request->reference_image){
                for($ri=0;$ri<count($request->reference_image);$ri++){
                    $refImage = new ProductReferenceImages;
                    $refImage->user_id = Auth::user()->id;
                    $refImage->product_id = $pro->id;
                    $refImage->image = $request->reference_image[$ri];
                    $refImage->ext = $request->reference_ext[$ri];
                    $refImage->status = 1;
                    $refImage->created_at = Carbon::now();
                    $refImage->save();
                }
            }

	    	return response()->json(['status' => 'Success']);

    	}else{
    		return response()->json(['status' => 'Fail']);
    	}
    }


    function edit_product(Request $request){
    	$pid = $request->pid;
    	$subcategory = Subcategory::where('category_id',1)->get();
        $garmentType = MasterList::where('type','garment_type')->get();
        $garmentConstruction = MasterList::where('type','garment_construction')->get();
        $designElements = MasterList::where('type','design_elements')->get();
        $shoulderConstruction = MasterList::where('type','shoulder_construction')->get();
        $needlesizes = NeedleSizes::all();
        $gaugeconversion = GaugeConversion::all();
    	$product = Products::where('pid',$pid)->first();
    	$measurements = ProductDesignerMeasurements::where('product_id',$product->id)->get();
    	$product_images = Product_images::where('product_id',$product->id)->get();
		$designers = MasterList::where('type','designers')->get();
		$notusedMeasurements = DB::table('product_designer_measurements_notused')->where('product_id',$product->id)->get();
		$measurement_variables = DB::table('measurement_variables')->where('variable_type','pattern_specific')->get();
		$users = User::where('status',1)->get();
		$product_access = DB::table('product_access')->where('product_id',$product->id)->get();
		$designerUsers = User::whereHas( 'roles', function($q){
            $q->where('role_name', 'Designer');
        })->where('status',1)->get();
        $paypalDetails = PaypalCredentials::where('user_id',$product->designer_name)->first();
    	return view('admin.products.edit-product',compact('product','measurements','product_images','subcategory','garmentType','garmentConstruction','gaugeconversion','needlesizes','designElements','shoulderConstruction','designers','notusedMeasurements','measurement_variables','users','product_access','paypalDetails','designerUsers'));
    }

    function remove_product_image(Request $request){
    	$id = $request->id;
    	$product_images = Product_images::find($id);
    	$del = $product_images->delete();
    	if($del){
    		return response()->json(['status' => 'Success']);
    	}else{
    		return response()->json(['status' => 'Fail']);
    	}
    }

    function delete_measurement(Request $request){
    	$meas = ProductDesignerMeasurements::find($request->id);
    	$del = $meas->delete();
    	if($del){
    		return response()->json(['status' => 'Success']);
    	}else{
    		return response()->json(['status' => 'Fail']);
    	}
    }

    function delete_product(Request $request){
    	$pro = Products::find($request->id);
    	$pro->status = 0;
    	$save = $pro->save();
    	if($save){
    		return response()->json(['status' => 'Success']);
    	}else{
    		return response()->json(['status' => 'Fail']);
    	}
    }

    /* function create_pattern(Request $request){
    	$pid = $request->pid;
    	$product = Products::where('pid',$pid)->first();
    	$pdf = ProductPdf::where('product_id',$product->id)->first();
    	return view('admin.products.pattern-template',compact('pid','pdf','product'));
    }

    function add_pattern_instructions(Request $request){
    	if($request->id == 0){
    		$pdf = new ProductPdf;
    		$pdf->user_id = Auth::user()->id;
    		$pdf->product_id = $request->product_id;
    		$pdf->created_at = Carbon::now();
    		$pdf->ipaddress = $_SERVER['REMOTE_ADDR'];
    	}else{
    		$pdf = ProductPdf::find($request->id);
    		$pdf->updated_at = Carbon::now();
    		$pdf->ipaddress = $_SERVER['REMOTE_ADDR'];
    	}
    	$pdf->content = $request->content;
    	$save = $pdf->save();
    	if($save){
    		return response()->json(['status' => 'Success']);
    	}else{
    		return response()->json(['status' => 'Fail']);
    	}
    } */

    function create_pattern(Request $request){
        $product_id = $request->id;
        $uom = $request->uom;
		if($request->tid){
			$tid = $request->tid;
		}else{
			$tid = 0;
		}
        $data = DB::table('product_pdf')->where('product_id',$request->id)->where('uom',$uom)->first();
        return view('admin.products.pattern.index',compact('product_id','data','uom','tid'));
    }

    function create_pattern_pdf(Request $request){
        if($request->id == 0){
            $array = array('product_id'=>$request->product_id,'uom' => $request->uom,'content' => $request->content,'e_content'=> $request->econtent);
            $ins = DB::table('product_pdf')->insert($array);
        }else{
            $array = array('uom' => $request->uom,'content' => $request->content,'e_content'=> $request->econtent);
            $ins = DB::table('product_pdf')->where('id',$request->id)->update($array);
        }

        if($ins){
            return 0;
        }else{
            return 1;
        }
    }

    function get_images_for_pattern(Request $request){
        $images = DB::table('pattern_images')->get();
        return view('admin.products.pattern.get-images',compact('images'));
    }

    function upload_images_for_pattern(Request $request){
        $image = $request->file('nomefile');
        $filename = time().$image->getClientOriginalName();
        $name = basename($filename);

        $s3 = \Storage::disk('s3');
        $filepath = '/knitfit/products/'.$filename;
        $pu1 = $s3->put($filepath, file_get_contents($image), 'public');


        $array = array('title' => $name,'image_path' => "https://s3.us-east-2.amazonaws.com/knitfitcoall".$filepath);
        $ins = DB::table('pattern_images')->insert($array);
		echo $array['image_path'];

    }
	
	
	function upload_excel_sheet(Request $request){
        $image = $request->file('file');
        $name = $image->getClientOriginalName();
        
        $products = Products::all();
        $array = array(array());
        foreach($products as $pro){
            $array1 = array($pro->measurement_file.'_in.xlsx',$pro->measurement_file.'_cm.xlsx');
            array_push($array,$array1);
        }

        $arr = array_column($array,0);
        $arr1 = array_column($array,1);


        if(in_array($name,$arr) || in_array($name,$arr1)){
            $move = $image->move(storage_path(), $name);
        }else{
            $move = '';
        }
        
		if($move){
			return response()->json(['status' => 'success']);
		}else{
			return response()->json(['status' => 'fail']);
		}
    }


	    /* Traditional Pattern functions */
		
		
	function upload_admin_pattern_images(Request $request){
        if($request->file('product_images')){
			$image = $request->file('product_images');
		}else{
			$image = $request->file('reference_images');
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
                $constraint->aspectRatio();
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
                $constraint->aspectRatio();
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
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
        $pcount = DB::table('products')->count();
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
		$designerUsers = User::whereHas( 'roles', function($q){
            $q->where('role_name', 'Designer');
        })->where('status',1)->get();
		$users = User::whereHas( 'roles', function($q){
            $q->where('role_name', 'Knitter');
        })->where('status',1)->get();
        return view('admin.traditional-pattern.create',compact('pcount','subcategory','garmentType','garmentConstruction','needlesizes','gaugeconversion','designElements','shoulderConstruction','designers','materialNeeded','yarnWeight','designerUsers','users'));
    }


    function save_traditional_pattern(Request $request){
        /*echo '<pre>';
        print_r($request->all());
        echo '</pre>';*/
        //exit;
        $request->validate([
            'sku' => 'required|alpha_num',
            'pattern_go_live_date' => 'required',
            //'status' => 'required',
            'name' => 'required|regex:/^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/',
            'designer_name' => 'required',
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

            $productsCount = Products::orderBy('id','desc')->count();
            $pcount = $productsCount + 1;

            /*$designerCount = MasterList::where('type','designers')->where('name',$request->designer_name)->count();

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
            }*/



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

            if($request->pattern_type == 'traditional'){
                $pattern_type = 0;
            }else{
                $pattern_type = 1;
            }

            $pattern = new Products;
            $pattern->user_id = Auth::user()->id;
            $pattern->sku = $request->sku;
            $pattern->product_go_live_date = date('Y-m-d',strtotime($request->pattern_go_live_date));
            $pattern->status = 0;
            $pattern->product_name = $request->name;
            $pattern->slug = Str::slug($request->name);
            $pattern->is_custom = $pattern_type;
            $pattern->category_id = 1;
            $pattern->design_type = 1;
            $pattern->designer_name = $request->designer_name;
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
			if($request->sale_price_start_date){
				$pattern->sale_price_start_date = date('Y-m-d',strtotime($request->sale_price_start_date));
			}
			if($request->sale_price_end_date){
				$pattern->sale_price_end_date = date('Y-m-d',strtotime($request->sale_price_end_date));
			}
            /*$pattern->template_id = decrypt($request->template_id);*/
            $save = $pattern->save();

            if($save){
                $pro = Products::find($pattern->id);
                $pro->pid = md5($pattern->id);
                $pro->save();
            }


        	$wStatus = new ProductWorkStatus;
            $wStatus->user_id = Auth::user()->id;
            $wStatus->product_id = $pattern->id;
            $wStatus->w_status = 'Pattern submitted';
            $wStatus->w_status_description = 'Pattern submitted for acceptance';
            $wStatus->w_date = Carbon::now();
            $wStatus->created_at = Carbon::now();
            $wStatus->updated_at = Carbon::now();
            $wStatus->save();

           /* $st = array(1,2);

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
            }*/
			
			/*if($request->paypal_username != ''){
                $checkPaypal = PaypalCredentials::where('user_id',$request->designer_name)->count();
                if($checkPaypal == 0){
                    $paypal = new PaypalCredentials;
                    $paypal->user_id = $request->designer_name;
                    $paypal->paypal_username = trim($request->paypal_username);
                    $paypal->paypal_password = trim($request->paypal_password);
                    $paypal->paypal_secret = trim($request->paypal_secret);
                    $paypal->paypal_app_id = trim($request->paypal_app_id);
                    $paypal->created_at = Carbon::now();
                    $paypal->save();
                }
            }*/
			
			/*if($request->paypal_username){
				$checkPaypal = PaypalCredentials::where('user_id',$request->designer_name)->count();
				if($checkPaypal > 0){
					$paypal = PaypalCredentials::find($request->paypal_id);
                    $paypal->store_name = trim($request->store_name);
                    $paypal->store_status = trim($request->store_status);
                    $paypal->account_type = trim($request->account_type);
                    $paypal->paypal_email = trim($request->paypal_email);
					$paypal->updated_at = Carbon::now();
					$paypal->save();
				}else{
					$paypal = new PaypalCredentials;
					$paypal->user_id = $request->designer_name;
					$paypal->customer_email = Auth::user()->email;
                    $paypal->store_name = trim($request->store_name);
                    $paypal->store_status = trim($request->store_status);
                    $paypal->account_type = trim($request->account_type);
                    $paypal->paypal_email = trim($request->paypal_email);
					$paypal->created_at = Carbon::now();
					$paypal->save();
				}
			}*/
			
			if($request->users_list){
                for($ul=0;$ul<count($request->users_list);$ul++){
                    $ularray = array('user_id' => $request->users_list[$ul],'product_id' => $pattern->id);
                    DB::table('product_access')->insert($ularray);
                }
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
                    $needles = new ProductNeedles;
                    $needles->user_id = Auth::user()->id;
                    $needles->product_id = $pattern->id;
                    $needles->needle_size = $request->needle_size[$l];
                    $needles->created_at = Carbon::now();
                    $needles->save();
                }
            }

            if($request->image_instructions){
                for ($m=0;$m<count($request->image_instructions);$m++){
                    $instruction = new ProductInstruction;
                    $instruction->user_id = Auth::user()->id;
                    $instruction->product_id = $pattern->id;
                    $instruction->instructions_file = $request->image_instructions[$m];
                    $instruction->type = $request->instructions_ext[$m];
                    $instruction->created_at = Carbon::now();
                    $instruction->save();
                }
            }

            if($request->submit_type == 'save'){
                $url = url('admin/browse-patterns');
            }else{
                $url = url('admin/browse-patterns');
            }
            return response()->json(['status' => 'success','url' => $url]);
        }catch(\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function edit_traditional_pattern(Request $request){
        $id = base64_decode($request->id);
        $product = Products::find($id);
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
        $designer = MasterList::where('id',$product->designer_name)->first();
		$designerUsers = User::whereHas( 'roles', function($q){
            $q->where('role_name', 'Designer');
        })->where('status',1)->get();
        $paypalDetails = PaypalCredentials::where('user_id',$product->designer_name)->first();
		//print_r($paypalDetails);
		//exit;
		$users = User::whereHas( 'roles', function($q){
            $q->where('role_name', 'Knitter');
        })->where('status',1)->get();
        $product_access = DB::table('product_access')->where('product_id',$product->id)->get();

        $status1 = ProductWorkStatus::where('product_id',$id)->where('w_status','Pattern submitted')->first();
        $status2 = ProductWorkStatus::where('product_id',$id)->where('w_status','Approved for upload')->first();
        $status3 = ProductWorkStatus::where('product_id',$id)->where('w_status','Design rejected')->first();
        $status4 = ProductWorkStatus::where('product_id',$id)->where('w_status','Files uploaded')->first();
        $status5 = ProductWorkStatus::where('product_id',$id)->where('w_status','Released for review')->first();
        $status6 = ProductWorkStatus::where('product_id',$id)->where('w_status','Approved for release')->first();

        return view('admin.traditional-pattern.edit',compact('product','subcategory','garmentType',
            'garmentConstruction','needlesizes','gaugeconversion','designElements','shoulderConstruction',
            'designers','materialNeeded','yarnWeight','designer','designerUsers','paypalDetails','users','product_access','status1','status2','status3','status4','status5','status6'));
    }

    function update_traditional_pattern(Request $request){
			//info('Update : '.$request->all());
        /*echo '<pre>';
        print_r($request->all());
        echo '</pre>';
        exit;*/
        $request->validate([
            'sku' => 'required|alpha_num',
            'pattern_go_live_date' => 'required',
            //'status' => 'required',
            'name' => 'required|regex:/^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/',
            'designer_name' => 'required',
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
			
			$paypal = PaypalCredentials::where('user_id',$request->designer_name)->first();
			if($request->status == 1){
				if($paypal->paypal_email == ''){
					return response()->json(['status' => 'fail','message' => 'To make this pattern active fill the paypal details section in users menu.']);
					exit;
				}
			}

            $productsCount = Products::orderBy('id','desc')->count();
            $pcount = $productsCount + 1;

           /* $designerCount = MasterList::where('type','designers')->where('name',$request->designer_name)->count();

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
            }*/

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

            if($request->pattern_type == 'traditional'){
                $pattern_type = 0;
            }else{
                $pattern_type = 1;
            }

            $product_id = decrypt($request->product_id);

            $pattern = Products::find($product_id);
            //$pattern->user_id = Auth::user()->id;
            //$pattern->sku = $request->sku;
            $pattern->product_go_live_date = date('Y-m-d',strtotime($request->pattern_go_live_date));
            $pattern->status = $request->status;
            $pattern->product_name = $request->name;
            $pattern->slug = Str::slug($request->name);
            $pattern->is_custom = $pattern_type;
            $pattern->category_id = 1;
            $pattern->design_type = 1;
            $pattern->designer_name = $request->designer_name;
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
            $pattern->sale_price_start_date = date('Y-m-d',strtotime($request->sale_price_start_date));
            $pattern->sale_price_end_date = date('Y-m-d',strtotime($request->sale_price_end_date));
            /*$pattern->template_id = decrypt($request->template_id);*/
            $save = $pattern->save();

            /* $st = array(1,2);

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
             }*/
			 
			/*$checkPaypal = PaypalCredentials::where('user_id',$request->designer_name)->count();
            if($checkPaypal > 0){
                $paypal = PaypalCredentials::find($request->paypal_id);
				$paypal->store_name = trim($request->store_name);
				$paypal->store_status = trim($request->store_status);
				$paypal->account_type = trim($request->account_type);
				$paypal->paypal_email = trim($request->paypal_email);
                $paypal->updated_at = Carbon::now();
                $paypal->save();
            }else{
                $paypal = new PaypalCredentials;
                $paypal->user_id = $request->designer_name;
                $paypal->customer_email = Auth::user()->email;
				$paypal->store_name = trim($request->store_name);
				$paypal->store_status = trim($request->store_status);
				$paypal->account_type = trim($request->account_type);
				$paypal->paypal_email = trim($request->paypal_email);
                $paypal->created_at = Carbon::now();
                $paypal->save();
            }*/
			
			
			if($request->users_list){
                DB::table('product_access')->where('product_id',$pattern->id)->delete();
                for($ul=0;$ul<count($request->users_list);$ul++){
                    $ulcheck = DB::table('product_access')->where('user_id',$request->users_list[$ul])->where('product_id',$pattern->id)->count();

                    if($ulcheck == 0){
                        $ularray = array('user_id' => $request->users_list[$ul],'product_id' => $pattern->id);
                        DB::table('product_access')->insert($ularray);
                    }
                }
            }else{
                $ulcount = DB::table('product_access')->where('product_id',$pattern->id)->count();
                if($ulcount > 0){
                    DB::table('product_access')->where('product_id',$pattern->id)->delete();
                }
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

            if($request->image_instructions){
                for ($m=0;$m<count($request->image_instructions);$m++){
                    $instruction = new ProductInstruction;
                    $instruction->user_id = Auth::user()->id;
                    $instruction->product_id = $pattern->id;
                    $instruction->instructions_file = $request->image_instructions[$m];
                    $instruction->type = $request->instructions_ext[$m];
                    $instruction->created_at = Carbon::now();
                    $instruction->save();
                }
            }

            if($request->submit_type == 'save'){
                $url = url('admin/browse-patterns');
            }else{
                $url = url('admin/browse-patterns');
            }
            return response()->json(['status' => 'success','url' => $url]);
        }catch(\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function deleteYarnRecommmendations(Request $request){
        $id = $request->id;
        $yarn = ProductYarnRecommendations::find($id);
        $deleted = $yarn->delete();

        if($deleted){
            ProductYarnRecommendationImages::where('p_pattern_yarn_recommendation_id',$id)->delete();
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

    function make_image_default(Request $request){
        $id = $request->id;
        $pattern_id = $request->pattern_id;
        $check = Product_images::where('product_id',$pattern_id)->where('main_photo',1)->count();

        if($check > 0){
            $array = array('main_photo' => 0);
            Product_images::where('product_id',$pattern_id)->update($array);
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
	
	/* check paypal credentials */

    function check_paypal_credentials(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'secret' => 'required',
        ]);

        $username = $request->username;
        $password = $request->password;
        $secret = $request->secret;
        $app_id = $request->app_id;
        $mode = env('PAYPAL_MODE');

        $paypalConfig = [
            'mode'    => $mode, // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'username'    => $username,
                'password'    => $password,
                'secret'      => $secret,
                'certificate' => '',
                'app_id'      => $app_id, // Used for testing Adaptive Payments API in sandbox mode
            ],
            'live' => [
                'username'    => $username,
                'password'    => $password,
                'secret'      => $secret,
                'certificate' => '',
                'app_id'      => $app_id, // Used for Adaptive Payments API
            ],
            'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => env('PAYPAL_CURRENCY', 'USD'),
            'billing_type'   => 'MerchantInitiatedBilling',
            'notify_url'     => '', // Change this accordingly for your application.
            'locale'         => '', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => true, // Validate SSL when creating api client.
            'invoice_prefix' => env('PAYPAL_INVOICE_PREFIX', 'PAYPAL')
        ];

        $data = [];
        $data['items'] = [
            [
                'name' => 'Testing business paypal',
                'price' => 0.01,
                'desc'  => 'Testing business paypal credentials',
                'qty' => 1
            ]
        ];

        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = url('/payment/success');
        $data['cancel_url'] = url('/cart');

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price']*$item['qty'];
        }
        $data['total'] = $total;

        $provider = new ExpressCheckout;
        $provider->setApiCredentials($paypalConfig);
        $response = $provider->setExpressCheckout($data);
        //$response = $provider->setExpressCheckout($data, true);
        if($response['paypal_link'] != ''){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail','message' => 'There is some issue with credentials.']);
        }
    }

    function get_paypal_credentials(Request $request){
        $user_id = $request->user_id;
        $paypal = PaypalCredentials::where('user_id',$user_id)->first();
		
        if($paypal){
            return response()->json(['status' => 'success','paypal_id' => $paypal->id,'store_name' => $paypal->store_name,'store_status' => $paypal->store_status,'account_type' => $paypal->account_type,'paypal_email' => $paypal->paypal_email]);
        }else{
            return response()->json(['status' => 'success','message' => 'No paypal credentials exists.']);
        }
    }
	
	function send_review_or_change_status(Request $request){

    $product_id = $request->product_id;
    $details = Products::find($product_id);
    $user = User::find($details->designer_name);
    if($request->statusType == 2){
        $wStatus = new ProductWorkStatus;
        $wStatus->user_id = Auth::user()->id;
        $wStatus->product_id = $product_id;
        $wStatus->w_status = 'Approved for upload';
        $wStatus->w_status_description = 'Design accepted';
        $wStatus->w_date = Carbon::now();
        $wStatus->created_at = Carbon::now();
        $wStatus->updated_at = Carbon::now();
        $save = $wStatus->save();

        $user->notify(new TraditionalPatternApproved($details));

    }else if($request->statusType == 3){
        $wStatus = new ProductWorkStatus;
        $wStatus->user_id = Auth::user()->id;
        $wStatus->product_id = $product_id;
        $wStatus->w_status = 'Design rejected';
        $wStatus->w_status_description = 'Design rejected';
        $wStatus->w_date = Carbon::now();
        $wStatus->created_at = Carbon::now();
        $wStatus->updated_at = Carbon::now();
        $save = $wStatus->save();

        $user->notify(new TraditionalPatternRejected($details));

    }else if($request->statusType == 5){
        $wStatus = new ProductWorkStatus;
        $wStatus->user_id = Auth::user()->id;
        $wStatus->product_id = $product_id;
        $wStatus->w_status = 'Released for review';
        $wStatus->w_status_description = 'Pattern released to designer for review';
        $wStatus->w_date = Carbon::now();
        $wStatus->created_at = Carbon::now();
        $wStatus->updated_at = Carbon::now();
        $save = $wStatus->save();

        $user->notify(new TraditionalPatternReleasedForReviewToDesigner($details));

    }else{
        $wStatus = new ProductWorkStatus;
        $wStatus->user_id = Auth::user()->id;
        $wStatus->product_id = $product_id;
        $wStatus->w_status = 'Approved for release';
        $wStatus->w_status_description = 'Pattern released for sale';
        $wStatus->w_date = Carbon::now();
        $wStatus->created_at = Carbon::now();
        $wStatus->updated_at = Carbon::now();
        $save = $wStatus->save();

        $pro = Products::find($product_id);
        $pro->status = 1;
        $pro->save();

        $user->notify(new TraditionalPatternReleasedForSale($details));

    }

    if($save){
        return response()->json(['status' => 'success','message' => 'Pattern sent for review.']);
    }else{
        return response()->json(['status' => 'error','message' => 'Pattern sent for review. Error in sending email.']);
    }


    exit;
		$toEmail = array('rkrishna021@gmail.com');
		$ccEmail = array('rkrishna021@gmail.com');
		
		$toEmail = 'jane.nickerson@knitfitco.com';
		$ccEmail = array('jane.nickerson@knitfitco.com','rkrishna021@gmail.com');
		
        $product_id = $request->product_id;
        if($request->statusType == 'review_admin'){
            $product = Products::find($product_id);
            $product->in_review = 1;
            $save = $product->save();

            $user = User::where('id',$product->designer_name)->first();

            $details = [
                'detail'=>'detail',
                'product_name' => $product->product_name,
                'userName' => 'Jane',
                'title' => 'Traditional pattern review',
                'description' => 'has been sent to you for review. Please check and suggest changes.',
				'description2' => 'If the pattern information and instructions are correct, submit the pattern to the designer for approval.click on <a href="https://stitchersstudio.com/website/review-pattern/">Approve or Suggest changes</a>',
                'pattern_url' => '',
                'statusType' => 'review_admin',
				'email' => $user->email,
                'temporary_password' => $user->temp_password,
				'temp_password' => $user->temp_password
            ];
            \Mail::to($toEmail)->cc($ccEmail)->send(new TraditionalPatternNotificationMail($details));
            if($save){
                return response()->json(['status' => 'success','message' => 'Pattern sent for review.']);
            }else{
                return response()->json(['status' => 'error','message' => 'Pattern sent for review. Error in sending email.']);
            }
        }else if($request->statusType == 'review_designer'){

            $product = Products::find($product_id);
            $product->in_review_designer = 1;
            $save = $product->save();

            $user = User::where('id',$product->designer_name)->first();

            $details = [
                'detail'=>'detail',
                'product_name' => $product->product_name,
                'userName' => $user->first_name.' '.$user->last_name,
                'title' => 'Traditional pattern review',
                'description' => 'has been sent to you for review. To access the design.',
				'description2' => 'Once you have reviewed the design, click on <a href="'.url('designer/main/view/pattern/'.$product->pid.'/' .$product->slug).'">Approve or Suggest changes</a> at the top of the page to suggest further changes or submit for publication.',
                'pattern_url' => url('designer/main/view/pattern/'.$product->pid.'/' .$product->slug),
                'statusType' => 'review_designer',
                'email' => $user->email,
                'temporary_password' => $user->temp_password,
				'temp_password' => $user->temp_password
            ];
            \Mail::to($user->email)->cc($ccEmail)->send(new TraditionalPatternNotificationMail($details));
            if($save){
                return response()->json(['status' => 'success','message' => 'Pattern sent for review.']);
            }else{
                return response()->json(['status' => 'error','message' => 'Pattern sent for review. Error in sending email.']);
            }
			
		}else if($request->statusType == 'live'){
			$product = Products::where('id',$product_id)->first();
			$paypal = PaypalCredentials::where('user_id',$product->designer_name)->first();
			
			if($paypal->paypal_email == ''){
				return response()->json(['status' => 'fail','message' => 'To make this pattern active fill the paypal details section in users menu.']);
				exit;
			}
			
            $product = Products::find($product_id);
            $product->status = 1;
            $save = $product->save();

            $user = User::where('id',$product->designer_name)->first();

            $details = [
                'detail'=>'detail',
                'product_name' => $product->product_name,
                'userName' => $user->first_name.' '.$user->last_name,
                'title' => 'Traditional pattern live',
                'description' => 'Congratulations! Your design has been published and it is LIVE on the StitchersStudio <a href="'.url("shop-patterns").'">Shop page</a>..',
				'description2' => "Now it's time for a social media blitz to let all of your followers know. Be sure to tag #stitchersstudio to reach a wider audience!",
				'pattern_url' => url('designer/main/view/pattern/'.$product->pid.'/' .$product->slug),
                'statusType' => 'live',
				'email' => $user->email,
                'temporary_password' => $user->temp_password,
				'temp_password' => $user->temp_password
            ];
            \Mail::to($user->email)->cc($ccEmail)->send(new TraditionalPatternNotificationMail($details));
            if($save){
                return response()->json(['status' => 'success','message' => 'Pattern is live & visible to everyone.']);
            }else{
                return response()->json(['status' => 'error','message' => 'Unable to make pattern live.Try again after sometime.']);
            }
        }else{
            return response()->json(['status' => 'error','message' => 'Invalid status selected.']);
        }
    }
}
