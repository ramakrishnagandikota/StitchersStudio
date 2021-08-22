<form class="form snippets" id="sectionForm{{$did}}" method="POST" action="{{ route("save.snippet.data")}}">
    <input type="hidden" name="snippet_name" id="snippet_name" value="Snippet{{$dataCount}}" >
    <input type="hidden" name="pattern_template_id" value="{{ $pattern_template_id }}">
    <div class="form-group row m-b-zero p-10 bordered-box" id="add-function-box">
        <div class="col-lg-8 row-bg">
            <h6 class="m-b-5 m-t-5">Snippet {{$dataCount}}</h6>
        </div>
        <div class="col-lg-4 row-bg text-right">
            <a href="javascript:;" class="deleteSnippet fa fa-trash pull-right" data-server="false" data-id="{{$dataCount}}" ></a>
        </div>
        <div class="col-lg-12">
            <div class="row">
                @if($designType->functions()->count() > 0)
                    <div class="col-md-6 m-b-20">
                        <select class="form-control fill select-formula" id="select{{$section_id}}" name="function_name" data-section-id="{{$section_id}}" data-id="{{$did}}" data-count="{{$dataCount}}">
                            <option value="">Select a function</option>
                            <optgroup label="Select Snippet">
                                <option value="empty">Empty Snippet</option>
                                <!-- <option value="concatinate">Concatinate Snippet</option> -->
                                <option value="yarndetails">Yarn Details Snippet</option>
                            </optgroup>
                            <optgroup label="Select Formula">
                                @foreach($allFunctions as $dtf)
                                    @php
                                        $addedSnippetsCount = App\Models\Patterns\Snippet::where('pattern_template_id',$pattern_template_id)
                                        ->where('function_id',$dtf->id)->count();
                                    @endphp
									@if($addedSnippetsCount == 0)
										<option value="{{$dtf->id}}" @if($dtf->id == $function->id) selected @endif >{{$dtf->function_name}}</option>
									@endif
                                @endforeach
                            </optgroup>
                        </select>
                        <span class="function_name text-danger"></span>
                    </div>
                @endif
                <div class="col-md-12" id="functionData{{$did}}">
                    @csrf
                    <input type="hidden" id="section_id" name="section_id" value="{{ $section_id }}">
                    <div class="row">


                        <div class="col-lg-12 snippet-accordion factor_column">
                            <div class="row theme-row m-b-10">
                                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-sampleInstruction{{ $dataCount }}">
                                    <h5 class="card-header-text">Sample Instruction:</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                            </div>
                            <div class="card-block collapse" id="child-sampleInstruction{{ $dataCount }}">
                                {!! $function->sample_instruction !!}
								<h5>Sample Output : </h5>
								{!! $function->output_instruction !!}
                            </div>
                        </div>


                        @if($function->inputVariables()->count() > 0)

                            <div class="col-lg-6 snippet-accordion">
                                <div class="row theme-row m-b-10">
                                    <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1Inputs{{ $dataCount }}">
                                        <h5 class="card-header-text">Inputs:</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                </div>
                                <div class="card-block collapse" id="child-accord1Inputs{{ $dataCount }}">
                                    <ul style="margin-left: 16px;list-style-type:circle" id="input-list">
                                        @foreach($function->inputVariables as $inp)
                                            <li>{{ ucfirst($inp->variable_name) }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        @endif

                        @if($function->outputVariables()->count() > 0)

                            <div class="col-lg-6 snippet-accordion factor_column">
                                <div class="row theme-row m-b-10">
                                    <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1output{{ $dataCount }}">
                                        <h5 class="card-header-text">Output variables:</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                </div>
                                <div class="card-block collapse" id="child-accord1output{{ $dataCount }}">
                                    <ul class="list-unstyled" id="output-variables">
                                        @foreach($function->outputVariables as $out)
                                            <li>{{ $out->variable_name }} <i class="fa fa-info-circle" title="{{ $out->variable_name }}" data-toggle="popover" data-trigger="focus" data-html="true" data-placement="top" data-content="<?php echo htmlspecialchars($out->variable_description); ?>"></i></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if($function->factors()->count() > 0)
                            @foreach($function->factors as $factor)
                                @php
                                    $lower = Str::lower($factor->factor_name);
                                    $fname_slug = Str::slug($lower,'_');
                                @endphp
                                <input type="hidden" name="factor_name" value="{{ $fname_slug }}">
                                <input type="hidden" name="factor_id" value="{{ $factor->id }}">

                                @if($factor->is_stitches == 0)
                                    @if($factor->pivot->factor_uom == 'in')

                                        <div class="col-lg-6 snippet-accordion factor_column">
                                            <div class="row theme-row m-b-10">
                                                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1factor_column1{{ $dataCount }}{{$factor->id}}{{$factor->pivot->factor_uom}}">
                                                    <h5 class="card-header-text">{{ $factor->factor_name }} ({{ ($factor->pivot->factor_uom == 'in') ? 'Inches' : 'Cm' }}):</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                            </div>
                                            <div class="card-block collapse" id="child-accord1factor_column1{{ $dataCount }}{{$factor->id}}{{$factor->pivot->factor_uom}}">
                                                <input type="hidden" name="factor_uom[]" value="{{ $factor->pivot->factor_uom }}">

                                                <select class="form-control fill select-factor" name="factor_in[]" id="factor{{$factor->pivot->factor_uom}}">
                                                    <option value="">Select {{ $factor->factor_name }}</option>
                                                    @if($factor->range != 0)
                                                        @for($i=$factor->min_value;$i<=$factor->max_value;$i+=$factor->range)
                                                            <option value="{{ $i }}"> {{ $i }}</option>
                                                        @endfor
                                                    @else
                                                        @for($i=$factor->min_value;$i<=$factor->max_value;$i++)
                                                            <option value="{{ $i }}"> {{ $i }}</option>
                                                        @endfor
                                                    @endif

                                                </select>
                                                <span class="factor{{$factor->pivot->factor_uom}} text-danger"></span>
                                            </div>
                                        </div>

                                    @else
                                        <div class="col-lg-6 snippet-accordion factor_column">
                                            <div class="row theme-row m-b-10">
                                                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1factor_column1{{ $dataCount }}{{$factor->id}}{{$factor->pivot->factor_uom}}">
                                                    <h5 class="card-header-text">{{ $factor->factor_name }} ({{ ($factor->pivot->factor_uom == 'in') ? 'Inches' : 'Cm' }}):</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                            </div>
                                            <div class="card-block collapse" id="child-accord1factor_column1{{ $dataCount }}{{$factor->id}}{{$factor->pivot->factor_uom}}">
                                                <input type="hidden" name="factor_uom[]" value="{{ $factor->pivot->factor_uom }}">
                                                <select class="form-control fill select-factor" name="factor_cm[]" id="factor{{$factor->pivot->factor_uom}}">
                                                    <option value="">Select {{ $factor->factor_name }}</option>
                                                    @if($factor->range != 0)
                                                        @for($i=$factor->min_value;$i<=$factor->max_value;$i+=$factor->range)
                                                            <option value="{{ $i }}"> {{ $i }}</option>
                                                        @endfor
                                                    @else
                                                        @for($i=$factor->min_value;$i<=$factor->max_value;$i++)
                                                            <option value="{{ $i }}"> {{ $i }}</option>
                                                        @endfor
                                                    @endif

                                                </select>
                                                <span class="factor{{$factor->pivot->factor_uom}} text-danger"></span>
                                            </div>
                                        </div>
                                    @endif
                                @else
                                    @if($factor->pivot->factor_uom == 'in')

                                        <div class="col-lg-6 snippet-accordion factor_column">
                                            <div class="row theme-row m-b-10">
                                                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1factor_column1{{ $dataCount }}{{$factor->id}}{{$factor->pivot->factor_uom}}">
                                                    <h5 class="card-header-text">{{ $factor->factor_name }} :</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                            </div>
                                            <div class="card-block collapse" id="child-accord1factor_column1{{ $dataCount }}{{$factor->id}}{{$factor->pivot->factor_uom}}">
                                                <input type="hidden" name="factor_uom[]" value="{{ $factor->pivot->factor_uom }}">

                                                <select class="form-control fill select-factor" name="factor_in[]" id="factor{{$factor->pivot->factor_uom}}">
                                                    <option value="">Select {{ $factor->factor_name }}</option>
                                                    @if($factor->range != 0)
                                                        @for($i=$factor->min_value;$i<=$factor->max_value;$i+=$factor->range)
                                                            <option value="{{ $i }}"> {{ $i }}</option>
                                                        @endfor
                                                    @else
                                                        @for($i=$factor->min_value;$i<=$factor->max_value;$i++)
                                                            <option value="{{ $i }}"> {{ $i }}</option>
                                                        @endfor
                                                    @endif
                                                </select>
                                                <input type="hidden" name="factor_cm[]" id="factorcm" value="0">
                                                <input type="hidden" name="factor_uom[]" value="cm">
                                                <span class="factor{{$factor->pivot->factor_uom}} text-danger"></span>
                                            </div>
                                        </div>

                                    @endif
                                @endif


                            @endforeach
                        @endif

                        @if($function->modifiers()->count() > 0)
                            @foreach($function->modifiers as $modifier)

                                @php
                                    $lower1 = Str::lower($modifier->modifier_name);
                                    $mname_slug = Str::slug($lower1,'_');
                                @endphp
                                <input type="hidden" name="modifier_name" value="{{ $mname_slug }}">
                                <input type="hidden" name="modifier_id" value="{{ $modifier->id }}">

                                @if($modifier->is_stitches == 0)
                                    @if($modifier->pivot->modifier_uom == 'in')

                                        <div class="col-lg-6 snippet-accordion factor_column">
                                            <div class="row theme-row m-b-10">
                                                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse"  data-target="#child-accord1modifier_column1{{ $dataCount }}{{$modifier->pivot->modifier_uom}}{{$modifier->id}}0">
                                                    <h5 class="card-header-text">{{ $modifier->modifier_name }} ({{ ($modifier->pivot->modifier_uom == 'in') ? 'Inches' : 'Cm' }}):</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                            </div>
                                            <div class="card-block collapse" id="child-accord1modifier_column1{{ $dataCount }}{{$modifier->pivot->modifier_uom}}{{$modifier->id}}0">

                                                <input type="hidden" name="modifier_uom[]" value="{{$modifier->pivot->modifier_uom}}">

                                                <select class="form-control fill select-factor" name="modifier_in[]" id="modifier{{$modifier->pivot->modifier_uom}}">
                                                    <option value="">Select {{ $modifier->modifier_name }}</option>
                                                    @if($modifier->is_negative == 1)
                                                        @foreach (range('-'.$modifier->max_value, $modifier->max_value) as $number) {
                                                        @if($number > 0)
                                                            <option value="{{ $number }}">+ {{ $number }} stitches</option>
                                                        @elseif($number == 0)
                                                            <option value="{{ $number }}">+ {{ $number }} stitches</option>
                                                        @else
                                                            <option value="{{ $number }}"> {{ $number }} stitches</option>
                                                        @endif
                                                        @endforeach
                                                    @else
                                                        @for($j=$modifier->min_value;$j<=$modifier->max_value;$j++)
                                                            <option value="{{ $j }}">+ {{ $j }} stitches</option>
                                                        @endfor
                                                    @endif
                                                </select>
                                                <span class="modifier_in{{$modifier->pivot->modifier_uom}} text-danger"></span>
                                            </div>
                                        </div>

                                    @else
                                        <div class="col-lg-6 snippet-accordion factor_column">
                                            <div class="row theme-row m-b-10">
                                                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1modifier_column1{{ $dataCount }}{{$modifier->pivot->modifier_uom}}{{$modifier->id}}0">
                                                    <h5 class="card-header-text">{{ $modifier->modifier_name }} ({{ ($modifier->pivot->modifier_uom == 'in') ? 'Inches' : 'Cm' }}):</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                            </div>
                                            <div class="card-block collapse" id="child-accord1modifier_column1{{ $dataCount }}{{$modifier->pivot->modifier_uom}}{{$modifier->id}}0">

                                                <input type="hidden" name="modifier_uom[]" value="{{$modifier->pivot->modifier_uom}}">

                                                <select class="form-control fill select-factor" name="modifier_cm[]" id="modifier{{$modifier->pivot->modifier_uom}}">
                                                    <option value="">Select {{ $modifier->modifier_name }}</option>
                                                    @if($modifier->is_negative == 1)
                                                        @foreach (range('-'.$modifier->max_value, $modifier->max_value) as $number) {
                                                        @if($number > 0)
                                                            <option value="{{ $number }}">+ {{ $number }} stitches</option>
                                                        @elseif($number == 0)
                                                            <option value="{{ $number }}">+ {{ $number }} stitches</option>
                                                        @else
                                                            <option value="{{ $number }}"> {{ $number }} stitches</option>
                                                        @endif
                                                        @endforeach
                                                    @else
                                                        @for($j=$modifier->min_value;$j<=$modifier->max_value;$j++)
                                                            <option value="{{ $j }}">+ {{ $j }} stitches</option>
                                                        @endfor
                                                    @endif
                                                </select>
                                                <span class="modifier_cm{{$modifier->pivot->modifier_uom}} text-danger"></span>
                                            </div>
                                        </div>

                                    @endif
                                @else
                                    @if($modifier->pivot->modifier_uom == 'in')

                                        <div class="col-lg-6 snippet-accordion factor_column">
                                            <div class="row theme-row m-b-10">
                                                <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1modifier_column1{{ $dataCount }}{{$modifier->pivot->modifier_uom}}{{$modifier->id}}0">
                                                    <h5 class="card-header-text">{{ $modifier->modifier_name }} :</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                            </div>
                                            <div class="card-block collapse" id="child-accord1modifier_column1{{ $dataCount }}{{$modifier->pivot->modifier_uom}}{{$modifier->id}}0">

                                                <input type="hidden" name="modifier_uom[]" value="{{$modifier->pivot->modifier_uom}}">

                                                <select class="form-control fill select-modifier" name="modifier_in[]" id="modifier{{$modifier->pivot->modifier_uom}}">
                                                    <option value="">Select {{ $modifier->modifier_name }}</option>
                                                    @if($modifier->is_negative == 1)
                                                        @foreach (range('-'.$modifier->max_value, $modifier->max_value) as $number) {
                                                        @if($number > 0)
                                                            <option value="{{ $number }}">+ {{ $number }} stitches</option>
                                                        @elseif($number == 0)
                                                            <option value="{{ $number }}">+ {{ $number }} stitches</option>
                                                        @else
                                                            <option value="{{ $number }}"> {{ $number }} stitches</option>
                                                        @endif
                                                        @endforeach
                                                    @else
                                                        @for($j=$modifier->min_value;$j<=$modifier->max_value;$j++)
                                                            <option value="{{ $j }}">+ {{ $j }} stitches</option>
                                                        @endfor
                                                    @endif
                                                </select>
                                                <input type="hidden" name="modifier_cm[]" id="modifiercm" value="0">
                                                <input type="hidden" name="modifier_uom[]" value="cm">

                                                <span class="modifier_in{{$modifier->pivot->modifier_uom}} text-danger"></span>
                                            </div>
                                        </div>
										
										
							
                                    @endif
                                @endif

                            @endforeach
                        @endif



                    </div>

                    <!-- conditional variables here -->


						@php
							$IfConditions = $function->ifConditions()->orderBy('sort','ASC')->get();
						@endphp
                    @if($IfConditions->count() > 0)
                        <h5 class="m-t-10 text-danger">Conditional Statements:-</h5> <br>
                        @foreach($IfConditions as $ifcond)
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="card-header m-b-5 snippet{{$dataCount}} mt-10" role="tab" id="headingOne12{{$ifcond->id}}{{$function->id}}" style="background-color: #dedddd;width:100%;">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne12{{$ifcond->id}}{{$function->id}}" aria-expanded="true" aria-controls="collapseOne1">
                                            <h5 class="mb-0">Conditional Variable : {{ $ifcond->condition_variable }}</h5>
                                            <i class="fa fa-caret-down pull-right micro-icons"></i>
                                        </a>
                                    </div>

                                    <div id="collapseOne12{{$ifcond->id}}{{$function->id}}" class="collapse snippets mb-10 col-md-12 row" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">

                                        @if($ifcond->conditionalVariables()->count() > 0)
                                            @foreach($ifcond->conditionalVariables as $condvars)
                                                <input type="hidden" name="if_condition_id[]" value="{{ $ifcond->id }}">
                                                <input type="hidden" name="condition_variable_id[]" value="{{ $condvars->id }}">
                                                <h5 class="m-t-10 m-b-10 text-danger">{{ $condvars->condition_text }}</h5>
                                                <textarea id="editor{{$condvars->id}}0{{$dataCount}}{{$ifcond->id}}" name="condition_description[]" class="form-control"></textarea>
                                                @component('designer.patterns.summernote', ['condId' => $condvars->id,'k' => 0,'dataCount' => $dataCount,'l' => $ifcond->id,'outputVariables' => $function->outputVariables,'measurements' => $measurements]) @endcomponent
                                            @endforeach
                                            <br>
                                        @endif

                                    </div>

                                </div>
                            </div>

                        @endforeach
                    @endif

                <!-- conditional variables here -->

                    @if($function->conditionalStatements()->count() > 0)
                    <!--This row is only for Conditional-->
                        <div class="row m-t-20" id="cond-row">
                            <div class="col-lg-12">
                                <?php $k=1; ?>
                                @foreach($function->conditionalStatements as $cond)
                                    <input type="hidden" class="cond_stmt_id{{$dataCount}}" name="cond_stmt_id[]" data-k="{{$k}}" value="{{ $cond->id }}">
                                    <!-- sub sccordion starts here -->
                                    <div class="card-header m-b-5 snippet{{$dataCount}}" role="tab" id="headingOne1{{$did}}{{$cond->id}}{{$dataCount}}" style="background-color: #dedddd;">
                                        <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1{{$cond->id}}{{$k}}{{$dataCount}}" aria-expanded="true" aria-controls="collapseOne1">
                                            <h5 class="mb-0">
                                                {!! $cond->description !!} :- {!! $cond->statement_description !!}
                                            </h5>
                                            <i class="fa fa-caret-down pull-right micro-icons"></i>
                                        </a>

                                        <div class="row" style="position: absolute;right: 50px;z-index: 10;top: 10px;@if($k == 1) display:none; @endif" >
                                            <div class="col-md-12">
                                                <div class="checkbox">

                                                    <input type="checkbox" class="sameAsCondition sameCond1{{$dataCount}}"  id="sameCond1{{$cond->id}}{{$k}}{{$dataCount}}"  value="{{$cond->id}}" data-divId="{{$cond->id}}{{$k}}{{$dataCount}}" data-tabid="{{$did}}{{$cond->id}}{{$dataCount}}" data-condid="{{$cond->id}}" data-sid="{{$dataCount}}" data-k="{{$k}}" @if($k != 1) checked @endif >Same as Condition 1
                                                    <input type="hidden" name="sameAsCondition[]" value="@if($k != 1) 1 @else 0 @endif" >
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                <!--<h5 class="theme-light-row">{!! $cond->description !!} :- {!! $cond->statement_description !!}</h5> -->

                                    <div id="collapseOne1{{$cond->id}}{{$k}}{{$dataCount}}" class="collapse snippets{{$dataCount}}{{$cond->id}}" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">

                                        <ul class="list-unstyled m-b-10" style="margin-left: 10px;" id="cond_instruction">
                                            @php
                                                //$inst = $cond->base_instructions;
                                                $inst = $cond->sample_instruction;
$array = array('[[PART-1]]','[[PART-2]]','[[PART-3]]','[[PART-4]]','[[PART-5]]','[[PART-6]]','[[PART-7]]','[[PART-8]]','[[PART-9]]','[[PART-10]]','[[PART-11]]','[[PART-12]]','[[PART-13]]','[[PART-14]]');

$array1 = array('<span class="text-danger">[[PART-1]]</span>','<span class="text-danger">[[PART-2]]</span>','<span class="text-danger">[[PART-3]]</span>','<span class="text-danger">[[PART-4]]</span>','<span class="text-danger">[[PART-5]]</span>','<span class="text-danger">[[PART-6]]</span>','<span class="text-danger">[[PART-7]]</span>','<span class="text-danger">[[PART-8]]</span>','<span class="text-danger">[[PART-9]]</span>','<span class="text-danger">[[PART-10]]</span>','<span class="text-danger">[[PART-11]]</span>','<span class="text-danger">[[PART-12]]</span>','<span class="text-danger">[[PART-13]]</span>','<span class="text-danger">[[PART-14]]</span>');
                                                $res = str_replace($array,$array1,$inst);
                                            @endphp
                                            <!-- <li class="desc"><b>Sample Instruction :- </b> {{ $cond->sample_instruction }}</li> -->
                                        </ul>
                                    @for($l=1;$l<=$cond->instructions_count;$l++)
                                        <!-- <h5 class="m-t-10 text-danger">PART-{{ $l }}</h5> -->
                                            <h5 class="m-t-10 m-b-10"> Instruction :</h5>
                                            <input type="hidden" class="conditional_statements_id{{$dataCount}}" name="conditional_statements_id[]" value="{{ $cond->id }}">
                                            <textarea  id="editor{{$cond->id}}{{$k}}{{$dataCount}}{{$l}}" class="hint2mention summernote m-b-10 form-control condition{{$cond->id}} sn{{$cond->id}}{{$k}}{{$dataCount}}{{$l}}"  name="description[]" data-condid="{{$cond->id}}" data-cid="{{$did}}{{$cond->id}}" data-sid="{{$dataCount}}" data-k="{{$k}}" data-l="{{$l}}"></textarea>
                                            <span class="summernote-required text-danger sn1{{$cond->id}}{{$k}}{{$dataCount}}"></span>
                                            @component('designer.patterns.summernote', ['condId' => $cond->id,'k' => $k,'dataCount' => $dataCount,'l' => $l,'outputVariables' => $function->outputVariables,'measurements' => $measurements]) @endcomponent
                                        @endfor

                                        <br>
                                    </div>

                                    <!-- sub accordion ends here -->
                                    <?php $k++; ?>
                                @endforeach

                            </div>
                        </div>
                        <!------------------------------------>
                    @endif

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn theme-btn btn-sm pull-right m-t-10 submitSnippet" data-id="sectionForm{{ $did }}" data-snippet-id="{{ $dataCount }}">Save</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</form>
