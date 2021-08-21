@extends('layouts.Api')
@section('title','My Connections')
@section('content')

<div class="page-body">
    <div class="row">
        <div class="col-xl-12">
            <!-- To Do Card List card start -->
			@if($success)
            <div class="card payment-box text-center" style="padding: 10px;">
                <i class="fa fa-check-circle success-text" aria-hidden="true"></i>
                <h2 class="theme-text">Thank you</h2>
                <p>Your subscription is successfully updated.</p>
            </div>
			@endif
			
			
			@if($faild)
            <div class="card payment-box text-center" style="padding: 10px;">
                <i class="fa fa-check-circle danger-text" aria-hidden="true"></i>
                <h2 class="theme-text">Oops!</h2>
                <p>You payment has faild.</p>
				<a href="javascript:;"  class="btn btn-success theme-btn btn-icon  waves-effect waves-light" onclick="OpenMyWin();">Back to app</a>
            </div>
			@endif
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
