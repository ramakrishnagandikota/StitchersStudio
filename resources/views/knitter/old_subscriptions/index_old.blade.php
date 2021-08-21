@extends('layouts.knitterapp')
@section('title','Subscriptions')
@section('content')

<div class="pcoded-wrapper" id="dashboard">

<div class="pcoded-content">

    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <!-- Page-body start -->
                <div class="page-body">
                    <div class="row">

                @foreach($subscriptions as $sub)
                <?php
              $details = App\Models\SubscriptionProperties::where('subscriptions_id',$sub->id)->get();
                ?>

                        <div class="col-xl-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="card prod-view ">
                                <div class="prod-item text-center">
                                    <div class="prod-img @if($sub->name == 'Basic') basic @elseif($sub->name == 'Premium') premium @else free @endif">
                                        <h5>{{$sub->name}}</h5>
                                    </div>
                                    <div class="prod-info @if($sub->name == 'Basic') basic-body @elseif($sub->name == 'Premium') premium-body @else  @endif">
                                        <h4>$ {{$sub->price_month}}</h4>
                                        <h6>per month</h6>
                                    </div>
                                    <div class="m-b-10">

                                        @foreach($details as $det)
                                        <h6>{{$det->property_description}}</h6>
                                        @endforeach
                                    </div>
                                </div>

                                @if(Auth::user()->subscription_type == $sub->id)
                                  <button type="button" class="btn theme-outline-btn btn-md">Your subscription</button>
                                @endif

                                @if($sub->id > Auth::user()->subscription_type)
                                  <button type="button" class="btn theme-outline-btn btn-md SubscriptionType" data-id="{{$sub->id}}" data-price1="{{$sub->price_month}}" data-price2="{{$sub->price_year}}" data-price3="{{$sub->offer_price}}" data-name="{{$sub->name}}" data-toggle="modal" data-target="#subscribeModal{{$sub->id}}">Upgrade</button>
                                @endif

                                @if($sub->id < Auth::user()->subscription_type)
                                  <button type="button" class="btn theme-outline-btn btn-md">NA</button>
                                @endif


                            </div>
                        </div>

                  @endforeach


                    </div>
                    </div>
                </div>
                <!-- Page-body end -->
            </div>
        </div>
    </div>
</div>
<!-- Main-body end -->

@foreach($subscriptions as $subb)
 <!-- Modal -->
 <div class="modal fade" id="subscribeModal{{$subb->id}}" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="m-r-15">
            <h5 class="modal-title m-l-15 p-t-15">Select your subscription<button type="button" class="close" data-dismiss="modal">&times;</button></h5>
            <hr>
        </div>
        <div class="modal-body p-30">
          <input type="hidden" id="subscription{{$subb->id}}" value="">
          <div class="row">
              <div class="col-lg-6">
                <div class="checkbox-color checkbox-primary">
                    <input id="checkbox18{{$subb->id}}" class="checkme" type="checkbox" onchange="valueChanged({{$subb->id}})" >
                    <label for="checkbox18{{$subb->id}}">
                        Yearly subscription
                    </label>
                    <p class="text-center"><strong>${{$subb->price_year}}</strong></p>
                </div>
             </div>
             <div class="col-lg-6">
                <div class="checkbox-color checkbox-primary">
                    <input id="checkbox1{{$subb->id}}" class="checkme" onchange="show2({{$subb->id}})" type="checkbox">
                    <label for="checkbox1{{$subb->id}}">
                        Monthly subscription
                    </label>
                    <p class="text-center"><strong>${{$subb->price_month}}</strong></p>
                </div>
             </div>
              <div id="div1{{$subb->id}}" class="col-lg-12 div1">
                  <div class="col-lg-12"><hr></div>
                <div class="col-md-12">
                    <div class="form-radio">
                    <div class="radio radio-inline">

                        <label>
                            <input type="radio" name="radio" id="recurring{{$subb->id}}" checked="checked">
                            <i class="helper"></i><span class="radio-text">Recurring payment monthly (${{$subb->price_month}})</span>
                        </label>
                    </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-radio">
                    <div class="radio radio-inline">
                            <label>
                                <input type="radio" id="onetime{{$subb->id}}" name="radio">
                                <i class="helper"></i><span class="radio-text">One time
                                  (${{ ($subb->offer_price == 0) ? $subb->price_year : $subb->offer_price }})</span>
                            </label>
                    </div>
                    </div>
                </div>
          </div>
            <div class="text-center col-lg-12 m-t-20">
                <!-- <button type="button" class="btn btn-default theme-outline-btn m-r-20" data-dismiss="modal">Cancel</button> -->
                <button type="button" data-id="{{$subb->id}}" class="btn btn-default theme-btn" id="continue" data-dismiss="modal">Continue</button>
              </div>
          </div>
          </div>
        </div>

      </div>

    </div>

    @endforeach
@endsection
@section('footerscript')

	<style>
     p,label{font-family:"californian-fb-display, serif"}
     .prod-item .prod-info{ padding : 0px !important;}
.button-3:hover:hover {
background-color: #cc8b86 ;
border: 1px solid #cc8b86 ;
 padding: 3px 3px;
color: #fff !important;
}
#mainNav{background-color: white;background-color: white;
box-shadow: 2px 2px 2px #e6e4e4;}
.theme-logo{width: 110px;}
.container-fluid{padding-right: 60px;padding-left: 60px;}
.nav-link{font-weight: 600;text-transform: uppercase;letter-spacing: 2px;font-size: 12px;}
body{background-color: #faf9f8;}
.centered-block{float: none;display: block;margin: 0 auto;}
.form-radio{margin: 0 auto;}
.theme-btn{padding: 10px;}
.free{padding-top: 14px;padding-bottom: 8px;color: #0d665b;background-image: linear-gradient(-180deg, #ffffff,#0000001a);}
.basic{background-color: #bc7c8f;color: white;padding-top: 14px;padding-bottom: 8px;background-image: linear-gradient(-180deg, #bc7c8f,#0000001a);;}
.basic-body{background-color: #bc7c8f !important;color: white;}
.premium{background-color: #0d665b;color: white;padding-top: 14px;padding-bottom: 8px;background-image: linear-gradient(-180deg, #0d665b,#0000001a);}
.premium-body{background-color: #0d665b;color: white;}
h4{padding-top: 10px;}
.basic-body h6,.premium-body h6{padding-bottom: 20px;}
.prod-view{padding:4px;}
h6{margin-bottom: 20px;}
	</style>

<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

<script type="text/javascript">
 $(".div1").hide();
 $('#continue').attr('disabled', true);
    function valueChanged(id)
    {
        if($('#checkbox18'+id).is(":checked"))
        {
            $("#div1"+id).show();
            document.getElementById("checkbox1"+id).disabled = true;
        }

        else
        {
            $("#div1"+id).hide();
            document.getElementById("checkbox1"+id).disabled = false;

        }

    }

    function show2(id){
    	if($('#checkbox1'+id).is(":checked"))
        {
            document.getElementById("checkbox18"+id).disabled = true;
        }else{
        	document.getElementById("checkbox18"+id).disabled = false;
        }
    }

    $('.checkme').click(function () {
    //check if checkbox is checked
    if ($(this).is(':checked')) {

        $('#continue').removeAttr('disabled'); //enable input

    } else {
        $('#continue').attr('disabled', true); //disable input
    }
});

$(function(){

  $(document).on('click','.SubscriptionType',function(){
    var id = $(this).attr('data-id');
    $("#subscription"+id).val(id);
  });

	$(document).on('click','#continue',function(){
    $(".loading").show();
    var id = $(this).attr('data-id');
	if($('#checkbox18'+id).is(":checked")) {
        var sub_type = 'yearly';
    }else{
        var sub_type = 'monthly'
    }

    if($('#recurring'+id).is(":checked")) {
        var mode = 'recurring';
    }else{
        var mode = 'no'
    }

    var subscription = $("#subscription"+id).val();

   var url = '{{url("knitter/paypal/ec-checkout/")}}?stype='+sub_type+'&mode='+mode+'&subscription='+subscription;
   window.location.assign(url);
});

});


</script>
@endsection
