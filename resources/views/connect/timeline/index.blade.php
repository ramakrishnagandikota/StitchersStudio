@extends('layouts.connect')
@section('title','Connect Timeline')
@section('content')
<!-- Page-body start -->
<div class="page-body m-t-15">

<div class="row">
<div class="col-lg-2"></div>
<div class="col-md-8">

<a href="javascript:;" style="
width: auto;
position: fixed;
right: 7px;
bottom: 64px;
z-index: 1;display:none;background: rgb(13, 102, 92) !important;padding: 5px;" id="scrollToTop"><i class="fa fa-chevron-up fa-2x" style="color:#fff;" aria-hidden="true"></i></a>
<span><a href="javascript:;" id="post-new-static" onclick="OpenAdd();" class="btn theme-btn waves-effect waves-light float-right back-to-top page-scroll"
><i class="fa fa-pencil-square-o m-r-10"></i> Create post</a></span>

<div id="Post"></div>
<div class="containers">

{{$timeline->links()}}
@foreach($timeline as $time)

@if($time->privacy == 'only-me')
    @if(Auth::user()->id == $time->user_id)
        @component('connect.timeline.posts', ['time' => $time]) @endcomponent
    @endif
@endif

@if($time->privacy == 'friends')
@if(Auth::user()->id == $time->user_id)
    @component('connect.timeline.posts', ['time' => $time]) @endcomponent
@endif
    @foreach($friends as $friend)
        @if($friend->friend_id == $time->user_id)
            @component('connect.timeline.posts', ['time' => $time]) @endcomponent
        @endif
    @endforeach
@endif

@if($time->privacy == 'followers')
@if(Auth::user()->id == $time->user_id)
    @component('connect.timeline.posts', ['time' => $time]) @endcomponent
@endif
    @foreach($follow as $foll)
        @if($foll->follow_user_id == $time->user_id)
            @component('connect.timeline.posts', ['time' => $time]) @endcomponent
        @endif
    @endforeach
@endif

@if($time->privacy == 'public')
    @component('connect.timeline.posts', ['time' => $time]) @endcomponent
@endif

@endforeach



</div>

<div class="page-load-status" style="display: none;">
    <div class="infinite-scroll-request">
        <div class="loader-ellips">
            <span class="loader-ellips__dot"></span>
            <span class="loader-ellips__dot"></span>
            <span class="loader-ellips__dot"></span>
            <span class="loader-ellips__dot"></span>
          </div>
        </div>
    <p class="infinite-scroll-last text-center">No more posts to show</p>
  </div>

<div id="target"></div>
<div class="text-center hide" id="pre-loader"><img style="height: 50px;" src="{{asset('resources/assets/preloader.gif')}}"></div>
</div>
</div>
<!-- Round card end -->
</div>
<!-- Page-body end -->


<div class="modal fade" id="myModal" role="dialog" style="z-index: 10000;">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
              <div class="modal-header">
                  <h6 class="modal-title">Privacy settings</h6>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
            <div class="modal-body m-t-15">
                <div class="row">
                    <div class="form-radio m-l-30">
                        <form id="post-privacy">
                            @csrf
                            <input type="hidden" name="tid" id="postId" value="0">
                <div class="group-add-on" id="privacy_check">
                    <div class="radio radiofill radio-inline">
                        <label>
                            <input type="radio" class="updatePrivacy" name="privacy" id="public" value="public"><i class="helper"></i> Public
                        </label>
                    </div>
                    <div class="radio radiofill radio-inline">
                        <label>
                            <input type="radio" class="updatePrivacy" name="privacy" id="friends" value="friends"><i class="helper"></i> Friends
                        </label>
                    </div>
                    <div class="radio radiofill radio-inline">
                            <label>
                                <input type="radio" class="updatePrivacy" name="privacy" id="followers" value="followers"><i class="helper"></i> Followers
                            </label>
                        </div>
                    <div class="radio radiofill radio-inline">
                        <label>
                            <input type="radio" class="updatePrivacy" name="privacy" id="only-me" value="only-me"><i class="helper"></i> Only Me
                        </label>
                    </div>
                </div>
            </form>
            </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                <button  id="savePrivacy" type="button" class="btn btn-danger" >Update</button>
        </div>
          </div>
        </div>
</div>


    <!--Modal for Delete Confirmation-->
  <div class="modal fade" id="delete-Modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
              <h5 class="modal-title f-w-500">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p></p>
               <p class="text-center"> <img class="img-fluid" src="{{url('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo" /></p>
               <h6 class="text-center f-w-500">Do you really want to delete this post ?</h6>
               <input type="hidden" id="postdelId" value="0">
               <!-- <h6 class="text-center">Action cannot be Undone !</h6> -->
               <p></p>
        </div>
        <div class="modal-footer">
                <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                <button  id="clear-all-tasks" type="button" class="btn btn-danger delete-card" data-dismiss="modal">Delete</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="commentdelete-Modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
              <h5 class="modal-title f-w-500">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p></p>
               <p class="text-center"> <img class="img-fluid" src="{{url('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo" /></p>
               <h6 class="text-center f-w-500">Do you really want to delete this comment ?</h6>
               <input type="hidden" id="commentdelId" value="0">
               <!-- <h6 class="text-center">Action cannot be Undone !</h6> -->
               <p></p>
        </div>
        <div class="modal-footer">
                <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                <button  id="clear-all-tasks" type="button" class="btn btn-danger delete-comment" data-dismiss="modal">Delete</button>
        </div>
      </div>
    </div>
  </div>

      <!--Modal for Edit comment-->
  <div class="modal fade" id="editComment-Modal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
              <h5 class="modal-title f-w-500">Comment</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <form class="form-material right-icon-control" id="UpdateComment">
                @csrf
        <div class="form-group form-default">
            <input type="hidden" id="cid" name="cid" value="0">
            <input type="hidden" id="tid" value="0">
            <textarea class="form-control fill" id="editcomment" name="comment" required=""></textarea>
            <span class="form-bar"></span>
            <label class="float-label">Write something...</label>
        </div>
    </form>
        </div>
        <div class="modal-footer">
                <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                <button id="commentUpdate" type="button" class="btn btn-danger" >Update Comment</button>
        </div>
      </div>
    </div>
  </div>

  <!-- create post -->

   <div class="modal fade bd-example-modal-lg" aria-labelledby="myLargeModalLabel" id="PostModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content" id="modal-data">

    <div class="text-center" id="pre-loader"><img style="height: 50px;" src="{{asset('resources/assets/preloader.gif')}}"></div>

      </div>
      <!-- modal content end -->
    </div>
  </div>


  <div class="modal fade" id="ShareModal" role="dialog">
    <div class="modal-dialog" style="max-width: 580px;">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
            <h6 class="modal-title">Share on Timeline</h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">


        </div>
      </div>
    </div>
  </div>

<audio id="myAudio" class="hide">
  <!-- <source src="horse.ogg" type="audio/ogg"> -->
  <source src="{{asset('resources/assets/pc.mp3')}}" type="audio/mpeg">
</audio>
@endsection
@section('footerscript')
<script type="text/javascript">
    var URL = '{{url("connect/imageUpload")}}';
    var URL1 = '';
    var CLOSE = '{{asset('resources/assets/marketplace/images/close.png')}}';
</script>
<style>
#upload-icon{position: relative;top:0px}
         .fbphotobox-container-left{margin-left: -4px;}
        .fbphotobox-main-container{padding-top: 25px;}
        .fbphotobox-image-content{padding:20px}
        .fbphotobox-container-right{overflow-y: scroll;}
        .fbphotobox img {
            width:200px;
            height:200px;
            margin:2px;
            border-radius:5px;
        }

        .fbphotobox img:hover {
            box-sizing:border-box;
              -moz-box-sizing:border-box;
              -webkit-box-sizing:border-box;
            border: 3px solid #0d665c;
        }
        .fbphotobox-main-container{margin-top: 35px;}
        .fa-trash{color: #666;}
        .image-upload img{width: 100%;}
        .input-group-append .input-group-text, .input-group-prepend .input-group-text{background-color: #faf9f8;color: #0d665c;}
        .options{color: #78909c;border: .5px solid #78909c;border-radius: 2px;margin-left: 28px;float: left;left: 0;position: absolute;}
        #post-buttons{position: absolute!important;top: 186px;margin-left: 58px;margin-top: 8px;}
        .upload{margin-left: 46px;}
        .jFiler-theme-dragdropbox{margin-top: 8px;}
        .post-new-footer i{ *margin-left: 20px !important;}
        .jFiler-items{margin-top: 20px;}
        #post-new-static{position: fixed;bottom: 10px;right: 6px;}
        .hide{
            display: none;
        }
        .liked{
            color: #0d665b !important
        }
        .nopm{
            padding: 0px !important;
            margin: 0px !important;
        }
        .red{
            border: 1px solid #bc7c8f !important;
        }
        .loader-ellips {
  font-size: 20px; /* change size here */
  position: relative;
  width: 4em;
  height: 1em;
  margin: 10px auto;
}

.loader-ellips__dot {
  display: block;
  width: 1em;
  height: 1em;
  border-radius: 0.5em;
  background: #0d665c !important; /* change color here */
  position: absolute;
  animation-duration: 0.5s;
  animation-timing-function: ease;
  animation-iteration-count: infinite;
}

.loader-ellips__dot:nth-child(1),
.loader-ellips__dot:nth-child(2) {
  left: 0;
}
.loader-ellips__dot:nth-child(3) { left: 1.5em; }
.loader-ellips__dot:nth-child(4) { left: 3em; }

@keyframes reveal {
  from { transform: scale(0.001); }
  to { transform: scale(1); }
}

@keyframes slide {
  to { transform: translateX(1.5em) }
}

.loader-ellips__dot:nth-child(1) {
  animation-name: reveal;
}

.loader-ellips__dot:nth-child(2),
.loader-ellips__dot:nth-child(3) {
  animation-name: slide;
}

.loader-ellips__dot:nth-child(4) {
  animation-name: reveal;
  animation-direction: reverse;
}

</style>


<!-- jquery file upload Frame work -->
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />

<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>


<link rel="stylesheet" type="text/css" href="{{asset('resources/assets/select2/select2.min.css')}}">
<script type="text/javascript" src="{{asset('resources/assets/select2/select2.full.min.js')}}"></script>

<script src="{{asset('resources/assets/infinite-scroll.pkgd.min.js')}}"></script>
<script>
    /* infinite-scroll code */
var $container = $(".containers");
	$container.infiniteScroll({
	  //path: '.pagination__next',
      path: function() {
         // alert(this.loadCount);
         if(this.loadCount <= {{$timeline->lastPage()}}){
            var pageNumber = ( this.loadCount + 2 ) * 1;
            return '{{url("connect?page=")}}'+pageNumber;
         }

        //return '/articles/P' + pageNumber;
      },
      append: '.posts',
      history: false,
      status: '.page-load-status',
      scrollThreshold: 100,
      hideNav: '.pagination',
	});
/* infinite-scroll */
//loadImagePlugin();

$(document).on('keypress','.form-control',function(){
    var val = $(this).val();
    if(val.length > 0){
        $(this).addClass('fill');
    }else{
        $(this).removeClass('fill');
    }
});

$('#PostModal').modal('hide');
/* $('#PostModal').modal({
backdrop: 'static',
keyboard: false
}) */
function OpenEdit(id){
    var options = {
         backdrop: 'static',
         keyboard: false
    }
$("#PostModal").modal(options);
$("#timeline"+id).slideUp();
$.get("{{url('connect/editAddPost')}}/"+id,function(res){
    $("#modal-data").html(res);
    $('#mySelect2').select2({
        placeholder: 'Select your friends for tagging',
        minimumInputLength: 2,
        allowClear: true
    });
});
}

function closePopup(id){
    $("#PostModal").modal('hide');
    $("#timeline"+id).slideDown();
}

function OpenAdd(){
$("#PostModal").modal("show");
$.get('{{url("connect/showAddPost")}}',function(res){
    $("#modal-data").html(res);

    $('#mySelect2').select2({
        placeholder: 'Select your friends for tagging',
        minimumInputLength: 2,
        allowClear: true
    });
$('#post-new').attr("disabled",true);
});
}

function OpenPrivacy(id){
$("#myModal").modal("show");
var privacy = $("#privacy-drop"+id).attr('data-privacy');
$("#postId").val(id);
$("#privacy_check #"+privacy).prop('checked',true);
}

function editPopup(cid,tid){
    var comment = $("#commentval"+cid).html();
    $("#editcomment").val(comment);
    $("#cid").val(cid);
    $("#tid").val(tid);
    $("#editComment-Modal").modal('show');
    //$("#comment"+cid).hide();
}

function OpenDelete(id){
$("#delete-Modal").modal("show");
$("#postdelId").val(id);
}

function OpenCommentDelete(id){
$("#commentdelete-Modal").modal("show");
$("#commentdelId").val(id);
}


$(document).ready(function() {

//$(".timelineComments > div.media:lt:(4)").removeClass('hide');


$(document).on('click','.deleteImage',function(){
    var id = $(this).attr('data-id');
    if(confirm('Are you sure want to delete this image ?')){
        $.get('{{url("connect/deleteImage")}}/'+id,function(res){
            if(res.status == 'success'){
                $("#image"+id).remove();
            }else{
                addProductCartOrWishlist('fa-times','error','Unable to delete image.Try after some time.');
                setTimeout(function(){ location.reload(); },2000);
            }
        });
    }
});

$(document).on('click','.loadAllComments',function(){
    var a = 10;
    var id = $(this).attr('data-id');
    var hiddenMedia = $("#timelineComments"+id+" > div.media.hide").length;
    if(hiddenMedia != 0){
        if(a < hiddenMedia){
            a = 10;
        }else{
            a = hiddenMedia;
        }
    $("#timelineComments"+id+" > div.media.hide:lt("+a+")").removeClass('hide');
    }
});

$(document).on('click','#tag',function(){
    $("#with").toggleClass('hide');
});

$(document).on('click','#location',function(){
    $("#locate").toggleClass('hide');
});

$(document).on('click','#post-new',function(){
    var post_content = $("#post_content").val();
    var post_privacy = $("#post_privacy").val();
    var locate = $("#locate").hasClass('hide');
    var share_location = $("#share_location").val();
    var $with = $("#with").hasClass('hide');
    var mySelect2 = $("#mySelect2").val();
    var er = [];
    var cnt = 0;

    if(post_content == ""){
        $("#post_content").addClass('red');
        er+=cnt+1;
    }else{
        $("#post_content").removeClass('hide');
    }

    if(post_privacy == 0){
        $("#post_privacy").addClass('red');
        er+=cnt+1;
    }else{
        $("Epost_privacy").removeClass('hide');
    }


    if(er != ""){
        addProductCartOrWishlist('fa-times','error','Please fill all the required fields.');
        return false;
    }



    var Data = $("#addPost").serializeArray();

    $.ajax({
        url : '{{url("connect/addPost")}}',
        type : 'POST',
        data : Data,
        beforeSend : function(){
            $(".loader-bg").show();
        },
        success : function(res){
            if(res.error){
                addProductCartOrWishlist('fa-times','error',res.error);
            }else{
                //playAudio();
                $('#PostModal').modal('hide');
                $("#Post").prepend(res);
                //setTimeout(function(){ loadImagePlugin(); },2000);
                addProductCartOrWishlist('fa-check','success','Post added successfully');
            }

        },
        complete : function(){
            $(".loader-bg").hide();
        }
    });
});

$(document).on('keyup','#post_content',function(){
    var val = $("#post_content").val();

    if(val != ""){
        $("#post-new").prop('disabled',false);
    }else{
        $("#post-new").prop('disabled',true);
    }
});

$(document).on('click','#post-update',function(){
    var post_content = $("#post_content").val();
    var post_privacy = $("#post_privacy").val();
    var er = [];
    var cnt = 0;

    if(post_content == ""){
        $("#post_content").addClass('red');
        er+=cnt+1;
    }else{
        $("#post_content").removeClass('hide');
    }

    if(post_privacy == 0){
        $("#post_privacy").addClass('red');
        er+=cnt+1;
    }else{
        $("Epost_privacy").removeClass('hide');
    }

    if(er != ""){
        addProductCartOrWishlist('fa-times','error','Please fill all the required fields.');
        return false;
    }

    var Data = $("#updatePost").serializeArray();
    var id = $("#timelineid").val();

    $.ajax({
        url : '{{url("connect/updatePost")}}',
        type : 'POST',
        data : Data,
        beforeSend : function(){
            $(".loader-bg").show();
        },
        success : function(res){
            if(res.error){
                addProductCartOrWishlist('fa-times','error',res.error);
            }else{
                //playAudio();
                $("#timeline"+id).remove();
                $('#PostModal').modal('hide');
                $("#Post").prepend(res);
                //setTimeout(function(){ loadImagePlugin(); },2000);
                addProductCartOrWishlist('fa-check','success','Post updated successfully.');
            }

        },
        complete : function(){
            $(".loader-bg").hide();
        }
    });
});

$(document).on('click','.like-post',function(){
    var timeline_id = $(this).attr('data-id');
    var Data = 'timeline_id='+timeline_id;

    var likeCount = $("#like"+timeline_id).html();
    var addLike = parseInt(likeCount) + 1;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url : '{{url("connect/addLike")}}',
        type : 'POST',
        data : Data,
        beforeSend : function(){
            //$(".loader-bg").show();
        },
        success : function(res){
            if(res.error){
                 addProductCartOrWishlist('fa-times','error',res.error);
            }else{
                $("#like"+timeline_id).html(addLike);
                $("#likable"+timeline_id).find('i').addClass('liked');
            $("#likable"+timeline_id).removeClass('like-post').addClass('unlike-post');
            //playAudio();
            addProductCartOrWishlist('fa-check','success',res.success);
            }

        },
        complete : function(){
            //$(".loader-bg").hide();
        },
        error : function(jqXHR,exception){
            var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else if(jqXHR.status == 401){
            msg = 'You are logged out,Please login';
        }else{
            msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }

        addProductCartOrWishlist('fa-check','danger',msg);
        location.reload();
        }
    });
});


$(document).on('click','.unlike-post',function(){
    var timeline_id = $(this).attr('data-id');
    var Data = 'timeline_id='+timeline_id;

    var likeCount = $("#like"+timeline_id).html();
    var removeLike = parseInt(likeCount) - 1;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url : '{{url("connect/unLikePost")}}',
        type : 'POST',
        data : Data,
        beforeSend : function(){
            //$(".loader-bg").show();
        },
        success : function(res){
            if(res.error){
                 addProductCartOrWishlist('fa-times','error',res.error);
            }else{
                $("#like"+timeline_id).html(removeLike);
                $("#likable"+timeline_id).find('i').removeClass('liked');
            $("#likable"+timeline_id).removeClass('unlike-post').addClass('like-post');
                 addProductCartOrWishlist('fa-check','success',res.success);
            }

        },
        complete : function(){
            //$(".loader-bg").hide();
        }
    });
});

$(document).on('click','.delete-card',function(){
    var id = $("#postdelId").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post('{{url("connect/deletePost")}}',{timeline_id: id},function(res){
        if(res.success){
            $("#timeline"+id).remove();
            //playAudio();
            addProductCartOrWishlist('fa-check','success',res.success);
        }else{
            addProductCartOrWishlist('fa-times','error',res.error);
        }
    });
});

$(document).on('click','.submitComment',function(){
    var id = $(this).attr('data-id');
    var Data = $("#AddComment"+id).serializeArray();
    Data.push({'name' : 'timeline_id','value': id});

    var comment = $("#AddComment"+id+" textarea").val();
    if(comment == ""){
        addProductCartOrWishlist('fa-times','error',"Please fill the comment.");
        $("#AddComment"+id+" textarea").focus();
        return false;
    }


    var commentCount = $("#commentCount"+id).html();
    var totalCount = parseInt(commentCount) + 1;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url : '{{url("connect/addComment")}}',
        type : 'POST',
        data : Data,
        beforeSend : function(){
            //$(".loader-bg").show();
        },
        success : function(res){
            if(res.error){
                 addProductCartOrWishlist('fa-times','error',res.error);
            }else{
                addProductCartOrWishlist('fa-check','success','Comment posted successfully.');
                //playAudio();
                if(commentCount == 0){
                    $("#showComments"+id).prepend(res);
                }else{
                    $("#showComments"+id).prepend(res);
                }
                $("#AddComment"+id)[0].reset();
                $(".commentCount"+id).html(totalCount);
                if(commentCount == 0){
                $("#comments-div"+id).removeClass('hide');
                }
            }

        },
        complete : function(){
            //$(".loader-bg").hide();
        }
    });
});


$(document).on('click','#commentUpdate',function(){
    var Data = $("#UpdateComment").serializeArray();
    var tid = $("#tid").val();
    var cid = $("#cid").val();
    $.post('{{url("connect/UpdateComment")}}',Data,function(res){
        if(res.error){
            addProductCartOrWishlist('fa-times','error',res.error);
            $("#comment"+cid).show();
        }else{
            $("#editComment-Modal").modal('hide');
        addProductCartOrWishlist('fa-check','success','Comment updated successfully.');
            $("#comment"+cid).remove();
            $("#UpdateComment")[0].reset();
            $("#showComments"+tid).prepend(res);
            //playAudio();

        }
    });
});


$(document).on('click','.delete-comment',function(){
    var id = $("#commentdelId").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post('{{url("connect/deleteComment")}}',{comment_id: id},function(res){
        if(res.success){
            $("#comment"+id).remove();
            //playAudio();
            addProductCartOrWishlist('fa-check','success',res.success);
        }else{
            addProductCartOrWishlist('fa-times','error',res.error);
        }
    });
});


$(document).on('click','.like-comment',function(){
    var comment_id = $(this).attr('data-id');
    var timeline_id = $(this).attr('data-timelineid');
    var Data = 'comment_id='+comment_id+'&timeline_id='+timeline_id;

    var likeCount = $("#commentlike"+comment_id).html();
    var addLike = parseInt(likeCount) + 1;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url : '{{url("connect/addCommentLike")}}',
        type : 'POST',
        data : Data,
        beforeSend : function(){
            //$(".loader-bg").show();
        },
        success : function(res){
            if(res.error){
                 addProductCartOrWishlist('fa-times','error',res.error);
            }else{
                $("#commentlike"+comment_id).html(addLike);
                $("#commentlikable"+comment_id).find('i').addClass('liked');
            $("#commentlikable"+comment_id).removeClass('like-comment').addClass('unlike-comment');
            //playAudio();
            addProductCartOrWishlist('fa-check','success',res.success);
            }

        },
        complete : function(){
            //$(".loader-bg").hide();
        }
    });
});


$(document).on('click','.unlike-comment',function(){
    var comment_id = $(this).attr('data-id');
    var timeline_id = $(this).attr('data-timelineid');
    var Data = 'comment_id='+comment_id+'&timeline_id='+timeline_id;

    var likeCount = $("#commentlike"+comment_id).html();
    var removeLike = parseInt(likeCount) - 1;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url : '{{url("connect/unLikeComment")}}',
        type : 'POST',
        data : Data,
        beforeSend : function(){
            //$(".loader-bg").show();
        },
        success : function(res){
            if(res.error){
                 addProductCartOrWishlist('fa-times','error',res.error);
            }else{
                $("#commentlike"+comment_id).html(removeLike);
                $("#commentlikable"+comment_id).find('i').removeClass('liked');
            $("#commentlikable"+comment_id).removeClass('unlike-comment').addClass('like-comment');
                 addProductCartOrWishlist('fa-check','success',res.success);
            }

        },
        complete : function(){
            //$(".loader-bg").hide();
        }
    });
});

$(document).on('click','#savePrivacy',function(){
    var Data = $("#post-privacy").serializeArray();
    var tid = $("#postId").val();
    var radioValue = $("input[name='privacy']:checked"). val();
    $.post('{{url("connect/savePrivacy")}}',Data,function(res){
        if(res.error){
        addProductCartOrWishlist('fa-times','success',res.error);
        }else{
        addProductCartOrWishlist('fa-check','success',res.success);
        $("#myModal").modal("hide");
        $("#privacy-drop"+tid).attr('data-privacy',radioValue);
        //playAudio();
        }
    })
});




$(document).on('click','#showMore',function(){
    var x = 4;
   // var media = $("#commentsPopupBox > div.media").length;
    var hidden = $("#commentsPopupBox > div.media.hide").length;
    //alert(hidden);
    if(x < hidden){
        x = 4;
    }else{
        x = hidden;
    }

    $("#commentsPopupBox > div.media.hide:lt("+x+")").removeClass('hide');

});


});





/*
$(window).scroll(function() {
if (  document.documentElement.clientHeight +
$(document).scrollTop() >= document.body.offsetHeight )
{
    alert("You're at the bottom of the page.");
    var id = $("input.lastId").last().val();
    $.get('url("connect/getData")}}/'+id,function(res){
        $("#target").append(res);
    });
}
});

$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() > $(document).height() - 8) {
    $("#pre-loader").show();
       var id = $("input.lastId").last().val();
       //if(id != 0){
       // alert(id);
        //$("input.lastId").last().removeClass('lastId');
    $.get('{{url("connect/getData")}}/'+id,function(res){
        //$("input.lastId").last().val(0);
        $("#pre-loader").hide();
        $("#target").append(res);
        //setTimeout(function(){ loadImagePlugin(); },2000);
    });
    //}
   }
});


/*
window.onscroll = function(ev) {
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
        alert('bottom');
    }
};
*/
/*
var size_li = 0;
$(document).on('click','.show-more',function () {
    var id = $(this).attr('data-id');
    size_li = $("#photo-library"+id+" a.hide").length;
        alert(size_li);
        x=2;
        x= (x+2 <= size_li) ? x+2 : size_li;
        alert(x);
       $('#photo-library'+id+' a:lt('+x+')').removeClass('hide');


});
*/

function addProductCartOrWishlist(icon,status,msg){
        $.notify({
            icon: 'fa '+icon,
            title: status+'!',
            message: msg
        },{
            element: 'body',
            position: null,
            type: "info",
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


function imagePopup(id){
    setTimeout(function(){
        //loadPlugin();
    var len = $(".gg-container:nth-child(1) > #gg-screen").length;
    if(len > 0){
        $(".gg-container:nth-child(1) > #gg-screen").slice(1).remove();
    }
    $(".lazy").slice(0, 4).show();
    AddReadMore();
    },1000);
}

</script>

<script>
var audio = document.getElementById("myAudio");

function playAudio() {
    audio.play();
}

function pauseAudio() {
    audio.pause();
}

/*
$(function () {
        function checkPendingRequest() {
            if ($.active > 0) {
                //window.setTimeout(checkPendingRequest, 1000);
                $("#post-new-static").html('ajax requests');
            }
            else {
                console.log('No ajax requests in browser');
                //alert("No hay peticiones pendientes");

                $("#post-new-static").html('No ajax requests');
            }
        };

        window.setInterval(checkPendingRequest, 5000);
 });
 */

 $(function () {

    $(document).on('click',"#loadMores",function (e) {
        e.preventDefault();
        //alert($(".lazy:hidden").length);
        $(".lazy:hidden").slice(0, 4).slideDown();
        if ($(".lazy:hidden").length == 0) {
            $("#loadMores").fadeOut('slow');
        }
      /*  $('#lazy-container').animate({
            scrollTop: $('#lazy-container').get(0).scrollHeight
        }, 1500); */
    });
});

$(document).on('click','#top',function () {
    $('.gg-image-right').animate({
        scrollTop: 0
    }, 600);
    return false;
});
/*
$(window).scroll(function () {
    if ($(this).scrollTop() > 50) {
        $('.totop a').fadeIn();
    } else {

        $('.totop a').fadeOut();
    }
});
*/

$(window).scroll(function () {
    if ($(this).scrollTop() > 600) {
        $("#scrollToTop").fadeIn('slow');
    }else{
        $("#scrollToTop").fadeOut('slow');
    }
});

$(document).on('click','#scrollToTop',function(){
    $("html, body").animate({
        scrollTop: 0
    }, "slow");
    return false;
});

function AddReadMore() {
        //This limit you can set after how much characters you want to show Read More.
        var carLmt = 200;
        // Text to show when text is collapsed
        var readMoreTxt = " ... Read More";
        // Text to show when text is expanded
        var readLessTxt = " Read Less";


        //Traverse all selectors with this class and manupulate HTML part to show Read More
        $(".addReadMore").each(function() {
            if ($(this).find(".firstSec").length)
                return;

            var allstr = $(this).text();
            if (allstr.length > carLmt) {
                var firstSet = allstr.substring(0, carLmt);
                var secdHalf = allstr.substring(carLmt, allstr.length);
                var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
                $(this).html(strtoadd);
            }

        });
        //Read More and Read Less Click Event binding
        $(document).on("click", ".readMore", function() {
            //alert('clicked')
            $(this).closest(".addReadMore").removeClass("showlesscontent").addClass('showmorecontent');
        });

        $(document).on("click", ".readLess", function() {
            //alert('clicked')
            $(this).closest(".addReadMore").removeClass("showmorecontent").addClass('showlesscontent');
        });
    }
</script>

@endsection
