@extends('layouts.app')
@section('title','Sign-Up')
@section('content')
        @if(Session::has('error'))
        <div class="text-center alert alert-success"><p>{{Session::get('error')}}</p>
        <p><b style="font-weight: 800;"><u>NOTE</u>:-</b> {{Session::get('note')}}</p>
        </div>
        @endif


        

<div class="col-sm-12 col-lg-3 col-md-12 m-b-20" style="margin-top: 150px;position: absolute;z-index: 10;">
                    
                </div>

<div class="col-sm-12">
 <!-- Authentication card start -->
<form id="defaultForm" class="md-float-material form-material" method="POST" action="{{url('register')}}" autocomplete="off" >
    @csrf
	@if($identity)
        <input type="hidden" name="identity" value="{{ $identity }}">
        <input type="hidden" name="invited" value="{{ $invited }}">
        <input type="hidden" name="new" value="{{ $new }}">
    @endif
    <div class="text-center">
        <a href="{{env('STITCHERS_STUDIO_URL')}}"><img src="{{ asset('resources/assets/files/assets/images/logoNew.png') }}" class="theme-logo" alt="logo.png"></a>
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
                <div class="form-group">
                    
                        <input type="text" class="form-control" name="first_name" maxlength="50" autocomplete="off" {{old('first_name') ? 'fill' : ''}} value="{{old('first_name')}}" />
                        <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="First name should contain only letters and have a maximum length of 50 characters."></i>
                        <span class="form-bar"></span>
                        <label class="float-label control-label">First name<span class="red">*</span></label>
                        <span class="red first_name">@if($errors->first('first_name')) {{$errors->first('first_name')}} @endif</span>
                  </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group form-primary">
                        <input type="text" id="last_name" name="last_name" maxlength="15" class="form-control {{old('last_name') ? 'fill' : ''}}" value="{{old('last_name')}}" >
                        <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Last name should contain only letters and have a maximum length of 15 characters."></i>
                        <span class="form-bar"></span>
                        <label class="float-label">Last Name<span class="red">*</span></label>
                         <span class="red last_name">@if($errors->first('last_name')) {{$errors->first('last_name')}} @endif</span>
                    </div>
                </div>
            </div>
            
                
                    <div class="form-group form-primary">
                        <input type="text" id="username" name="username" maxlength="25" class="form-control {{old('username') ? 'fill' : ''}}" value="{{old('username')}}" >
                        <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Your Username is how others will find you and may contain up to 25 characters, including letters and numbers."></i>
                        <span class="form-bar"></span>
                        <label class="float-label">Choose Username<span class="red">*</span></label>
                         <span class="red username">@if($errors->first('username')) {{$errors->first('username')}} @endif</span>
                    </div>
           
            <div class="form-group form-primary">
              <input type="text" name="email" id="email" class="form-control {{ $identity ? 'fill' : ''}}" value="{{ $identity ? base64_decode($identity) : '' }}" >
                <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Email should be a vaild email."></i>
                <span class="form-bar"></span>
                <label class="float-label">Your Email Address<span class="red">*</span></label>
                <span class="red email" id="emailValidate">@if($errors->first('email')) {{$errors->first('email')}} @endif</span>
            </div>
            <div class="row m-b-5">
                <div class="col-sm-6">
                    <div class="form-group form-primary">
                        <input type="password" id="input-password" maxlength="16" name="password" class="form-control" >
                        <span toggle="#input-password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        <span class="form-bar"></span>

                        <label class="float-label text-muted">Password<span class="red">*</span></label>
                        <span class="red password">@if($errors->first('password')) {{$errors->first('password')}} @endif</span>
                    </div>

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
                <div class="col-sm-6">
                    <div class="form-group form-primary">
                        <input type="password" id="confirm_password" maxlength="16" name="confirm_password" class="form-control" >
                       <!--  <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Password and Confirm Passwors should match."></i> -->
                        <span class="form-bar"></span>
                        <label class="float-label text-muted">Confirm Password<span class="red">*</span></label>
                        <span class="red confirm_password" id="cnfm_pwd">@if($errors->first('confirm_password')) {{$errors->first('confirm_password')}} @endif</span>
                    </div>
                </div>

             <!--   <div class="col-sm-6">
                    <div class="form-group form-primary">
                        {!! ReCaptcha::htmlFormSnippet() !!}
                        <span class="form-bar"></span>
                        <label class="float-label text-muted"></label>
                        <span class="red" id="recaptcha">@if($errors->first('recaptcha')) {{$errors->first('recaptcha')}} @endif</span>
                    </div>
                </div> -->
				
				<div class="col-sm-6">
                  <div class="form-group form-primary">
                    <div class="over-lay"></div>
                    <img src="{{asset('resources/assets/background04.png')}}">
                        <span id="randomfield"></span>
                        <input id="captchval" name="captchval" type="hidden">
                      </div>
                </div>
				
				<div class="col-sm-6">
                  <div class="form-group form-primary">
                      <button type="button" class="pull-right btn btn-primary btn-sm" onclick="getCaptcha()"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                      </div>
                </div> 
                
            </div>
			
			<div class="form-group form-primary" id="captchaDiv">
                        <input type="text" class="form-control" name="captcha" id="captcha">
                        <span class="form-bar"></span>
                        <label class="float-label text-muted">Captcha<span class="red">*</span></label>
                        <span class="red captcha" id="recaptcha">@if($errors->first('captcha')) {{$errors->first('captcha')}} @endif</span>
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
                  <div class="form-group" style="margin: 0px;">
                    <input type="checkbox" name="terms_and_conditions" class="form-control-danger" id="terms_and_conditions" value="1" >
                    <label class="micro-label">
                        <span class="text-inverse">I have read and accept the <a href="javascript:;" data-toggle="modal" data-target="#myModal" class="micro-label" style="color:#0d665c"><u>Terms &amp; Conditions</u>.</a><span class="red">*</span></span>
                    </label>
                    <span class="red terms_and_conditions">@if($errors->first('terms_and_conditions')) {{$errors->first('terms_and_conditions')}} @endif</span>
                  </div>
                    <div class="form-group">
                        <input type="checkbox" name="news_letters" value="1">
                        <label class="micro-label">
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
                    <button type="submit" id="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-10 theme-outline-btn">Sign up now</button>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-8">
                    <p class="text-inverse text-left m-b-0">Back to <a href="{{url('login')}}" style="color: #0d665c"><b>StitchersStudio</b></a></p>
                </div>
                <div class="col-md-4">
                    <p class="text-inverse text-right"><a target="_blank" onclick="saveSession()"  style="color: #0d665c" href="https://stitchersstudio.com/website/support/help-articles/"> <b>Help? </b></a></p>
                </div>
            </div>
        </div>


        

    </div>
</form>
<!--
<div class="auth-box">
<p class="text-center" style="font-weight: 500;">Note: For our early release, our app works on tablet, laptop, and desktop. Please sign up for our <a href="javascript:;" data-toggle="modal" data-target="#myModal1" style="color: #0d665c;
    text-decoration: underline;">mailing list</a> to be notified when our mobile app is ready!</p>
</div>
-->


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
               #password-validation-box{display: none;} 
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
   margin:0 auto;
   overflow: hidden;
   text-shadow: 0 1px 0 #fff;
     padding: 6px;
     border: 1px solid #ddd;
     z-index: 1;
     top: 40px;
     width: 100%;
     position: absolute;
     box-shadow:1px 4px 12px 4px #bdbcbc;
     background-color: #ffffff;
}
 #password-info ul {
   list-style: none;
   margin: 0;
   padding: 0;
}
 #password-info ul li {
   padding: 0px 4px 0px 46px;
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
    padding-top: 0px;
    position: relative;
    top: 0px;
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

.btn-primary.disabled, .btn-primary:disabled {
    background-color: #fff;
    border-color: #0d665c;
}

.has-error .help-block, .has-error .radio, .has-error .checkbox, .has-error .radio-inline, .has-error .checkbox-inline{
  color: #bc7c8f;
  font-weight: bold;
}
.help-block {
    display: block;
    margin-top: 5px;
    *margin-bottom: 10px;
    color: #bc7c8f;
	font-weight:bold;
}
small, .small {
    font-size: 85%;
}
.has-success .form-control {
    border-color: #0d665c;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
}

.has-feedback .form-control {
    padding-right: 42.5px;
}
.has-success .form-control-feedback {
    color: #0d665c;
}
.has-feedback .form-control-feedback {
    position: absolute;
    top: 0px;
    right: 0;
    display: block;
    width: 34px;
    height: 34px;
    line-height: 34px;
    text-align: center;
}
.has-error > input:focus{
  border-bottom: 1px solid #bc7c8f !important;
}
.has-error > .fa{
  *color : #bc7c8f;
}
.has-success > input:focus{
  border-bottom: 1px solid #0d665c !important;
}

.loading{
  z-index: 10000 !important;
}
#randomfield{
    position: absolute;
    left: 5px;
    top: -5px;
    font-stretch: extra-condensed;
    letter-spacing: 17px;
    font-style: italic;
    font-size: 24px;
    color: #0d665c;
  }
.over-lay{
      background: transparent;
    height: 100%;
    width: 100%;
    position: absolute;
    z-index: 1;
}
</style>

<link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
<script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>


<script type="text/javascript">
$(document).ready(function() {
	getCaptcha();
    $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: '', //fa fa-check
                invalid: '', //fa fa-exclamation
                validating: 'fa fa-spinner fa-spin'
            },
            fields: {
                first_name: {
                    message: 'The first name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The first name is required.'
                        },
                        stringLength: {
                            min: 2,
                            message: 'First name must contain atleast 2 characters'
                        },
						
                        /*remote: {
                            url: 'remote.php',
                            message: 'The first name is not available'
                        },*/
                        regexp: {
                            regexp: /^[a-zA-Z]+$/,
                            message: 'The first name can only consist of alphabets'
                        }
                    }
                },
        last_name: {
                    message: 'The last name is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The last name is required.'
                        },
                        stringLength: {
                            min: 2,
                            message: 'Last name must contain atleast 2 characters'
                        },
                        /*remote: {
                            url: 'remote.php',
                            message: 'The last name is not available'
                        },*/
                        regexp: {
                            regexp: /^[a-zA-Z]+$/,
                            message: 'The last name can only consist of alphabets'
                        }
                    }
                },
        username: {
                    message: 'The username is not valid',
                    validators: {
                        notEmpty: {
                            message: 'The username is required.'
                        },
                        stringLength: {
                            min: 5,
                            max: 25,
                            message: 'Username must contain atleast 5 characters.'
                        },
                        remote: {
                            url: '{{url("check-username")}}',
                            message: 'The username is already in use. Please enter another one.'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9]+$/,
                            message: 'The username can only consist of alphabets and numbers'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The email address is required.'
                        },
                        emailAddress: {
                            message: ''
                        },
                        remote: {
                            url: '{{url("check-email")}}',
                            message: 'The email is already in use. Please enter another one.'
                        },
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required.'
                        },
					stringLength: {
									min: 8,
									max: 16,
									message: '     '
								},
					
					regexp: {
									regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/,
									message: 'Invalid password format.'
								}
                    }
                },
        confirm_password: {
          validators: {
            notEmpty: {
              message: 'The confirm password is required.'
            },
            identical: {
              field: 'password',
			  message : 'The password & confirm passwors should be same.'
            }
          }
        },
		captchval:{
          validators: {
              notEmpty: {
                  message: ' '
              }
        }
      },
        captcha:{
          validators: {
              notEmpty: {
                message: 'The captcha is required.'
              },
              identical: {
                field: 'captchval',
          message : 'The captcha should match with image.'
              }
            }
        },
        terms_and_conditions: {
          validators: {
            notEmpty: {
              message: 'Please accept terms & conditions.'
            }
          }
        }
		
            }
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');

            // Use Ajax to submit form data
           /* $.post($form.attr('action'), $form.serialize(), function(result) {
              if(result ==)
                window.location.assign('{{url("login")}}');
            }, 'json'); */
			
			var captchval = $("#captchval").val();
            var captcha = $("#captcha").val();

            if(captchval != captcha){
              $("#captchaDiv").children('.help-block').eq(1).attr('data-bv-result','INVALID').show();
              return false;
            }

            $.ajax({
              url : '{{url("register")}}',
              type : 'POST',
              data : $form.serialize(),
              beforeSend : function(){
                $(".loading").show();
              },
              success : function(res){
                if(res == true){
					$("#defaultForm")[0].reset();
                  //window.location.assign('{{url("login")}}');
				  window.location.assign('{{url("register/thankyou")}}');
                }else{
                  location.reload();
                }
              },
              complete : function(){
                $(".loading").hide();
              },
              error: function (jqXHR, exception) {
                var err = eval("(" + jqXHR.responseText + ")");

                if(err.errors.first_name){
                    $('.first_name').html(err.errors.first_name);
                }

                if(err.errors.last_name){
                    $('.last_name').html(err.errors.last_name);
                }

                if(err.errors.username){
                    $('.username').html(err.errors.username);
                }

                if(err.errors.email){
                    $('.email').html(err.errors.email);
                }

                if(err.errors.password){
                    $('.password').html(err.errors.password);
                }

                if(err.errors.confirm_password){
                    $('.confirm_password').html(err.errors.confirm_password);
                }

                if(err.errors.terms_and_conditions){
                    $('.terms_and_conditions').html(err.errors.terms_and_conditions);
                }
            }
            });
        });
});

function getCaptcha() {
        var chars = "0Aa1Bb2Cc3Dd4Ee5Ff6Gg7Hh8Ii9Jj0Kk1Ll2Mm3Nn4Oo5Pp6Qq7Rr8Ss9Tt0Uu1Vv2Ww3Xx4Yy5Zz";
        var string_length = 5;
        var captchastring = '';
        for (var i=0; i<string_length; i++) {
            var rnum = Math.floor(Math.random() * chars.length);
            captchastring += chars.substring(rnum,rnum+1);
        }
        $('#captchval').val(captchastring);      
        document.getElementById("randomfield").innerHTML = captchastring;
        //document.getElementById("captcha").value = '';
        //document.getElementById("captcha").value = '';
    }
</script>

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

$(document).on('click','#terms_and_conditions',function(){
    if($(this).prop('checked')){
      $("#terms").prop('checked',true);
    }else{
      $("#terms").prop('checked',false);
    }
});
 

/*
  $("#first_name,#last_name").keypress(function(event){
      var inp = String.fromCharCode(event.keyCode);
      var pattern = /^[a-zA-Z]$/;
      var value = $(this).val();

    if (!pattern.test(inp)){
      return false;
    }else{
      if(value.length > 14){
        return false;
      }
    }

  });


  $("#username").keypress(function(event){
      var inp = String.fromCharCode(event.keyCode);
      var pattern = /^[a-zA-Z0-9]$/;
      var value = $(this).val();

    if (!pattern.test(inp)){
      return false;
    }else{
      if(value.length > 14){
        return false;
      }
    }

  });

  $("#email").keyup(function(event){
      var inp = String.fromCharCode(event.keyCode);
      var value = $(this).val();

      var check = validateEmail(value);

      if(check == false){
        $("#emailValidate").html("Enter a valid email.");
        $("#submit").attr('disabled',true);
      }else{
        $("#emailValidate").html("");
        $("#submit").attr('disabled',false);
      }

  });


  $('#input-password').keypress(function(event){
      var inp = String.fromCharCode(event.keyCode);
      var value = $(this).val();

      if(value.length > 16){
        return false;
      }
  });

  $('#confirm_password').keyup(function(event){
      var inp = String.fromCharCode(event.keyCode);
      var value = $(this).val();
      var pwd = $('#input-password').val();


      if(value.length > 15){
        return false;
      }

      if(pwd == value){
        $("#cnfm_pwd").html('');
        $("#submit").attr('disabled',false);
      }else{
         $("#cnfm_pwd").html('Password & confirm password should match.');
         $("#submit").attr('disabled',true);
      }
  });

*/
});

function validateEmail(elementValue){      
   var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
   return emailPattern.test(elementValue); 
} 

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
                pwdValid = false;
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
       /* $(".validate-password").validate({
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
        }); */
    
    }); // END passwordValidation()

    $("#input-password").focusin(function() {
    $("#password-validation-box").show();
}).focusout(function () {
    $("#password-validation-box").hide();
});
    </script>

@endsection