@extends('layouts.app')
@section('title','Sign-Up')
@section('content')
        @if(Session::has('error'))
        <p class="text-center alert alert-success">{{Session::get('error')}}</p>
        @endif

<div class="col-sm-12 col-lg-3 col-md-12 m-b-20" style="margin-top: 150px;position: absolute;z-index: 10;">
                    <div class="" id="password-validation-box">
                      <form class="validate-password" method="post" action="#">
                        <fieldset class="fieldset-password">
                          <div id="password-info">
                            <ul>
                              <li id="length" class="invalid clearfix">
                                <span class="icon-container">
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                </span>
                                At least 8 characters
                              </li>
                              <li id="capital" class="invalid clearfix">
                                <span class="icon-container">
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                </span>
                                At least 1 uppercase letter
                              </li>
                              <li id="lowercase" class="invalid clearfix">
                                <span class="icon-container">
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                </span>
                                At least 1 lowercase letter
                              </li>
                              <li id="number-special" class="invalid clearfix">
                                <span class="icon-container">
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                </span>
                                <span title="&#33; &#64; &#35;  &#92; &#36; &#37; &#94; &#38; &#42; " class="special-characters tip">Special character</span>
                              </li>
                              <li id="number-special1" class="invalid clearfix">
                                <span class="icon-container">
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                </span>
                                At least 1 number or <span title="&#33; &#64; &#35;  &#92; &#36; &#37; &#94; &#38; &#42; " class="special-characters tip"></span>
                              </li>
                            </ul>
                          </div>
                          
                        </fieldset>
                        
                      </form>
                    </div>
                </div>

<div class="col-sm-12">
 <!-- Authentication card start -->
<form class="md-float-material form-material" method="POST" action="{{url('register')}}" autocomplete="no">
    @csrf
    <div class="text-center">
        <img src="{{ asset('resources/assets/files/assets/images/logoNew.png') }}" class="theme-logo" alt="logo.png">
    </div>
    <div class="auth-box card">
        <div class="card-block custom-padding">
            <div class="row m-b-5">
                <div class="col-md-12">
                    <h5 class="text-center txt-primary m-b-10">Create Account</h5>
                </div>
            </div>
           
            <!-- <p class="text-muted text-center p-b-5">Sign up with your account details</p> -->

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-primary">
                        <input type="text" name="first_name" class="form-control {{old('first_name') ? 'fill' : ''}}" value="{{old('first_name')}}" >
                        <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Name should contain only letters and have a maximum length of 15 characters."></i>
                        <span class="form-bar"></span>
                        <label class="float-label">First Name</label>
                         <span class="red">@if($errors->first('first_name')) {{$errors->first('first_name')}} @endif</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group form-primary">
                        <input type="text" name="last_name" class="form-control {{old('last_name') ? 'fill' : ''}}" value="{{old('last_name')}}" >
                        <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Name should contain only letters and have a maximum length of 15 characters."></i>
                        <span class="form-bar"></span>
                        <label class="float-label">Last Name</label>
                         <span class="red">@if($errors->first('last_name')) {{$errors->first('last_name')}} @endif</span>
                    </div>
                </div>
            </div>
            
                
                    <div class="form-group form-primary">
                        <input type="text" name="username" class="form-control {{old('username') ? 'fill' : ''}}" value="{{old('username')}}" >
                        <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Your Username is how others will find you and may contain up to 15 characters, including letters and numbers."></i>
                        <span class="form-bar"></span>
                        <label class="float-label">Choose Username</label>
                         <span class="red">@if($errors->first('username')) {{$errors->first('username')}} @endif</span>
                    </div>
           
            <div class="form-group form-primary">
                <input type="text" name="email" class="form-control {{old('email') ? 'fill' : ''}}" value="{{old('email')}}" >
                <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Email should be a vaild email."></i>
                <span class="form-bar"></span>
                <label class="float-label">Your Email Address</label>
                <span class="red">@if($errors->first('email')) {{$errors->first('email')}} @endif</span>
            </div>
            <div class="row m-b-5">
                <div class="col-sm-6">
                    <div class="form-group form-primary">
                        <input type="password" id="input-password" name="password" class="form-control" >
                        <span toggle="#input-password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                       <!-- <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Your password must be more than 8 characters long, should contain at least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character(!@#\$%\^&\*)."></i> -->
                        <span class="form-bar"></span>

                        <label class="float-label text-muted">Password</label>
                        <span class="red">@if($errors->first('password')) {{$errors->first('password')}} @endif</span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group form-primary">
                        <input type="password" name="confirm_password" class="form-control" >
                       <!--  <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Password and Confirm Passwors should match."></i> -->
                        <span class="form-bar"></span>
                        <label class="float-label text-muted">Confirm Password</label>
                        <span class="red">@if($errors->first('confirm_password')) {{$errors->first('confirm_password')}} @endif</span>
                    </div>
                </div>
            </div>
            
                <div class="row">
                    <div class="col-md-4">
                        <p class="text-muted text-center p-b-5 m-t-5">Or, sign up with</p>
                    </div>
                    <div class="col-md-4">
                        <a href="{{url('auth/google')}}" class="btn waves-effect btn-sm custom-social-google waves-light btn-google-plus"><i class="icofont icofont-social-google-plus"></i>Google</a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{url('auth/facebook')}}" class="btn btn-facebook custom-social-facebook m-b-20 btn-sm waves-effect waves-light"><i class="icofont icofont-social-facebook"></i>facebook</a>
                    </div>
                </div>
         
            <div class="row text-left">
                <div class="col-md-12">
                    <div class="checkbox-fade fade-in-primary">
                        <label class="micro-label">
                            <input type="checkbox" name="terms_and_conditions" class="form-control-danger" value="1">
                            <span class="cr custom-chkbox"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span class="text-inverse">I have read and accept the <a href="javascript:;" data-toggle="modal" data-target="#myModal" class="micro-label" style="color:#0d665c"><u>Terms &amp; Conditions</u>.</a></span>
                            <br>
                            <span class="red">@if($errors->first('terms_and_conditions')) {{$errors->first('terms_and_conditions')}} @endif</span>
                        </label>
                        <label class="micro-label">
                            <input type="checkbox" name="news_letters" value="1">
                            <span class="cr custom-chkbox"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span class="text-inverse">Sign up for KnitFit Newsletter </span>
                        </label>
                    </div>
                </div>
                <!-- <div class="col-md-12">
                    <div class="checkbox-fade fade-in-primary">
                        <label>
                            <input type="checkbox" value="">
                            <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                            <span class="text-inverse">Send me the <a href="">Newsletter</a> weekly.</span>
                        </label>
                    </div>
                </div> -->
            </div>
            <div class="row m-t-15">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-10 theme-outline-btn">Sign up now</button>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-8">
                    <p class="text-inverse text-left m-b-0">Back to <a href="{{url('login')}}" style="color: #0d665c"><b>KnitFit</b></a></p>
                </div>
                <div class="col-md-4">
                    <p class="text-inverse text-right"><a target="_blank" onclick="saveSession()"  style="color: #0d665c" href="https://stitchersstudio.com/website/support/help-articles/"> <b>Help? </b></a></p>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
<!-- Authentication card end -->               

  <div class="modal fade" id="myModal" role="dialog" >
        <div class="modal-dialog modal-md">
         
          <div class="modal-content p-b-20">
		  <button type="button" class="close" data-dismiss="modal" style="position: absolute;right: 10px;z-index: 1;">&times;</button>
            <div class="modal-body p-30">
			<p style="font-size:1rem;" class="text-center"><u>Terms & Conditions</u></p>
 <p style="font-size:1rem;">Terms and Conditions are a legal expression of our commitment to you - our customer - and your privacy. In the terms, we describe:</p>
 <p style="font-size:1rem;">Information that we collect and store exclusively for your use and ours to improve your experience using the KnitFit app:</p>
	<ul style="list-style-type:initial;padding-left:inherit;font-size: 0.9rem;">
	<li>Personal contact information</li>
	<li>Measurements</li>
	<li>Order processing information</li>
	<li>Device information</li>
	<li>How we use Cookies and other information about your app usage, device and location that help us provide a better internet experience. (It’s all about identifying local internet service hubs and speeding up response times.)</li>
	<li>How we share information that you submit in public forums such as social media and groups.</li>
	<li>How your data may be used, without your personal identification, to improve sizing and other services offered by KnitFit.</li>
	</ul>
              </div>
          </div>
        </div>
      </div>         
@endsection

@section('footersection')

<style type="text/css">
    .red{
		color: #bc7c8f;
		font-weight:bold;
		font-size: 12px;
	}
    .pophover{
            position: absolute;
    top: 15px;
    right: 0px;
    font-size: 11px;
    }
              #password-validation-box{display: none;float: right;}
      .theme-logo {width: 150px;}
      #page {
     margin: 0 15px;
     padding-top: 30px;
}
 label {
     font-size: 0.875em;
}
 
 .form-group.error input {
     border-color: #ee4141;
     box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(238, 65, 65, .4);
}
 .form-group.error label.error {
     margin-top: 5px;
     color: #ee4141;
}
 .pod {
     padding: 25px;
     background: #fff;
     border: 1px solid #d9d9d9;
     border-radius: 4px;
}
 .pod h3 {
     text-align: center;
     margin: 10px 0 30px;
     font-family: 'Lobster', cursive;
}
 #password-info {
     margin: 20px -94px;
     overflow: hidden;
     text-shadow: 0 1px 0 #fff;
     padding: 8px;border: 1px solid #ddd;
}
 #password-info ul {
     list-style: none;
     margin: 0;
     padding: 0;
}
 #password-info ul li {
     padding: 10px 10px 10px 50px;
     margin-bottom: 1px;
     background: #f4f4f4;
     font-size: 12px;
     transition: 250ms ease;
     position: relative;
}
 #password-info ul li .icon-container {
     display: block;
     width: 40px;
     background: #ddd;
     position: absolute;
     top: 0;
     bottom: 0;
     left: 0;
     text-align: center;
}
 #password-info ul li .icon-container .fa {
     color: white;
     padding-top: 10px;
     position: relative;
     top: 2px;
}
 #password-info ul li .tip {
     color: #5ca6d5;
     text-decoration: underline;
}
 #password-info ul li.valid {
     color: #0d665c;
}
 #password-info ul li.valid .icon-container {
     background-color: #0d665c;
}
 #password-info ul li span.invalid {
     color: #ff642e;
}
</style>
<script>
$(".toggle-password").click(function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});
</script>
<script type="text/javascript">
    $(function () {
  $('[data-toggle="popover"]').popover();


});
    function saveSession(){
        localStorage.setItem('session','getting_started');
    }
</script>

<script>
    // Tooltips
    // -----------------------------------------
    
    // Only initialise tooltips if devices is non touch
    if (!('ontouchstart' in window)) {
        $('.tip').tooltip();
    }

    //$('[data-toggle="tooltip"]').tooltip();
    
    // Password Validation
    // -----------------------------------------
    
    $(function passwordValidation() {
    
        var pwdInput = $('#input-password');
        var pwdInputText = $('#input-password-text'); // This is the input type="text" version for showing password
        var pwdValid = false;
    
        function validatePwdStrength() {
    
            var pwdValue = $(this).val(); // This works because when it's called it's called from the pwdInput, see end
    
            // Validate the length
            if (pwdValue.length > 7) {
                $('#length').removeClass('invalid').addClass('valid');
                pwdValid = true;
            } else {
                $('#length').removeClass('valid').addClass('invalid');
            }
    
            // Validate capital letter
            if (pwdValue.match(/[A-Z]/)) {
                $('#capital').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#capital').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }
    
            // Validate lowercase letter
            if (pwdValue.match(/[a-z]/)) {
                $('#lowercase').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#lowercase').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }
    
            // special character
            if (pwdValue.match(/[\!@#$%\^&*\\]/)) {
                $('#number-special').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#number-special').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }

             // Validate number
             if (pwdValue.match(/[\d\\]/)) {
                $('#number-special1').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#number-special1').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }
        }
    
        function validatePwdValid(form, event) {
            if (pwdValid === true) {
                form.submit();
            } else {
                $('#alert-invalid-password').removeClass('hide');
                event.preventDefault();
            }
        }
    
        pwdInput.bind('change keyup input', validatePwdStrength); // Keyup is a bit unpredictable
        pwdInputText.bind('change keyup input', validatePwdStrength); // This is the input type="text" version for showing password
    
        // jQuery Validation
        $(".validate-password").validate({
            // Add error class to parent to use Bootstrap's error styles
            highlight: function (element) {
                $(element).parent('.form-group').addClass('error');
            },
            unhighlight: function (element) {
                $(element).parent('.form-group').removeClass('error');
            },
    
            rules: {
                // Ensure passwords match
                "passwordCheckMasked": {
                    equalTo: "#input-password"
                }
            },
            
            errorPlacement: function (error, element) {
                if (element.attr("name") == "password" || element.attr("name") == "passwordMasked") {
                    error.insertAfter("#input-password");
                } else {
                    error.insertAfter(element);
                }
                if (element.attr("name") == "passwordCheck" || element.attr("name") == "passwordCheckMasked") {
                    error.insertAfter("#input-password-check");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form, event) {
                //this runs when the form validated successfully
                validatePwdValid(form, event);
            }
        });
    
    }); // END passwordValidation()

    $("#input-password").focusin(function() {
    $("#password-validation-box").show();
}).focusout(function () {
    $("#password-validation-box").hide();
});
    </script>

@endsection