@extends('layouts.admin')
@section('breadcrum')
    <div class="col-md-12 col-12 align-self-center">
        <h3 class="text-themecolor">Feedback</h3>
        <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
        </ol>
    </div>

@endsection
@section('section1')
@php
$postUser = App\User::where('id',$feedback->user_id)->first();
@endphp
<div class="card-body">
<div class="row justify-content-md-center">
<div class="col-lg-12"> <h5 class="m-b-30"><a class="theme-heading" href="{{url('admin/feedback')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to feedback index</a></h5></div>
    <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card bg-white p-relative p-20">
                <div class="card-block">
                    <div class="row justify-content-md-center">
                        <div class="col-lg-12">
                            <div class="media" style="padding:0px;margin-bottom: 0px;">
                                <div class="media-left media-middle friend-box">
                                    <a href="#">
                                        <img class="media-object img-radius m-r-20" src="{{Auth::user()->picture ? Auth::user()->picture : Avatar::create(Auth::user()->first_name)->toBase64()}}" alt="">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="chat-header">{{ucfirst($postUser->first_name)}} {{$postUser->last_name}}</div>
                                    <div class="f-12 text-muted">
                                        @if(date('Y-m-d') == date('Y-m-d',strtotime($feedback->created_at)))
                                            {{ \Carbon\Carbon::parse($feedback->created_at)->diffForHumans()}}
                                        @else
                                            {{date('F dS Y',strtotime($feedback->created_at))}}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <h5 class="m-l-10 m-t-10 feedback-title">{{$feedback->title}}</h5>
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
                    </div>
                </div>
				
				<div class="row">
					<div class="col-md-12">
						<h3 class="text-center m-b-10 b-t-10">Comments</h3>
						<hr>
					</div>
				</div>
                
                @if($feedback->feedbackReplies()->count() > 0)
            <div class="row">
		
                <div class="col-lg-12">
				<div class="comment-widgets">
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
				
                                
                                <div class="d-flex flex-row comment-row" style="padding:0px;">
                                    <div class="p-2"><span class="round"><img src="{{$pic}}" alt="Admin" width="45" height="45"></span></div>
                                    <div class="comment-text active w-100" style="padding: 15px 15px 0px 5px;">
                                        <h5>{{$cuser->first_name.' '.$cuser->last_name}}</h5>
                                        <p class="m-b-5 feedback-comment">{!! $feedbackReply->feedback_reply !!}</p>
                                        <div class="comment-footer "> 
											<span class="text-muted pull-right">
											@if(date('Y-m-d') == date('Y-m-d',strtotime($feedbackReply->updated_at)))
												{{ \Carbon\Carbon::parse($feedbackReply->updated_at)->diffForHumans()}}
											@else
												{{date('F dS Y',strtotime($feedbackReply->updated_at))}}
											@endif
											</span> 
											<!--<span class="label label-light-success">Approved</span> 
											<span class="action-icons active">
												<a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
												<a href="javascript:void(0)"><i class="icon-close"></i></a>
												<a href="javascript:void(0)"><i class="ti-heart text-danger"></i></a>    
											</span> -->
										</div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                
                                
                            
					@endforeach
				</div>
										
                   
                </div>
				
            </div>
            @endif
			<hr>
			<h4>Post your reply here</h4>
            <div class="media" style="margin-bottom:0px;">
                <div class="media-left media-middle friend-box">
                    <a href="#">
                        <img class="media-object img-radius m-r-20" src="{{Avatar::create('Admin')->toBase64()}}" alt="">
                    </a>
                </div>
                <div class="media-body">
                    <form class="form-material right-icon-control" method="post" action="{{route('feedback.reply')}}">
                        @csrf
                        @method('POST')
                        <div class="form-group form-default">
                            <input type="hidden" name="id" value="{{base64_encode($feedback->id)}}">
                            <textarea class="form-control summernote" name="comment" required="" placeholder="Post a reply..." style="width: 95%;"></textarea>
                            <span class="form-bar"></span>
							<span>{{ $errors->first('comment')}}</span>
							<button class="btn theme-outline-btn btn-icon btn-primary waves-effect waves-light m-t-20" style="position:absolute;right:35px;">
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
</div>

@endsection
@section('footerscript')
<style>
.feedback-title{
	width: 93%;
    float: right;
    text-align: justify;
}
.page-titles{
	margin: 0 -30px 0px !important;
}
.comment-text p{
	margin-bottom: 0px !important;
	max-height: fit-content !important;
	overflow: visible !important;
	text-align: justify;
}
.round{
	background: none !important;
}
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/css/Marketplace.css') }}">
<link rel="stylesheet" href="{{ asset('resources/assets/marketplace/js/grid-gallery.css') }}">
<script id="check" src="{{asset('resources/assets/marketplace/js/grid-gallery-original.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/summernote/summernote.min.css') }}" />
<script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.js') }}"></script>
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

});
</script>
@endsection