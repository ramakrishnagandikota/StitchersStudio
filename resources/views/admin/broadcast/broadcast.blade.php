@extends('layouts.admin')
@section('breadcrum')
    <div class="col-md-12 col-12 align-self-center">
        <h3 class="text-themecolor">Users</h3>
        <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
        </ol>
    </div>

@endsection

@section('section1')
    <div class="card col-md-12 col-lg-12 col-xlg-12 col-sm-12 col-xs-12">
        <div class="card-body">
            <form id="broadcastForm">
                <input type="hidden" name="schedule_at" value="{{ date('Y-m-d H:i:s') }}">
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="int1">Select platform
                                </label>
                                <div class="row">
                                    <div class="col-md-12 ui-widget">
                                        <select name="platform[]" class="form-control form-control-primary col-lg-12 fill select2" multiple>
                                            <option value="web">Web</option>
                                            <option value="android">Android</option>
											<option value="ios">Ios</option>
                                        </select>
                                    </div>
                                </div>
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
            </form>

            <div class="row">
                <div class="col-lg-12 text-center">
                    <a href="{{ route('admin.broadcast') }}" class="btn theme-outline-btn waves-effect m-b-10 m-t-10 m-r-20" >Cancel</a>
                    <button type="button" class="btn theme-btn waves-effect m-b-10 m-t-10 m-r-20" id="save-btn" ><i class="fa fa-location-arrow f-18 m-r-10"></i>Send</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="SendModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send Message</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="payment-box text-center">
                        <i class="fa fa-check-circle success-text m-b-10" aria-hidden="true"></i>
                        <!-- <h6 class="theme-text f-20">Submitted successfully</h6> -->
                        <p class="f-18">This message will be sent to all users</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default theme-outline-btn" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('section2')

@endsection
@section('footerscript')
<!-- select 2 -->
    <link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/connect/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('resources/assets/connect/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
    <style>
        .red{
            color: red;
        }
    </style>
    <script>
        $(function (){
			
			$(".select2").select2({
				placeholder: "Select a device to send notifications",
				allowClear: true
			});
		
            var $validate = $(".validate");

            $validate.on('keyup',function (){
                var id = $(this).attr('id');
                var value = $(this).val();

                if(value == ''){
                    $("."+id).html('This field is required');
                }else{
                    $("."+id).html('');
                }
            });


            $(document).on('click','#save-btn',function(){
                var er = [];
                var cnt = 0;


                $validate.each(function (){
                    var id = $(this).attr('id');
                    var value = $(this).val();

                    if(value == ''){
                        $("."+id).html('This field is required');
                        er+=cnt+1;
                    }else{
                        $("."+id).html('');
                    }
                });

                if(er != ''){
                    return false;
                }

                var Data = $("#broadcastForm").serializeArray();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $(".loading").show();
                $.post('{{ route("admin.broadcast.user") }}',Data)
                    .done(function(res){
                        $(".loading").hide();
                        if(res.status == 'success'){
                            //notification('fa-check','success','Message broadcasted to all users.','success');
                            $("#SendModal").modal('show');
                            setTimeout(function (){ window.location.reload()},2000);
                        }else{
                            notification('fa-times','Oops..','Unable to broadcast message to users.','danger');
                        }
                    })
                    .fail(function(xhr, status, error) {
                        $(".loading").hide();
                        notification('fa-times','Oops..',error,'danger');
                    });
            });
        });
    </script>
@endsection
