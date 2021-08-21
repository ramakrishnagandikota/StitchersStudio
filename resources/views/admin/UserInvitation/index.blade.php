@extends('layouts.admin')
@section('breadcrum')
<div class="col-md-12 col-12 align-self-center">
    <h3 class="text-themecolor">Designer invitation</h3>
    <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
    </ol>
</div>
@endsection

@section('section1')



 <div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <form id="send-invite">
                @csrf
                <div class="form-group row">
                      <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Select user / Enter email id*</label>
                      <div class="col-sm-7">
                          <select  name="designer_name" id="designer_name" class="form-control" required>
                                <option value="">Please Select Design Type</option>
                                @foreach($users as $user)
                                <option value="{{$user->email}}">{{$user->first_name.' '.$user->last_name.' - '.$user->email}}</option>
                                @endforeach
                              </select>
                              <div class="clearfix"></div>
                              <span></span>
                      </div>
                  </div>
                  <div class="form-group pull-right">
                      <button type="button" class="btn btn-primary theme-btn" id="sendInvite">Send Invitation</button>
                  </div>
            </form>   

            <div class="alert hide" id="message">
                
            </div>         
        </div>
    </div>
</div>
<div class="clearfix"></div>

@endsection

@section('section2')

@endsection

@section('footerscript')
<style type="text/css">
  .select2-container--default .select2-selection--multiple .select2-selection__clear{
    position: absolute;
    right: 0;
  }
</style>

<link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/connect/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('resources/assets/connect/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
<script type="text/javascript">
	$(function(){
        $("#designer_name").select2({
            placeholder: "Select user to send invite",
            allowClear: true,
            tags: true
        });

        $(document).on('click','#sendInvite',function(){
            var Data = $("#send-invite").serializeArray();
            $.ajax({
                url : '{{ route("admin.invite.send") }}',
                type : 'POST',
                data : Data,
                beforeSend : function(){
                    $(".loading").show();
                },
                success : function(res){
                    if(res.status == true){
                        $("#message").removeClass("hide alert-danger").addClass('alert-success').html(res.message);
                        setTimeout(function(){ $("#message").addClass("hide").html('') },5000);
                    }else{
                        $("#message").removeClass("hide alert-success").addClass('alert-danger').html(res.message);
                        setTimeout(function(){ $("#message").addClass("hide").html('') },5000);
                    }
                },
                complete : function(){
                    $(".loading").hide();
                }
            });
        });
	});
</script>
@endsection
