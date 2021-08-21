@extends('layouts.knitterapp')
@section('title','Broadcast / Invitation')
@section('content')
<div class="pcoded-wrapper" id="dashboard">
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-lg-12">
                <label class="theme-heading f-w-600 m-b-20">Broadcast / Invitation
                </label>
            </div>
        </div>

        <div class="card p-20">
            <div class="dt-responsive table-responsive"><!-- table-responsive -->
                <table id="example" class="table table-striped table-bordered nowrap dataTable">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Detailed message</th>
                        <th>Type</th>
                        <th>Group name</th>
                        <th>Sent to</th>
                        <th>Sent at</th>
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


    <div class="modal fade" id="send-message" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title f-w-500">Create Broadcast message</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form id="broadcastForm" action="{{ url('designer/sendGroupMessage') }}">
                <div class="modal-body">
                        <input type="hidden" name="notification_type" value="broadcast">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="int1">Select audience
                                        </label>
                                        <div class="row">
                                            <div class="col-md-12 ui-widget">
                                                <select name="send_message_to" class="form-control form-control-primary col-lg-12 fill" id="send_message_to">
                                                    <option value="friends" selected="">Friends</option>
                                                    <option value="followers">Followers</option>
                                                    <option value="frineds_followers">Friends & Followers</option>
                                                    <option value="pattern-groups">Pattern Groups</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="show-group1">
                                <div class="col-lg-12 ">
                                    <label for="int1">Pattern groups<span class="kf-pink">*</span></label>
                                    <div class="form-group "  >
                                        <select class="form-control select2" name="groups_id[]" id="groups_id" multiple="multiple" >
                                            <option value=""  disabled >Please select an option</option>
                                            @if($groups->count() > 0)
                                                @foreach($groups as $group1)
                                                    <option value="{{ $group1->id }}">{{ $group1->group_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="int1">Title
                                        </label>
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
                                        <label for="int1">Detail message
                                        </label>
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
                    <button type="submit" id="submit" class="btn waves-effect waves-light btn-primary theme-btn"><i class="fa fa-bullhorn m-r-10"></i>Send</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="send-invitation" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title f-w-500">Send Invitation</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <form id="InvitationForm" action="{{ url('designer/sendGroupInvitation') }}" method="POST">
                    <input type="hidden" name="notification_type" value="invitation">
                    <div class="modal-body">

                        <div class="card-block">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="int1">Select audience<span class="kf-pink">*</span></label>
                                        <div class="row">
                                            <div class="col-md-12 ui-widget">
                                                <select name="send_invite_to" id="send_invite_to" class="form-control form-control-primary col-lg-12 fill" id="send_message_to">
                                                    <option value="friends" selected="">Friends</option>
                                                    <option value="followers">Followers</option>
                                                    <option value="frineds_followers">Friends & Followers</option>
                                                    <option value="pattern-groups">Pattern Groups</option>
                                                    <option value="individuals">Individuals</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row" id="show-groupInvite">
                                <div class="col-lg-12 ">
                                    <label for="int1">Enter email id's<span class="kf-pink">*</span></label>
                                    <div class="form-group "  >
                                        <select multiple="multiple" class="form-control" id="individual_emails" name="individual_emails[]"placeholder="Please enter email is's of users."></select>
                                    </div>
                                </div>
                            </div>


                            <div class="row" id="show-group">
                                <div class="col-lg-12 ">
                                    <label for="int1">Pattern groups<span class="kf-pink">*</span></label>
                                    <div class="form-group "  >
                                        <select class="form-control select2" name="groups_id[]" id="groups_id1" multiple="multiple" >
                                            <option value=""  disabled >Please select an option</option>

                                            @if($groups->count() > 0)
                                                @foreach($groups as $group1)
                                                    <option value="{{ $group1->id }}">{{ $group1->group_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 show-group">
                                    <label for="int1">Sending invitation about<span class="kf-pink">*</span></label>
                                    <div class="form-group">
                                        <select class="form-control select2" id="send_message_about" name="send_message_about" >
                                            <option value="" selected disabled >Please select an option</option>
                                            @if($groups->count() > 0)
                                                @foreach($groups as $group2)
                                                    <option value="{{ $group2->id }}">{{ $group2->group_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
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
                        <button type="submit" id="submit1" class="btn waves-effect waves-light btn-primary theme-btn"><i class="fa fa-bullhorn m-r-10"></i>Send Invite</button>
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


<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Broadcast / Invitation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body" id="broadcastMessage">
        
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div>
  </div>
</div>
    @endsection
    @section('footerscript')
        <style>
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
            select2-container--default .select2-selection--single {
                background-color: #fff;
                border: .4px solid #cccccc;
                border-radius: 2px;
            }
            .select2-container .select2-selection--single{height: 32px;}
            #show-group,#show-group1,#show-groupInvite{
                display: none;
            }
            .kf-pink{
                color: red;
            }
            .help-block{
                color: red;
            }
            #example_filter{
                float: right;
            }

        </style>
        <link rel="stylesheet" type="text/css"
              href="{{ asset('resources/assets/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/pages/data-table/css/buttons.dataTables.min.css') }}">
        <link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{asset('resources/assets/connect/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
        <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
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
                $("#group_id").select2();
                
                $("#send_message_about").select2({
                    placeholder: 'Please select an option'
                });

                var table = $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'print',
                        'csvHtml5',
                        'pdfHtml5',
                    ],
                    'processing': true,
                    'language': {
                        'loadingRecords': '&nbsp;',
                        'processing': 'Loading data...'
                    },
                    ajax: '{{ url("designer/group-broadcast") }}',
                    columns: [
                        { data: 'title' },
                        { data: 'description' },
                        { data: 'notification_type' },
                        { data: 'group_name' },
                        { data: 'send_message_to' },
                        { data: 'sent_at' },
                        { data: 'action'}
                    ],
                    "order": [[ 0, "desc" ]]
                });

                var mybutton = $('<a href="javascript:;" style="font-size:14px;border-radius:2px;color: #fff;" id="sendMessage" data-toggle="modal" data-dismiss="modal" data-target="#send-message" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right m-t-5"> Broadcast message</a> &nbsp; <a href="javascript:;" style="font-size:14px;border-radius:2px;color: #fff;" id="sendMessage" data-toggle="modal" data-dismiss="modal" data-target="#send-invitation" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right m-t-5 m-r-5"><i class="fa fa-bullhorn"></i> Send Invitation</a>');
                $('#example_filter').append(mybutton);

                $(document).on('change','#send_invite_to',function (){
                    var value = $(this).val();
                    if(value == 'pattern-groups'){
                        $("#show-group").show();
                        $("#show-groupInvite").hide();
                        setTimeout(function (){
                            $("#groups_id1").select2({
                                placeholder: 'Please select an option'
                            });
                            $("input.select2-search__field").css('width','100% !important');
                        },1000);

                    }else if(value == 'individuals'){
                        $("#show-group").hide();
                        $("#show-groupInvite").show();
                        $("#individual_emails").select2({
                            tags: true,
                            placeholder: "Please enter email id's of users"
                        });
                    }else{
                        $("#show-group").hide();
                        $("#show-groupInvite").hide();
                    }
                });

                $(document).on('change','#send_message_to',function (){
                    var value = $(this).val();
                    if(value == 'pattern-groups'){
                        $("#show-group1").show();
                        setTimeout(function (){
                            $("#groups_id").select2({
                                placeholder:'Please select a option'
                            });
                            $("input.select2-search__field").css('width','100% !important');
                        },1000);

                    }else if(value == 'individuals'){
                        $("#show-group2").hide();
                    }else{
                        $("#show-group1").hide();
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
                        send_message_to: {
                            message: 'The audience field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'This field is required.'
                                }
                            }
                        },
                        groups_id: {
                            message: 'The groups name is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The groups name is required.'
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
                            $("#groups_id").select2('').trigger('change');
                            $("#send-message").modal('hide');
                            $("#submit").prop('disabled',true);
                            $(".loading").hide();
                            notification('fa-check','Yeah..','Message broadcasted successfully...','success');
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


                var $validations = $('#InvitationForm');
                $validations.bootstrapValidator({
                    excluded: [':disabled',':hidden'],
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {
                        send_invite_to: {
                            message: 'The audience field is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'This field is required.'
                                }
                            }
                        },
                        'groups_id[]': {
                            message: 'The pattern groups is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The pattern groups is required.'
                                }
                            }
                        },
                        send_message_about: {
                            message: 'The group name is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The group name is required.'
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
                            $("#InvitationForm")[0].reset();
                            $("#individual_emails").select2('').trigger('change');
                            $("#groups_id1").select2('').trigger('change');
                            $("#send_message_about").select2('').trigger('change');
                            $("#send-invitation").modal('hide');
                            $("#submit1").prop('disabled',false);
                            $(".loading").hide();
                            notification('fa-check','Yeah..','Message broadcasted successfully..','success');
                            setTimeout(function(){ $('#example').DataTable().ajax.reload(); },2000);
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

                $(document).on('click','#button',function (){
                    //$('#example').DataTable().clear().draw();
                    $('#example').DataTable().ajax.reload();
                });

                $(document).on('click','.viewMessage',function (){
                    $(".loading").show();
                    var id = $(this).attr('data-id');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post('{{url("designer/groups/openBroadcastMessage")}}',{id:id},function(res){
                        if(res){
                            $("#messageModal").modal('show');
                            $("#broadcastMessage").html(res);
                            $(".loading").hide();
                        }else{
                            notification('fa-times','Oops..','unable to show details, Please refresh and try again.','error');
                            $(".loading").hide();
                        }
                    }).fail(function(error){
                        notification('fa-times','Oops..','unable to show details, Please refresh and try again.','danger');
                            $(".loading").hide();
                    })
                    
                });

            });
        </script>
    @endsection
