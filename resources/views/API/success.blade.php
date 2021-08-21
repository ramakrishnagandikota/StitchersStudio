@extends('layouts.Api')
@section('title','My Connections')
@section('content')

<div class="page-body">
    <div class="row">
        <div class="col-xl-12">
            <!-- To Do Card List card start -->
            <div class="card payment-box text-center" style="padding: 10px;">
                <i class="fa fa-check-circle success-text" aria-hidden="true"></i>
                <h2 class="theme-text">Thank you</h2>
                <p>Payment is successfully processsed.Please check your orders.</p>
                <p>Reference Id : {{$order_id}}</p>
				<p class="text-center">
				<button  class="btn btn-success theme-btn btn-icon  waves-effect waves-light" onclick="OpenMyWin();">Back to app</button>
				</p>
            </div>
            <!-- To Do Card List card end -->
        </div>
</div>
</div>
@endsection

@section('footersection')

@endsection
