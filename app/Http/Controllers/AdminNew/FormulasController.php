<?php

namespace App\Http\Controllers\AdminNew;

use App\Http\Controllers\Controller;
use App\Models\FormulaRequest;
use App\Models\Patterns\ConditionalStatement;
use App\Models\Patterns\ConditionalVariable;
use App\Models\Patterns\DesignType;
use App\Models\Patterns\Factor;
use App\Models\Patterns\FunctionsHierarchy;
use App\Models\Patterns\IfConditions;
use App\Models\Patterns\Instructions;
use App\Models\Patterns\Modifier;
use App\Models\Patterns\OutputVariables;
use App\Models\Patterns\PatternTemplate;
use App\Models\Patterns\Section;
use App\Models\Patterns\Snippet;
use App\Models\Patterns\YarnDetails;
use App\Notifications\NewFormulaRequestMessageNotification;
use Illuminate\Http\Request;
use Auth;
use App\Models\Patterns\Functions;
use Carbon\Carbon;
use DB;
use App\User;
use App\Models\Patterns\MeasurementVariables;
use App\Models\Patterns\MeasurementProfile;
use App\Models\Patterns\MeasurementValues;
use App\Notifications\NewFormulaRequestApproval;
use App\Models\FrComments;
use App\Events\NewFormulaRequestMessages;
use Laravolt\Avatar\Facade as Avatar;
use App\Models\Patterns\SnippetFactorModifier;
use App\Models\Patterns\ConditionalVariablesOutput;
use Illuminate\Http\JsonResponse;

class FormulasController extends Controller
{
    function __construct(){
    	$this->middleware('auth');
    }

    function index(){
        $functions = Functions::where('status',1)->get();
    	return view('adminnew.Formulas.index',compact('functions'));
    }

    function view_pattern_template(Request $request){
        $templates = PatternTemplate::leftJoin('p_design_type','p_pattern_template.design_type_id','p_design_type.id')->select('p_pattern_template.id','p_design_type.design_varient_name','p_pattern_template.template_name','p_pattern_template.status','p_pattern_template.created_at')->where('p_pattern_template.created_by','admin')->get();
        $design_type_groups = DesignType::select('design_type_name')->groupBy('design_type_name')->get();
        return view('adminnew.Pattern-Templates.index',compact('templates','design_type_groups'));
    }

    function create_pattern_template(Request $request){
        $templates = PatternTemplate::leftJoin('p_design_type','p_pattern_template.design_type_id','p_design_type.id')->select('p_pattern_template.id','p_design_type.design_varient_name','p_pattern_template.template_name','p_pattern_template.status','p_pattern_template.created_at')->where('p_pattern_template.created_by','admin')->get();
        $design_type_groups = DesignType::select('design_type_name')->groupBy('design_type_name')->get();
        return view('adminnew.Pattern-Templates.create',compact('design_type_groups','templates'));
    }

    function check_template_name(Request $request){
        if($request->template_name){
            $template_name = $request->template_name;
        }else{
            $template_name = $request->new_template_name;
        }


        $template = PatternTemplate::where('template_name',$template_name)->count();
        if($template > 0){
            return response()->json(['valid' => false]);
        }else{
            return response()->json(['valid' => true]);
        }
    }

    function save_pattern_template(Request $request){
        $request->validate([
            'design_type_id' => 'required',
            'template_name' => 'required|unique:p_pattern_template'
        ]);
        $template = new PatternTemplate;
        $template->user_id = Auth::user()->id;
        $template->design_type_id = $request->design_type_id;
        $template->template_name = $request->template_name;
        $template->created_by = 'admin';
        $template->created_at = Carbon::now();
        $save = $template->save();
        if($save){
            $url = url('adminnew/pattern-template/'.base64_encode($template->id).'/show');
            return response()->json(['status' => 'success', 'URL' => $url]);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function show_pattern_template(Request $request){
        /*$array = array(1,2,3,4);
        $array1 = array(21,22,23,24,25,26,27,28,29);
        for($i=0;$i<count($array1);$i++){
            for ($j=0;$j<count($array);$j++){
                $arr = array('functions_id' =>$array1[$i]);
                //echo $array1[$i].'<br>';
                DB::table('p_functions_output_varibles')->insert($arr);
            }

        }
        exit; */
        $id = base64_decode($request->id);
        $template = PatternTemplate::where('id',$id)->first();
        if(!$template){
            return redirect('adminnew/pattern-templates-list');
        }
        $array = '';
        $output_variables = OutputVariables::select('variable_name')->get();
        $designType = DesignType::find($template->design_type_id);
        $functions = $designType->functions()->orderBy('function_name')->get();
        $measurements = MeasurementProfile::where('user_id',Auth::user()->id)->get();
        $mvariables = MeasurementVariables::all();

        return view('adminnew.Pattern-Templates.show',compact('template','output_variables','id','designType','measurements','mvariables','functions'));
    }

    function add_template_data(Request $request){
        $fname = $request->fname;
        $variable = $request->$fname;
        $id = base64_decode($request->id);

        $template = PatternTemplate::find($id);
        $template->$fname = $variable;
        $save = $template->save();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function template_get_yarn_details(Request $request){
        $id = $request->id;
        $template = PatternTemplate::find($id);
        return view('adminnew.Pattern-Templates.yarn-details',compact('template'));
    }

    function template_delete_yarn_details(Request $request){
        $id = $request->id;

        try{
            $yarn = YarnDetails::find($id);
            $yarn->patterntemplate()->detach();
            $yarn->delete();
            return response()->json(['status' => 'success']);
        }catch(\Exception $e){
            return response()->json(['status' => 'error','message' => $e->getMessage()]);
        }
    }

    function template_add_yarn_details(Request $request){
        echo '<pre>';
        print_r($request->all());
        echo '</pre>';
        exit;

        $pattern_template_id = base64_decode($request->id);
        $template = PatternTemplate::find($pattern_template_id);
try{
    if($request->yarn_details){
        for ($i=0;$i<count($request->yarn_details);$i++){
            if($request->yarn_detail_id[$i] == 0){
                $yarn = YarnDetails::create([
                    'yarn_content' => $request->yarn_details[$i]
                ]);
                $template->yarnDetails()->attach([$yarn->id]);
            }else{
                $yarn = YarnDetails::where('id',$request->yarn_detail_id[$i])->update([
                    'yarn_content' => $request->yarn_details[$i]
                ]);
            }
        }
    }
    return response()->json(['status' => 'success']);
}catch (\Exception $e){
    return response()->json(['status' => 'error','message' => $e->getMessage()]);
}


    }

    function check_section_name(Request $request){
        $pattern_template_id = $request->get('pattern_template_id');
        $section_name = $request->get('section_name');
        $section = Section::where('section_name',$section_name)
            ->whereHas('patterntemplate', function ($query) use($pattern_template_id) {
            $query->where('pattern_template_id', $pattern_template_id);
        })->count();

        if($section > 0){
            return response()->json(['valid' => false]);
        }else{
            return response()->json(['valid' => true]);
        }
    }

    function pattern_template_add_section(Request $request){
        $request->validate([
            'section_name' => 'required'
        ]);
        $section_name = $request->section_name;
        $section = new Section;
        $section->section_name = $section_name;
        $section->created_at = Carbon::now();
        $save = $section->save();
        if($save){
            $section->patterntemplate()->attach([$request->pattern_template_id]);
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function get_all_sections(Request $request){
        $pattern_template_id = $request->pattern_template_id;
        $template = PatternTemplate::find($pattern_template_id);
        $allsections = $template->getAllSections;
        $designType = DesignType::find($template->design_type_id);
        $measurements = MeasurementVariables::all();
        return view('adminnew.Pattern-Templates.allsections',compact('pattern_template_id','allsections','designType','measurements'));
    }

    function get_new_section(Request $request){
        $pattern_template_id = $request->pattern_template_id;
        $template = PatternTemplate::find($pattern_template_id);
        $section = $template->getNewSection()->first();
        return view('adminnew.Pattern-Templates.newsection',compact('section','pattern_template_id'));
    }

    function get_function_attributes(Request $request){
        $pattern_template_id = $request->pattern_template_id;
        $function_id = $request->function_id;
        $section_id = $request->section_id;
        $did = $request->did;
        $dataCount = $request->dataCount;
        $again = $request->again;
        $measurements = MeasurementVariables::all();


        if(is_numeric($function_id)) {
            $function = Functions::find($function_id);
            $check = $function->child()->get();
            $array = array();
            $array1 = 0;
            $array2 = array();

            if($check->count() > 0){
                for ($i=0;$i<count($check);$i++){
                    $parent_functions_id = $check[$i]->parent_functions_id;
                    $snippetsCount = Snippet::where('pattern_template_id',$pattern_template_id)->where('function_id', $parent_functions_id)->count();
                    if($snippetsCount == 0){
                        $array2[] = $parent_functions_id;
                    }
                    array_push($array, $parent_functions_id);
                    $array1+=$snippetsCount;
                }

                if($array1 != $check->count()) {
                    $parentFunction = Functions::whereIn('id', $array2)->get();
                    return response()->json(['status' => 'parent_error', 'child_function' => $function->function_name, 'parentFunction' => $parentFunction]);
                    exit;
                }
            }

            $template = PatternTemplate::find($pattern_template_id);
            if ($template->getAllSections()->count() > 0) {
                foreach ($template->getAllSections as $sections) {
                    $snippetsCount = Section::find($sections->id)->snippets()->where('function_id', $function_id)->count();
                    if (($snippetsCount > 0) && ($again == 0)) {
                        return response()->json(['status' => 'error', 'message' => 'This function was already added.Please select another one.']);
                        exit;
                    }
                }
            }
           /* if ($check->count() > 0) {
                foreach ($check as $index => $ck) {
                    $snippetsCount = Section::find($section_id)->snippets()->where('function_id', $ck->parent_functions_id)->count();
                    if ($snippetsCount == 0) {
                        $parentFunction = Functions::find($ck->parent_functions_id);
                        $array[$index]['function_name'] = $parentFunction->function_name
                        return response()->json(['status' => 'parent_error', 'child_function' => $function->function_name ,'message' =>  $parentFunction->function_name]);
                        exit;
                    }
                }
            } */
        }
        //exit;
       /* if(is_numeric($function_id)) { /*  && $function_id != 30 for concatinate snippet *

        } */

        $template = PatternTemplate::find($pattern_template_id);
        $designType = DesignType::find($template->design_type_id);
		$allFunctions = $designType->functions()->orderBy('function_name')->get();
        if($function_id == 'concatinate'){
            $function = Functions::where('id',30)->first();
        }else{
            $function = Functions::where('id',$function_id)->first();
        }
        $measurements = MeasurementVariables::all();

        if($function_id == 'yarndetails'){
            return view('adminnew.Pattern-Templates.yarn-details',compact('pattern_template_id','section_id','did','dataCount','template','designType','function','measurements'));
            exit;
        }

        if($function_id == 'concatinate' || $function_id == 30){
            return view('adminnew.Pattern-Templates.concatinate-snippet',compact('pattern_template_id','section_id','did','dataCount','template','designType','function','measurements'));
            exit;
        }

        if($function_id == 'empty'){
            return view('adminnew.Pattern-Templates.empty-snippet',compact('pattern_template_id','section_id','did','dataCount'));
            exit;
        }

        /*$snippetsCount = Section::find($section_id)->snippets()->where('function_id',$function_id)->count();
        if($snippetsCount > 0){
            return response()->json(['status' => 'error','message' => 'This snippet was already added.Please select another one.']);
            exit;
        }*/

        return view('adminnew.Pattern-Templates.functiondata',compact('pattern_template_id','function','section_id','did','designType','dataCount','measurements','allFunctions'));
    }
	
	function remove_added_functions(Request $request){
        $pattern_template_id = $request->pattern_template_id;
        $template = PatternTemplate::find($pattern_template_id);
        $designType = DesignType::find($template->design_type_id);
        $allFunctions = $designType->functions()->orderBy('function_name')->get();
        $array = array();
        for ($i=0;$i< $allFunctions->count();$i++){
            $snippetsCount = Snippet::where('pattern_template_id',$pattern_template_id)->where('function_id',
                $allFunctions[$i]->id)->count();
            if($snippetsCount == 0) {
                $array[$i]['id'] = $allFunctions[$i]->id;
                $array[$i]['function_name'] = $allFunctions[$i]->function_name;
            }

        }

        return response()->json(['data' => $array]);
    }

    function add_snippet(Request $request){
        /*echo '<pre>';
        print_r($request->all());
        echo '<pre>';
        exit;*/

        $snippet = new Snippet;
        $snippet->pattern_template_id = $request->pattern_template_id;
        $snippet->snippet_name = $request->snippet_name;
        if($request->is_empty == 1){
            $snippet->function_id = 0;
            $snippet->snippet_description = $request->snippet_description;
            $snippet->is_empty = $request->is_empty;
        }else{
            $snippet->function_id = $request->function_name;
        }

        if($request->is_concatinate == 1){
            $snippet->function_id = 0;
            $snippet->is_concatinate = 1;
           // $snippet->input_variable = $request->input_variable;
        }

        if($request->is_yarn == 1){
            $snippet->function_id = 0;
            $snippet->is_yarn = 1;
        }

        /* if($request->factor_id_in){
            $snippet->factor_value_in = $request->factor_id_in;
        }else{
            $snippet->factor_value_in = 0;
        } */

        /* if($request->factor_id_cm){
            $snippet->factor_value_cm = $request->factor_id_cm;
        }else{
            $snippet->factor_value_cm = 0;
        }*/

        /*if($request->modifier){
            $snippet->modifier_value = $request->modifier;
        }*/



        $snippet->created_at = Carbon::now();
        $save = $snippet->save();

        if($save){

            if(isset($request->factor_in)){
                for($i=0;$i<count($request->factor_in);$i++){
                    $fm = new SnippetFactorModifier;
                    $fm->pattern_template_id = $request->pattern_template_id;
                    $fm->snippets_id = $snippet->id;
                    $fm->functions_id = $request->function_name;
                    $fm->is_factor_modifier = 1;
                    $fm->factor_modifier_id = $request->factor_id;
                    $fm->factor_modifier_name = $request->factor_name;
                    $fm->input_value_in = $request->factor_in[$i];
                    $fm->input_value_cm = $request->factor_cm[$i];
                    $fm->created_at = Carbon::now();
                    $fm->save();
                }
            }

            if(isset($request->modifier_in)){
                for($j=0;$j<count($request->modifier_in);$j++){
                    $fm1 = new SnippetFactorModifier;
                    $fm1->pattern_template_id = $request->pattern_template_id;
                    $fm1->snippets_id = $snippet->id;
                    $fm1->functions_id = $request->function_name;
                    $fm1->is_factor_modifier = 2;
                    $fm1->factor_modifier_id = $request->modifier_id;
                    $fm1->factor_modifier_name = $request->modifier_name;
                    $fm1->input_value_in = $request->modifier_in[$j];
                    $fm1->input_value_cm = $request->modifier_cm[$j];
                    $fm1->created_at = Carbon::now();
                    $fm1->save();
                }
            }

            if(isset($request->condition_variable_id)){
                for ($m=0;$m<count($request->condition_variable_id);$m++){
					if($request->condition_description[$m] == '<p><br></p>'){
                        $description = '';
                    }else{
                        $description = $request->condition_description[$m];
                    }
                    $cv = new ConditionalVariablesOutput;
                    $cv->user_id = Auth::user()->id;
                    $cv->function_id = $request->function_name;
                    $cv->if_condition_id = $request->if_condition_id[$m];
                    $cv->condition_variable_id = $request->condition_variable_id[$m];
                    $cv->condition_description = $description;
                    if($m % 2 == 0){
                        $cv->condition_type = 'Y';
                    }else{
                        $cv->condition_type = 'N';
                    }
                    $cv->save();

                    $snippet->conditionalVariableOutput()->attach([$cv->id]);
                }
            }

            $snippet->sections()->attach([$request->section_id]);

            if($request->cond_stmt_id) {
                for ($j = 0; $j < count($request->cond_stmt_id); $j++) {
                    $snippet->snippetConditionalStatements()->attach([$request->cond_stmt_id[$j]]);
                    if($request->is_concatinate == 1 || $request->is_empty == 1) {
                        $arr = array('snippets_id' => $snippet->id,'conditional_statements_id' => $request->cond_stmt_id[$j],'created_at' => Carbon::now());
                    }else{
                        $arr = array('snippets_id' => $snippet->id,'conditional_statements_id' => $request->cond_stmt_id[$j],'sameAsCondition' => $request->sameAsCondition[$j],'created_at' => Carbon::now());
                    }

                    DB::table('p_snippets_same_conditions')->insert($arr);
                }
            }

            if($request->description){
                for ($i=0;$i<count($request->description);$i++){
                    $instruction = new Instructions;
                    $instruction->description = $request->description[$i];
                    $instruction->created_at = Carbon::now();
                    $instruction->save();

                    $array = array('snippets_id' => $snippet->id, 'instructions_id' => $instruction->id, 'conditional_statements_id' => $request->conditional_statements_id[$i]);
                    DB::table('p_snippet_instructions')->insert($array);
                    //$snippet->instructions()->attach([$instruction->id]);
                    //$instruction->instructionsConditionalStatements()->attach([$request->conditional_statements_id[$i]]);
                }
            }

            if($request->is_yarn == 1){
                for($y=0;$y<count($request->yarn_title);$y++){
                    if($request->yarn_detail_id[$y] == 0){
                        $yarn = new YarnDetails;
                        $yarn->yarn_title = $request->yarn_title[$y];
                        $yarn->yarn_content = $request->yarn_details[$y];
                        $yarn->save();

                        $snippet->yarnDetails()->attach([$yarn->id]);
                    }else{
                        $yarn = YarnDetails::find($request->yarn_detail_id[$y]);
                        $yarn->yarn_title = $request->yarn_title[$y];
                        $yarn->yarn_content = $request->yarn_details[$y];
                        $yarn->save();
                    }
                }
            }

            return response()->json(['status' => 'success','section_id' => $request->section_id]);
        }else{
            return response()->json(['status' => 'fail']);
        }

    }

    function update_snippet(Request $request){
        /*echo '<pre>';
        print_r($request->all());
        echo '</pre>';
        exit;*/
        $snippet = Snippet::find($request->snippet_id);
        $snippet->snippet_name = $request->snippet_name;
        if($request->is_empty == 1){
            $snippet->function_id = 0;
            $snippet->snippet_description = $request->snippet_description;
            $snippet->is_empty = $request->is_empty;
        }else{
            $snippet->function_id = $request->function_name;
        }

        if($request->is_concatinate == 1){
            $snippet->function_id = 0;
            $snippet->is_concatinate = 1;
            //$snippet->input_variable = $request->input_variable;
        }

        /* if($request->factor_id_in){
            $snippet->factor_value_in = $request->factor_id_in;
        }else{
            $snippet->factor_value_in = 0;
        }

        if($request->factor_id_cm){
            $snippet->factor_value_cm = $request->factor_id_cm;
        }else{
            $snippet->factor_value_cm = 0;
        }

        if($request->modifier){
            $snippet->modifier_value = $request->modifier;
        }else{
            $snippet->modifier_value = 0;
        } */
        $snippet->updated_at = Carbon::now();
        $save = $snippet->save();

        if($save) {

            if(isset($request->factor_in)){
                for($i=0;$i<count($request->factor_in);$i++){
					if($request->snip_factor_id == 0){
						$fm = new SnippetFactorModifier;
						$fm->pattern_template_id = $request->pattern_template_id;
						$fm->snippets_id = $snippet->id;
						$fm->functions_id = $request->function_name;
						$fm->is_factor_modifier = 1;
						$fm->factor_modifier_id = $request->factor_id;
						$fm->factor_modifier_name = $request->factor_name;
						$fm->input_value_in = $request->factor_in[$i];
						$fm->input_value_cm = $request->factor_cm[$i];
						$fm->created_at = Carbon::now();
						$fm->save();
					}else{
						$fm = SnippetFactorModifier::find($request->snip_factor_id);
						$fm->snippets_id = $snippet->id;
						$fm->functions_id = $request->function_name;
						$fm->is_factor_modifier = 1;
						$fm->factor_modifier_id = $request->factor_id;
						$fm->factor_modifier_name = $request->factor_name;
						$fm->input_value_in = $request->factor_in[$i];
						$fm->input_value_cm = $request->factor_cm[$i];
						$fm->updated_at = Carbon::now();
						$fm->save();
					}
                }
            }

            if(isset($request->modifier_in)){
                for($j=0;$j<count($request->modifier_in);$j++){
					if($request->snip_modifier_id == 0){
						$fm1 = new SnippetFactorModifier;
						$fm1->pattern_template_id = $request->pattern_template_id;
						$fm1->snippets_id = $snippet->id;
						$fm1->functions_id = $request->function_name;
						$fm1->is_factor_modifier = 2;
						$fm1->factor_modifier_id = $request->modifier_id;
						$fm1->factor_modifier_name = $request->modifier_name;
						$fm1->input_value_in = $request->modifier_in[$j];
						$fm1->input_value_cm = $request->modifier_cm[$j];
						$fm1->created_at = Carbon::now();
						$fm1->save();
					}else{
						$fm1 = SnippetFactorModifier::find($request->snip_modifier_id);
						$fm1->snippets_id = $snippet->id;
						$fm1->functions_id = $request->function_name;
						$fm1->is_factor_modifier = 2;
						$fm1->factor_modifier_id = $request->modifier_id;
						$fm1->factor_modifier_name = $request->modifier_name;
						$fm1->input_value_in = $request->modifier_in[$j];
						$fm1->input_value_cm = $request->modifier_cm[$j];
						$fm1->updated_at = Carbon::now();
						$fm1->save();
					}
                }
            }

            if(isset($request->conditional_variables_outputs_id)){
                for ($m=0;$m<count($request->conditional_variables_outputs_id);$m++){
					if($request->condition_description[$m] == '<p><br></p>'){
                        $description = '';
                    }else{
                        $description = $request->condition_description[$m];
                    }
                    if($request->conditional_variables_outputs_id[$m] == 0){
                        $cv = new ConditionalVariablesOutput;
                        $cv->user_id = Auth::user()->id;
                        $cv->function_id = $request->function_name;
                        $cv->if_condition_id = $request->if_condition_id[$m];
                        $cv->condition_variable_id = $request->condition_variable_id[$m];
                        $cv->condition_description = $description;
                        if($m % 2 == 0){
                            $cv->condition_type = 'Y';
                        }else{
                            $cv->condition_type = 'N';
                        }
                        $cv->save();

                        $snippet->conditionalVariableOutput()->attach([$cv->id]);
                    }else{
                        $cv = ConditionalVariablesOutput::find($request->conditional_variables_outputs_id[$m]);
                        $cv->condition_description = $description;
                        $cv->updated_at = Carbon::now();
                        $cv->save();
                    }

                }
            }

            if($request->is_concatinate != 1) {
                if ($request->cond_stmt_id) {
                    for ($j = 0; $j < count($request->cond_stmt_id); $j++) {
                        $arr = array('sameAsCondition' => $request->sameAsCondition[$j], 'updated_at' => Carbon::now());
                        DB::table('p_snippets_same_conditions')->where('id', $request->checkbox_id[$j])->update($arr);
                    }
                }
            }

            if($request->is_yarn == 1){
                for($y=0;$y<count($request->yarn_title);$y++){
                    if($request->yarn_detail_id[$y] == 0){
                        $yarn = new YarnDetails;
                        $yarn->yarn_title = $request->yarn_title[$y];
                        $yarn->yarn_content = $request->yarn_details[$y];
                        $yarn->save();

                        $snippet->yarnDetails()->attach([$yarn->id]);
                    }else{
                        $yarn = YarnDetails::find($request->yarn_detail_id[$y]);
                        $yarn->yarn_title = $request->yarn_title[$y];
                        $yarn->yarn_content = $request->yarn_details[$y];
                        $yarn->save();
                    }
                }
            }

            if($request->instructions_id) {
                for ($i = 0; $i < count($request->instructions_id); $i++) {
                    $instruction = Instructions::find($request->instructions_id[$i]);
                    $instruction->description = $request->description[$i];
                    $instruction->updated_at = Carbon::now();
                    $instruction->save();
                }
            }
            return response()->json(['status' => 'success','section_id' => $request->section_id]);
        }else{
            return response()->json(['status' => 'fail']);
        }

    }

    function delete_snippet(Request $request){
        $snippet_id = $request->snippet_id;
        if(!is_numeric($snippet_id)){
            return response()->json(['status' => 'success','message' => 'Not integer']);
            exit;
        }
        try{
        $snippet_id = $request->snippet_id;
        $snippet = Snippet::find($snippet_id);
        $snippet->sections()->detach();
        $snippet->delete();

        $snipModifier = SnippetFactorModifier::where('snippets_id',$snippet->id)->count();
        if($snipModifier > 0){
            SnippetFactorModifier::where('snippets_id',$snippet->id)->delete();
        }

        if($snippet->conditionalVariableOutput()->count() > 0){
            $snippet->conditionalVariableOutput()->delete();
            $snippet->conditionalVariableOutput()->detach();
        }

        if($snippet->snippetConditionalStatements()->count() > 0){
            $snippet->snippetConditionalStatements()->detach();
        }

        if($snippet->yarnDetails()->count() > 0){
            $snippet->yarnDetails()->delete();
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

            return response()->json(['status' => 'success']);
        }catch (\Exception $e){
            return response()->json(['status' => 'success','message' => $e->getMessage()]);
        }

    }

    function update_section_name(Request $request){
        $pk = $request->pk;
        $exp = explode('_',$pk);
        $value = $request->value;
        $pattern_template_id = $exp[1];

        $section = Section::where('section_name',$value)
            ->whereHas('patterntemplate', function ($query) use($pattern_template_id) {
                $query->where('pattern_template_id', $pattern_template_id);
            })->count();

        if($section > 0){
            return response()->json(['status' => false,'message' => 'Section name already exists. Please select another name.']);
        }else{
            $section = Section::find($exp[0]);
            $section->section_name = $value;
            $save = $section->save();
            if($save){
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => false,'message' => 'Unable to update section name.']);
            }
        }

    }

    function delete_section(Request $request){
        try{

        $section_id = $request->section_id;
        $section = Section::find($section_id);
        $section->delete();
        if($section->patterntemplate()->count() > 0){
            $section->patterntemplate()->detach();
        }

        if($section->snippets()->count() > 0){

           foreach($section->snippets as $snipets){
               $snippet = Snippet::find($snipets->id);
               $snippet->sections()->detach();
               $snippet->delete();

               $snipModifier = SnippetFactorModifier::where('snippets_id',$snippet->id)->count();
               if($snipModifier > 0){
                   SnippetFactorModifier::where('snippets_id',$snippet->id)->delete();
               }

               if($snippet->conditionalVariableOutput()->count() > 0){
                   $snippet->conditionalVariableOutput()->delete();
                   $snippet->conditionalVariableOutput()->detach();
               }

               if($snippet->snippetConditionalStatements()->count() > 0){
                   $snippet->snippetConditionalStatements()->detach();
               }


               if($snippet->yarnDetails()->count() > 0){
                   $snippet->yarnDetails()->delete();
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
            return response()->json(['status' => 'success']);
        }catch (\Exception $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function delete_pattern_template(Request $request){
        $template_id = $request->template_id;

        try{
            $template = PatternTemplate::find($template_id);
            if($template->getAllSections()->count() > 0){
                foreach($template->getAllSections as $allsections){
                    $sections = Section::find($allsections->id);
                    if($sections->snippets()->count() > 0){

                        foreach($sections->snippets as $snipets){
                            $snippet = Snippet::find($snipets->id);
                            $snippet->sections()->detach();
                            $snippet->delete();

                            $snipModifier = SnippetFactorModifier::where('snippets_id',$snippet->id)->count();
                            if($snipModifier > 0){
                                SnippetFactorModifier::where('snippets_id',$snippet->id)->delete();
                            }

                            if($snippet->conditionalVariableOutput()->count() > 0){
                                $snippet->conditionalVariableOutput()->delete();
                                $snippet->conditionalVariableOutput()->detach();
                            }

                            if($snippet->snippetConditionalStatements()->count() > 0){
                                $snippet->snippetConditionalStatements()->detach();
                            }

                            if($snippet->yarnDetails()->count() > 0){
                                $snippet->yarnDetails()->delete();
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
            $template->delete();
            return response()->json(['status' => 'success']);
        }catch (\Exception $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }


    function duplicate_pattern_template(Request $request){
        $template_id = $request->template_id;
        $new_template_name = $request->new_template_name;
        try{
            $template = PatternTemplate::find($template_id);
            $newTemplate = $template->replicate();
			$newTemplate->parent_template_id = $template_id;
            $newTemplate->template_name = $new_template_name;
            $newTemplate->save();
            //$check = $template->push();
            if($template->getAllSections()->count() > 0){
                foreach($template->getAllSections as $sections)
                {
                    $section = new Section;
                    $section->section_name = $sections->section_name;
                    $section->save();

                    $newTemplate->getAllSections()->attach([$section->id]);



                    if($sections->snippets()->count() > 0){
                        foreach ($sections->snippets as $snippets) {
                            $snippet = new Snippet;
                            $snippet->pattern_template_id = $newTemplate->id;
                            $snippet->snippet_name = $snippets->snippet_name;
                            $snippet->snippet_description = $snippets->snippet_description;
                            $snippet->function_id =  $snippets->function_id;
                            $snippet->factor_value_in = $snippets->factor_value_in;
                            $snippet->factor_value_cm = $snippets->factor_value_cm;
                            $snippet->modifier_value = $snippets->modifier_value;
                            $snippet->input_variable = $snippets->input_variable;
                            $snippet->is_empty = $snippets->is_empty;
                            $snippet->is_concatinate = $snippets->is_concatinate;
                            $snippet->is_yarn = $snippets->is_yarn;
                            $snippet->save();

                            $snippet->sections()->attach([$section->id]);

                            if($snippets->snippetConditionalStatements()->count() > 0){
                                foreach($snippets->snippetConditionalStatements as $cond){
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

                            $sameAsCondition = DB::table('p_snippets_same_conditions')->where('snippets_id',$snippets->id)->get();
                            if($sameAsCondition->count() > 0){
                                foreach($sameAsCondition as $asc){
                                    $condArray = array('snippets_id' => $snippet->id,'conditional_statements_id' => $asc->conditional_statements_id,'sameAsCondition' => $asc->sameAsCondition);
                                    $condId = DB::table('p_snippets_same_conditions')->insert($condArray);

                                }

                            }

                            if($snippets->yarnDetails()->count() > 0){
                                foreach($snippets->yarnDetails as $yarnDetail){
                                    $yarn = new YarnDetails;
                                    $yarn->yarn_title = $yarnDetail->yarn_title;
                                    $yarn->yarn_content = $yarnDetail->yarn_content;
                                    $yarn->save();

                                    $snippet->yarnDetails()->attach([$yarn->id]);
                                }

                            }


                            if($snippets->instructions()->count() > 0){
                                foreach($snippets->instructions as $inst){
                                    $instruction = Instructions::find($inst->id);
                                    $newInstruction = $instruction->replicate();
                                    $newInstruction->save();
                                    //$snippet->instructions()->attach([$newInstruction->id]);

                                    $snippetInstructions = DB::table('p_snippet_instructions')->where('snippets_id',$snippets->id)->where('instructions_id',$inst->id)->get();
                                    foreach ($snippetInstructions as $si){
                                        $snipArray = array('snippets_id' => $snippet->id, 'instructions_id' => $newInstruction->id, 'conditional_statements_id' => $si->conditional_statements_id);
                                        DB::table('p_snippet_instructions')->insert($snipArray);
                                    }

                                }




                            }

                        }
                    }
                }
            }



            return response()->json(['status' => 'success','message' => $newTemplate]);
        }catch(\Exception $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function preview_pattern_template(Request $request){
        $template_id = $request->template_id;
        $measurement_id = $request->measurement_id;
        $template = PatternTemplate::where('id',$template_id)->first();
        $measurements = MeasurementVariables::all();
        $mvalues = MeasurementValues::where('measurement_profile_id',$measurement_id)->get();
        $mprofile = MeasurementProfile::where('id',$measurement_id)->first();
        return view('adminnew.Pattern-Templates.template-preview',compact('template','measurements','measurement_id','mvalues','mprofile'));
    }

    /******************************************** new formula requests ****************************************/


    function new_formula_requests(Request $request){
        $formulas = FormulaRequest::where('status',1)->get();
        return view('adminnew.New-formula-requests.index',compact('formulas'));
    }

    function edit_new_formula_requests(Request $request){
        $id = $request->id;
        $formulas = FormulaRequest::leftJoin('users','users.id','p_formula_requests.user_id')
                    ->select('p_formula_requests.*','users.first_name','users.last_name')
                    ->where('p_formula_requests.enc_id',$id)->first();
        $fcomments = $formulas->comments()->leftJoin('users','users.id','p_fr_comments.user_id')
                    ->select('p_fr_comments.*','users.first_name','users.last_name','users.picture')
            ->latest()
                    ->paginate(10);
        if($request->ajax()){
            $fcomments = $formulas->comments()->leftJoin('users','users.id','p_fr_comments.user_id')
                ->select('p_fr_comments.*','users.first_name','users.last_name','users.picture')
                ->latest()
                ->paginate(10);
        }
        if($formulas->f_status == 'Requested'){
            $array = array('f_status' => 'In Review','review_at' => Carbon::now());
            FormulaRequest::where('id',$formulas->id)->update($array);
        }
        return view('adminnew.New-formula-requests.edit',compact('formulas','fcomments'));
    }

    function completed_new_formula_requests(Request $request){
        $id = decrypt($request->formula_id);

        $formula = FormulaRequest::find($id);
        if($request->type == 'update_complete') {
            $formula->f_status = 'Completed';
            $formula->completed_at = Carbon::now();
            $formula->save();
        }

        if($request->type == 'update_rejected') {
            $formula->f_status = 'Rejected';
            $formula->rejected_at = Carbon::now();
            $formula->save();
        }

        $comment = new FrComments;
        $comment->user_id = Auth::user()->id;
        $comment->comments = $request->comments;
        $save = $comment->save();

        $formula->comments()->attach([$comment->id]);

        $user = User::find($formula->user_id);
        $user->notify(new NewFormulaRequestMessageNotification($comment,$formula));

        $picture = Avatar::create('Admin')->toBase64();
        $pic = $picture->encoded;

        $array = array('comment_id' => $comment->id,'comments' => $request->comments,'created_at' => Carbon::now()->diffForHumans(),'user_id' => Auth::user()->id,'name' => 'Admin','picture' => $pic);

        broadcast(new NewFormulaRequestMessages($array,$id,$formula->user_id))->toOthers();

        if($save){
            if($request->type == 'update_complete') {
                $user = User::find($formula->user_id);
                $user->notify(new NewFormulaRequestApproval($formula));
            }

            $fcomments = $formula->comments()->leftJoin('users','users.id','p_fr_comments.user_id')
                ->select('p_fr_comments.*','users.first_name','users.last_name','users.picture')
                ->where('p_fr_comments.id',$comment->id)
                ->get();

            return view('adminnew.New-formula-requests.new-comment',compact('fcomments'));
            //return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to update formula , try again after sometime.']);
        }
    }

    function get_formula_work_status(Request $request){
        $formula = FormulaRequest::where('enc_id',$request->id)->first();
        return view('adminnew.New-formula-requests.work-status',compact('formula'));
    }

    /* output variables */

    function output_variables(Request $request){
        $outputVariables = OutputVariables::where('status',1)->get();
        $jsonArray = array();
        if($request->ajax()){
            for($i=0;$i<$outputVariables->count();$i++){
                $jsonArray[$i]['id'] = $outputVariables[$i]->id;
                $jsonArray[$i]['variable_name'] = $outputVariables[$i]->variable_name;
                $jsonArray[$i]['variable_description'] = '<div class="addReadMore showlesscontent">'.$outputVariables[$i]->variable_description.'</div>';
                $jsonArray[$i]['action'] = '<a href="javascript:;" data-id="'.$outputVariables[$i]->id.'" class="fa fa-pencil editOutputVariable" title="Edit" data-toggle="modal" data-target=".bd-example-modal-lg"></a>';
            }
            return response()->json(['data' => $jsonArray]);
        }
        return view('adminnew.Formulas.output-variables',compact('outputVariables'));
    }

    function edit_output_variables(Request $request){
        $ov = OutputVariables::where('id',$request->id)->first();
        return response()->json(['id' => $ov->id,'variable_name' => $ov->variable_name,'variable_description' => $ov->variable_description]);
    }

    function update_output_variables(Request $request){
        $output = OutputVariables::find($request->id);
        $output->variable_description = $request->variable_description;
        $save = $output->save();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    /* sample instructions */

    function sample_instructions(Request $request){
        $sampleInstructions = Functions::where('status',1)->get();
        $outputVariables = OutputVariables::where('status',1)->get();
        $jsonArray = array();
        if($request->ajax()){
            for($i=0;$i<$sampleInstructions->count();$i++){
                $jsonArray[$i]['id'] = $sampleInstructions[$i]->id;
                $jsonArray[$i]['function_name'] = $sampleInstructions[$i]->function_name;
                $jsonArray[$i]['sample_instruction'] = '<div class="addReadMore showlesscontent">'.$sampleInstructions[$i]->sample_instruction.'</div>';
                $jsonArray[$i]['output_instruction'] = '<div class="addReadMore showlesscontent">'.$sampleInstructions[$i]->output_instruction.'</div>';
                $jsonArray[$i]['action'] = '<a href="javascript:;" data-id="'.$sampleInstructions[$i]->id.'" class="fa fa-pencil editSampleInstructions" title="Edit" data-toggle="modal" data-target=".bd-example-modal-lg"></a>';
            }
            return response()->json(['data' => $jsonArray]);
        }
        return view('adminnew.Formulas.sample-instructions',compact('sampleInstructions','outputVariables'));
    }

    function edit_sample_instructions(Request $request){
        $functions = Functions::where('id',$request->id)->first();
        return response()->json(['id' => $functions->id,'function_name' => $functions->function_name,'sample_instruction' => $functions->sample_instruction,'output_instruction' => $functions->output_instruction]);
    }

    function update_sample_instructions(Request $request){
        $function = Functions::find($request->id);
        $function->sample_instruction = $request->sample_instruction;
        $function->output_instruction = $request->output_instruction;
        $save = $function->save();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }
	
	/* Functions only rama krishna use */
	function get_all_data(Request $request){
        $function = Functions::find($request->id);
        return view('adminnew.Pattern-Templates.test',compact('function'));
    }

    function submit_all_data(Request $request){
		$request->validate([
			'function_name' => 'required',
			'description' => 'required',
			'condition_id' => 'required'
		]);
		
        $function_name = $request->function_name;
        $function_id = $request->functions_id;
        $conditionalStatement = $request->description;

        $function = Functions::find($function_id);
        $newFunction = $function->replicate();
        $newFunction->function_name = $function_name;
        $newFunction->save();
        echo 'Function created successfully';
        echo '<br>';

        $designVarients = $function->designVarients()->get();
        if($designVarients->count() > 0){
            foreach($designVarients as $design){
                $array5 = array('functions_id' => $newFunction->id,'design_type_id' => $design->id);
                DB::table('p_design_type_functions')->insert($array5);
            }
            echo 'Design varients created successfully';
            echo '<br>';
        }else{
            echo 'No Design varients to add.';
            echo '<br>';
        }

        $factor = $function->factors()->get();
        if($factor->count() > 0){
            foreach($factor as $fac){
                $array = array('functions_id' => $newFunction->id,'factor_id' => $fac->id,'factor_uom' => $fac->pivot->factor_uom);
                DB::table('p_functions_factor')->insert($array);
            }
            echo 'Factor created successfully';
            echo '<br>';
        }else{
            echo 'No factors to add.';
            echo '<br>';
        }

        $modifier = $function->modifiers()->get();
        if($modifier->count() > 0){
            foreach($modifier as $mod){
                $array1 = array('functions_id' => $newFunction->id,'modifier_id' => $mod->id,'modifier_uom' => $mod->pivot->factor_uom);
                DB::table('p_functions_modifier')->insert($array1);
            }
            echo 'Modifiers created successfully';
            echo '<br>';
        }else{
            echo 'No modifiers to add.';
            echo '<br>';
        }

        $inputs = $function->inputVariables()->get();
        if($inputs->count() > 0){
            foreach($inputs as $inp){
                $array2 = array('functions_id' => $newFunction->id,'measurement_variables_id' => $inp->id);
                DB::table('p_functions_measurement_variables')->insert($array2);
            }
            echo 'Inputs created successfully';
            echo '<br>';
        }else{
            echo 'No inputs to add.';
            echo '<br>';
        }

        $outputs = $function->outputVariables()->get();
        if($outputs->count() > 0){
            foreach($outputs as $out){
                $array3 = array('functions_id' => $newFunction->id,'output_variables_id' => $out->id);
                DB::table('p_functions_output_varibles')->insert($array3);
            }
            echo 'Outputs created successfully';
            echo '<br>';
        }else{
            echo 'No outputs to add.';
            echo '<br>';
        }

        $inpAsoutputs = $function->inputAsOutputVariables()->get();
        if($inpAsoutputs->count() > 0){
            foreach($inpAsoutputs as $out1){
                $array4 = array('functions_id' => $newFunction->id,'output_variables_id' => $out1->id);
                DB::table('p_functions_output_input_varibles')->insert($array4);
            }
            echo 'inputAsOutputVariables created successfully';
            echo '<br>';
        }else{
            echo 'No input as outputs to add.';
            echo '<br>';
        }



        if($request->condition_id == 0){
            $condition = new ConditionalStatement;
            $condition->description = $conditionalStatement;
            $save = $condition->save();
            if($save){
                $array6 = array('functions_id' => $newFunction->id,'conditional_statements_id' => $condition->id);
                DB::table('p_functions_conditional_statements')->insert($array6);
                echo 'Conditional statements created successfully';
                echo '<br>';
            }else{
                echo 'No conditional statements to add.';
                echo '<br>';
            }
        }else{
            $array6 = array('functions_id' => $newFunction->id,'conditional_statements_id' => $request->condition_id);
            DB::table('p_functions_conditional_statements')->insert($array6);
            echo 'Conditional statements created successfully';
            echo '<br>';
        }



        $childs = $function->child()->get();
        if($childs->count() > 0){
            foreach($childs as $ch) {
                $array7 = array('parent_functions_id' => $newFunction->id,'child_functions_id' => $ch->id);
                DB::table('p_functions_hierarchy')->insert($array7);
            }
            echo 'hierarchy created successfully';
            echo '<br>';
        }else{
            echo 'No hierarchy to add.';
            echo '<br>';
        }

        $ifConditions = $function->ifConditions()->get();
        if($ifConditions->count() > 0){
            foreach($ifConditions as $ifc){
                $array8 = array('functions_id' => $newFunction->id,'if_conditions_id' => $ifc->id);
                DB::table('p_functions_if_conditions')->insert($array8);

                /*$condvars = $ifc->conditionalVariables()->get();
                if($condvars->count() > 0){
                    foreach($condvars as $cv) {
                        $array9 = array('if_conditions_id' => $ifc->id, 'conditional_variables_id' => $cv->id);
                        DB::table('p_if_conditions_conditional_variables')->insert($array9);
                    }
                }*/
            }
            echo 'If conditions created successfully';
            echo '<br>';
        }else{
            echo 'No if conditions to add.';
            echo '<br>';
        }

    }
	
	
	/* creating a new formula */

    function create_new_update_formula_page(Request $request){
        $designType = DesignType::where('status',1)->get();
        $factors = Factor::where('status',1)->get();
        $modifiers = Modifier::where('status',1)->get();
        $measurementVariables = MeasurementVariables::all();
        $outputVariables = OutputVariables::all();
        $conditionalStatements = ConditionalStatement::where('status',1)->get();
        $functions = Functions::where('status',1)->get();
        if($request->id){
            $function = Functions::where('id',$request->id)->where('status',1)->first();
            if(!$function){
                echo 'This is inactive function';
                exit;
            }
            return view('adminnew.Formulas.update-formula',compact('designType','function','factors','modifiers','measurementVariables','outputVariables','conditionalStatements'));
        }
        return view('adminnew.Formulas.create-formula',compact('designType','factors','modifiers','measurementVariables','outputVariables','conditionalStatements','functions'));
    }

    function update_formula_page(Request $request){
        /* echo '<pre>';
        print_r($request->all());
        echo '</pre>';
        exit; */

        try{

        $function_id = $request->functions_id;
        $function = Functions::find($function_id);

        if($request->factor_id){
            for ($i=0;$i < count($request->factor_id); $i++){
                $function->factors()->attach($request->factor_id[$i]);
            }
        }

        if($request->modifier_id){
            for ($j=0;$j < count($request->modifier_id); $j++){
                $function->modifiers()->attach([$request->modifier_id[$j]]);
            }
        }

        if($request->measurement_variables_id){
            for ($k=0;$k < count($request->measurement_variables_id); $k++){
                $function->inputVariables()->attach([$request->measurement_variables_id[$k]]);
            }
        }
		
		if($request->detach_output_variables_id){
            for ($d=0;$d<count($request->detach_output_variables_id);$d++){
                $function->outputVariables()->detach([$request->detach_output_variables_id[$d]]);
            }
        }

        if($request->output_variables_id){
            for ($l=0;$l < count($request->output_variables_id);$l++){
                if(is_numeric($request->output_variables_id[$l])){
                    $function->outputVariables()->attach([$request->output_variables_id[$l]]);
                }else{
                    $uc = str_replace(" ","_",$request->output_variables_id[$l]);
                    $output = new OutputVariables;
                    $output->variable_name = strtoupper($uc);
                    $output->save();
                    $function->outputVariables()->attach([$output->id]);
                }
            }
        }

        if($request->output_as_input_id){
            for ($m=0;$m < count($request->output_as_input_id); $m++){
                $function->inputAsOutputVariables()->attach([$request->output_as_input_id[$m]]);
            }
        }

        if($request->parent_function_id){
            for ($n=0;$n < count($request->parent_function_id); $n++){
                $hkey = new FunctionsHierarchy;
                $hkey->parent_functions_id = $request->parent_function_id[$n];
                $hkey->child_functions_id = $function->id;
                $hkey->save();
            }
        }

        if($request->condition_variable){
            for ($m=0;$m<count($request->condition_variable);$m++){
                $ifcond = new IfConditions;
                $ifcond->condition_variable = $request->condition_variable[$m];
                $ifcond->save();
                $function->ifConditions()->attach([$request->condition_variable[$m]]);

                $condvar = $request->condition_text[$m];
                $condvar1 = $request->condition_type[$m];
                for ($n=0;$n<count($condvar);$n++){
                    $condvars = new ConditionalVariable;
                    $condvars->condition_text = $condvar[$n];
                    $condvars->condition_type = $condvar1[$n];
                    $condvars->save();
                    $ifcond->conditionalVariables()->attach([$condvars->id]);
                }
            }
        }
            return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'error','message' => $e->getMessage()]);
        }

    }

    function create_formula_page(Request $request){
        /* echo '<pre>';
        print_r($request->all());
        echo '</pre>';
        exit;*/
        try{

        $function = new Functions;
        $function->function_name = $request->function_name;
        $function->prgm_name = $request->prgm_name;
        $save = $function->save();

        if($save){
            $function->designVarients()->attach([$request->design_type_id]);

            if($request->factor_id){
                for ($i=0;$i < count($request->factor_id);$i++){
                    $function->factors()->attach([$request->factor_id[$i]]);
                }
            }

            if($request->modifier_id){
                for ($j=0;$j < count($request->modifier_id);$j++){
                    $function->modifiers()->attach([$request->modifier_id[$j]]);
                }
            }

            if($request->measurement_variables_id){
                for ($k=0;$k < count($request->measurement_variables_id);$k++){
                    $function->inputVariables()->attach([$request->measurement_variables_id[$k]]);
                }
            }

            if($request->output_variables_id){
                for ($l=0;$l < count($request->output_variables_id);$l++){
                    if(is_numeric($request->output_variables_id[$l])){
                        $function->outputVariables()->attach([$request->output_variables_id[$l]]);
                    }else{
                        $uc = str_replace(" ","_",$request->output_variables_id[$l]);
                        $output = new OutputVariables;
                        $output->variable_name = strtoupper($uc);
                        $output->save();
                        $function->outputVariables()->attach([$output->id]);
                    }
                }
            }

            if($request->output_as_input_id){
                for ($l=0;$l < count($request->output_as_input_id);$l++){
                    $function->inputAsOutputVariables()->attach([$request->output_as_input_id[$l]]);
                }
            }

            if($request->description){
                if(is_numeric($request->description)){
                    $function->conditionalStatements()->attach([$request->description]);
                }else{
                    $condition = new ConditionalStatement;
                    $condition->description = $request->description;
                    $condition->save();
                    $function->conditionalStatements()->attach([$condition->id]);
                }
            }

            if($request->parent_function_id){
                for ($n=0;$n < count($request->parent_function_id); $n++){
                    $hkey = new FunctionsHierarchy;
                    $hkey->parent_functions_id = $request->parent_function_id[$n];
                    $hkey->child_functions_id = $function->id;
                    $hkey->save();
                }
            }

            if($request->condition_variable){
                for ($m=0;$m<count($request->condition_variable);$m++){
                    if(is_numeric($request->condition_variable[$m])){
                        $ifcond = IfConditions::find($request->condition_variable[$m]);
                        $function->ifConditions()->attach([$request->condition_variable[$m]]);

                        $condvars = $ifcond->conditionalVariables()->get();
                        if($condvars->count() > 0){
                            foreach($condvars as $cv){
                                $ifcond->conditionalVariables()->attach([$cv->id]);
                            }
                        }
                    }else{
                        $ifcond = new IfConditions;
                        $ifcond->condition_variable = $request->condition_variable[$m];
                        $ifcond->save();
                        $function->ifConditions()->attach([$ifcond->id]);

                        $condvar = $request->condition_text[$m];
                        $condvar1 = $request->condition_type[$m];
                        for ($n=0;$n<count($condvar);$n++){
                            $condvars = new ConditionalVariable;
                            $condvars->condition_text = $condvar[$n];
                            $condvars->condition_type = $condvar1[$n];
                            $condvars->save();
                            $ifcond->conditionalVariables()->attach([$condvars->id]);
                        }
                    }
                }
            }
            return response()->json(['status' => 'success']);
        }
        }catch (\Throwable $e){
            return response()->json(['status' => 'error','message' => $e->getMessage()]);
        }
    }
	
	
	function update_function_name_csv(){
        $fileD = fopen(storage_path('csv/functions1.csv'),"r");
        $column=fgetcsv($fileD);
        while(!feof($fileD)){
            $rowData[]=fgetcsv($fileD);
        }
        echo 'Total rows : '.count($rowData).'<br>';
        $i=1;
        foreach ($rowData as $key => $value) {
            if($value){
                $inserted_data=array('function_name'=>$value[1]);
                $save = Functions::where('id',$value[0])->update($inserted_data);
                if($save){
                    echo $i.') Updated '.$value[0].' <br>';
                }
            }

        $i++;
        }
    }
	
	
	
	function show_hierarchy(Request $request){
        $jsonArray = array();
        $functions = Functions::where('status',1)->get();
        $hierarchy = FunctionsHierarchy::all();
        for ($i=0;$i< $hierarchy->count();$i++){
            $parentFunction = Functions::where('id',$hierarchy[$i]->parent_functions_id)->first();
            $childFunction = Functions::where('id',$hierarchy[$i]->child_functions_id)->first();

            $jsonArray[$i]['id'] = $hierarchy[$i]->id;
            $jsonArray[$i]['child_function'] = $childFunction->function_name;
            $jsonArray[$i]['parent_function'] = $parentFunction->function_name;
            $jsonArray[$i]['action'] = '<a href="javascript:;" data-id="'.$hierarchy[$i]->id.'" title="Delete" class="fa fa-trash-o deleteHierarchy"></a>';
        }
        if($request->ajax()){
            return response()->json(['data' => $jsonArray]);
        }
        return view('adminnew.Formulas.hierarchy',compact('functions'));
    }

    function delete_hierarchy(Request $request){
        try{
            $id = $request->id;
            $hierarchy = FunctionsHierarchy::find($id);
            $hierarchy->delete();
            return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function add_hierarchy(Request $request){
        $request->validate([
            'parent_functions_id' => 'required',
            'child_functions_id' => 'required'
        ]);

        try{
            $parent_functions_id = $request->parent_functions_id;
            $child_functions_id = $request->child_functions_id;

            $hierarchyCount = FunctionsHierarchy::where('parent_functions_id',$parent_functions_id)->where('child_functions_id',$child_functions_id)->count();
            if($hierarchyCount > 0){
                return response()->json(['status' => 'fail','message' => 'This hierarchy is already added.']);
                exit;
            }

            $hierarchy = new FunctionsHierarchy;
            $hierarchy->parent_functions_id = $parent_functions_id;
            $hierarchy->child_functions_id = $child_functions_id;
            $hierarchy->created_at = Carbon::now();
            $hierarchy->save();

            return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }
}
