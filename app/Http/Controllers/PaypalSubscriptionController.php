<?php

namespace App\Http\Controllers;

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
use App\Models\UserAddress;
use App\Models\Country;
use Log;

class PaypalSubscriptionController extends Controller
{
    function __construct(){
    	$this->middleware('auth');
    }

    function index(){
		
    	//$subscriptions = Subscription::where('status',1)->get();
		//$newsub = DB::table('paypal_payment_cancellations')->where('user_id',Auth::user()->id)->orderBy('id','DESC')->first();
		//$expiry = Auth::user()->sub_exp;
		
    	//return view('knitter.paypal-subscription-success');
		//return view('API.paypal-subscription-success');
		return view('API.paypal-subscription-success');
    }

    function checkLogin(){
	/*$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.paypal.com/v1/oauth2/token",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "grant_type=client_credentials",
	  CURLOPT_HTTPHEADER => array(
		"Authorization: Basic QVhSR3MxNGpVV1B6dkxsMWRJN2MzejBWY3NXVFVoWUkta3lzTldwc1IwNTFXcmJpXy1zNGJaT2EzZnN3RmljSEZ0UGRqZ1MxNEUycVNZNFU6RUdLdnM1YUlNdWhVemdqYjRzV0VCRl9wVElFekdzLWx3clBVVmdzYk42ak9jYlhFMUFqb215Z2VqR1NlVmtKMjBQT21Dc0ZSWk9CbmQ5WVY=",
		"Content-Type: application/x-www-form-urlencoded",
		"Cookie: cookie_check=yes; ui_experience=d_id%3D7d0f5c9279d3488ca77b9a0767c732ab1586604886924; LANG=en_US%3BUS; x-csrf-jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ0b2tlbiI6IktyRklYZTBxVkZhMVhzTzk3WFp3Z1RsaW5uRWx4Y0djMGJhZlBpcGpQYWRuWWRNVEZ0RFc2by1GYWhfSjQzVkJYajR6N0FmRE1DUjJ6Z1BYeFp0OGNNd0U3SHd0aERiZDFvTFFFYl85TnROVkZTUFlndTh4RF9TTUNUS3lVWmNFaHNsdEtPU25iTHRzU0llY01yMnc2MWhBV1V3NWxCV1NqemlkVHRya19jX2dxQ3R0S3psV1RXZHJwcmUiLCJpYXQiOjE1OTAwNjY1NDcsImV4cCI6MTU5MDA3MDE0N30.X--FTIi8VlcUM0iYEQ9TzvYdjky_Z4nPVtmOXcgvbt0; tsrce=billingnodeweb; ts=vr%3D69054b0e171ac120001ee8f3ffffd7cd%26vreXpYrS%3D1684737324%26vteXpYrS%3D1590068347%26vt%3D375a0961172ac1200010c871fffff55f"
	  ),
	)); 

	$response = curl_exec($curl);
	if(!$response){die("Connection Failure");}
	curl_close($curl);

/*
	$client = new \GuzzleHttp\Client();
	$response = $client->request('POST', 'https://api.sandbox.paypal.com/v1/oauth2/token', ['auth' => ['AXRGs14jUWPzvLl1dI7c3z0VcsWTUhYI-kysNWpsR051Wrbi_-s4bZOa3fswFicHFtPdjgS14E2qSY4U', 'EGKvs5aIMuhUzgjb4sWEBF_pTIEzGs-lwrPUVgsbN6jOcbXE1AjomygejGSeVkJ20POmCsFRZOBnd9YV']],
	[
    'form_params' => [
        'grant_type' => 'client_credentials'
    ]
]);

	print_r($response);
	exit;
	*
		$data = json_decode($response);

		$access_token = $data->access_token;
		$token_type = $data->token_type;
		$app_id = $data->app_id;
		$expires_in = $data->expires_in;
		$nonce = $data->nonce;
		
		Session::put('token',$token_type.' '.$access_token);
		Session::put('app_id',$app_id);
		
		return $token_type.' '.$access_token; */
		
		$body = "grant_type=client_credentials";    	
    	$client = new \GuzzleHttp\Client(['auth' => [
    			'AaQjxixB5xHegAnBiZOU5AMZtSCg5SVwTlib40j5zEmCeS2vXC6NB8XJ8oBpw6YyC0H6p1CUW7DDHVkb', 
    			'EDJ01SF_QRjVbqDl50N7kTE-AkD-c1Ue1Hfk-TJd8kwhfaJsOPThR9B5N4jim0wHdxK29Dbc4VhOMExx']
    		]);
		/*$client = new \GuzzleHttp\Client(['auth' => [
    			'AXRGs14jUWPzvLl1dI7c3z0VcsWTUhYI-kysNWpsR051Wrbi_-s4bZOa3fswFicHFtPdjgS14E2qSY4U', 
    			'EGKvs5aIMuhUzgjb4sWEBF_pTIEzGs-lwrPUVgsbN6jOcbXE1AjomygejGSeVkJ20POmCsFRZOBnd9YV']
    		]);*/
		//$request = $client->request('POST', 'https://api.sandbox.paypal.com/v1/oauth2/token',['body' => $body]);
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
		Session::put('app_id',$app_id);
    	return $data->token_type.' '.$data->access_token;
	}

	function getAllPlans(){
		
		
		if(Session::has('token')){
			$token = Session::get('token');
		}else{
			$token = $this->checkLogin();
		}
		
		
		if($token){
		//https://api.sandbox.paypal.com/v1/billing/plans
		$client = new \GuzzleHttp\Client();
    	$request = $client->request('GET','https://api.paypal.com/v1/billing/plans',[
		    'headers' => [
		        'Content-Type' => 'application/json',
				'Authorization' => $token
		    ]
		]);
    	$response = $request->getBody();
    	return $response;
		}
	}

	function get_user_address(){
		$address = UserAddress::get();
		$country = Country::all();
		return view('knitter.subscriptions.user-address',compact('address','country'));
	}

	function create_subscription(Request $request){
		/*echo '<pre>';
		print_r($request->all());
		echo '</pre>';
		exit;*/
		
		$id = $request->id;
		
		if(Session::has('token')){
			$token = Session::get('token');
		}else{
			$token = $this->checkLogin();
		}
		
		
		
		if($token){
			
		/*if(Auth::user()->remainingDays() > 0){
			$prevousSub = DB::table('paypal_payments')->where('user_id',Auth::user()->id)->where('status','Success')->orderBy('id','DESC')->first();
			if($prevousSub){
				$sub_id = $prevousSub->subscription_id;
				$this->cancelSubscriptionAlreadyExists($sub_id,$token);
			}
		}*/
			
		if($request->address_id == 0){
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
	    	$add->country = $request->country;
	    	$add->zipcode = $request->zipcode;
	    	$add->is_default = 0;
	    	$add->status = 1;
	    	$add->created_at = Carbon::now();
	    	$save = $add->save();
			
			$address_id = $add->id;
		}else{
			$address_id = $request->address_id;
		}
		
		
		$addr = UserAddress::where('id',$address_id)->first();
		

			$body = '{
  "plan_id": "'.$id.'",
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
    "return_url": "'.url('/success').'",
    "cancel_url": "'.url('/fail').'"
  }
}';


//echo $body;
//exit;


		$client = new \GuzzleHttp\Client(['headers' => [
		        'Content-Type' => 'application/json',
				'Authorization' => $token
		    ]]);
    	$response = $client->post('https://api.paypal.com/v1/billing/subscriptions',['body' => $body]);
		//$response = $client->post('https://api.sandbox.paypal.com/v1/billing/subscriptions',['body' => $body]);
    	$res = $response->getBody();
    	$data = json_decode($res);
    	/* echo '<pre>';
    	print_r($data);
    	echo '</pre>'; */
    	
		$url = $data->links[0]->href;
		$ba_token = explode('ba_token=', $url);
		$token = $ba_token[1];
		$subscription_id = $data->id;
		$status = $data->status;

		$sub = new PaypalPayments;
		$sub->user_id = Auth::user()->id;
		$sub->plan_id = $id;
		$sub->tranx_id = time();
		$sub->subscription_id = $subscription_id;
		$sub->ba_token = $token;
		$sub->status = $status;
		$sub->sent_data = $body;
		$sub->created_at = Carbon::now();
		$sub->ipaddress = $_SERVER['REMOTE_ADDR'];
		$save = $sub->save();


		return $res;

		}

	}
	
	
	function success(Request $request){
		/*echo '<pre>';
		echo 'success';
		print_r($request->all());
		echo '</pre>';
		exit; */
	
$prev =  DB::table('paypal_payments')->where('user_id',Auth::user()->id)->where('ba_token',$request->ba_token)->orderBy('id','DESC')->first();
	

$expired = Auth::user()->isSubscriptionExpired();

		if($expired == 1){
    		$last = Auth::user()->remainingDays();
    	}else{
    		$last = 0;
    	}

    	
		
		/*if($prev->plan_id == 'P-2US14301F3035910LL4LLGDI'){ /* yearly 
 			$numDays = 365;
		}else if($prev->plan_id == 'P-70289111JT019254YL4LLIIQ'){ /* monthly 
			$numDays = 30;
		}else{
			$numDays = 0;
		} */
		
		if($prev->plan_id == 'P-72C45040SG5797743L27JWOA'){ /* yearly */
 			$numDays = 365;
		}else if($prev->plan_id == 'P-664992417B445373VL4I6CFQ'){ /* monthly */
			$numDays = 30;
		}else{
			$numDays = 0;
		}
		
		

	$days = (int) $numDays + $last;



$array = array('token' => $request->token,'status' => 'Success','updated_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR'],'expiry' => Carbon::now()->addDays($days));
DB::table('paypal_payments')->where('user_id',Auth::user()->id)->where('ba_token',$request->ba_token)->update($array);

$user = User::find(Auth::user()->id);
$user->sub_exp = Carbon::now()->addDays($days);
$ins = $user->save();

$user->subscription()->detach();
$user->subscription()->attach([2]);

if($ins){
	Session::flash('success','Payment successful');
}else{
	Session::flash('error','Payment unsuccessful');
}
Log::channel('stack')->info('subscription data: ',['data' => $user,'payment_data' => $request->all(),'num_of_days' => $days,'ipaddress' => $_SERVER['REMOTE_ADDR']]);
return redirect('subscription/success/thankyou');
//return redirect('knitterSubscriptions');
	}


function success_thankyou(Request $request){
	$tranx =  DB::table('paypal_payments')->where('user_id',Auth::user()->id)->orderBy('id','DESC')->first();
	return view('knitter.subscriptions.success',compact('tranx'));
}

function payment_faild(Request $request){
	return view('knitter.subscriptions.cancel');
}


	function fail(Request $request){
		/*echo '<pre>';
		echo 'fail';
		print_r($request->all());
		echo '</pre>';
		exit; */
		
$array = array('token' => $request->token,'status' => 'Cancelled','updated_at' => Carbon::now());
$ins =  DB::table('paypal_payments')->where('user_id',Auth::user()->id)->where('subscription_id',$request->subscription_id)->update($array);

if($ins){
	Session::flash('error','Payment cancled by user.');
}else{
	Session::flash('error','Payment unsuccessful');
}
//return redirect('knitterSubscriptions');
Log::channel('stack')->info('subscription data: ',['data' => Auth::user(),'payment_data' => $request->all(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);
return redirect('subscription/failed');
	}
	
	
function getSubscriptionDetails(Request $request){
	$id = $request->id;

		if(Session::has('token')){
			$token = Session::get('token');
		}else{
			$token = $this->checkLogin();
		}
		
		if($token){
			try {
				//https://api.sandbox.paypal.com/v1/billing/subscriptions
					$client = new \GuzzleHttp\Client();
			    	$request = $client->request('GET','https://api.paypal.com/v1/billing/subscriptions/'.$id,[
					    'headers' => [
					        'Content-Type' => 'application/json',
							'Authorization' => $token
					    ]
					]);
			    	$response = $request->getBody();
			    	return $response;
			} catch (\Exception $e) {
				echo $e->getMessage();
			}
		}
}

function getPlanDetails(Request $request){
		$id = $request->id;

		if(Session::has('token')){
			$token = Session::get('token');
		}else{
			$token = $this->checkLogin();
		}
		
		if($token){
		//https://api.sandbox.paypal.com/v1/billing/plans
		$client = new \GuzzleHttp\Client();
    	$request = $client->request('GET','https://api.paypal.com/v1/billing/plans/'.$id,[
		    'headers' => [
		        'Content-Type' => 'application/json',
				'Authorization' => $token
		    ]
		]);
    	$response = $request->getBody();
    	return $response;
		}
}

function cancelSubscriptionAlreadyExists($subscription_id,$token){
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
		
		$array = array('is_cancelled' => 1,'cancelled_at' => Carbon::now());
		$payments = PaypalPayments::where('subscription_id',$subscription_id)->update($array);
}

function cancelSubscription(Request $request){
		$subscription_id = $request->subscription_id;
		
		$check = PaypalPayments::where('subscription_id',$subscription_id)->first();
		
		if($check->is_cancelled == 1){
			return response()->json(['status' => 'error','message' => 'Subscription already cancled.']);
			exit;
		}
		
		//$link = 'https://api.sandbox.paypal.com/v1/billing/subscriptions/'.$subscription_id.'/cancel';
		$link = 'https://api.paypal.com/v1/billing/subscriptions/'.$subscription_id.'/cancel';
		
		if(Session::has('token')){
			$token = Session::get('token');
		}else{
			$token = $this->checkLogin();
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
			echo $e->getMessage();
		}
	
		}

}

}
