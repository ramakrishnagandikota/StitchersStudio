@extends('layouts.app')
@section('title','Sign-In')
@section('content')

<div class="col-sm-12">
        @if(Session::has('error'))
        <p class="text-center alert alert-success">{{Session::get('error')}}.
            @if(Session::has('resend'))
            Click here to
            <a href="{{url('resend-email/'.md5(Session::get('resend')))}}">Resend email</a>
            @endif

        </p>
        @endif

            <!-- Authentication card start -->
                    <form id="defaultForm" class="md-float-material form-material" action="{{url('login')}}" method="POST" >
                        @csrf
						@if($identity)
                            <input type="hidden" name="identity" value="{{ $identity }}">
                            <input type="hidden" name="invited" value="{{ $invited }}">
                            <input type="hidden" name="new" value="{{ $new }}">
                        @endif

						<input type="hidden" name="redirect_uri" value="{{ $redirect }}" >
                        <div class="text-center">
                            <a href="{{env('STITCHERS_STUDIO_URL')}}"><img src="{{ asset('resources/assets/files/assets/images/logoNew.png') }}" class="theme-logo" alt="logo.png"></a>
                        </div>
                        <div class="auth-box card">
                            <div class="custom-padding">
                                <div class="row m-b-10">
                                    <div class="col-md-12">
                                        <h5 class="text-center txt-primary">Log in</h5>
                                    </div>
                                </div>
                                <!-- <p class="text-muted text-center p-b-5">Sign in with your regular account</p> -->
                                <div class="form-group form-primary">
                                    <input type="text" name="email"  class="form-control" >

                                    <span class="form-bar"></span>
                                    <label class="float-label text-muted">Username / Email</label>
                                    <span class="red">@if($errors->first('email')) {{$errors->first('email')}} @endif</span>
                                    <span class="red">@if($errors->first('username')) {{$errors->first('username')}} @endif</span>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="password" id="password-field" name="password" class="form-control" >
                                    <!-- <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Your password must be more than 8 characters long, should contain at least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character."></i> -->
                                    <span class="form-bar"></span>
                                    <label class="float-label text-muted">Password</label> <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    <span class="red">@if($errors->first('password')) {{$errors->first('password')}} @endif</span>
                                </div>
                                <div class="row text-left">
                                    <div class="col-12">
                                        <div class="checkbox-fade fade-in-primary">
                                            <!-- <label>
                                                <input type="checkbox" value="">
                                                <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                                                <span class="text-inverse">Remember me</span>
                                            </label> -->
                                        </div>
                                        <div class="forgot-phone text-right float-right m-b-20">
                                            <a href="{{url('reset-password')}}" class="text-right text-muted micro-label"> Forgot password?</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <p class="text-muted p-b-5 m-t-5">Or log in with</p>
                                    </div>
                                    <div class="col-md-4">
                                    <a href="{{url('auth/google')}}" class="btn waves-effect btn-sm custom-social-google waves-light btn-google-plus"><i class="icofont icofont-social-google-plus"></i>Google</a>
                                    </div>
                                    <div class="col-md-4">
                                        <a href="{{url('auth/facebook')}}" class="btn btn-facebook custom-social-facebook m-b-20 btn-sm waves-effect waves-light"><i class="icofont icofont-social-facebook"></i>facebook</a>
                                    </div>
                                </div>
                                <div class="row m-t-20">
                                    <div class="col-md-12">
                                        <button  type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20 theme-outline-btn">LOGIN</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                       <p class="text-inverse text-left">Don't have an account?<a href="{{url('register')}}" style="color: #0d665c"> <b>Register here </b></a></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text-inverse text-right"><a target="_blank"  style="color: #0d665c" onclick="saveSession()" href="https://stitchersstudio.com/website/support/help-articles/"> <b>Help? </b></a></p>
                                    </div>
                                </div>
                                
                                
                            </div>
                        </div>
                        <input type="hidden" name="previous" value="{{ str_replace(url('/'), '', URL::previous())}}">
                    </form>
                        <!-- end of form -->

                    </div>
@endsection
@section('footersection')
<link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
<script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

<style type="text/css">
.red{
	color: #bc7c8f;
	font-weight:bold;
	font-size: 12px;
}
    .pophover{
            position: absolute;
    top: 15px;
    font-size: 11px;
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
</style>

<script type="text/javascript">
    $(function () {
  $('[data-toggle="popover"]').popover();

	$('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: '', //fa fa-check
                invalid: '', //fa fa-exclamation
                validating: 'fa fa-spinner fa-spin'
            },
            fields: {
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The username / email field is required.'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'The password field is required.'
                        }
          
          
                    }
                },

            }
        }).on('status.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(false);
        });

});


    $(".toggle-password").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});

function saveSession(){
    localStorage.setItem('session','mediaLogin');
}

</script>
@endsection
