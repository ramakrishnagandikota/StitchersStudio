@extends('layouts.admin')
@section('breadcrum')
<div class="col-md-12 col-12 align-self-center">
    <h3 class="text-themecolor">Add Pattern</h3>
    <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Pattern</li>
    </ol>
</div>
@endsection

@section('section1')
<div class="card col-md-12 col-lg-12 col-xlg-12 col-sm-12 col-xs-12">

    <div class="progress m-t-20">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
</div>

    <div class="">
        <div class="card-body">

        <form class="form-horizontal" id="product-insert">
      {{csrf_field()}}
      <input type="hidden" name="id" value="{{$product->id}}">
            <div class="step">

                <span class="steptext">Step 1</span>

    <h4>Enter Product Details</h4>
    <hr>

            <div class="form-group row">
          <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Design Type*</label>
          <div class="col-sm-7">
              <select  name="sub_category_name" id="sub_category_name" class="form-control" required>
                    <option value="">Please Select Design Type</option>
                    @foreach($subcategory as $sub)
                    <option value="{{$sub->id}}" @if($product->design_type == $sub->id) selected @endif >{{$sub->subcat_name}}</option>
                    @endforeach
                  </select>
                  <div class="clearfix"></div>
                  <span>This Design Type is used for differentiating armhole shaping measurements for pattern.</span>
          </div>
      </div>

      <div class="form-group row">
          <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Product Name*</label>
          <div class="col-sm-7">
              <input type="text" name="name" id="name" class="form-control" required placeholder="Please enter product name" value="{{$product->product_name}}" >
          </div>
      </div>

      <div class="form-group row">
          <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Designer name*</label>
          <div class="col-sm-7">
              <select class="form-control" name="designer_name" id="designer_name">
                <option value="">Please select designer name</option>
                @foreach($designerUsers as $desg)
                <option value="{{$desg->id}}" @if($product->designer_name == $desg->id) selected @endif
                >{{$desg->first_name}} {{ $desg->last_name }}</option>
                @endforeach
              </select>
          </div>
      </div>

            </div>

            <div class="step">

                <span class="steptext"> Step 2</span>
            <h4>Designer recommendations</h4>
            <hr>

                        <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Skill Level*</label>
                    <div class="col-sm-7">
                        <select name="skill_level" required id="skill_level" class="form-control">
                        <option value="0">Please select skill level</option>
                        <option value="Basic" @if($product->skill_level == 'Basic') selected @endif >Basic</option>
                        <option value="Easy" @if($product->skill_level == 'Easy') selected @endif >Easy</option>
                        <option value="Intermediate" @if($product->skill_level == 'Intermediate') selected @endif >Intermediate</option>
                        <option value="Complex" @if($product->skill_level == 'Complex') selected @endif >Complex</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Product Type*</label>
                    <div class="col-sm-7">
                        <select name="is_custom" required id="is_custom" class="form-control">
                        <option value="" disabled >Please select type of product</option>
                        <option value="1" @if($product->is_custom == 1) selected @endif >Custom</option>
                        <option value="0" @if($product->is_custom == 0) selected @endif >Non Custom</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Recommended yarn*</label>
                    <div class="col-sm-7">
                        <input type="text" name="recommended_yarn" required id="recommended_yarn" class="form-control" value="{{$product->recommended_yarn}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Recommended fiber type*</label>
                    <div class="col-sm-7">
                        <input type="text" name="recommended_fiber_type" id="recommended_fiber_type" class="form-control" required  value="{{$product->recommended_fiber_type}}">
                    </div>
                </div>




                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Recommended yarn weight*</label>
                    <div class="col-sm-7">
                        <select name="recommended_yarn_weight" id="recommended_yarn_weight"  required class="form-control" >
                        <option value="Lace" @if($product->recommended_yarn_weight == 'Lace') selected @endif >Lace</option>
                        <option value="Super Fine" @if($product->recommended_yarn_weight == 'Super Fine') selected @endif >Super Fine</option>
                        <option value="Fine" @if($product->recommended_yarn_weight == 'Fine') selected @endif >Fine</option>
                        <option value="Light" @if($product->recommended_yarn_weight == 'Light') selected @endif >Light</option>
                        <option value="Meduim" @if($product->recommended_yarn_weight == 'Meduim') selected @endif >Meduim</option>
                        <option value="Bulky" @if($product->recommended_yarn_weight == 'Bulky') selected @endif >Bulky</option>
                        <option value="Super Bulky" @if($product->recommended_yarn_weight == 'Super Bulky') selected @endif >Super Bulky</option>
                        <option value="Jumbo" @if($product->recommended_yarn_weight == 'Jumbo') selected @endif >Jumbo</option>
                        </select>
                    </div>
                </div>



                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Additional tools needed</label>
                    <div class="col-sm-7">
                        <input type="text" name="additional_tools" id="additional_tools" class="form-control" value="{{$product->additional_tools}}">
                    </div>
                </div>



                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Needle size*</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="recommended_needle_size" id="recommended_needle_size" required >
                            <option selected>Select needle size</option>
                            @foreach($needlesizes as $ns)
                                <option value="{{$ns->id}}" @if($product->recommended_needle_size == $ns->id) selected @endif >US {{$ns->us_size}}  {{ $ns->mm_size ? '- '.$ns->mm_size.' mm' : '' }}</option>
                            @endforeach
                          </select>
                    </div>
                </div>

        <div class="form-group row">
            <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Recommended units of measure</label>
            <div class="col-sm-7">
                <select class="form-control" id="designer_recommended_uom" name="designer_recommended_uom">
                  <option value="0">Recommended units of measure</option>
                  <option value="in" @if($product->designer_recommended_uom == 'in') selected @endif >Inches</option>
                  <option value="cm" @if($product->designer_recommended_uom == 'cm') selected @endif >Centimeters</option>
                </select>
            </div>
        </div>

        <div class="form-group row inches">
            <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Recommended ease preference</label>
            <div class="col-sm-7">
                <select class="form-control" id="designer_recommended_ease_in" name="designer_recommended_ease_in">
                  <option value="0">Select value (inches)</option>
                  @for($j=1;$j<= 20;$j+= 0.25)
                      <option value="{{$j}}" @if($product->designer_recommended_ease_in == $j) selected @endif >{{$j}}"</option>
                  @endfor
                </select>
            </div>
        </div>

        <div class="form-group row inches">
            <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Recommended stitch gauge</label>
            <div class="col-sm-7">
                <select class="form-control" id="recommended_stitch_gauge_in" name="recommended_stitch_gauge_in">
                  <option value="0">Select value (inches)</option>
                  @foreach($gaugeconversion as $gc1)
                  <option value="{{$gc1->id}}" @if($product->recommended_stitch_gauge_in == $gc1->id) selected @endif  >{{$gc1->stitch_gauge_inch .' / 1 inches'}}</option>
                  @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row inches">
            <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Recommended row gauge</label>
            <div class="col-sm-7">
                <select class="form-control" id="recommended_row_gauge_in" name="recommended_row_gauge_in">
                  <option value="0">Select value (inches)</option>
                  @foreach($gaugeconversion as $gc2)
                  <option value="{{$gc2->id}}" @if($product->recommended_row_gauge_in == $gc2->id) selected @endif  >{{$gc2->row_gauge_inch .' / 1 inches'}}</option>
                  @endforeach
                </select>
            </div>
        </div>


        <div class="form-group row cms hide">
            <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Recommended ease preference</label>
            <div class="col-sm-7">
                <select class="form-control" id="designer_recommended_ease_cm" name="designer_recommended_ease_cm">
                  <option value="0">Select value (cm)</option>
                  @for($i=1;$i <= 20;$i++)
                  <option value="{{$i}}" @if($product->designer_recommended_ease_cm == $i) selected @endif >{{$i}} cm</option>
                  @endfor
                </select>
            </div>
        </div>

        <div class="form-group row cms hide">
            <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Recommended stitch gauge</label>
            <div class="col-sm-7">
                <select class="form-control" id="recommended_stitch_gauge_cm" name="recommended_stitch_gauge_cm">
                  <option value="0">Select value (cm)</option>
                  @foreach($gaugeconversion as $gc3)
                  <option value="{{$gc3->id}}" @if($product->recommended_stitch_gauge_cm == $gc3->id) selected @endif >{{$gc3->stitches_10_cm .' / 10cm'}}</option>
                  @endforeach
                </select>
            </div>
        </div>

        <div class="form-group row cms hide">
            <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Recommended row gauge</label>
            <div class="col-sm-7">
                <select class="form-control" id="recommended_row_gauge_cm" name="recommended_row_gauge_cm">
                  <option value="0">Select value (cm)</option>
                  @foreach($gaugeconversion as $gc4)
                  <option value="{{$gc4->id}}" @if($product->recommended_row_gauge_cm == $gc4->id) selected @endif >{{$gc4->rows_10_cm .' / 10cm'}}</option>
                  @endforeach
                </select>
            </div>
        </div>


            </div>


      <div class="step">
        <span class="steptext">Step 3</span>
        <h4>Product Information</h4>



                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Product Description*</label>
                    <div class="col-sm-7">
                        <textarea type="text"  id="description" class="form-control" required >{{$product->product_description}}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Details*</label>
                    <div class="col-sm-7">
                        <textarea type="text"  required id="short_description" class="form-control">{{$product->short_description}}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Additional Information*</label>
                    <div class="col-sm-7">
                        <textarea type="text"  required id="additional_information" class="form-control">{{$product->additional_information}}</textarea>
                    </div>
                </div>



                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">SKU*</label>
                    <div class="col-sm-7">
                        <input type="text" name="sku" id="sku"  required class="form-control" value="{{$product->sku}}">
                    </div>
                </div>




                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Product GoLive Date</label>
                    <div class="col-sm-7">
                        <input type="text" name="set_product_new_to_date" placeholder="Please select date" id="set_product_new_to_date" class="form-control" value="{{date('m/d/Y',strtotime($product->product_go_live_date))}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Status*</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="status" id="status" required >
                              <option value="" disabled >Please select status</option>
                          <option value="0" @if($product->status == 0) selected @endif >In Active</option>
                            <option value="1" @if($product->status == 1) selected @endif >Active</option>
                          </select>
                    </div>
                </div>


         <div class="form-group row">
          <?php
          $exp = explode(',',$product->garment_type);
          ?>
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Garment type*</label>
                    <div class="col-sm-7">
                       <select class="select" multiple="multiple" required id="garment_type" name="garment_type[]" style="width: 100%;">
                @foreach($garmentType as $gt)
                <option value="{{ $gt->slug }}" @for($k=0;$k<count($exp);$k++) @if($exp[$k] == $gt->slug) selected @endif @endfor >{{ $gt->name }}</option>
                @endforeach
                </select>
                    </div>
                </div>

                <div class="form-group row">
                  <?php
          $exp1 = explode(',',$product->garment_construction);
          ?>
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Garment construction*</label>
                    <div class="col-sm-7">
                       <select class="select" multiple="multiple" required id="garment_construction" name="garment_construction[]" style="width: 100%;">
                @foreach($garmentConstruction as $gc)
                <option value="{{ $gc->slug }}" @for($l=0;$l<count($exp1);$l++) @if($exp1[$l] == $gc->slug) selected @endif @endfor >{{ $gc->name }}</option>
                @endforeach
                </select>
                    </div>
                </div>

                <div class="form-group row">
                  <?php
          $exp2 = explode(',',$product->design_elements);
          ?>
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Design Elements*</label>
                    <div class="col-sm-7">
                       <select class="select" multiple="multiple" required id="design_elements" name="design_elements[]" style="width: 100%;">
                @foreach($designElements as $de)
                <option value="{{ $de->slug }}" @for($m=0;$m<count($exp2);$m++) @if($exp2[$m] == $de->slug) selected @endif @endfor >{{ $de->name }}</option>
                @endforeach
                </select>
                    </div>
          </div>

          <div class="form-group row">
             <?php
          $exp3 = explode(',',$product->shoulder_construction);
          ?>
              <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Shoulder construction*</label>
              <div class="col-sm-7">
                 <select class="select" multiple="multiple" required id="shoulder_construction" name="shoulder_construction[]" style="width: 100%;">
              @foreach($shoulderConstruction as $sc)
              <option value="{{ $sc->slug }}" @for($n=0;$n<count($exp3);$n++) @if($exp3[$n] == $sc->slug) selected @endif @endfor >{{ $sc->name }}</option>
              @endforeach
              </select>
                  </div>
          </div>
      </div>


      <div class="step">

            <span class="steptext"> Step 4</span>
      <h4>Measurements</h4>
      <hr>

      <button type="button" class="btn btn-primary pull-right" id="addNew">Add new variable</button>
      <br>

<table class="table table-responsive-md table-sm table-bordered" >
     <thead>
      <tr>
        <th>id</th>
        <th width="20%">Name</th>
        <th>Description</th>
        <th>Image </th>
          <th>Inches</th>
          <th>Cm </th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="tbody">
      @if($measurements->count() > 0)
      <?php $i=1; ?>
      @foreach($measurements as $ms)
      <?php
      $mname = str_replace('_',' ',ucfirst($ms->measurement_name));
      ?>
      <tr class="trs" id="trs{{$i}}">
        <td>{{$i}}<input type="hidden" name="measurement_id[]" value="{{$ms->id}}"></td>
        <td><input type="text" name="measurement_name[]" class="form-control" placeholder="Measurement Name" value="{{$mname}}" ></td>
        <td><input type="text" name="measurement_description[]" class="form-control" value="{{$ms->measurement_description}}" placeholder="Measurement Notes"></td>
        <td>
          <div class="row">
      <div class="col-md-9">
          <input type="file" id="uploadImage{{$i}}" class="uploadImage" data-id="{{$i}}" ><input type="hidden" name="measurement_image[]" id="measurement_image{{$i}}">
      </div>
        <div class="col-md-3"><span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <img src="{{asset($ms->measurement_image) }}" />  <span class="tooltip-text">{{ucfirst($ms->measurement_description)}}</span></span> </span>
        </div>
        </div>
      </td>
          <td><input type="number" name="min_value_inches[]" min="0" class="form-control" placeholder="Min value" value="{{ $ms->min_value_inches }}">
              <input type="number" name="max_value_inches[]" class="form-control" min="0" placeholder="Max value" value="{{ $ms->max_value_inches }}"></td>
          <td><input type="number" name="min_value_cm[]" min="0" class="form-control" placeholder="Min value" value="{{ $ms->min_value_cm }}">
              <input type="number" name="max_value_cm[]" class="form-control" min="0" placeholder="Max value" value="{{ $ms->max_value_cm }}"></td>
        <td><a href="javascript:;" data-id="{{$i}}" data-mid="{{$ms->id}}" class="deleteM"><i class="fa fa-trash"></i></td>
      </tr>
      <?php $i++; ?>
      @endforeach
      @else
      <tr class="trs" id="trs1">
        <td>1<input type="hidden" name="measurement_id[]" value="0"></td>
        <td><input type="text" name="measurement_name[]" class="form-control" value="" placeholder="Measurement Name" ></td>
        <td><input type="text" name="measurement_description[]" class="form-control" value="" placeholder="Measurement Notes"></td>
        <td><input type="file" id="uploadImage1" class="uploadImage" data-id="1" ><input type="hidden" name="measurement_image[]" id="measurement_image1"></td>
          <td><input type="number" name="min_value_inches[]" min="0" class="form-control" placeholder="Min value">
              <input type="number" name="max_value_inches[]" class="form-control" min="0" placeholder="Max value"></td>
          <td><input type="number" name="min_value_cm[]" min="0" class="form-control" placeholder="Min value">
              <input type="number" name="max_value_cm[]" class="form-control" min="0" placeholder="Max value"></td>
        <td><a href="javascript:;" data-id="1" data-mid="0" class="deleteM"><i class="fa fa-trash"></i></td>
      </tr>
      @endif
    </tbody>
  </table>

    </div>

            <div class="step">

                    <span class="steptext"> Step 5</span>
            <h4>Enter Price</h4>
            <hr>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Price</label>
                    <div class="col-sm-7">
                        <input type="number" name="price" id="price" class="form-control" required placeholder="Please enter price" value="{{$product->price}}" >
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Sale Price</label>
                    <div class="col-sm-7">
                        <input type="number" name="special_price" id="special_price" class="form-control" placeholder="Please enter sale price"  value="{{$product->sale_price}}">
                    </div>
                </div>


                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Sale Price Start Date</label>
                    <div class="col-sm-7">
                        <input type="text" name="special_price_start_date" id="special_price_start_date" class="form-control" value="{{date('m/d/Y',strtotime($product->sale_price_start_date))}}">
                    </div>

                </div>


                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Sale Price End Date</label>
                    <div class="col-sm-7">
                        <input type="text" name="special_price_end_date" id="special_price_end_date" class="form-control" value="{{date('m/d/Y',strtotime($product->sale_price_end_date))}}">
                    </div>

                </div>

            </div>



        <div class="step">

                <span class="steptext"> Step 6</span>
      <h4>Images</h4>
      <hr>

       <input type="file" name="file[]" id="filer_input1" multiple="multiple">

      <div id="ajaxDiv"></div>


@if($product_images->count() > 0)
          <div class="jFiler-items jFiler-row">
    <ul class="jFiler-items-list jFiler-items-grid">
      @foreach($product_images as $pi)
        <li class="jFiler-item" data-jfiler-index="0" style="" id="image{{$pi->id}}">
            <div class="jFiler-item-container">
                <div class="jFiler-item-inner">
                    <div class="jFiler-item-thumb">
                        <div class="jFiler-item-thumb-image">
                          <img src="{{$pi->image_medium}}" draggable="false" style="margin-top: 0px !important;">
                        </div>
                    </div>
                    <div class="jFiler-item-assets jFiler-row">
                        <ul class="list-inline pull-right">
                            <li>
                                <a class="icon-jfi-trash deleteImage jFiler-item-trash-action" data-id="{{$pi->id}}"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endif
        </div>



<div class="step">
    <span class="steptext"> Step 7</span>
    <h4>Paypal details</h4>
    <hr>
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
            <div class="test_paypal @if($paypalDetails) @if($paypalDetails->status == 1) hide @endif @else hide @endif">
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

    </form>




    <div class="clearfix"></div>
 <div style="margin-top:30px;">
<button class="action back btn btn-info">Back</button>
<button class="action next btn btn-info">Next</button>
<button class="action submit btn btn-success" type="button" id="submit-product">Submit</button>
</div>
        </div>
    </div>
</div>
@endsection

@section('section2')

@endsection

@section('footerscript')
<script type="text/javascript">
  var URL = '{{url("admin/product-images")}}';
  var PAGE = 'adminProducts';
  var URL1 = '{{url('admin/remove-product-image')}}';
</script>

<!-- select 2 -->
    <link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/connect/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('resources/assets/connect/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
<link href="{{ asset('resources/assets/connect/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css') }}" rel="stylesheet">
<script src="{{ asset('resources/assets/connect/assets/plugins/moment/moment.js') }}"></script>
 <script src="{{ asset('resources/assets/connect/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js') }}"></script>


<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />

<script src="{{ asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/filer/project-images.fileupload.init.js') }}" type="text/javascript"></script>

<script src="{{ asset('resources/assets/files/assets/pages/ckeditor/ckeditor.js') }}"></script>

<style type="text/css">
  .select2-container--default .select2-selection--multiple .select2-selection__clear{
    position: absolute;
    right: 0;
  }
  .jFiler-item .jFiler-item-container .jFiler-item-thumb img{
      margin-top: -136px !important;
    }
</style>

<script type="text/javascript">
    $(function(){

       var description = CKEDITOR.replace('description');
      var short_description = CKEDITOR.replace('short_description');
      var additional_information = CKEDITOR.replace('additional_information');

        $('#set_product_new_to_date,#special_price_start_date,#special_price_end_date').bootstrapMaterialDatePicker({ format: 'MM/DD/YYYY', weekStart : 0, time: false });

            /* ckeditor */

        $(document).on('click','#designer_recommended_uom',function(){
            var value = $(this).val();
            if(value == 'in'){
              $(".inches").removeClass('hide');
              $(".cms").addClass('hide');
            }else if(value == 'cm'){
              $(".inches").addClass('hide');
              $(".cms").removeClass('hide');
            }
        });



         $("#garment_type").select2({
            placeholder: "Please Select Garment Type",
            allowClear: true
        });

        $("#garment_construction").select2({
            placeholder: "Please Select Garment Construction",
            allowClear: true
        });

        $("#design_elements").select2({
            placeholder: "Please Select Design Elements",
            allowClear: true
        });

        $("#shoulder_construction").select2({
            placeholder: "Please Select Shoulder Construction",
            allowClear: true
        });

        $("#country_of_manufacture,#sub_category_name").select2();
        /* for multi select */




    });
</script>

<script>
    $(document).ready(function(){
    var current = 1;

    widget      = $(".step");
    btnnext     = $(".next");
    btnback     = $(".back");
    btnsubmit   = $(".submit");

    // Init buttons and UI
    widget.not(':eq(0)').hide();
    hideButtons(current);
    setProgress(current);

    // Next button click action
    btnnext.click(function(){
        if(current < widget.length){
                   widget.show();
                   widget.not(':eq('+(current++)+')').hide();
           setProgress(current);
           }
               hideButtons(current);
       })
       // Back button click action
       btnback.click(function(){
                if(current > 1){
            current = current - 2;
            btnnext.trigger('click');
        }
        hideButtons(current);
    });


    btnsubmit.click(function(){
        var Data = $("#product-insert").serializeArray();
       var description = CKEDITOR.instances.description.getData();
       var short_description = CKEDITOR.instances.short_description.getData();
       var additional_information = CKEDITOR.instances.additional_information.getData();

       Data.push({name: 'description', value: description});
       Data.push({name: 'short_description', value: short_description});
       Data.push({name: 'additional_information', value: additional_information});

        $.ajax({
           url : '{{ url("admin/update-product") }}',
           type : 'POST',
           data : Data,
            beforeSend : function(){
              $(".loadings").show();
            },
            success : function(res){

              if(res.status == 'Success'){
                Swal.fire(
                      'Great!',
                      'Product Added Successfully',
                      'success'
                    )
                setTimeout(function(){ window.location.assign('{{url("admin/browse-patterns")}}'); },2000);
              }else{
                Swal.fire(
                      'Oops!',
                      'Unable to add product, Try again after some time.',
                      'error'
                    )
              }

            },
            complete : function(){
             setTimeout(function(){ $(".loadings").hide(); },1000)
            }
        });
    });

$(document).on('click','#addNew',function(){
  var length = $('tr.trs').length;
  length = length + 1;
  var dd = '<tr class="trs" id="trs'+length+'"><td>'+length+'<input type="hidden" name="measurement_id[]" value="0"></td><td><input type="text" name="measurement_name[]" class="form-control" value="" placeholder="Measurement Name" ></td><td><input type="text" name="measurement_description[]" class="form-control" value="" placeholder="Measurement Notes"></td><td><input type="file" id="uploadImage'+length+'" class="uploadImage" data-id="'+length+'" ><input type="hidden" name="measurement_image[]" id="measurement_image'+length+'"></td><td><input type="number" name="min_value_inches[]" min="0" class="form-control" placeholder="Min value"><input type="number" name="max_value_inches[]" class="form-control" min="0" placeholder="Max value"></td><td><input type="number" name="min_value_cm[]" min="0" class="form-control" placeholder="Min value"><input type="number" name="max_value_cm[]" class="form-control" min="0" placeholder="Max value"></td><td><a href="javascript:;" data-id="'+length+'" data-mid="0" class="deleteM"><i class="fa fa-trash"></i></td></tr>';
  $("#tbody").append(dd);
});

$(document).on('click','.deleteM',function(){
  var id = $(this).attr('data-id');
  var mid = $(this).attr('data-mid');
  if(mid != 0){
    $.get('{{url("admin/delete-measurement")}}/'+mid);
  }
  $("#trs"+id).remove();
});


/* image upload */

$(document).on('change', '.uploadImage', function(){
  var id = $(this).attr('data-id');
  var name = document.getElementById("uploadImage"+id).files[0].name;
  var form_data = new FormData();
  var ext = name.split('.').pop().toLowerCase();
  if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
  {
   alert("Invalid Image File");
  }
  var oFReader = new FileReader();
  oFReader.readAsDataURL(document.getElementById("uploadImage"+id).files[0]);
  var f = document.getElementById("uploadImage"+id).files[0];
  var fsize = f.size||f.fileSize;
  if(fsize > 2000000)
  {
   alert("Image File Size is very big");
  }
  else
  {
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

   form_data.append("file", document.getElementById("uploadImage"+id).files[0]);
   $.ajax({
    url:"{{url('admin/upload-image')}}",
    method:"POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    beforeSend:function(){
     $('.loadings').show();
    },
    success:function(data)
    {
     if(data){
      $("#measurement_image"+id).val(data.path);
     }
    },
    complete : function(){
      $('.loadings').hide();
    }
   });
  }
 });


$(document).on('click','.deleteImage',function(){
  var id = $(this).attr('data-id');
  if(confirm('Aer you sure want to delete this image ?')){
    $.post(URL1,{id:id},function(res){
    if(res.status == 'Success'){
      $("#image"+id).remove();
    }
  });
  }
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

// Change progress bar action
setProgress = function(currstep){
    var percent = parseFloat(100 / widget.length) * currstep;
    percent = percent.toFixed();
    $(".progress-bar")
        .css("width",percent+"%")
        .html(percent+"% Completed");
}

// Hide buttons according to the current step
hideButtons = function(current){
    var limit = parseInt(widget.length);

    $(".action").hide();

    if(current < limit) btnnext.show();     if(current > 1) btnback.show();
    if (current == limit) { btnnext.hide(); btnsubmit.show(); }
}

</script>
@endsection
