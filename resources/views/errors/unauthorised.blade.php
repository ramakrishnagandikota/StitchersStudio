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
           <!-- <div class="row m-b-10">
            	<div class="col-md-3"></div>
                <div class="col-md-5">
                	<img src="{{asset('resources/assets/maintanance-icon.png')}}" class="card-img" alt="...">
                </div>
            </div>-->

            <div class="row">
            	<div class="col-md-12">
                	<h5 class="text-center txt-primary">Unauthorized</h5>
                </div>
                <br><br>
                <div class="col-md-12">
                <p style="text-align: justify;font-size: 15px;">
                	<a href="{{utl('knitter/projects')}}" class="btn btn-primary">Go back to projects</a>
                </p>
            </div>
            </div>

	
        </div>
    </div>
</div>
@endsection