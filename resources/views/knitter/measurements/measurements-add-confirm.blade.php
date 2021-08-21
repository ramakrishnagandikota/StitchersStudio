@extends('layouts.knitterapp')
@section('title','Knitter Dashboard')
@section('content')

<div class="pcoded-wrapper">

<div class="pcoded-content">

<div class="pcoded-inner-content">
<div class="main-body">
<h5 class="theme-heading m-b-20 f-18 m-t-10">Please confirm your measurements</h5>
<div class="page-wrapper">
    <!-- Page-body start -->
    <div class="page-body"> 
        <div class="row card">
            <div class="col-lg-12">
                <div class="container">
                    <h5 class="card-header-text theme-heading">Body Size</h5>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                   <label>Hips</label>
                                </div>
                                <div class="col-lg-6">
                                   <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row m-b-20">
                                <div class="col-lg-6">
                                    <label>Waist</label> 
                                </div>
                                <div class="col-lg-6">
                           <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-b-20">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Waist Front</label>
                                </div>
                                <div class="col-lg-6">
                                   <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Bust / Chest</label>
                                </div>
                                <div class="col-lg-6">
                           <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row m-b-20">
                                <div class="col-lg-6">
                                    <label>Bust Front</label>
                                </div>
                                <div class="col-lg-6">
                                   <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Bust Back</label>
                                </div>
                                <div class="col-lg-6">
                           <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <h5 class="card-header-text theme-heading m-t-30">Body Length</h5>
                    <hr>
                    <div class="row m-b-20">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Waist to Underarm</label>
                                </div>
                                <div class="col-lg-6">
                                   <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Armhole Depth</label>
                                </div>
                                <div class="col-lg-6">
                           <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="card-header-text theme-heading m-t-30">Arm Size</h5>
                    <hr>
                    <div class="row m-b-20">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Wrist Circumference</label>
                                </div>
                                <div class="col-lg-6">
                                   <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Forearm Circumference</label>
                                </div>
                                <div class="col-lg-6">
                           <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-b-20">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Upperarm Circumference</label>
                                </div>
                                <div class="col-lg-6">
                                   <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row m-b-20">
                                <div class="col-lg-6">
                                   <label>Shoulder Circumference</label>
                                </div>
                                <div class="col-lg-6">
                           <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="card-header-text theme-heading m-t-30">Arm Length</h5>
                    <hr>
                    <div class="row m-b-20">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Length to Underarm</label>
                                </div>
                                <div class="col-lg-6">
                                   <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Length Wrist to Elbow</label>
                                </div>
                                <div class="col-lg-6">
                           <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-b-20">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Length Elbow to Underarm</label>
                                </div>
                                <div class="col-lg-6">
                                   <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row m-b-20">
                                <div class="col-lg-6">
                                    <label>Arm Length to Top of Shoulder</label>
                                </div>
                                <div class="col-lg-6">
                           <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="card-header-text theme-heading m-t-30">Neck and Shoulders</h5>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Depth of Neck (base at shoulder to sternum)</label>
                                </div>
                                <div class="col-lg-6">
                                   <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row m-b-20">
                                <div class="col-lg-6">
                                    <label>Neck Width</label>
                                </div>
                                <div class="col-lg-6">
                           <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Neck Circumference</label>
                                </div>
                                <div class="col-lg-6">
                                   <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row m-b-20">
                                <div class="col-lg-6">
                                    <label>Neck to Shoulder</label>
                                </div>
                                <div class="col-lg-6">
                           <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>Shoulder to Shoulder</label>
                                </div>
                                <div class="col-lg-6">
                            <input class="form-control hover-placeholder" type="text" value="1.6" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center m-t-30 m-b-30">
                        <div class="col-lg-12">
                            <a href="#!" id="edit-cancel" class="btn btn-default waves-effect m-r-10">Cancel</a>
                            <a href="#!" class="btn theme-btn btn-primary waves-effect waves-light">Submit</a>
                    </div>
                </div>
                  </div>
            </div>
           
        </div>
        
    </div>
            </div>
            <!-- Page-body end -->
        </div>
    </div>
</div>
</div>

@endsection
@section('footerscript')

@endsection