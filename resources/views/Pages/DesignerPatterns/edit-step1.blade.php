@extends('layouts.knitterapp')
@section('title','My Patterns')
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
                        <div class="col-lg-12">
                            <ul class="nav nav-tabs md-tabs" role="tablist">
                                <li class="nav-item nav-tab1">
                                    <a class="nav-link active show" data-toggle="tab" href="#basic-p-details" role="tab" aria-selected="false">
                                        <button class="btn theme-btn btn-icon-tab waves-effect waves-light">
                                            <span id="tab-no1">1</span>
                                        </button>Basic details</a>
                                    <div class="slide"></div>
                                </li>
                                <li class="nav-item nav-tab2">
                                    <a class="nav-link" data-toggle="tab" href="#P-details" role="tab" aria-selected="false"><button class="btn theme-btn btn-icon-tab waves-effect waves-light">
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

                                <div class="tab-pane active show" id="basic-p-details" role="tabpanel">
                                    <form class="form-horizontal" id="create-pattern" action="{{ url('designer/update-pattern-step') }}">
                                        <input type="hidden" name="product_id" id="product_id" value="{{ base64_encode($product->id) }}">
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
                                                            <a href="javascript:;" class="moreImages pull-right" style="text-decoration: underline;">Add more images</a>
                                                        </div>
                                                        <div class="card-block @if($product->patternImages()->count() > 0) hide @endif" id="moreImages">
                                                            <!-- <div class="sub-title">Example 1</div> -->
                                                            <input type="file" name="product_images[]" id="product_images" multiple="multiple" disabled >
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
                                            <div class="form-group m-t-20">
                                                <div class="col-sm-12">
                                                    <div class="text-center m-b-10">
                                                        <button type="submit" class="btn theme-btn btn-primary waves-effect waves-light m-l-10" id="next-step1">Update basic details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!---------------------->
                                <div class="tab-pane" id="P-details" role="tabpanel"></div>
                                <!--Section for Pattern instruction Starts here-->
                                <div class="tab-pane" id="pattern-preview" role="tabpanel"></div>
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
                .hide{
                    display: none;
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
            <script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.js') }}"></script>
            <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

            <script>
                $(function (){
                    patternImages('product_images',URL,URL1);
                    //jqueryFiler('filer_input0',URL2,URL3,0);

                    $(".nav-tab2,.nav-tab3").find("a").prop("disabled", true);
                    $('.nav-tab2 a,.nav-tab3 a').css('cursor', 'not-allowed');
                    $('.nav-tab2 a,.nav-tab3 a').css('opacity', '.5');

                    var $validations = $('#create-pattern');
                    $validations.bootstrapValidator({
                        excluded: [':disabled'],
                        message: 'This value is not valid',
                        feedbackIcons: {
                            valid: '', //fa fa-check
                            invalid: '', //fa fa-exclamation
                            validating: 'fa fa-spinner fa-spin'
                        },
                        fields: {
                            product_name: {
                                message: 'The pattern name is not valid',
                                validators: {
                                    notEmpty: {
                                        message: 'The pattern name is required.'
                                    },
                                    regexp: {
                                        regexp: /^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/,
                                        message: 'The pattern name should have only alphabets, numbers and spaces.'
                                    }
                                }
                            },
                            about_description: {
                                message: 'The description name is not valid',
                                validators: {
                                    notEmpty: {
                                        message: 'Add some details about the pattern.'
                                    },
                                }
                            },
                            'product_images[]': {
                                message: 'The images name is not valid',
                                validators: {
                                    notEmpty: {
                                        message: 'Add some images for the pattern.'
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
                                notification('fa-times','Oops..','There are few errors in the form, Please refresh and try again.','danger');
                            }
                        }, 'json');
                    });

                    $(document).on('click','.moreImages',function (){
                        if($('#product_images').is(':disabled')){
                            $("#moreImages").html('<input type="file" name="product_images[]" id="product_images" multiple="multiple" >');
                            patternImages('product_images',URL,URL1);
                        }else{
                            //$("#product_images").prop('disabled',true);
                            $("#moreImages").html('<input type="file" name="product_images[]" id="product_images" multiple="multiple" disabled >');
                        }

                        $("#moreImages").toggle();
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
                                    $.get('{{ url("designer/delete-pattern-images")  }}/'+id,function (res){
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

                    $(document).on('click','.primaryImage',function(){
                        var id = $(this).attr('data-id');
                        var mainphoto = $(this).attr('data-mainphoto');
                        var product_id = $("#product_id").val();

                        var Data = 'id='+id+'&product_id='+product_id;

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
                                $.post('{{ url("designer/make-image-default") }}', Data, function(result) {
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

                });
            </script>
    @endsection