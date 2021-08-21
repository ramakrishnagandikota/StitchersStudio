<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use Session;
use App\Cart;
use Srmklive\PayPal\Services\ExpressCheckout;
use PayPal;
use Redirect;
use DB;
use App\Models\Orders;
use App\Models\Booking_process;
use App\Models\Products;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Config;
use App\Models\PaypalCredentials;
use Srmklive\PayPal\Services\AdaptivePayments;
use PDF;

class CheckoutController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    function add_to_project_library(Request $request){
        $pid = $request->pid;
        $pro = Products::where('pid',$pid)->first();

        if($pro->sale_price_start_date <= date('Y-m-d') && $pro->sale_price_end_date >= date('Y-m-d')){
            $totalPrice = $pro->sale_price;
            $price = $pro->sale_price;
        }else{
            $totalPrice = $pro->price;
            $price = $pro->price;
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
            $save = $add->save();

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

        return redirect('order/invoice/'.$invoice);
    }

    function remove_all_items(){
        Session::forget('cart');
    }

    function place_order(Request $request){
		
		//echo env('PAYPAL_MODE');
		//exit;

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $totalItems = $cart->items;

        foreach ($cart->items as $key => $item);
        $designer_name = $item['item']['designer_name'];

        $credentials = PaypalCredentials::where('user_id',$designer_name)->where('store_status',1)->first();

        if(!$credentials){
            Session::flash('invalid_credentials','The payment details are invalid, Contact administrator.');
            return redirect()->back();
            exit;
        }

        $totalPrice = $cart->totalPrice;

        if($totalPrice == 0){
            return $this->add_to_project_library_multiple($request);
            exit;
        }
        $invoice = time();

        $data = [
            'receivers'  => [
                [
                    'email' => $credentials->paypal_email, //'sb-hagbw5007710@personal.example.com',
                    'amount' => $totalPrice
                ]
            ],
            'ipAddress' => $_SERVER['REMOTE_ADDR'],
            'memo' => 'Example',
            'currencyCode' => $credentials->currency_code,
            'payer' => 'SENDER', // (Optional) Describes who pays PayPal fees. Allowed values are: 'SENDER', 'PRIMARYRECEIVER', 'EACHRECEIVER' (Default), 'SECONDARYONLY'
            'return_url' => url('payment/success/'.$invoice),
            'cancel_url' => url('payment/cancel/'.$invoice),
            'requestEnvelope' => [
                "errorLanguage" => "en_US",
                "detailLevel" => "ReturnAll"
            ]
        ];

        $provider = PayPal::setProvider('adaptive_payments');
        $response = $provider->createPayRequest($data);
		
		//print_r($credentials);
		//echo '<pre>';
		//print_r($response['error'][0]['parameter'][1]);
		//echo '</pre>';
			//exit;

        if (strtoupper($response['responseEnvelope']['ack']) == 'FAILURE') {
            Session::flash('invalid_credentials','Unable to make payment for this store.Please contact administrator.');
            //$response['error'][0]['message']
            return redirect()->back();
        }
        if (strtoupper($response['responseEnvelope']['ack']) == 'SUCCESS') {
            if(!$request->user_address){
                $add = new UserAddress;
                $add->user_id = Auth::user()->id;
                $add->type = 'billing';
                $add->first_name = $request->first_name;
                $add->last_name = $request->last_name;
                $add->email = $request->email;
                $add->mobile = $request->mobile;
                $add->address = $request->address;
                $add->city = $request->city;
                $add->state = $request->state;
                $add->zipcode = $request->zipcode;
                $add->is_default = 0;
                $add->status = 1;
                $add->created_at = Carbon::now();
                $save = $add->save();

                $address_id = $add->id;
            }else{
                $address_id = $request->user_address;
            }


            //$address = UserAddress::where('id',$address_id)->first();

            /* Orders table data insertion */

            $order = new Orders;
            $order->user_id = Auth::user()->id;
            $order->designer_id = $designer_name;
            $order->order_number = $invoice;
            $order->order_date = Carbon::now();
            $order->order_status = 'Pending';
            $order->payKey = $response['payKey'];
            $order->order_description = 'Payment towards order '.$invoice;
            $order->ordered_amt = $totalPrice;
            $order->booking_datebooked = date('Y-m-d');
            $order->booking_timebooked = date('H:i:s');
            $order->booking_cart_total = count($totalItems);
            $order->total = $totalPrice;
            $order->address_id = $address_id;
            $order->cart_total = serialize($cart);
            $order->created_at = Carbon::now();
            $order->save();


            foreach ($cart->items as $keys => $it) {
                if($it['item']['sale_price'] != 0){
                    $price = $it['item']['sale_price'];
                }else{
                    $price = $it['item']['price'];
                }

                $bp = new Booking_process;
                $bp->user_id = Auth::user()->id;
                $bp->order_id = $order->id;
                $bp->category_id = 1;
                $bp->product_id = $it['item']['id'];
                $bp->product_name = $it['item']['product_name'];
                $bp->product_quantity = $it['qty'];
                $bp->bookingdate = date('Y-m-d');
                $bp->bookingtime = date('H:i:s');
                $bp->setpayment = $price;
                $bp->subtotal = $totalPrice;
                $bp->created_at = Carbon::now();
                $bp->save();
            }

            //$request->session()->put('payKey', $response['payKey']);
            $redirect_url = $provider->getRedirectUrl('approved', $response['payKey']);
            return redirect($redirect_url);
        }
    }

    function success(Request $request){
        $order_id = $request->order_id;
        $orders = Orders::where('order_number',$order_id)->first();

        if(!$orders){
            return view('shopping.notfound');
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
            return redirect('order/invoice/'.$order_id);
        }else{
            return view('shopping.notfound');
        }
    }

    function cancel(Request $request){
        $order_id = $request->orderId;
        $orders = Orders::where('order_number',$order_id)->first();
        if(!$orders){
            return view('shopping.notfound');
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
        return redirect('cancel/'.$order_id);
    }

    function payment_invoice(Request $request){
        $orderId = $request->orderId;
        $page = '';
        $perPage = '';
        $orders = DB::table('orders')->where('order_number',$orderId)->first();
        if(!$orders){
            return view('shopping.notfound');
            exit;
        }
        $booking_process = DB::table('booking_process')->where('order_id',$orders->id)->get();
        return view('shopping.order-success',compact('page','perPage','orders','booking_process'));
    }

    function payment_faild(Request $request){
        $orderId = $request->orderId;
        $page = '';
        $perPage = '';
        $orders = DB::table('orders')->where('order_number',$orderId)->first();
        return view('shopping.order-faild',compact('page','perPage','orders'));
    }

    function cancel_order(Request $request){
        $orderId = $request->orderId;
        $page = '';
        $perPage = '';
        $orders = DB::table('orders')->where('order_number',$orderId)->first();
        return view('shopping.order-cancled',compact('page','perPage','orders'));
    }

    function print_order(Request $request){
        $orderId = $request->orderId;
        $orders = DB::table('orders')->where('order_number',$orderId)->first();
        $booking_process = DB::table('booking_process')->where('order_id',$orders->id)->get();
        if(!$orders){
            return view('shopping.notfound');
            exit;
        }

        $pdf = PDF::loadView('shopping.pdf-view',compact('orders','booking_process'));
        return $pdf->download($orderId.'.pdf');
    }

    function retry_order(Request $request){
        $orderId = $request->orderId;
        $orders = DB::table('orders')->where('order_number',$orderId)->first();
        if(!$orders){
            return view('shopping.notfound');
            exit;
        }
        $provider = new AdaptivePayments;
        $redirect_url = $provider->getRedirectUrl('approved', $orders->payKey);
        return redirect($redirect_url);
    }
}
