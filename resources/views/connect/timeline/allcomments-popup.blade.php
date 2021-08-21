<?php
$likeCount = $time->likes()->where('user_id',Auth::user()->id)->count();
?>

<div class="gg-image-right" style="background-color:white;padding:20px;position:absolute;width:27%;float:right;right:0;height:97vh;color:red;font-size:24px;overflow-y:scroll;text-align:left" >
    <div class="">
        <div class="timeline-details">
        <div class="chat-header">{{$time->post_content}}</p>
        </div>
    </div>
    <div class="b-t-theme social-msg">
        <a href="#"> <i class="icofont icofont-heart-alt text-muted @if($likeCount != 0) liked @endif"> </i> <span class="b-r-theme">Like ({{$time->likes()->count()}})</span> </a>
        <a href="#"> <i class="icofont icofont-comment text-muted"> </i> <span class="b-r-theme">Comments ({{$time->comments()->count()}})</span> </a>
        <a href="#"> <i class="icofont icofont-share text-muted"> </i> <span>Share (10)</span> </a>
    </div>
    <div class="card-block user-box" id="lazy-container">
        <hr>

@if($comments->count() > 0)
<?php $k=0; ?>
    @foreach($comments as $comm)
    <?php
    if($comm->picture){
        $picture = $comm->picture;
    }else{
        $a = $comm->first_name;
        $firstChar = mb_substr($a, 0, 1, "UTF-8");
        $picture = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.$firstChar;
    }
    ?>
        <div class="lazy media" @if($k > 3) style="display:none;" @endif>
            <a class="" href="#"> <img class="media-object img-radius m-r-20" src="{{$picture}}" alt="{{$comm->first_name}}"> </a>
            <div class="media-body b-b-theme social-client-description">
                <div class="chat-header text-left">{{$comm->first_name}} {{$comm->last_name}}
                    <br><span class="text-muted">{{$comm->created_at->diffForHumans()}}</span></div>
                <p class="text-muted text-left addReadMore showlesscontent">{{$comm->comment}}</p>
            </div>
        </div>
        <?php $k++; ?>
    @endforeach
@else
<div class="text-center">
<p>No comments to show</p>
</div>
@endif

@if($comments->count() > 3)
    <p class="totop">
        <a href="javascript:;" id="loadMores" class="text-left">Load More</a>
        <a href="javascript:;" id="top" style="float:right">Back to top</a>
    </p>
@endif
        <div class="media col-md-3 row" style="position:fixed;bottom:0px;background: #fff;">
        <a class="" href="#"> <img class="media-object img-radius m-r-20" src="{{Auth::user()->picture}}" alt="Generic placeholder image"> </a>
            <div class="media-body">
                <form class="form-material right-icon-control">
                    <div class="form-group form-default">
                        <textarea class="form-control" required=""></textarea> <span class="form-bar"></span>
                        <label class="float-label">Write something.....</label>
                    </div>
                    <div class="form-icon ">
                        <button class="btn theme-outline-btn btn-icon waves-effect waves-light"> <i class="fa fa-paper-plane "></i> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
