<?php

namespace App\Http\Controllers\Designer\Temp;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Auth;
use App\User;
use DB;
use Illuminate\Support\Facades\Crypt;
use Hash;
use Session;

class TDesignerController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    function index(){
		if(!Auth::user()->hasRole('Designer')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
		if(Session::has('previous_url')){
			Session::forget('previous_url');
		}
        $patterns = Products::where('designer_name',Auth::user()->id)->where('is_custom',0)->where('in_review',1)
            ->where('status',0)->get();
        return view('designer.temp.dashboard',compact('patterns'));
    }

    function my_patterns(){
		if(!Auth::user()->hasRole('Designer')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
        $patterns = Products::where('designer_name',Auth::user()->id)->where('is_custom',0)->get();
        return view('designer.temp.my-patterns',compact('patterns'));
    }

    function pattern_details(Request $request){
		if(!Auth::user()->hasRole('Designer')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
        $id = $request->id;
        $pattern = Products::where('designer_name',Auth::user()->id)->where('pid',$id)->first();
		if(!$pattern){
			$pdf = array();
		}else{
			$pdf = DB::table('product_pdf')->where('product_id',$pattern->id)->first();
		}
        return view('designer.temp.pattern-details',compact('pattern','pdf'));;
    }
	
	function change_password(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|string|min:6|max:16|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/',
            'confirm_new_password' => 'same:new_password',
        ]);
        $oldPassword = $request->old_password;
        $newPassword = $request->new_password;

        if(Auth::user()->temp_password != ''){
            if(Auth::user()->temp_password == $oldPassword){
                $user = User::find(Auth::user()->id);
                $user->password = bcrypt($newPassword);
                $user->temp_password = '';
                $save = $user->save();
            }
        }else{
            if (Hash::check($oldPassword, Auth::user()->password)) {
                $user = User::find(Auth::user()->id);
                $user->password = bcrypt($newPassword);
                $save = $user->save();
            }
        }

        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }
	
	function update_product_designer_review_status(Request $request){
		$id = $request->id;
		$pattern = Products::where('designer_name',Auth::user()->id)->where('id',$id)->first();
		if(!$pattern){
			return response()->json(['status' => 'fail','message' => 'Something went wrong.Please refresh page & try again.']);
			exit;
		}
		if($pattern->in_review_designer == 0){
			return response()->json(['status' => 'success']);
			exit;
		}
		$product = Products::find($id);
		$product->in_review_designer = 0;
		$save = $product->save();
		if($save){
			return response()->json(['status' => 'success']);
		}else{
			return response()->json(['status' => 'fail','message' => 'Something went wrong.Please refresh page & try again.']);
		}
	}
}
