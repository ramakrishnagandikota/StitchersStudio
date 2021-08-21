<?php

namespace App\Http\Controllers\Reports;

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

class PaypalSubscriptionUpdateController extends Controller
{
	
	function checkTime(){
		
		if(Session::get('time')){
			$sessionTime = Session::get('time');
		}else{
			$sessionTime = 0;
		}

		if(!$sessionTime){
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
	
	function update_paypal_recurring_responseManual(Request $request){
		/*$btime = "2021-04-30T10:00:00Z";
		echo $today = Carbon::today()->format('Y-m-d');
		
		if(date('Y-m-d',strtotime($btime)) == $today){
			echo 'yes';
		}else{
			echo 'no';
		}
		$today = "2020-09-22";
		$subscriptions = DB::table('paypal_payments')->where('status','Success')->whereDate('expiry',$today)->get();
		print_r($subscriptions);
		exit;*/
		$subscription_id = $request->subscription_id;
		$link = "https://api-m.paypal.com/v1/billing/subscriptions/".$subscription_id;
		$time = $this->checkTime();
    	
    	if($time == 0){
    		$token = $this->paypalLoginBasicAuth();
    	}else{
    		$token = Session::get('token');
    	}
		
		if($token){
			$client = new \GuzzleHttp\Client(['headers' => [
				'Content-Type' => 'application/json',
				'Authorization' => $token
			]]);
			$request = $client->request('GET', $link);
			$response = $request->getBody();
			$data = json_decode($response);
			//echo $data->billing_info->cycle_executions[0]->cycles_completed;
			echo '<pre>';
			print_r($data);
			echo '</pre>';
		}
	}
	
	function update_paypal_recurring_responseAutomate(){
		$time = $this->checkTime();
    	
    	if($time == 0){
    		$token = $this->paypalLoginBasicAuth();
    	}else{
    		$token = Session::get('token');
    	}
		
		if($token){
			$today = Carbon::today()->format('Y-m-d');
			$subscriptions = DB::table('paypal_payments')->where('status','Success')->whereDate('expiry',$today)->get();
			foreach($subscriptions as $sub){
				$link = "https://api-m.paypal.com/v1/billing/subscriptions/".$sub->subscription_id;
				$client = new \GuzzleHttp\Client(['headers' => [
					'Content-Type' => 'application/json',
					'Authorization' => $token
				]]);
				$request = $client->request('GET', $link);
				$response = $request->getBody();
				$data = json_decode($response);
			}
		}
	}
}
