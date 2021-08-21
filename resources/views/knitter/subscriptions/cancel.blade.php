@extends('layouts.knitterapp')
@section('title','Subscriptions')
@section('content')
<div class="pcoded-wrapper">

<div class="pcoded-content">
  
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">
                        <div class="col-xl-12">
                            <!-- To Do Card List card start -->
                            <div class="card payment-box text-center p-40">
                                <i class="fa fa-times-circle failure-text" aria-hidden="true"></i>
                                <h2 class="theme-text-danger">Payment failed</h2>
                                <!-- <p>Payment could not processsed.</p> -->
                                <p><strong>Your subscription payment has failed. To make payment now,click below</strong></p>
                                <p><button type="button" onClick="location.href='{{url("knitter/subscription")}}'" class="btn btn-sm theme-outline-btn">&nbsp;&nbsp;Retry&nbsp;&nbsp;</button></p>
                        </div>
                            <!-- To Do Card List card end -->
                        </div>
                        
                    </div>
                   
                </div>
                <!-- Page-body end -->
            </div>
        </div>
    </div>
</div>
<!-- Main-body end -->

</div>
@endsection
@section('footerscript')
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
@endsection