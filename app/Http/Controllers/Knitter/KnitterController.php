<?php

namespace App\Http\Controllers\Knitter;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\UserMeasurements;
use Auth;
use App\Models\Subscription;
use DB;
use Session;
use App\Models\Products;

class KnitterController extends Controller
{
	function __construct(){
		$this->middleware('auth');
	}

    function index(User $user){
		if(!Auth::user()->hasRole('Knitter')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
		/* if(Auth::user()->remainingDays() == 0){
            Auth::user()->subscription()->detach();
            Auth::user()->subscription()->attach(['1']);
        }*/
		if((Auth::user()->remainingDays() == 0) && (Auth::user()->isBasic() == true)){
			Auth::user()->subscription()->detach();
			Auth::user()->subscription()->attach(['1']);
        }
        $measurements = User::find(Auth::user()->id)->measurements()->orderBy('updated_at','DESC')->take(3)->get();
        $projects = User::find(Auth::user()->id)->projects()->where('is_deleted',0)->orderBy('updated_at','DESC')->get();
        $sessions = DB::table('sessions')->where('user_id',Auth::user()->id)->count();
		if(Auth::user()->hasRole('Designer')){
		$patterns = Products::where('designer_name',Auth::user()->id)->where('is_custom',0)->where('in_review',1)
            ->where('status',0)->get();
		}else{
			$patterns = array();
		}
    	return view('knitter.dashboard',compact('measurements','projects','sessions','patterns'));
    }


}
