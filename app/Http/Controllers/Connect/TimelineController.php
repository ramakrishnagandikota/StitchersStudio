<?php

namespace App\Http\Controllers\Connect;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use App\User;
use DB;
use App\Models\Timeline;
use Carbon\Carbon;
use Auth;
use App\Traits\PostLikableTrait;
use App\Notifications\LikeToPostNotification;
use App\Models\Timelinelikes;
use App\Models\Timelinecomments;
use App\Models\TimelineImages;
use App\Traits\PostCommentableTrait;
use App\Notifications\CommentToPostNotification;
use File;
use Image;
use Session;
use Redirect;
use Validator;
use App\Models\Friends;
use App\Models\Follow;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Events\LikeToPost;
use App\Traits\CommentLikableTrait;
use App\Models\TimelineCommentLikes;
use App\Notifications\LikeToCommentNotification;
use App\Models\TimelineShowPosts;
use FcmClient;

class TimelineController extends Controller
{
	function __construct(){
		$this->middleware(['auth','roles','subscription']);
	}
	
	function sendMobileNotification($title,$body,$user_id){
		$serverKey = 'AAAARPoR2c0:APA91bGuYpM8HuBShyIZERRG0zZKvDlkl6nk3aUVFdq8nJMxbL821_21XLgIhMKnmlYWsGsKEevDH8TNhMq5Ei40owRTmorRzACXQXAO74awX8EFQIElmY6oeBsjEYiz8ZZXJ7EJNy6_';
		$senderId = '296253249997';
		
		$tokens = User::where('id',$user_id)->select('android_device_id','ios_device_id')->first();
		//$array = array('android_device_id' => $tokens->android_device_id,'ios_device_id' => $tokens->ios_device_id);
		
		//$deviceId = Auth::user()->android_device_id;
		
		
		$client = new \Fcm\FcmClient($serverKey, $senderId);
		$myObjArray = array('click-action' => 'FCM_PLUGIN_ACTIVITY','notification_foreground' => true);
		
		$notification = new \Fcm\Push\Notification();
		 

		// Send the notification to the Firebase servers for further handling.

			if($tokens->android_device_id){
				$notification
				->addRecipient($tokens->android_device_id)
				->setTitle($title)
				->setBody($body)
				->setSound("default")
				->addDataArray($myObjArray);
				
				$send = $client->send($notification);
			}
			
			if($tokens->ios_device_id){
				$notification
				->addRecipient($tokens->ios_device_id)
				->setTitle($title)
				->setBody($body)
				->addDataArray($myObjArray);
				
				$send = $client->send($notification);
			}
		
		
		
		return true;
		/*echo '<pre>';
		print_r($send);
		echo '</pre>'; */
	}

	function users(Request $request){
		$json = array();
		$users = User::select('id','first_name','last_name')->get();
		for ($i=0; $i < count($users); $i++) {
			$json[$i]["value"] = $users[$i]->id;
			$json[$i]["text"] = $users[$i]->first_name;
		}
		return response()->json([$json]);
	}

    function index(){

    	$timeline = Timeline::leftJoin('users','users.id','timeline.user_id')
		->leftJoin('timeline_show_posts','timeline_show_posts.timeline_id','timeline.id')
    	->select('timeline.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')
    	->where('timeline.status',1)
    	->orderBy('timeline.id','DESC')->where('timeline_show_posts.show_user_id',Auth::user()->id)->paginate(15);
    	$friends = Friends::where('user_id',Auth::user()->id)->select('user_id','friend_id')->get();
    	$follow = Follow::where('user_id',Auth::user()->id)->select('user_id','follow_user_id')->get();
    	//echo '<pre>';
    	//print_r($follow);
    	//echo '</pre>';
    	//exit;
    	return view('connect.timeline.index',compact('timeline','friends','follow'));
    }

    function show_more(Request $request){
    	$id = $request->id;
    	$timeline = Timeline::leftJoin('users','users.id','timeline.user_id')
		->leftJoin('timeline_show_posts','timeline_show_posts.timeline_id','timeline.id')
    	->select('timeline.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')
    	->where('timeline.status',1)
		->where('timeline_show_posts.show_user_id',Auth::user()->id)
    	->where('timeline.id','<',$id)
    	->take(2)->orderBy('id','DESC')->get();
    	$friends = Friends::where('user_id',Auth::user()->id)->select('user_id','friend_id')->get();
    	$follow = Follow::where('user_id',Auth::user()->id)->select('user_id','follow_user_id')->get();
    	return view('connect.timeline.index-dummy',compact('timeline','friends','follow'));
    }

    function timeline_addDetails(Request $request){
        if($request->tag_friends){
            $tag = implode(',', $request->tag_friends);
        }else{
            $tag = '';
        }


    	$timeline = new Timeline;
    	$timeline->user_id = Auth::user()->id;
    	$timeline->post_content = $request->post_content;
    	$timeline->tag_friends = $tag;
    	$timeline->location = $request->location;
    	$timeline->privacy = $request->post_privacy;
    	$timeline->created_at = Carbon::now();
    	$timeline->ipaddress = $_SERVER['REMOTE_ADDR'];
    	$save = $timeline->save();
    	if($save){
			if($request->post_privacy == 'public'){
                $this->addPublicData($timeline->id);
            }elseif($request->post_privacy == 'friends'){
                $this->addFriendsData($timeline->id);
            }elseif($request->post_privacy == 'followers'){
                $this->addFollowersData($timeline->id);
            }else{
                $this->getOnlyMeData($timeline->id);
            }
    		if($request->image){
    			for ($i=0; $i < count($request->image); $i++) {
    				$images = new TimelineImages;
    				$images->user_id = Auth::user()->id;
    				$images->timeline_id = $timeline->id;
    				$images->image_path = $request->image[$i];
    				$images->created_at = Carbon::now();
    				$images->ipaddress = $_SERVER['REMOTE_ADDR'];
    				$images->save();
    			}
    		}

    		//$id = $request->id;
    	$timeline = Timeline::leftJoin('users','users.id','timeline.user_id')
    	->select('timeline.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')
    	->where('timeline.status',1)
    	->where('timeline.id','=',$timeline->id)->orderBy('id','DESC')
    	->get();
    	$friends = Friends::where('user_id',Auth::user()->id)->select('user_id','friend_id')->get();
    	$follow = Follow::where('user_id',Auth::user()->id)->select('user_id','follow_user_id')->get();
    	return view('connect.timeline.index-dummy',compact('timeline','friends','follow'));
    	}else{
    		return response()->json(['error' => 'Unable to add post,Try again after sometime.']);
    	}
    }
	
	function addPublicData($timeline_id){
        $users = User::all();
        for ($i=0; $i < count($users); $i++) { 
            $array = array('user_id' => Auth::user()->id,'timeline_id' => $timeline_id,'show_user_id' => $users[$i]->id);
            TimelineShowPosts::insert($array);
        }
    }

    function addFriendsData($timeline_id){
        $this->getOnlyMeData($timeline_id);
        $friends = Friends::where('user_id',Auth::user()->id)->get();
		if($friends->count() > 0){
			for ($i=0; $i < count($friends); $i++) { 
				$array = array('user_id' => Auth::user()->id,'timeline_id' => $timeline_id,'show_user_id' => $friends[$i]->friend_id);
				TimelineShowPosts::insert($array);
			}
		}
    }

    function addFollowersData($timeline_id){
        $this->getOnlyMeData($timeline_id);
        $follow = Follow::where('follow_user_id',Auth::user()->id)->get();
		if($follow->count() > 0){
			for ($i=0; $i < count($follow); $i++) { 
				$array = array('user_id' => Auth::user()->id,'timeline_id' => $timeline_id,'show_user_id' => $follow[$i]->user_id);
				
				TimelineShowPosts::insert($array);
			}
		}
    }

    function getOnlyMeData($timeline_id){
        $array = array('user_id' => Auth::user()->id,'timeline_id' => $timeline_id,'show_user_id' => Auth::user()->id);
            TimelineShowPosts::insert($array);
    }

    function timeline_updateDetails(Request $request){
		
		$del = TimelineShowPosts::where('timeline_id',$request->id)->delete();
		
        if($request->tag_friends){
            $tag = implode(',', $request->tag_friends);
        }else{
            $tag = '';
        }

    	$timeline = Timeline::find($request->id);
    	$timeline->post_content = $request->post_content;
    	$timeline->tag_friends = $tag;
    	$timeline->location = $request->location;
    	$timeline->privacy = $request->post_privacy;
    	$timeline->updated_at = Carbon::now();
    	$timeline->ipaddress = $_SERVER['REMOTE_ADDR'];
    	$save = $timeline->save();
    	if($save){
			if($request->post_privacy == 'public'){
                $this->addPublicData($request->id);
            }elseif($request->post_privacy == 'friends'){
                $this->addFriendsData($request->id);
            }elseif($request->post_privacy == 'followers'){
                $this->addFollowersData($request->id);
            }else{
                $this->getOnlyMeData($request->id);
            }
    		if($request->image){
    			for ($i=0; $i < count($request->image); $i++) {
    				$images = new TimelineImages;
    				$images->user_id = Auth::user()->id;
    				$images->timeline_id = $timeline->id;
    				$images->image_path = $request->image[$i];
    				$images->created_at = Carbon::now();
    				$images->ipaddress = $_SERVER['REMOTE_ADDR'];
    				$images->save();
    			}
    		}

    		//$id = $request->id;
    	$timeline = Timeline::leftJoin('users','users.id','timeline.user_id')
    	->select('timeline.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')
    	->where('timeline.status',1)
    	->where('timeline.id','=',$timeline->id)->orderBy('id','DESC')
    	->get();
    	$friends = Friends::where('user_id',Auth::user()->id)->select('user_id','friend_id')->get();
    	$follow = Follow::where('user_id',Auth::user()->id)->select('user_id','follow_user_id')->get();
    	return view('connect.timeline.index-dummy',compact('timeline','friends','follow'));
    	}else{
    		return response()->json(['error' => 'Unable to add post,Try again after sometime.']);
    	}
    }

    function timeline_addLike(Request $request, Timeline $timeline){
    	 $likeCount = Timelinelikes::where('user_id',Auth::user()->id)->where('timeline_id',$request->timeline_id)->count();
    	 if($likeCount > 0){
    	 	return response()->json(['error' => 'You have already liked this post.']);
    	 	exit;
    	 }
    	 $timeline  = Timeline::where('id',$request->timeline_id)->first();
         $like = $timeline->addLike($request);
         if(Auth::user()->id != $timeline->user_id){
			 /* Mobile push notifications */
			$content = ucfirst(Auth::user()->first_name).' '.Auth::user()->last_name.' likes your post.';
			$this->sendMobileNotification('You have a like notification for post',$content,$timeline->user_id);
			/* Mobile push notifications */
         $timeline->user->notify(new LikeToPostNotification($timeline));
         }

         $userDetails = DB::table('users')->leftJoin('timeline_likes','users.id','timeline_likes.user_id')->select('users.id as uid','users.first_name','users.picture','timeline_likes.timeline_id','timeline_likes.user_id')->where('timeline_likes.id',$like->id)->first();

		 //event(new LikeToPost($timeline->user_id,$userDetails));
        if($like){
            return response()->json(['success' => 'Post liked successfully.']);
        }else{
            return response()->json(['error' => 'Unable to like post.']);
        }
    }

    function timeline_unLikePost(Request $request){
    	$user_id = Auth::user()->id;
    	$timeline_id = $request->timeline_id;
    	$unlike = Timelinelikes::where('user_id',$user_id)->where('timeline_id',$timeline_id)->delete();
    	if($unlike){
            return response()->json(['success' => 'Post unliked successfully.']);
        }else{
            return response()->json(['error' => 'Unable to unlike post,Try again after sometime.']);
        }
    }

    function timeline_deletePost(Request $request){
    	$timeline = Timeline::where('id',$request->timeline_id)->where('user_id',Auth::user()->id)->delete();
    	if($timeline){
    		$timelineComments = Timelinecomments::where('user_id',Auth::user()->id)->where('timeline_id',$request->timeline_id)->delete();
			$del = TimelineShowPosts::where('timeline_id',$request->timeline_id)->delete();
    		$timelinelikes= Timelinelikes::where('user_id',Auth::user()->id)->where('timeline_id',$request->timeline_id)->delete();
    		$timelineimages = TimelineImages::where('user_id',Auth::user()->id)->where('timeline_id',$request->timeline_id)->get();
            for ($i=0; $i < count($timelineimages); $i++) { 
                \Storage::disk('s3')->delete($timelineimages[$i]->image_path);
                TimelineImages::where('id',$timelineimages[$i]->id)->delete();
            }
            return response()->json(['success' => 'Post deleted successfully.']);
        }else{
            return response()->json(['error' => 'Unable to delete post,Try again after sometime.']);
        }
    }

    function timeline_addComment(Request $request,Timeline $timeline){
    	 $timeline  = Timeline::where('id',$request->timeline_id)->first();
         $comment = $timeline->addComment($request);
         if(Auth::user()->id != $timeline->user_id){
			 /* Mobile push notifications */
			$content = ucfirst(Auth::user()->first_name).' '.Auth::user()->last_name.' commented on your post.';
			$this->sendMobileNotification('You have a new comment notification.',$content,$timeline->user_id);
			/* Mobile push notifications */
         $timeline->user->notify(new CommentToPostNotification($timeline));
         }
        if($comment){
        	$com = Timelinecomments::leftJoin('users','users.id','timeline_comments.user_id')
    	->select('timeline_comments.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')
    	->where('timeline_comments.status',1)
    	->where('timeline_comments.id',$comment->id)
    	->where('user_id',Auth::user()->id)
    	->first();
        $i = 0;
    	return view('connect.timeline.comments',compact('com','i'));
            //return response()->json(['success' => 'Comment posted successfully.']);
        }else{
            return response()->json(['error' => 'Unable to post comment.']);
        }
    }

    function timeline_UpdateComment(Request $request){
    	$comment_id = $request->cid;
    	$comment = $request->comment;

    	$array = array('comment' => $comment,'updated_at' => Carbon::now());
    	$save = Timelinecomments::where('id',$comment_id)->update($array);
    	if($save){
    		$com = Timelinecomments::leftJoin('users','users.id','timeline_comments.user_id')
    	->select('timeline_comments.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')
    	->where('timeline_comments.id',$comment_id)
    	->first();
        $i = 0;
    	return view('connect.timeline.comments',compact('com','i'));
            //return response()->json(['success' => 'Comment updated successfully.']);
        }else{
            return response()->json(['error' => 'Unable to update comment,Try again after sometime.']);
        }
    }

    function timeline_deleteComment(Request $request){
        $id = $request->comment_id;
        $check = Timelinecomments::where('id',$id)->where('user_id',Auth::user()->id)->count();
        if($check > 0){
           $delete = Timelinecomments::where('id',$id)->where('user_id',Auth::user()->id)->delete();
           if($delete){
               return response()->json(['success' => 'Comment deleted successfully.']);
           }else{
            return response()->json(['error' => 'Unable to delete comment.Try again after sometime.']);
           }
        }else{
            return response()->json(['error' => 'You dont have access to delete this comment']);
        }
    }

    function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    function imageUpload(Request $request){
    	$image = $request->file('files');
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
        $ext = $ext;
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

    function timeline_savePrivacy(Request $request){
		$del = TimelineShowPosts::where('timeline_id',$request->id)->delete();
		
    	$tid = $request->tid;
    	$check = Timeline::where('user_id',Auth::user()->id)->where('id',$tid)->count();
    	if($check == 0){
    		return response()->json(['error' => 'You are unauthorized to make these changes.']);
    		exit;
    	}
    	$timeline = Timeline::find($tid);
    	$timeline->privacy = $request->privacy;
    	$save = $timeline->save();
    	if($save){
			TimelineShowPosts::where('user_id',Auth::user()->id)->where('timeline_id',$timeline->id)->delete();
			if($request->privacy == 'public'){
                $this->addPublicData($tid);
            }elseif($request->privacy == 'friends'){
                $this->addFriendsData($tid);
            }elseif($request->privacy == 'followers'){
                $this->addFollowersData($tid);
            }else{
                $this->getOnlyMeData($tid);
            }
    		return response()->json(['success' => 'Post privacy changed successfully.']);
    	}else{
    		return response()->json(['error' => 'Unable to update privacy,Try again after sometime.']);
    	}
    }

    function showAddPost(){
        $friends = Friends::leftJoin('users','users.id','friends.friend_id')
                   ->where('friends.user_id',Auth::user()->id)
                   ->select('users.id','users.first_name','users.last_name','users.picture','users.username','users.email')->get();
    	return view('connect.timeline.add-post',compact('friends'));
    }

    function editAddPost(Request $request){
        $friends = Friends::leftJoin('users','users.id','friends.friend_id')
                   ->where('friends.user_id',Auth::user()->id)
                   ->select('users.id','users.first_name','users.last_name','users.picture','users.username','users.email')->get();
    	$timeline = Timeline::where('id',$request->id)->first();
    	$timeline_images = TimelineImages::where('timeline_id',$request->id)->get();
    	return view('connect.timeline.edit-post',compact('timeline','timeline_images','friends'));
    }


    function timeline_allCommentsPost(Request $request){
        $id = $request->id;
        $time = Timeline::where('id',$id)->first();
        $comments = Timelinecomments::leftJoin('users','users.id','timeline_comments.user_id')
        ->select('users.id as uid','users.first_name','users.last_name','users.picture','timeline_comments.*','users.username','users.email')
        ->where('timeline_comments.timeline_id',$id)->orderBy('id','DESC')->get();

       return view('connect.timeline.allcomments-popup',compact('time','comments'));
    }

    function allCommentsPhotos(Request $request){
        $id = $request->id;
        $tline_id = TimelineImages::where('id',$id)->select('timeline_id')->first();

        $timeline = Timeline::find($tline_id->timeline_id);
        $comments = Timelinecomments::leftJoin('users','users.id','timeline_comments.user_id')
        ->select('users.id as uid','users.first_name','users.last_name','users.picture','timeline_comments.*','users.username','users.email')
        ->where('timeline_comments.timeline_id',$timeline->id)->orderBy('id','DESC')->get();
        return view('connect.timeline.allcomments-popup',compact('timeline','comments'));
    }

    function post_notification(Request $request){
        $id = $request->id;
        try {
            $decrypted = decrypt($id);
        $timeline = Timeline::leftJoin('users','users.id','timeline.user_id')
        ->select('timeline.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')
        ->where('timeline.status',1)
        ->where('timeline.id',$decrypted)
        ->take(1)->orderBy('id','DESC')->get();
        $friends = Friends::where('user_id',Auth::user()->id)->select('user_id','friend_id')->get();
        $follow = Follow::where('user_id',Auth::user()->id)->select('user_id','follow_user_id')->get();
        } catch (DecryptException $e) {
            return view('notfound');
        }

        return view('connect.timeline.notification',compact('timeline','friends','follow'));
    }

    function deleteImage(Request $request){
        $id = $request->id;
        $image = TimelineImages::find($id);
        $del = $image->delete();
        if($del){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function timeline_addCommentLike(Request $request){
        //$timeline_id = $request->timeline_id;
        $comment_id = $request->comment_id;
        $comment = Timelinecomments::where('id',$comment_id)->first();
        $liked = $comment->addCommentLike($request);
        if(Auth::user()->id != $comment->user_id){
        $comment->user->notify(new LikeToCommentNotification($comment));
        }
        if($liked){
            return response()->json(['success' => 'Comment liked successfully.']);
        }else{
            return response()->json(['error' => 'Unable to like the comment.']);
        }
    }

    function timeline_unLikeComment(Request $request){
        $comment_id = $request->comment_id;
        $comment = TimelineCommentLikes::where('comment_id',$comment_id)->where('user_id',Auth::user()->id)->count();
        if($comment > 0){
            $comment = TimelineCommentLikes::where('comment_id',$comment_id)->where('user_id',Auth::user()->id)->delete();
            if($comment){
                return response()->json(['success' => 'Like removed successfully.']);
            }else{
                return response()->json(['error' => 'Unable to remove like.']);
            }
        }else{
            return response()->json(['error' => 'You dont have access to remove this like.']);
        }
    }


    
}
