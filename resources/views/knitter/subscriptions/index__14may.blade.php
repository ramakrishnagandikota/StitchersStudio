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
                            <div class="col-lg-12">
                                <h5 class="theme-heading m-b-20">Subscribe now</h5>
                            </div>
                        </div>
                        <!-- <h5 class="m-b-20">Knitter's Subscription</h5> -->
                        <div class="card p-20">
                        <div class="row">
                            <div class="col-lg-12" id="subscription-div">
                             <div class="table-responsive" style="display:inline">
<table class="table table-styling table-info" id="subscription-table">
    <thead>
        <tr>
            <th class="t-heading f-20" style="width: 40%;text-align: center;vertical-align: middle;">Features</th>
      @foreach($subscriptions as $sub)

        <th class="t-heading Free" style="text-align: center;width: 25%;padding: -.5rem 0.75rem;">@if($sub->name == 'Free') Free trial @elseif($sub->name == 'Basic') Knitter's subscription @endif<br>
            @if($sub->offer_price)
        <h4>${{$sub->price_month}}<span class="f-12">/mo<br>or {{$sub->offer_price}}/yr (30% off)<br></span></h4>
            @else
            <h4>${{$sub->price_month}}<span class="f-12">/mo<br><br></span></h4>
            @endif

            @if($sub->id == 1)
            @if(Auth::user()->isFree())
            <button type="button" class="btn theme-btn btn-md">Your subscription</button>
            @else
            <button type="button" class="btn theme-outline-btn btn-md p-40">NA</button>
            @endif
            @endif

            @if($sub->id == 2)
            @if(Auth::user()->isBasic())
            <button type="button" class="btn theme-btn btn-md">Your subscription </button>
            @else
            <button type="button" class="btn theme-outline-btn btn-md p-40 SubscriptionType" data-id="{{$sub->id}}" data-price1="{{$sub->price_month}}" data-price2="{{$sub->price_year}}" data-price3="{{$sub->offer_price}}" data-name="{{$sub->name}}" data-toggle="modal" data-target="#subscribeModal{{$sub->id}}">Upgrade</button>
            @endif
            @endif
        </th>

       @endforeach

        </tr>
    </thead>
    <tbody>
        <tr>
            <th>KnitFit Academy-Knitter Education</th>
            <td class="text-center Free"><i class="fa fa-check green-checkmark"></i></td>
            <td class="text-center Basic"><i class="fa fa-check green-checkmark"></i></td>

        </tr>
        <tr>
            <th>Connect-Social Media</th>
            <td class="text-center Free"><i class="fa fa-check green-checkmark"></i></td>
            <td class="text-center Basic"><i class="fa fa-check green-checkmark"></i></td>

        </tr>
        <tr>
            <th>Shopping</th>
            <td class="text-center Free"><i class="fa fa-check green-checkmark"></i></td>
            <td class="text-center Basic"><i class="fa fa-check green-checkmark"></i></td>

        </tr>
        <tr>
            <th>Custom Patterns</th>
            <td class="text-center Free"><i class="fa fa-check green-checkmark"></i></td>
            <td class="text-center Basic"><i class="fa fa-check green-checkmark"></i></td>

        </tr>
        <tr>
            <th>Measurements-Store Measurement Profiles</th>
            <td class="text-center Free">1</td>
            <td class="text-center Basic">Unlimited</td>

        </tr>
        <tr>
            <th>Project Library-Manage projects</th>
            <td class="text-center Free">1</td>
            <td class="text-center Basic">Unlimited</td>

        </tr>
    </tbody>
</table>
                             </div>
                            </div>
                        </div>
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
  <!-- Style.css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/Marketplace/css/Marketplace.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
<style>
    .checkbox-primary input[type="checkbox"]:checked+label::before {
    background-color: #0d665c;
}
.checkbox-primary input[type="checkbox"]:checked+label::before {
    background-color: #0d665c;
    border-color: #0d665c
}
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
body{background-color: #faf9f8;}
.centered-block{float: none;display: block;margin: 0 auto;}

.theme-btn{padding: 10px;}
.nav-tabs .slide {
    background: #0d665c;
}
.md-tabs .nav-item a {
    padding: 4px 0;
    font-size: 16px;
}
.table td, .table th,.table tr {
    border: 1px solid #b5b3b3;
}
.table td, .table th{padding: .80rem .40rem;}
.table-styling .table-info thead, .table-styling.table-info thead{border-bottom: 1px solid #b5b3b3;}
/* Track */
::-webkit-scrollbar-track {
  background: white;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #0d665c;
  border-radius: 6px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #0d665c;
}
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
