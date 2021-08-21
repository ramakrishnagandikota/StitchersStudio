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

<div class="row justify-content-md-center">
<div class="col-lg-12 col-md-12 col-sm-12">
    <!-- <span><a href="#" id="post-new-static" data-toggle="modal" data-target="#PostModal" class="btn theme-btn waves-effect waves-light float-right back-to-top page-scroll"><i class="fa fa-pencil-square-o m-r-10"></i>Post Feedback</a></span> -->
    <!--<span><a href="#" id="post-new-static" data-toggle="modal" data-target="#PostModal" class="btn theme-btn waves-effect waves-light float-right back-to-top page-scroll"><i class="fa fa-pencil-square-o m-r-10"></i>Post new feedback</a></span>-->
        <div class="card bg-white p-relative p-20">
            <div class="card-block">
                <div class="row justify-content-md-center">
                    <div class="col-lg-12">
                        <div class="media">
                            <div class="media-left media-middle friend-box">
                                <a href="#">
                                    <img class="media-object img-radius m-r-20" src="{{Auth::user()->picture ? Auth::user()->picture : Avatar::create(Auth::user()->first_name)->toBase64()}}" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="chat-header">{{ucfirst(Auth::user()->first_name)}} {{Auth::user()->last_name}}</div>
                                <div class="f-12 text-muted">
                                @if(date('Y-m-d') == date('Y-m-d',strtotime($feedback->created_at)))
                                        {{ \Carbon\Carbon::parse($feedback->created_at)->diffForHumans()}}
                                    @else
                                        {{date('F dS Y',strtotime($feedback->created_at))}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <h4 class="m-l-10 m-t-10 feedback-title">{{$feedback->title}}</h4>
                    </div>
            </div>
            <div class="card-block" style="padding-top: 0px;">
                <div class="timeline-details">
                    <!-- <div class="chat-header">Josephin Doe posted</div> -->
                    <p class="text-muted feedback-title">{{$feedback->notes}}</p>
					<div class="clearfix"></div>
                    @if($fbimages->count() > 0)
                    <hr>
                    <div class="content">
                        <h5>Attachments</h5>
                        <div class="gg-container">
                            <div class="gg-box dark" id="horizontal">
                        </div>
                        <div class="gg-box dark" id="square">
                            <?php $i=1 ?>
                            @foreach($fbimages as $images)
                            <img data-id="{{$i}}" src="{{$images->image}}">
                            <?php $i++; ?>
                            @endforeach
                        </div>
                        <!--<div style="color: #bbd6bb;font-size: 16px;text-decoration: underline;text-align: center;margin-bottom: 10px;"><a href="">Show more</a></div> -->
                        </div>
                    </div>
                    @endif
                    <hr>
                </div>
            </div>

            @if($feedback->feedbackReplies()->count() > 0)
            <div class="row">
		
                <div class="col-lg-12">
				<ul class="list-unstyled">
				@foreach($feedback->feedbackReplies as $feedbackReply)
		@php
			$cuser = App\User::where('id',$feedbackReply->user_id)->first();
			if($cuser->id == 8){
				$pic = Avatar::create('Admin')->toBase64();
			}else{
				if($cuser->picture){
					$pic = $cuser->picture;
				}else{
					$pic = Avatar::create($cuser->first_name)->toBase64();
				}
			}
		@endphp
					<li class="media my-4">
						<img class="media-object img-radius m-r-20" src="{{$pic}}" width="45" height="45" alt="Admin">
						<div class="media-body feedback-comment">
						<div class="f-12 text-muted" style="position: absolute;right:25px;">
                            @if(date('Y-m-d') == date('Y-m-d',strtotime($feedbackReply->updated_at)))
                                {{ \Carbon\Carbon::parse($feedbackReply->updated_at)->diffForHumans()}}
                            @else
                                {{date('F dS Y',strtotime($feedbackReply->updated_at))}}
                            @endif
                        </div>
							<h5 class="mt-0 mb-1">{{$cuser->first_name.' '.$cuser->last_name}}</h5> {!! $feedbackReply->feedback_reply !!}
						</div>
					</li>
					@endforeach
				</ul>
										
                   
                </div>
				
            </div>
            @endif
            <hr>
			<h4 class="text-center m-b-20">Post your reply here</h4>
            <div class="media" style="margin-bottom:0px;">
                <div class="media-left media-middle friend-box">
                    <a href="#">
                        <img class="media-object img-radius m-r-20" src="{{Auth::user()->picture}}" alt="">
                    </a>
                </div>
                <div class="media-body">
                    <form class="form-material right-icon-control" method="post" action="{{url('feedback/replyFeedback')}}">
                        @csrf
                        @method('POST')
                        <div class="form-group form-default">
                            <input type="hidden" name="id" value="{{base64_encode($feedback->id)}}">
                            <textarea class="form-control summernote" name="comment" required="" placeholder="Post a reply..." style="width: 95%;"></textarea>
                            <span class="form-bar"></span>
							<span>{{ $errors->first('comment')}}</span>
							<button class="btn theme-outline-btn  btn-primary waves-effect waves-light m-t-20" style="float:right">
                                Post reply
                            </button>
                        </div>
                        
                    </form>
                </div>
            </div>
            

        </div>
    </div>
</div>
</div>
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
                        <textarea id="notes" class="form-control post-input m-t-10" style="border: .6px solid #dadada;" rows="3" cols="10" required="" name="notes" placeholder="Addittional notes if any..."></textarea>
                        <span class="red notes"></span>
                    </div>
                    <select name="type" id="type" class="form-control form-control-default fill m-t-10">
                        <option value="">Please Select Page</option>
                        <option value="Dashboard">Dashboard</option>
                        <option value="My Patterns">My Patterns</option>
                        <option value="Tech Knitter">Tech Knitter</option>
                        <option value="Sales">Sales</option>
                        <option value="Revenue">Revenue</option>
                        <option value="Connect">Connect</option>
                        <option value="To-Do">To-Do</option>
                        <option value="Academy">Academy</option>
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
<style>
.feedback-comment p{
	margin-bottom: 0px !important;
}
.feedback-title{
	width: 94%;
    float: right;
    text-align: justify;
}
</style>
<script type="text/javascript">
	var URL = '{{url("feedback/uploadImage")}}';
	var URL1 = '{{url("feedback/removeImage")}}';
</script>
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('resources/assets/marketplace/src/images-grid-custom.css') }}">
<link rel="stylesheet" href="{{ asset('resources/assets/marketplace/js/grid-gallery.css') }}">


<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
<script src="{{asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
<script type="text/javascript" src="{{asset('resources/assets/files/assets/pages/filer/feedback-fileupload.init.js')}}"></script>
       <!-- notification js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/bootstrap-growl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/pages/notification/notification.js') }}"></script>

<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/bootstrap-notify.min.js') }}"></script>
<script id="check" src="{{asset('resources/assets/marketplace/js/grid-gallery-original.js')}}"></script>

<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/summernote/summernote.min.css') }}" />
<script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.js') }}"></script>
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
		
		$('.summernote').summernote({
		height: 150,
	});


    gridGallery({
      selector: "#horizontal",
      layout: "horizontal"
    });
    gridGallery({
      selector: "#square",
      layout: "square"
    });

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
						addProductCartOrWishlist('fa fa-check','success','Project created successfully','success');
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