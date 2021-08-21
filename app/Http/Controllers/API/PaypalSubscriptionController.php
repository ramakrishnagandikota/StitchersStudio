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
use App\Models\UserAddress;
use App\Models\Country;
use Log;

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
	
	function index(Request $request){
		$user_id = base64_decode($request->get('user_id'));
		if(!$user_id){
            return redirect('login');
        }
		
		$ba_token = $request->get('ba_token');
		
		$success = DB::table('paypal_payments')->where('user_id',$user_id)->where('ba_token',$ba_token)->where('status','Success')->where('is_cancelled',0)->orderBy('id','DESC')->first();
		$faild = DB::table('paypal_payments')->where('user_id',$user_id)->where('ba_token',$ba_token)->where('status','Cancelled')->where('is_cancelled',1)->orderBy('id','DESC')->first();
		return view('API.paypal-subscription-success',compact('success','faild'));
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
    	
    	/*$client = new \GuzzleHttp\Client(['auth' => [
    			'AXRGs14jUWPzvLl1dI7c3z0VcsWTUhYI-kysNWpsR051Wrbi_-s4bZOa3fswFicHFtPdjgS14E2qSY4U', 
    			'EGKvs5aIMuhUzgjb4sWEBF_pTIEzGs-lwrPUVgsbN6jOcbXE1AjomygejGSeVkJ20POmCsFRZOBnd9YV']
    		]);*/
		
		$client = new \GuzzleHttp\Client(['auth' => [
    			'AaQjxixB5xHegAnBiZOU5AMZtSCg5SVwTlib40j5zEmCeS2vXC6NB8XJ8oBpw6YyC0H6p1CUW7DDHVkb', 
    			'EDJ01SF_QRjVbqDl50N7kTE-AkD-c1Ue1Hfk-TJd8kwhfaJsOPThR9B5N4jim0wHdxK29Dbc4VhOMExx']
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
		$request->validate([
			'plan_id' => 'required',
			'address_id' => 'required'
		]);
		
    	$time = $this->checkTime();
    	
    	if($time == 0){
    		$token = $this->paypalLoginBasicAuth();
    	}else{
    		$token = Session::get('token');
    	}
    	
    	if($token){
			
	/*if(Auth::user()->remainingDays() > 0){
			$prevousSub = DB::table('paypal_payments')->where('user_id',Auth::user()->id)->where('status','Success')->orderBy('id','DESC')->first();
			if($prevousSub){
				$sub_id = $prevousSub->subscription_id;
				$this->cancelSubscriptionAlreadyExists($sub_id,$token);
			}
		}*/
			
			$address_id = $request->address_id;
		
		
		
		$addr = UserAddress::where('id',$address_id)->first();
		
    		$plan_id = $request->plan_id;
    		$body = '{
				  "plan_id": "'.$plan_id.'",
				  "start_time": "'.Carbon::now()->addMinutes(2)->toISOString().'",
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
						"address_line_1": "'.$addr->address.'",
						"address_line_2": "'.$addr->state.'",
						"admin_area_2": "'.$addr->city.'",
						"admin_area_1": "'.$addr->country.'",
						"postal_code": "'.$addr->zipcode.'",
						"country_code": "US"
					  }
				    }
				  },
				  "application_context": {
				    "brand_name": "StitchersStudio",
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
    	//$response = $client->post('https://api.sandbox.paypal.com/v1/billing/subscriptions',['body' => $body]);
    	$response = $client->post('https://api.paypal.com/v1/billing/subscriptions',['body' => $body]);
    	$res = $response->getBody();
    	$data = json_decode($res);

    	
		$url = $data->links[0]->href;
		$ba_token = explode('ba_token=', $url);
		$token = $ba_token[1];
		$subscription_id = $data->id;
		$status = $data->status;

		$sub = new PaypalPayments;
		$sub->user_id = Auth::user()->id;
		$sub->plan_id = $plan_id;
		$sub->tranx_id = time();
		$sub->subscription_id = $subscription_id;
		$sub->ba_token = $token;
		$sub->status = $status;
		$sub->sent_data = $body;
		$sub->created_at = Carbon::now();
		$sub->ipaddress = $_SERVER['REMOTE_ADDR'];
		$save = $sub->save();


		return response()->json(['subscriptionUrl' => $url]);
    	}else{
    		return response()->json(['error' => 'Token expired, Try again.']);
    	}
    }

    function paypalPaymentSuccess(Request $request){
    	$user_id = base64_decode($request->get('user_id'));
    	if(!$user_id){
            return redirect('login');
        }
		$users = User::find($user_id);

        $prev =  DB::table('paypal_payments')->where('user_id',$user_id)->where('ba_token',$request->ba_token)->orderBy('id','DESC')->first();

		$expired = $users->isSubscriptionExpired();

		if($expired == 1){
    		$last = $users->remainingDays();
    	}else{
    		$last = 0;
    	}

    	/*if($prev->plan_id == 'P-7TF98787S4969684BL3HCQ7A'){  /* Yearly recurring monthly 
    		$numDays = 30;
		}else if($prev->plan_id == 'P-1G8985561J6657318L3GUWZI'){ /* yearly 
 			$numDays = 365;
		}else if($prev->plan_id == 'P-3XB87451KC365513NL3FGE3A'){ /* monthly 
			$numDays = 30;
		}else{
			$numDays = 0;
		}*/
		
		/*if($prev->plan_id == 'P-72C45040SG5797743L27JWOA'){ /* yearly *
 			$numDays = 365;
		}else if($prev->plan_id == 'P-664992417B445373VL4I6CFQ'){ /* monthly *
			$numDays = 30;
		}else{
			$numDays = 0;
		}*/
		
		if($prev->plan_id == 'P-72C45040SG5797743L27JWOA'){ /* yearly */
 			$numDays = 365;
		}else if($prev->plan_id == 'P-664992417B445373VL4I6CFQ'){ /* monthly */
			$numDays = 30;
		}else{
			$numDays = 0;
		}

		$days = (int) $numDays + $last;

		$array = array('token' => $request->token,'status' => 'Success','updated_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR'],'expiry' => Carbon::now()->addDays($days));

		DB::table('paypal_payments')->where('user_id',$user_id)->where('ba_token',$request->ba_token)->update($array);
		
		$user = User::find($user_id);
		$user->sub_exp = Carbon::now()->addDays($days);
		$ins =  $user->save();

		$user->subscription()->detach();
		$user->subscription()->attach([2]);
		
		if($ins){
			Session::flash('success','Payment successful');
		}else{
			Session::flash('error','Payment unsuccessful');
		}
		Log::channel('stack')->info('subscription data: ',['data' => $user,'payment_data' => $request->all(),'num_of_days' => $days,'ipaddress' => $_SERVER['REMOTE_ADDR']]);
		return redirect('knitterSubscriptions?user_id='.base64_encode($user_id).'&ba_token='.$request->ba_token);
    }

    function paypalPaymentFail(Request $request){
		$user_id = base64_decode($request->get('user_id'));
    	if(!$user_id){
            return redirect('login');
        }
		$sub_table = DB::table('paypal_payments')->where('subscription_id',$request->subscription_id)->first();
		
		$array = array('token' => $request->token,'status' => 'Cancelled','is_cancelled' => 1,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);

		$ins =  DB::table('paypal_payments')->where('user_id',$user_id)->where('subscription_id',$request->subscription_id)->update($array);
		if($ins){
			Session::flash('success','Payment cancled by user');
		}else{
			Session::flash('error','Payment unsuccessful');
		}
		return redirect('knitterSubscriptions?user_id='.base64_encode($user_id).'&ba_token='.$sub_table->ba_token);
	}
	
	
	function cancelSubscriptionAlreadyExists($subscription_id,$token){
		//$link = 'https://api.sandbox.paypal.com/v1/billing/subscriptions/'.$subscription_id.'/cancel';
		$link = 'https://api.paypal.com/v1/billing/subscriptions/'.$subscription_id.'/cancel';
		$body = '{
			  "reason": "Upgrading to new subscription"
			}';

		$client = new \GuzzleHttp\Client(['headers' => [
		        'Content-Type' => 'application/json',
				'Authorization' => $token
		    ]]);
    	$response = $client->post($link);
    	$res = $response->getBody();
		
		$array = array('status' => 'Cancelled','is_cancelled' => 1,'cancelled_at' => Carbon::now());
		$payments = PaypalPayments::where('subscription_id',$subscription_id)->update($array);
	}
		function cancelSubscription(Request $request){
		$request->validate([
			'subscription_id' => 'required'
		]);
		
		$subscription_id = $request->subscription_id;
		
		$check = PaypalPayments::where('subscription_id',$subscription_id)->first();
		
		if($check->is_cancelled == 1){
			return response()->json(['status' => 'error','message' => 'Subscription already cancled.']);
			exit;
		}
		
		//$link = 'https://api.sandbox.paypal.com/v1/billing/subscriptions/'.$subscription_id.'/cancel';
		$link = 'https://api.paypal.com/v1/billing/subscriptions/'.$subscription_id.'/cancel';
		
		$time = $this->checkTime();
    	
    	if($time == 0){
    		$token = $this->paypalLoginBasicAuth();
    	}else{
    		$token = Session::get('token');
    	}
		
		if($token){

		try {
			$body = '{
				  "reason": "Not satisfied with the service"
				}';

		$client = new \GuzzleHttp\Client(['headers' => [
		        'Content-Type' => 'application/json',
				'Authorization' => $token
		    ]]);
    	$response = $client->post($link);
    	$res = $response->getBody();
		
		$array = array('is_cancelled' => 1,'cancelled_at' => Carbon::now());
		$payments = PaypalPayments::where('subscription_id',$subscription_id)->update($array);
		
		return response()->json(['status' => 'success','message' => 'Subscription cancled successfully.']);
		
		
		}catch (\Exception $e) {
			return response()->json(['status' => 'fail','message' => $e->getMessage()]);
		}
	
		}

	}
}
