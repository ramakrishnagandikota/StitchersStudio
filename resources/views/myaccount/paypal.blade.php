@extends('layouts.shopping')
@section('title','My account')
@section('content')
<!-- section start -->
@if(Session::has('success'))
<div class="alert alert-success">{{Session::get('success')}}</div>
@endif

@if(Session::has('fail'))
<div class="alert alert-danger">{{Session::get('fail')}}</div>
@endif



<section class="section-b-space">
    <div class="container">
        <div class="row">



            <div class="col-lg-3">
                <div class="account-sidebar"><a class="popup-btn">Paypal details</a></div>
                <div class="dashboard-left">
                    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                    <div class="block-content card">
					<h4 class="card-header m-b-10" >Account</h4>
                    @include('layouts.myaccount-menu')
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard card">
                        <div class="page-title">

                        <div class="box-account box-info">
                            <div class="box-head">
                                <h2>Account info</h2></div>
                            <div class="row">

<div class="col-sm-12">

<div class="box-content"><br>
    <div class="">
            <form class="theme-form" action="{{url('designer/update-paypal-credentials')}}" method="POST">
            	@csrf


              <div class="form-group col-md-6 m-b-20">
                  <label class="form-label">Store name</label>
                  <input type="text" name="store_name" id="store_name"
                         class="form-control paypal_credentials" placeholder="Store name" value="{{ $paypal ? $paypal->store_name : '' }}">
                  <span class="red store_name">{{ $errors->first('store_name') }}</span>
              </div>
              <div class="form-group col-md-6 m-b-20">
                <label class="form-label">Store status</label>
                <select name="store_status" id="store_status" class="form-control paypal_credentials">
                    <option value="">Please select store status</option>
                    @if($paypal)
                    <option value="1" @if($paypal->store_status == '1') selected @endif >Active</option>
                    <option value="0" @if($paypal->store_status == '0') selected @endif >Inactive</option>
                    @else
                    <option value="1" >Active</option>
                    <option value="0" >Inactive</option>
                    @endif
                </select>
                <span class="red store_status">{{ $errors->first('store_status') }}</span>
            </div>

            <div class="form-group col-md-6 m-b-20">
                <label class="form-label">Account type</label>
                <select name="account_type" id="account_type" class="form-control paypal_credentials">
                    <option value="">Please select account type</option>
                    @if($paypal)
                    <option value="personal" @if($paypal->account_type == 'personal') selected @endif >Personal</option>
                    <option value="business" @if($paypal->account_type == 'business') selected @endif >Business</option>
                    @else
                    <option value="personal" >Personal</option>
                    <option value="business" >Business</option>
                    @endif
                </select>
                <span class="red account_type">{{ $errors->first('account_type') }}</span>
            </div>

            <div class="form-group col-md-6 m-b-20">
                <label class="form-label">Paypal email</label>
                <input type="text" name="paypal_email" id="paypal_email"
                       class="form-control paypal_credentials" placeholder="Paypal email" value="{{ $paypal ? $paypal->paypal_email : '' }}">
                <small>This email will be used for receiving payments.Please enter
                    correct email.</small>
                <span class="red paypal_email">{{ $errors->first('paypal_email') }}</span>
            </div>

            <div class="form-group col-md-6 m-b-20">
                <label class="form-label">Re-enter paypal email</label>
                <input type="text" name="re_enter_paypal_email" id="re_enter_paypal_email"
                       class="form-control paypal_credentials" placeholder="Re-enter paypal email" value="">
                <small>This email will be used for receiving payments.Please enter
                    correct email.</small>
                <span class="red paypal_email">{{ $errors->first('re_enter_paypal_email') }}</span>
            </div>
                    
                        <button type="submit" class="btn theme-btn waves-effect waves-light" id="mc-submit-password">Submit paypal credentials</button>
                </form>
</div>
</div><br>

</div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>






<!-- section end -->
@endsection
@section('footerscript')
<style type="text/css">
                  #password-validation-box{ display: none; float: right;}
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
 
.myaccount{
        display: none;
    }
</style>
<script>
$(function(){
  $('#re_enter_paypal_email').bind("cut copy paste",function(e) {
     e.preventDefault();
 });
});
</script>
@endsection
