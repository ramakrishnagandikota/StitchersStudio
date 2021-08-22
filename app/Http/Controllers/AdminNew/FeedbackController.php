<?php

namespace App\Http\Controllers\AdminNew;

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

class FeedbackController extends Controller
{
    function __construct(){
    	$this->middleware('auth');
    }

    function index(Request $request){
    	return view('adminnew.Feedback.index');
    }

    function show_feedback(Request $request){
    	//$feedback = Feedback::where('comment','!=',NULL)->latest()->paginate(10);
        $feedback = Feedback::leftJoin('users','users.id','feedback.user_id')
                    ->select('feedback.*','users.first_name','users.last_name','users.email')
                    ->orderBy('id','desc')->paginate(10);
    	
    	if ($request->ajax()) {
            return view('adminnew.Feedback.feedback-paginate', ['feedback' => $feedback])->render();  
        }
        return view('adminnew.Feedback.feedback-paginate',compact('feedback'));
    }

    function search_feedback(Request $request){
        //if ($request->isMethod('post')) {
            $exp = explode('-', $request->date);
            $date1 = date('Y-m-d',strtotime($exp[0]));
            $date2 = date('Y-m-d',strtotime($exp[1]));
       // }

        $feedback = Feedback::leftJoin('users','users.id','feedback.user_id')
                    ->select('feedback.*','users.first_name','users.last_name','users.email')
                    ->whereBetween('feedback.created_at', [$date1, $date2])->orderBy('id','desc')->paginate(10);
        if ($request->ajax()) {
            return view('adminnew.Feedback.feedback-paginate', ['feedback' => $feedback])->render();  
        }
        return view('adminnew.Feedback.feedback-paginate',compact('feedback'));
    }

    function show_noReply(Request $request){
    	$noReply = Feedback::where('comment',NULL)->latest()->paginate(10);
    	if ($request->ajax()) {
            return view('adminnew.Feedback.feedback-noreply', ['noReply' => $noReply])->render();
        }
        return view('adminnew.Feedback.feedback-noreply',compact('noReply'));
    }

    function show_full_feedback(Request $request){
    	$id = base64_decode($request->id);
    	$feedback = Feedback::where('id',$id)->first();
    	if($feedback){
    		$fbimages = $feedback->feedbackImages()->get();
    		return view('adminnew.Feedback.show',compact('feedback','fbimages'));
    	}else{
    		return redirect()->back();
    	}
    }

    function feedback_reply(Request $request){
    	$id = base64_decode($request->id);
    	$feedback = Feedback::find($id);
    	$feedback->comment = $request->comment;
    	$feedback->updated_at = Carbon::now();
    	$save = $feedback->save();
    	if($save){
    		Session::flash('success','Comment added successfully.');
    	}else{
    		Session::flash('fail','Unable to add comment,Try again after sometime.');
    	}
    	return redirect()->back();
    }
}
