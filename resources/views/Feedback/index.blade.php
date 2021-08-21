@extends('layouts.knitterapp')
@section('title','Knitter Dashboard')
@section('content')

<div class="pcoded-wrapper" id="dashboard">
	<div class="pcoded-content">
	    <div class="pcoded-inner-content">
	        <div class="main-body">
	            <div class="page-wrapper">
	                <!-- Page-body start -->
	                <div class="page-body">

	                	@if($feedback->count() > 0)
<div class="row justify-content-md-center">
<div class="col-lg-10">
<div class="row">
    <div class="col-lg-9"> <h5 class="m-b-30 theme-heading">Feedback</h5></div>
    <div class="col-lg-12">
        <div class="row users-card">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <span><a href="#" id="post-new-static" data-toggle="modal" data-target="#PostModal" class="btn theme-btn waves-effect waves-light float-right back-to-top page-scroll"><i class="fa fa-pencil-square-o m-r-10"></i>Post feedback</a></span>
                    <div class="card bg-white p-relative">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-lg-12">
                                <h5 class="m-b-20">Feedback submitted</h5>
                                <hr>
							@foreach($feedback as $fb)
                                <p class="f-14"><!--Your feedback to --><a href="{{url('feedback/show/'.base64_encode($fb->id).'/'.Str::slug($fb->title))}}">{{$fb->title}}</a>
                                <br><span class="f-12 text-muted">
                                	Added 
									@if(date('Y-m-d') == date('Y-m-d',strtotime($fb->created_at)))
										{{ \Carbon\Carbon::parse($fb->created_at)->diffForHumans()}}
									@else
                                		{{date('F dS Y',strtotime($fb->created_at))}}
									@endif
                                </span>
                                <hr>
                                </p>
                            @endforeach 

                                

                                </div>
                        </div>
                    </div>
                    <!-- New feedback --> 
                </div>
               
            </div>
        </div>

        {{$feedback->links()}}

        </div>
    </div>
    </div>
</div>


								@else
	                    <div class="row m-t-20">
	                        <div class="col-lg-12 col-xl-12 col-md-9">
                                <div class="card custom-card skew-card">
	

                                    <div class="row">
                                        <div class="col-lg-6"><h3 class="m-l-20 m-t-10 text-muted"></h3></div>
                                        <div class="col-lg-6"> <button class="btn waves-effect m-t-10 m-r-20 pull-right waves-light btn-primary theme-outline-btn" data-toggle="modal" data-target="#PostModal"><i class="icofont icofont-plus"></i>Post feedback now</button></div>
                                    </div>
                                    <div class="user-content card-bg m-l-40 m-r-40 m-b-40">
                                            <img src="{{ asset('resources/assets/files/assets/images/arrow.png') }}" id="arrow-img"> 
                                        <h3 class="m-t-40 text-muted">Post your Feedback!</h3>
                                        <h4 class="text-muted m-t-10 m-b-30">True intuitive expertise is learned from prolonged experience with good feedback.....</h4>
                                    </div>
                               
                                </div>
                            </div>
                    </div>
                     @endif
                    <!-- Round card end -->
                    </div>
                </div>
                <!-- Page-body end -->
            </div>
        </div>
	</div>
</div>


<!-- Modal to Unfollow -->
<div class="modal fade" id="PostModal" role="dialog">
<div class="modal-dialog modal-md">
  <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title">Post your feedback</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="post-new-contain row card-block">
                <div class="col-md-1 col-xs-1 p-0 m-l-20">
                    <img src="{{Auth::user()->picture ? Auth::user()->picture : Avatar::create(ucfirst(Auth::user()->first_name))->toBase64()}}" class="img-fluid img-radius" alt="">
                </div>
                <form class="col-md-10 col-xs-10" id="upload-feedback">
                    <div>
                        <textarea id="title" class="form-control post-input" style="border: .6px solid #dadada;" rows="3" cols="10" required="" name="title" placeholder="Your feedback..."></textarea>
                        <span class="red title"></span>
                        <textarea id="notes" class="form-control post-input m-t-10" style="border: .6px solid #dadada;" rows="3" cols="10" required="" name="notes" placeholder="Additional notes if any..."></textarea>
                        <span class="red notes"></span>
                    </div>
                    <select name="type" id="type" class="form-control form-control-default fill m-t-10">
                        <option value="">Please Select Page</option>
                        @if($menus->count() > 0)
                            @foreach($menus as $menu)
                        <option value="{{$menu->name}}">{{$menu->name}}</option>
                            @endforeach
                        @endif
        			</select>
        			<span class="red type"></span>
                    <div class="image-upload m-t-15" style="position: relative;left: 0;"
                    title="Upload image">
                    <input type="file" name="file[]" id="filer_input1" multiple="multiple">
                </div>
                </form>
            </div>
        </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default theme-outline-btn" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-default theme-btn" id="submit" >Post</button>
    </div>
  </div>
</div>
</div> 
@endsection
@section('footerscript')
<script type="text/javascript">
	var URL = '{{url("feedback/uploadImage")}}';
	var URL1 = '{{url("feedback/removeImage")}}';
</script>
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
     <link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />

<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
<script src="{{asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
<script type="text/javascript" src="{{asset('resources/assets/files/assets/pages/filer/feedback-fileupload.init.js')}}"></script>
       <!-- notification js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/bootstrap-growl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/pages/notification/notification.js') }}"></script>

<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/bootstrap-notify.min.js') }}"></script>
<style type="text/css">
	#post-new-static {
    position: fixed;
    bottom: 10px;
    right: 6px;
    z-index: 99;
}
    #profile-img{width:auto;height:140px!important;border-radius: 6px;}
    .profile-upload{position: absolute;right: 52px;top: 20px;}
    #post-new-static {
    position: fixed;
    bottom: 10px;
    right: 6px;
    z-index: 99;
}
.progress{
  max-width: 100% !important;
}
.progress-bar-success{
  background-color: #0d665b !important;
}
.progress-bar-danger{
  background-color: #bc7c8f !important;
}
.progress-bar-info{
  background-color: #0d665b !important;
}
</style>

<script type="text/javascript">
	$(function(){
		/* addProductCartOrWishlist('fa fa-check','success','Project created successfully','success');
		addProductCartOrWishlist('fa-times','error','Unable to create project, Try again after sometime.','danger'); */

		$(document).on('click','#submit',function(){
			var Data = $("#upload-feedback").serializeArray();
			var title = $("#title").val();
			var type = $("#type").val();
			var er = [];
			var cnt = 0;

			if(title == ""){
				$(".title").html('Feedback is required.');
				er+=cnt+1;
			}else{
				$(".title").html('');
			}

			if(type == ""){
				$(".type").html('Page name is required.');
				er+=cnt+1;
			}else{
				$(".type").html('');
			}

			if(er!=""){
				return false;
			}

		  $.ajaxSetup({
	          headers: {
	              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	          }
	      });

			$.ajax({
				url : '{{url("feedback/saveFeedback")}}',
				type : 'POST',
				data : Data,
				beforeSend : function(){
					$(".loading").show();
				},
				success : function(res){
					if(res.status == 'success'){
						addProductCartOrWishlist('fa fa-check','success','Feedback sent successfully','success');
						$("#PostModal").modal('hide');
						setTimeout(function(){ location.reload(); },2000);
					}else{
						addProductCartOrWishlist('fa-times','error','Unable to submit feedback, Try again after sometime.','danger');
					}
				},
				complete : function(){
					setTimeout(function(){ $(".loading").hide(); },1500);
				}
			})
		});
	});


function addProductCartOrWishlist(icon,status,msg,type){
        $.notify({
            icon: 'fa '+icon,
            title: status+'!',
            message: msg
        },{
            element: 'body',
            position: null,
            type: type,
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: true,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 10000,
            delay: 3000,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
    }
</script>
@endsection