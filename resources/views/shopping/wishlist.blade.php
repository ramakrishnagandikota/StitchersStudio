@extends('layouts.shopping')
@section('title','My wishlist')
@section('content')

@if(Session::has('success'))
<div class="alert alert-success">{{Session::get('success')}}</div>
@endif

@if(Session::has('fail'))
<div class="alert alert-danger">{{Session::get('fail')}}</div>
@endif
<!-- section start -->
<section class="section-b-space">
<div class="container">
<div class="row">

<div class="col-lg-3">
                <div class="account-sidebar"><a class="popup-btn">Newsletter info</a></div>
                <div class="dashboard-left">
                    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                    <div class="block-content card">
                        <h4 class="card-header m-b-10">Account</h4>
                    <ul>
                        <li class="active" ><a href="{{url('wishlist')}}">Wishlist</a></li>
                        <li class="" ><a href="{{url('cart')}}">Cart</a></li>
                        <li><a href="{{url('change-password')}}">Change Password</a></li>
                        <li><a href="{{url('my-orders')}}">My orders</a></li>
                        <li  ><a href="{{url('my-account')}}">Newsletter info</a></li>
                        <li ><a href="{{url('my-address')}}">Address</a></li>
                    </ul>
                    </div>
                </div>
            </div>
			
			
<div class="col-lg-9">
<div class="dashboard-right">
<div class="dashboard card">
<div class="page-title">
    <h2>Wishlist <small>({{$wishlist->count()}})</small></h2></div>
<div class="box-account box-info">
    <div class="box">
@if($wishlist->count() > 0)
@foreach($wishlist as $wl)
<?php 
$image = DB::table('product_images')->where('product_id',$wl->proid)->first();
if($image){
	$im = $image->image_small;
}else{
	$im = 'https://via.placeholder.com/150';
}
?>
    <div class="row">
        <div class="col-sm-12">
                <div class="box-content m-t-10">
                    <div class="row">
                        <div class="col-sm-2">
                            <img src="{{$im}}" class="w">
                        </div>
                    <div class="col-sm-7">
                            <h6><a href="{{url('product/'.$wl->pid.'/'.$wl->slug)}}">{{$wl->product_name}}</a></h6>
                            <span>$@if($wl->sale_price) {{$wl->sale_price}} @else {{$wl->price}} @endif</span><br><br>
                           <!-- <button onclick="window.location.assign({{url('buynow/'.$wl->pid)}})" class="btn theme-btn btn-sm waves-effect waves-light" id="mc-submit">Buy now</button> -->
                    </div>
                    <div class="col-sm-3 m-auto text-center">
                            <i class="fa fa-heart heart" aria-hidden="true"></i><br>

                            <a href="{{url('remove-wishlist/'.$wl->id)}}">Remove item</a>
                    </div>
            </div>
        </div>
        </div>
    </div>



<div class="row">
    <div class="col-lg-12 m-t-10 m-b-10"><hr></div>
</div>
@endforeach
@else
<div class="m-auto">No products to show in wishlist.</div>
@endif
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

@endsection