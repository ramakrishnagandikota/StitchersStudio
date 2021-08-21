

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="csrf-token" content="eHMy1nbUF7cFogsmHhBUGEPnHZaDraOuhLFVLNJk">
  <meta name="author" content="">
  <title>Knitfit</title>
  <link href="{{ asset('resources/assets/home/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('resources/assets/home/css/all.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('resources/assets/home/css/simple-line-icons.css') }}">
  <link href="{{ asset('resources/assets/home/css/font_Lato.css') }}" rel="stylesheet">
  <link href="{{ asset('resources/assets/home/css/font_catamaran.css') }}" rel="stylesheet">
  <link href="{{ asset('resources/assets/home/css/font_Muli.css') }}" rel="stylesheet">
  <link href="{{ asset('resources/assets/home/css/font-awesome.css') }}" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="device-mockups/device-mockups.min.css"> -->
  <link href="{{ asset('resources/assets/home/css/new-age.css') }}" rel="stylesheet">
  <!-- Favicons -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('resources/assets/home/img/KF-logomark.png') }}">
  <link rel="stylesheet" href="{{ asset('resources/assets/home/css/all.css') }}" >
  <link href="{{ asset('resources/assets/home/css/slider.css') }}" rel="stylesheet">
  <link rel='stylesheet' href='https://rawgit.com/kenwheeler/slick/master/slick/slick.css'>
  <link rel='stylesheet' href='{{ asset('resources/assets/home/css/slick-theme.css') }}'>
  <!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick-theme.min.css'> -->
<link rel="stylesheet" href="https://use.typekit.net/xcd4otf.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

@if(Cookie::get('ga_cookie'))
  @include('layouts.analytics')
@endif

<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/37c9b2b6075ef0d7845f0df07/29d1c899f0552231cd078c622.js");</script>
</head>

@if(env('SHOW_MAINTANANCE') == true)

<div class="card mb-3" style="z-index: 10000;position: fixed;">
  <div class="row no-gutters">
    <div class="col-md-1">
      <img src="{{asset('resources/assets/maintanance-icon.png')}}" class="card-img" alt="...">
    </div>
    <div class="col-md-11">
      <div class="row">
      <div class="card-body">
        <h5 class="card-title" style="margin-bottom: 10px;">MAINTENANCE NOTIFICATION <!--<span class="pull-right maintenance"><a href="javascript:;" onclick="closeMaintanance()" class="fa fa-times"></a></span> --></h5>
        <p class="card-text">Please note that we will be performing important server maintenance on 23rd July from 11PM to 24th July 11AM EDT, during which time the server will be unavailable. If you are in the middle of something important, please save your work or hold off on any critical actions until we are finished.</p>
      </div>
      </div>
    </div>
  </div>
</div>

@endif

<body id="page-top">
<div class="loading">
  <div class="loader"></div>
</div>

  <nav class="navbar navbar-expand-lg navbar-light fixed-top al-p shadows" id="mainNav" @if(env('SHOW_MAINTANANCE') == true) style="top:127px;" @endif>

    <div class="container">
      <!-- <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="./img/KF-logo-h-wht.png" alt="homepage" style="width:110px" class="light-logo" /></a> -->
    <img src="{{ asset('resources/assets/home/img/logo_new.png') }}" onclick="window.location = '{{url('/')}}';" class="js-scroll-trigger logo" >
      <button class="navbar-toggler navbar-toggler-right  second-button" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <!-- <i class="fas fa-bars"></i> -->
    <div class="animated-icon2"><span></span><span></span><span></span><span></span></div>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto m-r-30">
         <li class="nav-item p-r-30">
            <a class="nav-link js-scroll-trigger active" href="#"  data-toggle="modal" data-target="#myModal">Join newsletter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" data-toggle="modal" data-target="#myContact" href="#">Contact us</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link"  href="{{url('login')}}">Login</a>
          </li>
		  <li class="nav-item">
            <a class="nav-link js-scroll-trigger"  href="{{url('register')}}">Create an account</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- <div class="row"> -->
  <!-- <div class="col-lg-2 col-md-2 col-sm-1"></div> -->
  <!-- <div class="col-lg-8 col-md-8 col-sm-12"> -->
  <section>
  <header class="masthead">
    <div class="container-fluid pd m-t-200">
      <div class="row ">
        <div class="col-lg-6 col-xl-6 my-auto">
          <div class="header-content">
            <h1 class="mb-5">Generate patterns that <span><br></span> fit you perfectly</h1>
            <a class="btn btn-outline btn-xl js-scroll-trigger" href="{{url('register')}}" >Create an account</a>
          </div>
        </div>
        <div class="col-lg-6 col-xl-6 my-auto">
          <div class="device-container">
            <video class="col-lg-12" autoplay loop controls muted>
              <source src="{{ asset('resources/assets/home/video/video.mp4') }}" type="video/mp4">
              <source src="{{ asset('resources/assets/home/video/video.mp4') }}" type="video/ogg">
              Your browser does not support HTML5 video.
            </video>
          </div>
        </div>
      </div>
    </div>
  </header>
  </section>
  <hr class="line">

  <section class="features" id="features">
    <div class="container">
      <div class="row">

        <div class="col-lg-12 my-auto">
          <div class="section-heading text-center">
            <h1 class="headlines">Features that support every knitter <br> in a streamlined mobile app</h1>
          </div>
          <div class="container">
            <div class="row">
              <div class="col-lg-4 col-xl-4 m-b-30">
                <div class="feature-item">
                  <img src="{{ asset('resources/assets/home/img/fit.png') }}" class="img-fluid">
                  <h3>Personalized fit</h3>
                  <p class="f-s" >Generate patterns to match  <br> your exact measurements</p>
                </div>
              </div>
              <div class="col-lg-4 col-xl-4">
                <div class="feature-item ">
                  <img src="{{ asset('resources/assets/home/img/connected.png') }}" class="img-fluid">
                  <h3>Stay connected</h3>
                  <p class="f-s">Share project updates or check <br>  patterns from your phone</p>
                </div>
              </div>
              <div class="col-lg-4 col-xl-4">
                <div class="feature-item">
                  <img src="{{ asset('resources/assets/home/img/management.png') }}" class="img-fluid">
                  <h3>Project management</h3>
                  <p class="f-s">Easy-to-use features to help   <br> you master your craft</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <hr class="line">


  <section class="contact" >
    <div class="container">

      <h6>HOW IT WORKS</h6>
       <div class="slider slider-for ownslider">
          <h2 class="black ">Share your work</h2>
          <h2 class="black ">Personalized sizing</h2>
          <h2 class="black ">Easy project management</h2>
          <h2 class="black ">Connect with knitters</h2>
          <h2 class="black ">Streamlined pattern instructions</h2>
      </div>
     <div class="">
      <div class=" col-md-4 mx-auto slider slider-nav text-center">

    <div><img src="{{ asset('resources/assets/home/img/slider1.gif') }}" class="img-fluid"></div>
    <div><img src="{{ asset('resources/assets/home/img/slider2.gif') }}" class="img-fluid"></div>
    <div><img src="{{ asset('resources/assets/home/img/slider3.gif') }}" class="img-fluid"> </div>
    <div><img src="{{ asset('resources/assets/home/img/slider4.gif') }}" class="img-fluid"> </div>
    <div><img src="{{ asset('resources/assets/home/img/slider5.gif') }}" class="img-fluid"> </div>
      </div>
    </div>
    </div>
  </section>




  <section class="contact m-t-30 primaryc" >
    <div class="container">
      <h2>Each one of us is unique.<br>Our handknits should be too.<br></h2>
    </div>
  </section>

    <section class="contact " >
    <div class="container m-t-50">
      <img src="{{ asset('resources/assets/home/img/KF-logomark.png') }}"  class="logomark">
      <h2 class="cblack">Join our inclusive knitting community on social media!</h2>

      <ul class="ul">
        <li class="icoli"><a href="https://www.facebook.com/knitfitco" target="_blank"><i class="fab fa-facebook-f p-15"></i></a></li>
        <li class="icoli"><a href="https://www.instagram.com/theknitfitapp/?hl=en"  target="_blank"> <i class="fab fa-instagram p-15"></i></a></li>
        <li class="icoli"><a href="https://www.linkedin.com/company/knitfit/" target="_blank"> <i class="fab fa-linkedin p-15"></i> </a></li>
       </ul>
    </div>
  </section>

  <section class="footer" >
      <div class="container text-center">
       <p><a href="#" class="span_o black"  data-toggle="modal" data-target="#myContact">Contact us</a></p>
       <!-- <p><a href="#" class="span_o black">FAQ</a></p> -->
      <p><a href="{{url('privacy')}}" target="_blank" class="span_o black">Statement of privacy and terms</a></p>

       <h6 class="m-t-30 black">DESIGNERS</h6>
       <!--<p><a href="https://mailchi.mp/cbd5373a14f7/designers-signup" class="span_o black">How to submit patterns</a></p> -->
	   <p><a href="https://mailchi.mp/fa4839b1e897/designers" class="span_o black">How to submit patterns</a></p>
      </div>
  </section>
  <br><br><br>
  </div>
  <!-- <div class="col-lg-2 col-md-2 col-sm-1"></div> -->
<!-- </div> -->

<!-- </div>
<div class="clearfix"></div>
</div>
</div>
</div> -->

<div class="modal fade" id="myModal" role="dialog" >
        <div class="modal-dialog modal-md">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <div class="modal-content p-t-20 p-b-20">
            <div class="modal-body text-center p-30">
                <h1>Sign up</h1>
                    <p class="f-16">Stay up to date on new and developing features!</p><br>
                    <input type="text" class="form-control" id="signupEmail" placeholder="Please enter email">
          <span class="red signupEmail"></span>
                    <br>
                    <button type="button" class="btn theme-outline-btn" data-dismiss="modal"  data-dismiss="modal">&nbsp;&nbsp;Cancel&nbsp;&nbsp;</button>
                    <button type="submit" class="btn btn-success theme-btn" id="signUp"><a class="custom-link" href="#" style="color:#fff">Subscribe</a></button>
              </div>
          </div>
        </div>
      </div>

<!-- Contact Popup Start-->

<div class="modal fade" id="myContact" role="dialog" >
        <div class="modal-dialog modal-md">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <div class="modal-content p-t-20 p-b-20">
            <div class="modal-body p-30">
			<form id="contact-us">
                <h1 class="text-center">Contact us</h1>
                   <div class="row">
                   <div class="col-md-6">
                   <div class="form-group">
                      <label for="int1">Name</label>
                        <div class="row">
                          <div class="col-md-12">
                          <input type="text" class="form-control" id="name" name="name" value=""> <span class="red name"></span>
                          </div>
                        </div>
                    </div>
                   </div>
                    <div class="col-md-6">
                    <div class="form-group">
                      <label for="int1">Email</label>
                        <div class="row">
                          <div class="col-md-12">
                          <input type="text" class="form-control" id="email" name="email" value="">
                          <span class="red email"></span>
                          </div>
                        </div>
                    </div>
                   </div>
                   </div>

                    <div class="form-group">
                      <label for="int1">Enter your message</label>
                        <div class="row">
                          <div class="col-md-12">
                          <textarea style="width:100%" id="message" name="message"></textarea>
                          <span class="red message"></span>
                          </div>
                        </div>
                    </div>
                    <!-- <input type="text" class="form-control" placeholder="Please enter email.."> -->
                    <br>
                    <div class="text-center">
                      <button type="button" class="btn theme-outline-btn" data-dismiss="modal"  >&nbsp;&nbsp;Cancel&nbsp;&nbsp;</button>
                      <button type="submit" class="btn btn-success theme-btn" id="ContactBtn"><a class="custom-link" href="#" style="color:#fff">Submit</a></button>
                    </div>
					</form>
            </div>

          </div>
        </div>
      </div>

<!-- Contact Popup End-->

<!-- Thank you popup start-->

<div class="modal fade" id="myModalThanks" role="dialog" >
        <div class="modal-dialog modal-md">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <div class="modal-content p-t-20 p-b-20">
            <div class="modal-body text-center p-30">
                <p class="f-16">We will be in contact within a few days.</p>
                <h1 class="m-t-15">Thank you!</h1><br>
                <button type="submit" class="btn btn-success theme-btn" data-toggle="modal"  data-dismiss="modal">Close</button>
              </div>
          </div>
        </div>
      </div>

<!-- Thank you popup end-->

<!-- Get app popup start-->

<div class="modal fade" id="myModalapp" role="dialog" >
        <div class="modal-dialog modal-md">
         <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
          <div class="modal-content p-t-20 p-b-20">
            <div class="modal-body text-center p-30">
              <h1 >Get your needles ready!</h1>
                <p class="f-16">You will be notified as soon as the app is available!</p><br>
                <button type="submit" class="btn btn-success theme-btn" data-toggle="modal"  data-dismiss="modal">Close</button>
              </div>
          </div>
        </div>
      </div>

<!-- Get app popup end-->

  <div class='cookie-banner' style='display: none'>
    <p style="margin:0 auto">
        We use cookies to personalize your experience. By continuing to visit this website you agree to use of cookies.
        <a href="{{url('privacy')}}" target="_blank">Privacy policy</a>
        &nbsp;&nbsp;&nbsp;<button class="btn btn-outline btn-sm close-cookie" >Cancel</button>&nbsp;&nbsp;<button class="btn theme-btn btn-sm" id="accept">Accept</button>
      </p>
    </div>
	
  <script src="{{ asset('resources/assets/home/js/jquery.min.js') }}"></script>
  <script src="{{ asset('resources/assets/home/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('resources/assets/home/js/jquery.easing.min.js') }}"></script>
  <!-- <script src='./js/slick.js'></script> -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js'></script>
  <script src="{{ asset('resources/assets/home/js/slider.js') }}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/fontawesome.min.js"></script>
    <script src="{{ asset('resources/assets/home/js/new-age.min.js') }}"></script>

<style type="text/css">
  .loading{
    display: none;
    background: #00000085;
    position: absolute;
    width: 100%;
    height: 100%;
    z-index: 10000;
    padding: 0px;
  }
  .loader{
        border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #bc7c8f;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
    margin: auto;
    position: relative;
    top: 200px !important;
    left: 0px !important;
  }
  /* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.red{
  color: #bc7c8f;
    font-weight: bold;
    font-size: 12px;
}
 .cookie-banner {
  position: fixed;
  bottom: 20px;
  left: 5%;
  right: 5%;
  width: 90%;
  padding: 5px 14px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background-color: #eee;
  border-radius: 5px;
  box-shadow: 0 0 2px 1px rgba(0, 0, 0, 0.2);
}
.close {
  height: 20px;
  background-color: #777;
  border: none;
  color: white;
  border-radius: 2px;
  cursor: pointer;
}
</style>
  <script>

$(document).ready(function () {

  getCookie();
  


$(document).on('click','#accept',function(){
    $.get('{{url("cookie/set")}}',function(res){
        location.reload();
    });
});

$('.close-cookie').click(function() {
  $('.cookie-banner').fadeOut();
})

  $('.second-button').on('click', function () {
    $('.animated-icon2').toggleClass('open');
  });

});

function getCookie(){
    $.get('{{url("cookie/get")}}',function(res){
      if(res == 0){
        $('.cookie-banner').delay(2000).fadeIn();
      }
    });
}
  // $(window).scroll(function(){
  //       var scroll = $(window).scrollTop();
  //       if(scroll > 100){
  //           $('.fixed-top').css('background', 'red');
  //       } else{
  //           $('.fixed-top').css('background-color', 'rgba(23, 162, 184, 0.9)');
  //       }
  //   });
// $(function () {
//     $(window).scroll(function () {
//         if ($(this).scrollTop() > 100) {

//            $('.navbar').css("background-color:red");
//         }
//         if ($(this).scrollTop() < 100) {

//           $('.navbar').css("background-color:black");
//        }
//     })
// });

$(function(){
    $(document).on('click','#ContactBtn',function(){

        var Data = $("#contact-us").serializeArray();
        $.ajax({
            url : '{{url("api/contact-us")}}',
            type : 'POST',
            data : Data,
            beforeSend : function(){
              $(".loading").show();
            },
            success : function(res){
              if(res.status == 1){
                $("#contact-us")[0].reset();
                $("#myContact").modal('hide');
                $("#myModalThanks").modal('show');
              }else{
                if(res.errors.name){
                  $(".name").html(res.errors.name);
                }else{
                  $(".name").html('');
                }

                if(res.errors.email){
                  $(".email").html(res.errors.email);
                }else{
                  $(".email").html('');
                }

                if(res.errors.message){
                  $(".message").html(res.errors.message);
                }else{
                  $(".message").html('');
                }
              }
            },
            complete : function(){
              $(".loading").hide();
            }
        });
    });

$(document).on('click','#signUp',function(){

        var email = $("#signupEmail").val();
        $.ajax({
            url : '{{ url("api/signUpKnitfit") }}',
            type : 'POST',
            data : 'email='+email,
            beforeSend : function(){
              $(".loading").show();
            },
            success : function(res){
              if(res.status == 1){
                $("#signupEmail").val('');
                $("#myModal").modal('hide');
                $("#myModalapp").modal('show');
              }else{


                if(res.errors.email){
                  $(".signupEmail").html(res.errors.email);
                }else{
                  $(".signupEmail").html('');
                }

              }
            },
            complete : function(){
              $(".loading").hide();
            }
        });
    });

});

</script>

</body>
</html>
