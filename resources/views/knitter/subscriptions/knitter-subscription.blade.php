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


                        @if(strtotime(date('Y-m-d',strtotime(Auth::user()->sub_exp))) != strtotime(date('Y-m-d',strtotime(Auth::user()->created_at))))
@if(Auth::user()->isSubscriptionExpired() == true)

@if(Auth::user()->remainingDays() <= 5)
  <div class="col-lg-12 alert @if($paypalsubscription) alert-success @else alert-danger @endif ">
You have only {{Auth::user()->remainingDays()}} days of subscription left.  

    @if($paypalsubscription)
        Your subscription renews on {{date('d/F/Y',strtotime(Auth::user()->sub_exp))}} .
        <a href="javascript:;" class="cancelSubscription" data-id="{{$paypalsubscription->subscription_id}}"><u>Click here</u></a> to cancel subscription.
    @else
        Your subscription ends on {{date('d/F/Y',strtotime(Auth::user()->sub_exp))}} .
    @endif

</div>
@else
<div class="col-lg-12 alert alert-success">
You have {{Auth::user()->remainingDays()}} days of subscription. 


    @if($paypalsubscription)
        Your subscription renews on {{date('d/F/Y',strtotime(Auth::user()->sub_exp))}} .
        <a href="javascript:;" class="cancelSubscription" data-id="{{$paypalsubscription->subscription_id}}"><u>Click here</u></a> to cancel subscription.
    @else
        Your subscription ends on {{date('d/F/Y',strtotime(Auth::user()->sub_exp))}} .
    @endif
</div>
@endif

@else
<div class="col-lg-12 alert alert-danger">
Your subscription is ended.
</div>
@endif
@else
<div class="col-lg-12 alert alert-danger">
You are in Free subscription. Upgrade subscription to avail all features.
</div>
@endif

@if(Session::has('success'))
<div class="col-lg-12 alert alert-success">
{{Session::get('success')}}
</div>

@endif

@if(Session::has('error'))
<div class="col-lg-12 alert alert-danger">
{{Session::get('error')}}
</div>
@endif

                        <!-- <h5 class="m-b-20">Knitter's Subscription</h5> -->
                        <div class="card p-20">
                        <div class="row">

                        	<div class="col-sm-4 col-lg-4 offset-lg-2 offset-md-2">
                                <div class="card text-center">
                                    <div class="card-header">
                                        <h2>Basic Knitter</h2>
                                        <span>$0.00/mo</span><br>
                                        <span style="font-size: 12px;visibility:hidden;">or 80.00/yr
                                            (30% off)</span>
                                    </div>
                                    <div class="card-body">
                                        <ul class="sub-table">
                                            <li><i
                                                class="fa fa-check-circle right-align"></i> Project Library :
                                            </li>

                                            <li class="sub-points">1 free KnitFit™ custom pattern</li>
                                            <li class="sub-points">1 Pattern pdf for mobile optimized use</li>
                                            <li class="sub-points">Manage up to 5 projects</li>
                                            <li>
                                                <i
                                                class="fa fa-check-circle right-align"></i>Measurements: Store 1 measurement profile
                                            </li>

                                            <li>
                                                <i
                                                class="fa fa-check-circle right-align"></i> Connect: Share photos, projects, and updates
                                            </li>

                                            
                                        </ul>
                                    </div>
                                    <div class="card-footer text-muted">
                                        @foreach($subscriptions as $sub)
                                        @if($sub->id == 1)
            @if(Auth::user()->isFree())
            <button type="button" class="btn theme-btn btn-md">Your subscription</button>
            @else
            <button type="button" class="btn theme-outline-btn btn-md p-40">NA</button>
            @endif
            @endif
            @endforeach
                                    <!--    
                                    <button
                                        class="btn btn-primary theme-btn btn-block">Try
                                        Free</button>-->
                                    </div>
                                  </div>
                            </div>
                                   
                            <div class="col-sm-4 col-lg-4">
                                <div class="card text-center">
                                    <div class="card-header">
                                        <h2>Premium Knitter</h2>
                                        <span>$2.99/mo</span><br>
                                        <span style="font-size: 12px;">or 24.99/yr
                                            (30% off)</span>
                                    </div>
                                    <div class="card-body">
                                        <ul class="sub-table">
                                            <li> <i
                                                class="fa fa-check-circle right-align"></i> Project Library :
                                            </li>

                                            <li class="sub-points">Unlimited pattern pdf's for mobile use</li>
                                            <li class="sub-points">Unlimited KnitFit™ custom patterns</li>
                                            <li class="sub-points">Unlimited projects</li>
                                            <li>
                                                <i
                                                class="fa fa-check-circle right-align"></i>Measurements: Unlimited measurement profiles
                                            </li>
                                            <li>
                                                <i
                                                class="fa fa-check-circle right-align"></i>Generate unlimited KnitFit™ custom sized patterns
                                            </li><li>
                                                <i
                                                class="fa fa-check-circle right-align"></i>Connect: Share photos, projects, and updates
                                            </li>
										</ul>
                                    </div>
                                    <div class="card-footer text-muted">
                                        @foreach($subscriptions as $sub)
@if($sub->id == 2)
    @if(Auth::user()->isBasic())
        @if(Auth::user()->remainingDays() <= 5)
              <button type="button" class="btn theme-btn btn-md">Your subscription </button>
           @if(!$paypalsubscription)
            <button type="button" class="btn theme-outline-btn btn-md p-40 SubscriptionType" data-id="{{$sub->id}}" data-price1="{{$sub->price_month}}" data-price2="{{$sub->price_year}}" data-price3="{{$sub->offer_price}}" data-name="{{$sub->name}}" >Upgrade</button>
          @endif
              @else
            <button type="button" class="btn theme-btn btn-md">Your subscription </button>
            @if(!$paypalsubscription)
        <button type="button" class="btn theme-outline-btn btn-md p-40 SubscriptionType" data-id="{{$sub->id}}" data-price1="{{$sub->price_month}}" data-price2="{{$sub->price_year}}" data-price3="{{$sub->offer_price}}" data-name="{{$sub->name}}" >Upgrade</button>
        @endif 
         @endif
            
            @else
            <button type="button" class="btn theme-outline-btn btn-md p-40 SubscriptionType" data-id="{{$sub->id}}" data-price1="{{$sub->price_month}}" data-price2="{{$sub->price_year}}" data-price3="{{$sub->offer_price}}" data-name="{{$sub->name}}" >Upgrade</button>
            @endif
            
@endif
                                        @endforeach  
                                    <!--<button
                                        class="btn btn-primary theme-btn btn-block">Get
                                        Started</button>-->
                                    </div>
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
    <div class="modal fade" id="subscribeModal{{$subb->id}}" role="dialog" data-keyboard="false" data-backdrop="static" >
       <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
           <div class="m-r-15">
               <h5 class="modal-title m-l-15 p-t-15">Select your subscription<button type="button" class="close" data-dismiss="modal">&times;</button></h5>
               <hr>
           </div>
           <div class="modal-body p-30">
           <form id="confirmSubscription{{$subb->id}}" class="form">
           @csrf
             <input type="hidden" id="subscription{{$subb->id}}" value="">
             <div class="row">
             <div class="col-md-12 text-center"><p class="red" id="errorDiv2{{$subb->id}}"></p></div>
                 <div class="col-lg-6">
                   <div class="checkbox-color checkbox-primary">
                       <input id="checkbox18{{$subb->id}}" class="checkme" type="checkbox"  onchange="valueChanged({{$subb->id}})" value="P-72C45040SG5797743L27JWOA">
                       <label for="checkbox18{{$subb->id}}">
                           Yearly subscription
                       </label>
                       <p class="text-center"><strong>${{$subb->offer_price ? $subb->offer_price : $subb->price_year}}</strong></p>
                   </div>
                </div>
                <div class="col-lg-6">
                   <div class="checkbox-color checkbox-primary">
                       <input id="checkbox1{{$subb->id}}" class="checkme" onchange="show2({{$subb->id}})" type="checkbox" value="P-664992417B445373VL4I6CFQ">
                       <label for="checkbox1{{$subb->id}}">
                           Monthly subscription
                       </label>
                       <p class="text-center"><strong>${{$subb->price_month}}</strong></p>
                   </div>
                </div>
                <div class="col-md-12">
                <p><strong>Note : </strong></p>
                
                <div class="box-account box-info">
            <div class="row m-t-20">
                <div id="existing{{$subb->id}}" class="col-lg-12 existing">
                    <div class="row">
                        <div class="col-sm-6 m-b-25">Select Billing Address</div>
                        <div class="col-sm-6"><a href="javascript:;" data-id="{{$subb->id}}" id="add-new-btn" class="theme-text"><i class="feather icon-plus"></i> Add new</a></div>
                        <div class="col-md-12 text-center"><p class="red" id="errorDiv1{{$subb->id}}"></p></div>
                            @if($address->count() > 0)
                            <div class="col-md-12" id="scrollAddress">
                                <?php $ad = 0; ?>
                            @foreach($address as $add)
                            <div class="row" >
                                <div class="card p-20 ">
                                    <div class="box-title">
                                        <h5 style="color: #414141;margin-bottom:8px ;">{{ucwords($add->first_name)}} {{ucwords($add->last_name)}} </h5>
                                        <div class="form-radio addresss">
                                            <div class="radio radio-inline">
                                                <label>
                                                    <input type="radio" name="user_address" data-id="{{$subb->id}}" id="user_address{{$subb->id}}" class="user_address" value="{{$add->id}}" >
                                                    <i class="helper"></i>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box-content">
                                        <h6>{{$add->address}},
                                            {{$add->city}},{{$add->state}},{{$add->country}} {{$add->zipcode}}</h6>
                                        <h6>{{$add->email}}</h6>
                                        </div>
                                </div>
                            </div>
                                <?php $ad++; ?>
                            @endforeach
                            </div>
                            @else
                                <p>You dont have any default address. Please add a address and proceed.</p>
                            @endif
                            
                </div>
                </div>
                <input type="hidden" name="address_id" id="address_id{{$subb->id}}" value="0" >
                <div id="Addnew{{$subb->id}}" class="col-lg-12 Addnew">
                    <div class="row">
                         <div class="col-sm-6 m-b-25">Select Billing Address</div>
                            <div class="col-sm-6"><a href="javascript:;" data-id="{{$subb->id}}" id="existing-btn" class="theme-text"> Use Existing Address</a></div>
                            <div class="col-md-12">
                                <div class="card p-10">
                                <div class="checkout-title">
                                  
                                <div class="row check-out" id="checkout-title{{$subb->id}}">
                                
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">First name<span class="red">*</span></div>
                                        <input type="text" name="first_name" id="first_name" class="form-control" value="" placeholder="First name">
                                        <span class="red first_name">{{$errors->first('first_name')}}</span>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">Last name<span class="red">*</span></div>
                                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{old('last_name')}}" placeholder="Last name">
                                        <span class="red last_name">{{$errors->first('last_name')}}</span>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">Phone</div>
                                        <input type="text" name="mobile" id="mobile" class="form-control" value="{{old('mobile')}}" placeholder="Phone number">
                                        <span class="red mobile">{{$errors->first('mobile')}}</span>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                        <div class="field-label">Email address<span class="red">*</span></div>
                                        <input type="text" name="email" id="email" class="form-control" value="{{old('email')}}" placeholder="Email address">
                                        <span class="red email">{{$errors->first('email')}}</span>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Country<span class="red">*</span></div>
                                        <select name="country" id="country" class="form-control">
                                            <option value="">Please select country</option>
                                            @foreach($country as $cntry)
                                            <option value="{{$cntry->nicename}}">{{$cntry->nicename}}</option>
                                            @endforeach
                                        </select>
                                        <span class="red country">{{$errors->first('country')}}</span>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Address<span class="red">*</span></div>
                                        <input type="text" name="address" id="address" class="form-control" value="{{old('address')}}" placeholder="Street address">
                                        <span class="red address">{{$errors->first('address')}}</span>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                        <div class="field-label">Town/City<span class="red">*</span></div>
                                        <input type="text" name="city" id="city" class="form-control" value="{{old('city')}}" placeholder="Town/City">
                                        <span class="red city">{{$errors->first('city')}}</span>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                        <div class="field-label">State<span class="red">*</span></div>
                                        <input type="text" name="state" id="state" class="form-control" value="{{old('state')}}" placeholder="State">
                                        <span class="red state">{{$errors->first('state')}}</span>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-6 col-xs-12">
                                        <div class="field-label">Postal code<span class="red">*</span></div>
                                        <input type="text" name="zipcode" id="zipcode" class="form-control" value="{{old('zipcode')}}" placeholder="Postal code">
                                        <span class="red zipcode">{{$errors->first('zipcode')}}</span>
                                    </div>
                                    
                                </div>
                                
                                <div class="col-md-12 text-center"><p class="red" id="errorDiv{{$subb->id}}"></p></div>
                            </div>
                            </div>
                    </div>
                </div>
            </div>
          
        </div>
            
          </div>
                
                
                </div>
                </form>
                
               
             </div>
               <div class="text-center col-lg-12 m-t-20">
                   <!-- <button type="button" class="btn btn-default theme-outline-btn m-r-20" data-dismiss="modal">Cancel</button> -->
                   <button type="button" data-id="{{$subb->id}}" class="btn btn-default theme-btn" id="continue" >Continue</button>
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
.addresss{position: absolute;top: 0;right: 0;float: right;}
    select,textarea{border: 1px solid #ccc;
    border-radius: 3px;
    width: 97%;
    padding: 3px;}
    input{border: 1px solid #ccc;
    border-radius: 3px;padding: 2px;}
    .Addnew{display: none;}
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
.alert-success {
    background-color: #fff;
    border-color: #0d665c;
    color: #0d665c;
}
.alert-danger {
    background-color: #fff;
    border-color: #bc7c8f;
    color: #bc7c8f;
}
.sub-points{font-size:13px;list-style: disc;margin-left:40px!important}
        .address {
            position: absolute;
            top: 0;
            right: 0;
            float: right;
        }

        select,
        textarea {
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 97%;
            padding: 3px;
        }

        input {
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 2px;
        }

        #Addnew {
            display: none;
        }

        .checkbox-primary input[type="checkbox"]:checked+label::before {
            background-color: #0d665c;
        }

        .checkbox-primary input[type="checkbox"]:checked+label::before {
            background-color: #0d665c;
            border-color: #0d665c
        }

        .button-3:hover:hover {
            background-color: #cc8b86;
            border: 1px solid #cc8b86;
            padding: 3px 3px;
            color: #fff !important;
        }

        #mainNav {
            background-color: white;
            background-color: white;
            box-shadow: 2px 2px 2px #e6e4e4;
        }

        .theme-logo {
            width: 110px;
        }

        .container-fluid {
            padding-right: 15px;
            padding-left: 15px;
        }

        body {
            background-color: #faf9f8;
        }

        .centered-block {
            float: none;
            display: block;
            margin: 0 auto;
        }

        .theme-btn {
            padding: 10px;
            text-transform: uppercase;
            
        }

        .nav-tabs .slide {
            background: #0d665c;
        }

        .md-tabs .nav-item a {
            padding: 4px 0;
            font-size: 16px;
        }

        .Free,
        .Basic,
        .Premium {
            border-left: 0px solid #e4e4e4 !important;
        }

        #subscription-table {
            background-color: transparent;
        }

        .table-styling .table-info thead,
        .table-styling.table-info thead {
            border: none;
        }

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

        .theme-btn,
        .theme-outline-btn {
            padding: 5px;
            text-transform: uppercase;
        }

        .table th {
            padding: 10px 0px 10px 0px;
        }

        /* .pricing-section .table-left,
        .pricing-section .table-right {
            box-shadow: 0 5px 10px rgb(0 0 0 / 10%);
            border: 1px solid #EFEFEF;
        } */
        h2{font-size: 24px;color: black;}
        .pricing-details span{font-size: 34px;}
        .right-align{float: right;right: 0;
    font-size: 18px;
    color: #03655B;margin-right: 15px;margin-top: 5px;}
    .sub-table li{padding-bottom: 10px;text-align: left;margin-left: 10px;}
    .sub-table{margin-top:30px;margin-bottom: 3px;}
    .pricing-details{padding: 20px;}
    .muted-text{color:#cccccc!important}
    .logo{width: 58px;margin-right: 5px;margin-top: -2px;}
    .table-right,.table-left{background:linear-gradient(180deg, #0d665c 18%, #FFFFFF 12%);}
    .fa-plus-square{color: #dd8ca0;font-size: 16px;margin-right: 10px;}
    h1, h2, h3, h4, h6, span, table td{color: #FFFFFF;}
    .card-header{background-color: #0d665c!important}
    .card-body{height: 400px;}
    .card .card-header span{font-size: 28px;}
    .no-visible{
        display: none;
    }
    .disabledbutton {
    pointer-events: none;
    opacity: 0.4;
    }
    #scrollAddress{
        height: 200px;
        width: 100%;
        overflow-y: scroll;
        border: 1px solid #e2e2e2;
    }
</style>
<script type="text/javascript" src="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

<script type="text/javascript">
    $(".div1").hide();
    $('#continue').attr('disabled', true);
       function valueChanged(id)
       {
           if($('#checkbox18'+id).is(":checked"))
           {
               document.getElementById("checkbox1"+id).disabled = true;
               $("#errorDiv2"+id).html('');
           }else{
               document.getElementById("checkbox1"+id).disabled = false;
           }

           

       }

       function show2(id){
           if($('#checkbox1'+id).is(":checked"))
           {
               document.getElementById("checkbox18"+id).disabled = true;
               $("#errorDiv2"+id).html('');
           }else{
               document.getElementById("checkbox18"+id).disabled = false;
           }
       }

       /*$('.checkme').click(function () {
       //check if checkbox is checked
       if ($(this).is(':checked')) {

           $('#continue').removeAttr('disabled'); //enable input

       } else {
           $('#continue').attr('disabled', true); //disable input
       }
   }); */

   $(function(){
       
       //$('.slider').slick();
       
       $(document).on('click',"#add-new-btn",function()
        {
            var id = $(this).attr('data-id');
            $("#Addnew"+id).show();
            $("#existing"+id).hide();
            $("#address_id"+id).val(0);
            $("#user_address"+id).prop("checked",false);
            $("#errorDiv1"+id).html('');
        })

        $(document).on('click',"#existing-btn",function()
        {
            var id = $(this).attr('data-id');
            $("#existing"+id).show();
            $("#Addnew"+id).hide();
            $("#errorDiv"+id).html('');
            $("#checkout-title"+id+" .form-control").each(function(){
               var idd = $(this).attr('id');
               var value = $(this).val();
               $("."+idd).html('');
           });
        })
       
       
       
       $(document).on('click','.user_address',function(){
           var id = $(this).attr('data-id');
          var vals = $(this).val();
          //alert(vals);
          $("#address_id"+id).val(vals); 
          $("#errorDiv1"+id).html('');
       });
       
    /*$(document).on('click','.cancelSubscription',function(){
        var id = $(this).attr('data-id');
        Swal.fire({
          title: 'Are you sure?',
          text: "You want to cancel subscription ?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, cancel!'
        }).then((result) => {
          if (result.value) {
              
              $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
      
              $.ajax({
                  url : '{{url("cancelSubscription")}}',
                  type : 'POST',
                  data : 'subscription_id='+id,
                  beforeSend : function(){
                      $(".loading").show();
                  },
                  success : function(res){
                      console.log(res);
                  },
                  complete : function(){
                      $(".loading").hide();
                  },
                  error : function(jqXHR){
                      console.log(jqXHR);
                  }
              });
            /*Swal.fire(
              'Deleted!',
              'Your file has been deleted.',
              'success'
            )
          }
        })
    }); */

     $(document).on('click','.SubscriptionType',function(){
       var id = $(this).attr('data-id');
       $("#subscription"+id).val(id);
       $('#subscribeModal'+id).modal({backdrop:'static', keyboard:false});
     });

       $(document).on('click','#continue',function(){
       //$(".loading").show();
       var er = [];
       var cnt = 0;
       
       var id = $(this).attr('data-id');
       if($('#checkbox18'+id).is(":checked")) {
           var sub_type = 'yearly';
       }else if($('#checkbox1'+id).is(":checked")){
           var sub_type = 'monthly';
       }else{
           var sub_type = '';
       }

       if(sub_type == 'yearly'){
            var mode = 'recurring';
            var plan_id = 'P-72C45040SG5797743L27JWOA';
       }else if(sub_type == 'monthly'){
            var mode = 'recurring';
            var plan_id = 'P-664992417B445373VL4I6CFQ';
       }else{
           $("#errorDiv2"+id).html('Please select the type of subscription.');
           er+cnt+1;
       }
       
       
       
       
       var address = $("#address_id"+id).val();
       var user_address = $("#user_address"+id).prop("checked");
       if ($('#Addnew'+id).css('display') == 'none'){
           if(user_address == false){
               $("#errorDiv1"+id).html('Please select the address.');
               er+=cnt+1;
           }
       }else{
           $("#checkout-title"+id+" .form-control").each(function(){
               var idd = $(this).attr('id');
               var value = $(this).val();
               
               if(idd != 'mobile'){
                   if(value == ""){
                       $("."+idd).html('This field is required.');
                       er+=cnt+1;
                   }else{
                       $("."+idd).html('');
                   }
               }
               
           });
       }
       
       if(er != ''){
           
           return false;
       }
       
       
    $(".loading").show();
       var Data = $("#confirmSubscription"+id).serializeArray();
       Data.push({name: 'id', value: plan_id});
        //console.log(Data);
        //return false;
       
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        
        $.ajax({
            url: '{{url("makePayment")}}',
            type: 'POST',
            dataType: 'json',
            data: Data,
        })
        .done(function(res) {
            console.log(res);
          if(res.status == 'APPROVAL_PENDING'){
            window.location.assign(res.links[0].href);
          }else{
              //alert(res.status);
          }
        })
        .fail(function() {
            $(".loading").hide();
            console.log("error");
        })
        .always(function() {
            
            console.log("complete");
        });
/*
   var jqXHR = $.getJSON('{{url("makePayment")}}/'+plan_id,function(res){
      console.log(res);
      if(res.status == 'APPROVAL_PENDING'){
        window.location.assign(res.links[0].href);
      }else{
          //alert(res.status);
      }
    })
  .done(function() {
    console.log( "second success" );
  })
  .fail(function() {
    console.log( "error" );
         // alert('Unable to generate token, please try again.');
         $("#continue").trigger('click');
  })
  .always(function() {
      //$(".loading").hide();
    console.log( "complete" );
  });
  */

   });



$(document).on('click','.checkSubscription',function(){
  $(".loading").show();
  var id = $(this).attr('data-id');
  var allData = '';
    var jqXHR = $.getJSON('{{url("checkSubscription")}}/'+id,function(res){
console.log(res);
var date    = new Date(res.create_time),
yr      = date.getFullYear(),
month   = date.getMonth() < 10 ? '0' + date.getMonth() : date.getMonth(),
day     = date.getDate()  < 10 ? '0' + date.getDate()  : date.getDate(),
newDate = day + '/' + month + '/' + yr;

        $("#payment_date").html(newDate);
        planDetails(res.plan_id);
  /*  
for (var i = 0; i < res.links.length; i++) {
  if(res.plan_id == 'P-7TF98787S4969684BL3HCQ7A'){
  if(res.links[i].rel == 'cancel'){
  allData+='<p><a href="javascript:;" class="cancelSubscription" data-link="'+res.links[i].href+'" data-method="'+res.links[i].method+'" data-rel="'+res.links[i].rel+'">'+capitalize_Words(res.links[i].rel)+' Subscription</a> (<small>Applicable only for recurring payments</small>)</p>';
  }
  }
}


        $("#response").html(allData);
    */
    })
  .done(function() {
    console.log( "second success" );
  })
  .fail(function() {
    console.log( "error" );
  })
  .always(function() {
    console.log( "complete" );
  });
}); 


$(document).on('click','.cancelSubscription',function(){
    var id = $(this).attr('data-id');
    
    Swal.fire({
          title: 'Are you sure?',
          text: "You want to cancel subscription ?",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, cancel!'
        }).then((result) => {
          if (result.value) {
              $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

              $.ajax({
                url : '{{url("cancelSubscription")}}',
                type : 'POST',
                data : 'subscription_id='+id,
                beforeSend : function(){
                  $(".loading").show();
                },
                success : function(res){
                    Swal.fire('Cancelled!',res.message,res.status);
                  if(res.status == 'success'){
                      setTimeout(function(){ location.reload(); },2000);
                  }
                },
                complete : function(){
                  $(".loading").hide();
                },
                error : function(jqXHR){
                    console.log(jqXHR);
                }
              });
          }
        });
    
    

    
  
});


   });

function capitalize_Words(str)
{
 return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
}

function planDetails(id){
    $.getJSON('{{url("getPlanDetails")}}/'+id,function(res){
        $("#sub_name").html(res.name);
        $(".loading").hide();
    });
}

function getUserAddress(id){
    $.get('{{url("get-user-address")}}',function(res){
        if(res.error){
            $("#userAddress"+id).html(res.error);
            return false;
        }
        $("#userAddress"+id).html(res);


    });
}
   </script>
@endsection
