<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\FormulaRequest;
use App\Models\FrComments;
use App\Models\FrOutputVariables;
use App\Models\Pattern;
use App\Models\Patterns\ConditionalVariablesOutput;
use App\Models\Patterns\DesignType;
use App\Models\Patterns\Functions;
use App\Models\Patterns\Instructions;
use App\Models\Patterns\MeasurementProfile;
use App\Models\Patterns\MeasurementValues;
use App\Models\Patterns\MeasurementVariables;
use App\Models\Patterns\OutputVariables;
use App\Models\Patterns\PatternTemplate;
use App\Models\Patterns\Section;
use App\Models\Patterns\Snippet;
use App\Models\Patterns\SnippetFactorModifier;
use App\Models\Patterns\YarnDetails;
use App\Notifications\NewFormulaRequestApproval;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\Mail\UserNewFormulaRequest;
use Mail;
use App\Notifications\NewFormulaRequestMessageNotification;
use App\Events\NewFormulaRequestMessages;
use Laravolt\Avatar\Facade as Avatar;

class FormulasController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    function update_template_name(Request $request){
        $templateCount = PatternTemplate::where('template_name',$request->value)->count();
        if($templateCount > 0){
            return response()->json(['status' => false,'message' => 'Template name already exists. Please select another name.']);
        }else{
            return response()->json(['status' => true]);
        }
    }

    function show_pattern_template(Request $request){
        $id = base64_decode($request->id);
        $template = PatternTemplate::where('id',$id)->first();
        if(!$template){
            return redirect('designer/my-patterns');
        }
        $array = '';
        $output_variables = OutputVariables::select('variable_name')->get();
        $designType = DesignType::find($template->design_type_id);
        $functions = $designType->functions()->orderBy('function_name')->get();
        $measurements = MeasurementProfile::where('user_id',Auth::user()->id)->get();
        $mvariables = MeasurementVariables::all();
        $pattern_id = $template->patterns()->first()->id;
        $pattern = Pattern::find($pattern_id);

        return view('designer.patterns.editPatternTemplate',compact('template','output_variables','id','designType','measurements','mvariables','pattern','functions'));
    }

    function get_all_sections(Request $request){
        $pattern_template_id = $request->pattern_template_id;
        $template = PatternTemplate::find($pattern_template_id);
        $allsections = $template->getAllSections;
        $designType = DesignType::find($template->design_type_id);
        $measurements = MeasurementVariables::all();
        return view('designer.patterns.allsections',compact('pattern_template_id','allsections','designType','measurements'));
    }

    function get_new_section(Request $request){
        $pattern_template_id = $request->pattern_template_id;
        $template = PatternTemplate::find($pattern_template_id);
        $section = $template->getNewSection()->first();
        return view('designer.patterns.newsection',compact('section','pattern_template_id'));
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
			//$function = Functions::where('id',$function_id)->where('status',1)->first();
            $check = $function->child()->get();
			//$check = $function->child()->where('status',1)->get();
            $array = array();
            $array1 = 0;
            $array2 = array();
            //echo count($check);
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

                if($array1 != $check->count()){
                    $parentFunction = Functions::whereIn('id',$array2)->get();
                    return response()->json(['status' => 'parent_error','child_function' => $function->function_name, 'parentFunction' => $parentFunction,'snippetsCount' => $snippetsCount,'checkCount' => $check->count()]);
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
            return view('designer.patterns.yarn-details',compact('pattern_template_id','section_id','did','dataCount','template','designType','function','measurements'));
            exit;
        }

        if($function_id == 'concatinate' || $function_id == 30){
            return view('designer.patterns.concatinate-snippet',compact('pattern_template_id','section_id','did','dataCount','template','designType','function','measurements'));
            exit;
        }

        if($function_id == 'empty'){
            return view('designer.patterns.empty-snippet',compact('pattern_template_id','section_id','did','dataCount'));
            exit;
        }

        return view('designer.patterns.functiondata',compact('pattern_template_id','function','section_id','did','designType','dataCount','measurements','allFunctions'));
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

                    if($snippet->snippetConditionalStatements()->count() > 0){
                        $snippet->snippetConditionalStatements()->detach();
                    }

                    if($snippet->conditionalVariableOutput()->count() > 0){
                        $snippet->conditionalVariableOutput()->delete();
                        $snippet->conditionalVariableOutput()->detach();
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

    function preview_pattern_template(Request $request){
        $template_id = $request->template_id;
        $measurement_id = $request->measurement_id;
        $template = PatternTemplate::where('id',$template_id)->first();
        $measurements = MeasurementVariables::all();
        $mvalues = MeasurementValues::where('measurement_profile_id',$measurement_id)->get();
        $mprofile = MeasurementProfile::where('id',$measurement_id)->first();
        return view('designer.patterns.template-preview',compact('template','measurements','measurement_id','mvalues','mprofile'));
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

    function add_snippet(Request $request){
        /*echo '<pre>';
        print_r($request->all());
        echo '</pre>';
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

        /*if($request->factor_id_in){
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

    function template_get_yarn_details(Request $request){
        $id = $request->id;
        $template = PatternTemplate::find($id);
        return view('designer.patterns.yarn-details',compact('template'));
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

        /*if($request->factor_id_in){
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
        }*/
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
                    /*$cv = ConditionalVariablesOutput::find($request->conditional_variables_outputs_id[$m]);
                    $cv->condition_description = $request->condition_description[$m];
                    $cv->updated_at = Carbon::now();
                    $cv->save();*/
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


    /************************************ NEW FORMULA REQUEST FUNCTIONS ********************************/

    function formula_requests(){
        $patterns = Auth::user()->patterns()->latest()->get();
        $formulas = Auth::user()->formulaRequests()->where('status',1)->latest()->get();
        return view('designer.newformula.index',compact('patterns','formulas'));
    }

    function new_formula_request(Request $request){
        $pattern_id = base64_decode($request->pattern_id);
        $patterns = Pattern::where('id',$pattern_id)->first();
        $measurements = MeasurementVariables::all();
        return view('designer.newformula.create',compact('patterns','measurements'));
    }

    function save_formula_request(Request $request){
        $request->validate([
           'formula_name' => 'required',
            'input_variables' => 'required|array',
            'output_variable_name' => 'required|array',
            'formula' => 'required|array'
        ]);

        $formulaCount = FormulaRequest::orderBy('id','desc')->first();
        if($formulaCount){
            $fc = $formulaCount->id + 1;
        }else{
            $fc = 1;
        }
        $fcount = md5($fc);

        $input_variables = implode(',',$request->input_variables);

        $formula = new FormulaRequest;
        $formula->enc_id = $fcount;
        $formula->user_id = Auth::user()->id;
        $formula->pattern_id = $request->pattern_id;
        $formula->formula_name = $request->formula_name;
        $formula->input_variables = $input_variables;
        $formula->factor_name_inch = $request->factor_name_inch;
        $formula->min_value_in = $request->min_value_in;
        $formula->max_value_in = $request->max_value_in;
        $formula->factor_name_cm = $request->factor_name_cm;
        $formula-> min_value_cm= $request->min_value_cm;
        $formula->max_value_cm = $request->max_value_cm;
        $formula->modifier_name = $request->modifier_name;
        $formula->min_value = $request->min_value;
        $formula->max_value = $request->max_value;
        $formula->f_status = 'Requested';
        $save = $formula->save();

        if($save){
            for ($i=0;$i<count($request->output_variable_name);$i++){
                $output = new FrOutputVariables;
                $output->user_id = Auth::user()->id;
                $output->output_variable_name = $request->output_variable_name[$i];
                $output->formula = $request->formula[$i];
                $output->comments = $request->comments[$i];
                $output->save();
                $formula->outputVariables()->attach([$output->id]);
            }
            $details = array('formula_name' => $request->formula_name);
            \Mail::to('info@knitfitco.com')->send(new UserNewFormulaRequest($details));
            return response()->json(['status' => 'success','url' => route('formula.requests')]);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to submit formula now , try again after some time.']);
        }
    }

    function edit_requested_formula(Request $request){
        $id = $request->id;
        $formula = FormulaRequest::leftJoin('p_patterns','p_patterns.id','p_formula_requests.pattern_id')
                    ->select('p_formula_requests.*','p_patterns.name')
                    ->where('p_formula_requests.enc_id',$id)->first();
        $measurements = MeasurementVariables::all();
        $fcomments = $formula->comments()->leftJoin('users','users.id','p_fr_comments.user_id')
            ->select('p_fr_comments.*','users.first_name','users.last_name','users.picture')
            ->paginate(10);
        if($request->ajax()){
            $fcomments = $formula->comments()->leftJoin('users','users.id','p_fr_comments.user_id')
                ->select('p_fr_comments.*','users.first_name','users.last_name','users.picture')
                ->paginate(10);
        }
        return view('designer.newformula.edit',compact('formula','measurements','fcomments'));
    }

    function view_requested_formula(Request $request){
        $id = $request->id;
        $formula = FormulaRequest::leftJoin('p_patterns','p_patterns.id','p_formula_requests.pattern_id')
            ->select('p_formula_requests.*','p_patterns.name')
            ->where('p_formula_requests.enc_id',$id)->first();
        $measurements = MeasurementVariables::all();
        $fcomments = $formula->comments()->leftJoin('users','users.id','p_fr_comments.user_id')
            ->select('p_fr_comments.*','users.first_name','users.last_name','users.picture')
            ->latest()
            ->paginate(10);
        if($request->ajax()){
            $fcomments = $formula->comments()->leftJoin('users','users.id','p_fr_comments.user_id')
                ->select('p_fr_comments.*','users.first_name','users.last_name','users.picture')
                ->latest()
                ->paginate(10);
        }

        return view('designer.newformula.view',compact('formula','measurements','fcomments'));
    }

    function outputVariable_delete(Request $request){
        $id = $request->id;
        $frequest = FrOutputVariables::find($id);
        $frequest->formulaRequest()->detach();
        $del = $frequest->delete();

        if($del){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete output variable now , try again after some time.']);
        }
    }

    function delete_new_formula_request(Request $request){
        $id = decrypt($request->id);
        $formula = FormulaRequest::find($id);
        if($formula->outputVariables()->count() > 0){
            foreach ($formula->outputVariables as $out){
                $frequest = FrOutputVariables::find($out->id);
                $frequest->delete();
            }
            $formula->outputVariables()->detach();
        }

        if($formula->comments()->count() > 0){
            foreach ($formula->comments as $comm){
                $comment = FrComments::find($comm->id);
                $comment->delete();
            }
            $formula->comments()->detach();
        }
        $del = $formula->delete();
        if($del){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to delete new formula now , try again after some time.']);
        }
    }

    function update_formula_request(Request $request){
        $request->validate([
            'formula_name' => 'required',
            'input_variables' => 'required|array',
            'output_variable_name' => 'required|array',
            'formula' => 'required|array'
        ]);

        $id = decrypt($request->formula_id);

        $input_variables = implode(',',$request->input_variables);

        $formula = FormulaRequest::find($id);
        $formula->formula_name = $request->formula_name;
        $formula->input_variables = $input_variables;
        $formula->factor_name_inch = $request->factor_name_inch;
        $formula->min_value_in = $request->min_value_in;
        $formula->max_value_in = $request->max_value_in;
        $formula->factor_name_cm = $request->factor_name_cm;
        $formula-> min_value_cm= $request->min_value_cm;
        $formula->max_value_cm = $request->max_value_cm;
        $formula->modifier_name = $request->modifier_name;
        $formula->min_value = $request->min_value;
        $formula->max_value = $request->max_value;
        $save = $formula->save();

        if($save){
            for ($i=0;$i<count($request->output_variable_id);$i++){
                if($request->output_variable_id[$i] == 0){
                    $output = new FrOutputVariables;
                    $output->user_id = Auth::user()->id;
                    $output->output_variable_name = $request->output_variable_name[$i];
                    $output->formula = $request->formula[$i];
                    $output->comments = $request->comments[$i];
                    $output->save();
                    $formula->outputVariables()->attach([$output->id]);
                }else{
                    $output = FrOutputVariables::find($request->output_variable_id[$i]);
                    $output->output_variable_name = $request->output_variable_name[$i];
                    $output->formula = $request->formula[$i];
                    $output->comments = $request->comments[$i];
                    $output->save();
                }
            }

            return response()->json(['status' => 'success','url' => route('formula.requests')]);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to submit formula now , try again after some time.']);
        }
    }

    function add_comment(Request $request){
        $id = decrypt($request->formula_id);

        $formula = FormulaRequest::find($id);

        $comment = new FrComments;
        $comment->user_id = Auth::user()->id;
        $comment->comments = $request->comments;
        $save = $comment->save();

        $formula->comments()->attach([$comment->id]);

        $user = User::find(16);
        $user->notify(new NewFormulaRequestMessageNotification($comment,$formula));

        if(Auth::user()->picture){
            $pic = Auth::user()->picture;
        }else{
            $picture = Avatar::create(Auth::user()->first_name)->toBase64();
            $pic = $picture->encoded;
        }

        $array = array('comment_id' => $comment->id,'comments' => $request->comments,'created_at' => Carbon::now()->diffForHumans(),'user_id' => Auth::user()->id,'name' => Auth::user()->first_name.' '.Auth::user()->last_name,'picture' => $pic);

        broadcast(new NewFormulaRequestMessages($array,$id,16))->toOthers();

        if($save){
            $fcomments = $formula->comments()->leftJoin('users','users.id','p_fr_comments.user_id')
                ->select('p_fr_comments.*','users.first_name','users.last_name','users.picture')
                ->where('p_fr_comments.id',$comment->id)
                ->get();

            return view('designer.newformula.new-comment',compact('fcomments'));
            //return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error','message' => 'Unable to update formula , try again after sometime.']);
        }
    }


    function get_formula_work_status(Request $request){
        $formula = FormulaRequest::where('enc_id',$request->id)->first();
        return view('designer.newformula.work-status',compact('formula'));
    }
}
