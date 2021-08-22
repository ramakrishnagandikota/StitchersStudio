@extends('layouts.designerapp')
@section('title','Create Pattern')
@section('content')
<div class="pcoded-main-container">
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-body">
                            <div class="row">
                                <!-- col-md-12 -->
                                <div class="col-xl-12">
                                    <label class="theme-heading f-w-600 m-b-20">Create Pattern</label>
                                    <span class="mytooltip tooltip-effect-2" >
                                        <span class="tooltip-item">?</span>
                                        <span class="tooltip-content clearfix" id="Customtooltip">
                                        <span class="tooltip-text" style="width: 100%;">Select the type of pattern you will use for this project.</span>
                                    </span>
                                    </span>
                                    <!-- card starts here -->
                                    <div class="text-right red" style="font-size: 12px;">Note : Please fill the fields with * sign.</div>
                                    <div class="card">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <!-- ul tabs -->

                                                <ul class="nav nav-tabs md-tabs" role="tablist">
                                                    <li class="nav-item nav-tab1">
                                                        <a class="nav-link active show" data-toggle="tab" href="#P-details" role="tab" aria-selected="false">
                                                            <button class="btn theme-btn btn-icon-tab waves-effect waves-light">
                                                                <span id="tab-no1">1</span>
                                                            </button>Pattern details <i class="fa"></i></a>
                                                        <div class="slide"></div>
                                                    </li>
                                                    <li class="nav-item nav-tab3">
                                                        <a class="nav-link" data-toggle="tab" href="#pi" role="tab" aria-selected="false"><button class="btn theme-btn btn-icon-tab waves-effect waves-light">
                                                                <span id="tab-no3">2</span>
                                                            </button>Pattern instructions <i class="fa"></i></a>
                                                        <div class="slide"></div>
                                                    </li>
                                                </ul>
                                                <!-- ul tabs -->
<form class="form-horizontal" id="create-pattern" action="{{ route('save.pattern') }}"  method="post">
    @csrf
                                                <!-- Section for Pattern details starts here -->
                                                <div class="tab-content card-block">
                                                    <div class="tab-pane active show" id="P-details" role="tabpanel">
                                                        <div class="card-block pattern-details">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-sm-12">
        <!--First Accordion Starts here-->
        <div class="row theme-row m-b-10">
            <div class="card-header accordion active col-lg-12 col-sm-12"
                 data-toggle="collapse" data-target="#section1">
                <h5 class="card-header-text">Enter pattern details
                </h5><i class="fa fa-caret-down pull-right micro-icons"></i>
            </div>
        </div>
        <div class="custom-card-block" id="section1">
            <div class="form-group row">
                <div class="col-md-4 m-b-20">
                    <label class="form-label">SKU<span class="red">*</span>
                    </label>
                    <input type="text" name="sku" id="sku" class="form-control" value="KFC<?php echo str_pad($pcount,4,"0",STR_PAD_LEFT); ?>" readonly >
                </div>

                <div class="col-md-4 m-b-20">
                    <label class="form-label">Pattern GoLive Date<span class="red">*</span>
                    </label>
                    <input type="text" name="pattern_go_live_date" readonly placeholder="Please select date" id="pattern_go_live_date" class="form-control" value="{{date('m/d/Y')}}" >
                </div>

                <div class="col-md-4 m-b-20">
                    <label class="form-label">Status<span class="red">*</span>
                    </label>
                    <select class="form-control" name="status" id="status" >
                        <option value="" disabled="">Please select status</option>
                        <option value="0">Inactive</option>
                        <option value="1" selected="">Active</option>
                    </select>
                </div>

            </div>
        </div>
        <!--End of First Accordion-->


        <!-- start of second accordion -->
        <div class="row theme-row m-b-10">
            <div class="card-header accordion col-lg-12"
                 data-toggle="collapse" data-target="#section3">
                <h5 class="card-header-text">Pattern information</h5>
                <i class="fa fa-caret-down pull-right micro-icons"></i>
            </div>
        </div>

        <div class="card-block collapse" id="section3">

                <div class="step">
                    <div class="form-group row">
                        <div class="col-md-4 m-b-20">
                            <label class="form-label">Pattern name<span class="red">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter pattern name" value="{{ old('name') }}">
                        </div>
                        <div class="col-md-4 m-b-20">
                            <label class="form-label">Designer name<span class="red">*</span>
                            </label>
                            <input type="text" class="form-control" id="designer_name" name="designer_name" placeholder="Enter designer name">
                        </div>
                        <div class="col-md-4 m-b-20">
                            <label class="form-label">Skill level<span class="red">*</span>
                            </label>
                            <select class="form-control form-control-default" id="skill_level" name="skill_level" >
                                <option value="">Please Select Skill level</option>
                                <option value="Beginner">Beginner</option>
								<option value="Easy">Easy</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Complex">Complex</option>
                            </select>
                        </div>
                        <div class="col-md-12 m-b-20">
                            <label class="form-label">Pattern description<span class="red">*</span>
                            </label>
                            <textarea id="pattern_description" name="pattern_description" class="form-control summernote" spellcheck="false"></textarea>
                        </div>

                        <div class="col-md-12 m-b-20">
                            <label class="form-label">Pattern details<span class="red">*</span>
                            </label>
                            <textarea  id="short_description" name="short_description" class="form-control summernote"></textarea>
                        </div>


                        <div class="col-md-12 m-b-20">
                            <label class="form-label">Gauge instruction<span class="red">*</span></label>
                            <textarea id="gauge_description" name="gauge_description" class="form-control summernote"></textarea>
                        </div>

                        <div class="col-md-12 m-b-20">
                            <div class="form-group">
                                <label class="form-label">Materials needed<span class="red">*</span></label>
                                <textarea id="material_needed" name="material_needed"  class="form-control summernote"></textarea>
                            </div>
                        </div>

                        <div class="col-md-4 m-b-20">
                            <div class="form-group m-t-10">
                                <label class="form-label">Design elements</label>
                                <select class="select" multiple="multiple" id="design_elements" name="design_elements[]" style="width: 100%;">
                                    @foreach($designElements as $de)
                                        <option value="{{ $de->slug }}" >{{ $de->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 m-b-20">
                            <div class="form-group m-t-10">
                                <label class="form-label">Shoulder construction<span class="red">*</span></label>
                                <select class="select" multiple="multiple" id="shoulder_construction" name="shoulder_construction[]" style="width: 100%;">
                                    @foreach($shoulderConstruction as $sc)
                                        <option value="{{ $sc->slug }}" >{{ $sc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!--<div class="col-md-4 m-b-20">

                        </div>

                        <div class="col-md-4 m-b-20">

                        </div> -->
                    </div>
                </div>

        </div>
        <!-- end of second accordion -->

        <!-- start of third accordion -->
        <div class="row theme-row m-b-10">
            <div class="card-header accordion col-lg-12"
                 data-toggle="collapse" data-target="#section2">
                <h5 class="card-header-text">Designer recommendations</h5>
                <i class="fa fa-caret-down pull-right micro-icons"></i>
            </div>
        </div>

        <div class="custom-card-block collapse" id="section2">
            <div class="row col-md-12" id="yarnDetails">
                <div class="form-group row m-b-zero yarnRows" id="yarn-row-1">
                    <div class="col-lg-12 row-bg">
                        <h6 class="m-t-5">Yarn</h6>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Yarn company
                                <span class="mytooltip tooltip-effect-2">
                                 <span class="tooltip-item">?</span>
                                 <span class="tooltip-content clearfix">
                                 <span class="tooltip-text" style="width: 100%;">Enter the name of Yarn company.</span>
                                 </span>
                                </span>
                            </label>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="yarn_company" name="yarn_company[]" value="" placeholder="Enter name of yarn company">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                Yarn name
                                <span class="mytooltip tooltip-effect-2">
                                   <span class="tooltip-item">?</span>
                                   <span class="tooltip-content clearfix">
                                      <!-- <img src="../../files/assets/images/tooltip/yarn.jpg" alt="Ecluid.png"> -->
                                      <span class="tooltip-text" style="width: 100%;">Enter the yarn you used for this pattern.</span>
                                   </span>
                                </span>
                            </label>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="yarn_name" name="yarn_name[]" value="" placeholder="Enter yarn name" ">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                Fiber type
                                <span class="mytooltip tooltip-effect-2">
                                   <span class="tooltip-item">?</span>
                                   <span class="tooltip-content clearfix">
                                      <!-- <img src="../../files/assets/images/tooltip/fabric.jpg" alt="Ecluid.png"> -->
                                      <span class="tooltip-text" style="width: 100%;">Enter the fiber content of the yarns used.</span>
                                   </span>
                                </span>
                            </label>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="fiber_type" name="fiber_type[]" value="" placeholder="Enter fiber type">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="form-label">
                                Yarn weight
                                <span class="mytooltip tooltip-effect-2">
                                   <span class="tooltip-item">?</span>
                                   <span class="tooltip-content clearfix">
                                      <!-- <img src="../../files/assets/images/tooltip/yarn-weigth.jpg" alt="Ecluid.png"> -->
                                      <span class="tooltip-text" style="width: 100%;">Select the yarn weight from the dropdown.</span>
                                   </span>
                                </span>
                            </label>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control" id="yarn_weight" name="yarn_weight[]">
                                        <option value="">Select yarn weight</option>
                                        @if($yarnWeight->count() > 0)
                                            @foreach($yarnWeight as $yw)
                                                <option value="{{ $yw->slug }}">{{ $yw->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                Shop URL
                                <span class="mytooltip tooltip-effect-2">
                                   <span class="tooltip-item">?</span>
                                   <span class="tooltip-content clearfix">
                                      <span class="tooltip-text" style="width: 100%;">Please enter URL</span>
                                   </span>
                                </span>
                            </label>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="url" class="form-control" id="yarn_url" name="yarn_url[]" placeholder="https://knitfitco.com">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">
                                Coupon code
                                <span class="mytooltip tooltip-effect-2">
                                   <span class="tooltip-item">?</span>
                                   <span class="tooltip-content clearfix">
                                      <span class="tooltip-text" style="width: 100%;">Please enter Coupon code</span>
                                   </span>
                                </span>
                            </label>
                            <div class="row">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="coupon_code" name="coupon_code[]" placeholder="Enter coupon code">
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- image uploads design -->

                     <!--image uploads design -->

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Upload files here</h5>
                            </div>
                            <div class="card-block">
                                <input type="file" class="filer_input" name="yarn_image[]" id="filer_input0" multiple="multiple">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="text-center">
                <button type="button" id="addYarnDetails" class="btn btn-sm add-yarn-custom f-12 theme-outline-btn btn-primary waves-effect waves-light"><i class="icofont icofont-plus f-12"></i>Add yarn</button>
            </div>
			
			
			 <!-- Needle size -->

            <div class="row form-group m-b-zero" id="needle-row-custom1">
                <div class="col-lg-8 row-bg">
                    <h6 class="m-b-10">Needle size</h6>
                </div>
                <div class="col-lg-4 text-right row-bg">
                    <button type="button" class="btn small-btn add-needle-custom f-12 theme-outline-btn btn-primary waves-effect waves-light" id="addNeedles"><i class="icofont icofont-plus f-12"></i>Add Needle</button>
                </div>

                <div class="row col-lg-12" id="needlesDiv">

                    <div class="col-md-4 allNeedles" id="needle0">
                        <div class="form-group">
                            <label class="form-label">Needle size used
                                <span class="mytooltip tooltip-effect-2">
                                <span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
                                  <!-- <img src="../../files/assets/images/tooltip/Knitting-Needle-Sizes.jpg" alt="Ecluid.png"> -->
                                  <span class="tooltip-text" style="width: 100%;">Select the needle size from the dropdown.</span>
                              </span>
                            </span>
                            </label>
                            <div class="row">
                                <div class="col-md-12">
                                    <select class="form-control col-md-10" id="needle_size" name="needle_size[]">
                                        <option selected>Select needle size</option>
                                        @if($needlesizes->count() > 0)
                                            @foreach($needlesizes as $ns)
                                                <option value="{{ $ns->id }}">US {{ $ns->us_size }} - {{ $ns->mm_size }} mm</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <!--<a href="javascript:;" class="fa fa-trash deleteNeedles" data-id="0" style="position: absolute;top: 9px;right: 0px;"></a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Gauge & ease-->

            <div class="row form-group m-b-zero" >
                <div class="col-lg-8 row-bg">
                    <h6 class="m-b-10">Gauge & ease</h6>
                </div>
                <div class="col-lg-4 text-right row-bg">

                </div>
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-lg-12">
                            <label class="form-label f-w-600 black">Designer's gauge
                                <span class="mytooltip tooltip-effect-2">
                                <span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
                                     <!-- <img src="../../files/assets/images/tooltip/Knitting-Needle-Sizes.jpg" alt="Ecluid.png"> -->
                                  <span class="tooltip-text f-w-200 f-14" style="width: 100%;">The designer's gauge is only provided for the reference of curious knitters. Only your own gauge matters for custom patterns!</span>
                                </span>
                                </span>
                            </label>

                            <div class="row form-group">
                                <div class="col-md-6">
                                    <div class="form-radio m-b-10">
                                        <h6 class="text-muted m-b-10">Unit of measurement</h6>
                                        <div class="radio radio-inline m-r-10">
                                            <label>
                                                <input type="radio" id="inches-custom" name="radio_inches" checked="checked">
                                                <i class="helper"></i>Inches
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Stitch gauge<span class="red">*</span>
                                        </label>
                                        <select class="form-control" id="stitch_gauge_in" name="stitch_gauge_in">
                                            <option value="">Select value (inches)</option>
                                            @foreach($gaugeconversion as $gc2)
                                                <option value="{{$gc2->id}}">{{$gc2->row_gauge_inch .' / 1 inches'}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Row gauge<span class="red">*</span>
                                        </label>
                                        <select class="form-control" id="row_gauge_in" name="row_gauge_in">
                                            <option value="">Select value (inches)</option>
                                            @foreach($gaugeconversion as $gc2)
                                                <option value="{{$gc2->id}}">{{$gc2->row_gauge_inch .' / 1 inches'}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Ease preference<span class="red">*</span>
                                        </label>
                                        <select class="form-control" id="ease_in" name="ease_in">
                                            <option value="">Select value (inches)</option>
                                            @for($j=1;$j<= 20;$j+= 0.25)
                                                <option value="{{$j}}">{{$j}}"</option>
                                            @endfor
                                        </select>
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="form-radio m-b-10">
                                        <h6 class="text-muted m-b-10">Unit of measurement</h6>
                                        <div class="radio radio-inline m-r-10">
                                            <label>
                                                <input type="radio" id="inches-custom" name="radio_cm" checked="checked">
                                                <i class="helper"></i>Centimeters
                                            </label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Stitch gauge<span class="red">*</span>
                                        </label>
                                        <select class="form-control" id="stitch_gauge_cm" name="stitch_gauge_cm">
                                            <option value="">Select value (cm)</option>
                                            @foreach($gaugeconversion as $gc3)
                                                <option value="{{$gc3->id}}">{{$gc3->rows_10_cm .' / 10cm'}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Row gauge<span class="red">*</span>
                                        </label>
                                        <select class="form-control" id="row_gauge_cm" name="row_gauge_cm">
                                            <option value="">Select value (cm)</option>
                                            @foreach($gaugeconversion as $gc3)
                                                <option value="{{$gc3->id}}">{{$gc3->rows_10_cm .' / 10cm'}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Ease preference<span class="red">*</span>
                                        </label>
                                        <select class="form-control" id="ease_cm" name="ease_cm">
                                            <option value="">Select value (cm)</option>
                                            @for($i=1;$i <= 20;$i++)
                                                <option value="{{$i}}">{{$i}} cm</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

           

        </div>

        <!-- end of third accordion -->

        <!-- start of fourth accordion -->

        <div class="row theme-row m-b-10">
            <div class="card-header accordion col-lg-12"
                 data-toggle="collapse" data-target="#section6">
                <h5 class="card-header-text">Images</h5>
                <i class="fa fa-caret-down pull-right micro-icons"></i>
            </div>
        </div>

    <div class="card-block collapse" id="section6">
        <!--<div class="row">
            <div class="col-lg-2 m-b-10">
                <div class="img-hover" style="background-image: url(../../files/assets/images/user-card/The-Boyfriend-Sweater.jpg);
                background-size: cover;
                height: 220px;"><div class="editable-items">
                        <i class="fa fa-star" data-toggle="modal" data-dismiss="modal" data-target="#delete-Modal"></i>
                        <i class="fa fa-trash" data-toggle="modal" data-dismiss="modal" data-target="#delete-Modal"></i>
                    </div></div>
            </div>

            <div class="col-lg-2 m-b-10">
                <div class="img-hover" style="background-image: url(../../files/assets/images/user-card/Off-the-Shoulder-Ruffle-Top.jpg);
                background-size: cover;
                height: 220px;"><div class="editable-items">
                        <i class="fa fa-star-o" data-toggle="modal" data-dismiss="modal" data-target="#delete-Modal"></i>
                        <i class="fa fa-trash" data-toggle="modal" data-dismiss="modal" data-target="#delete-Modal"></i>
                    </div></div>
            </div>

            <div class="col-lg-2 m-b-10">
                <div class="img-hover" style="background-image: url(../../files/assets/images/user-card/Marshas-Lacy-Tee.jpg);
                background-size: cover;
                height: 220px;"><div class="editable-items">
                        <i class="fa fa-star-o" data-toggle="modal" data-dismiss="modal" data-target="#delete-Modal"></i>
                        <i class="fa fa-trash" data-toggle="modal" data-dismiss="modal" data-target="#delete-Modal"></i>
                    </div></div>
            </div>
        </div> -->
        <!-- File upload card start -->
        <div class="card">
            <div class="card-header">
                <h5>Upload files here<b class="red">*</b></h5>
            </div>
            <div class="form-group card-block">
                <!-- <div class="sub-title">Example 1</div> -->
                <input type="file" class="filer_input1" name="product_images[]" id="product_images" multiple="multiple">
            </div>
        </div>
        <!-- File upload card end -->
    </div>

        <!-- end of fourth accordion -->

    <!-- start of 5th accordion -->
    <div class="row theme-row m-b-10">
        <div class="card-header accordion col-lg-12"
             data-toggle="collapse" data-target="#section5">
            <h5 class="card-header-text">Enter price</h5>
            <i class="fa fa-caret-down pull-right micro-icons"></i>
        </div>
    </div>

    <div class="card-block collapse" id="section5">
        <div class="row">
            <div class="form-group col-md-4 m-b-20">
                <label class="form-label">Price<span class="red">*</span>
                </label>
                <input type="text" name="product_price" id="product_price" class="form-control" placeholder="Enter price" value="0">
            </div>

            <div class="form-group col-md-4 m-b-20">
                <label class="form-label">Sale Price
                </label>
                <input type="number" name="sale_price" id="sale_price" class="form-control" placeholder="Enter sale price" min="0">
            </div>

            <div class="form-group col-md-4 m-b-20">
                <label class="form-label m-b-0">Sale Price Start Date</label>
                <input type="text" name="sale_price_start_date" id="sale_price_start_date" class="form-control" readonly placeholder="Select sale price start date">
            </div>

            <div class="form-group col-md-4 m-b-20">
                <label class="form-label">Sale Price End Date
                </label>
                <input type="text" name="sale_price_end_date" id="sale_price_end_date" class="form-control" readonly placeholder="Select sale price end date" >
            </div>
        </div>
    </div>
    <!-- end of 5th accordion -->

    <div class="m-t-20">
        <div class="col-sm-12">
            <div class="text-center m-b-10">
                <button type="submit" data-type="save" class="btn theme-btn btn-primary waves-effect waves-light m-l-10 save" >Save</button>
                <button type="submit" data-type="submit" class="btn theme-btn btn-primary waves-effect waves-light m-l-10 save" >Save & continue</button>
            </div>
        </div>
    </div>

                                                                    <input type="hidden" name="submit_type" id="submit_type" value="save">

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

<!-- second tab starts here

    <div class="tab-pane" id="pi" role="tabpanel">
        <div class="row">
            <div class="container" style="padding-top:20px;">
                <div class="justify-content-center row">
                    <div class="col-lg-4">
                        <select name="template_id" id="template_id" class="form-control">
                            <option value="">Select template</option>
                            @if($templates->count() > 0)
                                @foreach($templates as $temp)
                                    <option value="{{ encrypt($temp->id) }}">{{ ucfirst($temp->template_name) }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="template_id red"></span>
                    </div>
                    <div class="col-lg-2">
                        <a href="javascript:;" id="selectTemplate" class="btn theme-btn btn-sm">Select Template</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 m-t-15" id="templateData">

            </div>

            <div class="m-t-20 hide" id="templateSubmitButton">
                <div class="col-sm-12">
                    <div class="text-center m-b-10">
                        <button type="submit" class="btn theme-btn btn-primary waves-effect waves-light m-l-10">Attach template to pattern</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

second tab ends here -->

                                                </div>
                                                <!-- Section for Pattern details end here -->
</form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- card ends here -->
                                </div>
                                <!-- col-md-12 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footerscript')
<script type="text/javascript">
    var URL = '{{url("designer/upload-pattern-images")}}';
    var URL1 = '{{url("designer/remove-pattern-images")}}';

    var URL2 = '{{url("designer/upload-designer-recomondation-images")}}';
    var URL3 = '{{url("designer/remove-designer-recomondation-images")}}';

    var PAGE = 'designerPatterns';
</script>
<style>
    .profile-upload{position: absolute;z-index: 999999; top: 4px;left: 18px;}
    #upload-file {
        display: block;
        font-size: 14px;
    }
    .delete-row {
        top: 43px!important;
        right: -4px!important;
    }
    .border-box{border:.8px solid #ccc}
    .delete-function{color: #0d665c;font-size: 16px;cursor: pointer;}
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: .4px solid #cccccc;
        border-radius: 2px;
    }
    .select2-container .select2-selection--single{height: 32px;}
    .label{padding:0px;border:.5px solid #cccccc;}
    input[type="file"]{display: block;}
    /*#price{border: 1px solid #ccc;}*/
    .select{border: 1px solid #ccc;}
    .delete{cursor: pointer;}
    .noteChkbox{float: left;margin-top: 6px;margin-left: -10px;}
    input[type=checkbox]:checked ~ .tick label.strikethrough{
        text-decoration: line-through;
    }
    .jFiler-input-choose-btn{background-color: transparent;
        border: 1px solid #0d665c;
        color: #0d665c !important;font-weight: 300;
        border-radius: 0px;}
    /* .strikethrough{width: 100px;} */
    /* For To-Do only*/
    .tasks-parent{
        border: solid .6px #dadada;
        border-radius: 2px;
        margin: 5px;
        padding: 5px;
    }
    #todo #todo-form input{
        padding: 3px;
        border-radius: 2px;
        border: solid .6px #dadada;
        margin: 0 0 0 5px;
        width: 200px;
    }

    #todo #todo-form input[type=submit]{
        background: #ffffff;
        border: 1px solid #0d665c;
        color: #0d665c;
        padding: 3px 10px;
        cursor: pointer;
        width: auto;
        font-size: 12px;
    }
    #todo #todo-form input[type=submit]:hover{background-color: #0d665c;color: white;}
    .tasks{
        width: 100%;
    }
    .tasks .check{
        color: #0d665c;
        width: 20px;
        cursor: pointer;
    }
    .tasks .todo-name{
        width: 250px;
    }
    .nav-item .active{color: #0d665c!important;font-weight: 600;}
    td, th{white-space: initial;}
    .delete-row{top: 12px;right: 10px;}
    .img-hover:hover .editable-items{opacity: 1;}
    #preview-btn{bottom: 15px;position: fixed;float: right;right: 21px;z-index: 99999;}
    .select2-container--default .select2-selection--multiple .select2-selection__clear{
        position: absolute;
        right: 0;
    }
    li.select2-search--inline{
        width: 100% !important;
    }
    input.select2-search__field{
        width: 100% !important;
    }
    .jFiler-item .jFiler-item-container .jFiler-item-thumb img{
        *margin-top: -136px !important;
    }
    .red{
        color: #c14d7d;
    }
    .help-block {
        display: block;
        margin-top: 5px;
        *margin-bottom: 10px;
        color: #bc7c8f;
        font-weight:bold;
    }
    .conditionAccordionDisable a{
        pointer-events: none;
        opacity: 0.5;
    }
    .hide{
        display: none;
    }
</style>
<link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('resources/assets/connect/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />

<script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('resources/assets/connect/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
<link href="{{ asset('resources/assets/connect/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<script src="{{ asset('resources/assets/connect/assets/plugins/moment/moment.js') }}"></script>
<script src="{{ asset('resources/assets/connect/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css')}}" type="text/css" rel="stylesheet" />
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')}}" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/pages/message/message.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/summernote/summernote.min.css') }}" />

<script src="{{ asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js')}}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/filer/designer-create-patterns-jquery.fileupload.init.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

<script>
    $(function(){
        jqueryFiler('filer_input0',URL2,URL3,0);
        patternImages('product_images',URL,URL1);
        var accordion = $(".accordion ");

        $('.summernote').summernote({
            height: 150,
            callbacks: {
                onFocus: function(e) {
                    //alert($(this).attr('id'));
                    if($(this).summernote('isEmpty')){
                        $(this).summernote('code','');
                    }
                },
                onChange: function(e) {
                    var id = $(this).attr('id');
                    validateDescription(id);
                },
                onPaste: function(e) {
                    var id = $(this).attr('id');
                    validateDescription(id);
                }
            }
        });


        $(".nav-tab3").find("a").prop("disabled", true).css({'cursor': 'not-allowed', 'opacity': '0.5'});
        $('#pattern_go_live_date').bootstrapMaterialDatePicker({
            format: 'MM/DD/YYYY',
            weekStart : 0,
            time: false,
            minDate : new Date()
        });

        $('#sale_price_start_date').bootstrapMaterialDatePicker({
            format: 'MM/DD/YYYY',
            weekStart : 0,
            time: false,
            minDate : new Date()
        }).on('change',function (e,data){

            $('#sale_price_end_date').bootstrapMaterialDatePicker({
                format: 'MM/DD/YYYY',
                weekStart : 0,
                time: false,
                minDate : $("#sale_price_start_date").val(),
            })
        });


        $("#design_elements").select2({
            placeholder: "Enter tags",
            allowClear: true,
            tags: true
        });

        $("#shoulder_construction").select2({
            placeholder: "Enter tags",
            allowClear: true,
            tags: true
        });

        $("#template_id").select2({
            placeholder: "Please Select a template",
            allowClear: true
        });

        $(document).on('click',"#next-step1",function() {

            if($('#create-pattern').data('bootstrapValidator').isValid() === false) {
                $('#create-pattern').data('bootstrapValidator').validate('validate');
           }else{

              $('#P-details,#Measurements').removeClass('active show');
                $('#pi').addClass('active show');
                $('.nav-tab1 a,.nav-tab2 a').removeClass('active show');
                $('.nav-tab3 a').addClass('active show');
                $('.nav-tab3 a').css('cursor', 'pointer');
                $('.nav-tab3 a').css('opacity', '1');
                $("#tab-no2").html('<i class="fa fa-check"></i>');
                $(".nav-tab3").find("a").prop("disabled", false);

                accordion.each(function(){
                    var target = $(this).attr('data-target');
                    if($(target).hasClass('show')){
                        $(target).removeClass('show');
                    }
                });
            }
        });

         /* form validations */

        var $validations = $('#create-pattern');

        /*$validations.find('[name="design_elements[]"]')
            .select2({
                placeholder: "Enter tags",
                allowClear: true,
                tags: true
            })
            .change(function(e) {
                $validations.data('bootstrapValidator').validateField('design_elements');
            })
            .end();*/

        $validations.find('[name="shoulder_construction[]"]')
            .select2({
                placeholder: "Enter tags",
                allowClear: true,
                tags: true
            })
            .change(function(e) {
                $validations.data('bootstrapValidator').validateField('shoulder_construction');
            })
            .end();

        $validations.bootstrapValidator({
                excluded: [':disabled'],
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: '', //fa fa-check
                    invalid: '', //fa fa-exclamation
                    validating: 'fa fa-spinner fa-spin'
                },
                fields: {
                    sku: {
                        message: 'The sku is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The sku is required.'
                            },
                        }
                    },
                    pattern_go_live_date: {
                        message: 'The pattern go live date is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The pattern go live date is required.'
                            },
                        }
                    },
                    status: {
                        message: 'The status is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The status is required.'
                            },
                        }
                    },
                    name: {
                        message: 'The pattern name is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The pattern name is required.'
                            },
                            /*remote: {
                                message: 'The section name is already in use. Please enter another one.',
                                url: '',
                                data:{
                                    'section_name' : $("#section_name").val(),
                                    'pattern_template_id' : $("#pattern_template_id").val()
                                }
                            },*/
                            regexp: {
                                regexp: /^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/,
                                message: 'The pattern name should have only alphabets, numbers and spaces.'
                            }
                        }
                    },
                    designer_name: {
                        message: 'The designer name is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The designer name is required.'
                            },
                            /*remote: {
                                message: 'The section name is already in use. Please enter another one.',
                                url: '',
                                data:{
                                    'section_name' : $("#section_name").val(),
                                    'pattern_template_id' : $("#pattern_template_id").val()
                                }
                            },*/
                            regexp: {
                                regexp: /^([a-zA-Z]+\s)*[a-zA-Z]+$/,
                                message: 'The designer name should have only alphabets and spaces.'
                            }
                        }
                    },
                    skill_level: {
                        message: 'The skill level is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The skill level is required.'
                            }
                        }
                    },
                    pattern_description: {
                        message: 'The description is not valid',
                        validators: {
                            callback: {
                                message: 'The description is required.',
                                callback: function(value, validator) {
                                    var code = $('[name="pattern_description"]').summernote('code');
                                    // <p><br></p> is code generated by Summernote for empty content
                                    return (code !== '' && code !== '<p><br></p>');
                                }
                            }
                        }
                    },
                    short_description: {
                        message: 'The short description is not valid',
                        validators: {
                            callback: {
                                message: 'The short description is required.',
                                callback: function(value, validator) {
                                    var code = $('[name="short_description"]').summernote('code');
                                    // <p><br></p> is code generated by Summernote for empty content
                                    return (code !== '' && code !== '<p><br></p>');
                                }
                            }
                        }
                    },
                    gauge_description: {
                        message: 'The gauge description is not valid',
                        validators: {
                            callback: {
                                message: 'The gauge description is required.',
                                callback: function(value, validator) {
                                    var code = $('[name="gauge_description"]').summernote('code');
                                    // <p><br></p> is code generated by Summernote for empty content
                                    return (code !== '' && code !== '<p><br></p>');
                                }
                            }
                        }
                    },
                    material_needed: {
                        message: 'The materials is not valid',
                        validators: {
                            callback: {
                                message: 'The materials is required.',
                                callback: function(value, validator) {
                                    var code = $('[name="material_needed"]').summernote('code');
                                    // <p><br></p> is code generated by Summernote for empty content
                                    return (code !== '' && code !== '<p><br></p>');
                                }
                            }
                        }
                    },
                    /*'design_elements[]': {
                        message: 'The design elements is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The design elements is required.'
                            }
                        }
                    },*/
                    'shoulder_construction[]': {
                        message: 'The shoulder construction is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The shoulder construction  is required.'
                            }
                        }
                    },
                    stitch_gauge_in: {
                        message: 'The stitch gauge for inches is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The stitch gauge for inches is required.'
                            }
                        }
                    },
                    row_gauge_in: {
                        message: 'The row gauge for inches is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The row gauge for inches is required.'
                            }
                        }
                    },
                    ease_in: {
                        message: 'The ease for inches is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The ease for inches is required.'
                            }
                        }
                    },
                    stitch_gauge_cm: {
                        message: 'The stitch gauge for centimeters is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The stitch gauge for centimeters is required.'
                            }
                        }
                    },
                    row_gauge_cm: {
                        message: 'The row gauge for centimeters is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The row gauge for centimeters is required.'
                            }
                        }
                    },
                    ease_cm: {
                        message: 'The ease for centimeters is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The ease for centimeters is required.'
                            }
                        }
                    },
                    product_price: {
                        //message: 'The price is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The price is required.'
                            },
                            regexp:{
                                regexp: /^\d+(\.\d{2})?$/,
                                message: 'Price should contain number with 2 decimal places.'
                            }
                        }
                    },
                    'product_images[]': {
                        message: 'The images is not valid',
                        validators: {
                            notEmpty: {
                                message: 'The images are required.'
                            },
                            file: {
                                extension: 'jpg,jpeg,png',
                                type: 'image/jpg,image/jpeg,image/png',
                                maxSize: 2048 * 1024,
                                message: 'The selected file is not valid'
                            }
                        }
                    }

                }
            }).on('status.field.bv', function(e, data) {
                data.bv.disableSubmitButtons(false);
            }).on('error.field.bv', function(e, data) {
                //notification('fa-times','Error','Please fill the required fields.','danger');
                //console.log(data.field);
                //alert('error from form');
                accordion.each(function(){
                    var target = $(this).attr('data-target');
                    if(!$(target).hasClass('show')){
                        $(target).addClass('show');
                    }
                });
            }).on('success.form.bv', function(e,data) {
                e.preventDefault();



                //var template_id = $("#template_id").val();
                var sale_price = $("#sale_price").val();
                var sale_price_start_date = $("#sale_price_start_date").val();
                var sale_price_end_date = $("#sale_price_end_date").val();
                var er = [];
                var cnt = 0;

                /* if(template_id == ""){
                    $(".template_id").html('Template name is required.');
                    er+=cnt+1;
                }else{
                    $(".template_id").html('');
                } */

            if(sale_price != '' || sale_price > 0){
                if(sale_price_start_date == '' || sale_price_start_date == '0000-00-00'){
                    $(".sale_price_start_date").html('This field is required.');
                    er+=cnt+1;
                }else{
                    $(".sale_price_start_date").html('');
                }

                if(sale_price_end_date == '' || sale_price_end_date == '0000-00-00'){
                    $(".sale_price_end_date").html('This field is required');
                    er+=cnt+1;
                }else{
                    $(".sale_price_end_date").html('');
                }
            }

            if(er !=''){
                notification('fa-times','Error','Please fill all the required fields','danger');
                return false;
            }

            


                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(".loading,.loader-bg").show();
                $.post($form.attr('action'), $form.serialize(), function(result) {
                    if(result.status == 'success'){
                        $(".loading,.loader-bg").hide();
                        notification('fa-check','success','Data saved successfully.','success');
                        setTimeout(function(){ window.location.assign(result.url) },1000);
                    }else{
                        alert('There are few errors in the form, Please refresh and try again.');
                    }
                }, 'json');
            });


        $(document).on('click','#addYarnDetails',function() {
            var $rows = $(".yarnRows");
            var rowId = $rows.length;
            var prevRowId = $rows.length - 1;
            var $template = '<div class="form-group row m-b-zero yarnRows" id="yarn-row-' + rowId + '"> <div class="col-lg-10 row-bg"> <h6 class="m-t-5">Yarn </h6> </div><div class="col-lg-2 row-bg"> <a href="javascript:;" class="pull-right fa fa-trash deleteYarndetails"  title="Delete yarn details" data-id="' + rowId + '" id="deleteYarndetails' + rowId + '" data-server="false"></a> </div><div class="col-md-4"> <div class="form-group"> <label class="form-label">Yarn company <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Enter the name of Yarn company.</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <input type="text" class="form-control" id="yarn_company" name="yarn_company[]" value="" placeholder="Enter name of yarn company"> </div></div></div></div><div class="col-md-4"> <div class="form-group"> <label class="form-label"> Yarn name <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Enter the yarn you used for this pattern.</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <input type="text" class="form-control" id="yarn_name" name="yarn_name[]" value="" placeholder="Enter yarn name" "> </div></div></div></div><div class="col-md-4"> <div class="form-group"> <label class="form-label"> Fiber type <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Enter the fiber content of the yarns used.</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <input type="text" class="form-control" id="fiber_type" name="fiber_type[]" value="" placeholder="Enter fiber type"> </div></div></div></div><div class="col-lg-4"> <div class="form-group"> <label class="form-label"> Yarn weight <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Select the yarn weight from the dropdown.</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <select class="form-control" id="yarn_weight" name="yarn_weight[]"> <option value="">Select yarn weight</option> @if($yarnWeight->count() > 0) @foreach($yarnWeight as $yw) <option value="{{ $yw->slug }}">{{ $yw->name }}</option> @endforeach @endif </select> </div></div></div></div><div class="col-md-4"> <div class="form-group"> <label class="form-label"> Shop URL <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Please enter URL</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <input type="url" class="form-control" id="yarn_url" name="yarn_url[]" placeholder="https://knitfitco.com"> </div></div></div></div><div class="col-md-4"> <div class="form-group"> <label class="form-label"> Coupon code <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Please enter Coupon code</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <input type="text" class="form-control" id="coupon_code" name="coupon_code[]" placeholder="Enter coupon code"> </div></div></div></div><div class="col-md-12"> <div class="card"> <div class="card-header"> <h5>Upload files here</h5> </div><div class="card-block"> <input type="file" class="filer_input" name="yarn_image[]" id="filer_input'+rowId+'" multiple="multiple"> </div></div></div></div>';

            //$validations.data('bootstrapValidator').addField($(this));
            $("#yarnDetails").append($template);
            $("#deleteYarndetails"+prevRowId).removeClass('fa-trash');
            setTimeout(function (){ jqueryFiler('filer_input'+rowId,URL2,URL3,rowId); },1000);
        });

        $(document).on('click','.deleteYarndetails',function() {
            var id = $(this).attr('data-id');
            var $rows = $(".yarnRows");
            var rowId = $rows.length + 1;
            var prevRowId = $rows.length - 1;
            var server = $(this).attr('data-server');

            if(confirm('Are you sure want to delete this ?')){
                if(server == true){
                    $.get('{{ url("/")  }}',function (res){

                    });
                }else{
                    $("#yarn-row-"+id).remove();
                }
                if(prevRowId != 0){
                    $("#deleteYarndetails"+prevRowId).addClass('fa-trash');
                }
            }
        });

        $(document).on('click','#addNeedles',function(){
            var $rows = $(".allNeedles");
            var rowId = $rows.length + 1;
            var prevRowId = $rows.length;
           var $template = '<div class="col-md-4 allNeedles" id="needle'+rowId+'"> <div class="form-group"> <label class="form-label">Needle size used <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Select the needle size from the dropdown.</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <select class="form-control col-md-12" id="needle_size" name="needle_size[]"> <option selected>Select needle size</option> @if($needlesizes->count() > 0) @foreach($needlesizes as $ns) <option value="{{ $ns->id }}">US {{ $ns->us_size }} - {{ $ns->mm_size }} mm</option> @endforeach @endif  </select> <a href="javascript:;" class="fa fa-trash deleteNeedles" data-server="false" id="deleteNeedles'+rowId+'" data-id="'+rowId+'" style="position: absolute;top: 9px;right: 0px;"></a> </div></div></div></div>';
            $("#needlesDiv").append($template);
            $("#deleteNeedles"+prevRowId).removeClass('fa-trash');
        });



        $(document).on('click','.deleteNeedles',function(){
            var id = $(this).attr('data-id');
            var $rows = $(".allNeedles");
            var rowId = $rows.length + 1;
            var prevRowId = $rows.length - 1;
            var server = $(this).attr('data-server');

            if(confirm('Are you sure want to delete this ?')){
                if(server == true){
                    $.get('{{ url("/")  }}',function (res){

                    });
                }else{
                    $("#needle"+id).remove();
                }
                if(prevRowId != 0){
                    $("#deleteNeedles"+prevRowId).addClass('fa-trash');
                }
            }
        });

        $(document).on('click','.save',function (){
            var type = $(this).attr('data-type');
            $("#submit_type").val(type);
        });



    });

    function validateDescription(id){
        $('#create-pattern').data('bootstrapValidator').revalidateField(id);
    }

    function validateSaleData(){
        var sale_price = $("#sale_price").val();
        var sale_price_start_date = $("#sale_price_start_date").val();
        var sale_price_end_date = $("#sale_price_end_date").val();

        //if(sale_price){
            if(!sale_price_start_date){
                var options = {
                    fields: {
                        sale_price_start_date: {
                            message: 'The sale price start date is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The sale price start date is required and cannot be empty'
                                },
                            }
                        }
                    }
                }

                $('#create-pattern').data('bootstrapValidator').updateStatus('sale_price_start_date', 'NOT_VALIDATED').validateField('sale_price_start_date');
            }

            if(!sale_price_end_date){
                var options = {
                    fields: {
                        sale_price_end_date: {
                            message: 'The sale price end date is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The sale price end date is required and cannot be empty'
                                },
                            }
                        }
                    }
                }

                $('#create-pattern').data('bootstrapValidator').updateStatus('sale_price_end_date', 'NOT_VALIDATED').validateField('sale_price_end_date');
            }
        //}
    }
</script>
@endsection
