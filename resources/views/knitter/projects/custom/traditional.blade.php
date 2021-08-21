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
                                    <label class="theme-heading f-w-600 m-b-20">Create Pattern
                                    </label>
                                    <span class="mytooltip tooltip-effect-2" >
                            <span class="tooltip-item">?</span>
                            <span class="tooltip-content clearfix" id="Customtooltip">
                            <span class="tooltip-text" style="width: 100%;">Select the type of pattern you will use for this project.</span>
                        </span>
                        </span>
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

                                    @if($form == 'block')
                                        <form id="create-project">
                                            <input type="hidden" name="pattern_type" value="non-custom">
                                            <div class="card">

                                                <!--Section for non-custom Patterns Starts here-->
                                                <div class="card-block non-custom-pattern">
                                                    <div class="row">
                                                        <div class="col-lg-8 col-sm-12">
                                                            <!--First Accordion Starts here-->
                                                            <div class="row theme-row m-b-10">
                                                                <div class="card-header accordion active col-lg-12 col-sm-12" data-toggle="collapse" data-target="#non-custom-design">
                                                                    <h5 class="card-header-text">Select a traditional pattern
                                                                    </h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                                                                </div>
                                                            </div>
                                                            <div class="card-block collapse show" id="non-custom-design">

                                                                <div class="form-group row m-b-zero">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Name
                                                                            </label>
                                                                            <div class="row">
                                                                                <div	 class="col-md-12">
                                                                                    <input type="hidden" name="product_id" id="product_id" value="{{$product->id}}">
                                                                                    @if($product_image)
                                                                                        <input type="hidden" name="image" value="{{$product_image->image_medium}}">
                                                                                    @endif
                                                                                    <input type="hidden" name="project_name" value="{{$product->product_name}}">
                                                                                    <select  id="projectid" class="form-control form-control-default">
                                                                                        <option value="0" selected>--Select Pattern--</option>
                                                                                        @foreach($orders as $or)
                                                                                            <option value="{{$or->pid}}" @if($product->id == $or->pid) selected @endif >{{$or->product_name}}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <span class="project_name red hide">Project name is required.</span>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Skill level
                                                                            </label>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <input type="text" class="form-control" id="skill_level" name="" value="{{$product->skill_level}}" disabled>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group row">
                                                                    <div class="col-lg-12 p-15">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Description
                                                                            </label>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <textarea readonly rows="3" cols="1" name="description" class="form-control" placeholder=""><?php echo strip_tags($product->product_description); ?></textarea>
                                                                                    <span class="description red hide">Description is required.</span>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--End of First Accordion-->

                                                            <!--Second Accordion Starts here-->
                                                            <div class="row theme-row m-b-10">
                                                                <div class="card-header accordion col-lg-12" data-toggle="collapse" data-target="#yarn-n-tools">
                                                                    <h5 class="card-header-text">List yarn and tools</h5>
                                                                    <i class="fa fa-caret-down pull-right micro-icons"></i>
                                                                </div>

                                                            </div>
                                                            <div class="card-block collapse" id="yarn-n-tools">

                                                                <div class="form-group row">
                                                                    <div class="col-md-12 grey-box p-15 m-b-custom">
                                                                        <h5 class="m-b-10">Designer recommendations</h5>
                                                                        <span class="m-b-10 f-12">Here's what the designer recommended for this pattern</span>

                                                                    </div>
                                                                </div>

                                                                @if($product->yarnRecommmendations()->count() > 0)
                                                                    @foreach($product->yarnRecommmendations as $yarn)
                                                                        <div class="form-group grey-box row m-b-zero">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="col-form-label">Yarn Company
                                                                                    </label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <input type="text" class="form-control" value="{{ $yarn->yarn_company }}" disabled>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="col-form-label">Yarn name
                                                                                    </label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <input type="text" class="form-control" value="{{ $yarn->yarn_name }}" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="col-form-label">Fiber type
                                                                                    </label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <input type="text" class="form-control" value="{{ $yarn->fiber_type }}" disabled>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="col-form-label">Yarn weight
                                                                                    </label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <input type="text" class="form-control" value="{{ $yarn->yarn_weight }}" disabled >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="col-form-label">Yarn url </label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                        @if($yarn->yarn_url)
                                                                                            <a href="{{ $yarn->yarn_url }}" target="_blank">{{ $yarn->yarn_url }}</a>
																						@else
																							<input type="text" class="form-control" value="{{ $yarn->yarn_url }}" disabled >
																						@endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="col-form-label">Coupon code
                                                                                    </label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <input type="text" class="form-control" value="{{ $yarn->coupon_code }}" disabled >
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                @else
                                                                    <div class="form-group row m-b-zero text-center">
                                                                        <p class="text-center col-md-12">There are no yarn recommondations for this pattern.</p>
                                                                    </div>
                                                                @endif



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
                                                                <div class="form-group row m-b-zero" id="yarn-row-noncustom">
                                                                    <div class="col-lg-8 row-bg">
                                                                        <h6 class="m-b-10">Yarn</h6>
                                                                    </div>
                                                                    <div class="col-lg-4 text-right row-bg">
                                                                        <button type="button" class="btn small-btn add-yarn f-12 theme-outline-btn btn-primary waves-effect waves-light" id="noncustom"><i class="icofont icofont-plus f-12"></i>Add yarn</button>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group m-b-zero">
                                                                            <label class="col-form-label">Yarn used
                                                                                <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<span class="tooltip-text" style="width:100%">Enter the yarn you used for this pattern.</span>
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
<span class="tooltip-text" style="width:100%">Enter the fiber content of the yarns used.</span>
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
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Yarn weight used
                                                                                <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<span class="tooltip-text" style="width:100%">Select the yarn weight from the dropdown.</span>
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

                                                                <div class="form-group row m-b-zero" id="needle-row-noncustom">
                                                                    <div class="col-lg-8 row-bg">
                                                                        <h6 class="m-b-10">Needle size</h6>
                                                                    </div>
                                                                    <div class="col-lg-4 text-right row-bg">
                                                                        <button type="button" class="btn small-btn add-needle f-12 theme-outline-btn btn-primary waves-effect waves-light" id="noncustom"><i class="icofont icofont-plus f-12"></i>Add Needle</button>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Select needle size
                                                                                <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
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

                                                            <!--Third Accordion Starts here-->
                                                            <div class="row theme-row m-b-10">
                                                                <div class="card-header accordion col-lg-12" data-toggle="collapse" data-target="#gauge">
                                                                    <h5 class="card-header-text">Knit a gauge swatch</h5>
                                                                    <i class="fa fa-caret-down pull-right micro-icons"></i>
                                                                </div>
                                                            </div>
                                                            <div class="card-block collapse" id="gauge">
                                                                <div class="form-radio">
                                                                    <h6 class="text-muted m-b-10">Unit of measurement</h6>

                                                                    <div class="radio radio-inline m-r-10">
                                                                        <label>
                                                                            <input type="radio" id="inches-non-custom" name="uom" checked="checked" value="in">
                                                                            <i class="helper"></i>Inches
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio radio-inline">
                                                                        <label>
                                                                            <input type="radio" name="uom" id="cm-non-custom" value="cm">
                                                                            <i class="helper"></i>Centimeters
                                                                        </label>
                                                                    </div>


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
                                                                                    <label class="col-form-label">Stitch gauge</label>
                                                                                    <div class="row">
<?php 
$sgcin = App\Models\GaugeConversion::where('id',$product->recommended_stitch_gauge_in)->first();
$sgccm = App\Models\GaugeConversion::where('id',$product->recommended_stitch_gauge_cm)->first();

$rgcin = App\Models\GaugeConversion::where('id',$product->recommended_row_gauge_in)->first();
$rgccm = App\Models\GaugeConversion::where('id',$product->recommended_row_gauge_cm)->first();
?>
                                                                                        <div class="col-md-12">
                                                                                            <input type="text" id="sts-stitch-non-custom" class="form-control" placeholder="" disabled value="{{$sgcin->stitch_gauge_inch}} sts / inch">

                                                                                            <input type="text" id="cm-stitch-non-custom" class="form-control" placeholder="" disabled value="{{$sgccm->stitches_10_cm}} sts / 10 cm">
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
                                                                                            <input disabled type="text" id="sts-row-non-custom" class="form-control" placeholder="" value="{{$rgcin->row_gauge_inch}} sts / inch">

                                                                                            <input disabled type="text" id="cm-row-non-custom" class="form-control" placeholder="" value="{{$rgccm->rows_10_cm}} sts / 10 cm">
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
                                                                                    <label class="col-form-label">Stitch gauge
                                                                                        <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                        <span class="tooltip-content clearfix">
<span class="tooltip-text" style="width: 100%;">Add the number of stitches counted horizontally across 1"/10 cm of your swatch.</span>
                                        </span>
                                        </span>

                                                                                    </label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <select class="form-control" id="sts-stitch-non-custom" name="stitch_gauge_in" >
                                                                                                <option selected>Select value (inches)</option>
                                                                                                @foreach($gaugeconversion as $gc1)
                                                                                                    <option value="{{$gc1->id}}">{{$gc1->stitch_gauge_inch .' / inch'}}</option>
                                                                                                @endforeach
                                                                                            </select>

                                                                                            <select class="form-control" id="cm-stitch-non-custom" name="stitch_gauge_cm">
                                                                                                <option selected>Select value (cm)</option>
                                                                                                @foreach($gaugeconversion as $gc2)
                                                                                                    <option value="{{$gc2->id}}">{{$gc2->stitches_10_cm .' / 10cm'}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="col-form-label">Row gauge
                                                                                        <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                        <span class="tooltip-content clearfix">
<span class="tooltip-text" style="width: 100%;">Add the number of stitches counted vertically across 1"/10 cm of your swatch.</span>
                                        </span>
                                        </span>
                                                                                    </label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <select class="form-control" name="row_gauge_in" id="sts-row-non-custom">
                                                                                                <option>Select value (inches)</option>
                                                                                                @foreach($gaugeconversion as $gc3)
                                                                                                    <option value="{{$gc3->id}}">{{$gc3->row_gauge_inch .' / inch'}}</option>
                                                                                                @endforeach
                                                                                            </select>

                                                                                            <select class="form-control" name="row_gauge_cm" id="cm-row-non-custom" name="" >
                                                                                                <option selected>Select value (cm)</option>
                                                                                                @foreach($gaugeconversion as $gc4)
                                                                                                    <option value="{{$gc4->id}}">{{$gc4->rows_10_cm .' / 10cm'}}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!--End of Third Accordion-->

                                                            <!--Fourth Accordion Starts here-->
                                                            <div class="row theme-row m-b-10">
                                                                <div class="card-header accordion col-lg-12" data-toggle="collapse" data-target="#section4-NC">
                                                                    <h5 class="card-header-text">Choose measurement profile and ease</h5>
                                                                    <i class="fa fa-caret-down pull-right micro-icons"></i>
                                                                </div>
                                                            </div>
                                                            <div class="card-block collapse" id="section4-NC">
                                                                <div class="row form-group">
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">
                                                                                Reference a measurement profile
                                                                                <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<span class="tooltip-text" style="width:100%">Add a measurement profile for reference--this will not affect the available sizes in an external or non-custom pattern.</span>
                                </span>
                                </span>
                                                                            </label>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <select class="form-control" name="measurement_profile" id="sel1">
                                                                                        <option value="0">Select measurement profile</option>
                                                                                        @if($measurements->count() > 0)
                                                                                            @foreach($measurements as $ms)
                                                                                                <option value="{{$ms->id}}">For {{$ms->m_title}}</option>
                                                                                            @endforeach
                                                                                        @endif
                                                                                    </select>
                                                                                    <span class="red measurement_profile hide">Please select measurement profile</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-5">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label">Your ease preference
                                                                                <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<span class="tooltip-text" style="width:100%">Enter the amount of ease for reference. It will not affect pattern instructions in external or non-custom patterns.</span>
                                </span>
                                </span>
                                                                            </label>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <select id="inches-ease-prefer-non-custom" name="ease_in" class="form-control">
                                                                                        <option value="0" selected disabled >Select value (inches)</option>
                                                                                        @for($j=-2;$j<= 20;$j+= 0.25)
                                                                                            <option value="{{$j}}">{{$j}}"</option>
                                                                                        @endfor
                                                                                    </select>

                                                                                    <select id="sts-ease-prefer-non-custom" name="ease_cm" class="form-control">
                                                                                        <option value="0" selected disabled >Select value (cm)</option>
                                                                                        @for($i=-5;$i <= 20;$i+=0.5)
                                                                                            <option value="{{$i}}">{{$i}} cm</option>
                                                                                        @endfor

                                                                                    </select>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <!--End of Fourth Accordion-->

                                                        </div>
                                                        <div class="col-lg-4 col-sm-12">
                                                            @php
                                                                $images = $product->images();
                                                            @endphp
                                                            <div class="form-group row">
                                                                <!-- <label class="col-sm-12 col-lg-12 col-form-label">Knitted For</label> -->
                                                                @if($images->count() > 0)
                                                                    <div class="col-sm-12 col-lg-12">
                                                                        <img src="{{ $images->first()->image_small }}" alt="" style="width:100%; ">
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-6 col-sm-12">

                                                    </div>

                                                    <div class="form-group m-t-20">
                                                        <div class="col-sm-12">
                                                            <div class="text-center m-b-10">
                                                                <a href="#!" id="edit-cancel" class="btn theme-outline-btn btn-primary waves-effect waves-light m-r-10">Cancel</a>
                                                                <!-- <a href="#!"
                                                class="btn theme-outline-btn btn-primary waves-effect waves-light">Save</a> -->
                                                                <button type="button"
                                                                        class="btn theme-btn btn-primary waves-effect waves-light m-l-10" id="save" >Create Project
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Section for non-custom Patterns Ends here-->


                                            </div>
                                        </form>
                                    @endif

                                    <div class="alert alert-danger text-center" style="display: {{$div}}">You are in Free subscription. Please upgrade to Basic to add more projects.</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
        .profile-upload{position: absolute;z-index: 999999; top: 4px;left: 18px;}
        #upload-file {
            display: block;
            font-size: 14px;
        }

        /* The container */
        .container {
            display: block;
            position: relative;
            padding-left: 26px;
            margin-bottom: 10px;
            cursor: pointer;
            font-size: 14px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .container input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 16px;
            width: 16px;
            border: 1.6px solid #0d665c;
            border-radius: 2px;
        }

        /* On mouse-over, add a grey background color */
        .container:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .container input:checked ~ .checkmark {
            background-color: #0d665c;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .container input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .container .checkmark:after {
            left: 3px;
            top: 0px;
            width: 6px;
            height: 11px;
            border: solid white;
            border-width: 0 2px 2px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
        .progress{
            max-width: 100% !important;
        }
        .progress-bar-success{
            background-color: #0d665b !important;
        }
        .progress-bar-danger{
            background-color: #bc7c8f !important;
        }
        .progress-bar-info{
            background-color: #0d665b !important;
        }
        #hideBackground{
            position: absolute;
            margin: auto;
            width: 100%;
            height: 200px;
            background: #ffffffc4;
            z-index: 1000;
            display: none;
        }
        #hideBackground h3{
            margin-top: 50px;
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

    <script type="text/javascript">
        $(function(){
            $('#sel1').select2({
                placeholder: 'Select measurement profile',
                searchInputPlaceholder: 'Search from list'
            });
            $('#projectid').select2({
                placeholder: 'Select product name',
            });
            $("#cm-stitch-non-custom,#cm-row-non-custom,#sts-ease-prefer-non-custom").hide();

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

            $(document).on('change','#projectid',function(){
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
            })

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
                var type = 'non-custom';
				//$("input[name='pattern_type']:checked"). val();
                /*if(type == 'custom'){
                    var URL1 = '{{url("knitter/create-custom-project")}}';
                }else if(type == 'non-custom'){
                    var URL1 = '{{url("knitter/create-noncustom-project")}}';
                }else{
                    var URL1 = '{{url("knitter/create-project-external")}}';
                }*/
				var URL1 = '{{url("knitter/create-noncustom-project")}}';

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
                        var inputName = $("#"+mname).val();


                        if(inputName == ""){
                            $("."+mname).removeClass('hide');
                            er+=cnt+1;
                        }else{
                            $("."+mname).addClass('hide');
                        }
                    }


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
        });

        function getPatternSpecificvalues(){
            var radioValue = $("input[name='uom']:checked"). val();
            var product_id = $("#product_id").val();
            $("#hideBackground").show();
            $.get("{{url('knitter/getPatternSpecificvalues')}}/"+product_id+'/'+radioValue,function(res){
                $("#patternSpecific").html(res);
                $('.js-data-example-ajax').select2({
                    placeholder: 'Select an option',
                    searchInputPlaceholder: 'Search from list'
                });
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
