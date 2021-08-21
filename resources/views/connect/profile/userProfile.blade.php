@extends('layouts.connect')
@section('title','user Profile')
@section('content')
@php 

if($user->picture == 'undefined'){
	$a = $user->first_name;
    $firstChar = mb_substr($a, 0, 1, "UTF-8");
	$picture = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.strtoupper($firstChar);
}else if(empty($user->picture)){
	$a = $user->first_name;
    $firstChar = mb_substr($a, 0, 1, "UTF-8");
	$picture = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.strtoupper($firstChar);
}else{
	$picture = $user->picture;
}


$myrequest = App\Models\Friendrequest::where('user_id',Auth::user()->id)->where('friend_id',$user->id)->count();
$otherrequest = App\Models\Friendrequest::where('user_id',$user->id)->where('friend_id',Auth::user()->id)->count()
@endphp
<div class="page-body m-t-15 m-r-40">
<div class="row users-card">
<div class="col-lg-3 col-xl-3 col-md-6">
<div class="rounded-card user-card">
<div class="card">
<div class="img-hover">
<img class="img-fluid img-radius" src="{{ $picture }}" alt="round-img">

<div class="img-overlay img-radius">
    <span>
      @if($user->friends('user_id',Auth::user()->id)->count() == 0)
        @if($myrequest == 1)
          <button class="btn btn-sm btn-primary cancelRequest" data-toggle="tooltip" data-placement="top" title="Request sent" id="friend{{$user->id}}" data-id="{{$user->id}}"><i class="fa fa-user-times"></i></button>
          @endif
        @if($otherrequest == 1)
          <button class="btn btn-sm btn-primary acceptRequest" data-toggle="tooltip" data-placement="top" title="Accept request" id="friend{{$user->id}}" data-id="{{$user->id}}"><i class="fa fa-user-plus"></i></button>

        @endif
        
        @if($myrequest == 0 && $otherrequest == 0)
      <button class="btn btn-sm btn-primary friendRequest" data-toggle="tooltip" data-placement="top" title="Add friend" id="friend{{$user->id}}" data-id="{{$user->id}}"><i class="fa fa-user-plus"></i></button>
      @endif
        
      @else
        <button class="btn btn-sm btn-primary unfriend" data-toggle="tooltip" data-placement="top" title="Unfriend" id="friend{{$user->id}}" data-id="{{$user->id}}" ><i class="fa fa-user-times"></i></button>
      @endif
    </span>
</div>

</div>
<div class="user-content">
<h4 class=""> {{ ucfirst($user->first_name) }} {{ ucfirst($user->last_name) }}</h4>
<p class="m-b-0 text-muted m-b-10">{{ $user->hasRole('Knitter') ? 'Knitter' : 'Designer' }}</p>
</div>

</div>
</div>
</div>

<div class="col-lg-9 col-xl-9 col-md-6">
<div class="card">
<!-- Nav tabs -->
<ul class="nav nav-tabs md-tabs" role="tablist">
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#feed" role="tab" aria-selected="false">Studio</a>
<div class="slide"></div>
</li>
<li class="nav-item">
<a class="nav-link active show" data-toggle="tab" href="#about" role="tab" aria-selected="false">About</a>
<div class="slide"></div>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#profile3" role="tab" aria-selected="false">Skill set</a>
<div class="slide"></div>
</li>
<li class="nav-item">
<a class="nav-link " data-toggle="tab" href="#interest" role="tab" aria-selected="false">Interests</a>
<div class="slide"></div>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#settings3" role="tab" aria-selected="true">Contact details</a>
<div class="slide"></div>
</li>

</ul>
<!-- Tab panes -->
<div class="tab-content card-block">

<div class="tab-pane" id="feed" role="tabpanel">

<div class="p-relative" id="containers">
<!-- public -->
@if($timeline_public->count() > 0) 
  @foreach($timeline_public as $time)
    @php
    $images = $time->images;
    @endphp
    @if($images->count() > 0)
    <p class="text-center" style="font-weight: bold;">{{Timezone::convertToLocal($time->created_at, 'M d,Y H:i A')}}</p>
      @component('connect.profile.images',['images' => $images,'time_id' => $time->id])
      @endcomponent
    @endif
  @endforeach
@endif

<!-- friends -->
@if($friends != 0)

@if($timeline_friends->count() > 0) 
  @foreach($timeline_friends as $time)
    @php
    $images = $time->images;
    @endphp
    @if($images->count() > 0)
    <p class="text-center" style="font-weight: bold;">{{Timezone::convertToLocal($time->created_at, 'M d,Y H:i A')}}</p>
      @component('connect.profile.images',['images' => $images,'time_id' => $time->id])
      @endcomponent
    @endif
  @endforeach
@endif

@endif

<!-- followers -->
@if($follow != 0)

@if($timeline_followers->count() > 0) 
  @foreach($timeline_followers as $time)
    @php
    $images = $time->images;
    @endphp
    @if($images->count() > 0)
    <p class="text-center" style="font-weight: bold;">{{Timezone::convertToLocal($time->created_at, 'M d,Y H:i A')}}</p>
      @component('connect.profile.images',['images' => $images,'time_id' => $time->id])
      @endcomponent
    @endif
  @endforeach
@endif

@endif

<p id="nothingToShow" class="text-center">No images to show.</p>
</div>


</div>


<div class="tab-pane active show" id="about" role="tabpanel">
<div class="m-0" id="view-about">
<p class="f-14 m-t-5" id="aboutmeContent">
    {{ $user->profile->aboutme ? $user->profile->aboutme : 'No about to show.' }}
</p>
</div>

</div>
<div class="tab-pane" id="profile3" role="tabpanel">
<div class="row">
<div class="col-lg-12 col-xl-12">
<!--New Accordion-->

<div class="collapse show" id="skills">
<div class="list-group-item">
<div class="view-info2">
<div class="row">
<div class="col-lg-12">
<div class="general-info">
<div class="row">
<div class="col-lg-12 col-xl-12" id="skillSet">
  

@if($user->skills->count() > 0)
<?php 
$arr = array('','Beginner','Advanced beginner','Novice','Proficient','Expert');
?>
 <ul class="skills-list">
@foreach ($user->skills as $skill)
        <li>
            <img class="checked-img" src="{{ asset('resources/assets/files/assets/icon/custom/'.$skill->skills.'.png') }}" />
            <div class="text-center">{{$skill->skills}} </div>
            @for ($j = 1; $j <= $skill->rating; $j++)
            <i class="fa fa-star" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$arr[$j]}}"></i>
            @endfor

            @while ($j <= 5)
                <i class="fa fa-star-o" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$arr[$j]}}"></i>
                <?php $j++; ?>
            @endwhile
        </li>
    @endforeach
 </ul>
@else
<p>No skills to show.</p>
@endif
            <p></p>
            <hr>
            <h5 class="m-l-30 m-b-20">As a knitter I am </h5>
            <div class="form-radio m-l-30">
                @if($user->profile->as_a_knitter_i_am)
                <ul>
                    <li><i class="fa fa-check m-r-10"></i>{{$user->profile->as_a_knitter_i_am}}</li>
                </ul>
                @else
                <p>Nothing to display.</p>
                @endif
                </div>
                <p></p>
  

</div>
</div>

    </div>
</div>
<!-- end of table col-lg-6 -->
</div>
<!-- end of row -->
</div>
<!-- end of general info -->
</div>
<!-- end of col-lg-12 -->

<!-- end of row -->

</div>


<!--New Accordion-->
</div>
</div>
</div>

<div class="tab-pane " id="interest" role="tabpanel">
<div id="view-interest">

<h5 class="m-l-30 m-b-20 m-t-10">I knit for </h5>
<div class="m-l-30">
	@if($user->profile->i_knit_for)
<ul>
<?php 
$i_knit_for = explode(',', $user->profile->i_knit_for);
?>
@for($i=0;$i<count($i_knit_for);$i++)
<li style="display: list-item;color: #0d665b;"><i class="fa fa-check m-r-10"></i>{{$i_knit_for[$i]}}</li>
@endfor
</ul>
@else
<p>Nothing to display.</p>
@endif
</div>
<br>
<h5 class="m-l-30 m-b-20">I am here for </h5>
<div class="m-l-30">
	@if($user->profile->i_am_here_for)
<ul>
<?php 
$i_am_here_for = explode(',',$user->profile->i_am_here_for);
?>
@for($j=0;$j<count($i_am_here_for);$j++)
    <li style="display: list-item;color: #0d665b;"><i class="fa fa-check m-r-10"></i> {{$i_am_here_for[$j]}}</li>
@endfor
</ul>
@else
<p>Nothing to display.</p>
@endif
</div>

</div>   

</div>
<div class="tab-pane" id="settings3" role="tabpanel">
<!--profile cover end-->
<div class="row">
<div class="col-lg-12">
<div class="list-group panel">
<!--New Accordion-->

<div class="collapse show">
<div class="list-group-item">
<div class="col-lg-12 Profession">
<div class="view-info">
<div class="row">
<div class="col-lg-12">
<div class="general-info" id="view-details">

<div class="row">
<div class="col-lg-12 col-xl-6">
        <div class="table-responsive">
            <table class="table m-0">
                <tbody>
                    <tr>
                        <th scope="row">First name</th>
                        <td>{{$user->first_name}}</td>
                        <!-- <td><i class="fa fa-eye"></i></td> -->
                    </tr>
                  
                    <tr>
                        <th scope="row">Contact number</th>
                        <td>
                        	@component('connect.profile.mobile_privacy',['user' => $user]) @endcomponent
                        </td>
                        <!-- <td><i class="fa fa-eye-slash"></i></td> -->
                    </tr>
                    <tr>
                        <th scope="row">Postal address</th>
                        <td>@component('connect.profile.address_privacy',['user' => $user]) @endcomponent</td>
                        <!-- <td><i class="fa fa-eye-slash"></i></td> -->
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- end of table col-lg-6 -->
    <div class="col-lg-12 col-xl-6">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th scope="row">Last name</th>
                        <td>{{$user->last_name ? $user->last_name : '' }}</td>
                        <!-- <td><i class="fa fa-eye-slash"></i></td> -->
                    </tr>
                    <tr>
                        <th scope="row">E-mail</th>
                        <td>@component('connect.profile.email_privacy',['user' => $user]) @endcomponent</td>
                        <!-- <td><i class="fa fa-eye-slash"></i></td> -->
                    </tr>
                    <tr>
                        <th scope="row">Website</th>
                        <td><a target="_blank" href="{{$user->profile->website}}">{{$user->profile->website ? $user->profile->website : '' }}</a></td>
                    </tr>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>


<!-- end of general info -->
</div>
<!-- end of col-lg-12 -->
</div>
<!-- end of row -->
</div>
<!-- end of view-info -->

</div>
</div>
</div>

</div>

</div>
</div>
<!-- Page-body end -->
</div>

</div>
</div>
</div>
</div>                                       
</div>


<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
          <div class="modal-header">
              <!-- <h4 class="modal-title">Modal Header</h4> -->
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
        <div class="modal-body text-center m-t-15">
          <img src="{{ asset('resources/assets/files/assets/images/check.gif') }}" style="width: 80px;" class="img-fluid m-b-10" alt="">
          <p id="popupMessage"></p>
        </div>
      </div>
    </div>
 </div>



@endsection
@section('footerscript')
<style>
	.hide{
		display: none;
	}
	.fa-star{
       color: #0d665c !important
    }
  #view-about-btn{position: absolute;
    float: right;
    right: 0px;
    bottom: 0px;}
ul {
  list-style-type: none;
}

li {
  display: inline-block;
}

input[type="checkbox"][id^="cb"] {
  display: none;
}

.checked-edit-list label {
  border: 1px solid #fff;
  padding: 10px;
  display: block;
  position: relative;
  margin: 10px;
  cursor: pointer;
  text-align: center;
}

.checked-edit-list label:before {
  background-color: white;
  color: white;
  content: " ";
  display: block;
  border-radius: 50%;
  border: 1px solid transparent;
  position: absolute;
  top: -5px;
  left: -5px;
  width: 25px;
  height: 25px;
  text-align: center;
  line-height: 28px;
  transition-duration: 0.4s;
  transform: scale(0);
}

.checked-edit-list label img {
  height: 100px;
  width: 100px;
  transition-duration: 0.2s;
  transform-origin: 50% 50%;
  filter:grayscale(100%);
}
/* :checked + label {
  border-color: #ddd;
} */

:checked + label:before {
  content: "✓";
  background-color:transparent;;
  transform: scale(1);
}
.list-group-item{
background-color: transparent;
    border: unset;}

:checked + label img {
  transform: scale(0.9);
  box-shadow: 0 0 5px #333;
  z-index: -1;
  filter: grayscale(0%);
}
#edit-btn, #edit-btn1 {
    background-color: transparent;
    border: 1px solid transparent;
}
.nav-tabs .slide {
    background: #0d665c;
}
.btn-sm {
    /* padding: 0px 0px; */
    line-height: 10px;
    font-size: 11px;
}
.ekko-lightbox-nav-overlay a span{color: #0d665c;}
/* #edit-btn,#edit-btn1{position: absolute;top: 9px;right: 55px;z-index: 999;} */
.fa-pencil{padding:4px 6px;color: #0d665b;font-size: 16px;background-color: transparent;}
.fa-gear{color: #0d665b;cursor: pointer;}
.icofont-close{font-size: 16px!important;padding-top: 10px!important;right: 55px!important;}
#first-card .list-group-item,#second-card .list-group-item{border-bottom:1px solid #0d665b!important;}
.btn:focus, .btn.focus {
    outline: 0;
    box-shadow: none;
}
button, html [type="button"], [type="reset"], [type="submit"]{background-color: transparent;}
#privacy{border: 1px solid #0d665b;padding: 0px;border-radius: 2px;color: #0d665b;}

    #post-new-static{position: fixed;bottom: 10px;right: 6px;z-index: 9999999;}
    .options{color: #222222;border: .5px solid #78909c;border-radius: 2px;margin-left: 28px;float: left;left: 0;position: absolute;font-size: 14px;padding: 1px 2px 2px 2px;}
    #post-buttons{position: absolute!important;top: 186px;margin-left: 58px;margin-top: 8px;}
        .upload{margin-left: 53px;}
        .post-new-footer i{margin-left: 20px;}
        .jFiler-items{margin-top: 20px;}
        .image-upload img{width: 100%;}
        .input-group-append .input-group-text, .input-group-prepend .input-group-text{background-color: #faf9f8;color: #0d665c;}
        .nav-tabs .nav-item {margin-bottom: 0px;}
        #nothingToShow{ display: none; }
</style>
<script type="text/javascript">
	var CLOSE = '{{asset('resources/assets/marketplace/images/close.png')}}';
</script>


<script type="text/javascript" src="{{asset('resources/assets/files/bower_components/jquery-bar-rating/js/jquery.barrating.js') }}"></script>
<script type="text/javascript" src="{{asset('resources/assets/rating/stars.min.js')}}"></script>

<link rel="stylesheet" href="{{ asset('resources/assets/marketplace/js/grid-gallery.css') }}">
<script src="{{ asset('resources/assets/marketplace/js/grid-gallery-profile.js') }}"></script>

<script src="{{asset('resources/assets/infinite-scroll.pkgd.min.js')}}"></script>

<script type="text/javascript">

	$(document).ready(function() {

        $(".imageContent").each(function(){
        if($(this).children().length == 0){
          $(this).remove();
        }
    });

if($("#containers > .gg-container").length == 0){
    $("#nothingToShow").show();
}

/*

    var $container = $("#containers");
  $container.infiniteScroll({
    //path: '.pagination__next',
      path: function() {
         // alert(this.loadCount);
         if(this.loadCount <= ''){
            var pageNumber = ( this.loadCount + 2 ) * 1;
            return '{{url()->current()}}?page='+pageNumber;
         }

        //return '/articles/P' + pageNumber;
      },
      append: '.imageContent',
      history: false,
      status: '.page-load-status',
      scrollThreshold: 100,
      hideNav: '.pagination',
  });
*/

    $('[data-toggle="tooltip"]').tooltip();




$(document).on('click','.friendRequest',function(){
  var id = $(this).attr('data-id');

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


  $.ajax({
    url : '{{url("connect/sendFriendRequest")}}',
    type : 'POST',
    data : 'friend_id='+id,
    beforeSend : function(){
      $(".loader-bg").show();
      $("#friend"+id).find('i').removeClass('fa-user-plus').addClass('fa-spinner fa-spin');
    },
    success : function(res){
      if(res.success){
        $('#myModal').modal('toggle');
        $("#popupMessage").html('Request has been successfully sent!');
        setTimeout(function(){ $('#myModal').modal('toggle'); },2000);
    $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-times');
    $("#friend"+id).attr('data-original-title','Request Sent');
    $("#friend"+id).removeClass('friendRequest').addClass('cancelRequest');
        //addProductCartOrWishlist('fa fa-check','success',res.success);
        
      }else{
        $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-plus');
        addProductCartOrWishlist('fa fa-times','error',res.error);
      }
    },
    complete : function(){
      $(".loader-bg").hide();
    }
  });
});



$(document).on('click','.cancelRequest',function(){
  var id = $(this).attr('data-id');

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

Swal.fire({
  title: '',
  text: "Are you sure want to remove this friend request ?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Remove'
}).then((result) => {
  if (result.value) {

  $.ajax({
    url : '{{url("connect/cancelFriendRequest")}}',
    type : 'POST',
    data : 'friend_id='+id,
    beforeSend : function(){
      $(".loader-bg").show();
      $("#friend"+id).find('i').removeClass('fa-user-times').addClass('fa-spinner fa-spin');
    },
    success : function(res){
      if(res.success){
        $('#myModal').modal('toggle');
        $("#popupMessage").html('Request has been cancled!');
        setTimeout(function(){ $('#myModal').modal('toggle'); },2000);


        $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-plus');
    $("#friend"+id).attr('data-original-title','Add Friend');
    $("#friend"+id).removeClass('cancelRequest').addClass('friendRequest');
        //addProductCartOrWishlist('fa fa-check','success',res.success);
      }else{
        $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-times');
        addProductCartOrWishlist('fa fa-times','error',res.error);
      }
    },
    complete : function(){
      $(".loader-bg").hide();
    }
  });
}

});
});




$(document).on('click','.unfriend',function(){
  var id = $(this).attr('data-id');

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


Swal.fire({
  title: '',
  text: "Are you sure want to remove this user from friend list ?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Remove'
}).then((result) => {
  if (result.value) {
    
    $.ajax({
    url : '{{url("connect/removeFriend")}}',
    type : 'POST',
    data : 'friend_id='+id,
    beforeSend : function(){
      $(".loader-bg").show();
      $("#friend"+id).find('i').removeClass('fa-user-times').addClass('fa-spinner fa-spin');
    },
    success : function(res){
      if(res.success){
        $('#myModal').modal('toggle');
        $("#popupMessage").html('You have successfully unfriend the user!');
        setTimeout(function(){ $('#myModal').modal('toggle'); },2000);
        $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-plus');
    $("#friend"+id).attr('data-original-title','Add Friend');
    $("#friend"+id).removeClass('unfriend').addClass('friendRequest');
        //addProductCartOrWishlist('fa fa-check','success',res.success);
      }else{
        $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user');
        addProductCartOrWishlist('fa fa-times','error',res.error);
      }
    },
    complete : function(){
      $(".loader-bg").hide();
    }
  });


  }
});
});


$(document).on('click','.acceptRequest',function(){
  var id = $(this).attr('data-id');

  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


  $.ajax({
    url : '{{url("connect/acceptRequest")}}',
    type : 'POST',
    data : 'friend_id='+id,
    beforeSend : function(){
      $(".loader-bg").show();
      $("#friend"+id).find('i').removeClass('fa-user-plus').addClass('fa-spinner fa-spin');
    },
    success : function(res){
      if(res.success){
        $('#myModal').modal('toggle');
        $("#popupMessage").html('Friend request has been accepted!');
        setTimeout(function(){ $('#myModal').modal('toggle'); },2000);

        $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user');
    $("#friend"+id).attr('data-original-title','Unfriend');
    $("#friend"+id).removeClass('acceptRequest').addClass('unfriend');
        //addProductCartOrWishlist('fa fa-check','success',res.success);
      }else{
        $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-plus');
        addProductCartOrWishlist('fa fa-times','error',res.error);
      }
    },
    complete : function(){
      $(".loader-bg").hide();
    }
  });

});
        });

function openPopup(){
  setTimeout(function(){  
        //loadPlugin();
    var len = $(".gg-container > #gg-screen").length;
    //alert(len);
    if(len > 0){
        $(".gg-container > #gg-screen").slice(1).remove();
    }
    $(".lazy").slice(0, 4).show();
    AddReadMore();
    },1000);
}

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
</script>
@endsection