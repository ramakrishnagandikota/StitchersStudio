@extends('layouts.designerapp')
@section('title','Measurements')
@section('content')
    <div class="pcoded-wrapper" id="dashboard">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
    <div class="page-body">

        <div class="col-md-12">
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
                                                    <div class="row card-bg">
                                                        <div class="col-lg-9 col-md-9 col-sm-9"><h5 class="theme-heading page-header-title f-w-600 m-b-15">Measurement profile</h5></div>
                                                        <div class="col-lg-3 col-sm-3 col-md-3 text-center">
                                                            <button id="add-measurement-profile-btn" class="btn waves-effect pull-right waves-light btn-primary theme-outline-btn createTemplate" ><i class="icofont icofont-plus"></i>Add measurement profile</button>
                                                        </div>

@if($measurements->count() > 0)
    @foreach($measurements as $meas)                                     <!-- measurement box -->
<div class="col-xl-2 col-md-6 col-grid-box">
    <div class="product-box">
        <div class="img-wrapper">
            <div class="front">
                <a href="#"><img src="{{ $meas->m_image }}" class="img-fluid blur-up lazyload bg-img" alt=""></a>
            </div>

        </div>
        <div class="product-detail">
            <div>
                <a href="{{ url('designer/measurements/'.base64_encode($meas->id).'/show') }}"><h5 class="m-t-10 min-height-heading">{{ $meas->m_title }}</h5></a>
                <div class="editable-items">
                    <a href="{{ url('designer/measurements/'.base64_encode($meas->id).'/show') }}" class="fa fa-pencil" style="padding: 10px;background: none;color: #0d665c;"></a>
                    <a class="fa fa-trash deleteMeasurements" data-id="{{ $meas->id }}" style="padding:10px;"></a>
                </div>
            </div>
        </div>
    </div>
</div>
    @endforeach
@else
        <div class="user-content card-bg m-l-40 m-r-40 m-b-40 col-md-11" style="background-color: #ececec;box-shadow: none;">
            <img src="{{ asset('resources/assets/files/assets/images/arrow.png') }}" id="arrow-img">
            <h3 class="m-t-40 text-muted">Let's Make Your First Measurement !</h3>
            <h4 class="text-muted m-t-10 m-b-30">A better way to manage your Measurement<br>
                awaits you right here....</h4>
        </div>
@endif                                                   <!-- measurement box -->

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
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="summernoteModal" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Measurement</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="tab-content card-block">
                                <div class="tab-pane active" id="Newone" role="tabpanel">
                                    <form id="create-template" method="POST" action="{{route("create.measurement.profile")}}">
                                        @csrf
                                        <label class="col-sm-12 form-label m-t-15">Measurement Name<span class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="m_title" id="m_title" placeholder="Enter measurement name">
                                        </div>

                                        <label class="col-sm-12 form-label m-t-15">UOM<span class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="radio" name="uom" id="uom" value="in" > Inches
                                            <input type="radio" name="uom" id="uom1" value="cm" > Centimeters
                                        </div>

                                        <div class="modal-footer">
                                            <button data-dismiss="modal" class="btn theme-outline-btn" >Close</button>
                                            <button type="submit" id="submit" class="btn theme-btn" id="createMeasurement" >Create</button>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
@endsection
@section('footerscript')
    <style>
        .dataTables_filter .form-control{margin-top: 0px;}
        .radio-btn{display: table;margin: 0 auto;top: -7px;}
        .table td, .table th {
            padding: 0.55rem 0.75rem;
            font-size: 14px;
        }
        .hide{
            display: none;
        }
        .modal-footer{
            padding: 0px !important;
            padding-top:1rem !important;
            border:0px !important;
        }
        .help-block {
            display: block;
            margin-top: 5px;
            *margin-bottom: 10px;
            color: #bc7c8f;
            font-weight:bold;
        }
        small, .small {
            font-size: 85%;
        }
        #example2_filter label:nth-child(1){
            float:right;
        }
        [type=radio] {
            position: relative !important;
            opacity: 1 !important;
            height: auto !important;
            width: auto !important;
        }
</style>

    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/e-commerce.css') }}">
    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/color17.css') }}" media="screen" id="color">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/left-menu.css') }}">

    <!-- slick js-->
    <script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/slick.js') }}"></script>
    <script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/menu.js') }}"></script>
    <script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/lazysizes.min.js') }}"></script>

    <script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/script.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">

    <link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
    <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('resources/assets/select2/select2.min.css') }}" >
    <script src="{{ asset('resources/assets/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('resources/assets/select2/select2-searchInputPlaceholder.js') }}"></script>

    <script>
        $(document).ready(function () {

            $(document).on('click','.createTemplate',function(){
                var options = {
                    backdrop: 'static',
                    keyboard: false
                };
                $("#summernoteModal").modal(options);
            });



            $('#create-template')
                .bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {
                        uom : {
                            message: 'The UOM is required.',
                            validators: {
                                notEmpty: {
                                    message: 'The UOM is required.'
                                }
                            }
                        },
                        m_title: {
                            message: 'The measurement name is required.',
                            validators: {
                                notEmpty: {
                                    message: 'The measurement name is required.'
                                },
                                remote: {
                                    url: '{{ route("designer.check.measurement.name") }}',
                                    message: 'The template name is already in use. Please enter another one.'
                                },
                                regexp: {
                                    regexp: /^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/,
                                    message: 'The template name can only consist of alphabets, numbers and spaces.'
                                }
                            }
                        }

                    }
                }).on('status.field.bv', function(e, data) {
                data.bv.disableSubmitButtons(false);
            }).on('success.form.bv', function(e) {
                e.preventDefault();
                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');

                var Data = $("#create-template").serializeArray();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("designer.create.measurement.profile") }}',
                    type : 'POST',
                    data : Data,
                    beforeSend : function (){
                        $(".loading").show();
                    },
                    success : function(response){
                        if(response.status == 'success'){
                            notification('fa-check','success','Measurement created successfully.','success');
                            setTimeout(function (){
                                window.location.assign(response.URL);
                            },1500);
                        }else{
                            notification('fa-times','Error','Unable to create measurement.Try again','danger');
                            setTimeout(function (){
                                location.reload();
                            },1500);
                        }
                    },
                    complete : function (){
                        setTimeout(function (){
                            $(".loading").hide();
                        },1500);
                    },
                    error : function (){

                    }
                });
            });



            $(document).on('click','.deleteMeasurements',function(){
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Are you sure ?',
                    text: "You want to delete the measurement profile.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value == true) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url : '{{ route('designer.measurements.delete') }}',
                            type : 'POST',
                            data : 'id='+id,
                            beforeSend : function(){
                                $(".loading").show();
                            },
                            success : function(res){
                                if(res.status == 'success'){
                                    setTimeout(function(){ location.reload(); },1500);
                                    Swal.fire(
                                        'Deleted!',
                                        'The measurement profile has been deleted.',
                                        'success'
                                    );

                                }else{
                                    Swal.fire(
                                        'Oops!',
                                        'Unable to delete measurement profile,Try again later.',
                                        'danger'
                                    );
                                }
                            },
                            complete : function(){
                                $(".loading").hide();
                            },
                            error : function (jqXHR,testStatus){
                                console.log("Error"+ testStatus);
                            }
                        })

                    }
                });
            });


        });
    </script>
@endsection
