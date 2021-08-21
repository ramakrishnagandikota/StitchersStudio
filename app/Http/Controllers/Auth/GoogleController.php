<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use Exception;
use App\User;
use DB;
use Validator;
use Mail;
use Redirect;
use Laravel\Passport\Passport;
use Carbon\Carbon;
use Session;
use Log;
use App\Traits\UserAgentTrait;
use App\Models\Timeline;
use App\Models\TimelineShowPosts;

class GoogleController extends Controller
{
	use UserAgentTrait;
	
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->with(['API_KEY' => 'AIzaSyDJmxPukLMCRl8PnoMbqlYtwPxh7E9I2z4'])->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try{
            $gmailuser = Socialite::driver('google')->stateless()->user();
        }catch (\Exception $e){
            Session::flash('error','Unable to login.Try again after some time.');
            return redirect('login');
        }

        $user = User::where('email',$gmailuser->getEmail())->first();

        if(! $user){

Log::channel('stack')->info('User : ',['data' => $gmailuser, 'RegisterFrom' => 'Google','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);

			$name = $gmailuser->getName();
            $check = explode(' ', $name);
            $count = count($check);

            $last_name =$check[$count - 1];
            $first_name = str_replace($last_name, '', $name);
            
            
            $userCount = User::count() + 1;
            $y = date('Y') + 1; $m = date('m'); $d = date('d');
            $exp = $d.'-'.$m.'-'.$d;

            $appuser = new User;
            $appuser->enc_id = md5($userCount);
            $appuser->first_name = $first_name;
            $appuser->last_name = $last_name;
            $appuser->email = $gmailuser->getEmail();
            $appuser->oauth_provider = 'google';
            $appuser->oauth_uid = $gmailuser->getId();
            $appuser->picture = $gmailuser->getAvatar();
            $appuser->status = 1;
            $appuser->enc_email = md5($gmailuser->getEmail());
            $appuser->subscription_type = 1;
            $appuser->sub_exp = Carbon::now();
			$appuser->ipaddress = $_SERVER['REMOTE_ADDR'];
            $appuser->created_at = date('Y-m-d H:i:s');
            $appuser->save();
			
			$appuser->subscription()->attach(['1']);


            $arr = array('user_id' => $appuser->id,'role_id' => 2,'created_at' => date('Y-m-d H:i:s'));
            $dd = DB::table('user_role')->insert($arr);

            $arr1 = array('user_id' => $appuser->id);
            
            $up = DB::table('user_profile')->insert($arr1);
            $this->checkTimelinePosts($appuser->id);
            $users = User::where('email',$gmailuser->getEmail())->first();
            Auth::login($users,true);
			
			
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
				$device_type = 'Google Login, browser :'.$device['browser'].',platform :'.$device['platform'].',version :'.$device['version'].',Desktop :'.$desktops.',Mobile :'.$isPhone;
				$device = array('user_id' => $users->id,'device_type' => $device_type,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
				DB::table('user_login')->insert($device);
				
            return redirect('/knitter/dashboard');
        }else{
			Log::channel('stack')->info('User Login: ',['data' => $request->all(),'RegisterFrom' => 'Website,Google','Browser' => $this->myBrowser(),'ipaddress' => $_SERVER['REMOTE_ADDR']]);
             Auth::login($user,true);
			 
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
				$device_type = 'Google Login, browser :'.$device['browser'].',platform :'.$device['platform'].',version :'.$device['version'].',Desktop :'.$desktops.',Mobile :'.$isPhone;
				$device = array('user_id' => $user->id,'device_type' => $device_type,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
				DB::table('user_login')->insert($device);
				
            return redirect('/knitter/dashboard');
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
}
