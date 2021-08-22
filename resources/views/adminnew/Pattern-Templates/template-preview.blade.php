<?php $inputs1 = array(); $inputs1A = array(); $inputs2 = array(); ?>
@if($measurements->count() > 0)
    @foreach($measurements as $meas)
        @php
            $measurementvalues = App\Models\Patterns\MeasurementValues::where('measurement_profile_id',$measurement_id)->where('measurement_variable_id',$meas->id)->first();
            $inp = strtoupper($meas->variable_name);
            $inputs1[] = str_replace(' ','_',$inp);

            $inp1 = strtolower($meas->variable_name);
            $inputs1A[] = str_replace(' ','_',$inp1);

            if($measurementvalues){
				$inputs2[] = $measurementvalues->measurement_value;
			}else{
				$inputs2[] = 0;
			}
        @endphp
    @endforeach
@endif
<?php
if(count($inputs1) == count($inputs2)) {
    $assArray = array();
    $assArray1 = array();
    for($i=0;$i<count($inputs1);$i++) {
        $assArray[$inputs1[$i]] = $inputs2[$i];
        $assArray1[$inputs1A[$i]] = $inputs2[$i];
    }
}

$inputs = array();
foreach ($inputs1 as $inp){
    $inputs[] = $inp;
}

$inparray = array('TITLE','UOM');
$arr2 = array_merge($inputs,$inparray);

$array = array('TITLE' => $mprofile->m_title,'UOM' => ($mprofile->uom == 'in') ? 'inches' : 'cm');
$arr1 = array_merge($assArray,$array);
?>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <h5 class="p-10 text-center">
            {{ $template->template_name }}
        </h5>
    </div>
</div>
<div class="col-md-12">
    <div class="row theme-row m-b-10">
        <div class="card-header accordion active col-lg-12 col-sm-12" data-toggle="collapse" data-target="#PTsection1-preview">
            <h5 class="card-header-text">Project Information</h5>
            <i class="fa fa-caret-down pull-right micro-icons"></i>
        </div>
    </div>
    <div class="card-block collapse show" id="PTsection1-preview">
        <div class="col-lg-12">
            @php
            $tdescription = $template->description;
            for ($i=0;$i<count($arr1);$i++){
                $tdescription = str_replace('[['.$arr2[$i].']]',$arr1[$arr2[$i]],$tdescription);
            }
            @endphp
            {!! $tdescription !!}
        </div>
    </div>
</div>

<div class="clearfix"></div>
@if($template->getAllSections()->count() > 0)
    @foreach($template->getAllSections as $sections)
        <div class="col-md-12">
            <div class="row theme-row m-b-10">
                <div class="card-header accordion active col-lg-12 col-sm-12" data-toggle="collapse" data-target="#PTsection3{{$sections->id}}-preview">
                    <h5 class="card-header-text">{{ $sections->section_name }}</h5>
                    <i class="fa fa-caret-down pull-right micro-icons"></i>

                </div>
                <!-- <a href="javascript:;" class="fa fa-comments pull-right sectionNotes" aria-hidden="true" onclick="opencommentbar({{$sections->id}})"></a> -->
            </div>

            <div class="card-block collapse show" id="PTsection3{{$sections->id}}-preview">

                @if($sections->snippets()->count() > 0)
                    @foreach($sections->snippets as $snippets)
                    <!-- snippet is empty -->
                        @if($snippets->is_empty == 1)
                            <div class="col-md-12">
                                @php
                                    $snippetsDescription = $snippets->snippet_description;
                                    for ($i=0;$i<count($arr1);$i++){
                                        $snippetsDescription = str_replace('[['.$arr2[$i].']]',$arr1[$arr2[$i]],$snippetsDescription);
                                    }
                                @endphp
                                {!! $snippetsDescription !!}
                            </div>
                        @endif
                    <!-- snippet is empty -->
                    <!-- Concatinate snippet -->
                        @if($snippets->is_concatinate == 1)
                            <div class="col-md-12">
                            @if($snippets->instructions()->count() > 0)
                                @foreach($snippets->instructions as $inst)
                                    @php
                                    $instruction = $inst->description;
                                    for ($i=0;$i<count($arr1);$i++){
                                        $instruction = str_replace('[['.$arr2[$i].']]',$arr1[$arr2[$i]],$instruction);
                                    }
                                    @endphp
                                    {!! $instruction !!}
                                @endforeach
                            @endif
                            </div>
                        @endif
                    <!-- Contatinate snippet -->

                    <!-- Yarn details -->
                        @if($snippets->is_yarn == 1)
                            @if($snippets->yarnDetails()->count() > 0)
                                <!--<h5 class="m-b-10">Suggested yarn</h5> -->
                                @foreach($snippets->yarnDetails as $yarnDetails)
                                    <div class="col-md-12">
                                        <a href="{{ $yarnDetails->yarn_content }}" style="color: #0d665c !important;text-decoration: underline;" class="YarnUrl" target="_blank">{{ ucfirst($yarnDetails->yarn_title) }}</a>
                                    </div>
                                @endforeach
                            @endif
                        @endif
                    <!-- yarn details -->

                    <!-- All functions start here -->

                        @if($snippets->function_id != 0)

                            @php
    $functions = App\Models\Patterns\Functions::where('id',$snippets->function_id)->first();
    $outputs = array('[[NO_OF_STITCHES_TO_CAST_ON]]','[[NO_OF_STITCHES_TO_CAST_ON_BACK]]','[[NO_OF_STITCHES_TO_CAST_ON_FRONT]]',"[[SIDE_MARKER]]",'[[SIDE_MARKER_FRONT]]',"[[SIDE_MARKER_1]]",'[[SIDE_MARKER_2]]','[[PRINCESS_DART_FRONT_2_PIECES]]','[[DECREASE_EVERY_N_ROWS_WAIST]]','[[NO_OF_TIMES_TO_DECREASE_WAIST]]','[[INCREASE_EVERY_N_ROWS_WAIST]]','[[NO_OF_TIMES_TO_INCREASE_TO_WAIST]]',"[[PRINCESS_DART]]",'[[SIDE_MARKER]]','[[PRINCESS_DART_FRONT_1]]','[[PRINCESS_DART_FRONT_2]]','[[PRINCESS_DART_BACK_1]]','[[PRINCESS_DART_BACK_2]]','[[INCREASE_EVERY_N_ROWS_BUST]]','[[NO_OF_TIMES_TO_INCREASE_BUST]]','[[DECREASE_EVERY_N_ROWS_BUST]]','[[NO_OF_TIMES_TO_DECREASE_BUST]]','[[SHOULDER_BIND_OFF_2]]','[[SHOULDER_BIND_OFF_3]]','[[SHOULDER_BIND_OFF_1]]','[[NO_OF_STITCHES_TO_CAST_ON_FOR_SLEEVE]]','[[NO_OF_ROWS_BETWEEN_INCREASES_AT FOREARM]]','[[NO_OF_TIMES_TO_INCREASE_AT_FOREARM]]','[[NO_OF_ROWS_BETWEEN_INCREASES_AT_UPPER_ARM]]','[[NO_OF_TIMES_TO_INCREASE_AT_UPPER_ARM]]','[[NO_OF_SLEEVE_STITCHES_AT_UPPER_ARM]]','[[NO_OF_STITCHES_FOR_FIRST_DECREASE_AT_ARMHOLE]]','[[NO_OF_STITCHES_FOR_SECOND_DECREASE_AT_ARMHOLE]]','[[NO_OF_STITCHES_FOR_THIRD_DECREASE_AT_ARMHOLE]]','[[NO_OF_STITCHES_FOR_4TH_DECREASE_AT_ARMHOLE]]','[[NO_OF_TIMES_TO_DECREASE_1_STITCH_AT_EACH_END]]','[[NO_OF_STITCHES_FOR_THIRD_DECREASE_AT_ARMHOLE]]','[[NO_OF_STITCHES_FOR_4TH_DECREASE_AT_ARMHOLE]]','[[NO_OF_TIMES_TO_DECREASE_1_STITCH_AT_EACH_END]]','[[NO_OF_ROWS_USED]]','[[NO_OF_ROWS_TO_KNIT_STRAIGHT]]','[[DEC_1_STITCH_EVERY_OTHER_ROW_X_TIMES]]','[[DEC_2_STITCH_EVERY_OTHER_ROW_X_TIMES]]','[[DEC_4_STITCH_EVERY_OTHER_ROW_X_TIMES]]','[[BO_REMAINING_1]]','[[BO_REMAINING_2]]','[[BO_REMAINING_3]]','[[TEXT_FOR_DECREASE_1_STITCH_AT_EACH_END]]','[[TEXT_FOR_NO_OF_STITCHES_FOR_THIRD_DECREASE_AT_ARMHOLE]]','[[TEXT_FOR_NO_OF_STITCHES_FOR_FOURTH_DECREASE_AT_ARMHOLE]]','[[LENGTH_OF_SLEEVE_CUFF]]','[[BIND_OFF_REMAINING]]','[[DEPTH_OF_NECKLINE]]','[[DEPTH_OF_NECKLINE_BACK]]','[[NO_OF_STITCHES_AT_FRONT_AFTER_ARM_SH]]','[[NO_OF_STITCHES_AT_LEFT_FRONT]]','[[NO_OF_STITCHES_AT_SHOULDER]]','[[TEXT_TO_DEC_2_STS]]','[[V_NECK_NO_TIMES_TO_DEC_1_ST]]','[[ARMHOLE_DEPTH_BEFORE_SHOULDER_BIND_OFF]]','[[NO_OF_STITCHES_AT_BACK_AFTER_ARM_SH]]','[[NO_OF_STITCHES_AT_LEFT_BACK]]','[[CENTER_BACK_NECK_BINDOFF]]','[[NO_OF_LEFT_SHOULDER_STS_SCOOP]]','[[NO_OF_BACK_NECK_STS]]','[[TEXT_FOR_BUST_INCREASES]]','[[SECOND_LINE_TEXT_FOR_BUST_INCREASES]]','[[TEXT_FOR_BACK_INCREASES]]','[[SECOND_LINE_TEXT_FOR_BACK_INCREASES]]','[[TEXT_FOR_FOREARM_INCREASES]]','[[TEXT_FOR_UPPER_ARM_INCREASES]]','[[NO_OF_INCHES_OR_CM_FOR_LOWER_BORDER]]','[[NO_OF_ROWS_BETWEEN_INCREASES_AT_FOREARM]]','[[ARMHOLE_DEPTH_AT_NECKLINE_BACK]]','[[ARMHOLE_DEPTH_AT_NECKLINE]]',
    '[[CENTER_NECK_BINDOFF_BACK]]','[[NO_STITCHES_FOR_SCOOP_NECK_SHAPING]]','[[CENTER_NECK_BINDOFF]]',
    '[[SCOOP_NECK_FIRST_SHAPING_DECREASE]]','[[SCOOP_NECK_SECOND_SHAPING_DECREASE]]','[[TEXT_FOR_NO_TIMES_TO_DECREASE_ONE_STITCH_SCOOP_NECK]]','[[TEXT_FOR_SCOOP_NECK_SECOND_SHAPING_DECREASE]]','[[V_NECK_NO_TIMES_TO_DEC_2_STS]]','[[NO_OF_STITCHES_TO_SHAPE_NECKLINE]]','[[FIRST_DECREASE_AT_NECK]]','[[SECOND_DECREASE_AT_NECK]]','[[BEGIN_NECK_SHAPING]]','[[NO_OF_TIMES_TO_DECREASE_1_AT_FRONT_NECK]]','[[LENGTH_OF_NECK_EDGE_RIBBING]]');

    $outputs1 = array('NO_OF_STITCHES_TO_CAST_ON','NO_OF_STITCHES_TO_CAST_ON_BACK','NO_OF_STITCHES_TO_CAST_ON_FRONT',"SIDE_MARKER",'SIDE_MARKER_FRONT',"SIDE_MARKER_1",'SIDE_MARKER_2','PRINCESS_DART_FRONT_2_PIECES','DECREASE_EVERY_N_ROWS_WAIST','NO_OF_TIMES_TO_DECREASE_WAIST','INCREASE_EVERY_N_ROWS_WAIST','NO_OF_TIMES_TO_INCREASE_TO_WAIST',"PRINCESS_DART",'SIDE_MARKER','PRINCESS_DART_FRONT_1','PRINCESS_DART_FRONT_2','PRINCESS_DART_BACK_1','PRINCESS_DART_BACK_2','INCREASE_EVERY_N_ROWS_BUST','NO_OF_TIMES_TO_INCREASE_BUST','DECREASE_EVERY_N_ROWS_BUST','NO_OF_TIMES_TO_DECREASE_BUST','SHOULDER_BIND_OFF_1','SHOULDER_BIND_OFF_2','SHOULDER_BIND_OFF_3','NO_OF_STITCHES_TO_CAST_ON_FOR_SLEEVE','NO_OF_ROWS_BETWEEN_INCREASES_AT FOREARM','NO_OF_TIMES_TO_INCREASE_AT_FOREARM','NO_OF_ROWS_BETWEEN_INCREASES_AT_UPPER_ARM','NO_OF_TIMES_TO_INCREASE_AT_UPPER_ARM','NO_OF_SLEEVE_STITCHES_AT_UPPER_ARM','NO_OF_STITCHES_FOR_FIRST_DECREASE_AT_ARMHOLE','NO_OF_STITCHES_FOR_SECOND_DECREASE_AT_ARMHOLE','NO_OF_STITCHES_FOR_THIRD_DECREASE_AT_ARMHOLE','NO_OF_STITCHES_FOR_4TH_DECREASE_AT_ARMHOLE','NO_OF_TIMES_TO_DECREASE_1_STITCH_AT_EACH_END','NO_OF_STITCHES_FOR_THIRD_DECREASE_AT_ARMHOLE','NO_OF_STITCHES_FOR_4TH_DECREASE_AT_ARMHOLE','NO_OF_TIMES_TO_DECREASE_1_STITCH_AT_EACH_END','NO_OF_ROWS_USED','NO_OF_ROWS_TO_KNIT_STRAIGHT','DEC_1_STITCH_EVERY_OTHER_ROW_X_TIMES','DEC_2_STITCH_EVERY_OTHER_ROW_X_TIMES','DEC_4_STITCH_EVERY_OTHER_ROW_X_TIMES','BO_REMAINING_1','BO_REMAINING_2','BO_REMAINING_3','TEXT_FOR_DECREASE_1_STITCH_AT_EACH_END','TEXT_FOR_NO_OF_STITCHES_FOR_THIRD_DECREASE_AT_ARMHOLE','TEXT_FOR_NO_OF_STITCHES_FOR_FOURTH_DECREASE_AT_ARMHOLE','LENGTH_OF_SLEEVE_CUFF','BIND_OFF_REMAINING','DEPTH_OF_NECKLINE','DEPTH_OF_NECKLINE_BACK','NO_OF_STITCHES_AT_FRONT_AFTER_ARM_SH','NO_OF_STITCHES_AT_LEFT_FRONT','NO_OF_STITCHES_AT_SHOULDER','TEXT_TO_DEC_2_STS','V_NECK_NO_TIMES_TO_DEC_1_ST','ARMHOLE_DEPTH_BEFORE_SHOULDER_BIND_OFF','NO_OF_STITCHES_AT_BACK_AFTER_ARM_SH','NO_OF_STITCHES_AT_LEFT_BACK','CENTER_BACK_NECK_BINDOFF','NO_OF_LEFT_SHOULDER_STS_SCOOP','NO_OF_BACK_NECK_STS','TEXT_FOR_BUST_INCREASES','SECOND_LINE_TEXT_FOR_BUST_INCREASES','TEXT_FOR_BACK_INCREASES','SECOND_LINE_TEXT_FOR_BACK_INCREASES','TEXT_FOR_FOREARM_INCREASES','TEXT_FOR_UPPER_ARM_INCREASES','NO_OF_INCHES_OR_CM_FOR_LOWER_BORDER','NO_OF_ROWS_BETWEEN_INCREASES_AT_FOREARM','ARMHOLE_DEPTH_AT_NECKLINE_BACK','ARMHOLE_DEPTH_AT_NECKLINE','CENTER_NECK_BINDOFF_BACK','NO_STITCHES_FOR_SCOOP_NECK_SHAPING','CENTER_NECK_BINDOFF','SCOOP_NECK_FIRST_SHAPING_DECREASE','SCOOP_NECK_SECOND_SHAPING_DECREASE','TEXT_FOR_NO_TIMES_TO_DECREASE_ONE_STITCH_SCOOP_NECK','TEXT_FOR_SCOOP_NECK_SECOND_SHAPING_DECREASE','V_NECK_NO_TIMES_TO_DEC_2_STS','NO_OF_STITCHES_TO_SHAPE_NECKLINE','FIRST_DECREASE_AT_NECK','SECOND_DECREASE_AT_NECK','BEGIN_NECK_SHAPING','NO_OF_TIMES_TO_DECREASE_1_AT_FRONT_NECK','LENGTH_OF_NECK_EDGE_RIBBING');

        /* if($snippets->factor_value_cm == 0){
            $factor_value = $snippets->factor_value_in;
        }else if($snippets->factor_value_in == 0){
            $factor_value = $snippets->factor_value_cm;
        }else{
            $factor_value = 0;
        } */

if($functions->prgm_name == 'cast_on_1'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',1)->first();
            $modifier = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
            }

            $functionName = cast_on_1($assArray1, $factor_value, $modifier_value);
        }else if($functions->prgm_name == 'cast_on_2_front'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',1)->first();
            $modifier = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
            }
            $functionName = cast_on_2_front($assArray1, $factor_value, $modifier_value);
        }else if($functions->prgm_name == 'cast_on_2_back'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',1)->first();
            $modifier = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
            }
            $functionName = cast_on_2_back($assArray1, $factor_value, $modifier_value);
        }else if($functions->prgm_name == 'cast_on_3_front'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',1)->first();
            $modifier = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
            }
            $functionName = cast_on_3_front($assArray1, $factor_value, $modifier_value);
        }else if($functions->prgm_name == 'cast_on_3_back'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',1)->first();
            $modifier = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
            }
            $functionName = cast_on_3_back($assArray1, $factor_value, $modifier_value);
        }else if($functions->prgm_name == 'place_markers_side_markers_1'){
            $factor = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',1)->where('is_factor_modifier',1)->first();
            $modifier = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',1)->where('is_factor_modifier',2)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->first();

            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
                $factor_value1 = $factor1->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
                $factor_value1 = $factor1->input_value_cm;
            }
            $functionName = place_markers_side_markers_1($assArray1,$factor_value,$modifier_value,$factor_value1);
        }else if($functions->prgm_name == 'place_markers_side_markers_2'){
            $factor = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',4)->where('is_factor_modifier',1)->first();
            $modifier = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',4)->where('is_factor_modifier',2)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->first();

            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
                $factor_value1 = $factor1->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
                $factor_value1 = $factor1->input_value_cm;
            }
            $functionName = place_markers_side_markers_2($assArray1,$factor_value,$modifier_value,$factor_value1);
        }else if($functions->prgm_name == 'place_markers_princes_dart_1'){
            $factor = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',1)->where('is_factor_modifier',1)->first();
            $modifier = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',1)->where('is_factor_modifier',2)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->first();

            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
                $factor_value1 = $factor1->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
                $factor_value1 = $factor1->input_value_cm;
            }
            $functionName = place_markers_princes_dart_1($assArray1,$factor_value,$modifier_value,$factor_value1);
        }else if($functions->prgm_name == 'place_markers_princes_dart_2_front'){
            $factor = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',2)->where('is_factor_modifier',1)->first();
            $modifier = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',2)->where('is_factor_modifier',2)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->first();

            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
                $factor_value1 = $factor1->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
                $factor_value1 = $factor1->input_value_cm;
            }
            $functionName = place_markers_princes_dart_2_front($assArray1,$factor_value,$modifier_value,$factor_value1);
        }else if($functions->prgm_name == 'place_markers_princes_dart_2_back'){
            $factor = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',3)->where('is_factor_modifier',1)->first();
            $modifier = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',3)->where('is_factor_modifier',2)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->first();

            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
                $factor_value1 = $factor1->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
                $factor_value1 = $factor1->input_value_cm;
            }
            $functionName = place_markers_princes_dart_2_back($assArray1,$factor_value,$modifier_value,$factor_value1);
        }else if($functions->prgm_name == 'place_markers_princes_dart_3'){
            $factor = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',4)->where('is_factor_modifier',1)->first();
            $modifier = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',4)->where('is_factor_modifier',2)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->first();

            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
                $factor_value1 = $factor1->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
                $factor_value1 = $factor1->input_value_cm;
            }
            $functionName = place_markers_princes_dart_3($assArray1,$factor_value,$modifier_value,$factor_value1);
        }else if($functions->prgm_name == 'place_markers_princes_dart_4_front'){
            $factor = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',5)->where('is_factor_modifier',1)->first();
            $modifier = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',5)->where('is_factor_modifier',2)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->first();

            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
                $factor_value1 = $factor1->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
                $factor_value1 = $factor1->input_value_cm;
            }
            $functionName = place_markers_princes_dart_4_front($assArray1,$factor_value,$modifier_value,$factor_value1);
        }else if($functions->prgm_name == 'place_markers_princes_dart_4_back'){
            $factor = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',6)->where('is_factor_modifier',1)->first();
            $modifier = App\Models\Patterns\SnippetFactorModifier::where('pattern_template_id',$template->id)->where('functions_id',6)->where('is_factor_modifier',2)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->first();

            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
                $modifier_value = $modifier->input_value_in;
                $factor_value1 = $factor1->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
                $modifier_value = $modifier->input_value_cm;
                $factor_value1 = $factor1->input_value_cm;
            }
            $functionName = place_markers_princes_dart_4_back($assArray1,$factor_value,$modifier_value,$factor_value1);
        }else if($functions->prgm_name == 'decrease_to_waist_1'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = decrease_to_waist_1($assArray1, $factor_value);
        }else if($functions->prgm_name == 'decrease_to_waist_2_front'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = decrease_to_waist_2_front($assArray1, $factor_value);
        }else if($functions->prgm_name == 'decrease_to_waist_2_back'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = decrease_to_waist_2_back($assArray1, $factor_value);
        }else if($functions->prgm_name == 'decrease_to_waist_3'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = decrease_to_waist_3($assArray1, $factor_value);
        }else if($functions->prgm_name == 'decrease_to_waist_4_front'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = decrease_to_waist_4_front($assArray1, $factor_value);
        }else if($functions->prgm_name == 'decrease_to_waist_4_back'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = decrease_to_waist_4_back($assArray1, $factor_value);
        }else if($functions->prgm_name == 'increase_to_bust_1_front'){
            $functionName = increase_to_bust_1_front($assArray1,$snippets);
        }else if($functions->prgm_name == 'increase_to_back_1_back'){
            $functionName = increase_to_back_1_back($assArray1,$snippets);
        }else if($functions->prgm_name == 'increase_to_bust_2_front'){
            $functionName = increase_to_bust_2_front($assArray1,$snippets);
        }else if($functions->prgm_name == 'increase_to_back_2_back'){
            $functionName = increase_to_back_2_back($assArray1,$snippets);
        }else if($functions->prgm_name == 'increase_to_bust_3_front'){
            $functionName = increase_to_bust_3_front($assArray1,$snippets);
        }else if($functions->prgm_name == 'increase_to_back_3_back'){
            $functionName = increase_to_back_3_back($assArray1,$snippets);
        }else if($functions->prgm_name == 'increase_to_bust_4_left_front'){
            $functionName = increase_to_bust_4_left_front($assArray1,$snippets);
        }else if($functions->prgm_name == 'increase_to_bust_4_right_front'){
            $functionName = increase_to_bust_4_right_front($assArray1,$snippets);
        }else if($functions->prgm_name == 'increase_to_back_4_back'){
            $functionName = increase_to_back_4_back($assArray1,$snippets);
        }else if($functions->prgm_name == 'shoulder_shaping_1'){ // shoulder bind off;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }

            $functionName = shoulder_shaping_1($assArray1,$factor_value);
        }else if($functions->prgm_name == 'shoulder_shaping_2'){ // shoulder bind off;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shoulder_shaping_2($assArray1,$factor_value);
        }else if($functions->prgm_name == 'shoulder_shaping_3'){ // shoulder bind off;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shoulder_shaping_3($assArray1,$factor_value);
        }else if($functions->prgm_name == 'shoulder_shaping_4'){ // shoulder bind off;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shoulder_shaping_4($assArray1,$factor_value);
        }else if($functions->prgm_name == 'sleeve_cast_on_1'){ // Sleeve cast on;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = sleeve_cast_on_1($assArray1,$factor_value);
        }else if($functions->prgm_name == 'sleeve_cast_on_2'){ // Sleeve cast on;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = sleeve_cast_on_2($assArray1,$factor_value);
        }else if($functions->prgm_name == 'sleeve_cast_on_3'){ // Sleeve cast on;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = sleeve_cast_on_3($assArray1,$factor_value);
        }else if($functions->prgm_name == 'sleeve_cast_on_4'){ // Sleeve cast on;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = sleeve_cast_on_4($assArray1,$factor_value);
        }else if($functions->prgm_name == 'increase_to_forearm_1'){ // Increase to forearm;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = increase_to_forearm_1($assArray1,$factor_value,$snippets);
        }else if($functions->prgm_name == 'increase_to_forearm_2'){ // Increase to forearm;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = increase_to_forearm_2($assArray1,$factor_value,$snippets);
        }else if($functions->prgm_name == 'increase_to_forearm_3'){ // Increase to forearm;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = increase_to_forearm_3($assArray1,$factor_value,$snippets);
        }else if($functions->prgm_name == 'increase_to_forearm_4'){ // Increase to forearm;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = increase_to_forearm_4($assArray1,$factor_value,$snippets);
        }else if($functions->prgm_name == 'increase_to_upperarm_1'){ // Increase to upperarm;
            $functionName = increase_to_upperarm_1($assArray1,$snippets);
        }else if($functions->prgm_name == 'increase_to_upperarm_2'){ // Increase to upperarm;
            $functionName = increase_to_upperarm_2($assArray1,$snippets);
        }else if($functions->prgm_name == 'increase_to_upperarm_3'){ // Increase to upperarm;
            $functionName = increase_to_upperarm_3($assArray1,$snippets);
        }else if($functions->prgm_name == 'increase_to_upperarm_4'){ // Increase to upperarm;
            $functionName = increase_to_upperarm_4($assArray1,$snippets);
        }else if($functions->prgm_name == 'armhole_shaping_1'){ // Increase to upperarm;
            $functionName = armhole_shaping_1($assArray1,$snippets);
        }else if($functions->prgm_name == 'armhole_shaping_2'){ // Increase to upperarm;
            $functionName = armhole_shaping_2($assArray1,$snippets);
        }else if($functions->prgm_name == 'armhole_shaping_3_front'){ // Increase to upperarm;
            $functionName = armhole_shaping_3_front($assArray1,$snippets);
        }else if($functions->prgm_name == 'armhole_shaping_3_back'){ // Increase to upperarm;
            $functionName = armhole_shaping_3_back($assArray1,$snippets);
        }else if($functions->prgm_name == 'armhole_shaping_4_front'){ // Increase to upperarm;
            $functionName = armhole_shaping_4_front($assArray1,$snippets);
        }else if($functions->prgm_name == 'armhole_shaping_4_back'){ // Increase to upperarm;
            $functionName = armhole_shaping_4_back($assArray1,$snippets);
        }else if($functions->prgm_name == 'sleeve_cap_shaping_1'){ // Increase to upperarm;
            $functionName = sleeve_cap_shaping_1($assArray1,$snippets);
        }else if($functions->prgm_name == 'sleeve_cap_shaping_2'){ // Increase to upperarm;
            $functionName = sleeve_cap_shaping_2($assArray1,$snippets);
        }else if($functions->prgm_name == 'sleeve_cap_shaping_3'){ // Increase to upperarm;
            $functionName = sleeve_cap_shaping_3($assArray1,$snippets);
        }else if($functions->prgm_name == 'sleeve_cap_shaping_4'){ // Increase to upperarm;
            $functionName = sleeve_cap_shaping_4($assArray1,$snippets);
        }else if($functions->prgm_name == 'depth_of_neckline_1'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = depth_of_neckline_1($assArray1,$factor_value);
        }else if($functions->prgm_name == 'depth_of_neckline_2'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = depth_of_neckline_2($assArray1,$factor_value);
        }else if($functions->prgm_name == 'depth_of_neckline_3'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = depth_of_neckline_3($assArray1,$factor_value);
        }else if($functions->prgm_name == 'depth_of_neckline_4'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = depth_of_neckline_4($assArray1,$factor_value);
        }else if($functions->prgm_name == 'depth_of_neckline_back_1'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = depth_of_neckline_back_1($assArray1,$factor_value);
        }else if($functions->prgm_name == 'depth_of_neckline_back_2'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = depth_of_neckline_back_2($assArray1,$factor_value);
        }else if($functions->prgm_name == 'depth_of_neckline_back_3'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = depth_of_neckline_back_3($assArray1,$factor_value);
        }else if($functions->prgm_name == 'depth_of_neckline_back_4'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($mprofile->uom == 'in'){
                $factor_value = $factor->input_value_in;
            }else{
                $factor_value = $factor->input_value_cm;
            }
            $functionName = depth_of_neckline_back_4($assArray1,$factor_value);
        }else if($functions->prgm_name == 'left_right_front_to_shape_neckline_1'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }

            $functionName = left_right_front_to_shape_neckline_1($assArray1,$mprofile,$snippets,$factor_value);
        }else if($functions->prgm_name == 'left_right_front_to_shape_neckline_2'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = left_right_front_to_shape_neckline_2($assArray1,$mprofile,$snippets,$factor_value);
        }else if($functions->prgm_name == 'left_right_front_to_shape_neckline_3'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = left_right_front_to_shape_neckline_3($assArray1,$mprofile,$snippets,$factor_value);
        }else if($functions->prgm_name == 'left_right_front_to_shape_neckline_4'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = left_right_front_to_shape_neckline_4($assArray1,$mprofile,$snippets,$factor_value);
        }else if($functions->prgm_name == 'shape_neckline_v_neck_1'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shape_neckline_v_neck_1($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'shape_neckline_v_neck_2'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shape_neckline_v_neck_2($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'shape_neckline_v_neck_3'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shape_neckline_v_neck_3($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'shape_neckline_v_neck_4'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shape_neckline_v_neck_4($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'left_right_back_to_shape_neckline_1'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }

            $functionName = left_right_back_to_shape_neckline_1($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'left_right_back_to_shape_neckline_2'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = left_right_back_to_shape_neckline_2($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'left_right_back_to_shape_neckline_3'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = left_right_back_to_shape_neckline_3($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'left_right_back_to_shape_neckline_4'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = left_right_back_to_shape_neckline_4($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'bind_off_scoop_neck_front_1'){
            $functionName = bind_off_scoop_neck_front_1($assArray1,$mprofile,$snippets,$factor_value);
        }else if($functions->prgm_name == 'bind_off_scoop_neck_front_2'){
            $functionName = bind_off_scoop_neck_front_2($assArray1,$mprofile,$snippets,$factor_value);
        }else if($functions->prgm_name == 'bind_off_scoop_neck_front_3'){
            $functionName = bind_off_scoop_neck_front_3($assArray1,$mprofile,$snippets,$factor_value);
        }else if($functions->prgm_name == 'bind_off_scoop_neck_front_4'){
            $functionName = bind_off_scoop_neck_front_4($assArray1,$mprofile,$snippets,$factor_value);
        }else if($functions->prgm_name == 'underarm_shaping_for_sleeve_1'){
            $functionName = underarm_shaping_for_sleeve_1($assArray1,$snippets);
        }else if($functions->prgm_name == 'underarm_shaping_for_sleeve_2'){
            $functionName = underarm_shaping_for_sleeve_2($assArray1,$snippets);
        }else if($functions->prgm_name == 'underarm_shaping_for_sleeve_3_front'){
            $functionName = underarm_shaping_for_sleeve_3_front($assArray1,$snippets);
        }else if($functions->prgm_name == 'underarm_shaping_for_sleeve_3_back'){
            $functionName = underarm_shaping_for_sleeve_3_back($assArray1,$snippets);
        }else if($functions->prgm_name == 'underarm_shaping_for_sleeve_4_front'){
            $functionName = underarm_shaping_for_sleeve_4_front($assArray1,$snippets);
        }else if($functions->prgm_name == 'underarm_shaping_for_sleeve_4_back'){
            $functionName = underarm_shaping_for_sleeve_4_back($assArray1,$snippets);
        }else if($functions->prgm_name == 'shape_neckline_scoop_neck_1'){
            $modifier1 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',3)->first();
            $modifier2 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',4)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',14)->first();
            $factor2 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',15)->first();
            if($factor1){
                if($mprofile->uom == 'in'){
                    $factor_value1 = $factor1->input_value_in;
                }else{
                    $factor_value1 = $factor1->input_value_cm;
                }
            }else{
                $factor_value1 = 0;
            }

            if($factor2){
                if($mprofile->uom == 'in'){
                    $factor_value2 = $factor2->input_value_in;
                }else{
                    $factor_value2 = $factor2->input_value_cm;
                }
            }else{
                $factor_value2 = 0;
            }

            if($modifier1){
                if($mprofile->uom == 'in'){
                    $modifier_value1 = $modifier1->input_value_in;
                }else{
                    $modifier_value1 = $modifier1->input_value_cm;
                }
            }else{
                $modifier_value1 = 0;
            }

            if($modifier2){
                if($mprofile->uom == 'in'){
                    $modifier_value2 = $modifier2->input_value_in;
                }else{
                    $modifier_value2 = $modifier2->input_value_cm;
                }
            }else{
                $modifier_value2 = 0;
            }
            $functionName = shape_neckline_scoop_neck_1($assArray1,$mprofile,$snippets,$factor_value1,$factor_value2,$modifier1,
            $modifier2);
        }else if($functions->prgm_name == 'shape_neckline_scoop_neck_2'){
            $modifier1 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',3)->first();
            $modifier2 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',4)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',14)->first();
            $factor2 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',15)->first();
            if($factor1){
                if($mprofile->uom == 'in'){
                    $factor_value1 = $factor1->input_value_in;
                }else{
                    $factor_value1 = $factor1->input_value_cm;
                }
            }else{
                $factor_value1 = 0;
            }

            if($factor2){
                if($mprofile->uom == 'in'){
                    $factor_value2 = $factor2->input_value_in;
                }else{
                    $factor_value2 = $factor2->input_value_cm;
                }
            }else{
                $factor_value2 = 0;
            }

            if($modifier1){
                if($mprofile->uom == 'in'){
                    $modifier_value1 = $modifier1->input_value_in;
                }else{
                    $modifier_value1 = $modifier1->input_value_cm;
                }
            }else{
                $modifier_value1 = 0;
            }

            if($modifier2){
                if($mprofile->uom == 'in'){
                    $modifier_value2 = $modifier2->input_value_in;
                }else{
                    $modifier_value2 = $modifier2->input_value_cm;
                }
            }else{
                $modifier_value2 = 0;
            }
            $functionName = shape_neckline_scoop_neck_2($assArray1,$mprofile,$snippets,$factor_value1,$factor_value2,
            $modifier1,
            $modifier2);
        }else if($functions->prgm_name == 'shape_neckline_scoop_neck_3'){
            $modifier1 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',3)->first();
            $modifier2 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',4)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',14)->first();
            $factor2 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',15)->first();
            if($factor1){
                if($mprofile->uom == 'in'){
                    $factor_value1 = $factor1->input_value_in;
                }else{
                    $factor_value1 = $factor1->input_value_cm;
                }
            }else{
                $factor_value1 = 0;
            }

            if($factor2){
                if($mprofile->uom == 'in'){
                    $factor_value2 = $factor2->input_value_in;
                }else{
                    $factor_value2 = $factor2->input_value_cm;
                }
            }else{
                $factor_value2 = 0;
            }

            if($modifier1){
                if($mprofile->uom == 'in'){
                    $modifier_value1 = $modifier1->input_value_in;
                }else{
                    $modifier_value1 = $modifier1->input_value_cm;
                }
            }else{
                $modifier_value1 = 0;
            }

            if($modifier2){
                if($mprofile->uom == 'in'){
                    $modifier_value2 = $modifier2->input_value_in;
                }else{
                    $modifier_value2 = $modifier2->input_value_cm;
                }
            }else{
                $modifier_value2 = 0;
            }
            $functionName = shape_neckline_scoop_neck_3($assArray1,$mprofile,$snippets,$factor_value1,$factor_value2,
            $modifier1,
            $modifier2);
        }else if($functions->prgm_name == 'shape_neckline_scoop_neck_4'){
            $modifier1 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',3)->first();
            $modifier2 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',4)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',14)->first();
            $factor2 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',15)->first();
            if($factor1){
                if($mprofile->uom == 'in'){
                    $factor_value1 = $factor1->input_value_in;
                }else{
                    $factor_value1 = $factor1->input_value_cm;
                }
            }else{
                $factor_value1 = 0;
            }

            if($factor2){
                if($mprofile->uom == 'in'){
                    $factor_value2 = $factor2->input_value_in;
                }else{
                    $factor_value2 = $factor2->input_value_cm;
                }
            }else{
                $factor_value2 = 0;
            }

            if($modifier1){
                if($mprofile->uom == 'in'){
                    $modifier_value1 = $modifier1->input_value_in;
                }else{
                    $modifier_value1 = $modifier1->input_value_cm;
                }
            }else{
                $modifier_value1 = 0;
            }

            if($modifier2){
                if($mprofile->uom == 'in'){
                    $modifier_value2 = $modifier2->input_value_in;
                }else{
                    $modifier_value2 = $modifier2->input_value_cm;
                }
            }else{
                $modifier_value2 = 0;
            }
            $functionName = shape_neckline_scoop_neck_4($assArray1,$mprofile,$snippets,$factor_value1,$factor_value2,
            $modifier1,
            $modifier2);
        }else if($functions->prgm_name == 'shape_neckline_v_neck_right_front'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shape_neckline_v_neck_right_front($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'shape_neckline_v_neck_left_front'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shape_neckline_v_neck_left_front($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'shape_neckline_v_neck_right_back'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shape_neckline_v_neck_right_back($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'shape_neckline_v_neck_left_front'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shape_neckline_v_neck_left_front($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'shape_neckline_v_neck_left_back'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = shape_neckline_v_neck_left_back($assArray1,$factor_value,$mprofile,$snippets);
        }else if($functions->prgm_name == 'shape_neckline_scoop_neck_right_front'){
            $modifier1 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',3)->first();
            $modifier2 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',4)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',14)->first();
            $factor2 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',15)->first();
            if($factor1){
                if($mprofile->uom == 'in'){
                    $factor_value1 = $factor1->input_value_in;
                }else{
                    $factor_value1 = $factor1->input_value_cm;
                }
            }else{
                $factor_value1 = 0;
            }

            if($factor2){
                if($mprofile->uom == 'in'){
                    $factor_value2 = $factor2->input_value_in;
                }else{
                    $factor_value2 = $factor2->input_value_cm;
                }
            }else{
                $factor_value2 = 0;
            }

            if($modifier1){
                if($mprofile->uom == 'in'){
                    $modifier_value1 = $modifier1->input_value_in;
                }else{
                    $modifier_value1 = $modifier1->input_value_cm;
                }
            }else{
                $modifier_value1 = 0;
            }

            if($modifier2){
                if($mprofile->uom == 'in'){
                    $modifier_value2 = $modifier2->input_value_in;
                }else{
                    $modifier_value2 = $modifier2->input_value_cm;
                }
            }else{
                $modifier_value2 = 0;
            }
            $functionName = shape_neckline_scoop_neck_right_front($assArray1,$mprofile,$snippets,$factor_value1,$factor_value2,$modifier1,$modifier2);
        }else if($functions->prgm_name == 'shape_neckline_scoop_neck_left_front'){
            $modifier1 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',3)->first();
            $modifier2 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',4)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',14)->first();
            $factor2 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',15)->first();
            if($factor1){
                if($mprofile->uom == 'in'){
                    $factor_value1 = $factor1->input_value_in;
                }else{
                    $factor_value1 = $factor1->input_value_cm;
                }
            }else{
                $factor_value1 = 0;
            }

            if($factor2){
                if($mprofile->uom == 'in'){
                    $factor_value2 = $factor2->input_value_in;
                }else{
                    $factor_value2 = $factor2->input_value_cm;
                }
            }else{
                $factor_value2 = 0;
            }

            if($modifier1){
                if($mprofile->uom == 'in'){
                    $modifier_value1 = $modifier1->input_value_in;
                }else{
                    $modifier_value1 = $modifier1->input_value_cm;
                }
            }else{
                $modifier_value1 = 0;
            }

            if($modifier2){
                if($mprofile->uom == 'in'){
                    $modifier_value2 = $modifier2->input_value_in;
                }else{
                    $modifier_value2 = $modifier2->input_value_cm;
                }
            }else{
                $modifier_value2 = 0;
            }
            $functionName = shape_neckline_scoop_neck_left_front($assArray1,$mprofile,$snippets,$factor_value1,$factor_value2,$modifier1,$modifier2);
        }else if($functions->prgm_name == 'shape_neckline_scoop_neck_left_back'){
            $modifier1 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',3)->first();
            $modifier2 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',4)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',14)->first();
            $factor2 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',15)->first();
            if($factor1){
                if($mprofile->uom == 'in'){
                    $factor_value1 = $factor1->input_value_in;
                }else{
                    $factor_value1 = $factor1->input_value_cm;
                }
            }else{
                $factor_value1 = 0;
            }

            if($factor2){
                if($mprofile->uom == 'in'){
                    $factor_value2 = $factor2->input_value_in;
                }else{
                    $factor_value2 = $factor2->input_value_cm;
                }
            }else{
                $factor_value2 = 0;
            }

            if($modifier1){
                if($mprofile->uom == 'in'){
                    $modifier_value1 = $modifier1->input_value_in;
                }else{
                    $modifier_value1 = $modifier1->input_value_cm;
                }
            }else{
                $modifier_value1 = 0;
            }

            if($modifier2){
                if($mprofile->uom == 'in'){
                    $modifier_value2 = $modifier2->input_value_in;
                }else{
                    $modifier_value2 = $modifier2->input_value_cm;
                }
            }else{
                $modifier_value2 = 0;
            }
            $functionName = shape_neckline_scoop_neck_left_back($assArray1,$mprofile,$snippets,$factor_value1,$factor_value2,$modifier1,$modifier2);
        }else if($functions->prgm_name == 'shape_neckline_scoop_neck_right_back'){
            $modifier1 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',3)->first();
            $modifier2 = $snippets->modifiers()->where('is_factor_modifier',2)->where('factor_modifier_id',4)->first();
            $factor1 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',14)->first();
            $factor2 = $snippets->factors()->where('is_factor_modifier',1)->where('factor_modifier_id',15)->first();
            if($factor1){
                if($mprofile->uom == 'in'){
                    $factor_value1 = $factor1->input_value_in;
                }else{
                    $factor_value1 = $factor1->input_value_cm;
                }
            }else{
                $factor_value1 = 0;
            }

            if($factor2){
                if($mprofile->uom == 'in'){
                    $factor_value2 = $factor2->input_value_in;
                }else{
                    $factor_value2 = $factor2->input_value_cm;
                }
            }else{
                $factor_value2 = 0;
            }

            if($modifier1){
                if($mprofile->uom == 'in'){
                    $modifier_value1 = $modifier1->input_value_in;
                }else{
                    $modifier_value1 = $modifier1->input_value_cm;
                }
            }else{
                $modifier_value1 = 0;
            }

            if($modifier2){
                if($mprofile->uom == 'in'){
                    $modifier_value2 = $modifier2->input_value_in;
                }else{
                    $modifier_value2 = $modifier2->input_value_cm;
                }
            }else{
                $modifier_value2 = 0;
            }
            $functionName = shape_neckline_scoop_neck_right_back($assArray1,$mprofile,$snippets,$factor_value1,$factor_value2,$modifier1,$modifier2);
        }else if($functions->prgm_name == 'shoulder_shaping_right_front'){ // shoulder bind off;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }

            $functionName = shoulder_shaping_right_front($assArray1,$factor_value);
        }else if($functions->prgm_name == 'shoulder_shaping_left_front'){ // shoulder bind off;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }

            $functionName = shoulder_shaping_left_front($assArray1,$factor_value);
        }else if($functions->prgm_name == 'shoulder_shaping_back'){ // shoulder bind off;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }

            $functionName = shoulder_shaping_back($assArray1,$factor_value);
        }else if($functions->prgm_name == 'underarm_shaping_for_back'){ // Increase to upperarm;
            $functionName = underarm_shaping_for_back($assArray1,$snippets);
        }else if($functions->prgm_name == 'underarm_shaping_for_front_left'){ // Increase to upperarm;
            $functionName = underarm_shaping_for_front_left($assArray1,$snippets);
        }else if($functions->prgm_name == 'underarm_shaping_for_front_right'){ // Increase to upperarm;
            $functionName = underarm_shaping_for_front_right($assArray1,$snippets);
        }else if($functions->prgm_name == 'cliffs_of_moher_neckline_shaping'){
			$functionName = cliffs_of_moher_neckline_shaping($assArray1,$mprofile,$snippets);
		}else if($functions->prgm_name == 'finishing'){
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }
            $functionName = finishing($assArray1,$factor_value,$snippets);
        }else if($functions->prgm_name == 'shoulder_shaping_right_back'){ // shoulder bind off;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }

            $functionName = shoulder_shaping_right_back($assArray1,$factor_value);
        }else if($functions->prgm_name == 'shoulder_shaping_right_back'){ // shoulder bind off;
            $factor = $snippets->factors()->where('is_factor_modifier',1)->first();
            if($factor){
                if($mprofile->uom == 'in'){
                    $factor_value = $factor->input_value_in;
                }else{
                    $factor_value = $factor->input_value_cm;
                }
            }else{
                $factor_value = 0;
            }

            $functionName = shoulder_shaping_right_back($assArray1,$factor_value);
        }else if($functions->prgm_name == 'underarm_shaping_for_front'){ // Increase to upperarm;
            $functionName = underarm_shaping_for_front($assArray1,$snippets);
        }
        

            /* echo '<pre>';
            print_r($hierarchy);
            echo '</pre>';
            exit;*/
        $function = unserialize($functionName);

        //print_r($function);
        //exit;
        //$outputVariables = $functions->outputVariables()->select('variable_name')->get();
        //$condition = App\Models\Patterns\ConditionalStatement::where('id',$function['condition_id'])->first();
        //$baseInstruction = $condition->base_instructions;
        $sinstructions = DB::table('p_snippet_instructions')->where('snippets_id',$snippets->id)->where('conditional_statements_id',$function['condition_id'])->get();
        @endphp

                            @if($sinstructions->count() > 0)
                                <?php $pi=1; ?>
                                @foreach($sinstructions as $inst)
                                    @php
                                        $instructions = App\Models\Patterns\Instructions::where('id',$inst->instructions_id)->get();
                                    @endphp
                                    @foreach($instructions as $ins)
                                        <?php $baseInstruction = $ins->description; ?>
                                        <!-- output variables -->
                                            @if($functions->outputVariables()->count() > 0)
                                                @foreach($functions->outputVariables as $outVars)
                                                    @php
                                                        $outputVar = '[['.$outVars->variable_name.']]';
                                                        $out = $outVars->variable_name;
                                                        //echo $function[$out].' - '.$outputVar.' - '.$out.'<br>';
                                                        $functionOut = isset($function[$out]) ? $function[$out] : '';
                                                        //if(!is_numeric($functionOut)){
                                                            //$baseInstruction = str_replace($outputVar,$functionOut,$functionOut);
                                                        //}
                                                        //echo $function[$out];
                                                        //$baseInstruction = str_replace($outputVar,$functionOut,$functionOut);
                                                        $baseInstruction = str_replace($outputVar,$functionOut, $baseInstruction);
                                                    @endphp

                                                @endforeach
                                            @endif
                                        <!-- output variables -->

                                    @endforeach
                                    <?php $pi++; ?>
                                @endforeach
                            @endif

                            @php
                                for ($i=0;$i<count($arr1);$i++){
                                    $baseInstruction = str_replace('[['.$arr2[$i].']]',$arr1[$arr2[$i]],$baseInstruction);
                                }
                            @endphp

                            <div class="col-md-12">{!! $baseInstruction !!}</div>

                        @endif
                    <!-- All functions end here -->
                    @endforeach
                @endif
            </div>
        </div>
    @endforeach
@endif
