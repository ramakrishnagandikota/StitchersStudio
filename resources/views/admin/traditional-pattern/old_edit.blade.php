@extends('layouts.admin')
@section('breadcrum')
    <div class="col-md-12 col-12 align-self-center">
        <h3 class="text-themecolor">Add Pattern</h3>
        <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Add traditional pattern</li>
        </ol>
    </div>
@endsection

@section('section1')
    <div class="card col-md-12 col-lg-12 col-xlg-12 col-sm-12 col-xs-12">
        <div class="row">

            <form class="form-horizontal" id="create-pattern" action="{{ route('admin.update.traditional.pattern') }}"
                  method="post" style="width: 100%;">
                @csrf
                <input type="hidden" name="pattern_type" value="traditional">
                <input type="hidden" id="product_id" name="product_id" value="{{ encrypt($product->id) }}" />
                <div id="accordion2" class="accordion" role="tablist" aria-multiselectable="true" style="width: 100%;">

                    <div class="card">
                        <div class="card-header" role="tab" id="headingOne">
                            <h5 class="mb-0">
                                <a data-toggle="collapse" data-parent="#accordion2" href="#collapse1" aria-expanded="true" aria-controls="collapseOne">
                                    Enter pattern details
                                </a>
                            </h5>
                        </div>
                        <div id="collapse1" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-4 m-b-20">
                                        <label class="form-label">SKU<span class="red">*</span>
                                        </label>
                                        <input type="text" name="sku" id="sku" class="form-control" value="{{
                                        $product->sku }}"
                                        readonly >
                                    </div>

                                    <div class="col-md-4 m-b-20">
                                        <label class="form-label">Pattern GoLive Date<span class="red">*</span>
                                        </label>
                                        <input type="text" name="pattern_go_live_date" readonly placeholder="Please
                                        select date" id="pattern_go_live_date" class="form-control" value="{{date
                                        ('m/d/Y',strtotime($product->product_go_live_date))}}" >
                                    </div>

                                    <div class="col-md-4 m-b-20">
                                        <label class="form-label">Status<span class="red">*</span>
                                        </label>
                                        <select class="form-control" name="status" id="status" >
                                            <option value="" disabled="">Please select status</option>
                                            <option value="0" @if($product->status == 0) selected @endif
                                            >Inactive</option>
                                            <option value="1" @if($product->status == 1) selected @endif
                                            >Active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" role="tab" id="headingTwo">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse2" aria-expanded="false" aria-controls="collapseTwo">
                                    Pattern information
                                </a>
                            </h5>
                        </div>
                        <div id="collapse2" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                            <div class="card-body">
                                <div class="form-group row">
                                    <div class="col-md-6 m-b-20">
                                        <label class="form-label">Pattern name<span class="red">*</span></label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               placeholder="Enter pattern name" value="{{ $product->product_name }}">
                                        <small>Name of the pattern (to display on pattern listing in Shop)</small>
                                    </div>
                                    <div class="col-md-6 m-b-20">
                                        <label class="form-label">Designer name<span class="red">*</span>
                                        </label>
                                        <select type="text" class="form-control" id="designer_name" name="designer_name">
                                            <option value="">Please select designer name</option>
                                            @foreach($designerUsers as $des)
                                                <option value="{{ $des->id }}" @if($product->designer_name ==
                                                $des->id) selected @endif >{{
                                                $des->first_name }}
                                                    {{
                                                $des->last_name
                                            }}</option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="designer_id" value="{{ $product->designer_name }}">
                                    </div>
                                    <div class="col-md-6 m-b-20">
                                        <label class="form-label">Brand name
                                        </label>
                                        <input type="text" class="form-control"
                                               id="brand_name" name="brand_name"
                                               placeholder="Enter brand name" value="{{ $product->brand_name }}" >
                                        <small>If there is another name associated with your design work aside from your actual name, please provide it here</small>
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

                                    <!--<div class="col-md-4 m-b-20">

                                    </div>

                                    <div class="col-md-4 m-b-20">

                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" role="tab" id="headingThree">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse3" aria-expanded="false" aria-controls="collapseThree">
                                    Designer recommendations
                                </a>
                            </h5>
                        </div>
                        <div id="collapse3" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="card-body">
                                <div class="row col-md-12" id="yarnDetails">
                                    @if($product->yarnRecommmendations()->count() > 0)
                                        <?php $y=0; ?>
                                        @foreach($product->yarnRecommmendations as $yarns)
                                            <div class="form-group row m-b-zero yarnRows" id="yarn-row-{{$y}}">
                                                <input type="hidden" name="product_yarn_recommendations_id[]" value="{{
                                                $yarns->id }}">
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
                                                        <a href="javascript:;" class="pull-right fa fa-trash deleteYarndetails"  title="Delete yarn details" data-id="{{$y}}" id="deleteYarndetails{{$y}}" data-server="true"></a>
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
                                                                <input type="url" class="form-control" id="yarn_url" name="yarn_url[]" placeholder="https://knitfitco.com" value="{{ $yarns->yarn_url }}">
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
                                                                <div class="col-lg-2 m-b-10" id="yarnRecommendationImages">
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
                                    @endif
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
                                        @if($product->needles()->count() > 0)
                                            <?php $n = 0; ?>
                                            @foreach($product->needles as $needle)
                                                <div class="col-md-4 allNeedles" id="needle{{$n}}">
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
                                                                    <a href="javascript:;" class="fa fa-trash deleteNeedles" data-server="true" id="deleteNeedles{{$n}}" data-id="{{$n}}" style="position: absolute;top: 9px;right: 0px;"></a>
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

                                <br>

                                <!-- Gauge & ease-->

                                <div class="row form-group m-b-zero" id="needle-row-custom">
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

                                                <br>

                                                <div class="row form-group">
                                                    <div class="col-md-6">
                                                        <div class="form-radio m-b-10">
                                                            <h6 class="text-muted m-b-10">Unit of measurement</h6>
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" id="inches-custom" name="radio_inches" checked="checked" class="custom-control-input">
                                                                        <span class="custom-control-indicator"></span>
                                                                        <span
                                                                            class="custom-control-description">Inches</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <!--<div class="radio radio-inline m-r-10">
                                                                <label>
                                                                    <input type="radio" id="inches-custom" name="radio_inches" checked="checked">
                                                                    <i class="helper"></i>Inches
                                                                </label>
                                                            </div>-->
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
                                                                @for($j=1;$j<= 20;$j+= 0.25)
                                                                    <option value="{{$j}}" {{ ($j ==
                                                                    $product->designer_recommended_ease_in) ? 'selected' : '' }}>{{$j}}"</option>
                                                                @endfor
                                                            </select>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-radio m-b-10">
                                                            <h6 class="text-muted m-b-10">Unit of measurement</h6>
                                                            <!--<div class="radio radio-inline m-r-10">
                                                                <label>
                                                                    <input type="radio" id="inches-custom" name="radio_cm" checked="checked">
                                                                    <i class="helper"></i>Centimeters
                                                                </label>
                                                            </div>-->
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <label class="custom-control custom-radio">
                                                                        <input type="radio" id="inches-custom" name="radio_cm" checked="checked" class="custom-control-input">
                                                                        <span class="custom-control-indicator"></span>
                                                                        <span class="custom-control-description">Centimeters</span>
                                                                    </label>
                                                                </div>
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
                                                                @for($i=1;$i <= 20;$i++)
                                                                    <option value="{{$i}}" {{ ($i ==
                                                                    $product->designer_recommended_ease_cm) ? 'selected' : '' }}>{{$i}} cm</option>
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
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" role="tab" id="headingThree">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse4" aria-expanded="false" aria-controls="collapseThree">
                                    Images
                                </a>
                            </h5>
                        </div>
                        <div id="collapse4" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="card-body">
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
                                <div class="form-group card-block">
                                    <div class="sub-title">Image<span class="red">*</span></div>
                                    <input type="file" class="filer_input1" name="product_images[]" id="product_images" multiple="multiple">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" role="tab" id="headingThree">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse5" aria-expanded="false" aria-controls="collapseThree">
                                    Upload pattern pdf / instruction file (DOC, DOCX, PDF, PNG, JPEG)
                                </a>
                            </h5>
                        </div>
                        <div id="collapse5" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="card-body">
                                <div class="row">
                                    @if($product->traditionalPatternpdf()->count() > 0)
                                        @foreach($product->traditionalPatternpdf as $inst)
                                            <div class="col-lg-2 m-b-10 patternImages" id="patternImage{{$inst->id}}">
                                                <div class="img-hover" style="width:
                                                            100px;">
                                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                                    <div class="editable-items" style="text-align: center;">
                                                        <a class="fa fa-eye" target="_blank" href="{{
                                                                $inst->instructions_file }}" ></a>
                                                        <a class="fa fa-trash deleteImage" data-server="true"
                                                           href="javascript:;" data-id="{{ $inst->id }}"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="form-group card-block">
                                    <div class="sub-title">Instructions file<span class="red">*</span></div>
                                    <input type="file" class="filer_input1"
                                           name="product_instructions[]"
                                           id="product_instructions" multiple="multiple">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header" role="tab" id="headingThree">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse6" aria-expanded="false" aria-controls="collapseThree">
                                    Enter price
                                </a>
                            </h5>
                        </div>
                        <div id="collapse6" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="card-body">
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
                                        <input type="number" name="sale_price" id="sale_price" class="form-control"
                                               placeholder="Enter sale price" min="0" value="{{
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
                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree1">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion2" href="#collapse8" aria-expanded="false" aria-controls="collapseThree">
                                        Paypal details
                                    </a>
                                </h5>
                            </div>
                            <div id="collapse8" class="collapse" role="tabpanel" aria-labelledby="headingThree1">
                                <div class="card-body">
                                    <div class="row">
                                        <input type="hidden" id="paypal_verified" value="{{ $paypalDetails ? $paypalDetails->status : 0 }}" >
										@if($paypalDetails)
											<input type="hidden" name="paypal_id" value="{{ $paypalDetails->id }}">
										@endif
                                        <div class="form-group col-md-6 m-b-20">
                                            <label class="form-label">Paypal username</label>
                                            <input type="text" name="paypal_username" id="paypal_username"
                                                   class="form-control paypal_credentials"
                                                   placeholder="Ex : email_api1.domain.com"
                                                   value="{{ $paypalDetails ? $paypalDetails->paypal_username : '' }}" readonly >
                                            <span class="red paypal_username"></span>
                                        </div>
                                        <div class="form-group col-md-6 m-b-20">
                                            <label class="form-label">Paypal password</label>
                                            <input type="text" name="paypal_password" id="paypal_password"
                                                   class="form-control paypal_credentials"
                                                   placeholder="Ex : ABCD1234AHKH23RG"
                                                   value="{{ $paypalDetails ? $paypalDetails->paypal_password : '' }}" readonly >
                                            <span class="red paypal_password"></span>
                                        </div>
                                        <div class="form-group col-md-6 m-b-20">
                                            <label class="form-label">Paypal secret/signature</label>
                                            <input type="text" name="paypal_secret" id="paypal_secret"
                                                   class="form-control paypal_credentials"
                                                   placeholder="Ex : AzAibTQIex06ji3rlT3Oro9cEADCXZXpF72pJc3KqCr661As59yRAsD0"
                                                    value="{{ $paypalDetails ? $paypalDetails->paypal_secret : '' }}" readonly >
                                            <span class="red paypal_secret"></span>
                                        </div>
                                        <div class="form-group col-md-6 m-b-20">
                                            <label class="form-label">Paypal app id(optional)</label>
                                            <input type="text" name="paypal_app_id" id="paypal_app_id"
                                                   class="form-control paypal_credentials"
                                                   placeholder="Ex : APP-80W284485PHGT54R6"
                                                   value="{{ $paypalDetails ? $paypalDetails->paypal_app_id : '' }}" readonly >
                                            <span class="red paypal_app_id"></span>
                                        </div>
                                        <!--<div class="form-group col-md-6 m-b-20">
                                            <label class="form-label">Paypal certificate(optional)</label>
                                            <input type="file" name="paypal_certificate" id="paypal_certificate"
                                                   class="form-control paypal_credentials" readonly >
                                            <span class="red paypal_certificate"></span>
                                        </div> -->
                                        <div class="form-group col-md-6 m-b-20">
                                            <div class="test_paypal @if($paypalDetails) @if($paypalDetails->status == 1) hide @endif @else hide @endif ">
                                                <button
                                                    type="button"
                                                    class="btn btn-primary theme-btn waves-effect waves-light m-t-20"
                                                    id="test_paypal_credentials">Test paypal credentials</button>
                                                <button
                                                    type="button"
                                                    id="cancelPaypal"
                                                    class="btn btn-danger theme-btn waves-effect waves-light m-t-20"
                                                >Cancel</button>
                                            </div>
                                            <div class="edit_paypal">
                                                <button
                                                    type="button"
                                                    id="editPaypal"
                                                    class="btn btn-primary theme-btn waves-effect waves-light m-t-20"
                                                >Edit paypal credentials</button>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12 m-b-20" id="paypalError">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="m-t-20">
                            <div class="col-sm-12">
                                <div class="text-center m-b-10">
                                    <button type="submit" data-type="save" class="btn theme-btn btn-primary waves-effect waves-light m-l-10 save" >Save</button>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="submit_type" id="submit_type" value="save">

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('section2')

@endsection

@section('footerscript')
    <script type="text/javascript">
        var URL = '{{route("admin.upload.pattern.images")}}';
        var URL1 = '{{url("admin/remove-pattern-images")}}';

        var URL2 = '{{route("admin.upload.recomondation.images")}}';
        var URL3 = '{{url("admin/remove-admin-recomondation-images")}}';

        var URL4 = '{{route("admin.upload.pattern.instructions")}}';
        var URL5 = '{{url("admin/remove-admin-pattern-instructions")}}';

        //var PAGE = 'designerPatterns';
        var PAGE = 'adminPatterns';
    </script>
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
    <style>
        #accordionExample .accordionBtn:before,
        #accordionExample .accordionBtn.collapsed:before{
            content: "\f067";
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            width: 25px;
            height: 25px;
            line-height: 28px;
            font-size: 14px;
            color: #50bbaa;
            text-align: center;
            position: absolute;
            top: 18px;
            right: 15px;
            transform: rotate(135deg);
            transition: all 0.3s ease 0s;
        }
        #accordionExample .accordionBtn.collapsed:before{
            color: #a0a0a0;
            transform: rotate(0);
        }
        #accordion2 .card-header{
            border: 1px solid #99abb4;
            background-color: #99abb4;
            margin-left: 0px !important;
            margin-right: 0px !important;
        }
        #accordion2 .card-header a{
            color: #ffffff;
            font-weight: 500;
        }
        .page-titles{
            padding: 10px !important;
        }
        .jFiler-input-inner p{
            text-align: center !important;
        }
        .help-block {
            display: block;
            margin-top: 5px;
            *margin-bottom: 10px;
            color: #bc7c8f;
            font-weight:bold;
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
        .select2{
            width:100% !important;
        }
        .red{
            color: red;
        }
    </style>
    <script>
        $(function (){
            var yarnRows = $(".yarnRows");
            for (var i=0;i<yarnRows.length;i++){
                jqueryFiler('filer_input'+i,URL2,URL3,i);
            }

            patternImages('product_images',URL,URL1);
            patternInstructions('product_instructions',URL4,URL5);
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

            /* form validations */

            var $validations = $('#create-pattern');

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
                            },
                            regexp: {
                                regexp: /^([a-zA-Z]+\s)*[a-zA-Z]+$/,
                                message: 'The designer name should have only alphabets and spaces.'
                            }*/
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
                    /*
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
                    }*/

                }
            }).on('status.field.bv', function(e, data) {
                data.bv.disableSubmitButtons(false);
            }).on('error.field.bv', function(e, data) {
                var fieldName = data.field.replace('[]','');
                fieldName = fieldName.replace('_',' ');
                notification('fa-times','Error','Please fill '+ucfirst(fieldName,true),'danger');
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



                /*if(er !=''){
                    notification('fa-times','Error','Please fill all the required fields','danger');
                    return false;
                }*/

                //data.bv.disableSubmitButtons(true);


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
						$(".loading,.loader-bg").hide();
                    }
                }, 'json');
            });

            /* form validations */

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

            $(document).on('click','.primaryImage',function(){
                var id = $(this).attr('data-id');
                var mainphoto = $(this).attr('data-mainphoto');
                var pattern_id = $("#pattern_id").val();

                var Data = 'id='+id+'&pattern_id='+pattern_id;

                if(mainphoto == 1){
                    Swal.fire('This image was already pattern image');
                    return false;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to make this as a default image ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $(".loading,.loader-bg").show();
                        $.post('{{ route("admin.make.image.default") }}', Data, function(result) {
                            if(result.status == 'success'){
                                $("#primaryImage"+id).removeClass('fa-star-o').addClass('fa-star');
                                $("#primaryImage"+id).attr('data-mainphoto',1);
                                notification('fa-check','success','Pattern image set successfully..','success');
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong! Try again after some time.',
                                })
                            }
                            $(".loading,.loader-bg").hide();
                        });
                    }
                })

            });

            $(document).on('click','.deleteYarndetails',function() {
                var id = $(this).attr('data-id');
                var $rows = $(".yarnRows");
                var rowId = $rows.length + 1;
                var prevRowId = $rows.length - 1;
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
                            $.get('{{ url("admin/deleteYarnRecommmendations")  }}/'+id,function (res){
                                if(res.status == 'success'){
                                    $("#yarn-row-"+id).remove();
                                    notification('fa-check','success','Recommended yarn removed successfully..','success');
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong! Try again after some time.',
                                    })
                                }
                            });
                        }else{
                            $("#yarn-row-"+id).remove();
                        }
                        if(prevRowId != 0){
                            $("#deleteYarndetails"+prevRowId).addClass('fa-trash');
                        }
                    }
                });
            });

            $(document).on('click','.deleteNeedles',function(){
                var id = $(this).attr('data-id');
                var $rows = $(".allNeedles");
                var rowId = $rows.length + 1;
                var prevRowId = $rows.length - 1;
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
                            $.get('{{ url("admin/deleteNeedles")  }}/'+id,function (res){
                                if(res.status == 'success'){
                                    $("#needle-"+id).remove();
                                    notification('fa-check','success','Needle size removed successfully..','success');
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong! Try again after some time.',
                                    })
                                }
                            });
                        }else{
                            $("#needle"+id).remove();
                        }
                        if(prevRowId != 0){
                            $("#deleteNeedles"+prevRowId).addClass('fa-trash');
                        }
                    }
                });

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
                            alert('coming here')
                            $.get('{{ url("admin/delete-yarn-image")  }}/'+id,function (res){
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
                            $.get('{{ url("admin/delete-pattern-image")  }}/'+id,function (res){
                                if(res.status == 'success'){
                                    $("#patternImage-"+id).remove();
                                    notification('fa-check','success','Pattern image deleted successfully..','success');
                                }else{
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Something went wrong! Try again after some time.',
                                    })
                                }
                            });
                        }else{
                            $("#patternImage"+id).remove();
                        }
                    }
                })
            });

            $(document).on('click','#test_paypal_credentials',function (e){
                e.preventDefault();
                var paypal_username = $("#paypal_username").val();
                var paypal_password = $("#paypal_password").val();
                var paypal_secret = $("#paypal_secret").val();
                var paypal_app_id = $("#paypal_app_id").val();
                var er = [];
                var cnt = 0;

                if(paypal_username == ''){
                    $(".paypal_username").html('Paypal username is required.');
                    er+=cnt+1;
                }else{
                    $(".paypal_username").html('');
                }

                if(paypal_password == ''){
                    $(".paypal_password").html('Paypal password is required.');
                    er+=cnt+1;
                }else{
                    $(".paypal_password").html('');
                }

                if(paypal_secret == ''){
                    $(".paypal_secret").html('Paypal secret/signature is required.');
                    er+=cnt+1;
                }else{
                    $(".paypal_secret").html('');
                }

                if(er != ''){
                    return false;
                }

                var Data = 'username='+paypal_username+'&password='+paypal_password+'&secret='+paypal_secret+'&app_id' +
                    '='+paypal_app_id;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("admin.checkPaypalDetails") }}',
                    type : 'POST',
                    data : Data,
                    beforeSend : function (){
                        $('#paypalError').html('');
                        $(".loading").show();
                    },
                    success : function (res,status,xhr) {
                        if(res.status == 'success'){
                            notification('fa-check','success','Paypal details verified','success');
                            $("#test_paypal_credentials").prop('disabled',true);
                            $('input.paypal_credentials').attr('readonly',true);
                            $(".edit_paypal").removeClass('hide');
                            $(".test_paypal").addClass('hide');
                            $("#paypal_verified").val(1);
                        }else{
                            notification('fa-times','danger',res.message,'danger');
                        }
                    },
                    complete : function (){
                        $(".loading").hide();
                    },
                    error : function (jqXhr, textStatus, errorMessage){
                        var data = '';
                        if(jqXhr.responseJSON.errors.paypal_app_id[0]){
                            data+=jqXhr.responseJSON.errors.paypal_app_id[0]+'<br>';
                        }

                        if(jqXhr.responseJSON.errors.paypal_password[0]){
                            data+=jqXhr.responseJSON.errors.paypal_password[0]+'<br>';
                        }

                        if(jqXhr.responseJSON.errors.paypal_secret[0]){
                            data+=jqXhr.responseJSON.errors.paypal_secret[0]+'<br>';
                        }

                        if(jqXhr.responseJSON.errors.paypal_username[0]){
                            data+=jqXhr.responseJSON.errors.paypal_username[0]+'<br>';
                        }

                        $('#paypalError').addClass('alert alert-danger').html('Error: ' + data);
                    }
                })
            });

            $(document).on('click','#editPaypal',function (){
                $('input.paypal_credentials').attr('readonly',false);
                $(".edit_paypal").addClass('hide');
                $(".test_paypal").removeClass('hide');
                $("#paypal_verified").val(0);
            });

            $(document).on('click','#cancelPaypal',function (){
                $('input.paypal_credentials').attr('readonly',true);
                $(".edit_paypal").removeClass('hide');
                $(".test_paypal").addClass('hide');
                $("#paypal_verified").val(1);
            });

        });

        function validateDescription(id){
            $('#create-pattern').data('bootstrapValidator').revalidateField(id);
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
