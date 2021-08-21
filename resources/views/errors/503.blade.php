<!--extends('errors::minimal')

section('title', __('Service Unavailable'))
section('code', '503')
section('message', __($exception->getMessage() ?: 'Service Unavailable'))
-->
@extends('layouts.app')
@section('title','Maintenance')
@section('content')
<div class="col-sm-12">
	<div class="text-center">
        <a href="{{url('/')}}"><img src="{{ asset('resources/assets/files/assets/images/logoNew.png') }}" class="theme-logo" alt="logo.png"></a>
    </div>

    <div class="auth-box card">
        <div class="custom-padding">
            <div class="row m-b-10">
            	<div class="col-md-3"></div>
                <div class="col-md-5">
                	<img src="{{asset('resources/assets/maintanance-icon.png')}}" class="card-img" alt="...">
                </div>
            </div>

            <div class="row">
            	<div class="col-md-12">
                	<h5 class="text-center txt-primary">MAINTENANCE NOTIFICATION</h5>
                </div>
                <br><br>
                <div class="col-md-12">
                <p style="text-align: justify;font-size: 15px;">
                	Please note that we will be performing important server maintenance on {{date('dS F')}} from 11PM to {{date('dS F')}} 11AM EDT, during which time the server will be unavailable.</p> 
                	<!--<p style="text-align: justify;font-size: 15px;"> If you are in the middle of something important, please save your work or hold off on any critical actions until we are finished.-->
                </p>
            </div>
            </div>

	
        </div>
    </div>
</div>
@endsection