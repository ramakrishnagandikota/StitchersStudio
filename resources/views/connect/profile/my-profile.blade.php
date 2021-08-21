@extends('layouts.connect')
@section('title','My Profile')
@section('content')
@php 
if(Auth::user()->picture){
  $picture = Auth::user()->picture;
}else{
  $a = Auth::user()->first_name;
    $firstChar = mb_substr($a, 0, 1, "UTF-8");
  $picture = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.strtoupper($firstChar);
}
@endphp

<a href="javascript:;" style="
width: auto;
position: fixed;
right: 7px;
bottom: 64px;
z-index: 1;background: rgb(13, 102, 92) !important;padding: 5px;display: none;" id="scrollToTop"><i class="fa fa-chevron-up fa-2x" style="color:#fff;" aria-hidden="true"></i></a>


<!-- Page-body start -->
<div class="page-body m-t-15 m-r-40">
<div class="row users-card">
<div class="col-lg-3 col-xl-3 col-md-6">
<div class="rounded-card user-card">
<div class="card">
<div class="img-hover">

<img class="img-fluid img-radius" id="profile-img-left" src="{{$picture}}" alt="round-img"> 
<div class="img-overlay img-radius">
    <span class="profile-upload-left">
        <label for="profile-upload-left">
            <a class="btn btn-sm btn-primary upload-img-icon"><i class="fa fa-pencil"></i></a>
            </label>
    <input id="profile-upload-left" type="file" onchange="addPackage();" >
        </span>
</div>

</div>
<div class="user-content">
<h4 class=""> {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
<p class="m-b-0 text-muted m-b-10">Knitter</p>
</div>
</div>
</div>
</div>

<div class="col-lg-9 col-xl-9 col-md-6">
<div class="card">
<!-- Nav tabs -->
<ul class="nav nav-tabs md-tabs" role="tablist">
<li class="nav-item">
<a class="nav-link  active show" data-toggle="tab" href="#feed" role="tab" aria-selected="false">Studio</a>
<div class="slide"></div>
</li>
<li class="nav-item">
<a class="nav-link" data-toggle="tab" href="#about" role="tab" aria-selected="false">About</a>
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

<div class="tab-pane active show" id="feed" role="tabpanel">
<div class="p-relative" id="containers">

@if($timeline->count() > 0)
    @foreach($timeline as $time)

      <div class="content imageContent item" id="imageContent">
        @php 
          $timeline_images = App\Models\TimelineImages::where('timeline_id',$time->id)->get();
        @endphp
        @if($timeline_images->count() > 0)
        <p class="text-center" style="font-weight: bold;">{{Timezone::convertToLocal($time->created_at, 'M d,Y H:i A')}}</p>
          @component('connect.profile.images',['images' => $timeline_images,'time_id' => $time->id])

          @endcomponent
        @endif
      </div>
    @endforeach
@else
<div class="text-center">
<p>No images to show in studio.</p>
</div>
@endif
</div>
@if($timeline->count() > 0)
<div class="text-center">
<a href="javascript:;" class="load-more" style="color: #0d665b;">Load More</a>
</div>
@endif
</div>


<div class="tab-pane " id="about" role="tabpanel">
<div class="m-0" id="view-about">

<p class="f-14 m-t-5" id="aboutmeContent">
    @if(Auth::user()->profile)
		@if(Auth::user()->profile->aboutme)
		{{Auth::user()->profile->aboutme}}
		@else
		<a href="javascript:;" style="text-decoration:underline;" class="view-about-btn">Tell me about yourself.</a>
		@endif
    @endif
</p>

<button  type="button" class="btn btn-sm waves-effect waves-light view-about-btn pull-right">
<i class="fa fa-pencil"></i>
</button>

</div>

<div class="m-0" id="edit-about">
<p class="text-right">
<button id="" type="button" class="btn btn-sm waves-effect waves-light edit-about-btn">
<i class="icofont icofont-close"></i>
</button>
</p>
<form id="aboutme">
    <p><textarea name="aboutme" id="abtme" rows="4" cols="1" style="width: 100%;">
        @if(Auth::user()->profile){{Auth::user()->profile->aboutme}}@endif</textarea></p>
</form>

<div class="text-center">
<a href="javascript:;" id="saveAbout" class="btn btn-primary waves-effect waves-light theme-btn">Save</a>
<a href="javascript:;" id="" class="btn btn-default waves-effect edit-about-btn">Cancel</a>
</div>

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

<!-- end of view-info --
<div class="edit-info2 hide">
<div class="row">
<div class="col-lg-12">


<!-- end of row --
</div>
<!-- end of edit-info --
</div>
<!-- end of card-block --
</div>
-->
</div>


<!--New Accordion-->
</div>
</div>
</div>

<div class="tab-pane " id="interest" role="tabpanel">
<div id="view-interest">



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

<!-- end of row -->
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
                <div class="group-add-on">
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
            </div>
                </div>  
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
          </div>
        </div>
</div>




@endsection
@section('footerscript')
<style>
  .item{
    *display:none;
}
    #view-about-btn{position: absolute;
    float: right;
    right: -6px;
    top: 39px;}
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
:checked + label {
  border-color: #ddd;
}

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
    padding: 0px 0px;
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

    .hide{
      display: none;
    }
    .red{
      color: #bc7c8f;
    font-weight: bold;
    font-size: 12px;
    }
.options{color: #222222;border: .5px solid #78909c;border-radius: 2px;margin-left: 28px;float: left;left: 0;position: absolute;font-size: 14px;padding: 1px 2px 2px 2px;}
    .upload{margin-left: 53px;}
        .post-new-footer i{margin-left: 20px;}
        .jFiler-items{margin-top: 20px;}
        .image-upload img{width: 100%;}
        .input-group-append .input-group-text, .input-group-prepend .input-group-text{background-color: #faf9f8;color: #0d665c;}
        .upload-img-icon:hover i{background-color: #0d665c;color: white;transition-delay: .250s;}
        .nav-tabs .nav-item {margin-bottom: 0px;}
		
.br-theme-fontawesome-stars .br-widget a.disabled {
  pointer-events: none;
  cursor: default;
}
.br-theme-fontawesome-stars .br-widget a.disabled:after{
  color: #d2d2d2!important;
}
</style>

<script type="text/javascript">
  var CLOSE = '{{asset('resources/assets/marketplace/images/close.png')}}';
</script>
  <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/files/bower_components/jquery-bar-rating/css/fontawesome-stars.css') }}">
   <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/files/bower_components/jquery-bar-rating/css/bars-1to10.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/files/bower_components/jquery-bar-rating/css/bars-horizontal.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/files/bower_components/jquery-bar-rating/css/bars-movie.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/files/bower_components/jquery-bar-rating/css/bars-pill.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/files/bower_components/jquery-bar-rating/css/bars-reversed.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/files/bower_components/jquery-bar-rating/css/bars-square.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/files/bower_components/jquery-bar-rating/css/css-stars.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/files/bower_components/jquery-bar-rating/css/fontawesome-stars-o.css') }}">


 <!-- jquery file upload Frame work -->
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />

<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />

<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/ekko-lightbox/js/ekko-lightbox.js') }}"></script>

  <!-- jquery file upload js -->
    <script src="{{ asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/filer-modified/custom-filer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/filer-modified/jquery.fileuploads.init.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>

<link rel="stylesheet" href="{{ asset('resources/assets/marketplace/js/grid-gallery.css') }}">
<script src="{{ asset('resources/assets/marketplace/js/grid-gallery-profile.js') }}"></script>

<script src="{{asset('resources/assets/infinite-scroll.pkgd.min.js')}}"></script>

<script type="text/javascript">
$(document).ready(function() {

setTimeout(function(){ $(".item").slice(0, 10).show(); },1000);


$(document).on('click', '.load-more', function (e) {
  e.preventDefault();
    $(".item:hidden").slice(0, 10).slideDown();
  if ($(".item:hidden").length == 0) {
    $(".load-more").css('visibility', 'hidden');
  }
  /*  $('html,body').animate({
    scrollTop: $(this).offset().top
    }, 1000); */
});

    $(".imageContent").each(function(){
        if($(this).children().length == 0){
          $(this).remove();
        }
    });



    var $container = $("#containers");
  $container.infiniteScroll({
    //path: '.pagination__next',
      path: function() {
         // alert(this.loadCount);
         if(this.loadCount <= {{$timeline->lastPage()}}){
            var pageNumber = ( this.loadCount + 2 ) * 1;
            return '{{url("connect/myprofile?page=")}}'+pageNumber;
         }

        //return '/articles/P' + pageNumber;
      },
      append: '.imageContent',
      history: false,
      status: '.page-load-status',
      scrollThreshold: 100,
      hideNav: '.pagination',
  });

        });



 $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });



$(function(){

$("#edit-about").hide();
$(".view-about-btn").click(function(){
    $("#view-about").hide();
    $("#edit-about").show();
});

$(".edit-about-btn").click(function(){
    $("#view-about").show();
    $("#edit-about").hide();
});

    getSkillset();
    getInterest();
    getDetails();

    $(document).on('click','#saveAbout',function(){
        var Data = $("#aboutme").serializeArray();
        var aboutme = $("#abtme").val();
        $("#aboutmeContent").html(aboutme);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : '{{url("connect/addAboutme")}}',
            type : 'POST',
            data : Data,
            beforeSend : function(){
                $(".loader-bg").show();
            },
            success: function(res){
                if(res.success){
                    $("#edit-about").hide();
                    $("#view-about").show();
                    addProductCartOrWishlist('success','fa-check','Success',res.success);
                }else{
                    addProductCartOrWishlist('danger','fa-times','error',res.error);
                }
            },
            complete : function(){
                $(".loader-bg").hide();
            }
        });
 
    });


    $(document).on('click','.editSkillset',function(){
        $(".loader-bg").show();
        $.get('{{url("connect/editSkillset")}}',function(res){
            $("#skillSet").html(res);
            $(".loader-bg").hide();
			setTimeout(function(){ 
              $(".professional_skills").each(function(){
                var id = $(this).attr('data-id');
                var isChecked = $(this).prop('checked');
                if(isChecked == false){
                    $(".example-fontawesome"+id).find('div.br-widget').find('a').addClass('disabled');
                }
              });
          },1000);
        });
    });

	$(document).on('click','.professional_skills',function(){
      var id = $(this).attr('data-id');
      var rating = $(".example-fontawesome"+id).val();
      var isChecked = $(this).prop('checked');
      if(isChecked  == false){
        $(".example-fontawesome"+id).find('div.br-widget').find('a').removeClass('br-selected br-current');
          $(".example-fontawesome"+id).find('div.br-widget').find('a').first().addClass('br-selected br-current');
          $(".example-fontawesome"+id).find('div.br-widget').find('a').addClass('disabled');
      }else{
        $(".example-fontawesome"+id).find('div.br-widget').find('a').removeClass('disabled');
      }
    });

    $(document).on('click','#saveskillSet',function(){
      var val = [];
      var did = [];
      var value = []
      var er = [];
      var cnt = 0;
        $('.professional_skills:checked').each(function(i){
          val[i] = $(this).attr('id');
          did[i] = $(this).attr('data-id');
          value[i] = $(this).val();
          if($('.'+val[i]).val() == 0){
            addProductCartOrWishlist('danger','fa-times','Required','Please add rating to '+value[i]);
            er+=cnt+1;
          }
        });
        
        if(er != ""){
          return false;
        }
        var Data = $("#UpdateskillSet").serializeArray();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : '{{url("connect/addskillSet")}}',
            type : 'POST',
            data : Data,
            beforeSend : function(){
                $(".loader-bg").show();
            },
            success: function(res){
                if(res.success){
                    getSkillset();
                    addProductCartOrWishlist('success','fa-check','Success',res.success);
                }else{
                    addProductCartOrWishlist('danger','fa-times','error',res.error);
                }
            },
            complete : function(){
                $(".loader-bg").hide();
            }
        });
 
    });

$(document).on('click','.editInterest',function(){
    $(".loader-bg").show();
    $.get('{{url("connect/editInterest")}}',function(res){
        $("#view-interest").html(res);
        $(".loader-bg").hide();
    });
});


    $(document).on('click','#saveInterest',function(){
        var Data = $("#UpdateInterest").serializeArray();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : '{{url("connect/addInterest")}}',
            type : 'POST',
            data : Data,
            beforeSend : function(){
                $(".loader-bg").show();
            },
            success: function(res){
                if(res.success){
                    getInterest();
                    addProductCartOrWishlist('success','fa-check','Success',res.success);
                }else{
                    addProductCartOrWishlist('danger','fa-times','error',res.error);
                }
            },
            complete : function(){
                $(".loader-bg").hide();
            }
        });
 
    });


$(document).on('click','.editDetails',function(){
    $(".loader-bg").show();
    $.get('{{url("connect/editDetails")}}',function(res){
        $("#view-details").html(res);
        $(".loader-bg").hide();
    });
});



$(document).on('click','#saveDetails',function(){
        var Data = $("#updateDetails").serializeArray();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url : '{{url("connect/addDetails")}}',
            type : 'POST',
            data : Data,
            beforeSend : function(){
                $(".loader-bg").show();
            },
            success: function(res){
                if(res.success){
                    getDetails();
                    addProductCartOrWishlist('success','fa-check','Success',res.success);
                }else{
                    addProductCartOrWishlist('danger','fa-times','error',res.error);
                }
            },
            complete : function(){
                $(".loader-bg").hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
              var err = eval("(" + jqXHR.responseText + ")");

              if(err.errors.first_name){
                  $('.first_name').html(err.errors.first_name);
              }

              if(err.errors.last_name){
                  $('.last_name').html(err.errors.last_name);
              }

              if(err.errors.mobile){
                  $('.mobile').html(err.errors.mobile);
              }

              }
        });
 
    });

    $(document).on('click','.privacy',function(){
        $('input.active').removeClass('active');
        var id = $(this).attr('data-id');
        var inputVal = $("#"+id+"_privacy").val();
        $("#"+id+"_privacy").addClass('active');
        if(inputVal != 0){
            $("#"+inputVal).prop('checked',true);
        }
    });

    $(document).on('click','.updatePrivacy',function(){
        var id =  $(this).attr('id');
        $('input.active').val(id);
    });



$(window).scroll(function () {
    if ($(this).scrollTop() > 1000) {
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



});

function openPopup(){
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

function addPackage()
{
   var file_data = $("#profile-upload-left").prop("files")[0];   
  var form_data = new FormData();                  
  form_data.append("file", file_data) 

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });                   
            $.ajax({
                url: "{{url('connect/profile-picture')}}",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                     
                type: 'post',
                beforeSend : function(){
                  $(".loader-bg").show();
                },
                success : function(res){
                  if(res == 'error'){
                    addProductCartOrWishlist('success','fa-times','error','Unable to upload profile picture.');
                  }else{
                    $("#profile-img-left").attr('src',res.path);
                    setTimeout(function(){ location.reload(); },2000);
                  } 
                },
                complete : function(){
                  $(".loader-bg").hide();
                }
            });
}

function imagePopup(id){
    setTimeout(function(){
        //loadPlugin();
   // var len = $("#imageContent:nth-child(1) > #gg-screen").length;
   // alert(len);
   // if(len > 0){
    //alert($("div#gg-screen").length);
        $("div#gg-screen").slice(1).remove();
   // }
    $(".lazy").slice(0, 4).show();
    AddReadMore();
    },2000);
}


function getSkillset(){
    $(".loader-bg").show();
    $.get('{{url("connect/getSkillset")}}',function(res){
        $("#skillSet").html(res);
        $(".loader-bg").hide();
        $('[data-toggle="tooltip"]').tooltip();
    });
}

function getInterest(){
    $(".loader-bg").show();
    $.get('{{url("connect/getInterest")}}',function(res){
        $("#view-interest").html(res);
        $(".loader-bg").hide();
    });
}

function getDetails(){
    $(".loader-bg").show();
    $.get('{{url("connect/getDetails")}}',function(res){
        $("#view-details").html(res);
        $(".loader-bg").hide();
    });
}



function addProductCartOrWishlist(types,icon,status,msg){
        $.notify({
            icon: 'fa '+icon,
            title: status+'!',
            message: msg
        },{
            element: 'body',
            position: null,
            type: types,
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