@extends('layouts.knitterapp')
@section('title','FAQ')
@section('content')
<div class="pcoded-wrapper" id="dashboard">
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
    @section('designer-groups-menu')
        <li><a href="{{ url('designer/groups') }}" class="waves-effect waves-light">Groups</a></li>
        <li><a href="{{ url('designer/groups/'.$group->unique_id.'/show') }}" class="waves-effect waves-light ">Group members</a></li>
        <li><a href="{{ url('designer/groups/'.$group->unique_id.'/community') }}" class="waves-effect waves-light">Community</a></li>
        <li><a href="{{ url('designer/groups/'.$group->unique_id.'/faq') }}" class="waves-effect waves-light active">FAQ's</a></li>
    @endsection
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6">
                <label class="theme-heading f-w-600 m-b-20">{{ $group->group_name }} : FAQ's</label>
            </div>
            <div class="col-lg-6">
                <button class="btn theme-btn waves-effect waves-light pull-right" style="padding: 6px 12px; " id="addFaq"><i class="fa fa-plus m-r-10"></i>Add FAQ</button>
            </div>
        </div>

        <div class="row p-20">
            <div class="col-lg-9">
                <div class="card p-10">
                    <div class="accordion faq-row" id="accordionExample">
                        <div class="col-md-12">
                            <h5 class="text-center" id="loadingArea">Please wait. Loading data...</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3" id="sideMenu">

            </div>
        </div>

    </div>

</div>
</div>
</div>
</div>
</div>


    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="faqForm" action="{{ url('designer/groups/saveFAQ') }}" method="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Enter title</label>
                                <input type="text" name="faq_title" id="faq_title" class="form-control" value="" placeholder="Enter title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="">Select category (<small><a href="javascript:;" onclick="openPopup()" style="color: #c14d7d">Show all categories</a></small>)</label>
                                <select class="form-control" name="faq_category_id" id="faq_category_id"></select>
                                <small><a href="javascript:;" onclick="openPopup()"  style="color: #c14d7d">Click here</a> to add new category</small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Enter description</label>
                            <textarea class="form-control summernote" id="faq_description" name="faq_description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary">Save FAQ</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop1" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Update FAQ</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editForm" action="{{ url('designer/groups/faq/updateFAQ') }}" method="POST">
                    <div class="modal-body" id="editFaq">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit1" class="btn btn-primary">Update FAQ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleHeading">FAQ's Category</h5>
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
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('footerscript')
        <style>
            .fa-pencil{
                background-color: unset !important;
                color: #c38a9b !important;
                padding: 0px !important;
            }
            .underline{
                border-bottom: 2px dotted #c38a9b;
            }
            #gpages{
                display: none;
            }
            .nav-right li .active {
                border-bottom: 1px solid #0d665c;
                color: #0d665c;
                font-weight: 500;
            }
            .kf-pink{
                color: red;
            }
            .help-block{
                color: red;
            }
            .accordionBox{
                margin-bottom: 10px;
                box-shadow: none !important;
                border: 1px solid #eee;
            }
            .accordionBox .card-header{
                padding: 0px !important;
            }
            .upDownIcon{
                position: absolute;
                right: 15px;
                top: 13px;
            }
            .glyphicon-ok:before {
                content: "\2714";
            }
            .glyphicon-remove:before {
                content: "\292B";
            }
            .table td, .table th{
                padding: 10px;
            }
            .error{
                color: red;
            }
            #example_filter{
                float: right;
            }
        </style>

        <link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('resources/assets/connect/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>
        <link rel="stylesheet" href="{{ asset('resources/assets/summernote/summernote.css') }}">
        <script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

        <!--<link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
        <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>-->

        <Script>
            $(function (){

                $(document).on('show.bs.modal', '.modal', function () {
                    var zIndex = 1040 + (10 * $('.modal:visible').length);
                    $(this).css('z-index', zIndex);
                    setTimeout(function() {
                        $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
                    }, 0);
                });


                $("#category_id").select2({ placeholder : 'Please select a category'});

                $(document).on('click','#addCategory',function (e) {
                    $("#exampleHeading").html("Add new category");
                    $(".loading").show();
                    $.get('{{ url("designer/groups/".$group->id."/faq/category/add") }}',function (res){
                        $("#categoryModal").html(res);
                        $(".loading").hide();
                    }).fail(function (xhr, status, error){
                        notification('fa-times','Yeah..','Unable to get data, Try again after sometime.','danger');
                        $(".loading").hide();
                    });
                });

                $(document).on('click','#showCategories',function (e) {
                    loadCategories();
                });

                $(document).on('click','#saveCategory',function (e) {
                    var categoryName = $("#categoryName").val();
                    if(!categoryName){
                        $(".categoryName").html('Category name is required.');
                        return false;
                    }
                    $(".loading").show();
                    var Data = $("#addGroupForm").serializeArray();
                    $.post('{{ url("designer/groups/faq/category/create") }}',Data,function (res){
                        if(res.status == 'success'){
                            notification('fa-check','Yeah..','Category created successfully..','success');
                            loadCategories();
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

                $(document).on('keyup','#categoryName',function (e) {
                    var categoryName = $("#categoryName").val();
                    if(categoryName.length == 0){
                        $(".categoryName").html('Category name is required.');
                    }else{
                        $(".categoryName").html('');
                    }
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
                            $.post('{{ url("designer/groups/faq/category/delete") }}',{id:id},function (res){
                                if(res.status == 'success'){
                                    loadCategories();
                                    notification('fa-check','Yeah..','Category created successfully..','success');
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

                /* Faq jquery script */
                $(document).on('click','#addFaq',function (){
                    $("#staticBackdrop").modal('show');
                    getCategoryDropdown();
                });

                $('.summernote').summernote({
                    height: 150,
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

                var $validations = $('#faqForm');
                $validations.bootstrapValidator({
                    excluded: [':disabled'],
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {
                        faq_title: {
                            message: 'The title is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'This title field is required.'
                                }
                            }
                        },
                        faq_category_id: {
                            message: 'The category field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The category field is required.'
                                }
                            }
                        },
                        faq_description: {
                            message: 'The description is not valid',
                            validators: {
                                callback: {
                                    message: 'The description is required.',
                                    callback: function(value, validator) {
                                        var code = $('[name="faq_description"]').summernote('code');
                                        return (code !== '' && code !== '<p><br></p>');
                                    }
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
                    var formData = $form.serializeArray();
                    formData.push({ name: 'group_id', value: '{{base64_encode($group->id)}}'});
                    $(".loading").show();
                    $.post($form.attr('action'), formData, function(result) {
                        if(result.status == 'success'){
                            $("#faqForm")[0].reset();
                            $("#faq_category_id").val('').trigger('change');
                            $("#faq_description").summernote('code','');
                            $("#staticBackdrop").modal('hide');
                            $("#submit").prop('disabled',false);
                            $(".loading").hide();
                            notification('fa-check','Yeah..','Your FAQ was added successfully...','success');
                            setTimeout(function(){ getData(1) },2000);
                        }else{
                            $("#submit").prop('disabled',false);
                            $(".loading").hide();
                            notification('fa-times','Oops..','There are few errors in the form, Please refresh and try again.','danger');
                        }
                    }, 'json').fail(function(response) {
                        $("#submit").prop('disabled',false);
                        $(".loading").hide();
                        notification('fa-times','Oops..','There are few errors in the form, Please refresh and try again.','danger');
                        //alert('Error: ' + response.responseText);
                    });
                });

                $(document).on('click','.editFaq',function (){
                    
                    var id = $(this).attr('data-id');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $(".loading").show();
                    $.post('{{ url("designer/groups/faq/edit") }}',{id:id},function (res){
                        if(res){
                            $("#staticBackdrop1").modal('show');
                            $("#editFaq").html(res);
                            $('#faq_description1').summernote();
                            editFAQForm();
                        }else{
                            $("#editFaq").html("Unable to edit this faq, Try again after sometime.");
                        }
                    });
                    $(".loading").hide();
                });

                $(document).on('click','.deleteFaq',function (){
                    var id = $(this).attr('data-id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        //console.log(result);
                        if (result.value == true) {
                            $(".loading").show();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.post('{{ url("designer/groups/faq/delete") }}',{id:id},function (res){
                                if(res.status == 'success'){
                                    getData(1);
                                    Swal.fire(
                                        'Deleted!',
                                        'Faq deleted successfully.',
                                        'success'
                                    );
                                    $(".loading").hide();
                                } else{
                                    Swal.fire(
                                        'Oops!',
                                        res.message,
                                        'danger'
                                    );
                                    $(".loading").hide();
                                }
                            },'json').fail(function(response) {
                                $(".loading").hide();
                                Swal.fire(
                                    'Oops!',
                                    response.message,
                                    'danger'
                                )
                            });
                        }
                    })
                });

            });

            function openPopup(){
                $("#exampleHeading").html("FAQ's Category");
                $(".loading").show();
                $.get('{{ url("designer/groups/".$group->id."/getFaqCategories") }}',function (res){
                    if(res){
                        $("#categoryModal").html(res);
                        $("#exampleModal").modal('show');
                        $(".loading").hide();
                    }
                });
            }

            function loadCategories(){
                $("#exampleHeading").html("FAQ's Category");
                $(".loading").show();
                $.get('{{ url("designer/groups/".$group->id."/getFaqCategories") }}',function (res){
                    if(res){
                        //enableEditableTable();
                        $("#categoryModal").html(res);
                        $(".loading").hide();
                    }else{
                        $(".loading").hide();
                    }
                });
            }

            function getCategoryDropdown(){
                $('#faq_category_id').select2({
                    ajax: {
                        url: '{{ url("designer/groups/".$group->id."/faq/categories") }}',
                        dataType: 'json'
                    }
                });
            }

            function editFAQForm(){
                var $validations = $('#editForm');
                $validations.bootstrapValidator({
                    excluded: [':disabled'],
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {
                        faq_title: {
                            message: 'The title is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'This title field is required.'
                                }
                            }
                        },
                        faq_category_id: {
                            message: 'The category field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The category field is required.'
                                }
                            }
                        },
                        faq_description: {
                            message: 'The description is not valid',
                            /*validators: {
                                callback: {
                                    message: 'The description is required.',
                                    callback: function(value, validator) {
                                        var code = $('[name="faq_description"]').summernote('code');
                                        return (code !== '' && code !== '<p><br></p>');
                                    }
                                }
                            }*/
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
                    var formData = $form.serializeArray();
                    formData.push({ name: 'group_id', value: '{{base64_encode($group->id)}}'});
                    $(".loading").show();
                    $.post($form.attr('action'), formData, function(result) {
                        if(result.status == 'success'){

                            $("#faqForm")[0].reset();
                            $("#staticBackdrop1").modal('hide');
                            $("#submit1").prop('disabled',false);
                            $(".loading").hide();
                            notification('fa-check','Yeah..','Your FAQ was added successfully...','success');
                            setTimeout(function(){ getData(1); location.reload(); },2000);
                        }else{
                            $("#submit1").prop('disabled',false);
                            $(".loading").hide();
                            notification('fa-times','Oops..','There are few errors in the form, Please refresh and try again.','danger');
                        }
                    }, 'json').fail(function(response) {
                        $("#submit1").prop('disabled',false);
                        $(".loading").hide();
                        notification('fa-times','Oops..','There are few errors in the form, Please refresh and try again.','danger');
                        //alert('Error: ' + response.responseText);
                    });
                });
            }

            function getCategoriesSideMenu(){
                //$(".loading").show();
                $.get('{{ url("designer/groups/".$group->id."/faq/getCategoriesData") }}',function (res){
                    if(res){
                        //enableEditableTable();
                        $("#sideMenu").html(res);
                        $(".loading").hide();
                    }else{
                        $(".loading").hide();
                    }
                });
            }

            function validateDescription(id){
                $('#faqForm').data('bootstrapValidator').revalidateField(id);
            }

        </Script>

        <script type="text/javascript">
            getData(1);
            $(window).on('hashchange', function() {
                if (window.location.hash) {
                    var page = window.location.hash.replace('#', '');
                    if (page == Number.NaN || page <= 0) {
                        return false;
                    }else{
                        getData(page);
                    }
                }
            });

            $(document).ready(function()
            {
                $(document).on('click', '.pagination a',function(event)
                {
                    event.preventDefault();

                    $('li').removeClass('active');
                    $(this).parent('li').addClass('active');

                    var myurl = $(this).attr('href');
                    var page=$(this).attr('href').split('page=')[1];

                    getData(page);
                });

            });

            function getData(page){
                $("#loadingArea").html("Please wait. Loading data...")
                $.ajax(
                    {
                        url: '{{ url("designer/groups/".$group->unique_id."/faq") }}?page='+page,
                        type: "get",
                        datatype: "html"
                    }).done(function(data){
                    $("#accordionExample").empty().html(data);
                    getCategoriesSideMenu();
                    location.hash = page;
                }).fail(function(jqXHR, ajaxOptions, thrownError){
                    setTimeout(function (){
                        $("#loadingArea").html("Unable to get the FAQ's <a href='javascript:;' style='color: #c14d7d;' onclick='getData(1)'>Click Here</a> to load the data");
                    },1500);
                    //alert('No response from server');
                });
            }
        </script>
    @endsection
