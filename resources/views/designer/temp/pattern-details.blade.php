@extends('layouts.tempdesignerapp')
@section('title',$pattern ? $pattern->product_name : '')
@section('content')
    <div class="pcoded-wrapper" id="dashboard">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- Page-body start -->
                        <div class="page-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <label class="theme-heading f-w-600 m-b-20">{{ $pattern ? $pattern->product_name : '' }}
                                    </label>
                                </div>
                            </div>
                            <div class="row col-md-12">
                            @if($pattern)
							<input type="hidden" id="product_id" value="{{ $pattern->id }}" >
							<a href="javascript:;" id="makeChanges" data-href="https://stitchersstudio.com/website/review-pattern/?email={{Auth::user()->email}}&pattern_name={{str_replace(' ','-',$pattern->product_name)}}" class="btn btn-primary btn-sm m-b-10 m-t-10 theme-btn" style="position: absolute;right: 36px;top: -60px;" target="_blank">Approve or suggest changes</a>
                                    <div class="accordion" id="accordionExample" style="width: 100%;">
                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOneA"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                    Project information
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapseOneA" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                            <div class="card-body">

                                                <div class="row m-b-zero">
                                                    <div class="col-md-8">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Name</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label m-l-15">{{ucfirst
                                                                    ($pattern->product_name)}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Designer Name</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label m-l-15">{{ Auth::user()->first_name.' '
                                                                    .Auth::user()->last_name
                                                                    }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Skill level</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label m-l-15">{{ucfirst
                                                                    ($pattern->skill_level)}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Brand Name</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label m-l-15">{{ucfirst
                                                                    ($pattern->brand_name)}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Sizes</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label m-l-15">{{ucfirst
                                                                    ($pattern->sizes)}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label f-w-600">Pattern description</label>
                                                                <div class="row">
                                                                    <label class="col-form-label
                                                                m-l-15">{!! $pattern->product_description !!}</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label f-w-600">Pattern details</label>
                                                                <div class="row">
                                                                    <label class="col-form-label
                                                                m-l-15">{!! $pattern->short_description !!}</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label f-w-600">Gauge instruction</label>
                                                                <div class="row">
                                                                    <label class="col-form-label
                                                                m-l-15">{!! $pattern->gauge_description !!}</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="col-form-label f-w-600">Materials needed</label>
                                                                <div class="row">
                                                                    <label class="col-form-label
                                                                m-l-15">{!! $pattern->material_needed !!}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <?php
                                                        $images = App\Models\Product_images::where('product_id',
                                                            $pattern->id)->get();
                                                        ?>
                                                        @if($images->count() > 0)
                                                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">
                                                                <?php $i=1; ?>
                                                                @foreach($images as $im)
                                                                <div class="carousel-item @if($i == 1) active @endif">
                                                                    <img class="d-block w-100" src="{{ $im->image_medium }}"
                                                                         alt="{{$i}} slide">
                                                                </div>
                                                                    <?php $i++; ?>
                                                                @endforeach
                                                            </div>
                                                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                <span class="sr-only">Previous</span>
                                                            </a>
                                                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                <span class="sr-only">Next</span>
                                                            </a>
                                                        </div>
                                                        @endif
                                                    </div>

                                                </div>


                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="col-form-label f-w-600">Design elements</label>
                                                            <div class="row">
                                                                <label class="col-form-label m-l-15">{{$pattern->design_elements}}</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="col-form-label f-w-600">Construction technique</label>
                                                            <div class="row">
                                                                <label class="col-form-label m-l-15">{{$pattern->construction_technique}}</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="col-form-label f-w-600">Garment type</label>
                                                            <div class="row">
                                                                <label class="col-form-label m-l-15">{{$pattern->garment_type}}</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="col-form-label f-w-600">Shoulder construction</label>
                                                            <div class="row">
                                                                <label class="col-form-label m-l-15">{{$pattern->shoulder_construction}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="card-header custom-header">
                                                        <h5 class="mb-0">Designer recommendations</h5>
                                                    </div>

                                                    <div class="col-md-12">
                                                        @if($pattern->yarnRecommmendations()->count() > 0)
                                                            @foreach($pattern->yarnRecommmendations as $yarn)
                                                             <div class="row m-t-10 border-1-eee">
                                                                 <div class="col-md-10">
                                                                     <div class="row">
                                                                         <div class="col-md-4">
                                                                             <div class="form-group">
                                                                                 <label class="col-form-label f-w-600">Yarn company</label>
                                                                                 <div class="row">
                                                                                     <label class="col-form-label
                                                                             m-l-15">{{$yarn->yarn_company}}</label>
                                                                                 </div>
                                                                             </div>
                                                                         </div>

                                                                         <div class="col-md-4">
                                                                             <div class="form-group">
                                                                                 <label class="col-form-label f-w-600">Yarn name</label>
                                                                                 <div class="row">
                                                                                     <label class="col-form-label
                                                                             m-l-15">{{$yarn->yarn_name}}</label>
                                                                                 </div>
                                                                             </div>
                                                                         </div>

                                                                         <div class="col-md-4">
                                                                             <div class="form-group">
                                                                                 <label class="col-form-label f-w-600">Fiber type</label>
                                                                                 <div class="row">
                                                                                     <label class="col-form-label
                                                                             m-l-15">{{$yarn->fiber_type}}</label>
                                                                                 </div>
                                                                             </div>
                                                                         </div>
                                                                     </div>

                                                                     <div class="row">
                                                                         <div class="col-md-4">
                                                                             <div class="form-group">
                                                                                 <label class="col-form-label f-w-600">Yarn weight</label>
                                                                                 <div class="row">
                                                                                     <label class="col-form-label
                                                                             m-l-15">{{$yarn->yarn_weight}}</label>
                                                                                 </div>
                                                                             </div>
                                                                         </div>

                                                                         <div class="col-md-4">
                                                                             <div class="form-group">
                                                                                 <label class="col-form-label f-w-600">Shop URL</label>
                                                                                 <div class="row">
                                                                                     <label class="col-form-label
                                                                             m-l-15"><a href="{{$yarn->yarn_url}}"
                                                                                        target="_blank"
                                                                                         >{{$yarn->yarn_url}}</a>
                                                                                     </label>
                                                                                 </div>
                                                                             </div>
                                                                         </div>

                                                                         <div class="col-md-4">
                                                                             <div class="form-group">
                                                                                 <label class="col-form-label f-w-600">Coupon code</label>
                                                                                 <div class="row">
                                                                                     <label class="col-form-label
                                                                             m-l-15">{{$yarn->coupon_code}}</label>
                                                                                 </div>
                                                                             </div>
                                                                         </div>
                                                                     </div>
                                                                 </div>
                                                                 <div class="col-md-2">
                                                                     @if($yarn->yarnImages()->count() > 0)
                                                                         <div id="carouselExampleControls1"
                                                                              class="carousel slide"
                                                                              data-ride="carousel" style="padding:
                                                                              5px;">
                                                                             <div class="carousel-inner">
                                                                                 <?php $j=1; ?>
                                                                                 @foreach($yarn->yarnImages as $ym)
                                                                                     <div class="carousel-item @if($j
                                                                                      == 1) active @endif">
                                                                                         <img class="d-block"
                                                                                              src="{{
                                                                                              $ym->yarn_image }}"
                                                                                              alt="{{$j}} slide"
                                                                                              style="width: 100%;
                                                                                              float: right;">
                                                                                     </div>
                                                                                     <?php $j++; ?>
                                                                                 @endforeach
                                                                             </div>
                                                                             <a class="carousel-control-prev"
                                                                                href="#carouselExampleControls1" role="button" data-slide="prev">
                                                                                 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                                 <span class="sr-only">Previous</span>
                                                                             </a>
                                                                             <a class="carousel-control-next"
                                                                                href="#carouselExampleControls1" role="button" data-slide="next">
                                                                                 <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                                 <span class="sr-only">Next</span>
                                                                             </a>
                                                                         </div>
                                                                     @endif
                                                                 </div>
                                                             </div>
                                                            @endforeach
                                                        @else
                                                        <p class="text-center">No yarn recomondations to show.</p>
                                                        @endif
                                                    </div>
                                                </div>


                                                <div class="row m-t-20">
                                                    <div class="card-header custom-header">
                                                        <h5 class="mb-0">Needle sizes </h5>
                                                    </div>
                                                    <div class="col-md-12">
                                                        @if($pattern->needles()->count() > 0)
                                                            <div class="row">
                                                                @foreach($pattern->needles as $need)
																<?php $ns = App\Models\NeedleSizes::where('id',$need->needle_size)->first(); ?>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label
                                                                            f-w-600">Needle size</label>
                                                                            <div class="row">
                                                                                <label class="col-form-label
                                                                             m-l-15">
																			@if($ns)
																				US-{{$ns->us_size}} - {{$ns->mm_size}} mm
																			@else
																				0
																			@endif
																			 </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @else
                                                            <p class="text-center">No needles to show</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row m-t-20">
                                                    <div class="card-header custom-header">
                                                        <h5 class="mb-0">Gauge & ease</h5>
                                                    </div>
                                                    <div class="col-md-12">

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <?php
                                                                        $sguagein = App\Models\GaugeConversion::where
                                                                        ('id',$pattern->recommended_stitch_gauge_in)
                                                                            ->first();
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <label class="col-form-label
                                                                    f-w-600">Stitch gauge(in)</label>
                                                                            <div class="row">
                                                                                <label class="col-form-label
                                                                     m-l-15">{{$sguagein->stitch_gauge_inch}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <?php
                                                                        $rguagein = App\Models\GaugeConversion::where
                                                                        ('id',$pattern->recommended_row_gauge_in)
                                                                            ->first();
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <label class="col-form-label
                                                                    f-w-600">Row gauge(in)</label>
                                                                            <div class="row">
                                                                                <label class="col-form-label
                                                                     m-l-15">{{$rguagein->row_gauge_inch}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label
                                                                    f-w-600">Ease(in)</label>
                                                                            <div class="row">
                                                                                <label class="col-form-label
                                                                     m-l-15">{{$pattern->designer_recommended_ease_in}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>


                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <?php
                                                                        $sguagecm = App\Models\GaugeConversion::where
                                                                        ('id',$pattern->recommended_stitch_gauge_cm)
                                                                            ->first();
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <label class="col-form-label
                                                                    f-w-600">Stitch gauge(cm)</label>
                                                                            <div class="row">
                                                                                <label class="col-form-label
                                                                     m-l-15">{{$sguagecm->stitches_10_cm}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <?php
                                                                        $rguagecm = App\Models\GaugeConversion::where
                                                                        ('id',$pattern->recommended_row_gauge_cm)
                                                                            ->first();
                                                                        ?>
                                                                        <div class="form-group">
                                                                            <label class="col-form-label
                                                                    f-w-600">Row gauge(cm)</label>
                                                                            <div class="row">
                                                                                <label class="col-form-label
                                                                     m-l-15">{{$rguagecm->rows_10_cm}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="col-form-label
                                                                    f-w-600">Ease(cm)</label>
                                                                            <div class="row">
                                                                                <label class="col-form-label
                                                                     m-l-15">{{$pattern->designer_recommended_ease_cm}}</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="card-header custom-header">
                                                        <h5 class="mb-0">Price</h5>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Price</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label
                                                                m-l-15">{{number_format($pattern->price,2)}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Sale price</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label
                                                                m-l-15">{{number_format($pattern->sale_price,2)}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Start date</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label
                                                                m-l-15">
																@if($pattern->sale_price_start_date != '1970-01-01')
																	{{$pattern->sale_price_start_date}}
																@endif</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">End date</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label
                                                                m-l-15">
																@if($pattern->sale_price_end_date != '1970-01-01')
																	{{$pattern->sale_price_end_date}}
																@endif</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="card-header custom-header">
                                                        <h5 class="mb-0">Paypal details</h5>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <?php
                                                        $paypal = App\Models\PaypalCredentials::where('user_id',
                                                            Auth::user()->id)->first();
                                                        ?>
														@if($paypal)
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Store name</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label
                                                                m-l-15">{{$paypal ? $paypal->store_name : ''}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Store status</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label
                                                                m-l-15">
																@if($paypal)
																{{($paypal->store_status == 1) ?
                                                                'Active' : 'Inactive'}} @endif</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Account type</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label
                                                                m-l-15">{{ucfirst($paypal ? $paypal->account_type : '')}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label class="col-form-label f-w-600">Paypal email</label>
                                                                    <div class="row">
                                                                        <label class="col-form-label
                                                                m-l-15">{{$paypal ? $paypal->paypal_email : ''}}</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
														@else
															<p class="text-center m-t-20">No paypal credentials to show.</p>												
														@endif
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <div class="card-header" id="headingOne">
                                            <h2 class="mb-0">
                                                <button class="btn btn-link" type="button" data-toggle="collapse"
                                                        data-target="#collapseOneB"
                                                        aria-expanded="true" aria-controls="collapseOne">
                                                    Pattern instructions
                                                </button>
                                            </h2>
                                        </div>

                                        <div id="collapseOneB" class="collapse" aria-labelledby="headingOne"
                                             data-parent="#accordionExample">
                                            <div class="card-body">
                                                @if($pdf)
                                                {!! $pdf->content !!}
                                                @else
                                                <p class="text-center">No instructions show</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    </div>

                            @else
                            <p class="text-center">The pattern selected does not exist.</p>
                            @endif
                            </div>
                        </div>
                        <!-- Page-body end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Main-body end -->

    </div>

@endsection
@section('footerscript')
<style>

    .card{
        margin-bottom: 10px !important;
    }
    .form-group{
        margin-bottom:0px !important;
    }
    .custom-header{
        background: #eee !important;
        width: 100% !important;
        padding: 7px !important;
        border: 0px !important;
    }
    .card .card-header{
        padding:0px;
    }
    .border-1-eee{
        border:1px solid #9e9e9e;
        border-radius: 3px;
    }
</style>
    <script>
        $(function(){
			$(document).on('click','#makeChanges',function(){
				var product_id = $("#product_id").val();
				var href = $(this).attr('data-href');
				var token = '{{ csrf_token() }}';
				var Data = 'id='+product_id+'&_token='+token;
				
				$.ajax({
					url : '{{ route("designer.main.change.designer.status") }}',
					type : 'POST',
					data: Data,
					beforeSend : function(){
						$(".loading").show();
					},
					success : function(res){
						if(res.status == 'success'){
							setTimeout(function(){ window.open(href,'_blank'); },1000);
						}else{
							notification('fa-times','warning',res.message,'danger');
						}
					},
					complete : function(){
						setTimeout(function(){ $(".loading").hide(); },2000);
					}
				});
				
			});
        });
    </script>
@endsection
