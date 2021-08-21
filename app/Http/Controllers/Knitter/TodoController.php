<?php

namespace App\Http\Controllers\Knitter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Todo;
use Auth;
use Carbon\Carbon;

class TodoController extends Controller
{
    function __construct(){
		$this->middleware(['auth','roles','subscription']);
	}

	function index(){
		if((Auth::user()->remainingDays() == 0) && (Auth::user()->isBasic() == true)){
			Auth::user()->subscription()->detach();
			Auth::user()->subscription()->attach(['1']);
        }
		
		$todos = Auth::user()->todo()->orderBy('id','DESC')->get();
		return view('knitter.todo.index',compact('todos'));
	}

	function todo_add(Request $request){
		$todo = new Todo;
		$todo->user_id = Auth::user()->id;
		$todo->notes = $request->note;
		$todo->status = 1;
		$todo->created_at = Carbon::now();
		$todo->ipaddress = $_SERVER['REMOTE_ADDR'];
		$save = $todo->save();
		if($save){
    		return response()->json(['status' => 'success','id' => $todo->id]);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
	}

	function todo_completed(Request $request){
		$id = $request->id;
    	$check = Todo::where('id',$id)->first();
    	if($check->status == 1){
    		$notes = Todo::find($id);
    		$notes->status = 2;
    		$notes->completed_at = Carbon::now();
    		$save = $notes->save();
    	}else{
    		$notes = Todo::find($id);
    		$notes->status = 1;
    		$notes->completed_at = NULL;
    		$notes->updated_at = Carbon::now();
    		$save = $notes->save();
    	}

    	if($save){
    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
	}

	function todo_delete(Request $request){
		$id = $request->id;
    	$notes = Todo::find($id);
    	$save = $notes->delete();
    	if($save){
    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
	}

	function todo_delete_all(Request $request){
		$delete = Todo::where('user_id',Auth::user()->id)->delete();
    	if($delete){
    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
	}

}
