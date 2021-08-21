@extends('layouts.knitterapp')
@section('title',$product->product_name)
@section('content')

<div class="page-body">
<div class="row">
<div class="col-xl-12">
<label class="theme-heading f-w-600 m-b-20">Create Pattern
</label> <span class="mytooltip tooltip-effect-2" >
                    <span class="tooltip-item">?</span>
                    <span class="tooltip-content clearfix" id="Customtooltip">
                    <span class="tooltip-text" style="width: 100%;">Select the type of pattern you will use for this project.</span>
                </span>
                </span>

<p style="font-size: 34px;">Upload a pattern</p>
<p class="f-18" style="color: #6b6b6b;">Please fill out the form below and Submit for approval.</p>
<p class="f-14" style="color: #6b6b6b;">When your design has been approved,it's status on your dashboard will change to Approved for upload.</p>

<p><a style="color: #dd8ca0;" href="https://stitchersstudio.com/website/wp-content/uploads/2021/03/Asset-1-1.png" target="_blank" rel="noopener">View an example of how the info you enter will appear in your pattern listing.</a></p>
<p style="color: #6b6b6b;">If you have any questions about filling out this form, please contact info@stitcherstudio.com</p>
<!-- To Do Card List card start -->
<div class="card">
<!-- <div class="outline-row m-b-10 p-10 m-t-10" style="margin-right: 10px;margin-left: 10px;">
<h5 class="card-header-text">Select pattern type</h5>
</div> -->
<div class="row">
<form class="form-horizontal col-lg-12" id="update-pattern" action="{{ url('designer/update-all-pattern-data') }}">
<input type="hidden" name="product_id" id="product_id" value="{{ base64_encode($product->id) }}">
<ul class="nav nav-tabs md-tabs" role="tablist">
<li class="nav-item nav-tab1">
    <a class="nav-link " data-toggle="tab" href="#basic-p-details" role="tab" aria-selected="false">
        <button class="btn theme-btn btn-icon-tab waves-effect waves-light">
            <span id="tab-no1">1</span>
        </button>Basic details</a>
    <div class="slide"></div>
</li>
<li class="nav-item nav-tab2">
    <a class="nav-link active show" data-toggle="tab" href="#P-details" role="tab" aria-selected="false"><button class="btn theme-btn btn-icon-tab waves-effect waves-light">
            <span id="tab-no2">2</span>
        </button>Pattern details</a>
    <div class="slide"></div>
</li>
<li class="nav-item nav-tab3">
    <a class="nav-link" data-toggle="tab" href="#pattern-preview" role="tab" aria-selected="false"><button class="btn theme-btn btn-icon-tab waves-effect waves-light">
            <span id="tab-no3">3</span>
        </button>Pattern preview</a>
    <div class="slide"></div>
</li>
</ul>


<!-- Section for Pattern details starts here -->
<div class="tab-content card-block">
<!--Tab for Second tab-->
<!--
<div class="tab-pane active show" id="basic-p-details" role="tabpanel">

        <div class="card-block pattern-details">
            <div class="row">
                <div class="col-lg-12 col-sm-12">

                    <div class="step">
                        <div class="form-group row">
                            <div class="col-md-6 m-b-20">
                                <label class="">Pattern name<span class="required">*</span>
                                </label>
                                <input type="text" id="product_name" name="product_name" class="form-control" value="{{ $product->product_name }}" placeholder="Enter pattern name">
                                <span class="small-text clearfix">Name of the pattern (to display on pattern listing in Shop)</span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 m-b-20">
                                <label class="">Tell us about pattern<span class="required">*</span>
                                </label>
                                <textarea type="text" id="about_description" class="form-control" name="about_description" required="" placeholder="Tell us a little bit about this design." spellcheck="false">{{ $product->product_information }}</textarea>
                            </div>

                        </div>
                    </div>


                    <div class="card">
                        <div class="card-header">
                            <h5>Upload pattern images <span class="required">*</span></h5>
                            <span class="small-text">Add individual images of your design to show off the finished garment! The recommended image sizes are: 400 X 700 pixels minimum to 2000 X 3500 pixels maximum</span>
                        </div>
                        <div class="card-block">
                            <!-- <div class="sub-title">Example 1</div> --
                            <input type="file" name="product_images[]" id="product_images" multiple="multiple">
                        </div>

                        <div class="row">
                            @if($product->patternImages()->count() > 0)
                                @foreach($product->patternImages as $images)
                                    <div class="col-lg-2 m-b-10 patternImages" id="patternImage{{$images->id}}">
                                        <div class="img-hover" style="background-image: url({{ $images->image_small }});background-size: cover;
                                            height: 220px;">
                                            <div class="editable-items">
                                                <a class="fa @if($images->main_photo == 0) fa-star-o @else fa-star @endif primaryImage" id="primaryImage{{$images->id}}" href="javascript:;" data-id="{{ $images->id }}" data-server="true" data-mainPhoto="{{ $images->main_photo }}"></a>
                                                <a class="fa fa-trash deleteImage" data-server="true" href="javascript:;" data-id="{{ $images->id }}"></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12"></div>
            <div class="col-sm-12">
                <div class="text-center m-b-10">
                    <a href="javascript:;" class="btn theme-btn btn-primary waves-effect waves-light m-l-10" id="next-step1">Next</a>
                </div>
            </div>
        </div>
</div>

-->
<!---------------------->
<div class="tab-pane active show" id="P-details" role="tabpanel">
    <div class="card-block pattern-details">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <!--First Accordion Starts here-->
                <div class="row theme-row m-b-10">
                    <div class="card-header accordion active col-lg-12 col-sm-12"
                         data-toggle="collapse" data-target="#section1">
                        <h5 class="card-header-text">Pattern details
                        </h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                    </div>
                </div>
                <div class="custom-card-block" id="section1">
                    <div class="form-group row">
                        <div class="col-md-6 m-b-20">
                            <label class="form-label">SKU<span class="red">*</span>
                            </label>
                            <input type="text" name="sku" id="sku" class="form-control" value="{{
        $product->sku }}" readonly >
                        </div>

                        <div class="col-md-6 m-b-20">
                            <label class="form-label">Brand name
                            </label>
                            <input type="text" class="form-control"
                                   id="brand_name" name="brand_name"
                                   placeholder="Enter brand name" value="{{ $product->brand_name }}" >
                            <small>If there is another name associated with your design work aside from your actual name, please provide it here</small>
                        </div>

                    </div>
                </div>


                    <div class="row theme-row m-b-10">
                        <div class="card-header accordion col-lg-12"
                             data-toggle="collapse" data-target="#section3">
                            <h5 class="card-header-text">Pattern information</h5>
                            <i class="fa fa-caret-down pull-right micro-icons"></i>
                        </div>

                    </div>
                    <div class="card-block collapse" id="section3">
                        <div class="card-body row">
                            <div class="form-group row">
                                <div class="col-md-6 m-b-20">
                                    <label class="form-label">Pattern name<span class="red">*</span></label>
                                   <input type="hidden" id="product_name" name="product_name" class="form-control" value="{{ $product->product_name }}" placeholder="Enter pattern name">
								   <input type="text" id="name" name="name" class="form-control" value="{{ $product->product_name }}" placeholder="Enter pattern name">
                                    <small>Name of the pattern (to display on pattern listing in Shop)</small>
                                </div>


                                <div class="col-md-6 m-b-20">
                                    <label class="form-label">Skill level<span class="red">*</span>
                                    </label>
                                    <select class="form-control form-control-default" id="skill_level" name="skill_level" >
                                        <option value="">Please Select Skill level</option>
                                        <option value="Beginner" @if($product->skill_level == 'Beginner')
                                        selected @endif >Beginner</option>
                                        <option value="Easy" @if($product->skill_level == 'Easy') selected @endif >Easy</option>
                                        <option value="Intermediate" @if($product->skill_level == 'Intermediate') selected @endif >Intermediate</option>
                                        <option value="Complex" @if($product->skill_level == 'Complex') selected @endif >Complex</option>
                                    </select>
                                    <small>Select one to describe the difficulty level of this pattern.</small>
                                </div>

                                <div class="col-md-12 m-b-20">
                                    <label class="form-label">Pattern description<span class="red">*</span>
                                    </label>
                                    <textarea id="pattern_description" name="pattern_description"
                                              class="form-control summernote" spellcheck="false">{!! $product->product_description
                  !!}</textarea>
                                </div>

                                <div class="col-md-12 m-b-20">
                                    <label class="form-label">Pattern details<span class="red">*</span>
                                    </label>
                                    <textarea  id="short_description" name="short_description"
                                               class="form-control summernote">{!! $product->short_description !!}</textarea>
                                </div>


                                <div class="col-md-12 m-b-20">
                                    <label class="form-label">Gauge instruction<span class="red">*</span></label>
                                    <textarea id="gauge_description" name="gauge_description" class="form-control
         summernote">{!! $product->gauge_description !!}</textarea>
                                </div>

                                <div class="col-md-12 m-b-20">
                                    <div class="form-group">
                                        <label class="form-label">Materials needed<span class="red">*</span></label>
                                        <textarea id="material_needed" name="material_needed"
                                                  class="form-control summernote">{!! $product->material_needed !!}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6 m-b-20">
                                    <div class="form-group m-t-10">
                                        <?php
                                        $tags = explode(',',$product->design_elements);
                                        ?>
                                        <label class="form-label">Design elements<span class="red">*</span></label>
                                        <select class="select" multiple="multiple" id="design_elements" name="design_elements[]" style="width: 100%;">
                                            @if($designElements->count() > 0)
                                                @foreach($designElements as $de)
                                                    <option value="{{ $de->slug }}"
                                                            @if(count($tags) > 0)
                                                            @for($i=0;$i<count($tags);$i++)
                                                            @if($tags[$i] == $de->slug) selected @endif
                                                        @endfor
                                                        @endif
                                                    >{{ $de->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small>To specify other tags, Type a tag name
                                            and press enter
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6 m-b-20">
                                    <div class="form-group m-t-10">
                                        <?php
                                        $tags2 = explode(',',$product->garment_construction);
                                        ?>
                                        <label class="form-label">Construction technique<span class="red">*</span></label>
                                        <select class="select" multiple="multiple"
                                                id="garment_construction"
                                                name="garment_construction[]" style="width: 100%;">
                                            @if($garmentConstruction->count() > 0)
                                                @foreach($garmentConstruction as $gc)
                                                    <option value="{{ $gc->slug }}"
                                                            @if(count($tags2) > 0)
                                                            @for($k=0;$k<count($tags2);$k++)
                                                            @if($tags2[$k] == $gc->slug) selected @endif
                                                        @endfor
                                                        @endif
                                                    >{{ $gc->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small>To specify other tags, Type a tag name
                                            and press enter
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6 m-b-20">
                                    <div class="form-group m-t-10">
                                        <?php
                                        $tags3 = explode(',',$product->garment_type);
                                        ?>
                                        <label class="form-label">Garment type<span class="red">*</span></label>
                                        <select class="select" multiple="multiple"
                                                id="garment_type"
                                                name="garment_type[]" style="width: 100%;">
                                            @if($garmentType->count() > 0)
                                                @foreach($garmentType as $gt)
                                                    <option value="{{ $gt->slug }}"
                                                            @if(count($tags3) > 0)
                                                            @for($l=0;$l<count($tags3);$l++)
                                                            @if($tags3[$l] == $gt->slug) selected @endif
                                                        @endfor
                                                        @endif
                                                    >{{ $gt->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small>To specify other tags, Type a tag name
                                            and press enter
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6 m-b-20">
                                    <div class="form-group m-t-10">
                                        <?php
                                        $tags1 = explode(',',$product->shoulder_construction);
                                        ?>
                                        <label class="form-label">Shoulder construction<span class="red">*</span></label>
                                        <select class="select" multiple="multiple" id="shoulder_construction" name="shoulder_construction[]" style="width: 100%;">
                                            @if($shoulderConstruction->count() > 0)
                                                @foreach($shoulderConstruction as $sc)
                                                    <option value="{{ $sc->slug }}"
                                                            @if(count($tags1) > 0)
                                                            @for($j=0;$j<count($tags1);$j++)
                                                            @if($tags1[$j] == $sc->slug) selected @endif
                                                        @endfor
                                                        @endif
                                                    >{{ $sc->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small>To specify other tags, Type a tag name
                                            and press enter
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6 m-b-20">
                                    <label class="form-label">Sizes</label>
                                    <input type="text" class="form-control" id="sizes" name="sizes"
                                           placeholder="Enter sizes" value="{{ $product->sizes }}">
                                    <small>Enter multiple values by comma seperated.</small>
                                </div>

                            </div>
                        </div>
                    </div>


                <!-- section 2 ends here-->

                <!-- section 3 starts here -->
                <div class="row theme-row m-b-10">
                    <div class="card-header accordion col-lg-12"
                         data-toggle="collapse" data-target="#sectionYarn">
                        <h5 class="card-header-text">Designer recommendations</h5>
                        <i class="fa fa-caret-down pull-right micro-icons"></i>
                    </div>

                </div>
                <div class="custom-card-block collapse row" id="sectionYarn">
                    <div class="col-md-12 form-group " id="yarnDetails">
                        @if($product->yarnRecommmendations()->count() > 0)
                            <?php $y=0; ?>
                            @foreach($product->yarnRecommmendations as $yarns)
                                <div class="form-group row m-b-zero yarnRows" id="yarn-row-{{$yarns->id}}">
                                    <input type="hidden" name="product_yarn_recommendations_id[]" value="{{ $yarns->id }}">
                                    @if($y == 0)
                                        <div class="col-lg-10 row-bg">
                                            <h6 class="m-t-5">Yarn</h6>
                                        </div>
                                        <div class="col-lg-2 row-bg">
                                        </div>
                                    @else
                                        <div class="col-lg-10 row-bg">
                                            <h6 class="m-t-5">Yarn</h6>
                                        </div>
                                        <div class="col-lg-2 row-bg">
                                            <a href="javascript:;" class="pull-right fa fa-trash deleteYarndetails"  title="Delete yarn details" data-id="{{$yarns->id}}" id="deleteYarndetails{{$yarns->id}}" data-server="true"></a>
                                        </div>
                                    @endif
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
                                                    <input type="text" class="form-control" id="yarn_company" name="yarn_company[]" placeholder="Enter name of yarn company" value="{{ $yarns->yarn_company }}">
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
                                                    <input type="text" class="form-control" id="yarn_name" name="yarn_name[]"  placeholder="Enter yarn name" value="{{ $yarns->yarn_name }}">
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
                                                    <input type="text" class="form-control" id="fiber_type" name="fiber_type[]" placeholder="Enter fiber type" value="{{ $yarns->fiber_type }}">
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
                                                                <option value="{{ $yw->slug }}" @if($yw->slug == $yarns->yarn_weight) selected @endif >{{ $yw->name }}</option>
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
                                                    <input type="text" class="form-control" id="yarn_url" name="yarn_url[]" placeholder="https://knitfitco.com" value="{{ $yarns->yarn_url }}">
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
                                                    <input type="text" class="form-control" id="coupon_code" name="coupon_code[]" placeholder="Enter coupon code" value="{{ $yarns->coupon_code }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- image uploads design -->
                                    @if($yarns->yarnImages()->count() > 0)
                                        <div class="col-md-12">
                                            <div class="row">
                                                @foreach($yarns->yarnImages as $yarnImage)
                                                    <div class="col-lg-2 m-b-10" id="yarnRecommendationImages{{$yarnImage->id}}">
                                                        <div class="img-hover" style="background-image: url({{ $yarnImage->yarn_image }});
                                                            background-size: cover;height: 220px;">
                                                            <div class="editable-items">
                                                                <!--<i class="fa fa-star" data-toggle="modal" data-dismiss="modal" data-target="#delete-Modal"></i> -->
                                                                <a href="javascript:;" class="fa fa-trash deleteYarnImage" data-server="true" data-id="{{ $yarnImage->id }}"></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                @endif                        <!--image uploads design -->
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-block">
                                                <input type="file" class="filer_input" name="yarn_image[]" id="filer_input{{$y}}" multiple="multiple">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php $y++; ?>
                            @endforeach
                        @else
                            <div class="form-group row m-b-zero yarnRows" id="yarn-row-1">
                                <div class="col-lg-12 row-bg">
                                    <h6 class="m-t-5">Yarn</h6>
                                </div>
                                <div class="col-md-4">
                                    <input type="hidden" name="product_yarn_recommendations_id[]" value="0">
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
                                                <input type="text" class="form-control" id="yarn_name" name="yarn_name[]" value="" placeholder="Enter yarn name" >
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
                                                <input type="text" class="form-control" id="yarn_url" name="yarn_url[]" placeholder="https://knitfitco.com">
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
                        @endif
                    </div>

                    <div class="text-center">
                        <button type="button" id="addYarnDetails" class="btn btn-sm add-yarn-custom f-12 theme-outline-btn btn-primary waves-effect waves-light"><i class="icofont icofont-plus f-12"></i>Add yarn</button>
                    </div>


                    <br>

                    <!-- Gauge & ease-->

                    <div class="col-md-12 form-group m-b-zero" id="needle-row-custom">
                        <div class="col-lg-12 row-bg">
                            <h6 class="m-b-10">Gauge & ease</h6>
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
                                </div>

                                    <br>

                                    <div class="col-md-12 form-group row">
                                        <div class="col-md-6">
                                            <div class="form-radio m-b-10">
                                                <h6 class="text-muted m-b-10">Unit of measurement</h6>

                                                <div class="radio radio-inline m-r-10">
                                                    <label>
                                                        <input type="radio" id="inches-custom" name="radio_inches" checked="checked" class="custom-control-input">
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
                                                        <option value="{{$gc2->id}}" {{ ($gc2->id ==
                                    $product->recommended_stitch_gauge_in) ? 'selected' : '' }}
                                                        >{{$gc2->row_gauge_inch .' / 1 inches'}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Row gauge<span class="red">*</span>
                                                </label>
                                                <select class="form-control" id="row_gauge_in" name="row_gauge_in">
                                                    <option value="">Select value (inches)</option>
                                                    @foreach($gaugeconversion as $gc2)
                                                        <option value="{{$gc2->id}}" {{ ($gc2->id ==
                                    $product->recommended_row_gauge_in) ? 'selected' : '' }}
                                                        >{{$gc2->row_gauge_inch .' / 1 inches'}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Ease preference<span class="red">*</span>
                                                </label>
                                                <select class="form-control" id="ease_in" name="ease_in">
                                                    <option value="">Select value (inches)</option>
                                                    @for($j=-2;$j<= 20;$j+= 0.25)
                                                        <option value="{{$j}}" {{ ($j ==
                                    $product->designer_recommended_ease_in) ? 'selected' : '' }}>{{$j}}"</option>
                                                    @endfor
                                                </select>
                                            </div>

                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-radio m-b-10">
                                                <h6 class="text-muted m-b-10">Unit of measurement</h6>
                                                <div class="radio radio-inline">
                                                    <label>
                                                        <input type="radio" id="cm-custom" name="radio_cm" checked="checked" class="custom-control-input" id="cm">
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
                                                        <option value="{{$gc3->id}}" {{ ($gc3->id ==
                                    $product->recommended_stitch_gauge_cm) ? 'selected' : '' }}>{{$gc3->rows_10_cm
                                    .' / 10cm'}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Row gauge<span class="red">*</span>
                                                </label>
                                                <select class="form-control" id="row_gauge_cm" name="row_gauge_cm">
                                                    <option value="">Select value (cm)</option>
                                                    @foreach($gaugeconversion as $gc3)
                                                        <option value="{{$gc3->id}}" {{ ($gc3->id ==
                                    $product->recommended_row_gauge_cm) ? 'selected' : '' }}>{{$gc3->rows_10_cm
                                    .' / 10cm'}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Ease preference<span class="red">*</span>
                                                </label>
                                                <select class="form-control" id="ease_cm" name="ease_cm">
                                                    <option value="">Select value (cm)</option>
                                                    @for($i=-5;$i <= 20;$i+= 0.5)
                                                        <option value="{{$i}}" {{ ($i ==
                                    $product->designer_recommended_ease_cm) ? 'selected' : '' }}>{{$i}} cm</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <div class="row form-group m-b-zero">
                                <div class="col-md-6 m-b-20">
                                    <label class="form-label">Finished meaurements
                                    </label>
                                    <input type="text" class="form-control" name="finished_measurements" id="finished_measurements" value="{{ $product->finished_measurements }}">
                                    <span class="small-text">Enter the finished measurements of the garment</span>
                                </div>
                            </div>


                            <div class="row form-group m-b-zero">
                                <div class="col-lg-8 row-bg">
                                    <h6 class="m-b-10">Yarn Quantities</h6>
                                </div>
                                <div class="col-lg-4 text-right row-bg">
                                    <button type="button" class="btn small-btn add-needle-custom f-12 theme-outline-btn btn-primary waves-effect waves-light" id="addYarnQuantity"><i class="icofont icofont-plus f-12"></i>Add yarn quantities</button>
                                </div>
                                <div class="row col-lg-12" id="yanQuantitiesDiv">
                                    @if($product->yarnQuantities()->count() > 0)
                                        <?php $yaq = 0; ?>
                                        @foreach($product->yarnQuantities as $yq)
                                <div class="col-md-4 m-b-20 allYanq" id="yarnq{{$yaq}}">
                                    <label class="col-form-label">Yarn Quantities
                                    </label>
                                    <input type="hidden" name="yarn_quantity_id[]" value="{{ $yq->id }}">
                                    <input type="text" name="yarn_quantity[]" class="form-control" placeholder="Yarn quantity" value="{{ $yq->yarn_quantity }}">
                                    <span class="small-text">Enter the estimated amount of yarn required for the pattern</span>
                                    @if($yaq > 0)
                                        <a href="javascript:;" class="fa fa-trash deleteYarnq" data-server="true" id="deleteYarnq{{$yq->id}}" data-id="{{$yq->id}}" style="position: absolute;top: 9px;right: 0px;"></a>
                                    @endif
                                </div>
                                            <?php $yaq++; ?>
                                        @endforeach
                                    @else
                                        <div class="col-md-4 m-b-20 allYanq" id="yarnq0">
                                            <label class="">Yarn Quantities
                                            </label>
                                            <input type="hidden" name="yarn_quantity_id[]" value="0">
                                            <input type="text" name="yarn_quantity[]" class="form-control" placeholder="Yarn quantity">
                                            <span class="small-text">Enter the estimated amount of yarn required for the pattern</span>

                                        </div>
                                    @endif

                                </div>

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
                                    @if($product->needles()->count() > 0)
                                        <?php $n = 0; ?>
                                        @foreach($product->needles as $needle)
                                            <div class="col-md-4 allNeedles" id="needle{{$needle->id}}">
                                                <input type="hidden" name="needle_size_id[]" value="{{ $needle->id }}" />
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        Needle size used
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

                                                            <select class="form-control" id="needle_size" name="needle_size[]">
                                                                <option selected>Select needle size</option>
                                                                @if($needlesizes->count() > 0)
                                                                    @foreach($needlesizes as $ns)
                                                                        <option value="{{ $ns->id }}" {{ ($ns->id == $needle->needle_size) ? 'selected' : '' }}>US {{ $ns->us_size }} - {{ $ns->mm_size }} mm</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            @if($n > 0)
                                                                <a href="javascript:;" class="fa fa-trash deleteNeedles" data-server="true" id="deleteNeedles{{$needle->id}}" data-id="{{$needle->id}}" style="position: absolute;top: 9px;right: 0px;"></a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $n++; ?>
                                        @endforeach
                                    @else
                                        <div class="col-md-4 allNeedles" id="needle0">
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Needle size used
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
                                                        <input type="hidden" name="needle_size_id[]" value="0">
                                                        <select class="form-control col-md-10" id="needle_size" name="needle_size[]">
                                                            <option selected>Select needle size</option>
                                                            @if($needlesizes->count() > 0)
                                                                @foreach($needlesizes as $ns)
                                                                    <option value="{{ $ns->id }}">US {{ $ns->us_size }} - {{ $ns->mm_size }} mm</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>



                            </div>
                        </div>
                    </div>

                <!-- section 3 ends here -->
                <!-- section 4 starts here -->

                <div class="row theme-row m-b-10">
                    <div class="card-header accordion col-lg-12"
                         data-toggle="collapse" data-target="#section10">
                        <h5 class="card-header-text">Upload pattern images</h5>
                        <i class="fa fa-caret-down pull-right micro-icons"></i>
                    </div>
                </div>

                <div class="card-block collapse" id="section10">
                    <div class="card">
                        <div class="card-header">
                            <h5>Upload pattern images <span class="required">*</span></h5>
                            <span class="small-text">Add individual images of your design to show off the finished garment! The recommended image sizes are: 400 X 700 pixels minimum to 2000 X 3500 pixels maximum</span>
                        </div>
                        <div class="card-block">
                            <!-- <div class="sub-title">Example 1</div> -->
                            <input type="file" name="product_images[]" id="product_images" multiple="multiple">
                        </div>

                        <div class="row">
                            @if($product->patternImages()->count() > 0)
                                @foreach($product->patternImages as $images)
                                    <div class="col-lg-2 m-b-10 patternImages" id="patternImage{{$images->id}}">
                                        <div class="img-hover" style="background-image: url({{ $images->image_small }});background-size: cover;
                                            height: 220px;">
                                            <div class="editable-items">
                                                <a class="fa @if($images->main_photo == 0) fa-star-o @else fa-star @endif primaryImage" id="primaryImage{{$images->id}}" href="javascript:;" data-id="{{ $images->id }}" data-server="true" data-mainPhoto="{{ $images->main_photo }}"></a>
                                                <a class="fa fa-trash deleteImage" data-server="true" href="javascript:;" data-id="{{ $images->id }}"></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!-- section 4 ends here -->
				
				<!-- section 4 starts here -->

                <div class="row theme-row m-b-10">
                    <div class="card-header accordion col-lg-12"
                         data-toggle="collapse" data-target="#section102">
                        <h5 class="card-header-text">Upload reference images</h5>
                        <i class="fa fa-caret-down pull-right micro-icons"></i>
                    </div>
                </div>

                <div class="card-block collapse" id="section102">
                    <div class="card">
                        <div class="row">
                            @if($product->referenceImages()->count() > 0)
                                @foreach($product->referenceImages as $refimages)
                                    <div class="col-lg-2 m-b-10 patternImages"
                                         id="patternRefImage{{$refimages->id}}">
                                        <div class="img-hover" style="background-image: url({{ $refimages->image }});background-size: cover;
                                            height: 220px;">
                                            <div class="editable-items">
                                                <a class="fa fa-trash deleteRefImage" data-server="true"
                                                   href="javascript:;" data-id="{{ $refimages->id }}"></a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="card-header">
                            <h5>Upload reference images <span class="required">*</span></h5>
                            <span class="small-text">Add individual images of your design to show off the finished garment!</span>
                        </div>
                        <div class="card-block">
                            <input type="file" class="filer_input1" name="reference_images[]" id="reference_images" multiple="multiple">
                            <!--<span class="small-text">This should be a .doc or text-only file, not your pattern pdf. It should only contain text.</span>-->
                        </div>
                    </div>
                </div>
                <!-- section 4 ends here -->

                <!-- section 6 starts here -->
                <div class="row theme-row m-b-10">
                    <div class="card-header accordion col-lg-12"
                         data-toggle="collapse" data-target="#section6">
                        <h5 class="card-header-text">Upload pattern instruction file (DOC, DOCX)</h5>
                        <i class="fa fa-caret-down pull-right micro-icons"></i>
                    </div>

                </div>
                <div class="card-block collapse" id="section6">
                    @php
                    $productDocx = $product->patternInstructions()->where('type','!=','pdf')->get()
                    @endphp
                    @if($productDocx->count() > 0)
                        @foreach($productDocx as $docsImages)
                            <div class="col-lg-1 m-b-10 patterndDocImages" id="patternDocImage{{$docsImages->id}}" style="border:1px solid #bababa;border-radius: 5px;padding: 10px;">
                                <div class="img-hover">
                                    <a href="{{$docsImages->instructions_file}}" target="_blank">
                                        <div class="jFiler-item-thumb-image">
                                            <span class="jFiler-icon-file f-file f-file-ext-docx" style="background-color: rgb(64, 144, 36);">.docx</span>
                                        </div>
                                    </a>
                                    <div class="editable-items">
                                        <a class="fa fa-trash deleteRefImage" data-server="true"
                                           href="javascript:;" data-id="{{ $docsImages->id }}"></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h5>Upload pattern instructions file <span class="required">*</span></h5>
                            <span class="small-text">This is a file containing text instructions and needs to be in an editable format (doc or docx not pdf). Note: file names must be different.</span>
                        </div>
                        <div class="card-block">
                            <!-- <div class="sub-title">Example 1</div> -->
                            <input type="file" name="instruction_file[]" data-jfiler-extensions="doc,docx" id="filer_input3" multiple="multiple">
                            <!--<span class="small-text">This should be a .doc or text-only file, not your pattern pdf. It should only contain text.</span>-->
                        </div>
                    </div>
                </div>
                <!-- section 6 ends here -->

                <!-- section 5 starts here -->
                <div class="row theme-row m-b-10">
                    <div class="card-header accordion col-lg-12"
                         data-toggle="collapse" data-target="#section8">
                        <h5 class="card-header-text">Upload pattern PDF </h5>
                        <i class="fa fa-caret-down pull-right micro-icons"></i>
                    </div>

                </div>
                <div class="card-block collapse" id="section8">
                    @php
                        $productPdf = $product->patternInstructions()->where('type','=','pdf')->get()
                    @endphp
                    @if($productPdf->count() > 0)
                        @foreach($productPdf as $pdfImages)
                            <div class="col-lg-1 m-b-10 patternPdfImages" id="patternPdfImage{{$pdfImages->id}}" style="border:1px solid #bababa;border-radius: 5px;padding: 10px;">
                                <div class="img-hover">
                                    <a href="{{$pdfImages->instructions_file}}" target="_blank">
                                        <div class="jFiler-item-thumb-image">
                                            <span class="jFiler-icon-file f-file f-file-ext-pdf" style="background-color: rgb(242, 60, 15);">.pdf</span>
                                        </div>
                                    </a>
                                    <div class="editable-items">
                                        <a class="fa fa-trash deleteRefImage" data-server="true"
                                           href="javascript:;" data-id="{{ $pdfImages->id }}"></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h5>Upload pattern PDF <span class="required">*</span></h5>
                            <span class="small-text">This is for our reference as to the order of text and images. We will be using the actual text and images provided above to create the mobile optimized pattern. Note: patterns are mobile optimized and will not be displayed exactly as the PDF.</span>
                        </div>
                        <div class="card-block">
                            <!-- <div class="sub-title">Example 1</div> -->
                            <input type="file" name="instruction_file[]" data-jfiler-extensions="pdf" id="filer_input5" multiple="multiple">
                            <!--<span class="small-text">This should be a .doc or text-only file, not your pattern pdf. It should only contain text.</span>-->
                        </div>
                    </div>
                </div>
                <!-- section 5 ends here -->

                <!-- section 6 starts here -->
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
                            <input type="text" name="product_price" id="product_price"
                                   class="form-control" placeholder="Enter price" min="0" value="{{
               $product->price }}">
                        </div>

                        <div class="form-group col-md-4 m-b-20">
                            <label class="form-label">Sale Price
                            </label>
                            <input type="text" name="sale_price" id="sale_price" class="form-control"
                                   placeholder="Enter sale price" value="{{
               $product->sale_price }}">
                        </div>

                        <div class="form-group col-md-4 m-b-20">
                            <label class="form-label m-b-0">Sale Price Start Date</label>
                            <input type="text" name="sale_price_start_date" id="sale_price_start_date"
                                   class="form-control" readonly placeholder="Select sale price start
               date" value="{{ date('m/d/Y',strtotime($product->sale_price_start_date)) }}">
                        </div>

                        <div class="form-group col-md-4 m-b-20">
                            <label class="form-label">Sale Price End Date
                            </label>
                            <input type="text" name="sale_price_end_date" id="sale_price_end_date"
                                   class="form-control" readonly placeholder="Select sale price end date"
                                   value="{{ date('m/d/Y',strtotime($product->sale_price_end_date)) }}">
                        </div>


                        <div class="from-group col-md-12">
                            <div class="col-lg-12">
                                <div class="col-form-label">
                                    Can we share the news about your pattern on social media in email marketing?
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input type="radio" value="yes" name="email_marketing" @if($product->email_marketing == 'yes') checked @endif >
                                        <span class="cr">
                                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                                        </span>
                                        <span>Yes</span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkbox-fade fade-in-primary">
                                    <label>
                                        <input type="radio" value="no" name="email_marketing" @if($product->email_marketing == 'no') checked @endif >
                                        <span class="cr">
                                            <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                         </span>
                                        <span>No</span>
                                    </label>
                                </div>
                            </div>
                            <span class="small-text m-l-10">We will announce the new pattern and share photos from the pattern with our following to help you reach more knitters.</span>
                        </div>

                    </div>
                </div>
                <!-- section 6 ends here -->

                <div class="form-group m-t-20">
                    <div class="col-sm-12 text-center">
                
            
                <button type="submit" class="btn theme-btn" >Submit pattern for review</button>

                &nbsp; 
                @if($status5 || $status6)
                <a href="javascript:;" class="btn theme-btn btn-primary waves-effect waves-light m-l-10" id="next-step2">Next</a>
                @endif
                    </div>
                </div>

                </div>





            </div>
        </div>
    </div>

<div class="tab-pane" id="pattern-preview" role="tabpanel">
    @if($pdf)
        {!! $pdf->content !!}
    @endif

    <br>
    
    <button class="btn theme-btn btn-warning waves-effect waves-light m-l-10 changePatternStatus" data-id="6">Approve for release </button>
   
</div>


</div>



<!--Section for Pattern instruction Starts here-->

</form>
</div>
</div>
</div>
</div>
</div>
<!-- To Do Card List card end -->
</div>
@endsection
@section('footerscript')
<script type="text/javascript">
var URL = '{{url("designer/upload-pattern-images")}}';
var URL1 = '{{url("designer/remove-pattern-images")}}';

var URL2 = '{{url("designer/upload-designer-recomondation-images")}}';
var URL3 = '{{url("designer/remove-designer-recomondation-images")}}';

var URL4 = '{{url("designer/upload-patternInstrctionsFile")}}';
var URL5 = '{{url("designer/remove-designer-recomondation-images")}}';

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
#price{border: 1px solid #ccc;}
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
#preview-btn{bottom: 10px;position: fixed;float: right;right: 10px;z-index: 999;}
.preview{overflow-y: scroll;max-height: 100vh;}
::-webkit-input-placeholder { /* Chrome/Opera/Safari */
font-size: 12px;
}
::-moz-placeholder { /* Firefox 19+ */
font-size: 12px;
}
:-ms-input-placeholder { /* IE 10+ */
font-size: 12px;
}
:-moz-placeholder { /* Firefox 18- */
font-size: 12px;
}
.required{display: contents!important;color: red;}
.disabled{cursor:not-allowed;opacity: .4;}
.delete-row {
top: 12px!important;
right: 10px!important;
}
.help-block{
color: red;
}
.jFiler-item-thumb-image img{
top: 0px !important;
position: absolute !important;
left: 0px !important;
}
.fa-file-pdf-o{
font-size: 8em;
color: #ec3c3c;
}
.img-hover:hover fa-file-pdf-o{
color: #f49a9a !important;
}
.editable-items a{
color: black;
}
.yarnRows{
border: 1px solid #dddddd;
border-radius: 4px;
padding: 10px;
margin: 4px;
margin-bottom: 20px;
}
.btn.btn-icon-tab {
border-radius: 50%;
width: 22px;
line-height: 12px;
height: 22px;
padding: 3px;
text-align: center;
font-size: 13px;
margin-right: 6px;
}
</style>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
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
<script src="{{ asset('resources/assets/files/assets/pages/filer/product-reference-images.init.js')}}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

<script>
$(function (){
//patternImages('product_images',URL,URL1);
//jqueryFiler('filer_input0',URL2,URL3,0);
var yarnRows = $(".yarnRows");
for (var i=0;i<yarnRows.length;i++){
jqueryFiler('filer_input'+i,URL2,URL3,i);
}

patternImages('product_images',URL,URL1);
jqueryFilerReferenceImages("reference_images",URL,URL1);
jqueryFilerInstructionsDocFile('filer_input3',URL4,URL5);
jqueryFilerInstructionsPdfFile('filer_input5',URL4,URL5);

$(".nav-tab1,.nav-tab3").find("a").prop("disabled", true);
$('.nav-tab1 a,.nav-tab3 a').css('cursor', 'not-allowed');
$('.nav-tab1 a,.nav-tab3 a').css('opacity', '.5');


$("#next-step1").click(function() {
$('#basic-p-details,#pattern-preview').removeClass('active show');
$('#P-details').addClass('active show');
$('.nav-tab1 a,.nav-tab3 a').removeClass('active show');
$('.nav-tab2 a').addClass('active show');
$('.nav-tab2 a').css('cursor', 'pointer');
$('.nav-tab2 a').css('opacity', '1');
$("#tab-no2").html('<i class="fa fa-check"></i>');
$(".nav-tab2").find("a").prop("disabled", false);
});
$("#next-step2").click(function(){
$('#P-details,#Measurements').removeClass('active show');
$('#pattern-preview').addClass('active show');
$('.nav-tab1 a,.nav-tab2 a').removeClass('active show');
$('.nav-tab3 a').addClass('active show');
$('.nav-tab3 a').css('cursor', 'pointer');
$('.nav-tab3 a').css('opacity', '1');
$("#tab-no2").html('<i class="fa fa-check"></i>');
$(".nav-tab3").find("a").prop("disabled", false);
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

$("#design_elements").select2({
placeholder: "Enter tags",
allowClear: true,
tags: true
});

$("#designer_name").select2({
placeholder: "Select designer name",
allowClear: true
});

$("#garment_construction").select2({
placeholder: "Enter tags",
allowClear: true,
tags: true
});

$("#garment_type").select2({
placeholder: "Enter tags",
allowClear: true,
tags: true
});

$("#shoulder_construction").select2({
placeholder: "Enter tags",
allowClear: true,
tags: true
});

$(document).on('click','#addYarnDetails',function() {
var $rows = $(".yarnRows");
var rowId = $rows.length;
var prevRowId = $rows.length - 1;
var $template = '<div class="form-group row m-b-zero yarnRows" id="yarn-row-' + rowId + '"> <div class="col-lg-10 row-bg"> <h6 class="m-t-5">Yarn </h6> </div><div class="col-lg-2 row-bg"> <a href="javascript:;" class="pull-right fa fa-trash deleteYarndetails"  title="Delete yarn details" data-id="' + rowId + '" id="deleteYarndetails' + rowId + '" data-server="false"></a> </div><div class="col-md-4"> <div class="form-group"> <label class="form-label">Yarn company <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Enter the name of Yarn company.</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <input type="hidden" name="product_yarn_recommendations_id[]" value="0"> <input type="text" class="form-control" id="yarn_company" name="yarn_company[]" value="" placeholder="Enter name of yarn company"> </div></div></div></div><div class="col-md-4"> <div class="form-group"> <label class="form-label"> Yarn name <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Enter the yarn you used for this pattern.</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <input type="text" class="form-control" id="yarn_name" name="yarn_name[]" value="" placeholder="Enter yarn name" "> </div></div></div></div><div class="col-md-4"> <div class="form-group"> <label class="form-label"> Fiber type <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Enter the fiber content of the yarns used.</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <input type="text" class="form-control" id="fiber_type" name="fiber_type[]" value="" placeholder="Enter fiber type"> </div></div></div></div><div class="col-lg-4"> <div class="form-group"> <label class="form-label"> Yarn weight <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Select the yarn weight from the dropdown.</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <select class="form-control" id="yarn_weight" name="yarn_weight[]"> <option value="">Select yarn weight</option> @if($yarnWeight->count() > 0) @foreach($yarnWeight as $yw) <option value="{{ $yw->slug }}">{{ $yw->name }}</option> @endforeach @endif </select> </div></div></div></div><div class="col-md-4"> <div class="form-group"> <label class="form-label"> Shop URL <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Please enter URL</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <input type="text" class="form-control" id="yarn_url" name="yarn_url[]" placeholder="https://knitfitco.com"> </div></div></div></div><div class="col-md-4"> <div class="form-group"> <label class="form-label"> Coupon code <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Please enter Coupon code</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <input type="text" class="form-control" id="coupon_code" name="coupon_code[]" placeholder="Enter coupon code"> </div></div></div></div><div class="col-md-12"> <div class="card"> <div class="card-header"> <h5>Upload files here</h5> </div><div class="card-block"> <input type="file" class="filer_input" name="yarn_image[]" id="filer_input'+rowId+'" multiple="multiple"> </div></div></div></div>';

//$validations.data('bootstrapValidator').addField($(this));
$("#yarnDetails").append($template);
$("#deleteYarndetails"+prevRowId).removeClass('fa-trash');
setTimeout(function (){ jqueryFiler('filer_input'+rowId,URL2,URL3,rowId); },1000);
});



$(document).on('click','#addNeedles',function(){
var $rows = $(".allNeedles");
var rowId = $rows.length + 1;
var prevRowId = $rows.length;
var $template = '<div class="col-md-4 allNeedles" id="needle'+rowId+'"> <div class="form-group"> <label class="form-label">Needle size used <span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <span class="tooltip-text" style="width: 100%;">Select the needle size from the dropdown.</span> </span> </span> </label> <div class="row"> <div class="col-md-12"> <input type="hidden" name="needle_size_id[]" value="0"> <select class="form-control col-md-12" id="needle_size" name="needle_size[]"> <option selected>Select needle size</option> @if($needlesizes->count() > 0) @foreach($needlesizes as $ns) <option value="{{ $ns->id }}">US {{ $ns->us_size }} - {{ $ns->mm_size }} mm</option> @endforeach @endif  </select> <a href="javascript:;" class="fa fa-trash deleteNeedles" data-server="false" id="deleteNeedles'+rowId+'" data-id="'+rowId+'" style="position: absolute;top: 9px;right: 0px;"></a> </div></div></div></div>';
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
if(server == 'true'){
$.get('{{ url("designer/delete-needles")  }}/'+id,function (res){
    $("#needle"+id).remove();
});
}else{
$("#needle"+id).remove();
}
if(prevRowId != 0){
$("#deleteNeedles"+prevRowId).addClass('fa-trash');
}
}
});


$(document).on('click','#addYarnQuantity',function(){
var $rows = $(".allYanq");
var rowId = $rows.length + 1;
var prevRowId = $rows.length;
var $template = '<div class="col-md-4 allYanq" id="yarnq'+rowId+'"> <div class="form-group"> <label class="form-label">Yarn Quantities </label> <div class="row"> <div class="col-md-12"><input type="hidden" name="yarn_quantity_id[]" value="0"> <input type="text" class="form-control" placeholder="Yarn quantity" name="yarn_quantity[]"><span class="small-text">Enter the estimated amount of yarn required for the pattern</span> <a href="javascript:;" class="fa fa-trash deleteYarnq" data-server="false" id="deleteYarnq'+rowId+'" data-id="'+rowId+'" style="position: absolute;top: 9px;right: 0px;"></a> </div></div></div></div>';
$("#yanQuantitiesDiv").append($template);
$("#deleteYarnq"+prevRowId).removeClass('fa-trash');
});

$(document).on('click','.deleteYarnq',function(){
var id = $(this).attr('data-id');
var $rows = $(".allYanq");
var rowId = $rows.length + 1;
var prevRowId = $rows.length - 1;
var server = $(this).attr('data-server');

if(confirm('Are you sure want to delete this ?')){
if(server == true){
$.get('{{ url("/")  }}',function (res){

});
}else{
$("#yarnq"+id).remove();
}
if(prevRowId != 0){
$("#deleteYarnq"+prevRowId).addClass('fa-trash');
}
}
});


var $validations = $('#update-pattern');
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
brand_name: {
message: 'The brand name name is not valid',
validators: {
    notEmpty: {
        message: 'The brand name is required..'
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
'design_elements[]': {
message: 'The design elements is not valid',
validators: {
    notEmpty: {
        message: 'The design elements is required.'
    }
}
},
'garment_construction[]': {
message: 'The construction technique is not valid',
validators: {
    notEmpty: {
        message: 'The construction technique is required.'
    }
}
},
'garment_type[]': {
message: 'The garment type is not valid',
validators: {
    notEmpty: {
        message: 'The garment type is required.'
    }
}
},
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
}

}
}).on('status.field.bv', function(e, data) {
data.bv.disableSubmitButtons(false);
}).on('error.field.bv', function(e, data) {
console.log(data);
}).on('success.form.bv', function(e,data) {
e.preventDefault();
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
notification('fa-check','Yay..','Pattern updated successfully. We will notify you once your pattern approved.','success');
setTimeout(function(){ window.location.assign('{{ url("designer/my-patterns") }}') },4000);
}else{
    $(".loading,.loader-bg").hide();
notification('fa-times','Oops..','There are few errors in the form, Please refresh and try again.','danger');
}
}, 'json');
});

$(document).on('click','.deleteRefImage',function(){
var id = $(this).attr('data-id');
var server = $(this).attr('data-server');

Swal.fire({
title: 'Are you sure?',
text: "You won't be able to revert this!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.value) {
if(server){
    $(".loading").show();
    $.get('{{ url("designer/delete-pattern-reference-image")  }}/'+id,function (res){
        if(res.status == 'success'){
            $("#patternRefImage"+id).remove();
            notification('fa-check','success','Pattern image deleted successfully..','success');
            $(".loading").hide();
        }else{
            $(".loading").hide();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Try again after some time.',
            })
        }
    });
}else{
    $(".loading").hide();
    $("#patternRefImage"+id).remove();
}
}
})
});

$(document).on('click','.deleteImage',function(){
var id = $(this).attr('data-id');
var server = $(this).attr('data-server');

Swal.fire({
title: 'Are you sure?',
text: "You won't be able to revert this!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.value) {
if(server){
    $(".loading").show();
    $.get('{{ url("designer/delete-pattern-image")  }}/'+id,function (res){
        if(res.status == 'success'){
            $("#patternImage"+id).remove();
            notification('fa-check','success','Pattern image deleted successfully..','success');
            $(".loading").hide();
        }else{
            $(".loading").hide();
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Try again after some time.',
            })
        }
    });
}else{
    $(".loading").hide();
    $("#patternImage"+id).remove();
}
}
})
});

$(document).on('click','.deleteYarndetails',function() {
var id = $(this).attr('data-id');
var $rows = $(".yarnRows");
var rowId = $rows.length + 1;
var prevRowId = $rows.length - 1;
var server = $(this).attr('data-server');

if(confirm('Are you sure want to delete this ?')){
if(server == 'true'){
$.get('{{ url("designer/delete-yarn")  }}/'+id,function (res){
    $("#yarn-row-"+id).remove();
});
}else{
$("#yarn-row-"+id).remove();
}
if(prevRowId != 0){
$("#deleteYarndetails"+prevRowId).addClass('fa-trash');
}
}
});


$(document).on('click','.deleteYarnImage',function(){
var id = $(this).attr('data-id');
var server = $(this).attr('data-server');

Swal.fire({
title: 'Are you sure?',
text: "You won't be able to revert this!",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.value) {
if(server){
    $.get('{{ url("designer/delete-yarn-image")  }}/'+id,function (res){
        if(res.status == 'success'){
            $("#yarnRecommendationImages-"+id).remove();
            notification('fa-check','success','Yarn image removed successfully..','success');
        }else{
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong! Try again after some time.',
            })
        }
    });
}else{
    $("#yarnRecommendationImages"+id).remove();
}
}
})

});

$(document).on('click','.changePatternStatus',function(){
var product_id = $("#product_id").val();

$.get('{{url("designer/change-pattern-status")}}/'+product_id,function(res){
notification('fa-check','Yay..','Your pattern successfully made live','success');
});
});

});

function validateDescription(id){
$('#update-pattern').data('bootstrapValidator').revalidateField(id);
}
function ucfirst(str,force){
str=force ? str.toLowerCase() : str;
return str.replace(/(\b)([a-zA-Z])/,
function(firstLetter){
return   firstLetter.toUpperCase();
});
}
</script>
@endsection
