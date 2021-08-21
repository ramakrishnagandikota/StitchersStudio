<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;
use Validator;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use App\Mail\AccountVerificationMail;
use App\Mail\PasswordResetMail;
use DB;
use Mail;
use Redirect;
use App\Mail\RegistrationMail;
use App\Mail\IosLoginMail;
use Hash;
use Log;
use App\Traits\UserAgentTrait;
use Laravolt\Avatar\Facade as Avatar;
use Image;
use App\Models\UserMeasurements;
use App\Models\Timeline;
use App\Models\TimelineShowPosts;
use App\Models\PushNotificationDeviceData;

class LoginController extends Controller
{
	use UserAgentTrait;
	
    public $successStatus = 200;

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message
        ];


        return response()->json($response, 200);
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

    public function findUsername()
    {
        $login = request()->input('email');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }

    public function login(Request $request){

        /* if($this->findUsername() == 'email'){
                $validator = $request->validate([
                    'email' => 'required|email',
                    'password' => 'required|string|min:6|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
                ]);
            }else{
                $validator = $request->validate([
                    'username' => 'required|alpha_num|min:5|max:15',
                    'password' => 'required|string|min:6|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
                ]);
            }
		*/
		
		if($this->findUsername() == 'email'){
			$username = 'email';
		}else{
			$username = 'username';
		}

		$user = User::where($username,$request->email)->count();

		if($user == 0){
			$success['error'] = 'User does not exists.';
			return $this->sendError($success,401); 
			exit;
		}


            //$emailOrUsername = $this->findUsername();
            $data = array($this->findUsername() => $request->email,'password' => $request->password);

        if(Auth::attempt($data)){

            if(Auth::user()->status != 1){
                 $success['error'] = 'User account not verified';
				 Auth::logout();
                 return $this->sendError($success,401);
                 exit;
            }
            $user = Auth::user();
			
			if(!$user->hasRole('Knitter')){
                $success['error'] = 'You can not login with the given credentials. Try with different credentials.';
                Auth::logout();
                 return $this->sendError($success,401);
                 exit;
            }
			/*if($user){
				if(Auth::user()->remainingDays() == 0){
				 Auth::user()->subscription()->detach();
				 Auth::user()->subscription()->attach(['1']);
				}
			}*/
Log::channel('stack')->info('User : ',['data' => $request->all(), 'RegisterFrom' => 'Mobile','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

$measurements = UserMeasurements::where('user_id',Auth::user()->id)->count();
$projects = Auth::user()->projects()->where('is_archive',0)->where('is_deleted',0)->count();

			$firstChar = mb_substr($user->first_name, 0, 1, "UTF-8");
			$pic = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.strtoupper($firstChar);

            $success['access_token'] =  $user->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['first_name'] =  $user->first_name;
            $success['last_name'] = $user->last_name;
            $success['email'] = $user->email;
            $success['picture'] =  $user->picture;
            $success['role'] = $user->userRole();
            $success['username'] = $user->username;
			if(Auth::user()->isFree() == true){
				if($measurements == 0){
					$success['measurements'] = true;
				}else{
					$success['measurements'] = false;
				}
				
				if($projects == 0){
					$success['projects'] = true;
				}else{
					$success['projects'] = false;
				}
				
			}else{
				$success['measurements'] = true;
				$success['projects'] = true;
				
			}
			
			if($request->device_id){
				$device_type = $request->device_type;
				$idCount = PushNotificationDeviceData::where('user_id',$user->id)->where('device_token',$request->device_id)->count();
				if($idCount == 0){
					$dId = array('user_id' => $user->id,'device_type' => $device_type,'device_token' => $request->device_id,'created_at' => Carbon::now(),'updated_at' => Carbon::now());
					PushNotificationDeviceData::insert($dId);
				}
				
				if($request->device_type == 'ios'){
					$user_login = DB::table('user_login')->where('user_id',$user->id)->where('device_type','ios')->count();
					if($user_login == 0){
						$details = array('name' => $user->first_name.' '.$user->last_name);
						\Mail::to($user->email)->send(new IosLoginMail($details));
					}
				}
				$device = array('user_id' => $user->id,'device_type' => $device_type,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
				DB::table('user_login')->insert($device);
			}

            return $this->sendResponse($success, $this->successStatus);
        }
        else{
			$success['error'] = 'Invalid password.';
            return $this->sendError($success, 401);
        }
    }


    public function register(Request $request)
    {
       $validator = Validator::make($request->all(), [
            'first_name' => 'required|alpha|min:2|max:15',
            'last_name' => 'required|alpha|min:2|max:15',
            'username' => 'required|alpha_num|max:25|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
            'confirm_password' => 'required|same:password',
            'terms_and_conditions' => 'required'
        ]);


        if ($validator->fails()) {
            return $this->sendError($validator->errors(), 401);
        }
//Log::channel('stack')->info('User : ',['data' => $request->all(), 'RegisterFrom' => 'Mobile','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

            $userCount = User::count() + 1;

            $firstChar = mb_substr($request->first_name, 0, 1, "UTF-8");
            $pic = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.$firstChar;

            $md5email = md5($request->email);
            $user = new User;
            $user->enc_id = md5($userCount);
            $user->name = $request->username;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->enc_email = $md5email;
            $user->picture = Avatar::create($request->first_name)->toBase64();;
            $user->subscription_type = 1;
			$user->status = 0;
            $user->sub_exp = Carbon::now();
			$user->ipaddress = $_SERVER['REMOTE_ADDR'];
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();

        //$success['access_token'] =  $user->createToken('MyApp')->accessToken;
        


        $user->subscription()->attach(['1']);

        $arr = array('user_id' => $user->id,'role_id' => 2,'created_at' => date('Y-m-d H:i:s'));
            $dd = DB::table('user_role')->insert($arr);

            $arr = array('user_id' => $user->id);
            //$ii = DB::table('user_measurements')->insert($arr);
            $up = DB::table('user_profile')->insert($arr);

			$this->checkTimelinePosts($user->id);

            $details = [
                'detail'=>'detail',
                'name'  => ucwords(ucwords($request->username)),
                'email' =>$request->email,
                'encemail' => $md5email
                 ];

           try{
			    \Mail::to($request->email)->send(new RegistrationMail($details));
				$success['message'] =  'Hi '.$user->first_name.' '.$user->last_name.', Please check your email to activate your account.';
		   }catch(\Exception $e){
			   $success['message'] = 'Registration successful, Unable to send email.';
		   }

			return $this->sendResponse($success, $this->successStatus);

    }

    public function details()
    {
        $user = Auth::user();
        return $this->sendResponse($user, $this->successStatus);
    }

    function send_reset_password_link(Request $request,User $user){
        $validator = $request->validate([
            'email' => 'required|email'
        ]);




        if(! $validator) {
            return redirect()->back();
        }else{
            $check = $user->email($request->email)->first();
           if($check){
           $time = md5(time());
            $array = array('email' => $request->email,'token' => $time,'created_at' => date('Y-m-d H:i:s'));
            DB::table('password_resets')->insert($array);

            $details = array(
                'name'  => ucwords(ucwords($check->first_name.' '.$check->last_name)),
                'email' =>$request->email,
                'token' => $time
            );

			try{
                \Mail::to($request->email)->send(new PasswordResetMail($details)); 
                $success['message'] = 'Mail has been sent to the registered email with reset link';
                return $this->sendResponse($success, $this->successStatus);
            }catch(\Exception $e){
                $success['error'] = 'Unable to send email at this time, Try again after sometime.';
                return $this->sendError($success, 401);
            }
			
           }else{
            $success['error'] = 'Mail does not found in our records.';
            return $this->sendError($success, 401);

           }
           //return $this->sendResponse($success, $this->successStatus);
        }
    }


    function login_google(Request $request){
		//print_r($request->all());
		Log::channel('stack')->info('User : ',['data' => $request->all(), 'RegisterFrom' => 'Mobile,Google','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);
		//echo 'log recorded.';
		//exit;
		
        $email = $request->email;
        $dd = explode('@',$email);

        

        $userCount = User::where('email',$email)->first();

        if($userCount){
			$user = User::where('email',$email)->first();
			
			if(isset($request->device_type)){
				$device_type = $request->device_type;
				
				$idCount = PushNotificationDeviceData::where('user_id',$user->id)->where('device_token',$request->device_id)->count();
				if($idCount == 0){
					$dId = array('user_id' => $user->id,'device_type' => $device_type,'device_token' => $request->device_id,'created_at' => Carbon::now(),'updated_at' => Carbon::now());
					PushNotificationDeviceData::insert($dId);
				}
				
				if($request->device_type == 'ios'){
					$user_login = DB::table('user_login')->where('user_id',$user->id)->where('device_type','ios')->count();
					if($user_login == 0){
						$details = array('name' => $user->first_name.' '.$user->last_name);
						\Mail::to($user->email)->send(new IosLoginMail($details));
					}
				}
				
				$device = array('user_id' => $userCount->id,'device_type' => $device_type,'created_at' => Carbon::now());
				DB::table('user_login')->insert($device);
			}
			
			/*if($user->remainingDays() == 0){
			 $user->subscription()->detach();
			 $user->subscription()->attach(['1']);
			}*/
			$success = $this->getGoogleLogin($email);
			
        }else{
			
Log::channel('stack')->info('User : ',['data' => $request->all(), 'RegisterFrom' => 'Mobile,Google','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

		if($request->displayName){
            $name = $request->displayName;
        }else{
            $name = '';
        }

        if($request->givenName){
            $first_name = str_replace(' ','',$request->givenName);
        }else{
            $first_name = '';
        }

        if($request->familyName){
            $last_name = str_replace(' ','',$request->familyName);
        }else{
            $last_name = '';
        }

        if($request->userId){
            $oauth_uid = $request->userId;
        }else{
            $oauth_uid = '';
        }

        if(isset($request->imageUrl)){
            $picture = $request->imageUrl;
        }else{
            $firstChar = mb_substr($first_name, 0, 1, "UTF-8");
            $picture = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.$firstChar;
        }
		
		
        $oauth_provider = 'Google';
			
            $userCount = User::count() + 1;

            $user = new User;
            $user->enc_id = md5($userCount);
            $user->name = $name;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->username = $dd[0].$userCount;
            $user->email = $email;
            $user->oauth_provider = $oauth_provider;
            $user->oauth_uid = $oauth_uid;
            $user->picture = $picture;
            $user->subscription_type = 1;
			$user->status = 1;
            $user->sub_exp = Carbon::now();
			$user->ipaddress = $_SERVER['REMOTE_ADDR'];
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();

            $user->subscription()->attach(['1']);

            $arr = array('user_id' => $user->id,'role_id' => 2,'created_at' => date('Y-m-d H:i:s'));
            $dd = DB::table('user_role')->insert($arr);

            $arr1 = array('user_id' => $user->id);
            //$ii = DB::table('user_measurements')->insert($arr);
            $up = DB::table('user_profile')->insert($arr1);
			
			$this->checkTimelinePosts($user->id);
			$success = $this->getGoogleLogin($email);
			
        }
		
		if(isset($request->device_type)){
				$device_type = $request->device_type;
				
				$idCount = PushNotificationDeviceData::where('user_id',$user->id)->where('device_token',$request->device_id)->count();
				if($idCount == 0){
					$dId = array('user_id' => $user->id,'device_type' => $device_type,'device_token' => $request->device_id,'created_at' => Carbon::now(),'updated_at' => Carbon::now());
					PushNotificationDeviceData::insert($dId);
				}
				
				if($request->device_type == 'ios'){
					$user_login = DB::table('user_login')->where('user_id',$user->id)->where('device_type','ios')->count();
					if($user_login == 0){
						$details = array('name' => $user->first_name.' '.$user->last_name);
						\Mail::to($user->email)->send(new IosLoginMail($details));
					}
				}
				$device = array('user_id' => $user->id,'device_type' => $device_type,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
				DB::table('user_login')->insert($device);
			}

        return $this->sendResponse($success, $this->successStatus);
    }
	
	function getGoogleLogin($email){
			$userCount = User::where('email',$email)->first();
			if($userCount){
			$user_id = $userCount->id;
			//Auth::loginUsingId($user_id, true);

            $user = User::where('id',$user_id)->first();
			if($user){
				$measurements = UserMeasurements::where('user_id',$user->id)->count();
				$projects = $user->projects()->where('is_archive',0)->where('is_deleted',0)->count();
			}
			
            $success['access_token'] =  $user->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['first_name'] =  $user->first_name;
            $success['last_name'] = $user->last_name;
            $success['email'] = $user->email;
            $success['picture'] =  $user->picture;
            $success['role'] = $user->userRole();
            $success['username'] = $user->username;
			if($user->isFree() == true){
				if($measurements == 0){
					$success['measurements'] = true;
				}else{
					$success['measurements'] = false;
				}
				
				if($projects == 0){
					$success['projects'] = true;
				}else{
					$success['projects'] = false;
				}
				
			}else{
				$success['measurements'] = true;
				$success['projects'] = true;
				
			}
			}else{
				$success['error'] = 'Unable to login';
			}
			
			return $success;
	}

/*
    email:"dshendkar@yahoo.in"
    first_name:"Dattatray"
    picture:"https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=2783228471767882&height=720&width=720&ext=1587629507&hash=AeTNVpfmPL-FbYLh"
    username:"Dattatray Shendkar"
*/
    function login_facebook(Request $request){
		Log::channel('stack')->info('User : ',['data' => $request->all(), 'Login from' => 'Mobile,Facebook','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);
		
        $email = $request->email;
        $dd = explode('@',$email);
        $usersCount = User::count() + 1;

        if($request->email){
            $email = $request->email;
        }else{
            return response()->json(['error' => 'Invalid email.']);
            exit;
        }

        if($request->first_name){
            $first_name = str_replace(' ','',$request->first_name);
        }else{
            $first_name = '';
        }
		
		if($request->last_name){
            $last_name = str_replace(' ','',$request->last_name);
        }else{
            $last_name = '';
        }

        if($request->username){
            $username = str_replace(' ', '', $request->username);
        }else{
            $username = $dd[0].$usersCount;
        }

        if(base64_decode($request->picture)){
            $picture = base64_decode($request->picture);
        }else{
            $firstChar = mb_substr($first_name, 0, 1, "UTF-8");
            $picture = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.$firstChar;
        }

        $email = $request->email;
        $oauth_provider = 'Facebook';

        $userCount = User::where('email',$email)->first();

        if($userCount){
Log::channel('stack')->info('User : ',['data' => $request->all(), 'Login from' => 'Mobile,Facebook','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);
	
			$user_id = $userCount->id;
			$user = User::where('id',$user_id)->first();
			
			if($user){
				
				/*if($user->remainingDays() == 0){
				 $user->subscription()->detach();
				 $user->subscription()->attach(['1']);
				}*/
				
	$measurements = UserMeasurements::where('user_id',$user->id)->count();
	$projects = $user->projects()->where('is_archive',0)->where('is_deleted',0)->count();
}

if(isset($request->device_type)){
	$device_type = $request->device_type;
	
	$idCount = PushNotificationDeviceData::where('user_id',$user->id)->where('device_token',$request->device_id)->count();
				if($idCount == 0){
					$dId = array('user_id' => $user->id,'device_type' => $device_type,'device_token' => $request->device_id,'created_at' => Carbon::now(),'updated_at' => Carbon::now());
					PushNotificationDeviceData::insert($dId);
				}
	
	if($request->device_type == 'ios'){
		$user_login = DB::table('user_login')->where('user_id',$user->id)->where('device_type','ios')->count();
		if($user_login == 0){
			$details = array('name' => $user->first_name.' '.$user->last_name);
			\Mail::to($user->email)->send(new IosLoginMail($details));
		}
	}
	
	$device = array('user_id' => $user->id,'device_type' => $device_type,'ipaddress' => $_SERVER['REMOTE_ADDR'],'created_at' => Carbon::now());
	DB::table('user_login')->insert($device);
}

            $success['access_token'] =  $user->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['first_name'] =  $user->first_name;
            $success['last_name'] = $user->last_name;
            $success['email'] = $user->email;
            $success['picture'] =  $user->picture;
            $success['role'] = $user->userRole();
            $success['username'] = $user->username;
			if($user->isFree() == true){
				if($measurements == 0){
					$success['measurements'] = true;
				}else{
					$success['measurements'] = false;
				}
				
				if($projects == 0){
					$success['projects'] = true;
				}else{
					$success['projects'] = false;
				}
				
			}else{
				$success['measurements'] = true;
				$success['projects'] = true;
				
			}

        }else{
Log::channel('stack')->info('User : ',['data' => $request->all(), 'RegisterFrom' => 'Mobile,Facebook','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

            $user = new User;
            $user->enc_id = md5($usersCount);
            $user->name = $first_name;
            $user->first_name = $first_name;
			$user->last_name = $last_name;
            $user->username = $username;
            $user->email = $email;
            $user->oauth_provider = $oauth_provider;
            $user->oauth_uid = '';
            $user->picture = $picture;
            $user->subscription_type = 1;
			$user->status = 1;
            $user->sub_exp = Carbon::now();
			$user->ipaddress = $_SERVER['REMOTE_ADDR'];
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();

            $user->subscription()->attach(['1']);

            $arr = array('user_id' => $user->id,'role_id' => 2,'created_at' => date('Y-m-d H:i:s'));
            $dd = DB::table('user_role')->insert($arr);

            $arr1 = array('user_id' => $user->id);
            //$ii = DB::table('user_measurements')->insert($arr);
            $up = DB::table('user_profile')->insert($arr1);
			
			$this->checkTimelinePosts($user->id);
			
			$user_id = $user->id;
			

            $user = User::where('id',$user_id)->first();
if($user){
	
	/*if($user->remainingDays() == 0){
	 $user->subscription()->detach();
	 $user->subscription()->attach(['1']);
	}*/
				
	$measurements = UserMeasurements::where('user_id',$user->id)->count();
	$projects = $user->projects()->where('is_archive',0)->where('is_deleted',0)->count();
}

            $success['access_token'] =  $user->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['first_name'] =  $user->first_name;
            $success['last_name'] = $user->last_name;
            $success['email'] = $user->email;
            $success['picture'] =  $user->picture;
            $success['role'] = $user->userRole();
            $success['username'] = $user->username;
			if($user->isFree() == true){
				if($measurements == 0){
					$success['measurements'] = true;
				}else{
					$success['measurements'] = false;
				}
				
				if($projects == 0){
					$success['projects'] = true;
				}else{
					$success['projects'] = false;
				}
				
			}else{
				$success['measurements'] = true;
				$success['projects'] = true;
			}
        }
		
		if(isset($request->device_type)){
				$device_type = $request->device_type;
				
				$idCount = PushNotificationDeviceData::where('user_id',$user->id)->where('device_token',$request->device_id)->count();
				if($idCount == 0){
					$dId = array('user_id' => $user->id,'device_type' => $device_type,'device_token' => $request->device_id,'created_at' => Carbon::now(),'updated_at' => Carbon::now());
					PushNotificationDeviceData::insert($dId);
				}
				
				if($request->device_type == 'ios'){
					$user_login = DB::table('user_login')->where('user_id',$user->id)->where('device_type','ios')->count();
					if($user_login == 0){
						$details = array('name' => $user->first_name.' '.$user->last_name);
						\Mail::to($user->email)->send(new IosLoginMail($details));
					}
				}
				$device = array('user_id' => $user->id,'device_type' => $device_type,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
				DB::table('user_login')->insert($device);
			}

        return $this->sendResponse($success, $this->successStatus);
    }

    function check_password(Request $request){
        $password = $request->password;
        $new_password = $request->new_password;
        $confirm_new_password = $request->confirm_new_password;


        if (!Hash::check($password, Auth::user()->password)) {
            return response()->json(['status' => 'fail','message' => 'Password entered is not matched with current password.']);
            exit;
        }else{
            $request->validate([
                'new_password' => 'required|string|min:6|max:16|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                'confirm_new_password' => 'same:new_password'
            ]);

            if($password == $new_password){
                return response()->json(['status' => 'fail','message' => 'Password & new password should not be same.']);
                exit;
            }

            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($request->new_password);
            $save = $user->save();

            if($save){
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'fail']);
            }
        }
    }

    function logout(){
        $user = Auth::user()->token();
        $save = $user->revoke();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }
	
	function checkTimelinePosts($id){
    	$timeline = Timeline::where('privacy','public')->get();
    	for ($i=0; $i < count($timeline); $i++) { 
    		$user_id = $timeline[$i]->user_id;
    		$timeline_id = $timeline[$i]->id;
    		$new_user_id = $id;

    		$array[] = [
    			'user_id' => $user_id,
    			'timeline_id' => $timeline_id,
    			'show_user_id' => $new_user_id,
    			'created_at' => Carbon::now(),
    			'updated_at' => Carbon::now()
    		];
    	}
    	//$data = array_chunk($array, 100);
    	foreach ($array as $da) {
    		TimelineShowPosts::insert($da);
    	}
    	
    }
	
	function apple_login(Request $request){
		Log::channel('stack')->info('User : ',['data' => $request->all(), 'Login from' => 'Mobile,Apple','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);
		
		if($request->email){
			$email = $request->email;
		}else{
			$email = '';
		}
		
		if($request->givenName){
			$givenName = $request->givenName;
		}else{
			$givenName = '';
		}
		
		if($request->familyName){
			$familyName = $request->familyName;
		}else{
			$familyName = '';
		}
		
		if($request->userId){
			$userId = $request->userId;
		}else{
			$userId = '';
		}
		
		if($request->email){
			$user = User::where('email',$request->email)->first();
		}else{
			$user = User::where('oauth_uid',$userId)->first();
		}
		
		if($user){
			
				/*if($user->remainingDays() == 0){
				 $user->subscription()->detach();
				 $user->subscription()->attach(['1']);
				}*/
				
			$measurements = UserMeasurements::where('user_id',$user->id)->count();
			$projects = $user->projects()->where('is_archive',0)->where('is_deleted',0)->count();
			
			$success['access_token'] =  $user->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['first_name'] =  $user->first_name;
            $success['last_name'] = $user->last_name;
            $success['email'] = $user->email;
            $success['picture'] =  $user->picture;
            $success['role'] = $user->userRole();
            $success['username'] = $user->username;
			if($user->isFree() == true){
				if($measurements == 0){
					$success['measurements'] = true;
				}else{
					$success['measurements'] = false;
				}
				
				if($projects == 0){
					$success['projects'] = true;
				}else{
					$success['projects'] = false;
				}
				
			}else{
				$success['measurements'] = true;
				$success['projects'] = true;
			}
			
		}else{
			$oauth_provider = 'Apple';
            $userCount = User::count() + 1;

            $user = new User;
            $user->enc_id = md5($userCount);
            $user->name = $givenName.' '.$familyName;
            $user->first_name = $givenName;
            $user->last_name = $familyName;
            $user->username = '';
            $user->email = $email;
            $user->oauth_provider = $oauth_provider;
            $user->oauth_uid = $userId;
            $user->picture = Avatar::create($givenName)->toBase64();;
            $user->subscription_type = 1;
			$user->status = 1;
            $user->sub_exp = Carbon::now();
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();

            $user->subscription()->attach(['1']);

            $arr = array('user_id' => $user->id,'role_id' => 2,'created_at' => date('Y-m-d H:i:s'));
            $dd = DB::table('user_role')->insert($arr);

            $arr1 = array('user_id' => $user->id);
            //$ii = DB::table('user_measurements')->insert($arr);
            $up = DB::table('user_profile')->insert($arr1);
			
			$this->checkTimelinePosts($user->id);
			
				/*if($user->remainingDays() == 0){
				 $user->subscription()->detach();
				 $user->subscription()->attach(['1']);
				}*/
			
			$measurements = UserMeasurements::where('user_id',$user->id)->count();
			$projects = $user->projects()->where('is_archive',0)->where('is_deleted',0)->count();
			
			$success['access_token'] =  $user->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['first_name'] =  $user->first_name;
            $success['last_name'] = $user->last_name;
            $success['email'] = $user->email;
            $success['picture'] =  $user->picture;
            $success['role'] = $user->userRole();
            $success['username'] = $user->username;
			if($user->isFree() == true){
				if($measurements == 0){
					$success['measurements'] = true;
				}else{
					$success['measurements'] = false;
				}
				
				if($projects == 0){
					$success['projects'] = true;
				}else{
					$success['projects'] = false;
				}
				
			}else{
				$success['measurements'] = true;
				$success['projects'] = true;
			}
		}
		
		
		if(isset($request->device_type)){
				$device_type = $request->device_type;
				$idCount = PushNotificationDeviceData::where('user_id',$user->id)->where('device_token',$request->device_id)->count();
				if($idCount == 0){
					$dId = array('user_id' => $user->id,'device_type' => $device_type,'device_token' => $request->device_id,'created_at' => Carbon::now(),'updated_at' => Carbon::now());
					PushNotificationDeviceData::insert($dId);
				}
				
				if($request->device_type == 'ios' && $user->email != ""){
					$user_login = DB::table('user_login')->where('user_id',$user->id)->where('device_type','ios')->count();
					if($user_login == 0){
						$details = array('name' => $user->first_name.' '.$user->last_name);
						\Mail::to($user->email)->send(new IosLoginMail($details));
					}
				}
				$device = array('user_id' => $user->id,'device_type' => $device_type,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
				DB::table('user_login')->insert($device);
			}
			
			return $this->sendResponse($success, $this->successStatus);
			
			
        }
		
		
		function login_with_user_id(Request $request){
			
			$user = User::find($request->user_id);
			
			$success['access_token'] =  $user->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $user->id;
            $success['name'] =  $user->name;
            $success['first_name'] =  $user->first_name;
            $success['last_name'] = $user->last_name;
            $success['email'] = $user->email;
            $success['picture'] =  $user->picture;
            $success['role'] = $user->userRole();
            $success['username'] = $user->username;
			if($user->isFree() == true){
				if($measurements == 0){
					$success['measurements'] = true;
				}else{
					$success['measurements'] = false;
				}
				
				if($projects == 0){
					$success['projects'] = true;
				}else{
					$success['projects'] = false;
				}
				
			}else{
				$success['measurements'] = true;
				$success['projects'] = true;
			}
			
			return $this->sendResponse($success, $this->successStatus);
		}
		
		function verify_user(Request $request){
			Log::channel('stack')->info('User : ',['data' => $request->all(), 'RegisterFrom' => 'Apple, verify user','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);
			
			$token = $request->token;
			$user = DB::table('merged_users')->where('token',$token)->where('status',0)->first();
			if($user){
				$users = User::where('id',$user->merging_user_id)->first();
				
				$updateUser = User::find($user->main_user_id);
				$updateUser->oauth_provider = $users->oauth_provider;
				$updateUser->oauth_uid = $users->oauth_uid;
				$updateUser->save();
				
				$array = array('status' => 1,'updated_at' => Carbon::now());
				DB::table('merged_users')->where('token',$token)->update($array);
				
				$del = User::find($user->merging_user_id);
				$del->delete();
				
				if($updateUser){
					$message = 'Your account was merged successfully.';
					return view('merged',compact('message'));
				}else{
					$message = 'Unable to merge your account.Try again after some time.';
					return view('merged',compact('message'));
				}
			}else{
				$message = 'Your account was already merged.';
					return view('merged',compact('message'));
			}
		}
}
