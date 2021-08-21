@extends('layouts.shopping')
@section('title','My address')
@section('content')

<section class="section-b-space">
<div class="container">
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
    @endif

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
<div class="dashboard-right">
<div class="dashboard">
<div class="page-title">
<h2>Billing address</h2></div>
<div class="box-account box-info">
<div class="row">
    <div class="col-sm-6">
        <div class="card">
           <a href="{{url('add-address')}}">
            <div class="box-content text-center pad">
                    <i class="fa fa-plus"></i>
                <h3 class="m-t-20 m-b-15">Add address </h3>
            </div>
        </a>
        </div>
    </div>

    @if($address->count() > 0)
    @foreach($address as $add)
    <div class="col-sm-6">
        <div class="card setActive">
            <div class="box-title">
                <h4>{{ucwords($add->first_name)}} {{ucwords($add->last_name)}} </h4><a href="{{url('edit-address/'.base64_encode($add->id))}}"><u>Edit</u></a> | <a onclick="if(!confirm('Are you sure want to delete this address ?')){ return false; }" href="{{url('delete-address/'.base64_encode($add->id))}}"><u>Delete</u></a></div>
            <div class="box-content">
                <h6>{{$add->address}},{{$add->city}},{{$add->state}},{{$add->country}} - {{$add->zipcode}}</h6>
                <h6>{{$add->email}}</h6>
                @if($add->is_default == 1)
                <h6><a href="javascript:;" ><u>Default</u></a></h6>
                @else
                <h6><a href="{{url('set-default/'.base64_encode($add->id))}}" data-id="{{$add->id}}"><u>Set as default</u></a></h6>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    <div class="clearfix"></div>
    <div class="col-md-12">
        <div style="margin:auto;"> {{$address->links()}} </div> 
    </div>
   
@endif


</div><br>

<!--
<div class="page-title">
        <h2>Shipping address</h2></div>
<div class="row">
        <div class="col-sm-6">
                <div class="card">
                   <a href="#">
                    <div class="box-content text-center pad">
                            <i class="fa fa-plus"></i>
                        <h3 class="m-t-20 m-b-15">Add address </h3>
                    </div>
                </a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card setActive">
                    <div class="box-title">
                        <h4>MARK JECNO </h4><a href="#"><u>Edit</u></a></div>
                    <div class="box-content">
                        <h6>115 EWS
                            New mukhrjee nagar
                            Dewas, Madhya Pradesh 455001
                            India</h6>
                        <h6>mark-jenco@gmail.com</h6>
                        <h6><a href="#"><u>Set as default</u></a></h6></div>
                </div>
            </div>
</div>
 -->
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
<style>
.myaccount{
        display: none;
    }
</style>
@endsection