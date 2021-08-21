@extends('layouts.knitterapp')
@section('title','Create group')
@section('content')
<div class="pcoded-wrapper" id="dashboard">
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">

    <div class="page-body">
        <div class="row">
            <div class="col-xl-12">
                <label class="theme-heading f-w-600 m-b-20">Create group
                </label>
                <!-- To Do Card List card start -->
                <div class="card">
                    <div class="row">
                        <form id="createGroup" class="col-lg-12 col-sm-12" action="{{ url('designer/createGroup') }}">
                        <div class="col-lg-12">
                            <div class="card-block pattern-details">
                                <div class="row">
                                        <!--First Accordion Starts here-->
                                        <div class="custom-card-block" id="section1">
                                            <div class=" row">
                                                <div class="form-group col-md-4 m-b-20">
                                                    <label class="form-label">Group name<span class="kf-pink">*</span></label>
                                                    <input type="text" name="group_name" value="" id="group_name" class="form-control" placeholder="Enter group name">
                                                </div>

                                                <div class="form-group col-md-4 m-b-20">
                                                    <label class="form-label">Type of group<span class="kf-pink">*</span></label>
                                                    <select name="group_type" id="group_type" class="form-control form-control-default fill"></select>
                                                    <small><a style="color: #c14d7d" onclick="openCategory()" href="javascript:;">Click here</a> to see / add group types.</small>
                                                </div>

                                                <div class="form-group col-md-4 m-b-20">
                                                    <label class="form-label">Select pattern</label>
                                                    <select name="product_name" id="product_name" class="form-control form-control-default fill">
                                                        <option value="" disabled selected >Please select pattern name</option>
                                                        @foreach($products as $pro)
                                                        <option value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                

                                                <div class="form-group col-md-8 m-b-20">
                                                    <label class="form-label">Group description<span class="kf-pink">*</span></label>
                                                    <textarea type="text" cols="1" rows="1" name="group_description" placeholder="Enter group description" id="group_description" class="form-control"></textarea>
                                                </div>

                                                <div class="form-group col-md-4 m-b-20">
                                                    <label class="form-label">Expertise level expected<span class="kf-pink">*</span></label>
                                                    <select name="expertise_level" id="expertise_level" class="form-control form-control-default fill">
                                                        <option value="">Please select a option</option>
                                                        <option value="Beginner">Beginner</option>
                                                        <option value="Avanced-beginner">Advanced beginner</option>
                                                        <option value="Intermediate">Intermediate</option>
                                                        <option value="Proficient">Proficient</option>
                                                        <option value="Expert">Expert</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-4 m-b-20">
                                                    <label class="form-label">Start date<span class="kf-pink">*</span></label>
                                                    <input type="date" name="start_date" placeholder="Please select date" id="start_date" class="form-control">
                                                </div>

                                                <div class="form-group col-md-4 m-b-20">
                                                    <label class="form-label">End date<span class="kf-pink">*</span></label>
                                                    <input type="date" name="end_date" placeholder="Please select date" id="end_date" class="form-control">
                                                </div>

                                                <div class="form-group col-md-4 m-b-20">
                                                    <label class="form-label">Status<span class="kf-pink">*</span></label>
                                                    <select name="status" id="status" class="form-control form-control-default fill">
                                                        <option value="">Please select option</option>
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Upload group image</label>
                                                    <input type="file" name="file[]" id="groups_images">
                                                </div>
                                            </div>
                                        </div>

                                        <!--End of First Accordion-->
                                    </div>

                                </div>

                                <div class="form-group m-t-20">
                                    <div class="col-sm-12">
                                        <div class="text-center m-b-10">
                                            <button type="submit" id="create-group" class="btn theme-btn btn-primary waves-effect waves-light m-l-10">Create group</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <!-- To Do Card List card end -->
            </div>
        </div>
    </div>

</div>
</div>
</div>
</div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleHeading">Group Types</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <div class="row">
                        <div class="col-md-12" id="categoryModal"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">
                        Done
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('footerscript')
        <style>
            select2-container--default .select2-selection--single {
                background-color: #fff;
                border: .4px solid #cccccc;
                border-radius: 2px;
            }
            .select2-container .select2-selection--single{height: 32px;}
            .kf-pink{
                color: red;
            }
            .help-block{
                color: red;
            }
            .glyphicon-ok:before {
                content: "\2714";
            }
            .glyphicon-remove:before {
                content: "\292B";
            }

        </style>
        <link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />


    <script src="{{ asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/filer/custom-filer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/filer/createGroup.js') }}" type="text/javascript"></script>

        <link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('resources/assets/connect/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

        <script>
            $(function (){
                var URL = '{{url('knitter/project-image')}}';
                var URL1 = '{{url('knitter/remove-project-image')}}';

                jqueryFilerGroupImages('groups_images',URL,URL1);

               $("#product_name").select2();

               $("#group_type").select2({
                    placeholder: 'Please select a group type',
                   ajax: {
                       url: '{{ url("designer/groups/categories") }}',
                       dataType: 'json'
                   }
               });

                var $validations = $('#createGroup');
                $validations.bootstrapValidator({
                    excluded: [':disabled'],
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {
                        group_name: {
                            message: 'The group name is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The group name is required.'
                                },
                                regexp: {
                                    regexp: /^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/,
                                    message: 'The group name should have only alphabets, numbers and spaces.'
                                }
                            }
                        },
                        group_type: {
                            message: 'The group type is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The group type is required.'
                                }
                            }
                        },
                        group_description: {
                            message: 'The group description is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The group description is required.'
                                }
                            }
                        },
                        expertise_level: {
                            message: 'The expertise level is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The expertise level is required.'
                                }
                            }
                        },
                        start_date: {
                            message: 'The start date is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The start date is required.'
                                }
                            }
                        },
                        end_date: {
                            message: 'The end date is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The end date is required.'
                                }
                            }
                        },
                        status: {
                            message: 'The status is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The status is required.'
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
                    $(".loading").show();
                    $.post($form.attr('action'), $form.serialize(), function(result) {
                        if(result.status == 'success'){
                            $("#create-group").prop('disabled',true);
                            $(".loading").hide();
                            notification('fa-check','Yeah..','Group created successfully...','success');
                            setTimeout(function(){ window.location.assign('{{ url("designer/groups") }}') },2000);
                        }else{
                            $("#create-group").prop('disabled',false);
                            $(".loading").hide();
                            notification('fa-times','Oops..','There are few errors in the form, Please refresh and try again.','danger');
                        }
                    }, 'json').fail(function(response) {
                        $("#create-group").prop('disabled',false);
                        $(".loading").hide();
                        notification('fa-times','Oops..','There are few errors in the form, Please refresh and try again.','danger');
                        //alert('Error: ' + response.responseText);
                    });
                });

                $(document).on('click','#showCategories',function (e) {
                    openCategory();
                });

                $('#product_name').on('select2:select', function (e) {
                    var data = e.params.data;
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var Data = { 'product_id': data.id };
                    $.post('{{ url("designer/groups/getProductImage") }}',Data,function(res){
                        if(res.status == true){
                            $("#product_name").after('<input type="hidden" name="product_image" value="'+res.image+'">');
                        }
                    });
                });

                $(document).on('click','#addCategory',function (e) {
                    $(".loading").show();
                    $("#exampleHeading").html("Add new group type");
                    $.get('{{ url("designer/groups/category/add") }}',function (res){
                        $("#categoryModal").html(res);
                        $(".loading").hide();
                    }).fail(function (xhr, status, error){
                        notification('fa-times','Yeah..','Unable to get data, Try again after sometime.','danger');
                        $(".loading").hide();
                    });
                });

                $(document).on('click','#saveCategory',function (e) {
                    var categoryName = $("#categoryName").val();
                    if(!categoryName){
                        $(".categoryName").html('Category name is required.');
                        return false;
                    }
                    $(".loading").show();
                    var Data = $("#addGroupForm").serializeArray();
                    $.post('{{ url("designer/groups/category/create") }}',Data,function (res){
                        if(res.status == 'success'){
                            notification('fa-check','Yeah..','Category created successfully...','success');
                            openCategory();
                            $(".loading").hide();
                        }else{
                            notification('fa-times','Yeah..',res.message,'danger');
                            $(".loading").hide();
                        }
                    }).fail(function (xhr, status, error){
                        notification('fa-times','Yeah..','Unable to get data, Try again after sometime.','danger');
                        $(".loading").hide();
                    });
                });

                $(document).on('click','.deleteCategory',function (){
                    var id = $(this).attr('data-id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to delete this category ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value == true) {
                            $(".loading").show();
                            $.post('{{ url("designer/groups/categories/delete") }}',{id:id},function (res){
                                if(res.status == 'success'){
                                    openCategory();
                                    notification('fa-check','Yeah..','Category created successfully...','success');
                                    Swal.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                }else{
                                    notification('fa-times','Yeah..','Unable to get data, Try again after sometime.','danger');
                                    $(".loading").hide();
                                    Swal.fire(
                                        'Oops!',
                                        res.message,
                                        'danger'
                                    )
                                }
                            }).fail(function(response) {
                                $(".loading").hide();
                                notification('fa-times','Oops..',response.message,'danger');
                            });

                        }
                    })
                });
            });

function openCategory(){
    $("#exampleHeading").html("Group Types");
    $(".loading").show();
    $.get('{{ url("designer/groups/getAllCategories") }}',function (res){
        if(res){
            $("#categoryModal").html(res);
            $("#exampleModal").modal('show');
            $(".loading").hide();
        }
    });
}
        </script>
    @endsection