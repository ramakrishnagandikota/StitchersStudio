<?php

namespace App\Http\Controllers\AdminNew;

use App\Http\Controllers\Controller;
use App\Models\Timeline;
use App\Models\TimelineShowPosts;
use Illuminate\Http\Request;
use DB;
use Auth;
use App\Models\Role;
use App\User;
use Laravolt\Avatar\Facade as Avatar;
use Mail;
use Carbon\Carbon;
use Session;

class Customerusercontroller extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    function cususers_view(Request $request){

        if($request->status == 'active'){
            $query = DB::table('users')->where('status',1)->get();
            $status = 'Active';
        }else if($request->status == 'inactive'){
            $query = DB::table('users')->where('status',0)->get();
            $status = 'In Active';
        }else{
            $query = DB::table('users')->get();
            $status = 'All';
        }



        return view('adminnew/users/allusers',compact('query','status'));
    }

    function cususers_add(){

        $roles = Role::all();
        return view('adminnew/users/adduser',compact('roles'));
    }

    function cususers_insert(Request $request){
        $validator = $request->validate([
            'first_name' => 'required|alpha|min:2|max:15',
            'last_name' => 'required|alpha|min:2|max:15',
            'username' => 'required|alpha_num|min:5|max:25|unique:users',
            'email' => 'required|email|unique:users',
            'role' => 'required'
        ]);
        $userCount = User::count() + 1;

        $user = new User;
        $user->enc_id = md5($userCount);
        $user->name = $request->username;
        $user->first_name = ucfirst($request->first_name);
        $user->last_name = ucfirst($request->last_name);
        $user->username = strtolower($request->username);
        $user->email = strtolower($request->email);
        $user->enc_email = md5($request->email);
        $user->picture = Avatar::create($request->first_name)->toBase64();
        $user->subscription_type = 1;
        $user->sub_exp = Carbon::now();
        $user->created_at = date('Y-m-d H:i:s');
        $user->remember_token = bcrypt($userCount);
        $user->ipaddress = $_SERVER['REMOTE_ADDR'];
        $user->save();

        //$role = Role::where('role_name',$request->role)->first();
        $user->subscription()->attach([1]);

        $arr = array('user_id' => $user->id,'role_id' => $request->role,'created_at' => date('Y-m-d H:i:s'));
        $dd = DB::table('user_role')->insert($arr);

        $arr = array('user_id' => $user->id);
        //$ii = DB::table('user_measurements')->insert($arr);
        $up = DB::table('user_profile')->insert($arr);

        $this->checkTimelinePosts($user->id);

        if($arr){
            $user = array(
                'email'=>$request->email,
                'name'=>ucwords($request->first_name.' '.$request->last_name)
            );

            $data = array(
                'detail'=>'detail',
                'name'  => ucwords($user['name']),
                'email' =>$user['email']
            );

           /*Mail::send('admin.emails.registration', $data, function($message) use ($user)
            {
                $message->from('no-reply@knitfitco.com', 'Registration Notification');
                $message->to($user['email'], $user['name'])->subject('Knit fit couture User Registration Notification.');
            });*/

            Session::flash('success','User added successfully');
        }else{
            Session::flash('fail','Unable to add user.');
        }

        return redirect()->back();

    }

    function setup_password(Request $request){
        $email = str_replace('-', '@', $request->email);
        return view('setup-password',compact('email'));
    }

    function update_setup_myaccount(Request $request){
        $array = array('password' => bcrypt($request->password),'status'=>1);
        $is = DB::table('users')->where('email',$request->user_email)->update($array);
        if($is){
            return redirect('login');
        }else{
            return redirect()->back();
        }
    }

    function cususers_edit(Request $request){

        $id = $request->id;
        $user = User::where('id',$id)->first();
        return view('adminnew/users/edituser',compact('user'));

    }

    function cususers_update(Request $request){

        $user = User::find($request->id);
        $user->name = $request->username;
        $user->first_name = ucfirst($request->first_name);
        $user->last_name = ucfirst($request->last_name);
        $user->username = strtolower($request->username);
        $user->email = strtolower($request->email);
        $user->updated_at = date('Y-m-d H:i:s');
        $insid = $user->save();


        if($insid){
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

        $users = User::all();
        return view('adminnew/users/users-role', ['users' => $users]);
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
        $id = base64_decode($request->id);
        $user = DB::table('users')->where('id',$id)->first();
        $measurements = DB::table('user_measurements')->where('user_id',$id)->get();
        return view('adminnew.users.measurements',compact('user','measurements'));
    }

    function users_projects(Request $request){
        $id = base64_decode($request->id);
        $user = DB::table('users')->where('id',$id)->first();
        $projects = DB::table('projects')->where('user_id',$id)->get();
        return view('adminnew.users.projects',compact('user','projects'));
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
