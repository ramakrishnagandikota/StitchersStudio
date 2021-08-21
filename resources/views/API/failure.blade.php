@extends('layouts.Api')
@section('title','My Connections')
@section('content')

<div class="page-body">
    <div class="row">
        <div class="col-xl-12">
            <!-- To Do Card List card start -->
            <div class="card payment-box text-center p-40">
                <i class="fa fa-times-circle failure-text" aria-hidden="true"></i>
                <h2 class="theme-text-danger">Payment failed</h2>
                <!-- <p>Payment could not processsed.</p> -->
                <p><strong>Your payment has failed / cancled. </strong></p>
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
<script>
 function OpenMyWin() {
	 window.open('', '_self').close();
 }
 function closeWin() {

	 window.close();

 }
</script>
@endsection
