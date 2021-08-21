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

class OldCheckout extends Controller
{
    function __construct(){
    	$this->middleware('auth');

        /*$paypalConfig = Config::get('paypal');
        $this->apiContext = new ApiContext(new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret'])
        );
        $this->apiContext->setConfig($paypalConfig['settings']);*/
    }

	function getDesignerCredentials(){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $data = $cart->items;

        foreach ($cart->items as $key => $item);
        $designer_name = $item['item']['designer_name'];

        $credentials = PaypalCredentials::where('user_id',$designer_name)->first();

        $paypalConfig = [
            'mode'    => env('PAYPAL_MODE', ''), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'username'    => $credentials->paypal_username,
                'password'    => $credentials->paypal_password,
                'secret'      => $credentials->paypal_secret,
                'certificate' => '',
                'app_id'      => $credentials->paypal_app_id ? $credentials->paypal_app_id : '', // Used for testing
                // Adaptive Payments API in sandbox
                // mode
            ],
            'live' => [
                'username'    => $credentials->paypal_username,
                'password'    => $credentials->paypal_password,
                'secret'      => $credentials->paypal_secret,
                'certificate' => '',
                'app_id'      => $credentials->paypal_app_id ? $credentials->paypal_app_id : '', // Used for Adaptive
                // Payments API
            ],
            'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => env('PAYPAL_CURRENCY', 'USD'),
            'billing_type'   => 'MerchantInitiatedBilling',
            'notify_url'     => '', // Change this accordingly for your application.
            'locale'         => '', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => true, // Validate SSL when creating api client.
            'invoice_prefix' => env('PAYPAL_INVOICE_PREFIX', 'PAYPAL')
        ];

        return $paypalConfig;
    }

    function place_order(Request $request){

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $data = $cart->items;

        foreach ($cart->items as $key => $item);
        $designer_name = $item['item']['designer_name'];
		
		//echo $designer_name;
		//exit;

        $credentials = PaypalCredentials::where('user_id',$designer_name)->first();
        if(!$credentials){
            Session::flash('invalid_credentials','The payment details are invalid, Contact administrator.');
            return redirect()->back();
            exit;
        }

		$config = array();
		$config['mode'] = env('PAYPAL_MODE', '');
		$config['sandbox']['username'] = $credentials->paypal_username;
		$config['sandbox']['password'] = $credentials->paypal_password;
		$config['sandbox']['secret'] = $credentials->paypal_secret;
		$config['sandbox']['app_id'] = $credentials->paypal_app_id ? $credentials->paypal_app_id : '';
		$config['sandbox']['certificate'] = '';
		$config['payment_action'] = 'Sale';
		$config['currency'] = 'USD';
		$config['billing_type'] = 'MerchantInitiatedBilling';
		$config['validate_ssl'] = true;
		$config['invoice_prefix'] = 'PAYPAL';
		$config['locale'] = 'en_US';
		$config['notify_url'] = '';

        $paypalConfig = $this->getDesignerCredentials();

        //$paypalConfig = Config::get('paypal');
        //$provider = new ExpressCheckout;
        //$provider->setApiCredentials($paypalConfig);

		

        $totalPrice = $cart->totalPrice;

        if($totalPrice == 0){
            return $this->add_to_project_library_multiple($request);
            //exit;
        }

        $invoice = time();


        $data = [];

        $data['items'] = [];
        foreach ($cart->items as $key => $item) {
            if($item['item']['sale_price'] != 0){
                $price = $item['item']['sale_price'];
            }else{
                $price = $item['item']['price'];
            }

            $itemDetail=[
                'name' => $item['item']['product_name'],
                'price' => $price,
                'desc'  => $item['item']['product_name'],
                'qty' => $item['qty']
            ];

            $data['items'][] =$itemDetail;
        }

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['invoice_id'] = $invoice;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = url('payment/success/'.$invoice);
        $data['cancel_url'] = url('payment/cancel/'.$invoice);
        $data['total'] = $total;

        $provider = new ExpressCheckout;
		$provider->setApiCredentials($paypalConfig);
        $response = $provider->setExpressCheckout($data);
        //$response = $provider->setExpressCheckout($data, true);
		
		
        if($response['paypal_link'] != ''){

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
            $order->order_number = $invoice;
            $order->order_date = Carbon::now();
            $order->order_status = 'Pending';
            $order->order_description = 'Payment towards order '.$invoice;
            $order->ordered_amt = $totalPrice;
            $order->booking_datebooked = date('Y-m-d');
            $order->booking_timebooked = date('H:i:s');
            $order->booking_cart_total = count($data);
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

            return redirect($response['paypal_link']);
        }else{
            Session::flash('invalid_credentials','The payment details are invalid, Contact administrator.');
            return redirect()->back();
        }


       /* try {
            $provider = new ExpressCheckout;
            $provider->setApiCredentials($paypalConfig);
            $response = $provider->setExpressCheckout($data);
            $response = $provider->setExpressCheckout($data, true);
            if($response['paypal_link'] != ''){
                return redirect($response['paypal_link']);
            }else{
                Session::flash('invalid_credentials','The payment details are invalid, Contact administrator.');
                return redirect()->back();
            }
        }catch (\Throwable $e){
            echo $e->getMessage();
        }*/

    }

    public function cancel(Request $request)
    {
        $orderId = $request->orderId;
		
		$check = Orders::where('order_number',$orderId)->count();

        if($check > 0){
			$provider = PayPal::setProvider('express_checkout');
			$response = $provider->getExpressCheckoutDetails($request->token);

			$array = array('order_token' => $request->token,'order_status' => 'Cancled');
			$ins = Orders::where('order_number',$orderId)->update($array);
			return redirect('cancel/'.$orderId);
		}else{
			return redirect('shop-patterns');
        }
    }



    function remove_all_items(){
        Session::forget('cart');
    }

    public function success(Request $request)
    {
		$paypalConfig = $this->getDesignerCredentials();

        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $data = $cart->items;
        $data = [];

        $invoice = $request->order_id;

        $data['items'] = [];
        foreach ($cart->items as $key => $item) {
            if($item['item']['sale_price'] != 0){
                $price = $item['item']['sale_price'];
            }else{
                $price = $item['item']['price'];
            }

            $itemDetail=[
                'name' => $item['item']['product_name'],
                'price' => $price,
                'desc'  => $item['item']['product_name'],
                'qty' => $item['qty']
            ];

            $data['items'][] =$itemDetail;
        }

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['invoice_id'] = $invoice;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = url('payment/success/'.$invoice);
        $data['cancel_url'] = url('payment/cancel/'.$invoice);
        $data['total'] = $total;

        $provider = PayPal::setProvider('express_checkout');
        $provider->setApiCredentials($paypalConfig);

        $response2 = $provider->getExpressCheckoutDetails($request->token);
        $response1 = $provider->doExpressCheckoutPayment($data, $request->token, $response2['PAYERID']);
        $response = $provider->getExpressCheckoutDetails($request->token);

		/*echo '<pre>';
        print_r($response);
        echo '</pre>';
        exit;*/
      

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

        	$order_id = $request->order_id;

        	$array = array('order_token' => $request->token,'order_status' => $response['ACK'],'payer_email' => $response['EMAIL'],'payerid' => $response['PAYERID'],'payer_first_name' => $response['FIRSTNAME'],'payer_last_name' => $response['LASTNAME'],'updated_at' => Carbon::now());

        	$ins = Orders::where('order_number',$order_id)->update($array);
            $this->remove_all_items();
           return redirect('order/invoice/'.$order_id);
        //return view('shopping.order-success',compact('orders','booking_process'));
			exit;
        }

        $array = array('order_token' => $request->token,'order_status' => $response['ACK'],'payer_email' => $response['EMAIL'],'payerid' => $response['PAYERID'],'payer_first_name' => $response['FIRSTNAME'],'payer_last_name' => $response['LASTNAME'],'updated_at' => Carbon::now());
        $ins = Orders::where('order_number',$order_id)->update($array);
        return redirect('order/faild/'.$order_id);
    }

    function payment_invoice(Request $request){
    	$orderId = $request->orderId;
        $page = '';
        $perPage = '';
    	$orders = DB::table('orders')->where('order_number',$orderId)->first();
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


    /* if product is free */

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


    function add_to_project_library_multiple($request){
        $oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $data = $cart->items;
        $totalPrice = $cart->totalPrice;

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

        $invoice = time();
               //$address = UserAddress::where('id',$address_id)->first();

            /* Orders table data insertion */

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
            $order->booking_cart_total = count($data);
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
        $this->remove_all_items();

        return redirect('order/invoice/'.$invoice);
    }
}
