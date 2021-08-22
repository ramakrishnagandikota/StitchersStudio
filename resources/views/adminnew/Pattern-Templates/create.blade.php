@extends('layouts.adminnew')
@section('title','View pattern template')
@section('section1')

    <!-- modal -->
    <div class="modal fade" id="summernoteModal" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Template</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <ul class="nav nav-tabs md-tabs" role="tablist" style="width: 100%!important;">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#Newone" role="tab">Create New</a>
                                <div class="slide"></div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#Duplicate" role="tab">Duplicate</a>
                                <div class="slide"></div>
                            </li>
                        </ul>
                        <div class="col-lg-12">
                            <div class="tab-content card-block">
                                <div class="tab-pane active" id="Newone" role="tabpanel">
                                    <form id="create-template" method="POST" action="{{route("create.pattern.save")}}">
                                        @csrf
                                        <label class="col-sm-12 form-label">Variant Type<span class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <select name="design_type" id="design_type" class="form-control">
                                                <option value="" >Please select a variant type</option>
                                                @foreach($design_type_groups as $dtg)
                                                    <optgroup label="{{$dtg->design_type_name}}">
                                                        @php $design_type = App\Models\Patterns\DesignType::where('design_type_name',$dtg->design_type_name)->get(); @endphp
                                                        @foreach($design_type as $dt)
                                                            <option value="{{$dt->id}}" >{{$dt->design_varient_name}}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>

                                        <label class="col-sm-12 form-label m-t-15">Template Name<span class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="template_name" id="template_name" placeholder="Enter template name">
                                        </div>

                                        <div class="modal-footer">
                                            <a href="{{ route('pattern.templates.list') }}"  class="btn theme-outline-btn" >Close</a>
                                            <button type="submit" id="submit" class="btn theme-btn" id="createTemplate" >Create</button>
                                        </div>
                                    </form>

                                </div>
                                <div class="tab-pane" id="Duplicate" role="tabpanel">
                                    <div class="m-t-10">
                                        @if($templates->count() > 0)

                                            <form id="duplicateTemplate" method="POST" action="{{route("duplicate.template")}}">

                                                <label class="col-sm-12 form-label">Select Template name<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <select name="template_id" id="template_id" class="form-control">
                                                        <option value="">Select template</option>
                                                        @foreach($templates as $temps)
                                                            <option value="{{ $temps->id }}">{{ $temps->template_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <label class="col-sm-12 form-label">New template name<span class="text-danger">*</span></label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="new_template_name" name="new_template_name" value="" placeholder="Enter new template name">
                                                </div>

                                                <div class="modal-footer">
                                                    <a href="{{ route('pattern.templates.list') }}" class="btn theme-outline-btn" >Close</a>
                                                    <button type="submit" class="btn theme-btn" id="" >Duplicate</button>
                                                </div>
                                            </form>
                                        @else
                                            <p class="text-center">You don't have any available patterns for duplicating.</p>
                                        @endif
                                    </div>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
    <style>
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
    </style>
    <link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
    <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('resources/assets/select2/select2.min.css') }}" >
    <script src="{{ asset('resources/assets/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('resources/assets/select2/select2-searchInputPlaceholder.js') }}"></script>

    <script>
        $(function(){
            $("#template_id").select2();
            var options = {
                backdrop: 'static',
                keyboard: false
            };
            $("#summernoteModal").modal(options);


            $('#create-template')
                .bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {

                        design_type: {
                            message: 'The design type is required.',
                            validators: {
                                notEmpty: {
                                    message: 'The design type is required.'
                                }
                            }
                        },
                        template_name: {
                            message: 'The template name is required.',
                            validators: {
                                notEmpty: {
                                    message: 'The template name is required.'
                                },
                                remote: {
                                    url: '{{ route("check.template.name") }}',
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

                var design_type_id = $("#design_type").val();
                var template_name = $("#template_name").val();

                var Data = 'design_type_id='+design_type_id+'&template_name='+template_name;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("create.pattern.save") }}',
                    type : 'POST',
                    data : Data,
                    beforeSend : function (){
                        $(".loading").show();
                    },
                    success : function(response){
                        if(response.status == 'success'){
                        notification('fa-check','success','Template created successfully.','success');
                            setTimeout(function (){
                                window.location.assign(response.URL);
                            },1500);
                        }else{
                        notification('fa-times','Error','Unable to create template.Try again','danger');
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


            $('#duplicateTemplate')
                .bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {

                        template_id: {
                            message: 'Select template to duplicate.',
                            validators: {
                                notEmpty: {
                                    message: 'Please select a existing template.'
                                }
                            }
                        },
                        new_template_name: {
                            message: 'The template name is required.',
                            validators: {
                                notEmpty: {
                                    message: 'The template name is required.'
                                },
                                remote: {
                                    url: '{{ route("check.template.name") }}',
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
                var template_id = $("#template_id").val();
                var new_template_name = $("#new_template_name").val();

                var Data = 'template_id='+template_id+'&new_template_name='+new_template_name;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("duplicate.template") }}',
                    type : 'POST',
                    data : 'template_id='+template_id+'&new_template_name='+new_template_name,
                    beforeSend : function (){
                        $(".loading").show();
                    },
                    success : function (res){
                        if(res.status == 'success'){
                            notification('fa-check','success','Template created successfully.','success');
                            setTimeout(function(){ location.reload(); },1500);
                        }else{
                            notification('fa-times','Oops!','Unable to create template.Try again.','danger');
                        }
                    },
                    complete : function (){
                        $(".loading").hide();
                    },
                    error : function (){

                    }
                });
            });

        });
    </script>
@endsection
