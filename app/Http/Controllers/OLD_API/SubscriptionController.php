<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\Subscription;
use App\Models\SubscriptionProperties;
use App\Models\Invoice;

class SubscriptionController extends Controller
{

	function sendJsonData($data){
        $sub = (Auth::user()->subscription_type == 1) ? 'Free' : 'Basic';
		return response()->json(['data' => $data,'user_subscription' => $sub]);
	}

    function index(){
    	$jsonArray = array();
    	$subscription = Subscription::select('id','name','price_month','price_year')->where('status',1)->get();

    	for ($i=0; $i < count($subscription); $i++) {
    		$jsonArray[$i]['id'] = $subscription[$i]->id;
    		$jsonArray[$i]['name'] = $subscription[$i]->name;
    		$jsonArray[$i]['price_month'] = $subscription[$i]->price_month;
    		$jsonArray[$i]['price_year'] = $subscription[$i]->price_year;
            $jsonArray[$i]['offer_price'] = $subscription[$i]->offer_price;
    		$jsonArray[$i]['details'] = SubscriptionProperties::where('subscriptions_id',$subscription[$i]->id)->select('property_name','property_limit','property_description')->get();
    	}

    	$array = array('subscription' => $jsonArray);
    	return $this->sendJsonData($array);
    }

	function getMyOrder(){
        $jsonArray = array();
        $invoice = Invoice::where('user_id',Auth::user()->id)->orderBy('id','desc')->take(1)->get();
        for ($i=0; $i < count($invoice); $i++) { 
            $jsonArray[$i]['invoice_id'] = $invoice[$i]->invoice_id;
            $jsonArray[$i]['date'] = date('d/M/Y',strtotime($invoice[$i]->created_at));
        }
        $array = array('order_details' => $jsonArray);
        return response()->json(['data' => $array]);
    }


}
