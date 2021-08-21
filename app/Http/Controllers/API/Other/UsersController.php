<?php

namespace App\Http\Controllers\API\Other;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;

class UsersController extends Controller
{
    function __construct(){
		$this->middleware('auth');
	}
	
	function get_all_users_list(){
		$jsonArray = array();
		$jsonArray1 = array();
		$user = User::where('status',1)->paginate(20);
		
		for ($i=0; $i < count($user); $i++) { 
		 $firstChar = mb_substr($user[$i]->first_name, 0, 1, "UTF-8");
		 $pic = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.strtoupper($firstChar);
				 
            $jsonArray[$i]['id'] = $user[$i]->id;
            $jsonArray[$i]['first_name'] = $user[$i]->first_name;
            $jsonArray[$i]['last_name'] = $user[$i]->last_name;
            $jsonArray[$i]['username'] = $user[$i]->username;
			$jsonArray[$i]['role'] = $user[$i]->userRole();
            $jsonArray[$i]['email'] = $user[$i]->email;
            $jsonArray[$i]['mobile'] = $user[$i]->mobile;
			$jsonArray[$i]['picture'] = ($user[$i]->picture) ? $user[$i]->picture : $pic;
        }
		
		$jsonArray1['perPage'] = $user->count();
        $jsonArray1['total'] = $user->total();
        $jsonArray1['current_page'] = $user->currentPage();
        $jsonArray1['last_page_url'] = $user->previousPageUrl();
        $jsonArray1['next_page_url'] = $user->nextPageUrl();
        $jsonArray1['last_page'] = $user->lastPage();
        $jsonArray1['options'] = $user->getOptions();
        $jsonArray1['hasMorePages'] = $user->hasMorePages();
		$array = array('users' => $jsonArray,"links" => [$jsonArray1],"login_user_id" => Auth::user()->id);
		return response()->json(['status' => 200,'data' => $array]);
	}
}
