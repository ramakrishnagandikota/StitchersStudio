@extends('layouts.knitterapp')
@section('title','Group members')
@section('content')
    @section('designer-groups-menu')
        <li><a href="{{ url('designer/groups') }}" class="waves-effect waves-light">Groups</a></li>
        <li><a href="{{ url('designer/groups/'.$group->unique_id.'/show') }}" class="waves-effect waves-light active">Group members</a></li>
        <li><a href="{{ url('designer/groups/'.$group->unique_id.'/community') }}" class="waves-effect waves-light">Community</a></li>
        <li><a href="{{ url('designer/groups/'.$group->unique_id.'/faq') }}" class="waves-effect waves-light">FAQ's</a></li>
    @endsection
    <div class="pcoded-wrapper" id="dashboard">
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-lg-12">
                <label class="theme-heading f-w-600 m-b-20">{{ $group->group_name }}
                </label>
            </div>
        </div>

        <div class="card p-20">
            <div class="dt-responsive "><!-- table-responsive -->
                <table id="example" class="table table-striped table-bordered nowrap dataTable">
                    <thead>
                    <tr>
                        <th>
                            <div class="custom-control custom-checkbox collection-filter-checkbox">
                                <input type="checkbox" class="custom-control-input" id="main-checkbox">
                                <label class="custom-control-label" for="main-checkbox"></label>
                            </div>
                        </th>
                        <th>Member name</th>
                        <th>Email</th>
                        <th>User type</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- Round card end -->
    </div>


</div>
</div>
</div>
</div>
</div>
    <div class="modal fade" id="send-message" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title f-w-500">Send Broadcast message</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form id="broadcastForm" method="POST" action="{{ url('designer/broadcastmsgToUsers') }}">
                <div class="modal-body">
                        <div id="users"></div>
                    <input type="hidden" name="group_id" value="{{ $group->id }}">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="int1">Group name<span class="kf-pink">*</span></label>
                                        <div class="row">
                                            <div class="col-md-12 ui-widget">
                                                <input value="{{ $group->group_name }}" readonly id="group_name" type="text" class="form-control validate" name="group_name">
                                                <span class="title red"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="int1">Title<span class="kf-pink">*</span></label>
                                        <div class="row">
                                            <div class="col-md-12 ui-widget">
                                                <input placeholder="Message title" id="title" type="text" class="form-control validate" name="title">
                                                <span class="title red"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="int1">Detail message<span class="kf-pink">*</span></label>
                                        <div class="row">
                                            <div class="col-md-12 ui-widget">
                                                <textarea id="message" name="message" placeholder="Enter your detail message" cols="100%" type="text" class="form-control validate"></textarea>
                                                <span class="message red"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
                <div class="modal-footer">
                    <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn waves-effect waves-light btn-primary theme-btn" ><i class="fa fa-bullhorn m-r-10"></i>Send</button>
                </div>
                </form>
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
        </style>
        <link rel="stylesheet" type="text/css"
              href="{{ asset('resources/assets/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
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
        <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
        <script>
            $(function (){
                $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'print',
                        'csvHtml5',
                        'pdfHtml5',
                    ],
                    ajax: '{{ url("designer/groups/".$id.'/show') }}',
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'email' },
                        { data: 'user_role' },
                        { data: 'action' }
                    ],
                    "order": [[ 0, "desc" ]]
                });

                var mybutton = $('<a href="javascript:;" style="font-size:14px;border-radius:2px;color: #fff;" id="sendMessage" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right m-t-5"><i class="icofont icofont-plus"></i> Send message</a>');
                $('#example_filter').append(mybutton);

                $(document).on('click','#main-checkbox',function (){
                    var table = $('#example').DataTable();
                    var rows = table.rows().count();
                    for (var i=1;i<=rows;i++){
                        if($(this).is(":checked") == true){
                            $("#main-checkbox"+i).prop('checked',true);
                        }else{
                            $("#main-checkbox"+i).prop('checked',false);
                        }
                    }
                });

                var $validations = $('#broadcastForm');
                $validations.bootstrapValidator({
                    excluded: [':disabled',':hidden'],
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {
                        group_name: {
                            message: 'The group name field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'This group name is required.'
                                }
                            }
                        },
                        title: {
                            message: 'The title is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The title is required.'
                                }
                            }
                        },
                        message: {
                            message: 'The message field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The message field is required.'
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
                            $("#broadcastForm")[0].reset();
                            $("#send-message").modal('hide');
                            $("#submit").prop('disabled',false);
                            $(".loading").hide();
                            notification('fa-check','Yeah..','Message broadcasted successfully..','success');
                            setTimeout(function(){ $('#example').DataTable().ajax.reload(); },2000);
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

                $(document).on('click','#sendMessage',function (){
                    if($('input[name="checkbox[]"]:checked').length > 0){
                        $("#send-message").modal('show');
                        $('input[name="checkbox[]"]:checked').each(function() {
                            //console.log($(this).val());
                            $("#users").html('<input type="hidden" name="user_id[]" value="'+$(this).val()+'">');
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please select any user to send message.'
                        })
                    }
                });

                $(document).on('click','.deleteUser',function (){
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
                        if (result.value == true) {
                            $(".loading").show();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.post('{{ url("designer/deleteGroupUser") }}',{id:id},function (res){
                               if(res.status == 'success'){
                                   $('#example').DataTable().ajax.reload();
                                   Swal.fire(
                                       'Removed!',
                                       'User removed from group successfully.',
                                       'success'
                                   );
                                   $(".loading").hide();
                               }else{
                                   Swal.fire(
                                       'Oops..!',
                                       res.message,
                                       'danger'
                                   );
                                   $(".loading").hide();
                               }
                            });
                        }
                    });
                });
            });
        </script>
    @endsection