<?php
if($com->picture){
    $picture1 = $com->picture;
}else{
    $picture1 = 'https://via.placeholder.com/150?text='.$com->first_name;
}
?>

<div class="media @if($i > 3) hide @endif" id="comment{{$com->id}}">
    <a class="media-left" href="#">
        <img class="media-object img-radius m-r-20"
            src="{{$picture1}}"
            alt="{{$com->first_name}}">
    </a>
    @if(Auth::user()->id == $com->user_id)
<div class="col-lg-4 text-right" style="position: absolute;right: 15px;">
    <div class="dropdown-secondary dropdown d-inline-block">
        <span id="dropdown3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v" style="cursor: pointer;"></i>
        <div class="dropdown-menu" aria-labelledby="dropdown3" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
            <a class="dropdown-item waves-light waves-effect editComment" onclick="editPopup({{$com->id}},{{$com->group_timeline_id}})" href="javascript:;"><i class="icofont icofont-checked m-r-10"></i>Edit</a>
            <a class="dropdown-item waves-light waves-effect" href="javascript:;" onclick="OpenCommentDelete({{$com->id}});"><i class="fa fa-trash m-r-10"></i>Delete</a>
        <!-- end of dropdown menu -->
        </div>
    </div>
</div>
@endif
<?php
if($com->username){
    $username = $com->username;
}else{
    $na = explode('@', $com->email);
    $username = $na[0];
}
?>
    <div class="media-body b-b-theme social-client-description">
        <div class="chat-header">
            @if($com->user_id == Auth::user()->id)
        <a href="{{url('connect/myprofile')}}"> {{$com->first_name}} {{$com->last_name}}</a>
            @else
           <a href="{{url('connect/profile/'.$username.'/'.encrypt($com->uid))}}"> {{$com->first_name}} {{$com->last_name}}</a>
           @endif
            <span
                class="text-muted">
                @if(strtotime($com->updated_at) != strtotime($com->created_at))
                   Edited {{ \Carbon\Carbon::parse($com->updated_at)->diffForHumans()}}
                @else
                    {{ \Carbon\Carbon::parse($com->created_at)->diffForHumans()}}
                @endif
            </span></div>
        <p class="text-muted" id="commentval{{$com->id}}">{{$com->comment}}</p>
@php
    $comlikesCount = $com->likes()->count();
    $comlikesByme = $com->likes()->where('user_id',Auth::user()->id)->count();
@endphp
        <a href="javascript:;" class="@if($comlikesByme == 0) like-comment @else unlike-comment @endif" data-id="{{$com->id}}" id="commentlikable{{$com->id}}" data-timelineid="{{$com->group_timeline_id}}" >
            <i class="icofont icofont-heart-alt text-muted @if($comlikesByme > 0) liked @endif"></i>
        <span class="b-r-theme like-option ">Like (<b id="commentlike{{$com->id}}">{{$comlikesCount}}</b>)</span>
        </a>
    </div>

</div>
