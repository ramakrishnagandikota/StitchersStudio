<!--Section for Extenral Patterns Starts here-->
<div class="card-block external-pattern">
<div class="row">
<div class="col-lg-8 col-sm-12">
<!--First Accordion Starts here-->
<div class="row theme-row m-b-10">
<div class="card-header accordion active col-lg-12 col-sm-12"
    data-toggle="collapse" data-target="#design-external">
    <h5 class="card-header-text">Design
    </h5><i class="fa fa-caret-down pull-right micro-icons"></i>
</div>

</div>
<div class="card-block collapse show" id="design-external">
<div class="row form-group">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label">Name<span class="red">*</span>
            </label>
            <div class="row">
                    <div class="col-md-12">
                        <input type="text" name="project_name" id="project_name" class="form-control"
                        placeholder="Off-the-Shoulder Ruffle Top">
                        <span class="project_name red hide">Project name is required.</span>
                    </div>
                </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label">Description<span class="red">*</span>
            </label>
            <div class="row">
                    <div class="col-md-12">
                        <textarea  rows="2" cols="5"
            class="form-control" name="description" id="description"
            placeholder=""></textarea>
            <span class="description red hide">Description is required.</span>
                    </div>
                </div>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="form-group row">
        <div class="col-lg-12">
<!-- Upload  -->
<label class="col-sm-12 col-form-label">Upload a file<span class="red">*</span></label>
<br>    <br>
        </div>

        <div class="col-lg-12 m-l-15">
            <div class="row">
                  <div class="col-lg-12">
<input required type="file" name="file[]" id="filer_input1" multiple="multiple" style="width: 600px;">
<p class="image red hide">Upload atleast one image (allowed jpg,jpeg,png,pdf).</p>

<span class="red" style="position: absolute;bottom: 24px;">*</span>
<label class="container m-r-10" style="padding-top: 0 !important;">I verify that I have purchased this pattern and I have the right to use this pattern.
    <input type="checkbox" id="checkme" name="user_verify" value="1" />
    <span class="checkmark"></span>
</label>
<span class="checkme red hide">Verify that you have purchaced the pattern.</span>
</div>
</div>
</div>
</div>
    </div>
</div>
<!--End of First Accordion-->

<!--Second Accordion Starts here-->
<div class="row theme-row m-b-10">
<div class="card-header accordion col-lg-12"
    data-toggle="collapse" data-target="#yarn-external">
    <h5 class="card-header-text">Yarn and tools</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
</div>

</div>
<div class="card-block collapse" id="yarn-external">
<!-- <div class="row form-group">
    <div class="col-md-5">
        <div class="form-group">
            <label class="col-form-label">Reference a measurement profile
                <span class="mytooltip tooltip-effect-2">
                    <span class="tooltip-item">?</span>
                    <span class="tooltip-content clearfix">

                      <span class="tooltip-text" style="width: 100%;">Add a measurement profile for reference--this will not affect the available sizes in an external or non-custom pattern.</span>
                  </span>
            </label>
            <div class="row">
                    <div class="col-md-12">
                        <select class="form-control" id="sel1">
                            <option>For Jack</option>
                            <option>For Rose</option>
                            <option>For Rock</option>
                        </select>
                    </div>
                </div>
        </div>
    </div>
</div> -->
<div class="row form-group" id="yarn-row-external">
    <div class="col-lg-8 row-bg">
        <h6 class="m-b-10">Yarn</h6>
    </div>
    <div class="col-lg-4 text-right row-bg">
        <button type="button"
        class="btn small-btn add-yarn f-12 theme-outline-btn btn-primary waves-effect waves-light" id="external"><i class="icofont icofont-plus f-12"></i>Add yarn</button>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="col-form-label">Yarn used
                <span class="mytooltip tooltip-effect-2">
                    <span class="tooltip-item">?</span>
                    <span class="tooltip-content clearfix">
                      <!-- <img src="../../files/assets/images/tooltip/fabric.jpg" alt=""> -->
                      <span class="tooltip-text" style="width: 100%;">Enter the yarn you used for this pattern.</span>
                  </span>
            </label>
            <div class="row">
                    <div class="col-md-12">
                        <input type="text" name="yarn_used[]" id="yarn_used1" class="form-control"
                        placeholder="Lion Brand Yarn 135-189 Hometown Yarn">
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
                      <span class="tooltip-text" style="width: 100%;">Enter the fiber content of the yarns use.</span>
                  </span>
            </span>
            </label>
            <div class="row">
                    <div class="col-md-12">
                    <input type="text" class="form-control" name="fiber_type[]" id="fiber_type1" placeholder="Combed cotton woollen" >
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
                        <select class="form-control" name="yarn_weight[]" id="yarn_weight1">
                            <option value="Lace">Lace</option>
                            <option value="Super Fine">Super Fine</option>
                            <option value="Fine">Fine</option>
                            <option value="Light">Light</option>
                            <option value="Meduim">Meduim</option>
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
                        <input type="text" class="form-control" id="skeins1" name="skeins[]">

                    </div>

                </div>
        </div>
    </div>

</div>

<div class="row form-group" id="needle-row-external">
    <div class="col-lg-8 row-bg">
        <h6 class="m-b-10">Needle size</h6>
    </div>
    <div class="col-lg-4 text-right row-bg">
        <button type="button"
        class="btn small-btn add-needle f-12 theme-outline-btn btn-primary waves-effect waves-light" id="external"><i class="icofont icofont-plus f-12"></i>Add Needle</button>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="col-form-label">Needle size used
                <span class="mytooltip tooltip-effect-2">
                    <span class="tooltip-item">?</span>
                    <span class="tooltip-content clearfix">
                      <!-- <img src="../../files/assets/images/tooltip/yarn.jpg" alt=""> -->
                      <span class="tooltip-text" style="width: 100%;">Select the needle size from the dropdown.</span>
                  </span>
            </label>
            <div class="row">
                    <div class="col-md-12">
                        <select class="form-control" id="needle_size1" name="needle_size[]">
                            <option selected value="0">Select needle size</option>
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

<!--Third Accordion-->
<div class="row theme-row m-b-10">
<div class="card-header accordion col-lg-12"
    data-toggle="collapse" data-target="#gauge-ext">
    <h5 class="card-header-text">Gauge</h5>
    <i class="fa fa-caret-down pull-right micro-icons"></i>
</div>
</div>
<div class="card-block collapse" id="gauge-ext">
<div class="row">
    <div class="col-lg-12">
        <div class="form-radio">
            <h6 class="text-muted m-b-10">Unit of measurement</h6>

                        <div class="radio radio-inline m-r-10">
                            <label>
                                <input type="radio" id="inches-external" name="uom" checked="checked" value="in">
                                <i class="helper"></i>Inches
                            </label>
                        </div>
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" name="uom" id="cm-external" value="cm">
                                <i class="helper"></i>Centimeters
                            </label>
                        </div>


                    <br>
                </div>
    </div>
</div>
<div class="row form-group">
    <div class="col-md-4">
        <div class="form-group">
            <label class="col-form-label">Stitch gauge
                <span class="mytooltip tooltip-effect-2">
                    <span class="tooltip-item">?</span>
                    <span class="tooltip-content clearfix">
                      <!-- <img src="../../files/assets/images/tooltip/yarn.jpg" alt=""> -->
                      <span class="tooltip-text" style="width: 100%;">Stitch gauge refers to the number of stitches counted horizontally across your 4-inch or 10 cm swatch.
                        <!--ease for reference. It will not affect pattern instructions in external or non-custom patterns.--></span>
                  </span>
            </label>
            <div class="row">
                    <div class="col-md-12">
                        <select class="form-control" name="stitch_gauge_in" id="stitch-sts-external">
                            <option selected value="0">Select value (inches)</option>
                            @foreach($gaugeconversion as $gc)
                            <option value="{{$gc->id}}">{{$gc->stitch_gauge_inch .' / inch'}}</option>
                            @endforeach
                        </select>

                        <select class="form-control" name="stitch_gauge_cm" id="stitch-cm-external">
                            <option selected value="0">Select value (cm)</option>
                            @foreach($gaugeconversion as $gc1)
                            <option value="{{$gc1->id}}">{{$gc1->stitches_10_cm .' / 10cm'}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="col-form-label">Row gauge
                <span class="mytooltip tooltip-effect-2">
                    <span class="tooltip-item">?</span>
                    <span class="tooltip-content clearfix">
                      <!-- <img src="../../files/assets/images/tooltip/yarn.jpg" alt=""> -->
                      <span class="tooltip-text" style="width: 100%;">Row gauge refers to the number of stitches counted vertically across your 4-inch or 10 cm swatch.</span>
                  </span>
            </label>
            <div class="row">
                    <div class="col-md-12">
                        <select class="form-control" name="row_gauge_in" id="row-sts-external">
                            <option value="0" >Select value (inches)</option>
                            @foreach($gaugeconversion as $gc2)
                            <option value="{{$gc2->id}}">{{$gc2->row_gauge_inch .' /inch'}}</option>
                            @endforeach
                        </select>

                        <select class="form-control" name="row_gauge_cm" id="row-cm-external">
                            <option selected value="0">Select value (cm)</option>
                            <option>12 sts / 10 cm</option>
                            @foreach($gaugeconversion as $gc3)
                            <option value="{{$gc3->id}}">{{$gc3->rows_10_cm .' / 10cm'}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>
<!--End of Third Accordion-->

<!--Fourth Accordion Starts here-->
<div class="row theme-row m-b-10">
<div class="card-header accordion col-lg-12"
data-toggle="collapse" data-target="#section4-EXT">
<h5 class="card-header-text">Measurement profile and ease</h5>
<i class="fa fa-caret-down pull-right micro-icons"></i>
</div>
</div>
<div class="card-block collapse" id="section4-EXT">
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
                                <span class="red hide mprofile">Please select measurement profile.</span>
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label class="col-form-label">Your
                        ease preference
                         <span class="mytooltip tooltip-effect-2">
                            <span class="tooltip-item">?</span>
                            <span class="tooltip-content clearfix">
                              <span class="tooltip-text" style="width:100%">Enter the amount of ease for reference. It will not affect pattern instructions in external or non-custom patterns.</span>
                          </span>
                    </span>
                    </label>
                    <div class="row">
                            <div class="col-md-12">
                                <select id="inches-ease-prefer-ext" name="ease_in" class="form-control">
                                    <option value="0" selected disabled >Select value (inches)</option>
                                    @for($j=1;$j<= 20;$j+= 0.25)
                                        <option value="{{$j}}">{{$j}}"</option>
                                    @endfor
                                </select>

                                <select id="sts-ease-prefer-ext" name="ease_cm" class="form-control">
                                    <option value="0" selected disabled >Select value (cm)</option>
                                    @for($i=1;$i <= 20;$i+= 0.5)
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

<div class="form-group row">
    <!-- <label class="col-sm-12 col-lg-12 col-form-label">Knitted For</label> -->
     <span class="profile-upload">
          <!--  <label for="profile-upload">
                    <img src=" asset('resources/assets/files/assets/images/pencil.png') }}"/>
                </label>
        <input id="profile-upload" type='file' onchange="readprofileURL(this);" /> -->
            </span>
    <div class="col-sm-12 col-lg-12">
       <!-- <img id="profile-img-external-pattern" src="{{url('resources/assets/files/assets/images/user-card/pattern.jpg')}}"
            alt="" style="width:100%; "> -->

    </div>
</div>
</div>
</div>
<div class="col-lg-6 col-sm-12">
</div>
<div class="form-group m-t-20">
<div class="col-sm-12">
<div class="text-center m-b-10">
<a href="#!" id="edit-cancel"
    class="btn theme-outline-btn btn-primary waves-effect waves-light m-r-10">Cancel</a>
<!-- <a href="#!"
    class="btn theme-outline-btn btn-primary waves-effect waves-light">Save</a> -->
    <button type="button"
    class="btn theme-btn btn-primary waves-effect waves-light m-l-10" id="save" disabled >Create Project
</button>
</div>
</div>
</div>
</div>
<!--Section for External Patterns Ends here-->

<script src="{{ asset('resources/assets/files/assets/pages/filer/project-library-jquery.fileuploads.init.js') }}" type="text/javascript"></script>
