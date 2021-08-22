@extends('layouts.adminnew')
@section('title','Feedback')
@section('section1')
<div class="page-body m-t-15">
<div class="row justify-content-md-center">
<div class="col-lg-9"> <h5 class="m-b-30"><a class="theme-heading" href="{{url('adminnew/feedback')}}"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to feedback index</a></h5></div>
    <div class="col-lg-9 col-md-9 col-sm-9">
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
                            <h4 class="m-l-10 m-t-10">{{$feedback->title}}</h4>
                        </div>
                </div>
                <div class="card-block" style="padding-top: 0px;">
                    <div class="timeline-details">
                        <!-- <div class="chat-header">Josephin Doe posted</div> -->
                        <p class="text-muted">{{$feedback->notes}}</p>
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
                
                @if($feedback->comment)
            <div class="row">
                <div class="col-lg-12">
                    <div class="media">
                        <div class="media-left media-middle friend-box">
                            <a href="#">
                                <img class="media-object img-radius m-r-20" src="{{Avatar::create('Admin')->toBase64()}}" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <div class="chat-header">Admin</div>
                            <div class="f-12 text-muted">
                            @if(date('Y-m-d') == date('Y-m-d',strtotime($feedback->updated_at)))
                                {{ \Carbon\Carbon::parse($feedback->updated_at)->diffForHumans()}}
                            @else
                                {{date('F dS Y',strtotime($feedback->updated_at))}}
                            @endif
                                </div>
                        </div>
                    </div>
                    <p class="text-muted m-l-10 m-t-10">{{$feedback->comment}}</p>
                </div>
            </div>
            @else
            <div class="media">
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
                            <textarea class="form-control" name="comment" required=""></textarea>
                            <span class="form-bar"></span>
                            <label class="float-label">Post a reply...</label>
                        </div>
                        <div class="form-icon ">
                            <button class="btn theme-outline-btn btn-icon  waves-effect waves-light">
                                <i class="fa fa-paper-plane "></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
            </div>
        </div>
    </div>
</div>
</div>

@endsection
@section('footerscript')
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/css/Marketplace.css') }}">
<link rel="stylesheet" href="{{ asset('resources/assets/marketplace/js/grid-gallery.css') }}">
<script id="check" src="{{asset('resources/assets/marketplace/js/grid-gallery-original.js')}}"></script>

<script type="text/javascript">
	$(function(){


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