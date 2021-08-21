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
use Hash;
use Log;
use App\Traits\UserAgentTrait;
use Laravolt\Avatar\Facade as Avatar;
use Image;

class LoginController extends Controller
{
    public $successStatus = 200;
	use UserAgentTrait;

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

         /*if($this->findUsername() == 'email'){
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
                 return $this->sendError($success,401);
                 exit;
            }
			
Log::channel('stack')->info('User Login: ',['data' => $request->all(),'RegisterFrom' => 'Website','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

            $user = Auth::user();
			
			$firstChar = mb_substr($user->first_name, 0, 1, "UTF-8");
			$pic = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.strtoupper($firstChar);


            $success['access_token'] =  $user->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $user->id;
            $success['name'] =  $user->first_name;
            $success['picture'] =  ($user->picture) ? $user->picture : $pic;
			$success['role'] = $user->userRole();

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

Log::channel('stack')->info('User : ',['data' => $request->all(), 'RegisterFrom' => 'Mobile','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

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
            $user->picture = $pic;
            $user->subscription_type = 1;
			$user->status = 1;
            $user->sub_exp = Carbon::now()->addDays(30);
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();

        //$success['access_token'] =  $user->createToken('MyApp')->accessToken;
        $success['message'] =  'Hi '.$user->first_name.' '.$user->last_name.', Please check your email to activate your account.';


        $user->subscription()->attach(['1']);

        $arr = array('user_id' => $user->id,'role_id' => 2,'created_at' => date('Y-m-d H:i:s'));
            $dd = DB::table('user_role')->insert($arr);

            $arr = array('user_id' => $user->id);
            //$ii = DB::table('user_measurements')->insert($arr);
            $up = DB::table('user_profile')->insert($arr);



            $details = [
                'detail'=>'detail',
                'name'  => ucwords(ucwords($request->username)),
                'email' =>$request->email,
                'encemail' => $md5email
                 ];

            \Mail::to($request->email)->send(new RegistrationMail($details));


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

            \Mail::to($request->email)->send(new PasswordResetMail($details));
            //Session::flash('success','Mail has been sent to the registered email with reset link');

            $success['status'] = 'Mail has been sent to the registered email with reset link';



           }else{
            $success['status'] = 'Mail does not found in our records.';

           }
           return $this->sendResponse($success, $this->successStatus);
        }
    }


    function login_google(Request $request){
        $email = $request->email;
        $dd = explode('@',$email);

        if($request->displayName){
            $name = $request->displayName;
        }else{
            $name = $dd[0];
        }

        if($request->givenName){
            $first_name = $request->givenName;
        }else{
            $first_name = $dd[0];
        }

        if($request->familyName){
            $last_name = $request->familyName;
        }else{
            $last_name = $dd[0];
        }

        if($request->userId){
            $oauth_uid = $request->userId;
        }else{
            $oauth_uid = $dd[0];
        }

        if($request->imageUrl){
            $picture = $request->imageUrl;
        }else{
            $firstChar = mb_substr($first_name, 0, 1, "UTF-8");
            $picture = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.$firstChar;
        }


        $oauth_provider = 'Google';

        $userCount = User::where('email',$email)->first();

        if($userCount){
	Log::channel('stack')->info('User Login: ',['data' => $request->all(),'RegisterFrom' => 'Mobile,Google','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);
	
			$user = Auth::loginUsingId($userCount->id, true);
			if($user){
	
            $success['access_token'] =  $user->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $user->id;
            $success['name'] =  $user->first_name;
            $success['picture'] =  $user->picture;
			$success['role'] = $user->userRole();
			}else{
				$success['error'] = 'Unable to login';
			}

        }else{

Log::channel('stack')->info('User : ',['data' => $request->all(), 'RegisterFrom' => 'Mobile,Google','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

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
            $user->sub_exp = Carbon::now()->addDays(30);
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();

            $user->subscription()->attach(['1']);

            $arr = array('user_id' => $user->id,'role_id' => 2,'created_at' => date('Y-m-d H:i:s'));
            $dd = DB::table('user_role')->insert($arr);

            $arr = array('user_id' => $user->id);
            //$ii = DB::table('user_measurements')->insert($arr);
            $up = DB::table('user_profile')->insert($arr);
			
			$newUser = Auth::loginUsingId($user->id, true);
			
			if($newUser){

            $success['access_token'] =  $newUser->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $newUser->id;
            $success['name'] =  $newUser->first_name;
            $success['picture'] =  $newUser->picture;
			$success['role'] = $newUser->userRole();
			}else{
				$success['error'] = 'Unable to login';
			}
        }

        return $this->sendResponse($success, $this->successStatus);
    }

/*
    email:"dshendkar@yahoo.in"
    first_name:"Dattatray"
    picture:"https://platform-lookaside.fbsbx.com/platform/profilepic/?asid=2783228471767882&height=720&width=720&ext=1587629507&hash=AeTNVpfmPL-FbYLh"
    username:"Dattatray Shendkar"
*/
    function login_facebook(Request $request){
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
            $first_name = $request->first_name;
        }else{
            $first_name = '';
        }

        if($request->username){
            $username = $request->username;
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
Log::channel('stack')->info('User Login: ',['data' => $request->all(),'RegisterFrom' => 'Mobile,Facebook','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

			$user = Auth::loginUsingId($userCount->id, true);
			if($user){
            $success['access_token'] =  $userCount->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $userCount->id;
            $success['name'] =  $userCount->first_name;
            $success['picture'] =  $userCount->picture;
			$success['role'] = $userCount->userRole();
			}else{
				$success['error'] = 'Unable to login';
			}

        }else{
Log::channel('stack')->info('User : ',['data' => $request->all(), 'RegisterFrom' => 'Mobile,Facebook','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

            $user = new User;
            $user->enc_id = md5($usersCount);
            $user->name = $first_name;
            $user->first_name = $first_name;
            $user->username = $username;
            $user->email = $email;
            $user->oauth_provider = $oauth_provider;
            $user->oauth_uid = '';
            $user->picture = $picture;
            $user->subscription_type = 1;
			$user->status = 1;
            $user->sub_exp = Carbon::now()->addDays(30);
            $user->created_at = date('Y-m-d H:i:s');
            $user->save();

            $user->subscription()->attach(['1']);

            $arr = array('user_id' => $user->id,'role_id' => 2,'created_at' => date('Y-m-d H:i:s'));
            $dd = DB::table('user_role')->insert($arr);

            $arr = array('user_id' => $user->id);
            //$ii = DB::table('user_measurements')->insert($arr);
            $up = DB::table('user_profile')->insert($arr);
			
			$newUser = Auth::loginUsingId($user->id, true);
			
			if($newUser){

            $success['access_token'] =  $newUser->createToken('MyApp')->accessToken;
            $success['token_type'] =  'Bearer';
            $success['expires_in'] =  Carbon::now()->addDays(15);
			$success['id'] =  $newUser->id;
            $success['name'] =  $newUser->first_name;
            $success['picture'] =  $newUser->picture;
			$success['role'] = $newUser->userRole();
			}else{
				$success['error'] = 'Unable to login';
			}
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
		Log::channel('stack')->info('User Logout: ',['data' => Auth::user(),'RegisterFrom' => 'Mobile','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);
        $user = Auth::user()->token();
        $save = $user->revoke();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }
}
