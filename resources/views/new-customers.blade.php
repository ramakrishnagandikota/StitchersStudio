

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
  <!--link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/-->
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

<script id="mcjs">!function(c,h,i,m,p){m=c.createElement(h),p=c.getElementsByTagName(h)[0],m.async=1,m.src=i,p.parentNode.insertBefore(m,p)}(document,"script","https://chimpstatic.com/mcjs-connected/js/users/37c9b2b6075ef0d7845f0df07/29d1c899f0552231cd078c622.js");</script>
  
<style>
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
a.link:hover{ color: #0d665c !important; }
</style>	
</head>

<body id="page-top">
<div class="loading">
  <div class="loader"></div>
</div>

  <nav class="navbar navbar-expand-lg navbar-light fixed-top al-p shadows" id="mainNav">
   
    <div class="container">
      <!-- <a class="navbar-brand js-scroll-trigger" href="#page-top"><img src="./img/KF-logo-h-wht.png" alt="homepage" style="width:110px" class="light-logo" /></a> -->
	  <img src="{{ asset('resources/assets/home/img/logo_new1.png') }}" href="#page-top" class="js-scroll-trigger logo" >
      <button class="navbar-toggler navbar-toggler-right  second-button" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <!-- <i class="fas fa-bars"></i> -->
    <div class="animated-icon2"><span></span><span></span><span></span><span></span></div>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto m-r-30">
        <li class="nav-item p-r-30">
        <a class="nav-link js-scroll-trigger active" href="#" data-toggle="modal" data-target="#myModal">Join newsletter</a>
        </li>
        <!-- <li class="nav-item p-r-30">
        <a class="nav-link js-scroll-trigger" href="https://knitfitco.pluraltechnology.com/plans">Plans</a>
        </li> -->
        <li class="nav-item">
        <a class="nav-link js-scroll-trigger" data-toggle="modal" data-target="#myContact" href="#">Contact us</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{ url('login') }}">Login</a>
        </li>
        <li class="nav-item">
        <a class="nav-link js-scroll-trigger" href="{{ url('register') }}">Create an account</a>
        </li>
        <li class="nav-item">
        <a class="nav-link js-scroll-trigger f-w-500" target="_blank" href="https://play.google.com/store/apps/details?id=com.knitfitco.knitfit"><i class="fa fa-android nav-icon" aria-hidden="true"></i> Get Android app</a>
        </li>
        
        </ul>
        </div>
    </div>
  </nav>
  
  <section class="contact m-t-30 primaryc" >
    <div class="container">
      <div class="col-lg-12" style="margin-top: 40px;"><h2>Your account type: Free Account</h2>
      </div>
    </div>
  </section>
  <!-- <div class="row"> -->
  <!-- <div class="col-lg-2 col-md-2 col-sm-1"></div> -->
  <!-- <div class="col-lg-8 col-md-8 col-sm-12"> -->
  <!-- <section>
  <header class="masthead">
    <div class="container-fluid pd m-t-200">
      <div class="row ">
        <div class="col-lg-6 col-xl-6 my-auto">
          <div class="header-content">
            <h1 class="mb-5">Generate patterns that <span><br></span> fit you perfectly</h1>
            <button class="btn btn-outline btn-xl js-scroll-trigger" data-toggle="modal" data-target="#myModal">Get notified when the app is released</button>
          </div>
        </div>
        <div class="col-lg-6 col-xl-6 my-auto">
          <div class="device-container">
            <video class="col-lg-12" autoplay loop controls muted>
              <source src="./video/video.mp4" type="video/mp4">
              <source src="./video/video.mp4" type="video/ogg">
              Your browser does not support HTML5 video.
            </video>
          </div>
        </div>
      </div>
    </div>
  </header>
  </section>
  <hr class="line"> -->
<section class="features" id="features">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 my-auto">
          <div class="section-heading text-center">
            <h4 class="m-t-30"></h4>
          </div>
          <div class="container m-t-20">
            <div class="row justify-content-md-center">
              <div class="col-lg-6 my-auto">
                <p>To get your first custom sized pattern, head over to the <a class="link" href="{{ url('shop-patterns') }}">KnitFit pattern shop</a>. The link will open in a browser.</p>
                <p style="margin-top: 10px;">
                  After purchase, the pattern will be immediately available in your project library of the mobile app. You may need to go to the dashboard then back the project library to see the pattern you just purchased. Set up your measurement profile, knit your swatch, and generate your perfectly sized pattern!
                <br><br></p>
                </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12 my-auto">
          <div class="section-heading text-center">
            <h4 class="m-t-30">Upgrade to get unlimited projects!</h4>
          </div>
          <div class="container m-t-20">
            <div class="row justify-content-md-center">
              <div class="col-lg-6 my-auto">
                <p>
                  The Free Account comes with one project and one measurement profile enabled, and unlimited social media features. Upgrade to a Knitter Account to enable unlimited projects and measurement profiles for 2.99/mo or 24.99/yr (30% off)! 
				  @if(Auth::check())
					  <a class="link" href="{{ url('knitter/subscription') }}">Learn more</a>
				  @else
					  <a class="link" href="{{ url('login?redirect_uri=subscription') }}">Learn more</a>
				  @endif
				  about the benefits of the Knitter Account.
                </p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <hr class="line">

  <section class="footer" >
      <div class="container text-center">
       <p>If you have any questions, please send us feedback 
	   @if(Auth::check())
		  <a href="{{ url('feedback') }}" class="link">Feedback link</a></p>
	   @else
		  <a href="{{ url('login?redirect_uri=feedback') }}" class="link">Feedback link</a></p> 
	   @endif
      <br><br>
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
                    <p class="f-16">We'll email you when the app is ready!</p><br>
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

<script src="{{ asset('resources/assets/home/js/jquery.min.js') }}"></script>
  <script src="{{ asset('resources/assets/home/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('resources/assets/home/js/jquery.easing.min.js') }}"></script>
  <!-- <script src='./js/slick.js'></script> -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js'></script>
  <script src="{{ asset('resources/assets/home/js/slider.js') }}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/fontawesome.min.js"></script>
    <script src="{{ asset('resources/assets/home/js/new-age.min.js') }}"></script>
	<script src="https://use.fontawesome.com/99ba050946.js"></script>
	
	
  <script>

$(document).ready(function () {

  $('.second-button').on('click', function () {

    $('.animated-icon2').toggleClass('open');
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


});
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
if (localStorage.getItem('cookieSeen') != 'shown') {
  $('.cookie-banner').delay(2000).fadeIn();
  localStorage.setItem('cookieSeen','shown')
};
$('.close').click(function() {
  $('.cookie-banner').fadeOut();
})
</script>

</body>
</html>
