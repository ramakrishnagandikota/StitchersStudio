@if($allsections->count() > 0)
    @php $sec = 1; @endphp
    @foreach($allsections as $allsec)

        <div class="row theme-row m-b-10 section{{$allsec->id}}" >
            <div class="card-header accordion col-lg-12 col-sm-12" data-toggle="collapse" data-target="#PTsection4{{ $allsec->id }}">
                <h5 class="card-header-text username" data-type="text" data-pk="{{ $allsec->id }}_{{$pattern_template_id}}" >{{ $allsec->section_name }}</h5>
                <i class="fa fa-caret-down pull-right micro-icons"></i>
            </div>
        </div>


        <div class="card-block collapse section{{ $allsec->id }}" id="PTsection4{{ $allsec->id }}">
            <!--Starting snippets Box-->
            @if($allsec->snippets()->count() > 0)
                <?php $se = 1; ?>
                @foreach($allsec->snippets as $snip)
                    <div class="allsnippets" id="snippet{{$se}}">
                        <form class="form" id="sectionForm{{$allsec->id}}{{$se}}">
                            <input type="hidden" name="snippet_id" value="{{$snip->id}}">
                            <input type="hidden" name="snippet_name" value="{{$snip->snippet_name}}">
                            <input type="hidden" name="section_id" value="{{ $allsec->id }}">
                            <div class="form-group row m-b-zero p-10 bordered-box snippets" id="add-function-box">

                                <div class="col-lg-8 row-bg">
                                    <h6 class="m-b-5 m-t-5">{{ $snip->snippet_name }}</h6>
                                </div>
                                <div class="col-lg-4 row-bg text-right">
                                    <!-- delete button here-->
                                </div>

                                <!-- empty snippet starts here -->
                                @if($snip->is_empty == 1)
                                    <div class="col-lg-12">
                                        <input type="hidden" name="is_empty" value="{{ $snip->is_empty }}">
                                        <textarea class="hint2mention summernoteDescription m-b-10" name="snippet_description">{!! $snip->snippet_description !!}</textarea>
                                    </div>

                                @endif



                                @if($snip->is_yarn == 1)

                                    <div class="col-lg-12">

                                        <div class="row">
                                            <h5 class="theme-light-row col-md-12">Yarn details</h5>
                                        </div>

                                        <input type="hidden" name="is_yarn" value="{{ $snip->is_yarn }}">
                                        <div class="row m-t-10" id="addYarnData{{$snip->id}}">
                                            @if($snip->yarnDetails()->count() > 0)
                                                <?php $y = 0; ?>
                                                @foreach($snip->yarnDetails as $yd)
                                                    <div class="col-md-6 allYd m-b-10" id="yd{{$yd->id}}">
                                                        <input type="hidden" name="yarn_detail_id[]" value="{{ $yd->id }}">
                                                        <input type="text" class="form-control" name="yarn_title[]" value="{{ $yd->yarn_title }}"><br>
                                                        <textarea name="yarn_details[]" class="form-control" required="required" placeholder="Enter yarn url">{!! $yd->yarn_content !!}</textarea>
                                                    </div>
                                                    <?php $y++; ?>
                                                @endforeach
                                            @endif
                                        </div>

                                    </div>
                                @endif


                            <!-- empty snippet ends here -->

                                <!--
                   /******************** Concatinate snippet removed from here ***************************/
                                     -->

                                <!-- formulas start here -->
                                @if($snip->function_id != 0)
                                    @php
                                        $function = App\Models\Patterns\Functions::where('id',$snip->function_id)->first();
                                    @endphp


                                    <div class="col-lg-12">
                                        <div class="row">
                                            @if($designType->functions()->count() > 0)
                                                <div class="col-md-3 m-b-20">
                                                    <select disabled class="form-control fill" >
                                                        <option value="">Select a snippet</option>
                                                        <optgroup label="Select Snippet">
                                                            <option value="empty">Empty Snippet</option>
                                                            <!--<option value="concatinate">Concatinate Snippet</option>-->
                                                            <option value="yarndetails">Yarn Details Snippet</option>
                                                        </optgroup>
                                                        <optgroup label="Select Formula">

                                                            @foreach($designType->functions as $dtf)
                                                                <option value="{{ $dtf->id }}" @if($function->id == $dtf->id) selected @endif >{{ ucfirst($dtf->function_name) }}</option>
                                                            @endforeach
                                                        </optgroup>
                                                    </select>
                                                    <input type="hidden" name="function_name" value="{{ $function->id }}">
                                                    <span class="function_name text-danger"></span>
                                                </div>
                                        @endif

                                        <!--End snippets Box-->
                                        </div>
                                    </div>



                                    <div class="col-md-12" id="functionData{{$allsec->id}}{{$se}}">
                                        <div class="row">
                                            <input type="hidden" id="section_id" name="section_id" value="{{ $allsec->id }}{{$se}}">
                                            @if($function->inputVariables()->count() > 0)

                                                <div class="col-lg-6 snippet-accordion">
                                                    <div class="row theme-row m-b-10">
                                                        <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1Inputs{{ $allsec->id }}{{$se}}">
                                                            <h5 class="card-header-text">Inputs:</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                                    </div>
                                                    <div class="card-block collapse" id="child-accord1Inputs{{ $allsec->id }}{{$se}}">
                                                        @foreach($function->inputVariables as $inp)
                                                            <li>{{ ucfirst($inp->variable_name) }}</li>
                                                        @endforeach
                                                    </div>
                                                </div>

                                            @endif

                                            @if($function->outputVariables()->count() > 0)

                                                <div class="col-lg-6 snippet-accordion factor_column">
                                                    <div class="row theme-row m-b-10">
                                                        <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1output{{ $allsec->id }}{{$se}}">
                                                            <h5 class="card-header-text">Output variables:</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                                    </div>
                                                    <div class="card-block collapse" id="child-accord1output{{ $allsec->id }}{{$se}}">
                                                        <ul class="list-unstyled" id="output-variables">
                                                            @foreach($function->outputVariables as $out)
                                                                <li>{{ $out->variable_name }}</li>
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
                                                        $fac = $snip->factors()->where('is_factor_modifier',1)->first();
                                                    @endphp
                                                    <input type="hidden" name="factor_name" value="{{ $fname_slug }}">
                                                    <input type="hidden" name="factor_id" value="{{ $factor->id }}">
                                                     @if($fac)
                                        <input type="hidden" name="snip_factor_id" value="{{ $fac->id }}">
                                    @endif



                                        @if($factor->is_stitches == 0)
                                            @if($factor->pivot->factor_uom == 'in')

                                                <div class="col-lg-6 snippet-accordion factor_column">
                                                    <div class="row theme-row m-b-10">
                                                        <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1factor_column1{{ $allsec->id }}{{$se}}{{$factor->pivot->factor_uom}}">
                                                            <h5 class="card-header-text">{{ $factor->factor_name }} ({{ ($factor->pivot->factor_uom == 'in') ? 'Inches' : 'Cm' }}):</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                                    </div>
                                                    <div class="card-block collapse" id="child-accord1factor_column1{{ $allsec->id }}{{$se}}{{$factor->pivot->factor_uom}}">

                                                        <input type="hidden" name="factor_uom[]" value="{{$factor->pivot->factor_uom}}">
                                                        @if($fac)
                                                            <select class="form-control fill select-factor" name="factor_in[]" id="factor{{$factor->pivot->factor_uom}}">
                                                                <option value="">Select {{ $factor->factor_name }}</option>
                                                                @if($factor->range != 0)
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i+=$factor->range)
                                                                        <option value="{{ $i }}" @if($fac->input_value_in == $i) selected @endif  > {{ $i }}</option>
                                                                    @endfor
                                                                @else
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i++)
                                                                        <option value="{{ $i }}" @if($fac->input_value_in == $i) selected @endif > {{ $i }}</option>
                                                                    @endfor
                                                                @endif

                                                            </select>
                                                        @else
                                                            <select class="form-control fill select-factor" name="factor_in[]" id="factor{{$factor->pivot->factor_uom}}">
                                                                <option value="">Select {{ $factor->factor_name }}</option>
                                                                @if($factor->range != 0)
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i+=$factor->range)
                                                                        <option value="{{ $i }}"  > {{ $i }}</option>
                                                                    @endfor
                                                                @else
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i++)
                                                                        <option value="{{ $i }}"  > {{ $i }}</option>
                                                                    @endfor
                                                                @endif

                                                            </select>
                                                        @endif

                                                        <span class="factor_in{{$factor->pivot->factor_uom}} text-danger"></span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-lg-6 snippet-accordion factor_column">
                                                    <div class="row theme-row m-b-10">
                                                        <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1factor_column1{{ $allsec->id }}{{$se}}{{$factor->pivot->factor_uom}}">
                                                            <h5 class="card-header-text">{{ $factor->factor_name }} :</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                                    </div>
                                                    <div class="card-block collapse" id="child-accord1factor_column1{{ $allsec->id }}{{$se}}{{$factor->pivot->factor_uom}}">

                                                        <input type="hidden" name="factor_uom[]" value="{{$factor->pivot->factor_uom}}">
                                                        @if($fac)
                                                            <select class="form-control fill select-factor" name="factor_cm[]" id="factor{{$factor->pivot->factor_uom}}">
                                                                <option value="">Select {{ $factor->factor_name }}</option>
                                                                @if($factor->range != 0)
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i+=$factor->range)
                                                                        <option value="{{ $i }}" @if($fac->input_value_cm == $i) selected @endif  > {{ $i }}</option>
                                                                    @endfor
                                                                @else
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i++)
                                                                        <option value="{{ $i }}" @if($fac->input_value_cm == $i) selected @endif > {{ $i }}</option>
                                                                    @endfor
                                                                @endif

                                                            </select>
                                                        @else

                                                            <select class="form-control fill select-factor" name="factor_cm[]" id="factor{{$factor->pivot->factor_uom}}">
                                                                <option value="">Select {{ $factor->factor_name }}</option>
                                                                @if($factor->range != 0)
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i+=$factor->range)
                                                                        <option value="{{ $i }}"   > {{ $i }}</option>
                                                                    @endfor
                                                                @else
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i++)
                                                                        <option value="{{ $i }}"  > {{ $i }}</option>
                                                                    @endfor
                                                                @endif

                                                            </select>
                                                        @endif

                                                        <span class="factor_cm{{$factor->pivot->factor_uom}} text-danger"></span>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            @if($factor->pivot->factor_uom == 'in')

                                                <div class="col-lg-6 snippet-accordion factor_column">
                                                    <div class="row theme-row m-b-10">
                                                        <div class="card-header accordion p-1 col-lg-12 col-sm-12" data-toggle="collapse" data-target="#child-accord1factor_column1{{ $allsec->id }}{{$se}}{{$factor->pivot->factor_uom}}">
                                                            <h5 class="card-header-text">{{ $factor->factor_name }} :</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                                    </div>
                                                    <div class="card-block collapse" id="child-accord1factor_column1{{ $allsec->id }}{{$se}}{{$factor->pivot->factor_uom}}">

                                                        <input type="hidden" name="factor_uom[]" value="{{$factor->pivot->factor_uom}}">
                                                        @if($fac)
                                                            <select class="form-control fill select-factor" name="factor_in[]" id="factor{{$factor->pivot->factor_uom}}">
                                                                <option value="">Select {{ $factor->factor_name }}</option>
                                                                @if($factor->range != 0)
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i+=$factor->range)
                                                                        <option value="{{ $i }}" @if($fac->input_value_in == $i) selected @endif  > {{ $i }}</option>
                                                                    @endfor
                                                                @else
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i++)
                                                                        <option value="{{ $i }}" @if($fac->input_value_in == $i) selected @endif > {{ $i }}</option>
                                                                    @endfor
                                                                @endif

                                                            </select>
                                                        @else
                                                            <select class="form-control fill select-factor" name="factor_in[]" id="factor{{$factor->pivot->factor_uom}}">
                                                                <option value="">Select {{ $factor->factor_name }}</option>
                                                                @if($factor->range != 0)
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i+=$factor->range)
                                                                        <option value="{{ $i }}"  > {{ $i }}</option>
                                                                    @endfor
                                                                @else
                                                                    @for($i=$factor->min_value;$i<=$factor->max_value;$i++)
                                                                        <option value="{{ $i }}"  > {{ $i }}</option>
                                                                    @endfor
                                                                @endif

                                                            </select>
                                                        @endif
                                                        <input type="hidden" name="factor_cm[]" id="factorcm" value="{{ $fac ? $fac->input_value_cm : 0 }}">
                                                        <input type="hidden" name="factor_uom[]" value="cm">

                                                        <span class="factor_in{{$factor->pivot->factor_uom}} text-danger"></span>
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
                                                        $mod = $snip->modifiers()->where('is_factor_modifier',2)->first();
                                                    @endphp
                                                    <input type="hidden" name="modifier_name" value="{{ $mname_slug }}">
                                                    <input type="hidden" name="modifier_id" value="{{ $modifier->id }}">
                                                    @if($mod)
                                        <input type="hidden" name="snip_modifier_id" value="{{ $mod->id }}">
                                        @endif


                                        @if($modifier->is_stitches == 0)
                                            @if($modifier->pivot->modifier_uom == 'in')
                                                <div class="col-lg-6 snippet-accordion factor_column">
                                                    <div class="row theme-row m-b-10">
                                                        <div class="card-header accordion p-1 col-lg-12 col-sm-12"  data-target="#child-accord1modifier_column1{{ $allsec->id }}{{$se}}{{$modifier->id}}{{$modifier->pivot->id}}">
                                                            <h5 class="card-header-text">{{ $modifier->modifier_name }} ({{ ($modifier->pivot->modifier_uom == 'in') ? 'Inches' : 'Cm' }}):</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                                    </div>
                                                    <div class="card-block collapse" id="child-accord1modifier_column1{{ $allsec->id }}{{$se}}{{$modifier->id}}{{$modifier->pivot->id}}">
                                                        <input type="hidden" name="modifier_uom[]" value="{{$modifier->pivot->modifier_uom}}">
                                                        @if($mod)
                                                            <select class="form-control fill select-factor" name="modifier_in[]" id="modifier{{$modifier->pivot->modifier_uom}}">
                                                                <option value="">Select {{ $modifier->modifier_name }}</option>
                                                                @if($modifier->is_negative == 1)
                                                                    @foreach (range('-'.$modifier->max_value, $modifier->max_value) as $number) {
                                                                    @if($number > 0)
                                                                        <option value="{{ $number }}" @if($mod->input_value_in == $number) selected @endif >+ {{ $number }} stitches</option>
                                                                    @elseif($number == 0)
                                                                        <option value="{{ $number }}" @if($mod->input_value_in == $number) selected @endif >+ {{ $number }} stitches</option>
                                                                    @else
                                                                        <option value="{{ $number }}" @if($mod->input_value_in == $number) selected @endif > {{ $number }} stitches</option>
                                                                    @endif
                                                                    @endforeach
                                                                @else
                                                                    @for($j=$modifier->min_value;$j<=$modifier->max_value;$j++)
                                                                        <option value="{{ $j }}" @if($mod->input_value_in == $j) selected @endif >+ {{ $j }} stitches</option>
                                                                    @endfor
                                                                @endif
                                                            </select>
                                                        @else
                                                            <select class="form-control fill select-factor" name="modifier_in[]" id="modifier{{$modifier->pivot->modifier_uom}}">
                                                                <option value="">Select {{ $modifier->modifier_name }}</option>
                                                                @if($modifier->is_negative == 1)
                                                                    @foreach (range('-'.$modifier->max_value, $modifier->max_value) as $number) {
                                                                    @if($number > 0)
                                                                        <option value="{{ $number }}" >+ {{ $number }} stitches</option>
                                                                    @elseif($number == 0)
                                                                        <option value="{{ $number }}"  >+ {{ $number }} stitches</option>
                                                                    @else
                                                                        <option value="{{ $number }}"  > {{ $number }} stitches</option>
                                                                    @endif
                                                                    @endforeach
                                                                @else
                                                                    @for($j=$modifier->min_value;$j<=$modifier->max_value;$j++)
                                                                        <option value="{{ $j }}" >+ {{ $j }} stitches</option>
                                                                    @endfor
                                                                @endif
                                                            </select>
                                                        @endif
                                                        <span class="modifier_in{{$modifier->pivot->modifier_uom}} text-danger"></span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="col-lg-6 snippet-accordion factor_column">
                                                    <div class="row theme-row m-b-10">
                                                        <div class="card-header accordion p-1 col-lg-12 col-sm-12"  data-target="#child-accord1modifier_column1{{ $allsec->id }}{{$se}}{{$modifier->pivot->modifier_uom}}">
                                                            <h5 class="card-header-text">{{ $modifier->modifier_name }} ({{ ($modifier->pivot->modifier_uom == 'in') ? 'Inches' : 'Cm' }}):</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                                    </div>
                                                    <div class="card-block collapse" id="child-accord1modifier_column1{{ $allsec->id }}{{$se}}{{$modifier->pivot->modifier_uom}}">
                                                        <input type="hidden" name="modifier_uom[]" value="{{$modifier->pivot->modifier_uom}}">
                                                        @if($mod)
                                                            <select class="form-control fill select-factor" name="modifier_cm[]" id="modifier{{$modifier->pivot->modifier_uom}}">
                                                                <option value="">Select {{ $modifier->modifier_name }}</option>
                                                                @if($modifier->is_negative == 1)
                                                                    @foreach (range('-'.$modifier->max_value, $modifier->max_value) as $number) {
                                                                    @if($number > 0)
                                                                        <option value="{{ $number }}" @if($mod->input_value_cm == $number) selected @endif >+ {{ $number }} stitches</option>
                                                                    @elseif($number == 0)
                                                                        <option value="{{ $number }}" @if($mod->input_value_cm == $number) selected @endif >+ {{ $number }} stitches</option>
                                                                    @else
                                                                        <option value="{{ $number }}" @if($mod->input_value_cm == $number) selected @endif > {{ $number }} stitches</option>
                                                                    @endif
                                                                    @endforeach
                                                                @else
                                                                    @for($j=$modifier->min_value;$j<=$modifier->max_value;$j++)
                                                                        <option value="{{ $j }}" @if($mod->input_value_cm == $j) selected @endif >+ {{ $j }} stitches</option>
                                                                    @endfor
                                                                @endif
                                                            </select>
                                                        @else

                                                            <select class="form-control fill select-factor" name="modifier_cm[]" id="modifier{{$modifier->pivot->modifier_uom}}">
                                                                <option value="">Select {{ $modifier->modifier_name }}</option>
                                                                @if($modifier->is_negative == 1)
                                                                    @foreach (range('-'.$modifier->max_value, $modifier->max_value) as $number) {
                                                                    @if($number > 0)
                                                                        <option value="{{ $number }}" >+ {{ $number }} stitches</option>
                                                                    @elseif($number == 0)
                                                                        <option value="{{ $number }}" >+ {{ $number }} stitches</option>
                                                                    @else
                                                                        <option value="{{ $number }}"  > {{ $number }} stitches</option>
                                                                    @endif
                                                                    @endforeach
                                                                @else
                                                                    @for($j=$modifier->min_value;$j<=$modifier->max_value;$j++)
                                                                        <option value="{{ $j }}" >+ {{ $j }} stitches</option>
                                                                    @endfor
                                                                @endif
                                                            </select>
                                                        @endif
                                                        <span class="modifier_cm{{$modifier->pivot->modifier_uom}} text-danger"></span>
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            @if($modifier->pivot->modifier_uom == 'in')
                                                <div class="col-lg-6 snippet-accordion factor_column">
                                                    <div class="row theme-row m-b-10">
                                                        <div class="card-header accordion p-1 col-lg-12 col-sm-12"  data-target="#child-accord1modifier_column1{{ $allsec->id }}{{$se}}{{$modifier->id}}{{$modifier->pivot->id}}">
                                                            <h5 class="card-header-text">{{ $modifier->modifier_name }} ({{ ($modifier->pivot->modifier_uom == 'in') ? 'Inches' : 'Cm' }}):</h5><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
                                                    </div>
                                                    <div class="card-block collapse" id="child-accord1modifier_column1{{ $allsec->id }}{{$se}}{{$modifier->id}}{{$modifier->pivot->id}}">
                                                        <input type="hidden" name="modifier_uom[]" value="{{$modifier->pivot->modifier_uom}}">
                                                        @if($mod)
                                                            <select class="form-control fill select-factor" name="modifier_in[]" id="modifier{{$modifier->pivot->modifier_uom}}">
                                                                <option value="">Select {{ $modifier->modifier_name }}</option>
                                                                @if($modifier->is_negative == 1)
                                                                    @foreach (range('-'.$modifier->max_value, $modifier->max_value) as $number) {
                                                                    @if($number > 0)
                                                                        <option value="{{ $number }}" @if($mod->input_value_in == $number) selected @endif >+ {{ $number }} stitches</option>
                                                                    @elseif($number == 0)
                                                                        <option value="{{ $number }}" @if($mod->input_value_in == $number) selected @endif >+ {{ $number }} stitches</option>
                                                                    @else
                                                                        <option value="{{ $number }}" @if($mod->input_value_in == $number) selected @endif > {{ $number }} stitches</option>
                                                                    @endif
                                                                    @endforeach
                                                                @else
                                                                    @for($j=$modifier->min_value;$j<=$modifier->max_value;$j++)
                                                                        <option value="{{ $j }}" @if($mod->input_value_in == $j) selected @endif >+ {{ $j }} stitches</option>
                                                                    @endfor
                                                                @endif
                                                            </select>
                                                        @else
                                                            <select class="form-control fill select-factor" name="modifier_in[]" id="modifier{{$modifier->pivot->modifier_uom}}">
                                                                <option value="">Select {{ $modifier->modifier_name }}</option>
                                                                @if($modifier->is_negative == 1)
                                                                    @foreach (range('-'.$modifier->max_value, $modifier->max_value) as $number) {
                                                                    @if($number > 0)
                                                                        <option value="{{ $number }}" >+ {{ $number }} stitches</option>
                                                                    @elseif($number == 0)
                                                                        <option value="{{ $number }}"  >+ {{ $number }} stitches</option>
                                                                    @else
                                                                        <option value="{{ $number }}"  > {{ $number }} stitches</option>
                                                                    @endif
                                                                    @endforeach
                                                                @else
                                                                    @for($j=$modifier->min_value;$j<=$modifier->max_value;$j++)
                                                                        <option value="{{ $j }}" >+ {{ $j }} stitches</option>
                                                                    @endfor
                                                                @endif
                                                            </select>
                                                        @endif
                                                        <input type="hidden" name="modifier_cm[]" id="modifiercm" value="{{ $mod ? $mod->input_value_cm : 0 }}">
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

                                        @if($function->ifConditions()->count() > 0)
                                            <h5 class="m-t-10 text-danger">Conditional Statements:-</h5> <br>
                                            @foreach($function->ifConditions as $ifcond)
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="card-header m-b-5 snippet{{$se}} mt-10" role="tab" id="headingOne12{{$ifcond->id}}" style="background-color: #dedddd;width:100%;">
                                                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne12{{$ifcond->id}}" aria-expanded="true" aria-controls="collapseOne1">
                                                                <h5 class="mb-0">Conditional Variable : {{ $ifcond->condition_variable }}</h5>
                                                                <i class="fa fa-caret-down pull-right micro-icons"></i>
                                                            </a>
                                                        </div>

                                                        <div id="collapseOne12{{$ifcond->id}}" class="collapse snippets mb-10 col-md-12 row" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                                                            @if($ifcond->conditionalVariables()->count() > 0)
                                                                @foreach($ifcond->conditionalVariables as $condvars)
                                                                    <input type="hidden" name="if_condition_id[]" value="{{ $ifcond->id }}">
                                                                    <input type="hidden" name="condition_variable_id[]" value="{{ $condvars->id }}">
                                                                    <h5 class="m-t-10 m-b-10 text-danger">{{ $condvars->condition_text }}</h5>
                                                                    @if($snip->conditionalVariableOutput()->count() > 0)
                                                                        @foreach($snip->conditionalVariableOutput as $outvars)
                                                                            @if($outvars->condition_variable_id == $condvars->id)
                                                                                <input type="hidden" name="conditional_variables_outputs_id[]" value="{{ $outvars->id }}">
                                                                                <textarea id="editor{{$condvars->id}}0{{$se}}{{$outvars->id}}" name="condition_description[]" class="form-control">{!! $outvars->condition_description !!}</textarea>
                                                                                @component('adminnew.Pattern-Templates.summernote', ['condId' => $condvars->id,'k' => 0,'dataCount' => $se,'l' => $outvars->id,'outputVariables' => $function->outputVariables,'measurements' => $measurements]) @endcomponent
                                                                            @endif
                                                                        @endforeach
                                                                    @endif




                                                                @endforeach
                                                                <br>
                                                            @endif
                                                        </div>

                                                    </div>
                                                </div>

                                            @endforeach
                                        @endif

                                    <!-- conditional variables here -->

                                        @if($snip->snippetConditionalStatements()->count() > 0)
                                            <div class="row m-t-20" id="cond-row">
                                                <div class="col-lg-12">
                                                    <?php $k=1; ?>
                                                    @foreach($snip->snippetConditionalStatements as $snipCond)
                                                        @php
                                                            $checkbox = DB::table('p_snippets_same_conditions')->where('snippets_id',$snip->id)->where('conditional_statements_id',$snipCond->id)->first();
                                                        @endphp
                                                        <input type="hidden"  class="cond_stmt_id{{$sec}}" name="cond_stmt_id[]" data-k="{{$k}}" value="{{ $snipCond->id }}">

                                                        <div class="card-header m-b-5 snippet{{$sec}}" role="tab" id="headingOne1{{$allsec->id}}{{$snipCond->id}}{{$sec}}" style="background-color: #dedddd;" >
                                                            <a data-toggle="collapse" data-parent="#accordionEx" href="#collapseOne1{{$snipCond->id}}{{$k}}{{$sec}}" aria-expanded="true" aria-controls="collapseOne1">
                                                                <h5 class="mb-0">
                                                                    {!! $snipCond->description !!} :- {!! $snipCond->statement_description !!}
                                                                </h5>
                                                                <i class="fa fa-caret-down pull-right micro-icons"></i>
                                                            </a>

                                                            <div class="row" style="position: absolute;right: 50px;z-index: 10;top: 10px;@if($k == 1) display:none; @endif" >
                                                                <div class="col-md-12">
                                                                    <div class="checkbox">

                                                                        <input type="checkbox" class="sameAsCondition sameCond1{{$sec}}" id="sameCond1{{$snipCond->id}}{{$k}}{{$sec}}"  value="{{$snipCond->id}}" data-tabid="{{$allsec->id}}{{$snipCond->id}}{{$sec}}" data-divId="{{$snipCond->id}}{{$k}}{{$sec}}" data-condid="{{$snipCond->id}}" data-sid="{{$sec}}" data-k="{{$k}}" @if($checkbox->sameAsCondition == 1) checked @endif value="{{$checkbox->id}}">Same like Condition 1
                                                                        <input type="hidden" name="sameAsCondition[]" value="@if($checkbox->sameAsCondition == 1) 1 @else 0 @endif" >
                                                                        <input type="hidden" name="checkbox_id[]" value="{{$checkbox->id}}" >

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div id="collapseOne1{{$snipCond->id}}{{$k}}{{$sec}}" class="collapse snippets{{$sec}}{{$snipCond->id}}" role="tabpanel" aria-labelledby="headingOne1" data-parent="#accordionEx">
                                                            <ul class="list-unstyled m-b-10" style="margin-left: 10px;" id="cond_instruction">
                                                            @php
                                                                $inst = $snipCond->base_instructions;
                                                                $array = array('[[PART-1]]','[[PART-2]]','[[PART-3]]','[[PART-4]]','[[PART-5]]','[[PART-6]]','[[PART-7]]','[[PART-8]]','[[PART-9]]','[[PART-10]]','[[PART-11]]','[[PART-12]]','[[PART-13]]','[[PART-14]]');

                                                                $array1 = array('<span class="text-danger">[[PART-1]]</span>','<span class="text-danger">[[PART-2]]</span>','<span class="text-danger">[[PART-3]]</span>','<span class="text-danger">[[PART-4]]</span>','<span class="text-danger">[[PART-5]]</span>','<span class="text-danger">[[PART-6]]</span>','<span class="text-danger">[[PART-7]]</span>','<span class="text-danger">[[PART-8]]</span>','<span class="text-danger">[[PART-9]]</span>','<span class="text-danger">[[PART-10]]</span>','<span class="text-danger">[[PART-11]]</span>','<span class="text-danger">[[PART-12]]</span>','<span class="text-danger">[[PART-13]]</span>','<span class="text-danger">[[PART-14]]</span>');
                                                                $res = str_replace($array,$array1,$inst);
                                                            @endphp
                                                            <!-- <li class="desc"><b>Instruction :- </b>{!! $res !!}</li> -->
                                                            </ul>
                                                            @for($l=1;$l<=$snipCond->instructions_count;$l++)
                                                                <input type="hidden" name="conditional_statements_id[]" value="{{ $snipCond->id }}">
                                                            @endfor

                                                            @php
                                                                $sinstructions = DB::table('p_snippet_instructions')->where('snippets_id',$snip->id)->where('conditional_statements_id',$snipCond->id)->get();
                                                            @endphp
                                                            <?php $n=1; ?>
                                                            @foreach($sinstructions as $inst)
                                                                @php $instructions = App\Models\Patterns\Instructions::where('id',$inst->instructions_id)->first(); @endphp
                                                                <input type="hidden" name="instructions_id[]" value="{{ $instructions->id }}">
                                                            <!-- <h5 class="m-t-10 text-danger">PART-{{ $n }}</h5> -->
                                                                <h5 class="m-t-10 text-danger">Instruction</h5>
                                                                <textarea class="hint2mention summernote m-b-10" id="editor{{$snipCond->id}}{{$k}}{{$sec}}{{$n}}" name="description[]" data-condid="{{$snipCond->id}}" data-cid="{{$allsec->id}}{{$snipCond->id}}" data-sid="{{$sec}}" data-k="{{$k}}" data-l="{{$n}}">{!! $instructions->description !!}</textarea>
                                                                <span class="summernote-required text-danger"></span>
                                                                @component('adminnew.Pattern-Templates.summernote', ['condId' => $snipCond->id,'k' => $k,'dataCount' => $sec,'l' => $n,'outputVariables' => $function->outputVariables,'measurements' => $measurements]) @endcomponent
                                                                <?php $n++; ?>
                                                            @endforeach
                                                            <br>
                                                        </div>
                                                        <?php $k++; ?>
                                                    @endforeach



                                                </div>
                                            </div>
                                        @endif



                                        <!-- formulas end here -->
                                    </div>


                            @endif <!-- function id != 0 condition -->

                            </div>

                        </form>

                    </div>
                    <?php $se++; ?>
                @endforeach

            @endif
            <div class="row">
                <div class="col-md-12" id="addSnippet{{$allsec->id}}"></div>
            </div>

        </div>

        </div>
        @php $sec++; @endphp
    @endforeach

@endif
