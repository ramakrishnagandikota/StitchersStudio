<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use App\Models\Orders;
use App\Models\Booking_process;
use App\Models\Products;
use App\Models\Product_images;
use DB;
use App\Mail\NewsletterMail;
use Validator;
use Log;
use App\Mail\AppleUserValidateEmail;

class UserController extends Controller
{
    function __construct(){
        $this->middleware('auth:api');
    }
	
	public $successStatus = 200;

    function sendJsonData($data){
		return response()->json(['data' => $data]);
	}

    function add_address(Request $request){

        $validate = $request->validate([
    		'first_name' => 'required|alpha|min:3|max:20',
    		'last_name' => 'required|alpha|min:3|max:20',
    		'email' => 'required|email',
    		'address' => 'required|string',
    		'city' => 'required',
    		'state' => 'required',
    		'country' => 'required'
        ]);

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

        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function edit_address(Request $request){
        $addressCount = UserAddress::where('id',$request->id)->where('user_id',Auth::user()->id)->count();

        if($addressCount == 0){
            return response()->json(['status' => 'fail','message' => 'You are not authorized to access this address.']);
            exit;
        }

        $jsonArray = array();
        $add = UserAddress::where('id',$request->id)->get();
        for ($i=0; $i < count($add); $i++) {
            $jsonArray[$i]['id'] = $add[$i]->id;
            $jsonArray[$i]['first_name'] = $add[$i]->first_name;
            $jsonArray[$i]['last_name'] = $add[$i]->last_name;
            $jsonArray[$i]['email'] = $add[$i]->email;
            $jsonArray[$i]['mobile'] = $add[$i]->mobile;
            $jsonArray[$i]['address'] = $add[$i]->address;
            $jsonArray[$i]['city'] = $add[$i]->city;
            $jsonArray[$i]['country'] = $add[$i]->country;
            $jsonArray[$i]['state'] = $add[$i]->state;
            $jsonArray[$i]['zipcode'] = $add[$i]->zipcode;
            $jsonArray[$i]['is_default'] = ($add[$i]->is_default == 1) ? true : false;
        }

        $array = array('address' => $jsonArray);
        return $this->sendJsonData($array);
    }

    function update_address(Request $request){
        $validate = $request->validate([
    		'first_name' => 'required|alpha|min:3|max:20',
    		'last_name' => 'required|alpha|min:3|max:20',
    		'email' => 'required|email',
    		'address' => 'required|string',
    		'city' => 'required',
    		'state' => 'required',
    		'country' => 'required'
    	]);
        $add = UserAddress::find($request->id);
        $add->first_name = $request->first_name;
        $add->last_name = $request->last_name;
        $add->email = $request->email;
        $add->mobile = $request->mobile;
        $add->address = $request->address;
        $add->city = $request->city;
        $add->state = $request->state;
        $add->country = $request->country;
        $add->zipcode = $request->zipcode;
        $add->updated_at = Carbon::now();
        $save = $add->save();

        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function delete_address(Request $request){
        $addressCount = UserAddress::where('id',$request->id)->where('user_id',Auth::user()->id)->count();

        if($addressCount == 0){
            return response()->json(['status' => 'fail','message' => 'You are not authorized to access this address.']);
            exit;
        }
        $add = UserAddress::find($request->id);
        $delete = $add->delete();

        if($delete){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function setDefaultaddress(Request $request){
        $addressCount = UserAddress::where('id',$request->address_id)->where('user_id',Auth::user()->id)->count();

        if($addressCount == 0){
            return response()->json(['status' => 'fail','message' => 'You are not authorized to access this address.']);
            exit;
        }
		$array = array('is_default' => 0);
		UserAddress::where('user_id',Auth::user()->id)->update($array);

        $add = UserAddress::find($request->address_id);
        $add->is_default = 1;
        $save = $add->save();

        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function my_orders(){
        $jsonArray = array();
        $orders = Orders::where('user_id',Auth::user()->id)->where('order_status','Success')->orderBy('id','DESC')->get();
        for ($i=0; $i < count($orders); $i++) {
            $jsonArray[$i]['id'] = $orders[$i]->id;
            $jsonArray[$i]['order_number'] = $orders[$i]->order_number;
            $jsonArray[$i]['order_date'] = $orders[$i]->order_date;
            $jsonArray[$i]['order_status'] = $orders[$i]->order_status;
            $jsonArray[$i]['ordered_amt'] = $orders[$i]->ordered_amt;
            $jsonArray[$i]['payment_type'] = $orders[$i]->payment_type;
            $booking = Booking_process::where('order_id',$orders[$i]->id)->select('product_id','product_name','setpayment')->get();
            for ($j=0; $j < count($booking); $j++) {
                $jsonArray[$i]['products'][$j]['product_id'] = $booking[$j]->product_id;
                $jsonArray[$i]['products'][$j]['product_name'] = $booking[$j]->product_name;
                $images = Product_images::where('product_id',$booking[$j]->product_id)->select('image_small')->first();
                $jsonArray[$i]['products'][$j]['image'] = isset($images->image_small) ? $images->image_small : 'https://dummyimage.com/200x300&text='.$booking[$j]->product_name;
                $jsonArray[$i]['products'][$j]['price'] = $booking[$j]->setpayment;
            }
        }

        $array = array('orders' => $jsonArray);
        return $this->sendJsonData($array);
    }

    function newletter_check(){
        $ins = DB::table('subscription')->where('user_id',Auth::user()->id)->where('subscription_type','newsletters')->take(1)->get();
        if($ins){
            return response()->json(['data' => $ins]);
        }else{
            return response()->json(['data' => '']);
        }
    }

    function subscribe_newsletters(Request $request){
		$request->validate([
            'email' => 'required|email'
        ]); 
    	$count = DB::table('subscription')->count()+1;

    	$array = array('user_id' => Auth::user()->id,'token' => md5($count),'subscription_type' => 'newsletters','email' => $request->email,'ipaddress' => $_SERVER['REMOTE_ADDR']);
    	$ins = DB::table('subscription')->insertGetId($array);
    	
		if($ins){
			try{
				$details = [
				'detail'=>'detail',
				'name'  => ucwords(ucwords(Auth::user()->username)),
				'email' => $request->email,
				'token' => md5($count)
			];
				\Mail::to($request->email)->send(new NewsletterMail($details));
				return response()->json(['status' => 'success']);
			}catch(Throwable $e){
				return response()->json(['status' => 'success']);
			}
		}else{
			return response()->json(['status' => 'fail']);
		}
    }

    function newsletter_unscbscribe(Request $request){
    	$token = $request->token;
    	$ins = DB::table('subscription')->where('token',$token)->delete();
    	if($ins){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'file']);
        }
    }
	
	function getMyOrderDetails(Request $request){
        $jsonArray = array();
        $orders = Orders::where('user_id',Auth::user()->id)->orderBy('id','DESC')->take(1)->get();
        for ($i=0; $i < count($orders); $i++) {
            $jsonArray[$i]['id'] = $orders[$i]->id;
            $jsonArray[$i]['order_number'] = $orders[$i]->order_number;
            $jsonArray[$i]['order_date'] = $orders[$i]->order_date;
            $jsonArray[$i]['order_status'] = $orders[$i]->order_status;
            $jsonArray[$i]['ordered_amt'] = $orders[$i]->ordered_amt;
            $jsonArray[$i]['payment_type'] = $orders[$i]->payment_type;
            $booking = Booking_process::where('order_id',$orders[$i]->id)->select('product_id','product_name','setpayment')->get();
            for ($j=0; $j < count($booking); $j++) {
                $jsonArray[$i]['products'][$j]['product_id'] = $booking[$j]->product_id;
                $jsonArray[$i]['products'][$j]['product_name'] = $booking[$j]->product_name;
                $images = Product_images::where('product_id',$booking[$j]->product_id)->select('image_small')->first();
                $jsonArray[$i]['products'][$j]['image'] = $images->image_small;
                $jsonArray[$i]['products'][$j]['price'] = $booking[$j]->setpayment ? $booking[$j]->setpayment : 0;
            }
			$jsonArray[$i]['address'] = UserAddress::where('id',$orders[$i]->address_id)->select('type','first_name','last_name','email','mobile','address','city','state','country','zipcode')->get();
        }

        $array = array('orders' => $jsonArray);
        return $this->sendJsonData($array);
    }
	
	function update_names(Request $request){

		if($request->username){
			$request->validate([
				'first_name' => 'required|alpha|min:2|max:15',
				'last_name' => 'required|alpha|min:2|max:15',
				'username' => 'required|alpha_num|max:25|unique:users',
				'email' => 'required|email|unique:users'
			]);
		}else{
			$request->validate([
				'first_name' => 'required|alpha|min:2|max:15',
				'last_name' => 'required|alpha|min:2|max:15',
				'email' => 'required|email|unique:users'
			]);
		}
		

		
		if($request->username){
			$username = $request->username;
		}else{
			$username = '';
		}
		
		try{
			$array = array('first_name' => $request->first_name,'last_name' => $request->last_name,'username' => $username,'email' => $request->email);
			$save = Auth::user()->update($array);
			return response()->json(['status' => 'success']);
		}catch(\Exception $e){
			return response()->json(['status' => 'fail','message' => $e->getMessage()]);
		}
		
	}
	
	
	function validate_user(Request $request){
		$validator = $request->validate([
			'email' => 'required|email'
		]);
		if (!$validator) {
            return $this->sendError($validator->errors(), 401);
        }
		$loggedInUser = Auth::user()->id;
		$anotherAccount = User::where('email',$request->email)->first();
		$token = md5(time());
		
		$array = array('main_user_id' => $anotherAccount->id,'given_email' => $request->email,'merging_user_id' => $loggedInUser,'token' => $token,'created_at' => Carbon::now());
		DB::table('merged_users')->insert($array);
		
		$details = [
		    'detail'=>'detail',
		    'name'  => Auth::user()->username ? Auth::user()->username : 'User',
		    'email' => $request->email,
			'token' =>$token
		];

        
		try{
			$mail = \Mail::to($request->email)->send(new AppleUserValidateEmail($details));
			info('verification Mail sent for apple user');
			return response()->json(['status' => true]);
		}catch(\Throwable $e){
			return response()->json(['status' => false,'message' => $e->getMessage()]);
		}
	}
	
	public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
	
	public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message
        ];


        return response()->json($response, 200);
    }
}
