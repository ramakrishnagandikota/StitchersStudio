<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>StitchersStudio | @yield('title')</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
      <!-- Meta -->
      <meta charset="utf-8">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="description" content="Knitfit" />
      <meta name="keywords" content="Knitfit" />
      <meta name="author" content="Jane Nickerson" />
	  <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- Favicon icon -->
  <!-- <script src=" asset('public/js/app.js') }}" defer></script> -->
      <link rel="icon" href="{{ asset('resources/assets/files/assets/images/favicon.ico') }}" type="image/x-icon">
      <!-- Google font-->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
      <!-- Required Fremwork -->
      <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/bower_components/bootstrap/css/bootstrap.min.css') }}">
      <!-- waves.css -->
      <link rel="stylesheet" href="{{ asset('resources/assets/files/assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all"><!-- feather icon -->
      <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/feather/css/feather.css') }}">
      <!-- themify-icons line icon -->
      <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/themify-icons/themify-icons.css') }}">
      <!-- ico font -->
      <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/icofont/css/icofont.css') }}">
      <!-- Font Awesome -->
      <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/font-awesome/css/font-awesome.min.css') }}">
      <!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/style.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.css')}}">
{!! htmlScriptTagJsApi() !!}
</head>
<body themebg-pattern="theme1" id="app">

@if(env('SHOW_MAINTANANCE') == true)

<div class="card mb-3">
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

<div class="loading">
  <div class="loader"></div>
</div>

  <!-- Pre-loader start -->
  <div class="theme-loader">
      <div class="loader-track">
          <div class="preloader-wrapper">
              <div class="spinner-layer spinner-blue">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
              <div class="spinner-layer spinner-red">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>

              <div class="spinner-layer spinner-yellow">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>

              <div class="spinner-layer spinner-green">
                  <div class="circle-clipper left">
                      <div class="circle"></div>
                  </div>
                  <div class="gap-patch">
                      <div class="circle"></div>
                  </div>
                  <div class="circle-clipper right">
                      <div class="circle"></div>
                  </div>
              </div>
          </div>
      </div>
  </div>
    <section class="login-block">

	        <!-- Container-fluid starts -->
        <div class="container-fluid">
            <div class="row">
              
             @yield('content')
                    </div>
                    <!-- Authentication card end -->
               
                <!-- end of col-sm-12 -->
            </div>
    </section>


<div class="modal fade" id="myModal1" role="dialog" >
  <div class="modal-dialog modal-md">
   <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
    <div class="modal-content p-t-20 p-b-20">
      <div class="modal-body text-center p-30">
          <h1>Sign up</h1>
              <p class="f-16">Stay up to date on new and developing features!</p><br>
              <input type="text" class="form-control" id="signupEmail" placeholder="Please enter email">
			  <span class="red signupEmail" style="position: absolute;left: 31px;"></span>
              <br>
              <button type="button" class="btn theme-outline-btn" data-dismiss="modal"  data-dismiss="modal">&nbsp;&nbsp;Cancel&nbsp;&nbsp;</button>
              <button type="submit" class="btn btn-success theme-btn" id="signUp"><a class="custom-link" href="#" style="color:#fff">Subscribe</a></button>
        </div>
    </div>
  </div>
</div>

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

 <div class='cookie-banner' style='display: none'>
    <p style="margin:0 auto">
        We use cookies to personalize your experience. By continuing to visit this website you agree to use of cookies.
        <a href="{{url('privacy')}}" target="_blank">Privacy policy</a>
        &nbsp;&nbsp;&nbsp;<button class="btn btn-outline btn-sm close-cookie" >Cancel</button>&nbsp;&nbsp;<button class="btn theme-btn btn-sm" id="accept">Accept</button>
      </p>
    </div>
	
 <style type="text/css">
   .loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #bc7c8f;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  position: absolute;
    margin: auto;
    top: 250px;
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

.loading{
    display: none;
      background: #00000085;
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 1;
    padding: 0px;
    top: 0px;

}

/* sweet alert customizes css */
  .swal2-icon.swal2-success [class^=swal2-success-line]{
	  background-color: #0d665c !important;
  }
  .swal2-icon.swal2-success .swal2-success-ring{
	  border:.25em solid rgb(13, 102, 92)
  }
  .swal2-styled.swal2-confirm {

    background-color: #0d665c !important;
    color: #fff !important;
    border: 1px solid #0d665c !important;
  }
  .swal2-icon.swal2-error [class^=swal2-x-mark-line]{
	  background-color: #bc7c8f !important;
  }
  .swal2-icon.swal2-error {
    border-color: #bc7c8f !important;
    color: #bc7c8f !important;
}
.swal2-styled.swal2-cancel {
    background-color: #bc7c8f !important;
}
.swal2-icon.swal2-warning {
    border-color: #bc7c8f !important;
    color: #bc7c8f !important;
}
.alert-success {
    background-color: #fff;
    border-color: #0d665c;
    color: #0d665c;
}
.alert-danger {
    background-color: #fff;
    border-color: #bc7c8f;
    color: #bc7c8f;
}
.theme-logo {
    width: 150px !important;
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

	<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/popper.js/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- waves js -->
<script src="{{ asset('resources/assets/files/assets/pages/waves/js/waves.min.js') }}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
<!-- modernizr js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/modernizr/js/modernizr.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/modernizr/js/css-scrollbars.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/common-pages.js') }}"></script>
<script type="text/javascript" src="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.js')}}"></script>


<!-- i18next.min.js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/i18next/js/i18next.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-i18next/js/jquery-i18next.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/common-pages.js') }}"></script>
<script type="text/javascript">
  $(function(){
	  getCookie();
	  $(document).on('click','#accept',function(){
		$.get('{{url("cookie/set")}}',function(res){
			location.reload();
		});
	  });

	$('.close-cookie').click(function() {
	  $('.cookie-banner').fadeOut();
	})
     $(document).on('click','#signUp',function(){

        var email = $("#signupEmail").val();
		if(email == ""){
			 $(".signupEmail").html("The email field is required.");
			 return false;
		}else{
			$(".signupEmail").html("");
		}
        $.ajax({
            url : '{{ url("api/signUpKnitfit") }}',
            type : 'POST',
            data : 'email='+email+'&sub_type=mobileapp',
            beforeSend : function(){
              $(".loading").show();
            },
            success : function(res){
              if(res.status == 1){
                $("#signupEmail").val('');
                $("#myModal1").modal('hide');
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
	
	
	$("#signupEmail").keyup(function(event){
      var inp = String.fromCharCode(event.keyCode);
      var value = $(this).val();

      var check = validateEmail(value);

      if(check == false){
        $(".signupEmail").html("Enter a valid email.");
        $("#signUp").attr('disabled',true);
      }else{
        $(".signupEmail").html("");
        $("#signUp").attr('disabled',false);
      }

  });
  
   });
   
function validateEmail(elementValue){      
   var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
   return emailPattern.test(elementValue); 
} 
function getCookie(){
    $.get('{{url("cookie/get")}}',function(res){
      if(res == 0){
        $('.cookie-banner').delay(2000).fadeIn();
      }
    });
}
</script>
@yield('footersection')

</body>
</html>
