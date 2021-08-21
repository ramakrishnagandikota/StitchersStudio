<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Feedback;
use App\Models\FeedbackImages;
use Auth;
use Carbon\Carbon;
use Image;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Str;
use Session;
use App\Models\FeedbackReplies;

class FeedbackController extends Controller
{
    function __construct(){
    	$this->middleware('auth');
    }

    function index(Request $request){
    	return view('admin.Feedback.index');
    }

    function show_feedback(Request $request){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
    	//$feedback = Feedback::where('comment','!=',NULL)->latest()->paginate(10);
        $feedback = Feedback::leftJoin('users','users.id','feedback.user_id')
                    ->select('feedback.*','users.first_name','users.last_name','users.email')
                    ->orderBy('id','desc')->paginate(10);
    	
    	if ($request->ajax()) {
            return view('admin.Feedback.feedback-paginate', ['feedback' => $feedback])->render();  
        }
        return view('admin.Feedback.feedback-paginate',compact('feedback'));
    }

    function search_feedback(Request $request){
        //if ($request->isMethod('post')) {
            $exp = explode('-', $request->date);
            $date1 = date('Y-m-d 00:00:00',strtotime($exp[0]));
            $date2 = date('Y-m-d 23:59:59',strtotime($exp[1]));
       // }

        $feedback = Feedback::leftJoin('users','users.id','feedback.user_id')
                    ->select('feedback.*','users.first_name','users.last_name','users.email')
                    ->whereBetween('feedback.created_at', [$date1, $date2])->orderBy('id','desc')->paginate(10);
        if ($request->ajax()) {
            return view('admin.Feedback.feedback-paginate', ['feedback' => $feedback])->render();  
        }
        return view('admin.Feedback.feedback-paginate',compact('feedback'));
    }

    function show_noReply(Request $request){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
    	$noReply = Feedback::where('comment',NULL)->latest()->paginate(10);
    	if ($request->ajax()) {
            return view('admin.Feedback.feedback-noreply', ['noReply' => $noReply])->render();
        }
        return view('admin.Feedback.feedback-noreply',compact('noReply'));
    }

    function show_full_feedback(Request $request){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
    	$id = base64_decode($request->id);
    	$feedback = Feedback::where('id',$id)->first();
    	if($feedback){
    		$fbimages = $feedback->feedbackImages()->get();
    		return view('admin.Feedback.show',compact('feedback','fbimages'));
    	}else{
    		return redirect()->back();
    	}
    }

    function feedback_reply(Request $request){
		$request->validate([
			'comment' => 'required'
		]);
    	$id = base64_decode($request->id);
    	//$feedback = Feedback::where('id',$id)->first();
		
		$fr = new FeedbackReplies;
		$fr->user_id = Auth::user()->id;
		$fr->feedback_id = $id;
    	$fr->feedback_reply = $request->comment;
    	$fr->created_at = Carbon::now();
    	$fr->updated_at = Carbon::now();
		$fr->ipaddress = $request->ip();
    	$save = $fr->save();
    	if($save){
    		Session::flash('success','Comment added successfully.');
    	}else{
    		Session::flash('fail','Unable to add comment,Try again after sometime.');
    	}
    	return redirect()->back();
    }
}
