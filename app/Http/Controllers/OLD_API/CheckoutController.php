<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\API\Cart;
use App\Models\Products;
use App\Models\Product_images;
use Session;
use Srmklive\PayPal\Services\ExpressCheckout;
use PayPal;
use Redirect;
use DB;
use App\Models\Orders;
use App\Models\Booking_process;
use App\User;
use Carbon\Carbon;

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

        /* adding / selecting address */
        $address_id = $request->get('address');


        $order = new Orders;
        $order->user_id = Auth::user()->id;
        $order->order_number = $invoice;
        $order->order_date = Carbon::now();
        $order->order_status = 'Pending';
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


        $data = [];
        $data['items'] = [];

        foreach ($cart as $ca) {

        $date = strtotime(date('Y-m-d'));
        $dateStart = strtotime(date('Y-m-d',strtotime($ca->sale_price_start_date)));
        $dateEnd = strtotime(date('Y-m-d',strtotime($ca->sale_price_end_date)));

        if($date >= $dateStart && $date <= $dateEnd){
            $price = $ca->sale_price;
        }else{
            $price = $ca->price;
        }
            $itemDetail=[
                'name' => $ca->product_name,
                'price' => $price
            ];

            $data['items'][] =$itemDetail;
        }

        $data['invoice_id'] = $invoice;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = url('api/success/'.$invoice.'?user_id='.$user_id);
        $data['cancel_url'] = url('api/failure/'.$invoice.'?user_id='.$user_id);
        $data['total'] = $sum;

        $provider = new ExpressCheckout;
        $response = $provider->setExpressCheckout($data);
        $response = $provider->setExpressCheckout($data, true);
        return redirect($response['paypal_link']);
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
        $provider = PayPal::setProvider('express_checkout');
        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {

        	$array = array('order_token' => $response['TOKEN'],'order_status' => $response['ACK'],'payer_email' => $response['EMAIL'],'payerid' => $response['PAYERID'],'payer_first_name' => $response['FIRSTNAME'],'payer_last_name' => $response['LASTNAME'],'updated_at' => Carbon::now());

        	$ins = Orders::where('order_number',$order_id)->update($array);
            $cart = Cart::where('user_id',Auth::user()->id)->delete();
            return view('API.success',compact('order_id'));
        }

        $array = array('order_token' => $response['TOKEN'],'order_status' => $response['ACK'],'payer_email' => $response['EMAIL'],'payerid' => $response['PAYERID'],'payer_first_name' => $response['FIRSTNAME'],'payer_last_name' => $response['LASTNAME'],'updated_at' => Carbon::now());
        $ins = Orders::where('order_number',$order_id)->update($array);
        return view('API.failure',compact('order_id'));
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
        $provider = PayPal::setProvider('express_checkout');
        $response = $provider->getExpressCheckoutDetails($request->token);

        $array = array('order_token' => $response['TOKEN'],'order_status' => 'Cancled');
        $ins = Orders::where('order_number',$order_id)->update($array);
        return view('API.failure',compact('order_id'));
    }

}
