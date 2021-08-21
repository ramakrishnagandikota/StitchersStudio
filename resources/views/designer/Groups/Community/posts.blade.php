<div class="posts" id="timeline{{$time->id}}"  style="opacity:0.1;">
    <?php
    if($time->picture){
        $picture = $time->picture;
    }else{
        $picture = 'https://via.placeholder.com/150?text='.$time->first_name;
    }
    ?>
    <?php
    if($time->username){
        $username = $time->username;
    }else{
        $na = explode('@', $time->email);
        $username = $na[0];
    }
    ?>
    <div >
        <div class="card bg-white p-relative">
            <div class="card-block">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="media">
                            <div class="media-left media-middle friend-box">
                                <a href="#">
                                    <img class="media-object img-radius m-r-20"
                                         src="{{$picture}}" alt="{{$time->first_name}}">
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="chat-header">
                                    @if(Auth::user()->id == $time->user_id)
                                        <b><a href="{{url('connect/myprofile')}}"> {{ucfirst($time->first_name)}} {{ucfirst($time->last_name)}}</a> </b>
                                    @else
                                        <b><a href="{{url('connect/profile/'.$username.'/'.encrypt($time->uid))}}">{{ucfirst($time->first_name)}} {{ucfirst($time->last_name)}} </a></b>
                                    @endif

                                    posted</div>
                                <div class="f-13 text-muted">{{ \Carbon\Carbon::parse($time->created_at)->diffForHumans()}}</div>
                            </div>
                        </div>
                    </div>

                    @if(Auth::user()->id == $time->user_id)

                        <div class="col-lg-4 text-right">
                            <div class="dropdown-secondary dropdown d-inline-block ">
                                <span id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-ellipsis-v" style="cursor: pointer;"></i>
                                <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                    <a class="dropdown-item waves-light waves-effect" onclick="OpenEdit({{$time->id}});" href="javascript:;"><i class="icofont icofont-checked m-r-10"></i>Edit</a>
                                    <a class="dropdown-item waves-light waves-effect" href="javascript:;" onclick="OpenDelete({{$time->id}});"><i class="fa fa-trash m-r-10"></i>Delete</a>
            <!-- end of dropdown menu -->
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                <div class="card-block" style="padding-top: 0px;">
                    <!-- <p>More than five images</p>
                    <div id="gallery1"></div> -->

                    <?php
                    $images = $time->images;
                    ?>
                    @if($images->count() > 0)
                        <div class="content">
                            <div class="gg-container" id="container{{$time->id}}">
                                <div class="gg-box dark" id="horizontal{{$time->id}}"></div>
                                <div class="gg-box dark @if($images->count() == 1) single-cover @elseif($images->count() == 2) double-cover @elseif($images->count() == 3) tripple-cover @elseif($images->count() == 4) fourth-cover @else fifth-cover @endif" id="square{{$time->id}}" >
                                    <?php $i=1; ?>
                                    @foreach($images as $image)
                                        <img @if($i > 6) class="hide" @endif data-tid="{{$time->id}}" onclick="imagePopup({{$time->id}})" id="image{{$time->id}}" data-id="{{$i}}" src="{{ $image->image_path }}">
                                        <?php $i++; ?>
                                    @endforeach
                                </div>
                                @if($i > 6)
                                    <div style="color: #bbd6bb;font-size: 16px;text-decoration: underline;text-align: center;">
                                        <a href="javascript:;" class="show-more" onclick="imagePopup({{$time->id}})" data-id="{{$time->id}}">Show more</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="timeline-details">
                        <!-- <div class="chat-header">Josephin Doe posted</div> -->
                        <p class="text-muted">{{$time->post_content}}</p>

                        @if($time->tag_friends)
                            <p>With
                                @php
                                    $exp = explode(',', $time->tag_friends);
                                @endphp
                                @for($i=0; $i < count($exp); $i++)
                                    <?php  $frie = App\User::where('id',$exp[$i])->first(); ?>
                                    @if($frie)
                                        @if($i == 0)
                                            <b>{{ucfirst($frie->first_name)}} {{ucfirst($frie->last_name)}}</b>
                                        @elseif($i == (count($exp) - 1))
                                            and <b>{{ucfirst($frie->first_name)}} {{ucfirst($frie->last_name)}}</b>
                                        @else
                                            <b>{{ucfirst($frie->first_name)}} {{ucfirst($frie->last_name)}}</b>
                                        @endif
                                    @endif
                                @endfor

                            </p>
                        @endif
                        @if($time->location)
                            <p>At {{$time->location}}</p>
                        @endif
                    </div>
                    <?php
                    $likeCount = $time->likes()->where('user_id',Auth::user()->id)->count();
                    ?>
                    <div class="card-block b-b-theme b-t-theme social-msg">
                        <a href="javascript:;" class="@if($likeCount == 0) like-post @else unlike-post @endif" id="likable{{$time->id}}" data-id="{{$time->id}}">
                            <i class="icofont icofont-heart-alt text-muted @if($likeCount != 0) liked @endif"></i>
                            <span class="b-r-theme">Like (<b id="like{{$time->id}}">{{$time->likes()->count()}}</b>)</span>
                        </a>
                        <a href="#">
                            <i class="icofont icofont-comment text-muted">

                            </i>
                            <span class="b-r-theme">Comments (<span class="nopm" id="commentCount{{$time->id}}" class="commentCount{{$time->id}}">{{$time->comments()->count()}}</span>)</span>
                        </a>
                        <!--
                        <a href="#">
                            <i class="icofont icofont-share text-muted"></i>
                            <span data-toggle="modal" data-target="#ShareModal">Share (10)</span>
                        </a> -->
                        <!--
                        <a href="#">
                            <i class="icofont icofont-share text-muted">

                            </i>
                            <span>Share (10)</span>
                        </a>
                         -->
                    </div>


                    <div class="card-block user-box" id="timelineComments{{$time->id}}">

                        <div id="comments-div{{$time->id}}" class="p-b-20 @if($time->comments->count() == 0) hide @endif">
    <span class="f-14"><a href="Javascript:;" class="showHidecomments" data-id="{{$time->id}}">Comments (<span class="commentCount{{$time->id}}">{{$time->comments()->count()}}</span>)</a>
    </span>
                            <span class="float-right"><a href="Javascript:;" class="loadAllComments" data-id="{{$time->id}}">See all comments</a></span>
                        </div>

                        @if($time->comments->count() > 0)
                            @php
                                $comments = $time->comments()->leftJoin('users','users.id','group_timeline_comments.user_id')->select('group_timeline_comments.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')->where('group_timeline_comments.status',1)->get();
                            @endphp

                            <?php $i=1; ?>
                            @foreach($comments as $comment)
                                @component('Designer.Groups.Community.comments',['com' => $comment,'i' => $i])

                                @endcomponent
                                <?php $i++; ?>
                            @endforeach
                        @endif

                        @php
                            if(Auth::user()->picture){
                              $pic = Auth::user()->picture;
                            }else{
                                $a = Auth::user()->first_name;
                                $firstChar = mb_substr($a, 0, 1, "UTF-8");
                              $pic = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.$firstChar;
                            }
                        @endphp
                        <div id="showComments{{$time->id}}"></div>
                        <!-- add new comment start-->
                        <div class="media">
                            <a class="media-left" href="#">
                                <img class="media-object img-radius m-r-20"
                                     src="{{$pic}}"
                                     alt="Generic placeholder image">
                            </a>
                            <div class="media-body">
                                <form class="form-material right-icon-control" id="AddComment{{$time->id}}">
                                    <div class="form-group form-default">
                                        <textarea class="form-control" name="comment"  required=""></textarea>
                                        <span class="form-bar"></span>
                                        <label class="float-label">Write something...</label>
                                    </div>
                                    <div class="form-icon ">
                                        <button type="button"
                                                class="btn theme-outline-btn btn-icon  waves-effect waves-light submitComment" data-id="{{$time->id}}">
                                            <i class="fa fa-paper-plane "></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- add new comment end-->
                        <input type="hidden" class="lastId" value="{{$time->id}}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <span style="display:none;">
<input type="hidden"  id="commentsbox{{$time->id}}" value='
<div class="gg-image" style="width:72%;float:left;left:0;height:97vh"></div>
<div class="gg-close gg-btn" style="z-index:99999">&times</div>
<div class="gg-next gg-btn" style="z-index:99999">&rarr;</div>
<div class="gg-prev gg-btn" style="z-index:99999">&larr;</div>
<div class="gg-image-right" style="background-color:white;padding:20px;position:absolute;width:27%;float:right;right:0;height:97vh;color:red;font-size:24px;overflow-y:scroll;text-align:left" >
    <div class="">
        <div class="timeline-details">
        <div class="chat-header text-muted addReadMore showlesscontent" style="font-weight:normal;font-size:13px;">{{$time->post_content}}</p>
        </div>
    </div>
    <div class="b-t-theme social-msg">
        <a href="#"> <i class="icofont icofont-heart-alt text-muted @if($likeCount != 0) liked @endif"> </i> <span class="b-r-theme">Like ({{$time->likes()->count()}})</span> </a>
        <a href="#"> <i class="icofont icofont-comment text-muted"> </i> <span class="b-r-theme">Comments ({{$time->comments()->count()}})</span> </a>

    </div>
    <div class="card-block user-box" id="lazy-container">
        <hr>
@php
    $comments = $time->comments()->leftJoin('users','users.id','group_timeline_comments.user_id')->select('group_timeline_comments.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')->where('group_timeline_comments.status',1)->get();
@endphp
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
    <div class="media col-md-3 row" style="display:none;position:fixed;bottom:0px;background: #fff;">
    <a class="" href="#"> <img class="media-object img-radius m-r-20" src="{{Auth::user()->picture}}" alt="Generic placeholder image"> </a>
            <div class="media-body">
                <form class="form-material right-icon-control">
                    <div class="form-group form-default">
                        <textarea class="form-control" ></textarea> <span class="form-bar"></span>
                        <label class="float-label">Write something.....</label>
                    </div>
                    <div class="form-icon ">
                        <button type="button" class="btn theme-outline-btn btn-icon waves-effect waves-light" > <i class="fa fa-paper-plane "></i> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
' >
</span>

    <style>
        div#lazy-container {
            height: 55%;
            overflow: auto;
        }
        .addReadMoreWrapTxt.showmorecontent .SecSec,
        .addReadMoreWrapTxt.showmorecontent .readLess {
            display: block;
        }
        .addReadMore.showlesscontent .SecSec,
        .addReadMore.showlesscontent .readLess {
            display: none;
        }

        .addReadMore.showmorecontent .readMore {
            display: none;
        }
        .readMore,.readLess,#loadMores,#top{
            color: #0d665c;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
    @if($images->count() > 0)
        <script>
            setTimeout(function(){
                loadPlugin();
                /* gridGallery({
                     selector: ".dark",
                     darkMode: true
                 });
                 gridGallery({
                     selector: "#horizontal{{$time->id}}",
            layout: "horizontal"
        }); */
                gridGallery({
                    selector: "#square{{$time->id}}",
                    layout: "square"
                });
            },2000);
        </script>
    @endif
    <script>
        setTimeout(function(){ $("#timeline{{$time->id}}").css("opacity",1); },2000);
    </script>
</div>
