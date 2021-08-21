@extends('layouts.shopping')
@section('title','Checkout')
@section('content')
 <section class="section-b-space light-layout">
    <div class="container">
        <div class="row card">
            <div class="col-md-12">
                <div class="success-text p-t-20"><i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2>Thank you</h2>
                    <!-- <p>Payment is successfully processsed and your order is on the way</p> -->

                </div>
                <br>
                <div class="success-text p-b-20">
                    <h3><b>Ready to start knitting?</b></h3>
                    <!-- <p class="m-t-20">Add <a href="../../Knitter/Nini/Measurement.html" >Measurements </a> to start project |                                                             Visit <a href="../../Knitter/Nini/Timeline.html" >Projects</a> Library </p> -->
                    <a href="{{url('shop-patterns')}}" class="btn theme-outline-btn waves-effect waves-light m-l-20 m-b-20 m-t-20">Continue shopping</a>
                    <a href="{{url('knitter/project-library')}}" class="btn theme-btn waves-effect waves-light m-l-20 m-b-20 m-t-20">Create a project</a>
                    <p>You'll need a measurement profile to get started on a custom pattern. Go to <a href="{{url('knitter/measurements')}}"><u>Measurement profiles.</a></u></p>
                </div>
            </div>
        </div>
    </div>
</section>


                                        <!-- Section ends -->
<!-- order-detail section start -->
<section class="section-b-space" id="DivIdToPrint">
    <div class="container card p-40">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="m-b-20 m-t-20" style="color: black;">Your order details</h3>
            </div>
            <div class="col-lg-6">
                <div class="product-order p-t-30">
                    <div class="checkout-details">
                        <div class="order-box">
                            <div class="title-box">
                                <table class="mytable" style="width: 100%;">
                                    <thead>
                                      <tr style="border-bottom: 1px solid #dddddd;margin-bottom:20px">
                                        <th></th>
                                        <th style="text-align: left;">Product</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    	@if($booking_process->count() > 0)
                                    	@foreach($booking_process as $bp)
<?php
	$image = DB::table('product_images')->where('product_id',$bp->product_id)->first();
	if($image){
		$im = $image->image_small;
	}else{
		$im = 'https://via.placeholder.com/150';
	}
?>
                                      <tr>
                                          <td><img src="{{$im}}" alt="" class="img-fluid img-60 blur-up lazyload"></td>
                                        <td>{{ucfirst($bp->product_name)}}</td>
                                        <td align="center">{{$bp->product_quantity}}</td>
                                        <td align="center">${{number_format($bp->setpayment,2)}}</td>
                                      </tr>
                                      @endforeach
                                      @endif
                                      <tr>
                                        <th>Subtotal</th>
                                        <th></th>
                                        <th colspan="2" style="text-align: right;">${{number_format($orders->ordered_amt,2)}}</th>
                                    </tr>
                                    <tr>
                                        <th>Shipping</th>
                                        <th></th>
                                        <th colspan="2" style="text-align: right;">$0.00</th>
                                    </tr>
                                        <tr>
                                            <th>Tax</th>
                                            <th></th>
                                            <th colspan="2" style="text-align: right;">$0.00</th>
                                        </tr>

                                    <tr style="border-top: 1px solid #a4a4a4;">
                                        <th>Total</th>
                                        <th></th>
                                        <th colspan="2" style="text-align: right;">${{number_format($orders->ordered_amt,2)}}</th>
                                    </tr>
                                      </tbody>
                                      </table>
                            </div>

                    </div>
                </div>

            </div>
            </div>
            <div class="col-lg-6">
                <div class="row order-success-sec p-t-40 m-l-25">
                    <div class="col-sm-6">
                        <h5 class="f-w-500 m-b-10">Summary</h5>
                        <ul class="order-detail">
                            <li>Order ID: {{$orders->order_number}}</li>
                            <li>Transaction ID: {{$orders->receiverTransactionId}}</li>
                            <li>Order date: {{date('M d, Y')}}</li>
                            <li>Order total: ${{$orders->ordered_amt}}</li>
                        </ul>
                    </div>
                    <?php
                    $address = App\Models\UserAddress::where('id',$orders->address_id)->first();
                     ?>
                    <div class="col-sm-6">
                        <h5 class="f-w-500 m-b-10">Shipping address</h5>
                        <ul class="order-detail">
                            <li>{{ucfirst($address->first_name)}} {{$address->last_name}}</li>
                            <li>{{$address->address}},{{$address->city}}</li>
                            <li>{{$address->country}},{{$address->zipcode}}</li>
                            <li>Contact No. {{$address->mobile}}</li>
                        </ul>
                    </div>
                    <div class="col-sm-12 payment-mode m-t-20">
                        <h5 class="f-w-500 m-b-10">Payment method</h5>
                        <p>{{ucfirst($orders->payment_type)}}</p>
                    </div>
                    <!-- <div class="col-md-12">
                        <div class="delivery-sec">
                            <h4>Expected date of delivery</h4>
                            <h3>October 22, 2018</h3></div>
                    </div> -->
                </div>
            </div>
            <a href="{{ url('print/'.$orders->order_number) }}" target="_blank" class="btn theme-btn">Print</a>
        </div>
    </div>
</section>
@endsection
@section('footerscript')
<script>

    /*
    function printDiv()
    {

        var divToPrint=document.getElementById('DivIdToPrint');
        var newWin=window.open('','Print-Window');
        newWin.document.open();
        newWin.document.write('<html><head><link rel="stylesheet" type="text/css" href="https://knitfitnew' +
            '.test/resources/assets/files/bower_components/bootstrap/css/bootstrap.min.css" media="all"> <link ' +
            'rel="stylesheet" type="text/css" href="https://knitfitnew.test/resources/assets/files/assets/css/pages' +
            '.css" media="all"></head><body onload="window.print()">'+divToPrint
            .innerHTML+'</body></html>');
        newWin.document.close();
        setTimeout(function(){newWin.close();},10);
    }*/
</script>
@endsection
