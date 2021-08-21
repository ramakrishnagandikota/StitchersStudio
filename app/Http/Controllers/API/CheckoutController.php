<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaypalCredentials;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Auth;
use App\Models\API\Cart;
use App\Models\Products;
use App\Models\Product_images;
use Session;
use Srmklive\PayPal\Services\AdaptivePayments;
use Srmklive\PayPal\Services\ExpressCheckout;
use PayPal;
use Redirect;
use DB;
use App\Models\Orders;
use App\Models\Booking_process;
use App\User;
use Carbon\Carbon;
use Log;

class CheckoutController extends Controller
{
    function __construct(){
        //$this->middleware('auth:api');
    }

    function sendJsonData($data){
		return response()->json(['data' => $data]);
    }

    function place_order(Request $request){

        $user_id = $request->get('user_id');
        if($user_id != 'null' || $user_id != 0 || $user_id != ""){
            Auth::loginUsingId($user_id, true);
            if(Auth::check()){
                Session::put('user_id', $user_id);
            }else{
                Session::flash('error',"You are not logged in. Please login & try.");
                return redirect('login');
            }

        }else{
            Session::flash('error',"You are not logged in. Please login & try.");
            return redirect('login');
        }


        $cart = Cart::leftJoin('products','products.id','cart.product_id')
                ->select('products.id','products.product_name','products.price','products.sale_price','products.sale_price_start_date','sale_price_end_date')->where('cart.user_id',$user_id)->get();

        if($cart->count() == 0){
            echo 'Your cart is empty.';
            exit;
        }

        foreach ($cart as $key);
		$pro = Products::where('id',$key->id)->first();
        $designer_name = $pro->designer_name;

        $credentials = PaypalCredentials::where('user_id',$designer_name)->where('store_status',1)->first();
		//print_r($credentials);
        if(!$credentials){
            echo 'The payment details are invalid, Contact administrator.';
            exit;
        }
		//exit;

        $sum = 0;
        foreach ($cart as $ca) {

            $date = strtotime(date('Y-m-d'));
            $dateStart = strtotime(date('Y-m-d',strtotime($ca->sale_price_start_date)));
            $dateEnd = strtotime(date('Y-m-d',strtotime($ca->sale_price_end_date)));

            if($date >= $dateStart && $date <= $dateEnd){
                $price = $ca->sale_price;
            }else{
                $price = $ca->price;
            }

            $sum=$sum+$price;

        }

        $invoice = time();

        $data = [
            'receivers'  => [
                [
                    'email' => $credentials->paypal_email, //'sb-hagbw5007710@personal.example.com',
                    'amount' => $sum
                ]
            ],
            'ipAddress' => $_SERVER['REMOTE_ADDR'],
            'memo' => 'Example',
            'currencyCode' => $credentials->currency_code,
            'payer' => 'SENDER', // (Optional) Describes who pays PayPal fees. Allowed values are: 'SENDER', 'PRIMARYRECEIVER', 'EACHRECEIVER' (Default), 'SECONDARYONLY'
            'return_url' => url('api/success/'.$invoice.'?user_id='.$user_id),
            'cancel_url' => url('api/failure/'.$invoice.'?user_id='.$user_id),
            'requestEnvelope' => [
                "errorLanguage" => "en_US",
                "detailLevel" => "ReturnAll"
            ]
        ];

        $provider = PayPal::setProvider('adaptive_payments');
        $response = $provider->createPayRequest($data);

        if (strtoupper($response['responseEnvelope']['ack']) == 'FAILURE') {
            echo 'Unable to make payment for this store.Please contact administrator.';
            exit;
        }

        if (strtoupper($response['responseEnvelope']['ack']) == 'SUCCESS') {
            $address_id = $request->get('address');

            /* Orders table data insertion */

            $order = new Orders;
            $order->user_id = Auth::user()->id;
            $order->designer_id = $designer_name;
            $order->order_number = $invoice;
            $order->order_date = Carbon::now();
            $order->order_status = 'Pending';
            $order->payKey = $response['payKey'];
            $order->order_description = 'Payment towards order '.$invoice;
            $order->ordered_amt = $sum;
            $order->booking_datebooked = date('Y-m-d');
            $order->booking_timebooked = date('H:i:s');
            $order->booking_cart_total = count($cart);
            $order->total = $sum;
            $order->address_id = $address_id;
            $order->cart_total = serialize($cart);
            $order->created_at = Carbon::now();
            $order->save();

            foreach ($cart as $car) {

                $date = strtotime(date('Y-m-d'));
                $dateStart = strtotime(date('Y-m-d',strtotime($car->sale_price_start_date)));
                $dateEnd = strtotime(date('Y-m-d',strtotime($car->sale_price_end_date)));

                if($date >= $dateStart && $date <= $dateEnd){
                    $price = $ca->sale_price;
                }else{
                    $price = $ca->price;
                }

                $bp = new Booking_process;
                $bp->user_id = Auth::user()->id;
                $bp->order_id = $order->id;
                $bp->category_id = 1;
                $bp->product_id = $car->id;
                $bp->product_name = $car->product_name;
                $bp->product_quantity = 1;
                $bp->bookingdate = date('Y-m-d');
                $bp->bookingtime = date('H:i:s');
                $bp->setpayment = $price;
                $bp->subtotal = $sum;
                $bp->created_at = Carbon::now();
                $bp->save();
            }

            $redirect_url = $provider->getRedirectUrl('approved', $response['payKey']);
            return redirect($redirect_url);
        }
    }

    function payment_success(Request $request){

        $user_id = $request->get('user_id');
        if($user_id){
            Auth::loginUsingId($user_id, true);
            session(['user_id' => Auth::user()->id]);
        }else{
            return redirect('login');
        }

        $order_id = $request->id;
        $orders = Orders::where('order_number',$order_id)->first();

        if(!$orders){
            return view('API.failure',compact('order_id'));
            exit;
        }

        $provider = new AdaptivePayments;
        $response = $provider->getPaymentDetails($orders->payKey);
        $this->remove_all_items();
        if (strtoupper($response['status']) == 'COMPLETED') {
            $transactionId = $response['paymentInfoList']['paymentInfo'][0]['transactionId'];
            $transactionStatus = $response['paymentInfoList']['paymentInfo'][0]['transactionStatus'];
            $refundedAmount = $response['paymentInfoList']['paymentInfo'][0]['refundedAmount'];
            $pendingRefund = $response['paymentInfoList']['paymentInfo'][0]['pendingRefund'];
            $senderTransactionId = $response['paymentInfoList']['paymentInfo'][0]['senderTransactionId'];
            $senderTransactionStatus = $response['paymentInfoList']['paymentInfo'][0]['senderTransactionStatus'];
            $receiverAmount = $response['paymentInfoList']['paymentInfo'][0]['receiver']['amount'];
            $receiverEmail = $response['paymentInfoList']['paymentInfo'][0]['receiver']['email'];
            $receiverPrimary = $response['paymentInfoList']['paymentInfo'][0]['receiver']['primary'];
            $receiverPaymentType = $response['paymentInfoList']['paymentInfo'][0]['receiver']['paymentType'];
            $receiverAccountId = $response['paymentInfoList']['paymentInfo'][0]['receiver']['accountId'];
            $senderEmail = $response['sender']['email'];
            $senderAccountId = $response['sender']['accountId'];


            $order = Orders::find($orders->id);
            $order->receiverTransactionId = $transactionId;
            $order->order_status = ($response['status'] == 'COMPLETED') ? 'Success' : 'Pending';
            $order->receiverTransactionStatus = $transactionStatus;
            $order->refund = $refundedAmount;
            $order->pendingRefund = $pendingRefund;
            $order->senderTransactionId = $senderTransactionId;
            $order->senderTransactionStatus = $senderTransactionStatus;
            $order->receiverAmount = $receiverAmount;
            $order->receiverEmail = $receiverEmail;
            $order->receiverPrimary = $receiverPrimary;
            $order->receiverPaymentType = $receiverPaymentType;
            $order->receiverAccountId = $receiverAccountId;
            $order->senderEmail = $senderEmail;
            $order->senderAccountId = $senderAccountId;
            $order->updated_at = Carbon::now();
            $order->save();
            $cart = Cart::where('user_id',Auth::user()->id)->delete();
            return view('API.success',compact('order_id'));
        }else{
            return view('API.failure',compact('order_id'));
        }
    }

    function payment_failure(Request $request){

        $user_id = $request->get('user_id');
        if($user_id){
            Auth::loginUsingId($user_id, true);
            session(['user_id' => Auth::user()->id]);
        }else{
            return redirect('login');
        }

        $order_id = $request->id;
        $orders = Orders::where('order_number',$order_id)->first();
        if(!$orders){
            return view('API.failure',compact('order_id'));
            exit;
        }

        $provider = new AdaptivePayments;
        $response = $provider->getPaymentDetails($orders->payKey);

        $receiverAmount = $response['paymentInfoList']['paymentInfo'][0]['receiver']['amount'];
        $receiverEmail = $response['paymentInfoList']['paymentInfo'][0]['receiver']['email'];
        $receiverPrimary = $response['paymentInfoList']['paymentInfo'][0]['receiver']['primary'];
        $receiverPaymentType = $response['paymentInfoList']['paymentInfo'][0]['receiver']['paymentType'];
        $receiverAccountId = $response['paymentInfoList']['paymentInfo'][0]['receiver']['accountId'];

        $order = Orders::find($orders->id);
        $order->order_status = ($response['status'] == 'CREATED') ? 'Created' : 'Pending';
        $order->receiverAmount = $receiverAmount;
        $order->receiverEmail = $receiverEmail;
        $order->receiverPrimary = $receiverPrimary;
        $order->receiverPaymentType = $receiverPaymentType;
        $order->receiverAccountId = $receiverAccountId;
        $order->updated_at = Carbon::now();
        $order->save();

        return view('API.failure',compact('order_id'));
    }


    /* place order if order is free or 0 */

    function remove_all_items(){
        Session::forget('cart');
    }

    function add_to_project_library(Request $request){
		//info($request->all())
        $pid = $request->product_id;
        $pro = Products::where('id',$pid)->first();

		if($pro->sale_price_start_date != '0000-00-00' || $pro->sale_price_end_date != '0000-00-00'){
			if($pro->sale_price_start_date <= date('Y-m-d') && $pro->sale_price_end_date >= date('Y-m-d')){
				$totalPrice = $pro->sale_price;
				$price = $pro->sale_price;
			}else{
				$totalPrice = $pro->price;
				$price = $pro->price;
			}
		}else{
			$totalPrice = $pro->price;
            $price = $pro->price;
		}

        if($totalPrice > 0){
            return response()->json(['status' => 'error','message' => 'The price of product should be zero.']);;
            exit;
        }

        $address = UserAddress::where('user_id',Auth::user()->id)->count();
        if($address > 0){
            $user_address = UserAddress::where('user_id',Auth::user()->id)->first();
            $address_id = $user_address->id;
        }else{
            $add = new UserAddress;
            $add->user_id = Auth::user()->id;
            $add->type = 'billing';
            $add->first_name = Auth::user()->first_name;
            $add->last_name = Auth::user()->last_name;
            $add->email = Auth::user()->email;
            $add->mobile = '9000000000';
            $add->address = 'Test Address';
            $add->city = 'Test City';
            $add->state = 'Test State';
            $add->zipcode = 'Test zipcode';
            $add->is_default = 0;
            $add->status = 1;
            $add->created_at = Carbon::now();
            $add->save();

            $address_id = $add->id;
        }

        $invoice = time();

        $order = new Orders;
        $order->user_id = Auth::user()->id;
        $order->order_number = $invoice;
        $order->order_date = Carbon::now();

        $order->order_token = $invoice;
        $order->order_status = 'Success';
        $order->payer_email = Auth::user()->email;
        $order->payerid = Auth::user()->id;
        $order->payer_first_name = Auth::user()->first_name;
        $order->payer_last_name = Auth::user()->last_name;

        $order->order_description = 'Payment towards order '.$invoice;
        $order->ordered_amt = $totalPrice;
        $order->booking_datebooked = date('Y-m-d');
        $order->booking_timebooked = date('H:i:s');
        $order->booking_cart_total = 1;
        $order->total = $totalPrice;
        $order->address_id = $address_id;
        $order->cart_total = serialize($pro);
        $order->created_at = Carbon::now();
        $order->save();

        $bp = new Booking_process;
        $bp->user_id = Auth::user()->id;
        $bp->order_id = $order->id;
        $bp->category_id = 1;
        $bp->product_id = $pro->id;
        $bp->product_name = $pro->product_name;
        $bp->product_quantity = 1;
        $bp->bookingdate = date('Y-m-d');
        $bp->bookingtime = date('H:i:s');
        $bp->setpayment = $price;
        $bp->subtotal = $totalPrice;
        $bp->created_at = Carbon::now();
        $bp->save();

        $this->remove_all_items();

        return response()->json(['status' => 'success']);
    }

}
