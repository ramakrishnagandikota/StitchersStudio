@extends('layouts.knitterapp')
@section('title','Support')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-lg-12">
                <label class="theme-heading f-w-600 m-b-20">Create Ticket
                </label>
                <label class="f-w-600 m-b-20 pull-right"><a href="{{ url('support') }}" class="theme-heading"><i class="fa fa-arrow-left"></i>&nbsp;Back to support</a></label>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-lg-12">
                <div class="card p-30">
                    <form id="support-ticket">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="int1">Question related to<span class="red">*</span></label>
                                <div class="row">
                                    <div class="col-md-12 ui-widget select-topic">
                                        <select class="form-control form-control-default" id="query_related_to" name="query_related_to">
                                            <option value="" selected>Select topic</option>
                                            <optgroup label="Pattern information">
                                                <option value="Pattern information - Pattern name">Pattern name</option>
                                                <option value="Pattern information - Designer name">Designer name</option>
                                                <option value="Pattern information - Brand name">Brand name</option>
                                                <option value="Pattern information - Description">Description</option>
                                                <option value="Pattern information - Designer recommendations">Designer recommendations</option>
                                                <option value="Pattern information - Price">Price</option>
                                                <option value="Pattern information - Paypal details">Paypal details</option>
                                            </optgroup>
                                            <optgroup label="Shopping page listing">
                                                <option value="Shopping page listing - Pattern description">Pattern description</option>
                                                <option value="Shopping page listing - Pattern details">Pattern details</option>
                                                <option value="Shopping page listing - Materials">Materials</option>
                                                <option value="Shopping page listing - Gauge instruction">Gauge instruction</option>
                                            </optgroup>
                                            <optgroup label="Pattern instructions">
                                                <option value="Pattern instructions - Images">Images</option>
                                                <option value="Pattern instructions - Order of pattern sections">Order of pattern sections</option>
                                                <option value="Pattern instructions - Missing section">Missing section</option>
                                                <option value="Pattern instructions - Incorrect instructions">Incorrect instructions</option>
                                            </optgroup>
                                            <option value="Paypal account or payment issue">Paypal account or payment issue</option>
                                            <option value="Images">Images</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row show-details">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="int1">Pattern name<span class="red">*</span></label>
                                <div class="row">
                                    <div class="col-md-12 ui-widget" id="p_name" >
                                        <select class="form-control form-control-default" id="pattern_name" name="pattern_name">
                                            @if($orders->count() > 0)
                                                <option value=""></option>
                                                @foreach($orders as $ord)
                                                    <option value="{{ $ord->pid }}">{{ $ord->product_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-12 ui-widget hide" id="o_name">
                                        <input type="text" class="form-control form-control-default" id="other_name" name="other_name">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="int1">Priority<span class="red">*</span></label>
                                <div class="row">
                                    <div class="col-md-12 ui-widget">
                                        <select class="form-control form-control-default" id="priority" name="priority">
                                            <option value="" selected>Priority</option>
                                            <option value="3">High</option>
                                            <option value="2">Medium</option>
                                            <option value="1">Low</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="int1">Related url</label>
                                <div class="row">
                                    <div class="col-md-12 ui-widget">
                                        <input type="text" class="form-control hover-placeholder ui-autocomplete-input" id="related_url" name="related_url" value="" autocomplete="off" placeholder="Enter related url">
                                        <small>Please cut and paste the url from the browser into this field</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="int1">Ticket subject<span class="red">*</span></label>
                                <div class="row">
                                    <div class="col-md-12 ui-widget">
                                        <input type="text" class="form-control hover-placeholder ui-autocomplete-input" id="subject" name="subject" value="" placeholder="Enter ticket subject">
                                        <small>In general, what is this ticket about?</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="int1">Ticket description<span class="red">*</span></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <textarea class="form-control summernote" id="description" name="description" placeholder="Enter your query in detail"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <!-- File upload card start -->
                            <div class="card">
                                <div class="card-header">
                                    <h5>Attachments</h5>
                                </div>
                                <div class="card-block">
                                    <!-- <div class="sub-title">Example 1</div> -->
                                    <input type="file" name="files[]" id="filer_input1" multiple="multiple">
                                </div>
                            </div>
                            <!-- File upload card end -->
                        </div>

                        <div class="col-sm-12">
                            <div class="text-center m-b-10">
                                <button type="submit" class="btn theme-btn btn-primary waves-effect waves-light m-l-10">Submit Ticket</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
	@endsection
    @section('footerscript')
        <style>
            body{
                font-size: 1rem;
            }
            .subscription{color: #c14d7d;}
            .subscription{
                animation:blinkingText 1.2s infinite;
            }
            @keyframes blinkingText{
                0%{     color: #c14d7d    }
                49%{    color:#c14d7d  }
                60%{    color: transparent; }
                99%{    color:transparent;  }
                100%{   color: #c14d7d;     }
            }
            .note-color,.note-insert,.note-view{display: none;}
            .jFiler-input-choose-btn{background-color: transparent;
                border: 1px solid #0d665c;
                color: #0d665c !important;font-weight: 300;
                border-radius: 0px;}
            .form-control{
                font-size: 14px !important;
            }
            .red,.help-block{
                color: red;
            }
            .select2-container--default .select2-selection--single .select2-selection__arrow{
                top:3px !important;
            }
            span.select2-selection--single{
                border-color: #d6d6d6 !important;
                color: #5f5d5d !important;
                font-weight: 600 !important;
                border-radius: 2px !important;
                border: 1px solid #ccc !important;
                display: block !important;
                width: 100% !important;
                line-height: 1.5 !important;
                background-color: #fff !important;
                background-clip: padding-box !important;
                transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out !important;
                height: 34px !important;
            }
            .hide{
                display: none;
            }
        </style>
        <script type="text/javascript">
            var URL = '{{url("support/uploadImage")}}';
            var URL1 = '{{url("support/removeImage")}}';
        </script>
		<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
    <!-- filer js -->
	
        <link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
        <link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />
        <script src="{{asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
        <script type="text/javascript" src="{{asset('resources/assets/files/assets/pages/filer/support-fileupload.init.js')}}"></script>
    <!-- summernote -->
        <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/summernote/summernote.min.css') }}" />
        <script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.js') }}"></script>
    <!-- bootstrap validator -->
        <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>
    <!-- select 2-->
        <link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('resources/assets/connect/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

        <script>
            $(function (){

                $('.summernote').summernote({
                    height: 150,
                    placeholder: 'Enter your query in detail...',
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

                $("#pattern_name").select2({
                    placeholder: "Select a pattern name",
                    allowClear: true
                });

                var $validations = $('#support-ticket');
                $validations.find('[name="pattern_name"]')
                    .select2({
                        placeholder: "Select a pattern name",
                        allowClear: true
                    })
                    .change(function(e) {
                        $validations.data('bootstrapValidator').validateField('pattern_name');
                    }).end();
                $validations.bootstrapValidator({
                    excluded: [':disabled',':hidden'],
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {
                        query_related_to: {
                            message: 'The service field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Please select service related to your query.'
                                },
                            }
                        },
                        pattern_name: {
                            message: 'The pattern name is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Please select a pattern name from the list.'
                                },
                            }
                        },
                        other_name: {
                            message: 'The name is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Please add a name from the list.'
                                },
                            }
                        },
                        priority: {
                            message: 'The priority is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Please select priority of this ticket.'
                                },
                            }
                        },
                        subject: {
                            message: 'The subject is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Please enter subject.'
                                },
                            }
                        },
                        description: {
                            message: 'The description is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'Please enter detail about your query.'
                                },
                            }
                        },
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
                    var Data = $("#support-ticket").serializeArray();

                    $.ajax({
                       url : '{{ route("saveTicket") }}',
                       type : 'POST',
                       data: Data,
                        beforeSend : function (){
                            $(".loader-bg").show();
                        },
                        success : function (res){
                            if(res.status == true){
                                notification('fa-check','Yay..','Support ticket created successfully.','success');
                                $("#support-ticket")[0].reset();
                                setTimeout(function (){ window.location.assign('{{ url("support") }}'); });
                            }else{
                                notification('fa-times','Oops..','Unable to create a ticket. Try again after sometime.','danger');
                            }
                        },
                        complete : function (){
                            $(".loader-bg").hide();
                        },
                        error : function (){

                        }
                    });
                });

                $(document).on('change','#query_related_to',function(){
                    var value = $(this).val();
                    if(value == 'Other'){
                        $("#p_name").addClass('hide');
                        $("#o_name").removeClass('hide');
                    }else{
                        $("#o_name").addClass('hide');
                        $("#p_name").removeClass('hide');
                    }
                });

            });

        function validateDescription(id){
            $('#support-ticket').data('bootstrapValidator').revalidateField(id);
        }
        </script>
    @endsection
