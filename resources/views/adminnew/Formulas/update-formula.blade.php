@extends('layouts.adminnew')
@section('title','Update Formula')
@section('section1')
@php
    $nextFunction = $function->id + 1;
@endphp
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6"><h5 class="theme-heading p-10">Update Formula : {{ $function->function_name
            }}</h5></div>
            <div class="col-lg-6"><a href="{{ url('adminnew/create-add-update-function/'.$nextFunction) }}" class="btn btn-danger
                pull-right btn-sm m-l-10">Next Function</a> &nbsp;&nbsp;&nbsp;<a href="javascript:;" id="save" class="btn btn-sm theme-btn pull-right">Update
                    Formula</a></div>
        </div>

        <form id="update-formula">
            @csrf
        <div class="col-lg-12 snippet-accordion factor_column">
            <div class="theme-row m-b-10">
                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse"
                     data-target="#designVariants">
                    <h5 class="card-header-text">Design Variants :</h5><i class="fa fa-caret-down pull-right
                    micro-icons"></i>
                </div>
            </div>
            <div class="card-block collapse" id="designVariants">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            @php
                                $designVarients = $function->designVarients()->get();
                            @endphp
                            <label>Select Design Variant </label>
                            @if($designVarients->count() > 0)
                                <ul style="margin-left: 16px;list-style-type:circle" id="input-list">
                                    @foreach($designVarients as $dv)
                                        <li>{{ $dv->design_varient_name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <br>
                            <select class="form-control select2" name="design_type_id" id="design_type_id">
                                <option value="0" disabled >Please select design variant</option>
                                @if($designType->count() > 0)
                                    @foreach($designType as $dt)
                                        <option value="{{ $dt->id }}"
                                                @if($designVarients->count() > 0)
                                                    @foreach($designVarients as $design)
                                                        @if($design->id == $dt->id) disabled @endif
                                                    @endforeach
                                                @endif
                                         >{{
                                        $dt->design_varient_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 snippet-accordion factor_column">
            <div class="theme-row m-b-10">
                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-sampleInstruction">
                    <h5 class="card-header-text">Function :</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                </div>
            </div>
            <div class="card-block collapse" id="child-sampleInstruction">
                <div class="row">
                    <input type="hidden" name="functions_id" value="{{ $function->id }}" readonly >
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Function Name</label>
                            <input type="text" name="function_name" class="form-control" placeholder="Enter function
                            name" value="{{
                            $function->function_name }}" readonly >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Program Name</label>
                            <input type="text" name="prgm_name" class="form-control" placeholder="Enter program name" value="{{
                            $function->prgm_name }}" readonly >
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 snippet-accordion factor_column">
            <div class="theme-row m-b-10">
                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse"
                     data-target="#factors">
                    <h5 class="card-header-text">Factors :</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                </div>
            </div>
            <div class="card-block collapse" id="factors">
                <div class="row">
                    @php
                        $factor = $function->factors()->get();
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select factor</label>
                            @if($factor->count() > 0)
                                <ul style="margin-left: 16px;list-style-type:circle" id="input-list">
                                    @foreach($factor as $fac1)
                                        <li>{{ $fac1->factor_name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <br>
                            <select name="factor_id[]" id="factor_id" class="form-control select2" multiple >
                                <option value="0" disabled >Select Factor</option>
                                @if($factors->count() > 0)
                                    @foreach($factors as $fact)
                                        <option value="{{ $fact->id }}"
                                        @if($factor->count() > 0)
                                            @foreach($factor as $fac)
                                                @if($fac->id == $fact->id) disabled @endif
                                            @endforeach
                                        @endif
                                        >{{ $fact->factor_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 snippet-accordion factor_column">
            <div class="theme-row m-b-10">
                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse"
                     data-target="#modifiers">
                    <h5 class="card-header-text">Modifiers :</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                </div>
            </div>
            <div class="card-block collapse" id="modifiers">
                <div class="row">
                    @php
                        $modifier = $function->modifiers()->get();
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select modifier</label>
                            @if($modifier->count() > 0)
                                <ul style="margin-left: 16px;list-style-type:circle" id="input-list">
                                    @foreach($modifier as $mod)
                                        <li>{{ $mod->modifier_name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <br>
                            <select name="modifier_id[]" id="modifier_id" class="form-control select2" multiple >
                                <option value="0" disabled >Select Factor</option>
                                @if($modifiers->count() > 0)
                                    @foreach($modifiers as $modi)
                                        <option value="{{ $modi->id }}"
                                            @if($modifier->count() > 0)
                                                @foreach($modifier as $mod)
                                                    @if($mod->id == $modi->id) disabled @endif
                                                @endforeach
                                            @endif
                                        >{{ $modi->modifier_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 snippet-accordion factor_column">
            <div class="theme-row m-b-10">
                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse"
                     data-target="#inputVariables">
                    <h5 class="card-header-text">Measurement / Input variables :</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                </div>
            </div>
            <div class="card-block collapse" id="inputVariables">
                <div class="row">
                    @php
                        $inputs = $function->inputVariables()->get();
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select input variables</label>
                            @if($inputs->count() > 0)
                                <ul style="margin-left: 16px;list-style-type:circle" id="input-list">
                                @foreach($inputs as $inp)
                                    <li>{{ $inp->variable_name }}</li>
                                @endforeach
                                </ul>
                            @endif
                            <br>
                            <select name="measurement_variables_id[]" id="measurement_variables_id" class="form-control select2" multiple >
                                <option value="0" disabled >Select Factor</option>
                                @if($measurementVariables->count() > 0)
                                    @foreach($measurementVariables as $mv)
                                        <option value="{{ $mv->id }}"
                                            @if($inputs->count() > 0)
                                                @foreach($inputs as $inp)
                                                    @if($mv->id == $inp->id) disabled @endif
                                                @endforeach
                                            @endif
                                        >{{ ucfirst($mv->variable_name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 snippet-accordion factor_column">
            <div class="theme-row m-b-10">
                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse"
                     data-target="#outputVariables">
                    <h5 class="card-header-text">Output variables :</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                </div>
            </div>
            <div class="card-block collapse" id="outputVariables">
                <div class="row">
                    @php
                        $outputs = $function->outputVariables()->get();
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select output variable</label>
                            @if($outputs->count() > 0)
                            <ul style="margin-left: 16px;list-style-type:circle" id="input-list">
                                @foreach($outputs as $out)
                                    <li>{{ $out->variable_name }}</li>
                                @endforeach
                            </ul>
                            @endif
                            <br>
                            <select name="output_variables_id[]" id="output_variables_id" data-tags="true" class="form-control
                            select2" multiple >
                                <option value="0" disabled >Select Factor</option>
                                @if($outputVariables->count() > 0)
                                    @foreach($outputVariables as $ov)
                                        <option value="{{ $ov->id }}"
                                            @if($outputs->count() > 0)
                                                @foreach($outputs as $out)
                                                    @if($ov->id == $out->id) disabled @endif
                                                @endforeach
                                            @endif
                                        >{{ $ov->variable_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
						<div class="form-group">
                            <label>Delete output variable</label>
                            <select name="detach_output_variables_id[]" id="detach_output_variables_id"
                                    class="form-control select2" multiple >
                                <option value="0" disabled >Select Factor</option>
                                @if($outputVariables->count() > 0)
                                    @foreach($outputVariables as $ov)
                                        <option value="{{ $ov->id }}" >{{ $ov->variable_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 snippet-accordion factor_column">
            <div class="theme-row m-b-10">
                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse"
                     data-target="#outputAsInputVariables">
                    <h5 class="card-header-text">Output as Input variables :</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                </div>
            </div>
            <div class="card-block collapse" id="outputAsInputVariables">
                <div class="row">
                    @php
                        $inpAsoutputs = $function->inputAsOutputVariables()->get();
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select output variable</label>
                            @if($inpAsoutputs->count() > 0)
                                <ul style="margin-left: 16px;list-style-type:circle" id="input-list">
                                    @foreach($inpAsoutputs as $out1)
                                        <li>{{ $out1->variable_name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <br>
                            <select name="output_as_input_id[]" id="output_as_input_id" class="form-control
                            select2" multiple >
                                <option value="0" disabled >Select Factor</option>
                                @if($outputVariables->count() > 0)
                                    @foreach($outputVariables as $ov1)
                                        <option value="{{ $ov1->id }}"
                                            @if($inpAsoutputs->count() > 0)
                                                @foreach($inpAsoutputs as $outIn)
                                                    @if($ov1->id == $outIn->id) disabled @endif
                                                @endforeach
                                            @endif
                                        >{{ $ov1->variable_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-12 snippet-accordion factor_column">
            <div class="theme-row m-b-10">
                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse"
                     data-target="#conditionalStatements">
                    <h5 class="card-header-text">Conditional Statements :</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                </div>
            </div>
            <div class="card-block collapse" id="conditionalStatements">
                <div class="row">
                    @php
                        $condStatements = $function->conditionalStatements()->get();
                    @endphp

                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Conditional Statements</label>
                            @if($condStatements->count() > 0)
                                <ul style="margin-left: 16px;list-style-type:circle" id="input-list">
                                    @foreach($condStatements as $cs)
                                        <li>
<input type="hidden" class="form-control" id="conditional_statements_id[]" value="{{ $cs->id }}">
                                            {{ $cs->description }} {{ $cs->statement_description ? ' - '
                                            .$cs->statement_description : '' }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="col-lg-12 snippet-accordion factor_column">
            <div class="theme-row m-b-10">
                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse"
                     data-target="#Hierarchy">
                    <h5 class="card-header-text">Hierarchy :</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                </div>
            </div>
            <div class="card-block collapse" id="Hierarchy">
                <div class="row">
                    @php
                    $designtype = App\Models\Patterns\DesignType::find($design->id);
                    $functions = $designtype->functions()->get();
                        $childs = $function->child()->get();
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Select output variable</label>
                            @if($childs->count() > 0)
                                <ul style="margin-left: 16px;list-style-type:circle" id="input-list">
                                    @foreach($childs as $chil)
                                        @php $pfunctionName = App\Models\Patterns\Functions::where('id',
                                        $chil->parent_functions_id)->first(); @endphp
                                        <li>{{ $pfunctionName->function_name }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            <br>
                            <select name="parent_function_id[]" id="parent_function_id" class="form-control select2"
                                    multiple >
                                <option value="0" disabled >Select Factor</option>
                                @if($functions->count() > 0)
                                    @foreach($functions as $func)
                                        <option value="{{ $func->id }}"
                                            @if($childs->count() > 0)
                                                @foreach($childs as $child)
                                                    @if($func->id == $child->id) disabled @endif
                                                @endforeach
                                            @endif
                                        >{{ $func->function_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 snippet-accordion factor_column">
            <div class="theme-row m-b-10">
                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse"
                     data-target="#ifConditions">
                    <h5 class="card-header-text">Conditional Variables :</h5><i class="fa fa-caret-down pull-right
                    micro-icons"></i>
                </div>
            </div>
            <div class="card-block collapse" id="ifConditions">
                <div class="row">
                    @php
                        $ifConditions = $function->ifConditions()->get();
                    @endphp

                    <div class="col-md-12">
                        <button type="button" class="btn btn-sm btn-primary theme-btn pull-right"
                                id="addNewCondition">Add new
                            condition</button>
                        <div class="form-group">
                            <label>Conditional Variables</label>
                            @if($ifConditions->count() > 0)
                            <ul style="margin-left: 16px;list-style-type:circle" id="input-list">
                                @foreach($ifConditions as $ifc)
                                    @php
                                        $condvars = $ifc->conditionalVariables()->get();
                                    @endphp
                                    <li>
                                        <input type="hidden" class="form-control" name="if_conditions_id[]" value="{{
                            $ifc->id }}">
                                        {{ $ifc->condition_variable }}
                                        @if($condvars->count() > 0)
                                            <ul style="margin-left: 16px;list-style-type:circle" id="input-list">
                                            @foreach($condvars as $cv)
                                                    <li>
                                                        <input type="hidden" class="form-control" name="conditional_variables_id[]" value="{{
                            $ifc->id }}">
                                                        {{ $cv->condition_text }} - {{ $cv->condition_type }}
                                                    </li>

                                            @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-12" id="ifConditionVariables">

                    </div>

                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
@section('footerscript')
    <style>
        .card-header-text{
            padding: 6px !important;
        }
        .micro-icons{
            padding: 0px 12px 4px 14px;
            position: absolute;
            right: 0px;
            top: 14px;
        }

    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/summernote/summernote.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>

    <script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('node_modules/jquery.auto-save-form/jQuery.auto-save-form.js') }}"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('resources/assets/select2/select2.min.css') }}" >
    <script src="{{ asset('resources/assets/select2/select2.full.min.js') }}"></script>

    <script>
        $(function (){
           $(".select2").select2();

            $(document).on('click','#addNewCondition',function (){
                var count = $("#ifConditionVariables > .ifConditions").length;
                count = count;

                var Data = '<div class="row ifConditions" id="condition'+count+'"> <div class="col-md-3"> <div ' +
                    'class="form-group"> <label>Condition text</label> <input type="text" class="form-control" ' +
                    'name="condition_variable[]"> </div></div><div class="col-md-4"> <div class="form-group"> ' +
                    '<label>Condition if</label> <input type="text" class="form-control" ' +
                    'name="condition_text['+count+'][]"> <input type="hidden" class="form-control" ' +
                    'name="condition_type['+count+'][]" ' +
                    'value="Y"> </div></div><div class="col-md-4"> <div class="form-group"> <label>Condition ' +
                    'else</label> <input type="text" class="form-control" name="condition_text['+count+'][]"> <input ' +
                    'type="hidden" ' +
                    'class="form-control" name="condition_type['+count+'][]" value="N"> </div></div><div ' +
                    'class="col-md-1"> ' +
                    '<label></label><br><a href="javascript:;" id="del'+count+'" class="fa fa-trash text-danger ' +
                    'deleteCondition" ' +
                    'style="margin-top:15px;"' +
                    ' data-id="'+count+'"></a> </div></div>';
                $("#ifConditionVariables").append(Data);
            });

            $(document).on('click','.deleteCondition',function (){
                var id = $(this).attr('data-id');
                if(confirm('Are you sure want to delete ?')){
                    $("#condition"+id).remove();
                }
            });

           $(document).on('click','#save',function (){
              var Data = $("#update-formula").serializeArray();

              $.ajax({
                 url : '{{ route('adminnew.update.formula') }}',
                 type : 'POST',
                 data: Data,
                 beforeSend : function (){
					$(".loading").show();
                 },
                 success : function (res){
                    alert(res.status);
                 },
                 complete : function (){
					$(".loading").hide();
                 },
                 error : function (jqXHR) {

                 }
              });
           });
        });
    </script>
@endsection
