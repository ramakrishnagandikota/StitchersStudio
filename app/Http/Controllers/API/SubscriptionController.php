<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\Subscription;
use App\Models\SubscriptionProperties;
use App\Models\Invoice;
use App\Models\UserMeasurements;
use DB;

class SubscriptionController extends Controller
{

	function sendJsonData($data){
		$measurements = UserMeasurements::where('user_id',Auth::user()->id)->count();
		$projects = Auth::user()->projects()->where('is_archive',0)->where('is_deleted',0)->count();
        $sub = Auth::user()->isFree() ? 'Free' : 'Basic';
		$cancelled = DB::table('paypal_payments')->where('user_id',Auth::user()->id)->where('status','Success')->where('is_cancelled',0)->orderBy('id','DESC')->first();
		if($cancelled){
			$subscription_id = $cancelled->subscription_id;
			$canc = true;
		}else{
			$subscription_id = 0;
			$canc = false;
		}
		if(Auth::user()->isFree() == true){
			if($measurements == 0){
				$measurements = true;
			}else{
				$measurements = false;
			}
			
			if($projects == 0){
				$projects = true;
			}else{
				$projects = false;
			}
			
		}else{
			$measurements = true;
			$projects = true;
			
		}
		
		return response()->json(['data' => $data,'user_subscription' => $sub,'no_of_days_remaining' => Auth::user()->remainingDays(),'expiry' => date('d/F/Y',strtotime(Auth::user()->sub_exp)),'is_cancelled' => $canc,'measurements' => $measurements,'projects' => $projects,'subscription_id' => $subscription_id]);
	}

    function index(){
		
		if((Auth::user()->remainingDays() == 0) && (Auth::user()->isBasic() == true)){
			Auth::user()->subscription()->detach();
			Auth::user()->subscription()->attach(['1']);
        }
		
    	$jsonArray = array();
    	$subscription = Subscription::select('id','name','price_month','price_year')->where('status',1)->get();

    	for ($i=0; $i < count($subscription); $i++) {
    		$jsonArray[$i]['id'] = $subscription[$i]->id;
    		$jsonArray[$i]['name'] = $subscription[$i]->name;
    		$jsonArray[$i]['price_month'] = $subscription[$i]->price_month;
    		$jsonArray[$i]['price_year'] = $subscription[$i]->price_year;
            if($subscription[$i]->name == 'Basic'){
    			$jsonArray[$i]['discount'] = '30%';
            	$jsonArray[$i]['offer_price'] = '24.99';
    		}else{
    			$jsonArray[$i]['price_year'] = '0';
            	$jsonArray[$i]['offer_price'] = $subscription[$i]->offer_price;
    		}
			$properties = SubscriptionProperties::where('subscriptions_id',$subscription[$i]->id)->select('property_name','property_limit','property_description','show')->where('status',1)->get();
    		for ($j=0;$j<count($properties);$j++){
                $jsonArray[$i]['details'][$j]['property_name'] = $properties[$j]->property_name;
                $jsonArray[$i]['details'][$j]['property_limit'] = $properties[$j]->property_limit;
                $jsonArray[$i]['details'][$j]['property_description'] = $properties[$j]->property_description;
                $jsonArray[$i]['details'][$j]['show'] = ($properties[$j]->show == 0) ? false : true;
            }
    		//$jsonArray[$i]['details'] = SubscriptionProperties::where('subscriptions_id',$subscription[$i]->id)->select('property_name','property_limit','property_description')->get();
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
