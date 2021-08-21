@extends('layouts.shopping')
@section('title','Checkout')
@section('content')
<form id="placeOrder" method="POST" action="{{url('placeOrder')}}">
	@csrf
	
	@if(Session::has('invalid_credentials'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ Session::get('invalid_credentials') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="padding: 0.3rem 1.25rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
	
<div class="dashboard-right">
    <div class="dashboard card">
        <div class="page-title row">
            <h2 class="col-md-10">Billing address</h2>
            <a href="javascript:;" class="col-md-2 pull-right btn theme-btn waves-effect waves-light" id="addNew">Add new address</a>
        </div>
        <div class="box-account box-info">
            <div class="row" id="userAddress">
            	<div style="margin:auto;">Problem in loading data.Please <a href="javascript:;" onclick="getUserAddress();">Click here</a></div>
            </div><br>
        </div>
    </div>
</div>

<div class="row" style="margin-left: 0px;">
<div class="col-lg-12">

<div class="checkout-page">
    <div class="checkout-form">

<div class="row">
    <div class="no-visible col-lg-6 col-sm-12 col-xs-12 card p-t-25">
        <div class="checkout-title">
            <h3>Billing details</h3></div>
        <div class="row check-out" id="add-form">
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">First name</div>
                <input type="text" name="first_name" value="" placeholder=""  >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Last name</div>
                <input type="text" name="last_name" value="" placeholder=""  >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Phone</div>
                <input type="text" name="mobile" value="" placeholder=""  >
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Email address</div>
                <input type="text" name="email" value="" placeholder=""  >
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Country</div>
                <select name="country">
                    <option value="">Please select country</option>
                    @foreach($country as $cntry)
                    <option value="{{$cntry->nicename}}">{{$cntry->nicename}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Address</div>
                <input type="text" name="address" value=""  placeholder="Street address">
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Town/City</div>
                <input type="text" name="city" value=""  placeholder="">
            </div>
            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                <div class="field-label">State</div>
                <input type="text" name="state" value=""  placeholder="">
            </div>
            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                <div class="field-label">Postal code</div>
                <input type="text" name="zipcode" value=""  placeholder="">
            </div>
            <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <br><br>
                <!-- <input type="checkbox" name="shipping-option" id="account-option"> &ensp;
                <label for="account-option">Create an account?</label> -->
            </div>
        </div>

    </div>
    <div class="col-lg-6 col-sm-12 col-xs-12">
        <div class="checkout-details card">
          <!--   <div class="checkout-title">
                <h3>Shipping</h3></div>
                <div class="order-box p-l-30">
               <div class="form-radio m-l-5" style="border-bottom: 1px solid #dddddd;">

                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" checked="checked" name="radio" id="local-pickup">
                                <i class="helper"></i>Local pickup
                            </label>
                        </div>
                        <div class="radio radio-inline">
                            <label>
                                <input type="radio" name="radio" id="free-shipping">
                                <i class="helper"></i>Free shipping
                            </label>
                        </div>

                </div>
                <table class="mytable" style="width: 111%;">
                    <tr>
                        <th>Subtotal</th>
                        <th style="text-align: center;"></th>
                        <th style="text-align: center;">$00.00</th>
                      </tr>
                      </table>
                      </div>-->
            <div class="checkout-title">
                <h3>Order details</h3></div>
            <div class="order-box p-l-30">
                <div class="title-box">
                    <table class="mytable" style="width: 100%;">
                        <thead>
                          <tr style="border-bottom: 1px solid #dddddd;margin-bottom:20px">
                            <th style="text-align: left;">Product</th>
                            <th>Quantity</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                        	@if(Session::has('cart'))
							@foreach($data as $da)
                          <tr>
                            <td>{{$da['item']['product_name']}}</td>
                            <td align="center">{{$da['qty']}}</td>
                            <td align="center">@if($da['item']['sale_price'])
                                ${{number_format($da['item']['sale_price'],2)}}
                            @else
                                @if($da['item']['price'] == 0) FREE @else
                                ${{number_format($da['item']['price'],2)}}
                                @endif
                            @endif</td>
                          </tr>
                          @endforeach
                          @endif

                          <tr style="border-bottom: 1px solid #dddddd;">
                          <th>Subtotal</th>
                          <th style="text-align: center;">{{count($data)}}</th>
                          <th style="text-align: center;">${{$totalPrice}}</th>
                        </tr>
                        <tr>
                            <tr></tr>
                            <th>Total</th>
                            <th></th>
                            <th style="text-align: center;">${{$totalPrice}}</th>
                        </tr>
                          </tbody>
                          </table>
                </div>

            <div class="payment-box">
                <div class="upper-box">
                    <div class="payment-options">
                        <div class="form-radio">

                                <div class="radio">
                                    <label>
                                        <input type="radio" checked name="payment" id="external-pattern" value="paypal">
                                        <i class="helper"></i>Paypal
                                    </label>
									<!--<div class="col-md-12" style="text-align: right;position: absolute;top: 0px;"><a href="{{url('knitter/subscription')}}">Subscription</a></div>-->
                                </div>

                        </div>
                        <ul>


                            <li>
                                <div class="radio-option paypal">

                                    <label for="payment-3"><span class="image"><img style="margin-top: 15px;" src="{{asset('resources/assets/knitfitEcommerce/assets/images/paypal.png') }}" alt=""></span></label>
                                </div>
                            </li>
                        </ul>
						<!--<div><p><b>Note :- </b>Thank you for your purchase. Please note, "Noetic Data, LLC" will appear on your credit card statement as the merchant for your purchase and the confirmation email from Paypal. Noetic Data, LLC is our company and business entity that develops and maintains the KnitFit software.</p></div>-->
                    </div>
                </div>
                <div class="text-right"><input type="submit" name="placeOrder" id="saveOrder" class="btn theme-btn waves-effect waves-light" value="Place order"></div>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
</div>
</form>
@endsection
@section('footerscript')
  <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/slick/slick.css') }}">
  <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/slick/slick-theme.css') }}">
<script type="text/javascript" src="{{asset('resources/assets/slick/slick.min.js')}}"></script>
<style type="text/css">
	.no-visible{
		display: none;
	}
	.disabledbutton {
    pointer-events: none;
    opacity: 0.4;
	}
</style>
<script type="text/javascript">
	$(function(){

/*
$(window).resize(function() {
   var width = $(window).width();
   //location.reload();
   alert(width);
});
*/

		getUserAddress();

		$(document).on('click','#addNew',function(){
			$(".no-visible").toggle(1000);
			$("#userAddress").toggleClass("disabledbutton");
                $("#local-pickup").prop('checked', function(ind, attr){
                return attr == true ? null : true;
                //alert(attr);
                });
			$("#add-form input").each(function(index, el) {
                var attr = $(this)[0].hasAttribute('required');

                if(attr == false){
                    $(this).attr('required',true);
                }else{
                    $(this).removeAttr('required');
                }


            });

            $(".user_address").each(function(index, el) {
                var attr = $(this)[0].hasAttribute('required');

                if(attr == false){
                    $(this).attr('required',true);
                }else{
                    $(this).removeAttr('required');
                }
            });

		});

	/*	$(document).on('click','#saveOrder',function(){
			var Data = $("#placeOrder").serializeArray();

			$.ajax({
				url : 'url("placeOrder")}}',
				type : 'POST',
				data : Data,
				beforeSend : function(){
					$(".loader-bg").show();
				},
				success : function(res){
					if(res.status == 'Success'){
						$("#address-form")[0].reset();
						$(".no-visible").toggle(1000);
						getUserAddress();
						addProductCartOrWishlist('fa-check','Success','Address added successfully.');

					}else{
						addProductCartOrWishlist('fa-times','Oops!','Unable to add address, Try again after some time.');
					}
				},
				complete : function(){
					$(".loader-bg").hide();
				}
			});
		}); */
	});

	function getUserAddress(){
		$.get('{{url("getUserAddress")}}',function(res){
			if(res.error){
				$("#userAddress").html(res.error);
				return false;
			}
			$("#userAddress").html(res);


		});
	}

	function addProductCartOrWishlist(icon,status,msg){
        $.notify({
            icon: 'fa '+icon,
            title: status+'!',
            message: msg
        },{
            element: 'body',
            position: null,
            type: "info",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: true,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 10000,
            delay: 3000,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
    }
</script>
@endsection
