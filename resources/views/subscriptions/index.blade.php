@extends('layouts.shopping')
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
                        <div class="col-xl-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="card prod-view">
                                <div class="prod-item text-center">
                                    <div class="prod-img free">
                                        <h5>Free</h5>
                                    </div>
                                    <div class="prod-info">
                                        <h4>$ 0</h4>
                                        <h6>per month</h6>
                                    </div>
                                    <div class="m-b-10">
                                        <hr>
                                        <h6>Knitter's Academy-User education</h6>
                                        <h6>Social media</h6>
                                        <h6>Shopping</h6>
                                        <h6>Custom sized patterns</h6>
                                        <h6>Custom profile measurement limit upto 1</h6>
                                        <h6>Project management limit upto 1</h6>
                                    </div>
                                </div>
                                @if(Auth::user()->subscription_type == 2)
                                <button type="button" class="btn theme-outline-btn btn-md">NA</button>
                                @elseif(Auth::user()->subscription_type == 1)
                                <button type="button" class="btn theme-outline-btn btn-md">Your subscription</button>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="card prod-view">
                                <div class="prod-item text-center">
                                    <div class="prod-img basic">
                                        <h5>Basic</h5>
                                    </div>
                                    <div class="prod-info basic-body">
                                        <h4>$ 2.99</h4>
                                        <h6>per month</h6>
                                    </div>
                                    <div class="m-b-10 m-t-15">
                                      <h6>Knitter's Academy-User education</h6>
                                      <h6>Social media</h6>
                                      <h6>Shopping</h6>
                                      <h6>Custom sized patterns</h6>
                                      <h6>Custom profile measurement limit upto 5</h6>
                                      <h6>Project management No limit</h6>
                                      <h6>Stash management</h6>
                                      <h6>Stash sales</h6>
                                      <h6>Groups</h6>
                                      <h6>Live events</h6>
                                      <h6>Knit-alongs</h6>
                                    </div>
                                </div>
                                @if(Auth::user()->subscription_type == 2)
                                <button type="button" class="btn theme-outline-btn btn-md">Your subscription</button>
                                @else
                                <button type="button" class="btn theme-outline-btn btn-md SubscriptionType" data-id="2" data-toggle="modal" data-target="#subscribeModal">Upgrade</button>
                                @endif
                            </div>
                        </div>
                       <!-- <div class="col-xl-4 col-md-6 col-sm-6 col-xs-12">
                            <div class="card prod-view">
                                <div class="prod-item text-center">
                                    <div class="prod-img premium">
                                        <h5>Premium</h5>
                                    </div>
                                    <div class="prod-info premium-body">
                                        <h4>$$</h4>
                                        <h6>per month</h6>
                                    </div>
                                    <div class="m-b-10 m-t-15">
                                      <h6>Feature 1</h6>
                                      <h6>Feature 2</h6>
                                      <h6>Feature 3</h6>
                                      <h6>Feature 4</h6>
                                      <h6>Feature 5</h6>
                                      <h6>Feature 6</h6>
                                      <h6>Feature 7</h6>
                                      <h6>Feature 8</h6>
                                      <h6>Feature 9</h6>
                                      <h6>Feature 10</h6>
                                      <h6>Feature 11</h6>
                                    </div>
                                </div>
                                <button type="button" class="btn theme-outline-btn btn-md">Upgrade</button>
                            </div>
                        </div> -->
                    </div>
                    </div>
                </div>
                <!-- Page-body end -->
            </div>
        </div>
    </div>
</div>
<!-- Main-body end -->


 <!-- Modal -->
 <div class="modal fade" id="subscribeModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="m-r-15">
            <h5 class="modal-title m-l-15 p-t-15">Select your subscription<button type="button" class="close" data-dismiss="modal">&times;</button></h5>
            <hr>
        </div>
        <div class="modal-body p-30">
          <input type="hidden" id="subscription" value="">
          <div class="row">
              <div class="col-lg-6">
                <div class="checkbox-color checkbox-primary">
                    <input id="checkbox18" class="checkme" type="checkbox" onchange="valueChanged()" >
                    <label for="checkbox18">
                        Yearly subscription
                    </label>
                </div>
             </div>
             <div class="col-lg-6">
                <div class="checkbox-color checkbox-primary">
                    <input id="checkbox1" class="checkme" onchange="show2()" type="checkbox">
                    <label for="checkbox1">
                        Monthly subscription
                    </label>
                </div>
             </div>
              <div id="div1" class="col-lg-12">
                  <div class="col-lg-12"><hr></div>
                <div class="col-md-12">
                    <div class="form-radio">
                    <div class="radio radio-inline">
                      
                        <label>
                            <input type="radio" name="radio" id="recurring" checked="checked">
                            <i class="helper"></i><span class="radio-text">Recurring payment monthly</span>
                        </label>
                    </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="form-radio">
                    <div class="radio radio-inline">
                            <label>
                                <input type="radio" id="onetime" name="radio">
                                <i class="helper"></i><span class="radio-text">One time</span>
                            </label>
                    </div>
                    </div>
                </div>  
          </div>
            <div class="text-center col-lg-12 m-t-20">
                <!-- <button type="button" class="btn btn-default theme-outline-btn m-r-20" data-dismiss="modal">Cancel</button> -->
                <button type="button" class="btn btn-default theme-btn" id="continue" data-dismiss="modal">Continue</button>
              </div>
          </div>
          </div>
        </div>
       
      </div>
      
    </div>
@endsection
@section('footerscript')

	<style>
  p,label{font-family:"californian-fb-display, serif"}

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
.basic{background-color: #bc7c8f !important;color: white;padding-top: 14px;padding-bottom: 8px;background-image: linear-gradient(-180deg, #bc7c8f,#0000001a);;}
.basic-body{background-color: #bc7c8f !important;color: white;}
.premium{background-color: #0d665b !important;color: white;padding-top: 14px;padding-bottom: 8px;background-image: -webkit-linear-gradient(#0d665b, #0000001a);background-image: -o-linear-gradient(#0d665b, #0000001a);background-image: linear-gradient(#0d665b, #0000001a);}
.premium-body{background-color: #0d665b !important;color: white;}
h4{padding-top: 10px;}
.basic-body h6,.premium-body h6{padding-bottom: 20px;}
.prod-view{padding:4px;}
h6{margin-bottom: 20px;}
	</style>

<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

<script type="text/javascript">
 $("#div1").hide();
 $('#continue').attr('disabled', true);
    function valueChanged()
    {
        if($('#checkbox18').is(":checked"))  
        {
            $("#div1").show();
            document.getElementById("checkbox1").disabled = true;
        } 
           
        else
        {
            $("#div1").hide();
            document.getElementById("checkbox1").disabled = false;
            
        }
            
    }

    function show2(){
    	if($('#checkbox1').is(":checked"))  
        {
            document.getElementById("checkbox18").disabled = true;
        }else{
        	document.getElementById("checkbox18").disabled = false;
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
    $("#subscription").val(id);
  });

	$(document).on('click','#continue',function(){
	if($('#checkbox18').is(":checked")) {
        var sub_type = 'yearly';
    }else{
        var sub_type = 'monthly'
    }

    if($('#recurring').is(":checked")) {
        var mode = 'recurring';
    }else{
        var mode = 'no'
    }

    var subscription = $("#subscription").val();

   var url = '{{url("knitter/paypal/ec-checkout/")}}?stype='+sub_type+'&mode='+mode+'&subscription='+subscription;
   window.location.assign(url);
});

});


</script>
@endsection