<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\PaypalPayments;
use App\Models\PaypalPlans;
use DB;
use GuzzleHttp\Psr7;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Session;
use GuzzleHttp\Exception\RequestException;
use Log;
use App\Models\Subscription;
use Illuminate\Support\Facades\Http;

class SubscriptionPaymentController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    public function subscription_data(){
        $subscription = PaypalPayments::leftJoin('users','users.id','paypal_payments.user_id')
                    ->select('paypal_payments.*','users.id as userId','users.first_name','users.last_name','users.email')
                    ->where('users.status',1)->get();
        return view('admin.Subscription.index',compact('subscription'));
    }
	
	function checkTime(){
		
		if(Session::has('time')){
			$sessionTime = Session::get('time');
		}else{
			$sessionTime = 0;
		}

		if(strtotime($sessionTime) == 0){
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
	
	function paypalLoginBasicAuth(){
		
		//Session::forget('token');
    	
    	$body = "grant_type=client_credentials";
    	//$stream = array('grant_type' => 'client_credentials');
    	
    	/* $client = new \GuzzleHttp\Client(['auth' => [
    			'AXRGs14jUWPzvLl1dI7c3z0VcsWTUhYI-kysNWpsR051Wrbi_-s4bZOa3fswFicHFtPdjgS14E2qSY4U', 
    			'EGKvs5aIMuhUzgjb4sWEBF_pTIEzGs-lwrPUVgsbN6jOcbXE1AjomygejGSeVkJ20POmCsFRZOBnd9YV']
    		]);
		*/
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
	
	function checkSubscriptionDetails(Request $request){
		$request->validate([
			'subscription_id' => 'required'
		]);
		$subscription_id = $request->subscription_id;
		$link = 'https://api.paypal.com/v1/billing/subscriptions/'.$subscription_id;
		
		$time = $this->checkTime();
    	
    	if($time == 0){
    		$token = $this->paypalLoginBasicAuth();
    	}else{
    		$token = Session::get('token');
    	}
		
		//print_r($token);
		
		try {
			
			$client = new \GuzzleHttp\Client(['headers' => [
		        'Content-Type' => 'application/json',
				'Authorization' => $token,
				'Prefer' => 'return=minimal'
		    ]]);
			$response = $client->request('GET',$link);
			$res = $response->getBody();
			
			
			
			
			//return response()->json(['data' => $res]);
			echo '<pre>';
			print_r($response);
			echo '<pre>';
			
		}catch (\Exception $e) {
			return response()->json(['status' => 'fail','message' => $e->getMessage()]);
		}
	}
}
