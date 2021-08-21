<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;
use DB;
use Validator;
use Mail;
use Redirect;
use App\Mail\RegistrationMail;
use App\Mail\AccountVerificationMail;
use App\Mail\PasswordResetMail;
use Carbon\Carbon;
use Log;
use App\Traits\UserAgentTrait;
use App\Models\Timeline;
use App\Models\TimelineShowPosts;
use App\Models\UserLogin;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
	use UserAgentTrait;
	

    public function findUsername()
    {
        $login = request()->input('email');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);

        return $fieldType;
    }



    function login_page(Request $request){
		
		$previousUrl = url()->previous();
        //Session::forget('previous_url');
        if(url()->previous() != 'https://stitchersstudio.com/web/login'){
            Session::put('previous_url',$previousUrl);
        }
	
	if(Auth::check()){
            return redirect('home');
        }
    	if($request->isMethod('get')){
			$redirect = $request->get('redirect_uri') ? $request->get('redirect_uri') : '';
			
			$identity = $request->get('identity') ? $request->get('identity') : '';
            $invited = $request->get('invited') ? $request->get('invited') : '';
            $new = $request->get('new') ? $request->get('new') : '';
    		return view('auth/login',compact('redirect','identity','invited','new'));

    		//return view('auth/login',compact('redirect'));
    		//return view('auth/login');
    	}else{

//Log::useDailyFiles(storage_path().'/logs/users-laravel.log');
//Log::channel('stack')->info('Login: ',['data' => $request->all()]);
/*
if($this->findUsername() == 'email'){
    $validator = $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/'
    ]);
}else{
    $validator = $request->validate([
        'username' => 'required|alpha_num|min:5|max:25',
        'password' => 'required|string|min:6|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/'
    ]);
}
*/
/*
if(! $validator){
    return redirect()->back();
}else{
    echo $request->password;
}

exit;
*/

if($this->findUsername() == 'email'){
    $username = 'email';
}else{
    $username = 'username';
}

$user = User::where($username,$request->email)->first();

if(!$user){
    Session::flash('error','User does not exist. Please register.');
    return redirect()->back();
    exit;
}

		if($user->hasRole('Designer') && ($user->temp_password != '')){
            $password = $user->temp_password;
            if(($user->email == $request->email) && ($password == $request->password)){
                $previous = Session::get('previous_url');
                Auth::loginUsingId($user->id, true);
                sleep(2);
                if($previous){
                    return redirect($previous);
                }else{
                    return redirect('designer/main/dashboard');
                }
            }else{
                Session::flash('error','Invalid credentials. Please check & try again.');
                return redirect()->back();
            }
            exit;
        }

 
	$redirect = $request->redirect_uri ? $request->redirect_uri : '';
	$remember = $request->remember;
	$data = array($this->findUsername() => $request->email,'password' => $request->password);


        if(Auth::attempt($data,$remember)){

            if(Auth::user()->status == 1){

Log::channel('stack')->info('User Login: ',['data' => $request->all(),'RegisterFrom' => 'Website','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

				$device = $this->myBrowser();
				if($device['isDesktop'] == 1){
					$desktops = 'true';
				}else{
					$desktops = 'false';
				}
				if($device['isPhone'] == 1){
					$isPhone = 'true';
				}else{
					$isPhone = 'false';
				}
				$device_type = 'Web Login, browser :'.$device['browser'].',platform :'.$device['platform'].',version :'.$device['version'].',Desktop :'.$desktops.',Mobile :'.$isPhone;
				//$device = array('user_id' => Auth::user()->id,'device_type' => $device_type,'ipaddress' => $_SERVER['REMOTE_ADDR'],'created_at' => Carbon::now());
				$userLogin1 = new UserLogin;
				$userLogin1->user_id = Auth::user()->id;
				$userLogin1->device_type = $device_type;
				$userLogin1->ipaddress = $_SERVER['REMOTE_ADDR'];
				$userLogin1->created_at = Carbon::now();
				$userLogin1->save(); 
				//DB::table('user_login')->insert($device);

				if(Auth::user()->hasRole('Admin')){
					return redirect('admin');
                }
				
				if(Auth::user()->invited_as_designer == 1){
                    if($request->identity){
                        $identity = $request->identity;
                        $invited = $request->invited;
                        $new = $request->new;
                    }else{
                        $identity = base64_encode(Auth::user()->email);
                        $invited = "yes";
                        $new = "no";
                    }
                    Session::put('identity',$identity);
                    Session::put('invited',$invited);
                    Session::put('new',$new);
                    
                    return redirect('user/agree-terms-conditions?identity='.$identity.'&invited='.$invited.'&new='.$new);
                    exit;
                }


                if(Auth::user()->hasRole('Knitter')){
					if($redirect == 'subscription'){
						return redirect('knitter/subscription');
						exit;
					}else if($redirect == 'feedback'){
						return redirect('feedback');
						exit;
					}
					return redirect('dashboard');
                    //return redirect('knitter/dashboard');
                    //return redirect()->back();
                }

                if(Auth::user()->hasRole('Designer')){
                    return redirect('designer/main/dashboard');
                    //return redirect()->back();
                }
                return redirect('/');

            }else{
$user = User::where('email',$request->email)->orWhere('username',$request->email)->first();
                Auth::logout();
                Session::flash('error','Your email was not activated . Please check your email to activate your account.');
                Session::flash('resend',$user->id);
                return redirect()->back();
            }
        }else{
          Session::flash('error','Invalid credentials / No account exists . Please check & try again.');
            return redirect()->back();
        }

    	}
    }

	function Register_validate(Request $request){
		if(Auth::check()){
			return redirect('connect');
		}
    	if($request->isMethod('get')){
			            $identity = $request->get('identity') ? $request->get('identity') : '';
            $invited = $request->get('invited') ? $request->get('invited') : '';
            $new = $request->get('new') ? $request->get('new') : '';
    		return view('auth/register',compact('identity','invited','new'));

    		//return view('auth/register');
    	}else{
    		$validator = $request->validate([
                'first_name' => 'required|alpha|min:2|max:15',
                'last_name' => 'required|alpha|min:2|max:15',
	            'username' => 'required|alpha_num|max:25|unique:users',
		        'email' => 'required|email|unique:users',
		        'password' => 'required|string|min:6|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/',
		        'confirm_password' => 'same:password',
		        'terms_and_conditions' => 'required',
				'captchval' => 'required',
                'captcha' => 'required|same:captchval'
	        ]);
           /* [
                'password.regex' => 'Your password must be more than 8 characters long, should contain at least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.'
            ]); */

		    if(! $validator){
				if($request->ajax()){
					return false;
				}
	            return redirect()->back();
	        }else{

Log::channel('stack')->info('User Registration: ',['data' => $request->all(),'RegisterFrom' => 'Website','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

            $userCount = User::count() + 1;

	        	 $y = date('Y') + 1; $m = date('m'); $d = date('d');
            	 $exp = $y.'-'.$m.'-'.$d;

                 $md5email = md5($request->email);
                 $firstChar = mb_substr($request->first_name, 0, 1, "UTF-8");
                 $pic = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.strtoupper($firstChar);

            $user = new User;
            $user->enc_id = md5($userCount);
            $user->name = $request->username;
            $user->first_name = ucfirst($request->first_name);
            $user->last_name = ucfirst($request->last_name);
            $user->username = strtolower($request->username);
            $user->email = strtolower($request->email);
            $user->password = bcrypt($request->password);
            $user->enc_email = $md5email;
            $user->picture = $pic;
            $user->oauth_picture = $this->random_color();
            $user->subscription_type = 1;
			if($request->identity){
                $user->invited_as_designer = 1;
            }

            $user->sub_exp = Carbon::now();
            $user->created_at = date('Y-m-d H:i:s');
            $user->remember_token = bcrypt($userCount);
			$user->ipaddress = $_SERVER['REMOTE_ADDR'];
            $user->save();

            $user->subscription()->attach(['1']);

            /* $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['first_name'] =  $user->first_name; */

            $arr = array('user_id' => $user->id,'role_id' => 2,'created_at' => date('Y-m-d H:i:s'));
            $dd = DB::table('user_role')->insert($arr);

            $arr = array('user_id' => $user->id);
            //$ii = DB::table('user_measurements')->insert($arr);
            $up = DB::table('user_profile')->insert($arr);

			$this->checkTimelinePosts($user->id);

			$details = [
			    'detail'=>'detail',
			    'name'  => ucwords(ucwords($request->username)),
			    'email' => strtolower($request->email),
				'encemail' => $md5email
			     ];

            //\Mail::to($request->email)->send(new RegistrationMail($details));
			
			try{
				\Mail::to($request->email)->send(new RegistrationMail($details));
				Session::flash('error','You have successfully registered. Please check your email to activate your account.');
				Session::flash('resend',$user->id);
			}catch(\Exception $e){
				$message = $e->getMessage();
				Session::flash('error','You have successfully registered. Unable to send email.');
				Session::flash('resend',$user->id);
			}

			if($request->ajax()){
				return true;
			}
			return redirect('login');
	        }
    	}
    }

    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }

    function logout(){
		Log::channel('stack')->info('User Logout: ',['data' => Auth::user(),'RegisterFrom' => 'Website','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);
		if(Session::has('skip_invitation')){
            Session::forget('skip_invitation');
        }

    	Auth::logout();
    	return redirect('login');
    }


           function email_activate(Request $request){
           $e = $request->encemail;
			$db = DB::table('users')->where('enc_email',$e)->where('status',0)->first();

        if($db){
        if($db->status == 1){
            return view('alreadyactivated');
        }else{
            $ar = array('status'=>1,'updated_at' => Carbon::now());
            $dd = DB::table('users')->where('enc_email',$e)->update($ar);


            $details = array(
                'detail'=>'detail',
                'name'  => ucwords(ucwords($db->username)),
                'email' =>$db->email
            );

            \Mail::to($db->email)->send(new AccountVerificationMail($details));

            return view('activated');
        }

    }else{

        return view('alreadyactivated');

   }
    }



    function reset_password(){
        return view('auth.passwords.email');
    }

function send_reset_password_link(Request $request,User $user){
		if($this->findUsername() == 'email'){
			$validator = $request->validate([
				'email' => 'required|email'
			]);
			$variable = 'email';
		}else{
			$validator = $request->validate([
				'email' => 'required'
			]);
			$variable = 'username';
		}

        if(! $validator) {
            return redirect()->back();
        }else{
            $check = User::where($variable,$request->email)->first();
           if($check){
           $time = md5(time());
            $array = array('email' => $check->email,'token' => $time,'created_at' => date('Y-m-d H:i:s'));
            DB::table('password_resets')->insert($array);

            $details = array(
                'name'  => ucwords(ucwords($check->first_name.' '.$check->last_name)),
                'email' =>$check->email,
                'token' => $time
            );

            \Mail::to($check->email)->send(new PasswordResetMail($details));
            Session::flash('success','Email has been sent to the registered email with reset link');

           }else{
            Session::flash('fail','Email / Username does not found in our records.');

           }
           return redirect()->back();
        }
    }

    function validate_password(Request $request){
        $token = $request->token;
        $expired = DB::table('password_resets')->where('token',$request->token)->first();
        if($expired->is_clicked == 1){
            return view('auth.passwords.expired');
            exit;
        }

        if(date('Y-m-d') != date('Y-m-d',strtotime($expired->created_at))){
            return view('auth.passwords.expired');
            exit;
        }
        $check = DB::table('password_resets')->where('token',$token)->first();
        $email = base64_encode($check->email);
        return view('auth.passwords.reset',compact('email','token'));
    }

    function check_validpage(Request $request){
        $expired = DB::table('password_resets')->where('token',$request->token)->first();
        if($expired->is_clicked == 1){
            echo 'expired';
        }

        if(date('Y-m-d') != date('Y-m-d',strtotime($expired->created_at))){
            echo 'expired';
        }
        return '';
    }

    function validate_newpassword(Request $request){

        $validator = $request->validate([
            'password' => 'required|string|min:6|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/',
            'confirm_password' => 'required|same:password|min:8|max:16'
        ]);


        if(! $validator) {
            return response()->json([
            'success' => 'false',
            'errors'  => $validator->getMessageBag()->toArray(),
            ], 400);
        }else{

        $email = base64_decode($request->tok);

        $expired = DB::table('password_resets')->where('token',$request->token)->first();
        if($expired->is_clicked == 1){
            return view('auth.passwords.expired');
            exit;
        }

        if(date('Y-m-d') != date('Y-m-d',strtotime($expired->created_at))){
            return view('auth.passwords.expired');
            exit;
        }
        $array = array('password' => bcrypt($request->password));
        $upd = User::where('email',$email)->update($array);

        $array1 = array('is_clicked' => 1);
        $upd1 = DB::table('password_resets')->where('token',$request->token)->update($array1);

        if($upd){
            return 0;
        }else{
            return 1;
        }

    }

}


function resend_email(Request $request){
    $id = $request->id;
    $user = User::where('enc_id',$id)->first();
    $details = [
        'detail'=>'detail',
        'name'  => ucwords(ucwords($user->username)),
        'email' => strtolower($user->email),
        'encemail' => $user->enc_email
         ];

    


    try{
        \Mail::to($user->email)->send(new RegistrationMail($details));
        Session::flash('error','Email has sent successfully. Please check your email to activate your account.');
        Session::flash('resend',$user->id);
    }catch(\Exception $e){
        $message = $e->getMessage();
        Session::flash('error','Unable to send email. Please write an email to info@knitfitco.com');
        //Session::flash('resend',$user->id);
    }
    return redirect()->back();
}


    function checkSession(){
        if(!Auth::check()){
            return response()->json(['status' => false]);
        }else{
            return response()->json(['status' => true]);
        }
    }
	
	function checkUsername(Request $request){
        $username = $request->get('username');
        $user = User::where('username',$username)->count();
        if($user > 0){
            return response()->json(['valid' => false]);
        }else{
            return response()->json(['valid' => true]);
        }
    }

    function checkEmail(Request $request){
        $email = $request->get('email');
        $user = User::where('email',$email)->count();
        if($user > 0){
            return response()->json(['valid' => false]);
        }else{
            return response()->json(['valid' => true]);
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
	
	
	    function update_user_roles(Request $request){
        $identity = base64_decode($request->identity);
        $invited = $request->invited;
        $new = $request->new;

        if($request->terms == 1){
            $user = User::find(Auth::user()->id);
            $user->invited_as_designer = 2;
            $save = $user->save();

            if($save){
                Session::forget('identity');
                Session::forget('invited');
                Session::forget('new');
                if(Session::has('skip_invitation')){
                    Session::forget('skip_invitation');
                }
                $arr = array('user_id' => $user->id,'role_id' => 4,'created_at' => date('Y-m-d H:i:s'));
                $dd = DB::table('user_role')->insert($arr);
                return response()->json(['status' => true,'message' => 'Your role has updated successfully.']);
            }else{
                return response()->json(['status' => false,'message' => 'Unable to update,try again after sometime.']);
            }
            
        }else{
            return response()->json(['status' => false,'message' => 'Please accept terms & conditions check box.']);
        }
    }

    function skip_invitation(){
        Session::put('skip_invitation');
        return redirect('dashboard');
    }

}
