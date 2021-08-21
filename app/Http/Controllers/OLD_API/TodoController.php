<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TodoRequest;
use App\Http\Resources\TodoResource;
use App\User;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\Todo;
use Symfony\Component\HttpFoundation\Response;

class TodoController extends Controller
{
	function __construct(){
        $this->middleware(['auth:api','roles','subscription']);
    }

    public function index(){
    	return TodoResource::collection(Auth::user()->todo()->latest()->get());
    }

    public function store(TodoRequest $request){
    	$array = array("notes" => $request->notes,"status" => 1, "created_at" => Carbon::now(),"ipaddress" => $_SERVER['REMOTE_ADDR']);
    	$todo = Auth::user()->todo()->create($array);
    	return response()->json(['created' => true,'id' => $todo->id],Response::HTTP_CREATED);
    }

    public function show(Todo $todo){
    	return new TodoResource($todo);
    }

    public function update(Request $request, Todo $todo){
    	if($request->notes){
    	return response()->json(['updated' => false,'message' => 'Required only status field.']);
    	exit;
    	}
    	if($request->status == 2){
    		$array = array("status" => $request->status,"updated_at" => Carbon::now(), "completed_at" => Carbon::now());
    	}else{
    		$array = array("status" => $request->status,"updated_at" => Carbon::now(), "completed_at" => '');
    	}
    	
    	$todo->update($array);
        return response()->json(['updated' => true], Response::HTTP_ACCEPTED);
    }

    public function destroy(Todo $todo){
    	$todo->delete();
        return response()->json(['deleted' => true]);
    }

    public function destroy_all(Todo $todo){
    	Auth::user()->todo()->delete();
    	return response()->json(['deleted' => true]);
    }
}
