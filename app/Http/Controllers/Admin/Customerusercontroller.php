<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Input;
use Mail;
use App\Models\PaypalCredentials;
use Artisan;
use Laravolt\Avatar\Facade as Avatar;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;	


class Customerusercontroller extends Controller
{
    function cususers_view(Request $request){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
		
		if($request->status == 'active'){
			$query = User::where('status',1)->get();
			$status = 'Active';
		}else if($request->status == 'inactive'){
			$query = User::where('status',0)->get();
			$status = 'In Active';
		}else{
			$query = User::all();
			$status = 'All';
		}

		 
		
		return view('admin/users/allusers',compact('query','status'));
	}
	
	function cususers_add(){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
		$roles = Role::where('status',1)->get();
		return view('admin/users/adduser',compact('roles'));
	}
	
	function cususers_insert(Request $request){
		
		if($request->role == 4){
            if(($request->store_name != '') || ($request->paypal_email != '')){
				$validator = $request->validate([
                'first_name' => 'required|alpha|min:2|max:15',
                'last_name' => 'required|alpha|min:2|max:15',
                'username' => 'required|alpha_num|max:25|unique:users',
                'email' => 'required|email|unique:users',
                'role' => 'required',
                'store_name' => 'required',
                'store_status' => 'required',
                'account_type' => 'required',
                'paypal_email' => 'required|email|unique:paypal_credentials',
            ]);
				
			}else{
				$validator = $request->validate([
                'first_name' => 'required|alpha|min:2|max:15',
                'last_name' => 'required|alpha|min:2|max:15',
                'username' => 'required|alpha_num|max:25|unique:users',
                'email' => 'required|email|unique:users',
                'role' => 'required',
            ]);
			}
        }else{
            $validator = $request->validate([
                'first_name' => 'required|alpha|min:2|max:15',
                'last_name' => 'required|alpha|min:2|max:15',
                'username' => 'required|alpha_num|max:25|unique:users',
                'email' => 'required|email|unique:users',
                'role' => 'required'
            ]);
        }
        $allUsersCount = User::orderBy('id','desc')->first();
        $userCount = $allUsersCount->id + 1;

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
        //$user->password = bcrypt('Password@123');
		$user->temp_password = $request->password;
        $user->enc_email = $md5email;
        $user->picture = Avatar::create($request->first_name)->toBase64();
        $user->subscription_type = 1;
        $user->status = 1;
        $user->sub_exp = Carbon::now()->addDays(30);
        $user->created_at = date('Y-m-d H:i:s');
        $user->remember_token = bcrypt($userCount);
        $user->ipaddress = $_SERVER['REMOTE_ADDR'];
        $save = $user->save();

        if($save){
            if($request->role == 4){
                $paypal = new PaypalCredentials;
                $paypal->user_id = $user->id;
                if(($request->store_name != '') || ($request->paypal_email != '')){
					$paypal->store_name = $request->store_name;
					$paypal->store_status = $request->store_status;
					$paypal->account_type = $request->account_type;
					$paypal->paypal_email = $request->paypal_email;
				}else{
					$paypal->store_name = '';
					$paypal->store_status = '';
					$paypal->account_type = '';
					$paypal->paypal_email = '';
				}
                $paypal->save();
            }

            $user->subscription()->attach([1]);
            $role = Role::where('role_name',$request->role)->first();
            $arr = array('user_id' => $user->id,'role_id' => $request->role,'created_at' => date('Y-m-d H:i:s'));
            $dd = DB::table('user_role')->insert($arr);

            $arr = array('user_id' => $user->id);
            $up = DB::table('user_profile')->insert($arr);
            return 0;
        }else{
            return 1;
        }
     }
	 
	  function setup_password(Request $request){
		 
		$email = str_replace('-', '@', $request->email);
		return view('setup-password',compact('email'));
    }
	
	function update_setup_myaccount(){
		
		$data = Input::all();
		$array = array('password' => bcrypt($data['password']),'status'=>1);
		$is = DB::table('users')->where('email',$data['user_email'])->update($array);
		if($is){
			return redirect('login');
		}else{
			return redirect()->back();
		}
	}

    function cususers_edit(Request $request){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
		$id = $request->id;
		$users = User::where('id',$id)->get();
		$paypal = PaypalCredentials::where('user_id',$id)->first();
        $roles = Role::where('status',1)->get();
		return view('admin/users/edituser',compact('users','paypal','roles'));
	
    }

    function cususers_update(Request $request){
		if($request->role == 4){
            if(($request->store_name != '') || ($request->paypal_email != '')){
				$validator = $request->validate([
					'first_name' => 'required|alpha|min:2|max:15',
					'last_name' => 'required|alpha|min:2|max:15',
					'username' => 'required|alpha_num|max:25',
					'role' => 'required',
					'store_name' => 'required',
					'store_status' => 'required',
					'account_type' => 'required',
					'paypal_email' => 'required|email|unique:paypal_credentials',
				]);
			}else{
				$validator = $request->validate([
                'first_name' => 'required|alpha|min:2|max:15',
                'last_name' => 'required|alpha|min:2|max:15',
                'username' => 'required|alpha_num|max:25',
                'role' => 'required'
            ]);
			}
        }else{
            $validator = $request->validate([
                'first_name' => 'required|alpha|min:2|max:15',
                'last_name' => 'required|alpha|min:2|max:15',
                'username' => 'required|alpha_num|max:25',
                'role' => 'required'
            ]);
        }

        $user = User::find($request->id);
        $user->first_name = ucfirst($request->first_name);
        $user->last_name = ucfirst($request->last_name);
        $user->username = strtolower($request->username);
        $user->updated_at = date('Y-m-d H:i:s');
        $save = $user->save();

        if($save){
			$paypalcheck = PaypalCredentials::where('user_id',$user->id)->count();
            if(count($request->role) == 1){
				$user->roles()->sync([$request->role[0]]);
			}
			if(count($request->role) == 2){
				$user->roles()->sync([$request->role[0],$request->role[1]]);
			}
			if(count($request->role) == 3){
				$user->roles()->sync([$request->role[0],$request->role[1],$request->role[2]]);
			}
			for($i=0;$i<count($request->role);$i++){
				if($request->role[$i] == 4) {
					if ($paypalcheck == 0){
						$paypal = new PaypalCredentials;
						$paypal->user_id = $request->id;
						$paypal->store_name = $request->store_name;
						$paypal->store_status = $request->store_status;
						$paypal->account_type = $request->account_type;
						$paypal->paypal_email = $request->paypal_email;
						$paypal->save();
					}else{
						$paypalcheck = PaypalCredentials::where('user_id',$user->id)->first();
						$paypal = PaypalCredentials::find($paypalcheck->id);
						$paypal->store_name = $request->store_name;
						$paypal->store_status = $request->store_status;
						$paypal->account_type = $request->account_type;
						$paypal->paypal_email = $request->paypal_email;
						$paypal->save();
					}
				}
			}
            return 0;
        }else{
            return 1;
        }
	
	
   }
    
	function cususer_delete(Request $request){
		
		$id = $request->id;
    	$dat = array('status'=>0);
    	$data = DB::table('users')->where('id',$id)->update($dat);
    	if($data){
    		return 0;
    	}else{
    		return 1;
    	}
	}
	
	function manage_users_role(){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
		$users = User::all();
        return view('admin/users/users-role', ['users' => $users]);
	}
	
	public function postAdminAssignRoles(Request $request)
    {
        $user = User::where('email', $request['email'])->first();
        $user->roles()->detach();
        if ($request['role_admin']) {
            $user->roles()->attach(Role::where('role_name', 'Admin')->first());
        }
        if ($request['role_knitter']) {
            $user->roles()->attach(Role::where('role_name', 'Knitter')->first());
        }
        if ($request['role_wholesaler']) {
            $user->roles()->attach(Role::where('role_name', 'Wholesaler')->first());
        }
        if ($request['role_designer']) {
            $user->roles()->attach(Role::where('role_name', 'Designer')->first());
        }
        if ($request['role_advertaiser']) {
            $user->roles()->attach(Role::where('role_name', 'Advertaiser')->first());
        }
        if ($request['role_retailer']) {
            $user->roles()->attach(Role::where('role_name', 'Retailer')->first());
        }
        return redirect()->back();
    }


    function users_measurements(Request $request){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
    	$id = base64_decode($request->id);
    	$user = DB::table('users')->where('id',$id)->first();
    	$measurements = DB::table('user_measurements')->where('user_id',$id)->get();
    	return view('admin.users.measurements',compact('user','measurements'));
    }

    function users_projects(Request $request){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
    	$id = base64_decode($request->id);
    	$user = DB::table('users')->where('id',$id)->first();
    	$projects = DB::table('projects')->where('user_id',$id)->get();
    	return view('admin.users.projects',compact('user','projects'));
    }
	
	function check_paypal_email(Request $request){
        $email = $request->get('paypal_email');
        $user = PaypalCredentials::where('paypal_email',$email)->count();
        if($user > 0){
            return response()->json(['valid' => false]);
        }else{
            return response()->json(['valid' => true]);
        }
    }
}
