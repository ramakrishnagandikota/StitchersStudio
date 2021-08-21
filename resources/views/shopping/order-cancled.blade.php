@extends('layouts.shopping')
@section('title','Checkout')
@section('content')
<section class="section-b-space light-layout">
    <div class="container">
        <div class="row card">
            <div class="payment-box text-center p-40">
                <i class="fa fa-times-circle failure-text" aria-hidden="true"></i>
                <h2 class="theme-text-danger">Payment cancled</h2>
                <!-- <p>Payment could not processsed.</p> -->
                <p class="m-t-15">Payment could not processed !</p>
                    <p>Transaction ID:{{$orders->order_number}}</p>
                <p><a href="{{ url('retry/order/'.$orders->order_number) }}"
                      class="btn btn-sm theme-outline-btn">&nbsp; Retry&nbsp;payment</a></p>
                <!-- <p><button type="button" onClick="location.href='index.html'" class="btn btn-sm theme-outline-btn">&nbsp;&nbsp;Retry&nbsp;&nbsp;</button></p> -->
                <p></p><a href="{{url('shop-patterns')}}" class="btn theme-outline-btn waves-effect waves-light m-l-20 m-b-10 m-t-20">Continue shopping</a></p>
        </div>
        </div>
    </div>
</section>
@endsection
@section('footerscript')

@endsection
