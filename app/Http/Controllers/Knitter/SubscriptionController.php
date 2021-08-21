<?php

namespace App\Http\Controllers\Knitter;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\IPNStatus;
use App\Models\Item;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\AdaptivePayments;
use Srmklive\PayPal\Services\ExpressCheckout;
use Session;
use Auth;
use App\User;
use Carbon\Carbon;
use App\Models\Subscription;
use App\Models\PaypalPayments;
use App\Models\UserAddress;
use App\Models\Country;

class SubscriptionController extends Controller
{

	protected $provider;

    public function __construct()
    {
        $this->provider = new ExpressCheckout();
    }

    function index(){
        $subscriptions = Subscription::where('status',1)->get();
		$paypalsubscription = PaypalPayments::where('user_id',Auth::user()->id)->where('status','Success')->where('is_cancelled',0)->orderBy('id','DESC')->first();
		$address = UserAddress::where('user_id',Auth::user()->id)->orderBy('id','desc')->where('status',1)->get();
		$country = Country::all();
    	//return view('knitter.subscriptions.index',compact('subscriptions','paypalsubscription','address','country'));
		if(Auth::user()->hasRole('Knitter') && Auth::user()->hasRole('Designer')){
            return view('knitter.subscriptions.designer-subscription',compact('subscriptions','paypalsubscription','address','country'));
        }else if(Auth::user()->hasRole('Knitter')){
            return view('knitter.subscriptions.knitter-subscription',compact('subscriptions','paypalsubscription','address','country'));
        }else if(Auth::user()->hasRole('Designer')){
            return view('knitter.subscriptions.designer-subscription',compact('subscriptions','paypalsubscription','address','country'));
        }else{
             return view('knitter.subscriptions.index',compact('subscriptions','paypalsubscription','address','country'));
        }
    }


    public function getExpressCheckout(Request $request)
    {
    	$sub_type = $request->get('stype');
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $newSubscription = $request->subscription;
		
        $cart = $this->getCheckoutData($recurring,$sub_type,$newSubscription);
		
        try {
            $response = $this->provider->setExpressCheckout($cart, $recurring);

            return redirect($response['paypal_link']);
        } catch (\Exception $e) {
            $invoice = $this->createInvoice($cart, 'Invalid');

            session()->put(['code' => 'danger', 'message' => "Error processing PayPal payment for Order $invoice->id!"]);
        }
    }

     protected function getCheckoutData($recurring = false,$sub_type,$newSubscription)
    {
        $data = [];

        $order_id = Invoice::all()->count() + 1;

$subscription = Subscription::where('id',$newSubscription)->select('name','price_month','offer_price','price_year')->first();

        if($sub_type == 'yearly'){
        	if($recurring == true){
        		$r = 'recurring';
        		$stype = 'Yearly';
    			$amt = $subscription->price_month;
        	}else{
        //$sub = Subscription::where('')   
        		$r = '';
        		$stype = 'Yearly';
    			$amt = ($subscription->offer_price == 0) ? $subscription->price_year : $subscription->offer_price;
        	}
    		
    	}else{
    		$stype = 'Monthly';
    		$amt = $subscription->price_month;
    	}


    	if($sub_type == 'yearly'){
    		if($recurring == true){
    			$data['items'] = [
                [
                    'name'  => $stype.' Subscription '.config('paypal.invoice_prefix').' #'.$order_id,
                    'price' => $amt,
                    'qty'   => 1,
                ],
            ];

            $data['return_url'] = url('knitter/paypal/ec-checkout-success?stype='.$sub_type.'&mode=recurring&subscription='.$newSubscription.'');
            $data['cancel_url'] = url('/knitter/subscription/cancel-payment?stype='.$sub_type.'&mode=recurring&subscription='.$newSubscription.'');
            $data['subscription_desc'] = $subscription->name.' '.$stype.' Subscription '.config('paypal.invoice_prefix').' #'.$order_id;
	        }else{
	        	$data['items'] = [
	                [
	                    'name'  => $subscription->name.' '.$stype.' Subscription '.config('paypal.invoice_prefix').' #'.$order_id,
	                    'price' => $amt,
	                    'qty'   => 1,
	                ],
	            ];

	            $data['return_url'] = url('knitter/paypal/ec-checkout-success?stype='.$sub_type.'&subscription='.$newSubscription.'');
	            $data['cancel_url'] = url('/knitter/subscription/cancel-payment?stype='.$sub_type.'&subscription='.$newSubscription.'');
	        }
    	}else{
    		$data['items'] = [
                [
                    'name'  => $subscription->name.' '.$stype.' Subscription '.config('paypal.invoice_prefix').' #'.$order_id,
                    'price' => $amt,
                    'qty'   => 1,
                ],
            ];

            $data['return_url'] = url('knitter/paypal/ec-checkout-success?stype='.$sub_type.'&subscription='.$newSubscription.'');
            $data['cancel_url'] = url('/knitter/subscription/cancel-payment?stype='.$sub_type.'&subscription='.$newSubscription.'');
    	}

        

        $data['invoice_id'] = time().'-'.$order_id;
        $data['invoice_description'] = $subscription->name.' '.$stype." Subscription #$order_id Invoice";
        

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;
		
		

        return $data;
    }

     protected function createInvoice($token,$response,$cart, $status,$recurring,$sub_type,$PayerID,$subscription)
    {


    	if($recurring == true){
    		$r = 1;
    	}else{
    		$r = 0;
    	}

    	if($sub_type == 'yearly'){
    		$s = 'Yearly';
    	}else{
    		$s = 'Monthly';
    	}

    	$time = time();


        $invoice = new Invoice();
        $invoice->user_id = Auth::user()->id;
        $invoice->subscription_id = $subscription;
        $invoice->sub_type = $s;
        $invoice->invoice_id = $time;
        //$invoice->transaction_id = $transaction_id;
        $invoice->title = $cart['invoice_description'];
        $invoice->qty = 1;
        $invoice->price = $cart['total'];
        if (!strcasecmp($status, 'Completed') || !strcasecmp($status, 'Processed')) {
            $invoice->paid = 1;
        } else if(strcasecmp($status, 'Pending')) {
            $invoice->paid = 2;
        }else{
        	$invoice->paid = 0;
        }
        $invoice->payerid = $PayerID;
        $invoice->is_recurring = $r;

        $invoice->TOKEN = $token;
        $invoice->TIMESTAMP = $response['TIMESTAMP'];
        $invoice->CORRELATIONID = $response['CORRELATIONID'];
        $invoice->ACK = $response['ACK'];
        if(isset($response['PROFILEID'])){
        	$invoice->PROFILEID = $response['PROFILEID'];
        }else{
        	$invoice->PROFILEID = '';
        }
        
        if(isset($response['PROFILESTATUS'])){
        	$invoice->PROFILESTATUS = $response['PROFILESTATUS'];
        }else{
        	$invoice->PROFILESTATUS = '';
        }
        $invoice->fulldata = json_encode($response);
        $invoice->save();

        /*collect($cart['items'])->each(function ($product) use ($invoice) {
            $item = new Item();
            $item->invoice_id = $invoice->id;
            $item->item_name = $product['name'];
            $item->item_price = $product['price'];
            $item->item_qty = $product['qty'];

            $item->save();
        }); */

        $user = User::find(Auth::user()->id);
        $user->subscription_type = 2;
        
			if(Auth::user()->remainingDays() > 0){
				$pendingDays = Auth::user()->remainingDays();
            }else{
				$pendingDays = 0;
            }
			
        if($sub_type == 'yearly'){
        	if($recurring == true){
                $days = (int) 30 + $pendingDays;
        		$user->sub_exp = Carbon::now()->addDays($days);
        	}else{
                $days = (int) 365 + $pendingDays;
        		$user->sub_exp = Carbon::now()->addDays($days);
        	}
    		
    	}else{
            $days = (int) 30 + $pendingDays;
    		$user->sub_exp = Carbon::now()->addDays($days);
    	}
        $user->save();

        $user->subscription()->detach();
        $user->subscription()->attach([$subscription]);

        return $invoice;
    }

    public function notify(Request $request)
    {
        if (!($this->provider instanceof ExpressCheckout)) {
            $this->provider = new ExpressCheckout();
        }

        $post = [
            'cmd' => '_notify-validate',
        ];
        $data = $request->all();
        foreach ($data as $key => $value) {
            $post[$key] = $value;
        }

        $response = (string) $this->provider->verifyIPN($post);

        $ipn = new IPNStatus();
        $ipn->payload = json_encode($post);
        $ipn->status = $response;
        $ipn->save();
    }

    public function getAdaptivePay()
    {
        $this->provider = new AdaptivePayments();

        $data = [
            'receivers'  => [
                [
                    'email'   => 'johndoe@example.com',
                    'amount'  => 10,
                    'primary' => true,
                ],
                [
                    'email'   => 'janedoe@example.com',
                    'amount'  => 5,
                    'primary' => false,
                ],
            ],
            'payer'      => 'EACHRECEIVER', // (Optional) Describes who pays PayPal fees. Allowed values are: 'SENDER', 'PRIMARYRECEIVER', 'EACHRECEIVER' (Default), 'SECONDARYONLY'
            'return_url' => url('payment/success'),
            'cancel_url' => url('payment/cancel'),
        ];

        $response = $this->provider->createPayRequest($data);
        dd($response);
    }

     public function getExpressCheckoutSuccess(Request $request)
    {
        $recurring = ($request->get('mode') === 'recurring') ? true : false;
        $subscription = $request->get('subscription');
        $subscr = Subscription::where('id',$subscription)->select('name','price_month','offer_price','price_year')->first();

        if($request->get('stype') === 'yearly'){
        	if($recurring == true){
        		$sub_type = 'yearly';
        		$amt = $subscr->price_month;
        	}else{
        		$sub_type = 'yearly';
        		$amt = ($subscr->offer_price == 0) ? $subscr->price_year : $subscr->offer_price;
        	}
        		
        	}else{
        		$sub_type = 'monthly';
        		$amt = $subscr->price_month;
        	}
        $token = $request->get('token');
        $PayerID = $request->get('PayerID');

        $cart = $this->getCheckoutData($recurring,$sub_type,$subscription);
		
		//print_r($cart);
		//exit;

        // Verify Express Checkout Token
        $response = $this->provider->getExpressCheckoutDetails($token);
		

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
        	if($request->get('stype') === 'yearly'){
        		if ($recurring === true) {
        			$response = $this->provider->createMonthlySubscription($response['TOKEN'], $amt, $cart['subscription_desc']);

        			if (!empty($response['PROFILESTATUS']) && in_array($response['PROFILESTATUS'], ['ActiveProfile', 'PendingProfile'])) {
                    $status = 'Processed';
                } else {
                    $status = 'Invalid';
                }

                //echo 'yearly recurring';
                //print_r($response);
                $invoice = $this->createInvoice($token,$response,$cart, $status,$recurring,$sub_type,$PayerID,$subscription);
        		}else{
        			//$transaction_id = $response['TRANSACTIONID'];
        			$payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
                $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
                //echo 'yearly no recurring';
                //print_r($payment_status);
                $invoice = $this->createInvoice($token,$payment_status,$cart, $status,$recurring,$sub_type,$PayerID,$subscription);
        		}
        	}else{
        		//$transaction_id = $response['TRANSACTIONID'];
        		$payment_status = $this->provider->doExpressCheckoutPayment($cart, $token, $PayerID);
                $status = $payment_status['PAYMENTINFO_0_PAYMENTSTATUS'];
                //echo 'monthly';
                //print_r($payment_status);
                $invoice = $this->createInvoice($token,$payment_status,$cart, $status,$recurring,$sub_type,$PayerID,$subscription);
        	}

            if ($invoice->paid) {
                Session::flash('message',"Order $invoice->invoice_id has been paid successfully!");
            } else {
                Session::flash('message', "Error processing PayPal payment for Order $invoice->invoice_id!");
            }

            return view('knitter.subscriptions.success',compact('response','status'));
        }
    }

    function cancel_payment(Request $request){
        $subscription = $request->get('subscription');
    	$recurring = ($request->get('mode') === 'recurring') ? true : false;
    	$sub_type = ($request->get('stype') === 'yearly') ? 'yearly' : 'monthly';
    	$token = $request->get('token');

        $subscr = Subscription::where('id',$subscription)->select('name','price_month','offer_price','price_year')->first();

    	if($sub_type == 'yearly'){
    		if($recurring == true){
    			$total = $subscr->price_month;
    			$des = $subscr->name.' Yearly Subscription';
    			$s = 'Yearly';
    			$r = 1;
    		}else{
    			$total = ($subscr->offer_price == 0) ? $subscr->price_year : $subscr->offer_price;
    			$des = $subscr->name.'Yearly Subscription';
    			$s = 'Yearly';
    			$r = 0;
    		}
    	}else{
    		$total = $subscr->price_month;
    		$des = $subscr->name.'Monthly Subscription';
    		$s = 'Monthly';
    		$r = 0;
    	}

    	$cart = $this->getCheckoutData($recurring,$sub_type,$subscription);
    	$time = time();


        $invoice = new Invoice();
        $invoice->user_id = Auth::user()->id;
        $invoice->subscription_id = $subscription;
        $invoice->sub_type = $s;
        $invoice->invoice_id = $time;
        $invoice->title = $des;
        $invoice->qty = 1;
        $invoice->price = $total;
        $invoice->paid = 0;
        $invoice->is_recurring = $r;
        $invoice->TOKEN = $token;
        $invoice->ACK = 'Payment cancled by user';
        $invoice->save();
    	return view('knitter.subscriptions.cancel');
    }
}
