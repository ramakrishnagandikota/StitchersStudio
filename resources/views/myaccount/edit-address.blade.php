@extends('layouts.shopping')
@section('title','Edit address')
@section('content')

<section class="section-b-space">
<div class="container">
	@if(Session::has('error'))
	<div class="alert alert-danger">
		{{Session::get('error')}}
	</div>
	@endif
<div class="row">
<div class="col-lg-3">
<div class="account-sidebar"><a class="popup-btn">my account</a></div>
<div class="dashboard-left">
<div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
<div class="card block-content">
<h4 class="card-header m-b-10" >Account</h4>
@include('layouts.myaccount-menu')
</div>
</div>
</div>

<div class="col-lg-9">
<div class="checkout-page">
<div class="checkout-form">
<form action="{{url('update-address')}}" method="POST">
	@csrf
    <input type="hidden" name="id" value="{{base64_encode($add->id)}}">
<div class="row">
    <div class="card col-md-10 offset-lg-1 p-20">
        <div class="checkout-title  text-center">
            <h3>Edit address</h3></div>
        <div class="row check-out">
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">First name</div>
                <input type="text" name="first_name" value="{{$add->first_name}}" placeholder="">
                <span class="red">{{$errors->first('first_name')}}</span>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Last name</div>
                <input type="text" name="last_name" value="{{$add->last_name}}" placeholder="">
                <span class="red">{{$errors->first('last_name')}}</span>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Phone</div>
                <input type="text" name="mobile" value="{{$add->mobile}}" placeholder="">
                <span class="red">{{$errors->first('mobile')}}</span>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Email address</div>
                <input type="text" name="email" value="{{$add->email}}" placeholder="">
                <span class="red">{{$errors->first('email')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Country</div>
                <select name="country">
				<option value="">Please select country</option>
                    @foreach($country as $cntry)
                    <option value="{{$cntry->nicename}}" @if($add->country == $cntry->nicename) selected @endif >{{$cntry->nicename}}</option>
                    @endforeach
                </select>
                <span class="red">{{$errors->first('country')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Address</div>
                <input type="text" name="address" value="{{$add->address}}" placeholder="Street address">
                <span class="red">{{$errors->first('address')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Town/City</div>
                <input type="text" name="city" value="{{$add->city}}" placeholder="">
                <span class="red">{{$errors->first('city')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                <div class="field-label">State / County</div>
                <input type="text" name="state" value="{{$add->state}}" placeholder="">
                <span class="red">{{$errors->first('state')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                <div class="field-label">Postal code</div>
                <input type="text" name="zipcode" value="{{$add->zipcode}}" placeholder="">
                <span class="red">{{$errors->first('zipcode')}}</span>
            </div>
            <!-- <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input type="checkbox" name="shipping-option" id="account-option"> &ensp;
                <label for="account-option">Create An Account?</label>
            </div> -->
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
            	<input type="submit" name="submit" class="btn theme-btn waves-effect waves-light" value="Add address">
            </div>
        </div>
    </div>
    
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection
@section('footerscript')
<style type="text/css">
	.red{
		color: #bc7c8f;
    font-weight: 500;
	}
	.myaccount{
        display: none;
    }
</style>
@endsection