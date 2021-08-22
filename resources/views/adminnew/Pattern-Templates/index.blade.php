@extends('layouts.adminnew')
@section('title','View pattern template')
@section('section1')
<div class="page-body">
    <div class="row">
        <div class="col-lg-6">
            <h5 class="theme-heading p-10">View template</h5>
        </div>
    </div>
    <div class="card p-20">
        <div class="dt-responsive table-responsive">
            <table id="example2"
                   class="table table-striped table-bordered nowrap">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Variant type</th>
                    <th>Name</th>
                    <th>Created on</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if($templates->count() > 0)
                    @foreach($templates as $temp)
                        <tr>
                            <th>{{$temp->id}}</th>
                            <td>{{$temp->design_varient_name}}</td>
                            <td>{{$temp->template_name}}</td>
                            <td>{{date('d-m-Y',strtotime($temp->created_at))}}</td>
                            <td>{{$temp->status == 1 ? 'Created' : 'Pending' }}</td>
                            <td>
                                <a href="{{ url('adminnew/pattern-template/'.base64_encode($temp->id).'/show') }}"><i class="fa fa-edit edit-btn m-r-5" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i></a>
                                <!--<a href="javascript:;"><i class="fa fa-copy copy-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copy"></i></a> -->
                                <a href="javascript:;" class="deleteTemplate" data-id="{{$temp->id}}"><i class="fa fa-trash delete-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" ></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal -->
<div class="modal fade" id="summernoteModal" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Template</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
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
                                    <button data-dismiss="modal" class="btn theme-outline-btn" >Close</button>
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
        <button data-dismiss="modal" class="btn theme-outline-btn" >Close</button>
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
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
<link rel="stylesheet" type="text/css" HREF="{{ asset('resources/assets/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/pages/data-table/css/buttons.dataTables.min.css') }}">
<!-- data-table js -->
<script src="{{ asset('resources/assets/files/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/data-table/js/jszip.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/data-table/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/data-table/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/jszip.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/bower_components/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/bower_components/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/extension-btns-custom.js') }}"></script>

<link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
<script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

<link rel="stylesheet" href="{{ asset('resources/assets/select2/select2.min.css') }}" >
<script src="{{ asset('resources/assets/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('resources/assets/select2/select2-searchInputPlaceholder.js') }}"></script>

<script>
    $(document).ready(function () {

        $("#template_id").select2();

        $('#example2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print',
                'csvHtml5',
                'pdfHtml5',
            ],
        });

        setTimeout(function(){
            var mybutton = $('<button style="font-size:14px;border-radius:2px" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right createTemplate" > Create new</button>');
            $('#example2_filter').append(mybutton);
        },1000);

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
                                message: 'The template name can only consist of letters, numbers and spaces.'
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

        $(document).on('click','.deleteTemplate',function(){
           var template_id = $(this).attr('data-id');

            Swal.fire({
                title: 'Are you sure ?',
                text: "You want to delete the template",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url : '{{ route("delete.pattern.template") }}',
                        type : 'POST',
                        data : 'template_id='+template_id,
                        beforeSend : function(){
                            $(".loading").show();
                        },
                        success : function(res){
                            if(res.status == 'success'){
                                setTimeout(function(){ location.reload(); },1500);
                                Swal.fire(
                                    'Deleted!',
                                    'The template has been deleted.',
                                    'success'
                                );

                            }else{
                                Swal.fire(
                                    'Oops!',
                                    'Unable to delete template,Try again later.',
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


      /*  $(document).on('click','#duplicateTemplate',function(){
           var template_id = $("#template_id").val();
           if(template_id == 0){
               $(".template_id").html('Please select template name.');
               return false;
           }else{
               $(".template_id").html('');
           }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

           $.ajax({
              url : '{{ route("duplicate.template") }}',
              type : 'POST',
              data : 'template_id='+template_id,
               beforeSend : function (){
                    $(".loading").show();
               },
               success : function (res){
                    if(res.status == 'success'){
    notification('fa-check','success','Template created successfully.','success');
    //setTimeout(function(){ location.reload(); },1500);
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
        }); */
    });
</script>
@endsection
