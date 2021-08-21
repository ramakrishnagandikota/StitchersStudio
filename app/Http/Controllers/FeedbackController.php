<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Feedback;
use App\Models\FeedbackImages;
use Auth;
use Carbon\Carbon;
use Image;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Str;
use App\Mail\UserFeedbackToAdminMail;
use Mail;
use App\Models\Menu;
use App\Models\FeedbackReplies;

class FeedbackController extends Controller
{
    function __construct(){
    	$this->middleware('auth');
    }

    function index(Request $request){
		$menus = Menu::where('status','!=',0)->get();
    	$feedback = Auth::user()->feedbacks()->latest()->paginate(10);
    	return view('Feedback.index',compact('feedback','menus'));
    }

    function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       return preg_replace('/[^A-Za-z0-9\-.]/', '', $string); // Removes special chars.
    }

    function uploadImage(Request $request){
    	$image = $request->file('file');
        for ($i=0; $i < count($image); $i++) {
            $fname = $this->clean($image[$i]->getClientOriginalName());
            $filename = time().'-'.$fname;
            $ext = $image[$i]->getClientOriginalExtension();

         $s3 = \Storage::disk('s3');
        //exit;
        $filepath = 'knitfit/'.$filename;

        if($ext == 'pdf'){
            $pu = $s3->put('/'.$filepath, file_get_contents($image[$i]),'public');
        }else{
        $ext = 'jpg';
        $img = Image::make($image[$i]);
        $height = Image::make($image[$i])->height();
        $width = Image::make($image[$i])->width();
        $img->orientate();
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->encode('jpg');
        $pu = $s3->put('/'.$filepath, $img->__toString(), 'public');
        }

       if($pu){
         return response()->json(['path1' => $filepath, 'path' => 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath,'ext' => $ext]);
     }else{
        echo 'error';
     }
        }
    }


    function removeImage(Request $request){
    	return true;
    }

    function uploadFeedback(Request $request){
    	$request->validate([
    		'title' => 'required',
    		'type' => 'required'
    	]);
    	$feedback = new Feedback;
    	$feedback->user_id = Auth::user()->id;
    	$feedback->title = $request->title;
    	$feedback->notes = $request->notes;
    	$feedback->type = $request->type;
    	$feedback->status = 1;
    	$feedback->created_at = Carbon::now();
    	$feedback->ipaddress = $request->ip();
    	$save = $feedback->save();
    	if($save){
    		$images = $request->image;
            if($images){
        		for ($i=0; $i < count($images); $i++) { 
        			$fimage = new FeedbackImages;
        			$fimage->user_id = Auth::user()->id;
        			$fimage->feedback_id = $feedback->id;
        			$fimage->image = $images[$i];
        			$fimage->status = 1;
        			$fimage->created_at = Carbon::now();
        			$fimage->ipaddress = $request->ip();
        			$fimage->save();
        		}
            }

        $details = [
            'detail'=>'detail',
            'name'  => ucfirst(Auth::user()->first_name).' '.ucfirst(Auth::user()->last_name),
            'email' => Auth::user()->email,
            'title' => $request->title,
            'notes' => $request->notes,
            'type' => $request->type,
            'id' => $feedback->id
         ];

        try{
			\Mail::to('info@knitfitco.com')->send(new UserFeedbackToAdminMail($details));
        }catch(Throwable $e){
            return response()->json(['status' => 'success','message' => 'Feedback submitted, Unable to send email.']);
        }

    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
    }

    function show_feedback(Request $request){
    	$id = base64_decode($request->id);
    	$feedback = Feedback::where('id',$id)->first();
    	if($feedback){
    		$fbimages = $feedback->feedbackImages()->get();
    		return view('Feedback.show',compact('feedback','fbimages'));
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
