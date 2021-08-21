@extends('layouts.shopping')
@section('title','Add new address')
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
<h4 class="card-header m-b-10">Account</h4>
<ul>
        <li class="" ><a href="{{url('wishlist')}}">Wishlist</a></li>
        <li class="" ><a href="{{url('cart')}}">Cart</a></li>
        <li><a href="{{url('change-password')}}">Change Password</a></li>
        <li><a href="{{url('my-orders')}}">My orders</a></li>
        <li class="" ><a href="{{url('my-account')}}">Newsletter info</a></li>
        <li class="active"><a href="{{url('my-address')}}">Address</a></li>
    </ul>
</div>
</div>
</div>

<div class="col-lg-9">
<div class="checkout-page">
<div class="checkout-form">
<form action="{{url('add-address')}}" method="POST">
	@csrf
<div class="row">
    <div class="card col-md-10 offset-lg-1 p-20">
        <div class="checkout-title  text-center">
            <h3>Add new address</h3></div>
        <div class="row check-out">
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">First name</div>
                <input type="text" name="first_name" value="" placeholder="">
                <span class="red">{{$errors->first('first_name')}}</span>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Last name</div>
                <input type="text" name="last_name" value="{{old('last_name')}}" placeholder="">
                <span class="red">{{$errors->first('last_name')}}</span>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Phone</div>
                <input type="text" name="mobile" value="{{old('mobile')}}" placeholder="">
                <span class="red">{{$errors->first('mobile')}}</span>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Email address</div>
                <input type="text" name="email" value="{{old('email')}}" placeholder="">
                <span class="red">{{$errors->first('email')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Country</div>
                <select name="country">
                    <option value="">Please select country</option>
                    @foreach($country as $cntry)
                    <option value="{{$cntry->nicename}}">{{$cntry->nicename}}</option>
                    @endforeach
                </select>
                <span class="red">{{$errors->first('country')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Address</div>
                <input type="text" name="address" value="{{old('address')}}" placeholder="Street address">
                <span class="red">{{$errors->first('address')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Town/City</div>
                <input type="text" name="city" value="{{old('city')}}" placeholder="">
                <span class="red">{{$errors->first('city')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                <div class="field-label">State / County</div>
                <input type="text" name="state" value="{{old('state')}}" placeholder="">
                <span class="red">{{$errors->first('state')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                <div class="field-label">Postal code</div>
                <input type="text" name="zipcode" value="{{old('zipcode')}}" placeholder="">
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