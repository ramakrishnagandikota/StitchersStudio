<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Session;
use Auth;
use App\User;
use Carbon\Carbon;
use App\Models\Subscription;
use Illuminate\Support\Facades\Http;
use DB;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use App\Models\PaypalPayments;
use App\Models\PaypalPlans;

class PaypalSubscriptionController extends Controller
{

	function checkTime(){
		
		if(Session::get('time')){
			$sessionTime = Session::get('time');
		}else{
			$sessionTime = 0;
		}

		if($sessionTime == 0){
			return 0;
			exit;
		}

		$date1 = date('Y-m-d H:i:s',strtotime($sessionTime));
    	$date2 = date('Y-m-d H:i:s',strtotime(Carbon::now()));
    	$time1 = strtotime($date1);
    	$time2 = strtotime($date2);
    	$hour = abs($time2 - $time1)/(60*60);
    	return (int) $hour;
	}

    function getPlans(){
    	$jsonArray = array();

    	$subscription = PaypalPlans::where('plan_id','!=','0')->get();

    	for ($i=0; $i < count($subscription); $i++) { 
    		$jsonArray[$i]['plan_id'] = $subscription[$i]->plan_id;
    		$jsonArray[$i]['name'] = $subscription[$i]->name;
    		$jsonArray[$i]['price'] = $subscription[$i]->price;
    		$jsonArray[$i]['is_recurring'] = ($subscription[$i]->is_recurring == 1) ? true : false; 
    	}

        $array = array('subscription' => $jsonArray);
    	return response()->json(['data' => $array]);
    }

    function paypalLoginBasicAuth(){
    	
    	$body = "grant_type=client_credentials";
    	//$stream = array('grant_type' => 'client_credentials');
    	
    	$client = new \GuzzleHttp\Client(['auth' => [
    			'AXRGs14jUWPzvLl1dI7c3z0VcsWTUhYI-kysNWpsR051Wrbi_-s4bZOa3fswFicHFtPdjgS14E2qSY4U', 
    			'EGKvs5aIMuhUzgjb4sWEBF_pTIEzGs-lwrPUVgsbN6jOcbXE1AjomygejGSeVkJ20POmCsFRZOBnd9YV']
    		]);
		$request = $client->request('POST', 'https://api.paypal.com/v1/oauth2/token',['body' => $body]);
    	$response = $request->getBody();
    	//return $response;
    	$data = json_decode($response);

    	$access_token = $data->access_token;
		$token_type = $data->token_type;
		$app_id = $data->app_id;
		$expires_in = $data->expires_in;
		$nonce = $data->nonce;
    	Session::put('token',$token_type.' '.$access_token);
    	Session::put('time',Carbon::now());
    	return $data->token_type.' '.$data->access_token;
    }

    function createSubscription(Request $request){
    	$time = $this->checkTime();
    	
    	if($time == 0){
    		$token = $this->paypalLoginBasicAuth();
    	}else{
    		$token = Session::get('token');
    	}
    	
    	if($token){
    		$plan_id = $request->plan_id;
    		$body = '{
				  "plan_id": "'.$plan_id.'",
				  "start_time": "'.Carbon::now()->addMinutes(1)->toISOString().'",
				  "quantity": "1",
				  "shipping_amount": {
				    "currency_code": "USD",
				    "value": "0"
				  },
				  "subscriber": {
				    "name": {
				      "given_name": "'.Auth::user()->first_name.'",
				      "surname": "'.Auth::user()->last_name.'"
				    },
				    "email_address": "'.Auth::user()->email.'",
				    "shipping_address": {
				      "name": {
				        "full_name": "'.Auth::user()->first_name.' '.Auth::user()->last_name.'"
				      },
				      "address": {
				        "address_line_1": "2211 N First Street",
				        "address_line_2": "Building 17",
				        "admin_area_2": "San Jose",
				        "admin_area_1": "CA",
				        "postal_code": "95131",
				        "country_code": "US"
				      }
				    }
				  },
				  "application_context": {
				    "brand_name": "Knitfit",
				    "locale": "en-US",
				    "shipping_preference": "SET_PROVIDED_ADDRESS",
				    "user_action": "SUBSCRIBE_NOW",
				    "payment_method": {
				      "payer_selected": "PAYPAL",
				      "payee_preferred": "IMMEDIATE_PAYMENT_REQUIRED"
				    },
				    "return_url": "'.url('/api/subscriptionPaymentSuccess?user_id='.base64_encode(Auth::user()->id)).'",
				    "cancel_url": "'.url('/api/subscriptionPaymentFail?user_id='.base64_encode(Auth::user()->id)).'"
				  }
				}';
		$client = new \GuzzleHttp\Client(['headers' => [
		        'Content-Type' => 'application/json',
				'Authorization' => $token
		    ]]);
    	$response = $client->post('https://api.sandbox.com/v1/billing/subscriptions',['body' => $body]);
    	$res = $response->getBody();
    	$data = json_decode($res);

    	
		$url = $data->links[0]->href;
		$ba_token = explode('ba_token=', $url);
		$token = $ba_token[1];
		$subscription_id = $data->id;
		$status = $data->status;

		$sub = new PaypalPayments;
		$sub->user_id = Auth::user()->id;
		$sub->plan_id = $id;
		$sub->subscription_id = $subscription_id;
		$sub->ba_token = $token;
		$sub->status = $status;
		$sub->created_at = Carbon::now();
		$sub->ipaddress = $_SERVER['REMOTE_ADDR'];
		$save = $sub->save();


		return $url;
    	}else{
    		return response()->json(['error' => 'Token expired, Try again.']);
    	}
    }

    function paypalPaymentSuccess(Request $request){
    	$user_id = base64_decode($request->get('user_id'));
    	if($user_id){
            Auth::loginUsingId($user_id, true);
            session(['user_id' => Auth::user()->id]);
        }else{
            return redirect('login');
        }

        $prev =  DB::table('paypal_payments')->where('user_id',$user_id)->orderBy('id','DESC')->first();

		$expired = Auth::user()->isSubscriptionExpired();

		if($expired == 1){
    		$last = Auth::user()->remainingDays();
    	}else{
    		$last = 0;
    	}

    	if($prev->plan_id == 'P-7TF98787S4969684BL3HCQ7A'){  /* Yearly recurring monthly */
    		$numDays = 30;
		}else if($prev->plan_id == 'P-1G8985561J6657318L3GUWZI'){ /* yearly */
 			$numDays = 365;
		}else if($prev->plan_id == 'P-3XB87451KC365513NL3FGE3A'){ /* monthly */
			$numDays = 30;
		}else{
			$numDays = 0;
		}

		$days = (int) $numDays + $last;

		$array = array('token' => $request->token,'status' => 'Success','updated_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR'],'expiry' => Carbon::now()->addDays($days));

		$ins =  DB::table('paypal_payments')->where('user_id',$user_id)->where('ba_token',$request->ba_token)->update($array);
		if($ins){
			Session::flash('success','Payment successful');
		}else{
			Session::flash('error','Payment unsuccessful');
		}
		return redirect('knitterSubscriptions');
    }

    function paypalPaymentFail(Request $request){
		$user_id = base64_decode($request->get('user_id'));
    	if($user_id){
            Auth::loginUsingId($user_id, true);
            session(['user_id' => Auth::user()->id]);
        }else{
            return redirect('login');
        }
		
		$array = array('user_id' => Auth::user()->id,'subscription_id' => $request->subscription_id,'ba_token' => $request->ba_token,'token' => $request->token,'status' => 'Cancled','created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);

		$ins =  DB::table('new_subscription')->where('user_id',Auth::user()->id)->where('ba_token',$request->ba_token)->update($array);
		if($ins){
			Session::flash('success','Payment successful');
		}else{
			Session::flash('error','Payment unsuccessful');
		}
		return redirect('knitterSubscriptions');
	}
}
