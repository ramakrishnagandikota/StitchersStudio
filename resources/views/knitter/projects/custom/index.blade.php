@extends('layouts.knitterapp')
@section('title','Knitter Project Library')
@section('content')

    <div class="pcoded-wrapper">

        <div class="pcoded-content">

            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- Page-body start -->
                        <div class="page-body">
                            <div class="row">
                                <div class="col-xl-12">
                                   <!-- <label class="theme-heading f-w-600 m-b-20">Create Project
                                    </label>
                                    <span class="mytooltip tooltip-effect-2" >
                            <span class="tooltip-item">?</span>
                            <span class="tooltip-content clearfix" id="Customtooltip">
                            <span class="tooltip-text" style="width: 100%;">Select the type of pattern you will use for this project.</span>
                        </span>
                        </span> -->
                                    <!-- To Do Card List card start -->
                                    @php
                                        if(Auth::user()->hasSubscription('Free')){
                                            if($projects >= $projectLimit->subscription_limit){
                                          $form = 'none';
                                          $div = 'block';
                                          }else{
                                          $form = 'block';
                                          $div = 'none';
                                          }
                                        }else{
                                        $form = 'block';
                                          $div = 'none';
                                        }
                                    @endphp


                                    <div class="alert alert-danger text-center" style="display: {{$div}}">You are in Free subscription. Please upgrade to Basic to add more projects.</div>

                                </div>




                                <!-- project starts here -->

                                <div class="col-lg-6 m-b-5" style="display: {{$form}}">
                                    <ul class="nav nav-tabs md-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#pattern-generator"
                                               role="tab"><img class="fixed-logo" src="{{ asset
                                               ('resources/assets/files/assets/images/logoOld.png')}}"alt="KnitFit"><span id="tab-heading">Pattern Generator</span></a>
                                            <div class="slide"></div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#Mprofile" role="tab">Measurement Profiles</a>
                                            <div class="slide"></div>
                                        </li>
                                    </ul>
                                </div>
                                <form id="create-project">
                                    <input type="hidden" name="pattern_type" value="custom">

                                <div class="col-sm-12">
                                    <!-- Material tab card start -->
                                    <div class="card">
                                        <div class="card-block">
                                            <!-- Row start -->
                                            <div class="row">
                                                <div class="col-lg-12 col-xl-12">
                                                    <!-- Nav tabs -->
                                                    <!-- Tab panes -->
                                                    <div class="tab-content card-block">
                                                        <div class="tab-pane active" id="pattern-generator" role="tabpanel">
                                                            <div class="card-header">
                                                                <h5 style="font-weight: 700;">Getting started</h5>
                                                            </div>
                                                            <div class="sub-title m-t-15 m-l-10">
															FIll in the sections below to generate a <b class="f-w-800">custom pattern!</b> Be sure to purchase a <b class="f-w-800">KnitFit™ Custom Pattern</b> in <b class="f-w-800">StitchersStudio Shop</b> before you begin. You will also need to add a <b class="f-w-800">Measurement Profile</b> so it can inform the <b class="f-w-800">Pattern Generator</b> on how to size your pattern. <a target="_blank" href="{{env('WORDPRESS_APP_URL')}}/website/how-to-generate-a-custom-pattern/" style="color: #05665b;">Learn more</a></div>
                                                            <!-- Section for Custom Pattern starts here -->
                                                            <div class="card-block purchased-pattern">
                                                                <div class="row">
                                                                    <div class="col-lg-8 col-sm-12">
                                                                        <!--First Accordion Starts here-->
                                                                        <div class="row theme-row m-b-10">
                                                                            <div class="card-header accordion active col-lg-12 col-sm-12"
                                                                                 data-toggle="collapse" data-target="#section1">
                                                                                <h5 class="card-header-text">Select a custom pattern
                                                                                </h5>
                                                                                <i class="fa fa-caret-down pull-right micro-icons"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-block collapse" id="section1">
                                                                            <div class="form-group row m-b-zero">
                                                                                <div class="col-md-5">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Name
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="hidden"
                                                                                                       name="product_id" id="product_id" value="{{$product ? $product->id : ''}}">
                                                                                                @if($product_image)
                                                                                                    <input type="hidden" name="image" value="{{$product_image->image_medium}}">
                                                                                                @endif
                                                                                                <input type="hidden"
                                                                                                       name="project_name" value="{{$product ? $product->product_name : ''}}">

            <select id="projectid" class="form-control form-control-default" onchange="getProduct(this.value)">
                <option value="0" selected>--Select Pattern--</option>
                @if($product)
                @foreach($orders as $or)
                    <option value="{{$or->pid}}" @if($product->id == $or->pid) selected @endif >{{$or->product_name}}</option>
                @endforeach
                @else
                    @foreach($orders as $or)
                        <option value="{{$or->pid}}"  >{{$or->product_name}}</option>
                    @endforeach
                @endif
            </select>
                                                                                                <span class="project_name red hide">Project name is required.</span>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
																				@if($product)
                                                                                <div class="col-md-5">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Skill level
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="text"
                                                                                                       class="form-control" id="skill_level" name="" value="{{$product ? $product->skill_level : ''}}" disabled>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
																				@endif
                                                                            </div>
																			@if($product)
                                                                            <div class="form-group row">
                                                                                <div class="col-md-12 p-15">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Description
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <textarea readonly
                                                                                                          rows="3"
                                                                                                          cols="1"
                                                                                                          name="description" class="form-control" placeholder=""><?php echo strip_tags($product ? $product->product_description : ''); ?></textarea>
                                                                                                <span class="description red hide">Description is required.</span>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
																			@endif
                                                                        </div>

@if($product)
	
<!--Third Accordion Starts here-->
                                                                        <div class="row theme-row m-b-10">
                                                                            <div class="card-header accordion col-lg-12"
                                                                                 data-toggle="collapse" data-target="#section3">
                                                                                <h5 class="card-header-text">Knit a gauge swatch</h5>
                                                                                <i class="fa fa-caret-down pull-right micro-icons"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-block collapse" id="section3">
                                                                            <div class="form-radio m-b-10">
                                                                                <h6 class="text-muted m-b-10">Unit of measurement</h6>
                                                                                <form>
                                                                                    <div class="radio radio-inline m-r-10">
                                                                                        <label>
                                                                                            <input type="radio" id="inches-custom" name="uom" checked="checked" value="in">
                                                                                            <i class="helper"></i>Inches
                                                                                        </label>
                                                                                    </div>
                                                                                    <div class="radio radio-inline">
                                                                                        <label>
                                                                                            <input type="radio" id="cm-custom" name="uom" id="cm-custom" value="cm">
                                                                                            <i class="helper"></i>Centimeters
                                                                                        </label>
                                                                                    </div>

                                                                                </form>
                                                                                <br>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6 grey-box">
                                                                                    <label class="col-form-label f-w-600 black">Designer's gauge
                                                                                        <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                            <span class="tooltip-content clearfix">
<!-- <img src="../../files/assets/images/tooltip/Knitting-Needle-Sizes.jpg" alt=""> -->
<span class="tooltip-text f-w-200 f-14" style="width: 100%;">The designer's gauge is only provided for the reference of curious knitters. Only your own gauge matters for custom patterns!</span>
                            </span>
                            </span>
                                                                                    </label>
                                                                                    <div class="row form-group">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Stitch gauge
                                                                                                </label>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                        @php
                                                                                                            if($product->designer_recommended_uom == 'in'){
																												$sgau_cm = '';
																												$rgau_cm = '';
                                                                                                            $sgau_in = App\Models\GaugeConversion::where('id',$product->recommended_stitch_gauge_in)->first();
                                                                                                            $rgau_in = App\Models\GaugeConversion::where('id',$product->recommended_row_gauge_in)->first();
                                                                                                            }else{
																												$sgau_in = '';
																												$rgau_in = '';
                                                                                                            $sgau_cm = App\Models\GaugeConversion::where('id',$product->recommended_stitch_gauge_cm)->first();
                                                                                                            $rgau_cm = App\Models\GaugeConversion::where('id',$product->recommended_row_gauge_cm)->first();
                                                                                                            }
                                                                                                        @endphp
                                                                                                        <input type="text" id="sts-stitch-custom" class="form-control" placeholder="" disabled value="{{$sgau_in ? $sgau_in->stitch_gauge_inch : 0}} sts / inch">

                                                                                                        <input type="text" id="cm-stitch-custom" class="form-control" placeholder="" disabled value="{{$sgau_in ? $sgau_in->stitches_10_cm : 0}} sts / 10 cm">

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Row gauge
                                                                                                </label>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                        <input disabled type="text" id="sts-row-custom" class="form-control" placeholder="" value="{{$rgau_in ? $rgau_in->row_gauge_inch : 0}} sts / inch">

                                                                                                        <input disabled type="text" id="cm-row-custom" class="form-control" placeholder="" value="{{$rgau_in ? $rgau_in->rows_10_cm : 0}} sts / 10 cm">

                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-6">
                                                                                    <label class="col-form-label f-w-600 black">Your gauge
                                                                                        <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                            <span class="tooltip-content clearfix">
<span class="tooltip-text f-w-200 f-14" style="width: 100%;">Use the dropdown to select the number of stitches per 4 inches or 10 cm. This is the minimum swatch size to get a good idea of your gauge and a well-fitting project!</span>
                            </span>
                            </span>
                                                                                    </label>
                                                                                    <div class="row form-group">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Stitch gauge<span class="red">*</span>
                                                                                                    <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                        <span class="tooltip-content clearfix">
<span class="tooltip-text" style="width: 100%;">Add the number of stitches counted horizontally across 1"/10 cm of your swatch.</span>
                                        </span>
                                        </span>

                                                                                                </label>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                        <select class="form-control" id="sts-stitch-custom" name="stitch_gauge_in" >
                                                                                                            <option selected value="0">Select value (inches)</option>
                                                                                                            @foreach($gaugeconversion as $gc2)
                                                                                                                <option value="{{$gc2->id}}">{{$gc2->stitch_gauge_inch .' / 1 inches'}}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                        <span class="red hide sts-stitch-custom">Please fill this field.</span>
                                                                                                        <select class="form-control" id="cm-stitch-custom" name="stitch_gauge_cm">
                                                                                                            <option selected value="0" >Select value (cm)</option>
                                                                                                            @foreach($gaugeconversion as $gc3)
                                                                                                                <option value="{{$gc3->id}}">{{$gc3->stitches_10_cm .' / 10cm'}}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                        <span class="hide red cm-stitch-custom">Please fill this field.</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label class="col-form-label">Row gauge<span class="red">*</span>
                                                                                                    <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                        <span class="tooltip-content clearfix">
<span class="tooltip-text" style="width: 100%;">Add the number of stitches counted vertically across 1"/10 cm of your swatch.</span>
                                        </span>
                                        </span>
                                                                                                </label>
                                                                                                <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                        <select class="form-control" name="row_gauge_in" id="sts-row-custom">
                                                                                                            <option value="0">Select value (inches)</option>
                                                                                                            @foreach($gaugeconversion as $gc2)
                                                                                                                <option value="{{$gc2->id}}">{{$gc2->row_gauge_inch .' / 1 inches'}}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                        <span class="red hide sts-row-custom">Please fill this field.</span>
                                                                                                        <select class="form-control" name="row_gauge_cm" id="cm-row-custom" name="" >
                                                                                                            <option selected value="0">Select value (cm)</option>
                                                                                                            @foreach($gaugeconversion as $gc3)
                                                                                                                <option value="{{$gc3->id}}">{{$gc3->rows_10_cm .' / 10cm'}}</option>
                                                                                                            @endforeach
                                                                                                        </select>
                                                                                                        <span class="hide red cm-row-custom">Please fill this field.</span>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <!--End of Third Accordion-->
																		
                                                                        <!--End of First Accordion-->
                                                                        <!--Fourth Accordion Starts here-->
                                                                        <div class="row theme-row m-b-10">
                                                                            <div class="card-header accordion col-lg-12"
                                                                                 data-toggle="collapse" data-target="#section4">
                                                                                <h5 class="card-header-text">Choose measurement profile and ease</h5>
                                                                                <i class="fa fa-caret-down pull-right micro-icons"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-block collapse" id="section4">

                                                                            <div class="row form-group">
                                                                                <div class="col-md-5">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">
                                                                                            Measurement profile<span class="red">*</span>
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <?php
                                                                                            $measurements1 = Auth::user()->measurements()->first();
                                                                                            ?>
                                                                                            <div class="col-md-12">
                                                                                                <select class="form-control" name="measurement_profile" id="sel1" onchange="getmeausrementUOM(this.value);">
                                                                                                    <option value="0">Select measurement profile</option>
                                                                                                    @if($measurements->count() > 0)
                                                                                                        @foreach($measurements as $ms)
                                                                                                            <option value="{{$ms->id}}" @if(Auth::user()->hasSubscription('Free')) @if($ms->id != $measurements1->id) disabled @endif @endif >For {{$ms->m_title}}</option>
                                                                                                        @endforeach
                                                                                                    @endif
                                                                                                </select>
                                                                                                <div class="red m_profile_error"></div>
                                                                                                <span class="red measurement_profile hide">Please select measurement profile</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row form-group">
                                                                                <div class="col-md-5">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Designer recommended ease
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="text" disabled id="sts-recom-ease" class="form-control" placeholder="" value="{{$product->designer_recommended_ease_in}}``">
                                                                                                <input type="text"class="form-control" id="cm-recom-ease" disabled value="{{$product->designer_recommended_ease_cm}}">

                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-5">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Your ease preference<span class="red">*</span>
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <select id="inches-ease-prefer-custom" name="ease_in" class="form-control">
                                                                                                    <option value="0" selected  >Select value (inches)</option>
                                                                                                    @for($j=-2;$j<= 20;$j+= 0.25)
                                                                                                        <option value="{{$j}}">{{$j}}"</option>
                                                                                                    @endfor
                                                                                                </select>
                                                                                                <span class="hide red inches-ease-prefer-custom">Please fill this field.</span>
                                                                                                <select id="sts-ease-prefer-custom" name="ease_cm" class="form-control">
                                                                                                    <option value="0" selected  >Select value (cm)</option>
                                                                                                    @for($i=-5;$i <= 20;$i+=0.5)
                                                                                                        <option value="{{$i}}">{{$i}} cm</option>
                                                                                                    @endfor

                                                                                                </select>
                                                                                                <span class="red hide sts-ease-prefer-custom">Please fill this field.</span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>


                                                                    <!--End of Fourth Accordion-->
                                                                        
                                                                        <!--Second Accordion Starts here-->
                                                                        <div class="row theme-row m-b-10">
                                                                            <div class="card-header accordion col-lg-12"
                                                                                 data-toggle="collapse" data-target="#section2">
                                                                                <h5 class="card-header-text">List yarn and tools</h5>
                                                                                <i class="fa fa-caret-down pull-right micro-icons"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-block collapse" id="section2">
                                                                            <div class="form-group row">
                                                                                <div class="col-md-12 grey-box p-15 m-b-custom">
                                                                                    <h5 class="m-b-10">Designer recommendations</h5>
                                                                                    <span class="m-b-10 f-12">Here's what the designer recommended for this pattern</span>

                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group grey-box row m-b-zero">
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Recommended yarn
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="text" class="form-control" id="recommended_yarn"  value="{{$product->recommended_yarn}}" disabled>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Recommended fiber type
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="text" class="form-control" id="recommended_fiber_type" value="{{$product->recommended_fiber_type}}" disabled>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Recommended yarn weight
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="text" class="form-control" id="recommended_yarn_weight" value="{{$product->recommended_yarn_weight}}" disabled>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group grey-box row m-b-zero">
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Recommended needle size
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                @php
                                                                                                    $Needle = App\Models\NeedleSizes::where('id',$product->recommended_needle_size)->first();
                                                                                                @endphp
                                                                                                @if($Needle)
                                                                                                    <input type="text" class="form-control" id="recommended_needle_size" value="US {{$Needle->us_size}} - {{$Needle->mm_size}} mm" disabled>
																								@else
                                                                                                    <input
                                                                                                        type="text"
                                                                                                        class="form-control" id="recommended_needle_size" value="--" disabled>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-8">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Additional tools needed
                                                                                            <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<span class="tooltip-text" style="width: 100%;">List any additional items you needed for this project (i.e. tapestry needle, stitch markers…)</span>
                                </span>
                                </span>
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <textarea disabled rows="1" cols="1" id="additional_tools" class="form-control" placeholder="">{{$product->additional_tools}}</textarea>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <div class="form-group row m-b-zero">
                                                                                <div class="col-md-12 p-15">
                                                                                    <div class="row">
                                                                                        <div class="col-lg-12">
                                                                                            <h5 class="m-b-10">Your choices</h5>
                                                                                            <span class="m-b-10 f-12">Note everything you used so you can make it again!</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-group row m-b-zero" id="yarn-row-custom">
                                                                                <div class="col-lg-8 row-bg">
                                                                                    <h6 class="m-t-5">Yarn</h6>
                                                                                </div>
                                                                                <div class="col-lg-4 row-bg text-right">
                                                                                    <button type="button" class="btn small-btn add-yarn f-12 theme-outline-btn btn-primary waves-effect waves-light" id="custom"><i class="icofont icofont-plus f-12"></i>Add yarn</button>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Yarn used
                                                                                            <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<!-- <img src="../../files/assets/images/tooltip/yarn.jpg" alt=""> -->
<span class="tooltip-text" style="width: 100%;">Enter the yarn you used for this pattern.</span>
                                </span>
                                </span>
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="text" class="form-control" id="yarn_used1" name="yarn_used[]" value="">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Fiber type used
                                                                                            <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<!-- <img src="../../files/assets/images/tooltip/fabric.jpg" alt=""> -->
<span class="tooltip-text" style="width: 100%;">Enter the fiber content of the yarns used.</span>
                                </span>
                                </span>
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="text" class="form-control" id="fiber_type1" name="fiber_type[]" value="">
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-4">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Yarn weight used
                                                                                            <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<!-- <img src="../../files/assets/images/tooltip/yarn-weigth.jpg" alt=""> -->
<span class="tooltip-text" style="width: 100%;">Select the yarn weight from the dropdown.</span>
                                </span>
                                </span>
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <select class="form-control" id="yarn_weight1" name="yarn_weight[]">
                                                                                                    <option value="Lace">Lace</option>
                                                                                                    <option value="Super Fine">Super Fine</option>
                                                                                                    <option value="Fine">Fine</option>
                                                                                                    <option value="Light">Light</option>
                                                                                                    <option value="Medium">Medium</option>
                                                                                                    <option value="Bulky">Bulky</option>
                                                                                                    <option value="Super Bulky">Super Bulky</option>
                                                                                                    <option value="Jumbo">Jumbo</option>
                                                                                                </select>
                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Colorway
                                                                                            <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<!-- <img src="../../files/assets/images/tooltip/yarn.jpg" alt=""> -->
<span class="tooltip-text" style="width: 100%;">Please enter colorway</span>
                                </span>
                                </span>
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="text" class="form-control" id="colourway1" name="colourway[]">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Dye lot
                                                                                            <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<!-- <img src="../../files/assets/images/tooltip/yarn.jpg" alt=""> -->
<span class="tooltip-text" style="width: 100%;">Please enter dye lot</span>
                                </span>
                                </span>
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="text" class="form-control" id="dye_lot1" name="dye_lot[]">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Skeins
                                                                                            <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<!-- <img src="../../files/assets/images/tooltip/yarn.jpg" alt=""> -->
<span class="tooltip-text" style="width: 100%;">Please enter skeins</span>
                                </span>
                                </span>
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <input type="text" class="form-control" id="skeins" name="skeins[]">

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                            </div>

                                                                            <div class="row form-group m-b-zero" id="needle-row-custom">
                                                                                <div class="col-lg-8 row-bg">
                                                                                    <h6 class="m-b-10">Needle size</h6>
                                                                                </div>
                                                                                <div class="col-lg-4 text-right row-bg">
                                                                                    <button type="button" class="btn small-btn add-needle f-12 theme-outline-btn btn-primary waves-effect waves-light" id="custom"><i class="icofont icofont-plus f-12"></i>Add Needle</button>
                                                                                </div>
                                                                                <div class="col-md-4">
                                                                                    <div class="form-group">
                                                                                        <label class="col-form-label">Needle size used
                                                                                            <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<!-- <img src="../../files/assets/images/tooltip/Knitting-Needle-Sizes.jpg" alt=""> -->
<span class="tooltip-text" style="width: 100%;">Select the needle size from the dropdown.</span>
                                </span>
                                </span>
                                                                                        </label>
                                                                                        <div class="row">
                                                                                            <div class="col-md-12">
                                                                                                <select class="form-control" id="needle_size" name="needle_size[]">
                                                                                                    <option selected>Select needle size</option>
                                                                                                    @foreach($needlesizes as $ns)
                                                                                                        <option value="{{$ns->id}}">US {{$ns->us_size}}  {{ $ns->mm_size ? '- '.$ns->mm_size.' mm' : '' }}</option>
                                                                                                    @endforeach
                                                                                                </select>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <!--End of Second Accordion-->
                                                                        <!--Fifth Accordion Starts here-->
                                                                        <div class="row theme-row m-b-10">
                                                                            <div class="card-header accordion col-lg-12"
                                                                                 data-toggle="collapse" data-target="#section5">
                                                                                <label class="col-form-label p-0 theme-heading f-w-600" style="font-size:15px">Add pattern-specific measurements
                                                                                    <span class="mytooltip tooltip-effect-2" style="display: inherit;margin-top: 0;">
                                    <span class="tooltip-item">?</span>
                                    <span class="tooltip-content clearfix">
                                    <span class="tooltip-text f-w-200 f-14" style="width: 100%;">Certain patterns ask for measurements that fall outside what you have recorded in your measurement profiles.</span>
                                    </span>
                                    </span>
                                                                                </label>
                                                                                <i class="fa fa-caret-down pull-right micro-icons"></i>
                                                                            </div>
                                                                        </div>
                                                                        <div class="card-block collapse" id="section5">
                                                                            <div id="hideBackground">
                                                                                <h3 class="text-center">Please wait...</h3>
                                                                            </div>
                                                                            <div class="row form-group" id="patternSpecific">

                                                                            </div>
                                                                        </div>
                                                                        <!--End of Fifth Accordion-->
    @endif
                                                                    </div>



                                                                    <div class="col-lg-4 col-sm-12">
                                                                        <div class="form-group row">
                                                                            <!-- <label class="col-sm-12 col-lg-12 col-form-label">Knitted For</label> -->
                                                                            <div class="col-sm-12 col-lg-12">
                                                                                <img src="../../files/assets/images/user-card/Off-the-Shoulder Ruffle Top.jpg"
                                                                                     alt="" style="width:100%; ">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6 col-sm-12">
                                                                </div>
                                                                <div class="form-group m-t-20">
                                                                    @if($product)
                                                                    <div class="col-sm-12">
                                                                        <div class="text-center m-b-10">
                                                                            <a href="{{url('knitter/project-library')}}" id="edit-cancel"
                                                                               class="btn theme-outline-btn btn-primary waves-effect waves-light m-r-10">Cancel</a>
                                                                            <!-- <a href="#!"
                                                                               class="btn theme-outline-btn btn-primary waves-effect waves-light">Save</a> -->
<a href="javascript:;" class="btn theme-btn btn-primary waves-effect waves-light m-l-10" style="color:#ffffff;" id="save">Generate
    Pattern</a>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <!--Section for Custom Patterns Ends here-->
                                                        </div>


                                                        <div class="tab-pane" id="Mprofile" role="tabpanel">
                                                            <div class="card-header" style="border-bottom:0px">
                                                                <h5 style="font-weight: 700;">Getting started with Measurement profiles</h5>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-9 col-sm-12 col-md-9 m-b-10">
                                                                    <div class="sub-title m-t-15 m-l-10" style="border-bottom:0px;">A measurement profile is a set of body measurements for one individual that will
                                                                        be referenced by the <b class="f-w-800">KnitFit™ Pattern Generator </b>to inform the sizing of a custom pattern.
                                                                        Get started by clicking the button to the right! Your saved <b class="f-w-800">Measurement Profiles </b>
                                                                        will appear below.
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-3 col-sm-3 col-md-3 text-center m-t -10">
                                                                    <a href="{{ url('knitter/measurements') }}"
                                                                       id="add-measurement-profile-btn"
                                                                       class="btn
                                                                    waves-effect pull-right waves-light btn-primary
                                                                    theme-outline-btn" ><i class="icofont
                                                                    icofont-plus"></i>Add measurement profile</a>
                                                                </div>
                                                            </div>
                                                            <section class="section-b-space ratio_asos">
                                                                <div class="collection-wrapper">
                                                                    <div class="container">
                                                                        <div class="row">
                                                                            <div class="collection-content col">
                                                                                <div class="page-main-content">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-12">
                                                                                            <div class="collection-product-wrapper">
                                                                                                <div class="product-wrapper-grid">
                                                                                                    <!--Updated code by Rupesh on 16 Apr 20202 (Removed justify-content-center class from below line and added one more column) No Total profiles are 6 -->
<?php $measurement = Auth::user()->measurements()->first(); ?>
<div class="row">
    @if($measurements->count() > 0)
        @foreach($measurements as $userms)
            @php
                if(!Auth::user()->isSubscriptionExpired()){
                    if($measurement->id != $userms->id){
                        $disabled1 = 1;
                    }else{
                        $disabled1 = 0;
                    }
                }else{
                    $disabled1 = 0;
                }

            if($userms->user_meas_image){
                $usermimage = $userms->user_meas_image;
            }else{
                $usermimage = 'https://via.placeholder.com/270X350/?text='.$userms->m_title;
            }
            @endphp
    <div class="col-xl-2 col-md-6 col-grid-box @if($disabled1 == 1) disabled @endif" id="id_{{base64_encode($userms->id)}}">
        <div class="product-box">
            <div class="img-wrapper">
                <div class="front">
                    <a href="#">
                        <img src="{{$usermimage}}" class="img-fluid blur-up lazyload bg-img" alt="">
                    </a>
                </div>
            </div>
            <div class="product-detail">
                <div>
                    @if($disabled1 == 0)
                    <a href="{{url('knitter/measurements/edit/'.base64_encode($userms->id))}}">
                        <h5 class="m-t-10 min-height-heading">{{ $userms->m_title ? ucwords($userms->m_title) : 'No Name' }}</h5>
                    </a>
                    @else
                        <a href="javascript:;">
                            <h5 class="m-t-10 min-height-heading">{{ $userms->m_title ? ucwords($userms->m_title) : 'No Name' }}</h5>
                        </a>
                    @endif
                    @if($disabled1 == 0)
                        <div class="editable-items">
                            <a href="{{url('knitter/measurements/edit/'.base64_encode($userms->id))}}" ><i class="fa fa-pencil"></i></a>
                            <!--<i class="fa fa-trash getId" data-type="measurements" data-id="{{base64_encode($userms->id)}}" data-toggle="modal" data-dismiss="modal" data-target="#child-Modal"></i>-->
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
            @endforeach
    @endif
</div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Row end -->
                                        </div>
                                    </div>
                                    <!-- Material tab card end -->
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!--Onload Modal -->
    <!-- Modal -->
    </div>

    @if($measurementsCount == 0)
        <div class="modal fade" id="OnLoadModal" role="dialog">
            <div class="modal-dialog modal-md">
                <div class="modal-content p-t-20 p-b-20">
                    <div class="modal-body text-center p-30">
                        <h3>It looks like you haven’t added any
                            measurement profiles yet.
                        </h3>
                        <h6 class="m-t-30 m-b-40 f-w-400">You must have a measurement profile to generate custom patterns.<br> Or, if you are creating an external or non-custom pattern, click continue.</h6>
                        <button type="submit" class="btn btn-success theme-btn" data-toggle="modal"><a class="custom-link" href="{{url('knitter/measurements')}}">Add measurement profile</a></button>
                        <button type="button" class="btn btn-danger theme-outline-btn" id="continueAnyway" data-dismiss="modal">&nbsp;&nbsp;Continue anyway&nbsp;&nbsp;</button>
                        <p class="m-t-20"><a href="{{url('knitter/project-library')}}"><i class="fa fa-mail-reply"></i> Back to Project library</a></p>
                    </div>

                </div>
            </div>
        </div>
    @endif

@endsection
@section('footerscript')
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/color17.css') }}
    " media="screen" id="color">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/left-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('resources/assets/files/bower_components/select2/css/select2.min.css') }}" />
    <!-- Multi Select css -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('resources/assets/files/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/bower_components/multiselect/css/multi-select.css') }}" />
    <!-- jquery file upload Frame work -->
    <link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />
	
    <style type="text/css">
        .hide{
            display: none;
        }
        .fixed-logo{width: 80px;margin-right: 10px;}
        .nav-tabs .slide{height: 2px;}
        .card .card-block{padding-top: 0px;}
        .product-box:hover .editable-items{
            opacity: 1 !important;
        }
		.select2-results__options li{
			width:100%;
		}
		.selectize-dropdown-content{
			background: #ffffff;
		}
		#pattern-generator .card-header{
            border-bottom: 0px !important;
        }
        #pattern-generator .sub-title{
            border-bottom: 0px !important;
        }
		.nav-tabs .slide{
			background: #0d665c !important;
		}
		.nav-link{font-size: 15px!important;}
        .md-tabs .nav-item a{padding: 5px 0px 10px 0px;}
        #tab-heading{vertical-align: middle;}
		.nav-tabs{
            border-bottom: 0px !important;
        }
    </style>
    <script type="text/javascript">
        var URL = '{{url('knitter/project-image')}}';
        var URL1 = '{{url('knitter/remove-project-image')}}';
    </script>
    <script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

    <!-- Select 2 js -->
    <script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/select2/js/select2.full.min.js') }}"></script>
	
    <!-- Custom js -->
    <script type="text/javascript" src="{{ asset('resources/assets/files/assets/pages/advance-elements/select2-custom.js') }}"></script>

    <script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/multi-select-dropdownlist.js') }}"></script>
    <!-- jquery file upload js -->
    <script src="{{ asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/filer/custom-filer.js') }}" type="text/javascript"></script>

    <!-- notification js -->
    <script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/bootstrap-growl.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/files/assets/pages/notification/notification.js') }}"></script>

    <script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/bootstrap-notify.min.js') }}"></script>
    <script type="text/javascript" src="{{asset('resources/assets/select2/select2-searchInputPlaceholder.js')}}"></script>

    <!-- lazyload js-->
    <script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/lazysizes.min.js') }}"></script>
	
	<link rel="stylesheet" type="text/css" href="{{asset('resources/assets/selectize/selectize.css')}}">
<script type="text/javascript" src="{{asset('resources/assets/selectize/selectize.min.js')}}"></script>

    <script type="text/javascript">
        $(function(){
			
			$(document).on('keypress','.flexdatalist',function(evt){
				var ASCIICode = (evt.which) ? evt.which : evt.keyCode 
				if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) 
					return false; 
				return true; 
			});

            $('#sel1').select2({
                placeholder: 'Select measurement profile',
                searchInputPlaceholder: 'Search from list'
            });
            $('#projectid').select2({
                placeholder: 'Select product name',
            });
            $("#cm-stitch-custom,#cm-row-custom,#sts-ease-prefer-custom,#cm-recom-ease,#cm-stitch-custom-user,#cm-row-custom-user").hide();
            getPatternSpecificvalues();
            $('#OnLoadModal').modal({backdrop: 'static', keyboard: false});

            $(document).on('click','#purchased-pattern:radio',function(){
                $("#p_type1").val('custom');
                //alert($(this).val());
            });

            $(document).on('click','#non-custom-pattern:radio',function(){
                $("#p_type2").val('non-custom');
            });


            $(document).on('click','#external-pattern',function(){
                var data = $(this).val();
                $(".loading").show();
                //if(data == 'external'){
                $.get('{{url("knitter/project/external")}}',function(res){
                    $("#loadPatterns").html(res);
                    $(".loading").hide();
                    $("#cm-stitch-non-custom,#cm-row-non-custom,#stitch-cm-external,#row-cm-external,#sts-ease-prefer-ext").hide();
                    $("#external-pattern").prop('checked',true);
                });
                //}
            });

            /* $(document).on('change','#projectid',function(){
                var id = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url : '{{url("knitter/create-project-custom")}}',
                    type : 'POST',
                    data : 'id='+id,
                    beforeSend : function(){
                        $('.loading').show();
                    },
                    success : function(res){
                        if(res){
                            $("#loadPatterns").html(res);
                            $("#cm-stitch-custom,#cm-row-custom,#sts-ease-prefer-custom,#cm-recom-ease,#cm-stitch-custom-user,#cm-row-custom-user").hide();
                            $('#myModal').modal('hide');
                        }else{
                            alert('Error occured.Please logout & login again.');
                        }
                    },
                    complete : function(){
                        $('.loading').hide();
                    }
                });
            }) */

            $(document).on('click','#saveCustom',function(){
                var p_type = $("#p_type1").val();
                var id = $("#pattern-list").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{url("knitter/create-project-custom")}}',
                    type : 'POST',
                    data : 'id='+id,
                    beforeSend : function(){
                        $('.loading').show();
                    },
                    success : function(res){
                        if(res){
                            $("#loadPatterns").html(res);
                            $("#cm-stitch-custom,#cm-row-custom,#sts-ease-prefer-custom,#cm-recom-ease,#cm-stitch-custom-user,#cm-row-custom-user").hide();
                            $('#myModal').modal('hide');
                            $(".modal-backdrop").hide();
                            $('#sel1').select2({
                                placeholder: 'Select measurement profile',
                                searchInputPlaceholder: 'Search from list'
                            });
                            getPatternSpecificvalues();
                        }else{
                            alert('Error occured.Please logout & login again.');
                        }
                    },
                    complete : function(){
                        $('.loading').hide();
                    }
                });

            });

            $(document).on('click','#saveNonCustom',function(){
                var p_type = $("#p_type2").val();
                var id = $("#pattern-list-non-custom").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{url("knitter/create-project-noncustom")}}',
                    type : 'POST',
                    data : 'id='+id,
                    beforeSend : function(){
                        $('.loading').show();
                    },
                    success : function(res){
                        if(res){
                            $("#customPattern").hide();
                            $("#externalPattern").hide();
                            $('#nonCustomModal').modal('hide');
                            $(".modal-backdrop").hide();
                            $("#loadPatterns").html(res);
                            $("#cm-stitch-non-custom,#cm-row-non-custom,#sts-ease-prefer-non-custom").hide();
                        }else{
                            alert('Error occured.Please logout & login again.');
                        }
                    },
                    complete : function(){
                        $('.loading').hide();
                    }
                });
            });

            $(document).on('click',"#inches-external:radio",function() {
                $("#stitch-sts-external,#row-sts-external,#inches-ease-prefer-ext").show();
                $('#stitch-cm-external,#row-cm-external,#sts-ease-prefer-ext').hide();
            });

//$('#cm-custom,#cm-stitch-custom,#cm-row-custom,#cm-non-custom,#cm-stitch-non-custom,#cm-row-non-custom,#cm-stitch-custom-user,#cm-row-custom-user,#sts-ease-prefer-custom,#cm-recom-ease,#sts-ease-prefer-non-custom,#sts-ease-prefer-ext').hide();

            $(document).on('click',"#inches-custom:radio",function() {
                $('#sts-stitch-custom,#sts-stitch-custom-user,#sts-row-custom-user,#sts-row-custom,#inches-ease-prefer-custom,#sts-recom-ease').show();
                $('#cm-stitch-custom,#cm-stitch-custom-user,#cm-row-custom-user,#cm-row-custom,#sts-ease-prefer-custom,#cm-recom-ease').hide();
                $(".cm-stitch-custom,.cm-row-custom").addClass('hide');
                $(".sts-ease-prefer-custom").addClass('hide');
            });

            $(document).on('click',"#cm-custom:radio",function() {
                $('#cm-stitch-custom,#cm-stitch-custom-user,#cm-row-custom-user,#cm-row-custom,#sts-ease-prefer-custom,#cm-recom-ease').show();
                $('#sts-stitch-custom,#sts-stitch-custom-user,#sts-row-custom-user,#sts-row-custom,#inches-ease-prefer-custom,#sts-recom-ease').hide();
                $(".sts-stitch-custom,.sts-row-custom").addClass('hide');
                $(".inches-ease-prefer-custom").addClass('hide');
            });



            $(document).on('click',"#inches-non-custom:radio",function() {
                $('#sts-stitch-non-custom,#sts-row-non-custom,#inches-ease-prefer-non-custom').show();
                $("#cm-stitch-non-custom,#cm-row-non-custom,#sts-ease-prefer-non-custom").hide();
            });

            $(document).on('click',"#cm-non-custom:radio",function() {
                $("#cm-stitch-non-custom,#cm-row-non-custom,#sts-ease-prefer-non-custom").show();
                $('#sts-stitch-non-custom,#sts-row-non-custom,#inches-ease-prefer-non-custom').hide();
            });

            $(document).on('click',"#cm-external:radio",function() {
                $("#stitch-cm-external,#row-cm-external,#sts-ease-prefer-ext").show();
                $('#stitch-sts-external,#row-sts-external,#inches-ease-prefer-ext').hide();
            });


            var i=2;
            $(document).on("click",".add-yarn",function(){
                var id = $(this).attr('id');
                $("#yarn-row-"+id).append('<div id="yarn_tools'+i+'" class="row" style="margin-right: 0px;"><div class="col-lg-12" ><hr></div><div class="col-md-4">\
<div class="form-group">\
<label class="col-form-label">Yarn used\
<span class="mytooltip tooltip-effect-2">\
<span class="tooltip-item">?</span>\
<span class="tooltip-content clearfix">\
<span class="tooltip-text" style="width: 100%;">Enter the yarn you used for this pattern.</span>\
</span>\
</span></label>\
<div class="row">\
<div class="col-md-12">\
<input type="text" class="form-control" id="yarn_used'+i+'" name="yarn_used[]" placeholder="Lion Brand Yarn 135-189 Hometown Yarn">\
</div>\
</div>\
</div>\
</div>\
<div class="col-md-4">\
<div class="form-group">\
<label class="col-form-label">Fiber type used\
<span class="mytooltip tooltip-effect-2">\
<span class="tooltip-item">?</span>\
<span class="tooltip-content clearfix">\
<span class="tooltip-text" style="width: 100%;">Enter the fiber content of the yarns used.</span>\
</span>\
</span>\
</label>\
<div class="row">\
<div class="col-md-12">\
<input type="text" class="form-control" id="fiber_type'+i+'" name="fiber_type[]" placeholder="Combed cotton woollen"></div>\
</div>\
</div>\
</div> \
<div class="col-lg-4">\
<div class="form-group">\
<label class="col-form-label">Yarn weight used\
<span class="mytooltip tooltip-effect-2">\
<span class="tooltip-item">?</span>\
<span class="tooltip-content clearfix">\
<span class="tooltip-text" style="width: 100%;">Select the yarn weight from the dropdown.</span>\
</span>\
</span>\
</label>\
<div class="row">\
<div class="col-md-12">\
<select class="form-control" id="yarn_weight'+i+'" name="yarn_weight[]" >\
<option value="Lace">Lace</option>\
<option value="Super Fine">Super Fine</option>\
<option value="Fine">Fine</option>\
<option value="Light">Light</option>\
<option value="Medium">Medium</option>\
<option value="Bulky">Bulky</option>\
<option value="Super Bulky">Super Bulky</option>\
<option value="Jumbo">Jumbo</option>\
</select>\
</div></div>\
</div><a href="javascript:;" class="deleteYarn" data-id="'+i+'"><i class="fa fa-trash delete-row"></i></a>\
</div>\
<div class="col-md-4">\
<div class="form-group">\
<label class="col-form-label">Colorway \
<span class="mytooltip tooltip-effect-2">\
<span class="tooltip-item">?</span>\
<span class="tooltip-content clearfix">\
<span class="tooltip-text" style="width: 100%;">Please enter colorway</span>\
</span>\
</span>  </label>\
<div class="row">\
<div class="col-md-12">\
<input type="text" class="form-control" id="colourway1" name="colourway[]"> \
</div>\
</div>\
</div>\
</div>\
<div class="col-md-4">\
<div class="form-group">\
<label class="col-form-label">Dye lot  \
<span class="mytooltip tooltip-effect-2">\
<span class="tooltip-item">?</span>\
<span class="tooltip-content clearfix">\
<span class="tooltip-text" style="width: 100%;">Please enter dye lot</span>\
</span>\
</span></label>\
<div class="row">\
<div class="col-md-12">\
<input type="text" class="form-control" id="dye_lot'+i+'" name="dye_lot[]"> \
</div>\
</div>\
</div>\
</div>\
<div class="col-md-4">\
<div class="form-group">\
<label class="col-form-label">Skeins  \
<span class="mytooltip tooltip-effect-2">\
<span class="tooltip-item">?</span>\
<span class="tooltip-content clearfix">\
<span class="tooltip-text" style="width: 100%;">Please enter skeins</span>\
</span>\
</span> </label>\
<div class="row">\
<div class="col-md-12">\
<input type="text" class="form-control" id="skeins'+i+'" name="skeins[]"> \
</div>\
</div>\
</div>\
</div></div>\
')
                i++;
            });

//Action button to add NEEDLE field in the External PATTERN
            var j=2;
            $(document).on("click",".add-needle",function(){
                var id = $(this).attr('id');
                $("#needle-row-"+id).append(' <div class="col-md-4" id="needle'+j+'">\
<div class="form-group">\
<label class="col-form-label">Needle size used\
<span class="mytooltip tooltip-effect-2">\
<span class="tooltip-item">?</span>\
<span class="tooltip-content clearfix">\
  <span class="tooltip-text" style="width: 100%;">Select the needle size from the dropdown.</span>\
</span></span></label>\
<div class="row">\
<div class="col-md-12">\
    <select class="form-control" name="needle_size[]" id="needle_size'+i+'">\
        <option selected>Select needle size</option>\
        @foreach($needlesizes as $ns)\
            <option value="{{$ns->id}}">US {{$ns->us_size}}  {{ $ns->mm_size ? '- '.$ns->mm_size.' mm' : '' }}</option>\
        @endforeach\
    </select>\
</div>\
</div></div>\
<a href="javascript:;" class="deleteNeedle" data-id="'+j+'"><i class="fa fa-trash delete-row"></i></a>\
</div>')
            });
//=======================================================


// delete needle row

            $(document).on('click','.deleteYarn',function(){
                var id = $(this).attr('data-id');
                if(confirm('Are you sure want to delete this row ?')){
                    $("#yarn_tools"+id).remove();
                }
            });

            $(document).on('click','.deleteNeedle',function(){
                var id = $(this).attr('data-id');
                if(confirm('Are you sure want to delete this row ?')){
                    $("#needle"+id).remove();
                }
            });


            $(document).on('click','#checkme',function () {
//check if checkbox is checked
                if ($(this).is(':checked')) {
                    $('#save').removeAttr('disabled'); //enable input
                } else {
                    $('#save').attr('disabled', true); //disable input
                }
            });

            $(document).on('click','#save',function(e){
                e.preventDefault();
                var type = 'custom'; //$("input[name='pattern_type']"). val();
                if(type == 'custom'){
                    var URL1 = '{{url("knitter/create-custom-project")}}';
                }else if(type == 'non-custom'){
                    var URL1 = '{{url("knitter/create-noncustom-project")}}';
                }else{
                    var URL1 = '{{url("knitter/create-project-external")}}';
                }


                var project_name = $("#project_name").val();
                var description = $("#description").val();
                var images = $(".jFiler-item").length;
                var checkme = $("#checkme").prop('checked');
                var mprofile = $("#sel1").val();
                var er = [];
                var cnt = 0;


                if(type == 'external'){

                    if(project_name == ''){
                        $(".project_name").removeClass('hide');
                        er+=cnt+1;
                    }else{
                        $(".project_name").addClass('hide');
                    }

                    if(images == 0){
                        $(".image").removeClass('hide');
                        er+=cnt+1;
                    }else{
                        $(".image").addClass('hide');
                    }

                    if(description == ''){
                        $(".description").removeClass('hide');
                        er+=cnt+1;
                    }else{
                        $(".description").addClass('hide');
                    }

                    if(mprofile == ''){
                        $(".mprofile").removeClass('hide');
                        er+=cnt+1;
                    }else{
                        $(".mprofile").addClass('hide');
                    }

                    if(checkme == false){
                        $(".checkme").removeClass('hide');
                        er+=cnt+1;
                    }else{
                        $(".checkme").addClass('hide');
                    }

                }else if(type == 'custom'){
                    var measurement = $("#sel1").val();
                    var radio = $("input[name='uom']:checked").val();
                    var m_name = $("input.m_name");

                    for (var i = 0; i < m_name.length; i++) {
                        var mname = $(m_name[i]).val();
                        var inputName = $("#flex"+i).val();


                        if(inputName == ""){
                            $("."+mname).removeClass('hide');
                            er+=cnt+1;
                        }else{
                            $("."+mname).addClass('hide');
                        }
                    }
					
					$("input.flexdatalist-alias").each(function(){
                        var self = $(this);
                        var name = self.attr('name');
                        name = name.replace('flexdatalist-','');
                        //console.log(name);
                        var datalist = $("#"+name).find('option');
                        var array = [];
                        for (var i=0;i<datalist.length;i++){
                            array.push(datalist[i].value);
                        }

                        if(self.val() == ''){
                            $("."+name).removeClass('hide');
                            er+=cnt+1;
                        }else{
                            if ($.inArray(self.val(), array) != -1)
                            {
                                //console.log(self.val(),'Yes');
                                $("."+name).addClass('hide');
                            }else{
                                //console.log(self.val(),'No');
                                $("."+name).removeClass('hide');
                                er+=cnt+1;
                            }
                        }
                    });


                    if(measurement == 0){
                        $(".measurement_profile").removeClass('hide');
                        er+=cnt+1;
                    }else{
                        $(".measurement_profile").addClass('hide');
                    }

                    if(radio == 'in'){
                        var stitch_gauge = $("select#sts-stitch-custom").val();
                        var row_gauge = $("select#sts-row-custom").val();
                        var ease = $("#inches-ease-prefer-custom").val();

                        if(stitch_gauge == 0){
                            $(".sts-stitch-custom").removeClass('hide');
                            er+=cnt+1;
                        }else{
                            $(".sts-stitch-custom").addClass('hide');
                        }

                        if(row_gauge == 0){
                            $(".sts-row-custom").removeClass('hide');
                            er+=cnt+1;
                        }else{
                            $(".sts-row-custom").addClass('hide');
                        }

                        if(ease == 0){
                            $(".inches-ease-prefer-custom").removeClass('hide');
                            er+=cnt+1;
                        }else{
                            $(".inches-ease-prefer-custom").addClass('hide');
                        }

                    }else{
                        var stitch_gauge = $("select#cm-stitch-custom").val();
                        var row_gauge = $("select#cm-row-custom").val();
                        var ease = $("#sts-ease-prefer-custom").val();

                        if(stitch_gauge == 0){
                            $(".cm-stitch-custom").removeClass('hide');
                            er+=cnt+1;
                        }else{
                            $(".cm-stitch-custom").addClass('hide');
                        }

                        if(row_gauge == 0){
                            $(".cm-row-custom").removeClass('hide');
                            er+=cnt+1;
                        }else{
                            $(".cm-row-custom").addClass('hide');
                        }

                        if(ease == 0){
                            $(".sts-ease-prefer-custom").removeClass('hide');
                            er+=cnt+1;
                        }else{
                            $(".sts-ease-prefer-custom").addClass('hide');
                        }

                    }


                }else{
                    if(project_name == ''){
                        $(".project_name").removeClass('hide');
                        er+=cnt+1;
                    }else{
                        $(".project_name").addClass('hide');
                    }

                    if(description == ''){
                        $(".description").removeClass('hide');
                        er+=cnt+1;
                    }else{
                        $(".description").addClass('hide');
                    }
                }



                if(er != ""){
                    addProductCartOrWishlist('fa-times','error','Please fill all the required fields.','danger');
                    return false;
                }

                var Data = $("#create-project").serializeArray();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : URL1,
                    type : 'POST',
                    data : Data,
                    beforeSend : function(){
                        $(".loading").show();
                    },
                    success : function(res){
                        if(res.status == 'success'){
                            addProductCartOrWishlist('fa fa-check','success','Project created successfully','success');

                            if(type == 'custom'){
                                setTimeout(function(){ window.location.assign('{{url("knitter/generate-custom-pattern")}}/'+res.key+'/'+res.slug); },2000);
                            }else if(type == 'non-custom'){
                                setTimeout(function(){ window.location.assign('{{url("knitter/generate-noncustom-pattern")}}/'+res.key+'/'+res.slug); },2000);
                            }else{
                                setTimeout(function(){ window.location.assign('{{url("knitter/generate-pattern")}}/'+res.key+'/'+res.slug); },2000);
                            }

                        }else{
                            addProductCartOrWishlist('fa-times','error','Unable to create project, Try again after sometime.','danger');
                        }
                    },
                    complete : function(){
                        setTimeout(function(){ $(".loading").hide(); },1500);
                    }
                });
            });


            $(document).on('click','.custom-link',function(){
                localStorage.removeItem('project');
                var project = true;
                localStorage.setItem('project',project);
            });


            $(document).on('click',"input[name='uom']",function(){
                var radioValue = $("input[name='uom']:checked"). val();
                var product_id = $("#product_id").val();
                //alert(product_id + ' - '+ radioValue);
                if(radioValue){
                    $("#sel1").val(0);
                    $(".m_profile_error").html('');
                    getPatternSpecificvalues();
                }
            });


            $(document).on('click','#continueAnyway',function(){
                $("#customPattern").hide();
                $("#external-pattern").trigger('click');
            });
			
			$(document).on('keyup','.pattern_specific_measurements',function (evt){
                var self = $(this);
                self.val(self.val().replace(/[^0-9\.]/g, ''));
                var datalist = $("datalist#lower_edge_to_underarm").find('option');
                //console.log(datalist,datalist.length);
                var name = self.attr('name');
                name = name.replace('flexdatalist-','');

                var array = [];
                for (var i=0;i<datalist.length;i++){
                    array.push(datalist[i].value);
                }

                if ($.inArray(self.val(), array) != -1)
                {
                    //console.log(self.val(),'Yes');
                    $("."+name).addClass('hide');
                }else{
                    //console.log(self.val(),'No');.
                    $("."+name).removeClass('hide');
                }

                if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57))
                {
                    evt.preventDefault();
                }

            });
			
        });

        function getProduct(value){
            if(value){
				$(".loading").show();
                var value1 = btoa(value);
                var url = '{{url("/")}}'+'/knitter/projects/custom/'+value1+'/create';
                window.location.assign(url);
            }
        }

        function getPatternSpecificvalues(){
            var radioValue = $("input[name='uom']:checked"). val();
            var product_id = $("#product_id").val();
            $("#hideBackground").show();
            $.get("{{url('knitter/getPatternSpecificvalues')}}/"+product_id+'/'+radioValue,function(res){
                $("#patternSpecific").html(res);
                /*$('.js-data-example-ajax1').select2({
                    placeholder: 'Select an option',
                    searchInputPlaceholder: 'Search from list'
                });*/
				//$('.js-data-example-ajax1').selectize();
				//$('.flexdatalist').flexdatalist();
                $("#hideBackground").hide();
            });
        }

        function readprofileURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#profile-img-external-pattern')
                        .attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        /* getting measurement profile uom */
        function getmeausrementUOM(value){
            if(value == 0){
                return;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var Data = 'm_id='+value;
            var uom =  $("input[name='uom']:checked"). val();

            $.ajax({
                url : '{{url("knitter/checkMeasurementUOM")}}',
                type : 'POST',
                data : Data,
                beforeSend : function(){
                    $(".loading").show();
                },
                success : function(res){
                    if(res.status == 1){
                        $(".m_profile_error").html(res.error);
                        $("#sel1").val(0);
                    }else{
                        if(uom != res.uom){
                            $(".m_profile_error").html('The UOM of selected measurement profile is '+res.uom_full+'. Please select another one.');
                            $("#sel1").val(0);
                        }else{
                            $(".m_profile_error").html('');
                        }
                    }
                },
                complete : function(){
                    $(".loading").hide();
                }
            });
        }


        function addProductCartOrWishlist(icon,status,msg,type){
            $.notify({
                icon: 'fa '+icon,
                title: status+'!',
                message: msg
            },{
                element: 'body',
                position: null,
                type: type,
                allow_dismiss: true,
                newest_on_top: false,
                showProgressbar: true,
                placement: {
                    from: "top",
                    align: "right"
                },
                offset: 20,
                spacing: 10,
                z_index: 10000,
                delay: 3000,
                animate: {
                    enter: 'animated fadeInDown',
                    exit: 'animated fadeOutUp'
                },
                icon_type: 'class',
                template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                    '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
            });
        }
    </script>
@endsection
