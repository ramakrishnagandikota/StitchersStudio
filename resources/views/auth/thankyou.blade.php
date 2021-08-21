@extends('layouts.app')
@section('title','Sign-Up')
@section('content')

<div class="col-sm-12">
<!-- Authentication card start -->
<form class="md-float-material form-material">
    <div class="text-center">
        <a href="{{env('STITCHERS_STUDIO_URL')}}"><img src="{{ asset('resources/assets/files/assets/images/logoNew.png') }}" class="theme-logo" alt="logo.png"></a>
    </div>
    <div class="auth-box card">
        <div class="custom-padding">
            <!-- <p class="text-muted text-center p-b-5">Sign in with your regular account</p> -->
           <div class="row">
                <div class="col-lg-12 p-20">
                    <h2 class="text-center">Thank you for signing up!</h2>
                    @if(Session::has('resend'))
                    <p class="m-t-20 f-14 f-w-500">Please check you email to activate your account. Click here to <a href="{{url('resend-email/'.md5(Session::get('resend')))}}"><span style="color: #0d665c">resend email.</span></a></p>
                    @endif
                </div>
            </div>
            <div class="row m-t-0">
                <div class="col-md-12">
                    <a href="{{url('login')}}" id="login-button" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20 theme-outline-btn">LOGIN</a>
                </div>
                <div class="col-lg-8">
                    <p class="text-inverse text-left">Don't have an account?<a href="{{url('register')}}" style="color: #0d665c"> <b>Register here </b></a></p>
                </div>
                <div class="col-lg-4">
                    <a href="https://stitchersstudio.com/website/support/help-articles/" style="color: #0d665c" class="pull-right"> <b>Help?</b></a>
                </div>
            </div>
            
        </div>
    </div>
</form>
    <!-- end of form -->
</div>
@endsection
@section('footersection')
<script type="text/javascript">
	var session = '{{Session::has('resend')}}';
	if(!session){
		window.location.assign('{{url("login")}}');
	}
</script>
@endsection