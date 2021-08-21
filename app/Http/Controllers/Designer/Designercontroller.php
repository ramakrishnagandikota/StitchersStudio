<?php

namespace App\Http\Controllers\Designer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PaypalCredentials;
use Auth;
use App\User;
use Session;

class Designercontroller extends Controller
{
     function __construct(){
    	$this->middleware(['auth']);
    }

    function paypal_credentials(Request $Request){
    	$paypal = PaypalCredentials::where('user_id',Auth::user()->id)->first();
    	return view('myaccount.paypal',compact('paypal'));
    }

    function update_paypal_credentials(Request $request){
    	$request->validate([
    		'store_name' => 'required',
    		'store_status' => 'required',
    		'account_type' => 'required',
    		'paypal_email' => 'required|email|unique:paypal_credentials,paypal_email,'.Auth::user()->id,
            're_enter_paypal_email' => 'required|email|same:paypal_email'
    	]);

    	$id = base64_decode($request->id);
    	try{
    		$array = array('user_id' => Auth::user()->id,'store_name' => $request->store_name,'store_status' => $request->store_status,'account_type' => $request->account_type,'paypal_email' => $request->paypal_email);
    		$count = PaypalCredentials::where('user_id',Auth::user()->id)->count();
    		if($count > 0){
				$update = PaypalCredentials::where('user_id',Auth::user()->id)->update($array);
    		}else{
    			$update = PaypalCredentials::where('user_id',Auth::user()->id)->insert($array);
    		}
    		

    		if($update){
    			Session::flash('success','Paypal details updated successfully');
    		}else{
    			Session::flash('fail','Unable to update paypal details. Try again after sometime.');
    		}
    		
    		return redirect()->back();
    	}catch(\Throwable $e){
			Session::flash('fail',$e->getMessage());
			return redirect()->back();
    	}
    	
    }
}
