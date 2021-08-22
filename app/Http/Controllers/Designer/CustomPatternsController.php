<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\GaugeConversion;
use App\Models\MasterList;
use App\Models\NeedleSizes;
use App\Models\Pattern;
use App\Models\PatternImage;
use App\Models\PatternNeedles;
use App\Models\Patterns\ConditionalVariablesOutput;
use App\Models\Patterns\DesignType;
use App\Models\Patterns\Instructions;
use App\Models\Patterns\MeasurementVariables;
use App\Models\Patterns\PatternTemplate;
use App\Models\Patterns\Section;
use App\Models\Patterns\Snippet;
use App\Models\Patterns\SnippetFactorModifier;
use App\Models\Patterns\YarnDetails;
use App\Models\Products;
use App\Models\Subcategory;
use App\Models\YarnRecommendationImages;
use App\Models\YarnRecommendations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Image;
use Illuminate\Support\Str;
use DB;
use App\Models\PatternWorkStatus;
use App\Models\WorkStatus;

class CustomPatternsController extends Controller
{
    function __construct(){
        $this->middleware(['auth','roles']);
    }

    function index(){
        //$patterns = Pattern::all();
        $patterns = Auth::user()->patterns()->latest()->get();
        return view('designer.patterns.index',compact('patterns'));
    }

    function create_pattern(){
        $templates = PatternTemplate::where('created_by','admin')->where('status',1)->get();
        $productsCount = Pattern::orderBy('id','desc')->count();
        $pcount = $productsCount + 1;
        /* $garmentType = MasterList::where('type','garment_type')->get();
        $garmentConstruction = MasterList::where('type','garment_construction')->get(); */
        $garmentType = MasterList::where('type','garment_type')->get();
        $materialNeeded = MasterList::where('type','material_needed')->get();
        $designElements = MasterList::where('type','design_elements')->get();
        $shoulderConstruction = MasterList::where('type','shoulder_construction')->get();
        $designers = MasterList::where('type','designers')->get();
        $yarnWeight = MasterList::where('type','yarn_weight')->get();
        $needlesizes = NeedleSizes::all();
        $gaugeconversion = GaugeConversion::all();
        return view('designer.patterns.create',compact('templates','pcount','materialNeeded','designElements','shoulderConstruction','designers','yarnWeight','needlesizes','gaugeconversion','garmentType'));
    }

    function get_pattern_template(Request $request){
        $template_id = decrypt($request->template_id);
        try {
            $template = PatternTemplate::where('id',$template_id)->first();
            $pattern_template_id = $template->id;
            $allsections = $template->getAllSections;
            $designType = DesignType::find($template->design_type_id);
            $measurements = MeasurementVariables::all();
            return view('designer.patterns.showTemplate',compact('template','allsections','designType','measurements','pattern_template_id'));
        }catch (\Throwable $e){
            return response()->json(['error' => true,'message' => $e->getMessage()]);
        }
    }


    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-.]/', '', $string); // Removes special chars.
    }

    function upload_pattern_images(Request $request){
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


    function save_pattern(Request $request){
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
            /*'design_elements' => 'required',*/
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

            $pattern = new Pattern;
            $pattern->pid = md5($pcount);
            $pattern->user_id = Auth::user()->id;
            $pattern->sku = $request->sku;
            $pattern->pattern_go_live_date = date('Y-m-d',strtotime($request->pattern_go_live_date));
            $pattern->status = $request->status;
            $pattern->name = $request->name;
            $pattern->slug = Str::slug($request->name);
            $pattern->designer_name = $designer->id;
            $pattern->skill_level = $request->skill_level;
            $pattern->pattern_description = $request->pattern_description;
            $pattern->short_description = $request->short_description;
            $pattern->gauge_description = $request->gauge_description;
            $pattern->material_needed = $request->material_needed;
            $pattern->design_elements = $design_elements;
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

            if($request->submit_type == 'save'){
                $url = url('designer/my-patterns');
            }else{
                $url = url('designer/pattern/select-template/'.base64_encode($pattern->id));
            }
            return response()->json(['status' => 'success','url' => $url]);
        }catch(\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }

    }


    function edit_pattern(Request $request){
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
            return view('designer.patterns.edit',compact('pattern','materialNeeded','designElements','shoulderConstruction','designers','yarnWeight','needlesizes','gaugeconversion','garmentType','designer'));
        }catch (\Throwable $e){
            dd($e->getMessage());
        }
    }

    function update_pattern(Request $request){
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
            /*'design_elements' => 'required',*/
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
                $designer = MasterList::find($request->designer_id);
                $designer->name = $request->designer_name;
                $designer->slug = Str::slug($request->designer_name);
                $designer->updated_at = Carbon::now();
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
            $pattern_id = decrypt($request->pattern_id);
            $pattern = Pattern::find($pattern_id);
            $pattern->pattern_go_live_date = date('Y-m-d',strtotime($request->pattern_go_live_date));
            $pattern->status = $request->status;
            $pattern->name = $request->name;
            $pattern->slug = Str::slug($request->name);
            $pattern->designer_name = $designer->id;
            $pattern->skill_level = $request->skill_level;
            $pattern->pattern_description = $request->pattern_description;
            $pattern->short_description = $request->short_description;
            $pattern->gauge_description = $request->gauge_description;
            $pattern->material_needed = $request->material_needed;
            $pattern->design_elements = $design_elements;
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
                for ($j=0;$j<count($request->yarn_company);$j++) {

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
                    } else {
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
                    if($request->needle_size_id[$l] == 0){
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

            $temp = $pattern->templates()->first();
            if($temp){
                $url = url('designer/template/'.base64_encode($pattern->templates()->first()->id).'/'.Str::slug($pattern->templates()->first()->template_name));
            }else{
                $url = url('designer/pattern/select-template/'.base64_encode($pattern->id));
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

    function pattern_getWorkStatus(Request $request){
        $id = $request->id;
        $status = PatternWorkStatus::where('pattern_id',$id)->get();
        $workStatus = WorkStatus::where('status',1)->get();
        return view('designer.patterns.workStatus',compact('status','workStatus','id'));
    }

    function pattern_release(Request $request){
        try{
            $id = decrypt($request->id);
            $array = array('user_id' => Auth::user()->id,'pattern_id' => $id,'w_status' => $request->status,'w_date' => Carbon::now());
            PatternWorkStatus::where('pattern_id',$id)->insert($array);
            return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'error','message' => $e->getMessage()]);
        }
    }

    function delete_pattern(Request $request){

        try{

            $pattern_id = decrypt($request->id);

            $pattern = Pattern::find($pattern_id);

            if($pattern->yarnRecommmendations()->count() > 0){
                foreach ($pattern->yarnRecommmendations as $rec){
                    $yarn = YarnRecommendations::find($rec->id);
                    if($yarn->yarnImages()->count() > 0){
                        foreach($yarn->yarnImages as $yi){
                            $yimage = YarnRecommendationImages::find($yi->id);
                            $yimage->delete();
                        }
                    }
                    $yarn->delete();
                }
            }



            if($pattern->needles()->count() > 0){
                $pattern->needles()->delete();
            }

            if($pattern->patternImages()->count() > 0){
                $pattern->patternImages()->delete();
            }

            if($pattern->workStatus()->count() > 0){
                $pattern->workStatus()->delete();
            }

            $template_id = $pattern->templates()->first()->id;
            $template = PatternTemplate::find($template_id);
            if($template->getAllSections()->count() > 0){
                foreach($template->getAllSections as $allsections){
                    $sections = Section::find($allsections->id);
                    if($sections->snippets()->count() > 0){

                        foreach($sections->snippets as $snipets){
                            $snippet = Snippet::find($snipets->id);
                            $snippet->sections()->detach();
                            $snippet->delete();

                            if($snippet->snippetConditionalStatements()->count() > 0){
                                $snippet->snippetConditionalStatements()->detach();
                            }

                            if($snippet->yarnDetails()->count() > 0){
                                foreach($snippet->yarnDetails as $yd){
                                    $yarnd = YarnDetails::find($yd->id);
                                    $yarnd->delete();
                                }
                                $snippet->yarnDetails()->detach();
                            }

                            $sameAsCondition = DB::table('p_snippets_same_conditions')->where('snippets_id',$snippet->id)->get();
                            if($sameAsCondition->count() > 0){
                                DB::table('p_snippets_same_conditions')->where('snippets_id',$snippet->id)->delete();
                            }

                            if($snippet->instructions()->count() > 0){
                                foreach($snippet->instructions as $inst){
                                    $instructions = Instructions::find($inst->id);
                                    $instructions->delete();

                                    DB::table('p_snippet_instructions')->where('snippets_id',$snippet->id)->where('instructions_id',$inst->id)->delete();

                                }
                                //$snippet->instructions()->detach();
                            }
                        }

                    }
                    $sections->delete();
                }
                $template->getAllSections()->detach();
            }
            if($pattern->templates()->count() > 0){
                $pattern->templates()->detach();
            }
            $template->delete();
            $pattern->delete();
            return response()->json(['status' => 'success']);
        }catch (\Exception $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function select_pattern_template(Request $request){
        $pattern_id = base64_decode($request->pattern_id);
        $pattern = Pattern::find($pattern_id);
        if($pattern->templates()->count() > 0){
            return redirect()->back();
        }
        $templates = PatternTemplate::where('created_by','admin')->where('status',1)->get();
        return view('designer.patterns.select-pattern-template',compact('pattern_id','templates'));
    }

    function attach_pattern_to_template(Request $request){
        $request->validate([
            'pattern_id' => 'required',
            'template_id' => 'required'
        ]);

        $pattern_id = decrypt($request->pattern_id);
        $pattern = Pattern::find($pattern_id);
        $pat = Pattern::where('id',$pattern_id)->first();
        $designer = MasterList::where('id',$pat->designer_name)->first();
        $template_id = decrypt($request->template_id);
        $templates = PatternTemplate::where('id',$template_id)->first();
        $templateNameCount = PatternTemplate::where('template_name',$templates->template_name)->count();
        $tcount = $templateNameCount + 1;

        $new_template_name = $templates->template_name.'-'.Str::slug($designer->slug).'-'.$tcount;

        try {
            $template = PatternTemplate::find($template_id);
            $newTemplate = $template->replicate();
            $newTemplate->user_id = Auth::user()->id;
            $newTemplate->pattern_type = $request->pattern_type;
            $newTemplate->parent_template_id = $template_id;
            $newTemplate->template_name = $new_template_name;
            $newTemplate->created_by = 'designer';
            $newTemplate->created_at = Carbon::now();
            $newTemplate->save();

            $newTemplate->patterns()->attach([$pattern_id]);

            //$check = $template->push();
            if ($template->getAllSections()->count() > 0) {
                foreach ($template->getAllSections as $sections) {
                    $section = new Section;
                    $section->section_name = $sections->section_name;
                    $section->save();

                    $newTemplate->getAllSections()->attach([$section->id]);

                    if ($sections->snippets()->count() > 0) {
                        foreach ($sections->snippets as $snippets) {
                            $snippet = new Snippet;
                            $snippet->pattern_template_id = $newTemplate->id;
                            $snippet->snippet_name = $snippets->snippet_name;
                            $snippet->snippet_description = $snippets->snippet_description;
                            $snippet->function_id = $snippets->function_id;
                            $snippet->factor_value_in = $snippets->factor_value_in;
                            $snippet->factor_value_cm = $snippets->factor_value_cm;
                            $snippet->modifier_value = $snippets->modifier_value;
                            $snippet->input_variable = $snippets->input_variable;
                            $snippet->is_empty = $snippets->is_empty;
                            $snippet->is_concatinate = $snippets->is_concatinate;
                            $snippet->is_yarn = $snippets->is_yarn;
                            $snippet->save();

                            $snippet->sections()->attach([$section->id]);

                            if ($snippets->snippetConditionalStatements()->count() > 0) {
                                foreach ($snippets->snippetConditionalStatements as $cond) {
                                    $snippet->snippetConditionalStatements()->attach([$cond->id]);
                                }
                            }

                            $snipModifier = SnippetFactorModifier::where('snippets_id',$snippets->id)->get();
                            if($snipModifier->count() > 0){
                                foreach ($snipModifier as $sm){
                                    $snip = SnippetFactorModifier::find($sm->id);
                                    $newsnip = $snip->replicate();
                                    $newsnip->snippets_id = $snippet->id;
                                    $newsnip->pattern_template_id = $newTemplate->id;
                                    $newsnip->created_at = Carbon::now();
                                    $newsnip->save();
                                }
                            }

                            if($snippets->conditionalVariableOutput()->count() > 0){
                                foreach ($snippets->conditionalVariableOutput as $cond){
                                    $condvars = ConditionalVariablesOutput::find($cond->id);
                                    $newc = $condvars->replicate();
                                    $newc->user_id = Auth::user()->id;
                                    $newc->created_at = Carbon::now();
                                    $newc->save();
                                    $snippet->conditionalVariableOutput()->attach($newc->id);
                                }
                            }

                            $sameAsCondition = DB::table('p_snippets_same_conditions')->where('snippets_id', $snippets->id)->get();
                            if ($sameAsCondition->count() > 0) {
                                foreach ($sameAsCondition as $asc) {
                                    $condArray = array('snippets_id' => $snippet->id, 'conditional_statements_id' => $asc->conditional_statements_id, 'sameAsCondition' => $asc->sameAsCondition);
                                    $condId = DB::table('p_snippets_same_conditions')->insert($condArray);
                                }
                            }

                            if ($snippets->yarnDetails()->count() > 0) {
                                foreach ($snippets->yarnDetails as $yarnDetail) {
                                    $yarn = new YarnDetails;
                                    $yarn->yarn_title = $yarnDetail->yarn_title;
                                    $yarn->yarn_content = $yarnDetail->yarn_content;
                                    $yarn->save();

                                    $snippet->yarnDetails()->attach([$yarn->id]);
                                }
                            }


                            if ($snippets->instructions()->count() > 0) {
                                foreach ($snippets->instructions as $inst) {
                                    $instruction = Instructions::find($inst->id);
                                    $newInstruction = $instruction->replicate();
                                    $newInstruction->save();
                                    //$snippet->instructions()->attach([$newInstruction->id]);

                                    $snippetInstructions = DB::table('p_snippet_instructions')->where('snippets_id', $snippets->id)->where('instructions_id', $inst->id)->get();
                                    foreach ($snippetInstructions as $si) {
                                        $snipArray = array('snippets_id' => $snippet->id, 'instructions_id' => $newInstruction->id, 'conditional_statements_id' => $si->conditional_statements_id);
                                        DB::table('p_snippet_instructions')->insert($snipArray);
                                    }

                                }

                            }

                        }
                    }
                }
            }

            return response()->json(['status' => 'success','url' => url('designer/template/'.base64_encode($newTemplate->id).'/'.Str::slug($new_template_name))]);
        }catch (\Throwable $e){
            return response()->json(['status' => 'error','message' => $e->getMessage()]);
        }
    }
}
