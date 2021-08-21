<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use App\User;
use DB;
use App\Models\Timeline;
use Carbon\Carbon;
use Auth;
use App\Models\Timelinelikes;
use App\Models\Timelinecomments;
use App\Models\TimelineImages;
use File;
use Image;
use Session;
use Redirect;
use Validator;
use App\Models\Friends;
use App\Models\Follow;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Traits\PostLikableTrait;
use App\Notifications\LikeToPostNotification;
use App\Events\LikeToPost;
use App\Traits\PostCommentableTrait;
use App\Notifications\CommentToPostNotification;
use App\Traits\CommentLikableTrait;
use App\Models\TimelineCommentLikes;
use App\Notifications\LikeToCommentNotification;
use App\Models\Friendrequest;
use App\Traits\FriendRequestableTrait;
use App\Notifications\FriendRequestNotification;
use App\Traits\FriendRequestAcceptableTrait;
use App\Notifications\FriendRequestAcceptNotification;
use App\Traits\FollowTrait;
use App\Notifications\FollowNotification;
use Illuminate\Support\Facades\Crypt;
use App\Models\Projectimages;
use App\Models\UserSkills;
use App\Models\MasterList;
use App\Models\Userprofile;
use App\Models\UserSettings;

class ConnectController extends Controller
{
    function __construct(){
		$this->middleware(['auth','roles','subscription']);
    }

    function index(){
        $jsonArray = array();
		$jsonArray1 = array();
        $timeline = Timeline::orderBy('id','desc')->paginate(10);

        $friends = Friends::where('user_id',Auth::user()->id)->select('user_id','friend_id')->get();
        $follow = Follow::where('user_id',Auth::user()->id)->select('user_id','follow_user_id')->get();

        for ($i=0; $i < count($timeline); $i++) {

             $jsonArray[$i]['id'] = $timeline[$i]->id;
            $posted_user = User::where('id',$timeline[$i]->user_id)->first();
            $jsonArray[$i]['user_id'] = $timeline[$i]->user_id;
			$jsonArray[$i]['first_name'] = $posted_user->first_name;
			$jsonArray[$i]['last_name'] = $posted_user->last_name;
			$jsonArray[$i]['picture'] = $posted_user->picture;
            $jsonArray[$i]['post_content'] = $timeline[$i]->post_content;
            if($timeline[$i]->tag_friends){
                $exp = explode(",", $timeline[$i]->tag_friends);
            for ($e=0; $e < count($exp); $e++) {
                $user = User::where('id',$exp[$e])->select('id','first_name','last_name','picture')->first();
                    if($user){
                        $jsonArray[$i]['tag_friends'][$e]['id'] = $user->id;
                        $jsonArray[$i]['tag_friends'][$e]['first_name'] = $user->first_name;
                        $jsonArray[$i]['tag_friends'][$e]['last_name'] = $user->last_name;
                    }else{
                        $jsonArray[$i]['tag_friends'][$e]['id'] = '';
                        $jsonArray[$i]['tag_friends'][$e]['first_name'] = '';
                        $jsonArray[$i]['tag_friends'][$e]['last_name'] = '';
                    }
                }
            }else{
                $jsonArray[$i]['tag_friends'] = array();
            }

            $jsonArray[$i]['location'] = $timeline[$i]->location;
            $jsonArray[$i]['privacy'] = $timeline[$i]->privacy;
            $jsonArray[$i]['images'] = TimelineImages::where('timeline_id',$timeline[$i]->id)->select('id','image_path')->get();
            $jsonArray[$i]['likes_count'] = Timelinelikes::where('timeline_id',$timeline[$i]->id)->count();
            $iamliked = Timelinelikes::where('timeline_id',$timeline[$i]->id)->where('user_id',Auth::user()->id)->count();
            $jsonArray[$i]['liked_by_me'] = ($iamliked == 1) ? true : false;
            $jsonArray[$i]['comments_count'] = Timelinecomments::where('timeline_id',$timeline[$i]->id)->count();
            $comments = Timelinecomments::where('timeline_id',$timeline[$i]->id)->get();
            if(count($comments) > 0){
            for ($j=0; $j < count($comments); $j++) {
                $users = User::where('id',$comments[$j]->user_id)->select('first_name','last_name','picture')->first();
                $jsonArray[$i]['comments'][$j]['id'] = $comments[$j]->id;
                $jsonArray[$i]['comments'][$j]['user_id'] = $comments[$j]->user_id;
                $jsonArray[$i]['comments'][$j]['first_name'] = $users->first_name;
                    $jsonArray[$i]['comments'][$j]['last_name'] = $users->last_name;
                    $jsonArray[$i]['comments'][$j]['picture'] = $users->picture;
                $jsonArray[$i]['comments'][$j]['comment'] = $comments[$j]->comment;
                $jsonArray[$i]['comments'][$j]['created_at'] = $comments[$j]->created_at->diffForHumans();
                $jsonArray[$i]['comments'][$j]['Clikes_count'] = TimelineCommentLikes::where('timeline_id',$timeline[$i]->id)->where('comment_id',$comments[$j]->id)->count();
                $Commiamliked = TimelineCommentLikes::where('timeline_id',$timeline[$i]->id)->where('comment_id',$comments[$j]->id)->where('user_id',Auth::user()->id)->count();
                $jsonArray[$i]['comments'][$j]['Cliked_by_me'] = ($Commiamliked == 1) ? true : false;
            }
            }else{
                $jsonArray[$i]['comments'] = [];
            }
            $jsonArray[$i]['created_at'] = $timeline[$i]->created_at->diffForHumans();
            $jsonArray[$i]['updated_at'] = $timeline[$i]->updated_at->diffForHumans();
            $jsonArray[$i]['show_post'] = true;
			

        }
		
		return $jsonArray;
    }
	
	function get_all_posts(){
        $jsonArray = array();
        $jsonArray1 = array();
        $timeline = Timeline::orderBy('id','desc')->paginate(10);

        $friends = Friends::where('user_id',Auth::user()->id)->select('user_id','friend_id')->get();
        $follow = Follow::where('user_id',Auth::user()->id)->select('user_id','follow_user_id')->get();

         for ($i=0; $i < count($timeline); $i++) {

        if($timeline[$i]->privacy == 'only-me'){    // only me
                if(Auth::user()->id == $timeline[$i]->user_id){
                  $jsonArray = $this->index();
                }else{
                    $jsonArray = [];
                }
            }else if($timeline[$i]->privacy == 'friends'){     // friends
                if(Auth::user()->id == $timeline[$i]->user_id){
                    $jsonArray = $this->index();
                }else{
                    foreach($friends as $friend){
                        if($friend->friend_id == $timeline[$i]->user_id){
                            $jsonArray = $this->index();
                        }else{
                            $jsonArray = [];
                        }
                    }
                }
            }else if($timeline[$i]->privacy == 'followers'){   // followers
                if(Auth::user()->id == $timeline[$i]->user_id){
                    $jsonArray = $this->index();
                }else{
                    foreach($follow as $foll){
                        if($foll->follow_user_id == $timeline[$i]->user_id){
                            $jsonArray = $this->index();
                        }else{
                            $jsonArray = [];
                        }
                    }
                }
            }else{
                $jsonArray = $this->index();
            }

        }
             $jsonArray1['perPage'] = $timeline->count();
        $jsonArray1['total'] = $timeline->total();
        $jsonArray1['current_page'] = $timeline->currentPage();
        $jsonArray1['last_page_url'] = $timeline->previousPageUrl();
        $jsonArray1['next_page_url'] = $timeline->nextPageUrl();
        $jsonArray1['last_page'] = $timeline->lastPage();
        $jsonArray1['options'] = $timeline->getOptions();
        $jsonArray1['hasMorePages'] = $timeline->hasMorePages();


        $array = array('timeline' => $jsonArray,"links" => [$jsonArray1],"login_user_id" => Auth::user()->id);
        return response()->json(['data' => $array]);
    }

    function getTimelinebyId($id){
        $jsonArray = array();
        $timeline = Timeline::where('id',$id)->take(1)->get();
        for ($i=0; $i < count($timeline); $i++) {

                $jsonArray[$i]['id'] = $timeline[$i]->id;
            $posted_user = User::where('id',$timeline[$i]->user_id)->first();
            $jsonArray[$i]['user_id'] = $timeline[$i]->user_id;
			$jsonArray[$i]['first_name'] = $posted_user->first_name;
			$jsonArray[$i]['last_name'] = $posted_user->last_name;
			$jsonArray[$i]['picture'] = $posted_user->picture;
                $jsonArray[$i]['post_content'] = $timeline[$i]->post_content;
                $exp = explode(",", $timeline[$i]->tag_friends);
                for ($e=0; $e < count($exp); $e++) {
                    $user = User::where('id',$exp[$e])->select('id','first_name','last_name','picture')->first();
                        if($user){
                            $jsonArray[$i]['tag_friends'][$e]['id'] = $user->id;
                            $jsonArray[$i]['tag_friends'][$e]['first_name'] = $user->first_name;
                            $jsonArray[$i]['tag_friends'][$e]['last_name'] = $user->last_name;
                        }else{
                            $jsonArray[$i]['tag_friends'][$e]['id'] = '';
                            $jsonArray[$i]['tag_friends'][$e]['first_name'] = '';
                            $jsonArray[$i]['tag_friends'][$e]['last_name'] = '';
                        }
                    }
                $jsonArray[$i]['location'] = $timeline[$i]->location;
                $jsonArray[$i]['privacy'] = $timeline[$i]->privacy;
                $jsonArray[$i]['images'] = TimelineImages::where('timeline_id',$timeline[$i]->id)->select('id','image_path')->get();
                $jsonArray[$i]['likes_count'] = Timelinelikes::where('timeline_id',$timeline[$i]->id)->count();
                $iamliked = Timelinelikes::where('timeline_id',$timeline[$i]->id)->where('user_id',Auth::user()->id)->count();
                $jsonArray[$i]['liked_by_me'] = ($iamliked == 1) ? true : false;
                $jsonArray[$i]['comments_count'] = Timelinecomments::where('timeline_id',$timeline[$i]->id)->count();
                $comments = Timelinecomments::where('timeline_id',$timeline[$i]->id)->get();
                if(count($comments) > 0){
                for ($j=0; $j < count($comments); $j++) {
                    $users = User::where('id',$comments[$j]->user_id)->select('first_name','last_name','picture')->first();
                    $jsonArray[$i]['comments'][$j]['id'] = $comments[$j]->id;
                    $jsonArray[$i]['comments'][$j]['user_id'] = $comments[$j]->user_id;
                    $jsonArray[$i]['comments'][$j]['first_name'] = $users->first_name;
                    $jsonArray[$i]['comments'][$j]['last_name'] = $users->last_name;
                    $jsonArray[$i]['comments'][$j]['picture'] = $users->picture;
                    $jsonArray[$i]['comments'][$j]['comment'] = $comments[$j]->comment;
                    $jsonArray[$i]['comments'][$j]['created_at'] = $comments[$j]->created_at->diffForHumans();
					$jsonArray[$i]['comments'][$j]['Clikes_count'] = TimelineCommentLikes::where('timeline_id',$timeline[$i]->id)->where('comment_id',$comments[$j]->id)->count();
					$Commiamliked = TimelineCommentLikes::where('timeline_id',$timeline[$i]->id)->where('comment_id',$comments[$j]->id)->where('user_id',Auth::user()->id)->count();

					$jsonArray[$i]['comments'][$j]['Cliked_by_me'] = ($Commiamliked == 1) ? true : false;
                }
                }else{
                    $jsonArray[$i]['comments'] = [];
                }
                $jsonArray[$i]['created_at'] = $timeline[$i]->created_at->diffForHumans();
                $jsonArray[$i]['updated_at'] = $timeline[$i]->updated_at->diffForHumans();

            }

            $array = array('timeline' => $jsonArray,"login_user_id" => Auth::user()->id);
        return response()->json(['data' => $array]);
    }

    function timeline_deletePost(Request $request){
        $timelinecheck = Timeline::where('id',$request->timeline_id)->where('user_id',Auth::user()->id)->count();

        if($timelinecheck == 0){
            return response()->json(['error' => 'Unable to delete post,Try again after sometime.']);
            exit;
        }

    	$timeline = Timeline::where('id',$request->timeline_id)->where('user_id',Auth::user()->id)->delete();
    	if($timeline){
    		$timelineComments = Timelinecomments::where('timeline_id',$request->timeline_id)->delete();
    		$timelinelikes= Timelinelikes::where('timeline_id',$request->timeline_id)->delete();
    		$timelineimages = TimelineImages::where('timeline_id',$request->timeline_id)->delete();
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function likeUnlikePost(Request $request){
        $timeline_id = $request->timeline_id;
        $user_id = Auth::user()->id;
    $likeCount = Timelinelikes::where('user_id',$user_id)->where('timeline_id',$timeline_id)->count();
        if($likeCount > 0){
$like = Timelinelikes::where('user_id',$user_id)->where('timeline_id',$timeline_id)->delete();
        }else{
$timeline  = Timeline::where('id',$timeline_id)->first();
$like = $timeline->addLike($request);
if(Auth::user()->id != $timeline->user_id){
$timeline->user->notify(new LikeToPostNotification($timeline));
}

$userDetails = DB::table('users')->leftJoin('timeline_likes','users.id','timeline_likes.user_id')->select('users.id as uid','users.first_name','users.picture','timeline_likes.timeline_id','timeline_likes.user_id')->where('timeline_likes.id',$like->id)->first();
        }
        if($like){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function timeline_addComment(Request $request){
        $request->validate([
            'timeline_id' => 'required',
            'comment' => 'required'
        ]);
        $jsonArray = array();
        $timeline  = Timeline::where('id',$request->timeline_id)->first();
        $comment = $timeline->addComment($request);
		if(Auth::user()->id != $timeline->user_id){
        $timeline->user->notify(new CommentToPostNotification($timeline));
		}
       if($comment){
           $com = Timelinecomments::leftJoin('users','users.id','timeline_comments.user_id')
       ->select('timeline_comments.*','users.first_name','users.last_name','users.picture')
       ->where('timeline_comments.status',1)
       ->where('timeline_comments.id',$comment->id)
       ->where('user_id',Auth::user()->id)
       ->take(1)->get();

        for ($i=0; $i < count($com); $i++) {
            $jsonArray[$i]['id'] = $com[$i]->id;
            $jsonArray[$i]['user_id'] = $com[$i]->user_id;
            $jsonArray[$i]['first_name'] = $com[$i]->first_name;
            $jsonArray[$i]['last_name'] = $com[$i]->last_name;
            $jsonArray[$i]['picture'] = $com[$i]->picture;
            $jsonArray[$i]['comment'] = $com[$i]->comment;
            $jsonArray[$i]['created_at'] = $com[$i]->created_at->diffForHumans();
        }

        $array = array('comments' => $jsonArray);
        return response()->json(['data' => $array]);

       }else{
           return response()->json(['status' => 'fail']);
       }
   }

   function timeline_editComment(Request $request){
       $jsonArray = array();
       $comment_id = $request->id;
       $com = Timelinecomments::leftJoin('users','users.id','timeline_comments.user_id')
       ->select('timeline_comments.*','users.first_name','users.last_name','users.picture')
       ->where('timeline_comments.status',1)
       ->where('timeline_comments.id',$comment_id)
       ->where('user_id',Auth::user()->id)
       ->take(1)->get();

        for ($i=0; $i < count($com); $i++) {
            $jsonArray[$i]['id'] = $com[$i]->id;
            $jsonArray[$i]['user_id'] = $com[$i]->user_id;
            $jsonArray[$i]['first_name'] = $com[$i]->first_name;
            $jsonArray[$i]['last_name'] = $com[$i]->last_name;
            $jsonArray[$i]['picture'] = $com[$i]->picture;
            $jsonArray[$i]['comment'] = $com[$i]->comment;
            $jsonArray[$i]['created_at'] = $com[$i]->created_at->diffForHumans();
        }

        $array = array('comments' => $jsonArray);
        return response()->json(['data' => $array]);
   }

   function timeline_updateComment(Request $request){
       $jsonArray = array();
       $comment_id = $request->comment_id;
       $comm = Timelinecomments::find($comment_id);
       $comm->comment = $request->comment;
       $save = $comm->save();

       if($save){
        $com = Timelinecomments::leftJoin('users','users.id','timeline_comments.user_id')
        ->select('timeline_comments.*','users.first_name','users.last_name','users.picture')
        ->where('timeline_comments.status',1)
        ->where('timeline_comments.id',$comment_id)
        ->where('user_id',Auth::user()->id)
        ->take(1)->get();

         for ($i=0; $i < count($com); $i++) {
             $jsonArray[$i]['id'] = $com[$i]->id;
             $jsonArray[$i]['user_id'] = $com[$i]->user_id;
             $jsonArray[$i]['first_name'] = $com[$i]->first_name;
             $jsonArray[$i]['last_name'] = $com[$i]->last_name;
             $jsonArray[$i]['picture'] = $com[$i]->picture;
             $jsonArray[$i]['comment'] = $com[$i]->comment;
             $jsonArray[$i]['created_at'] = $com[$i]->created_at->diffForHumans();
         }

         $array = array('comments' => $jsonArray);
         return response()->json(['data' => $array]);
       }
   }

   function timeline_deleteComment(Request $request){
       $comment_id = $request->comment_id;
       $checkComment = Timelinecomments::where('user_id',Auth::user()->id)->where('id',$comment_id)->count();

       if($checkComment == 0){
        return response()->json(['status' => 'fail','message' => 'You are unauthorized to delete this comment.']);
        exit;
       }

       $comm = Timelinecomments::find($comment_id);
       $save = $comm->delete();
       if($save){
           return response()->json(['status' => 'success']);
       }else{
           return response()->json(['status' => 'fail']);
       }
   }


   function timeline_addPost(Request $request){
       $request->validate([
           'post_content' => 'required',
		   'privacy' => 'required'
       ]);
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
    $timeline->privacy = $request->privacy;
    $timeline->created_at = Carbon::now();
    $timeline->ipaddress = $_SERVER['REMOTE_ADDR'];
    $save = $timeline->save();

    if($save){
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
           return $this->getTimelinebyId($timeline->id);
    }else{
        return response()->json(['status' => 'fail']);
    }
   }

   function timeline_editPost(Request $request){
       $jsonArray = array();
       $id = $request->id;
       $timeline = Timeline::where('id',$id)->where('user_id',Auth::user()->id)->get();
       if($timeline->count() == 0){
           return response()->json(['status' => 'fail','message' => 'There is no post for the given request.']);
           exit;
       }

       for ($i=0; $i < count($timeline); $i++) {
           $jsonArray[$i]['id'] = $timeline[$i]->id;
           $jsonArray[$i]['post_content'] = $timeline[$i]->post_content;
		   if($timeline[$i]->tag_friends){
           $exp = explode(",", $timeline[$i]->tag_friends);
           for ($e=0; $e < count($exp); $e++) {
            $user = User::where('id',$exp[$e])->select('id','first_name','last_name')->first();
                if($user){
                    $jsonArray[$i]['tag_friends'][$e]['id'] = $user->id;
                    $jsonArray[$i]['tag_friends'][$e]['first_name'] = $user->first_name;
                    $jsonArray[$i]['tag_friends'][$e]['last_name'] = $user->last_name;
                }else{
                    $jsonArray[$i]['tag_friends'][$e]['id'] = '';
                    $jsonArray[$i]['tag_friends'][$e]['first_name'] = '';
                    $jsonArray[$i]['tag_friends'][$e]['last_name'] = '';
                }
            }
		   }else{
			 $jsonArray[$i]['tag_friends'] = array();  
		   }
           $jsonArray[$i]['location'] = $timeline[$i]->location;
           $jsonArray[$i]['privacy'] = $timeline[$i]->privacy;
           $jsonArray[$i]['images'] = TimelineImages::where('timeline_id',$timeline[$i]->id)->select('id','image_path')->get();
       }

        $array = array('timeline' => $jsonArray);
        return response()->json(['data' => $array]);
   }

   function timeline_updatePost(Request $request){
       $request->validate([
            'id' => 'required',
           'post_content' => 'required',
		   'privacy' => 'required'
       ]);
    if($request->tag_friends){
        $tag = implode(',', $request->tag_friends);
    }else{
        $tag = '';
    }


    $timeline = Timeline::find($request->id);
    $timeline->post_content = $request->post_content;
    $timeline->tag_friends = $tag;
    $timeline->location = $request->location;
    $timeline->privacy = $request->privacy;
    $timeline->updated_at = Carbon::now();
    $timeline->ipaddress = $_SERVER['REMOTE_ADDR'];
    $save = $timeline->save();

    if($save){
        if($request->image){

            for ($i=0; $i < count($request->image); $i++) {
                if($request->image_id[$i] == 0){
                $images = new TimelineImages;
                $images->user_id = Auth::user()->id;
                $images->timeline_id = $timeline->id;
                $images->image_path = $request->image[$i];
                $images->created_at = Carbon::now();
                $images->ipaddress = $_SERVER['REMOTE_ADDR'];
                $images->save();
                }
            }
        }
           return $this->getTimelinebyId($timeline->id);
    }else{
        return response()->json(['status' => 'fail']);
    }
   }

   function delete_timeline_image(Request $request){
        $id = $request->image_id;
        $delete = TimelineImages::where('id',$id)->delete();

        if($delete){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
   }

   function likeUnlikeComment(Request $request){
    $comment_id = $request->comment_id; // comment_id , timeline_id
    $comment = Timelinecomments::where('id',$comment_id)->first();
    $liked = $comment->addCommentLike($request);
    if(Auth::user()->id != $comment->user_id){
    $comment->user->notify(new LikeToCommentNotification($comment));
    }
    if($liked){
        return response()->json(['status' => 'success']);
    }else{
        return response()->json(['status' => 'error']);
    }
   }

   function my_connections(){
       $jsonArray = array();
    $friends = Friends::leftJoin('users','users.id','friends.friend_id')
    ->where('friends.user_id',Auth::user()->id)->select('friends.id','users.id as user_id','users.first_name','users.last_name','users.email','users.username','users.picture')->get();

    for ($i=0; $i < count($friends); $i++) {
        $jsonArray[$i]['id'] = $friends[$i]->user_id;
        $jsonArray[$i]['first_name'] = $friends[$i]->first_name;
        $jsonArray[$i]['last_name'] = $friends[$i]->last_name;
        $jsonArray[$i]['picture'] = $friends[$i]->picture;
        $follow = Follow::where('user_id',Auth::user()->id)->where('follow_user_id',$friends[$i]->user_id)->count();
        $jsonArray[$i]['follow'] = ($follow > 0) ? true : false;
		$jsonArray[$i]['user_role'] = User::find($friends[$i]->user_id)->isKnitter() ? 'Knitter' : 'Designer';
    }
        $array = array('friends' => $jsonArray);
        return response()->json(['data' => $array]);
   }

   function search_my_connections(Request $request){
       $search = $request->search;

    $skill = $request->skill;
$jsonArray = array();


$query = '';
$query1 = '';
$query2 = '';
$query3 = '';

$query4 = '';
$query5 = '';
$query6 = '';
$query7 = '';
$query8 = '';
$query9 = "";

$query2.=" left join users ON friends.friend_id = users.id ";
$query3.=" friends.user_id = '".Auth::user()->id."' and ";



if($request->followers){
    $query4.=" left join follow on follow.user_id = users.id ";
    $query5.= "follow.follow_user_id = '".Auth::user()->id."' and";
}

if($request->search){
    $query6.=" and (users.first_name LIKE '%".$search."%' OR users.last_name LIKE '%".$search."%' OR users.username LIKE '%".$search."%')  ";
}

if($skill){
	$query7.= " left join user_skills on user_skills.user_id = users.id ";
}


$query.= "SELECT DISTINCT friends.friend_id as user_id,users.id,users.first_name,users.last_name,users.picture,users.username,users.email from friends ".$query2.$query7.$query4." where ".$query3.$query5." users.id != ".Auth::user()->id." ".$query6;




if($skill){ 
 
    for ($i=0; $i < count($skill); $i++) { 

        $rating = $skill[$i].'_rating';
        $skill_level = $request->$rating;
        
$query2 = '';
        for ($j=0; $j < count($skill_level); $j++) { 

            if($skill_level[$j] > 0 && $skill_level[$j] < 6){
               if($j == 0){
                $query2.= " ( user_skills.rating = '".$skill_level[$j]."' ";
                }else{
                $query2.=" OR user_skills.rating = '".$skill_level[$j]."' ";
                }

                if($j === count($skill_level) - 1){
                    $query2.=" ) ";
                }
            }
        }

        if($i == 0){
            $query1.= " and ( ";
        }else{
            $query1.=" OR ";
        }

        $query1.=" (user_skills.skills = '".$skill[$i]."' ";
        if($query2){
            $query1.=" AND ".$query2." ) ";
        }else{
            $query1.=" ) ";
        }
        


        if($i === count($skill) - 1){
            $query1.=" ) ";
        }
    }



}


$friends = DB::select(DB::raw($query.$query1));

 for ($i=0; $i < count($friends); $i++) {
     $jsonArray[$i]['id'] = $friends[$i]->user_id;
     $jsonArray[$i]['first_name'] = $friends[$i]->first_name;
     $jsonArray[$i]['last_name'] = $friends[$i]->last_name;
     $jsonArray[$i]['picture'] = $friends[$i]->picture;
     $follow = Follow::where('user_id',Auth::user()->id)->where('follow_user_id',$friends[$i]->user_id)->count();
        $jsonArray[$i]['follow'] = ($follow > 0) ? true : false;
     $jsonArray[$i]['user_role'] = User::find($friends[$i]->user_id)->isKnitter() ? 'Knitter' : 'Designer';
 }
     $array = array('friends' => $jsonArray);
     return response()->json(['data' => $array]);
}



    /* function find_connections(Request $request){
        $search = $request->search;
        $request->validate([
            'search' => 'required'
        ]);
        $users = User::where('id','!=',Auth::user()->id)->where('first_name', 'LIKE', "%{$search}%") ->orWhere('last_name', 'LIKE', "%{$search}%")->get();

        for ($i=0; $i < count($users); $i++) {
            $jsonArray[$i]['id'] = $users[$i]->id;
            $jsonArray[$i]['first_name'] = $users[$i]->first_name;
            $jsonArray[$i]['last_name'] = $users[$i]->last_name;
            $jsonArray[$i]['picture'] = $users[$i]->picture;
            $friend = Friends::where('user_id',Auth::user()->id)->where('friend_id',$users[$i]->id)->count();
            $frequest = Friendrequest::where('user_id',Auth::user()->id)->where('friend_id',$users[$i]->id)->count();
            $freq = Friendrequest::where('user_id',$users[$i]->id)->where('friend_id',Auth::user()->id)->count();
            $follow = Follow::where('user_id',Auth::user()->id)->where('follow_user_id',$users['$i']->id)->count();


            $jsonArray[$i]['friend'] = ($friend > 0) ? true : false;
            $jsonArray[$i]['request_sent'] = ($frequest > 0) ? true : false;
            $jsonArray[$i]['request_received'] = ($freq > 0) ? true : false;
            $jsonArray[$i]['follow'] = ($follow > 0) ? true : false;
			$jsonArray[$i]['user_role'] = User::find($users[$i]->id)->isKnitter() ? 'Knitter' : 'Designer';
        }
            $array = array('users' => $jsonArray);
            return response()->json(['data' => $array]);
    }
    filter_my_connections
    */

    function find_connections(Request $request){
        
        $search = $request->search;
        $skill = $request->skill;
        //$skill_level = $request->skill_level;


        $jsonArray = array();

        $request->validate([
            'search' => 'required'
        ]); 

//echo json_encode($request->all());

     $query = '';
$query1 = '';
$query2 = '';
$query3 = '';

$query4 = '';
$query5 = '';


if($request->friends){
    $query2.=" left join friends ON friends.friend_id = users.id ";
    $query3.=" friends.user_id = '".Auth::user()->id."' and ";
}

if($request->followers){
    $query4.=" left join follow on follow.user_id = users.id ";
    $query5.= "follow.follow_user_id = '".Auth::user()->id."' and";
}


if($skill){
    $query.= "SELECT DISTINCT users.id,users.first_name,users.last_name,users.picture,users.username,users.email from user_skills left join users on users.id = user_skills.user_id ".$query2.$query4." WHERE ".$query3.$query5."  users.id != '".Auth::user()->id."' and users.status = 1 and (users.first_name LIKE '%".$search."%' OR users.last_name LIKE '%".$search."%' OR users.username LIKE '%".$search."%')  ";
}else{
    
    $query.= "SELECT DISTINCT users.id,users.first_name,users.last_name,users.picture,users.username,users.email from users ".$query2.$query4." WHERE ".$query3.$query5."  users.id != '".Auth::user()->id."' and users.status = 1 and (users.first_name LIKE '%".$search."%' OR users.last_name LIKE '%".$search."%' OR users.username LIKE '%".$search."%')  ";
}

if($skill){ 
 
    for ($i=0; $i < count($skill); $i++) { 

        $rating = $skill[$i].'_rating';
        $skill_level = $request->$rating;
        
        
        //if($skill_level){
            $query2 = '';
        for ($j=0; $j < count($skill_level); $j++) { 

            if($skill_level[$j] > 0 && $skill_level[$j] < 6){
               if($j == 0){
                $query2.= " ( user_skills.rating = '".$skill_level[$j]."' ";
                }else{
                $query2.=" OR user_skills.rating = '".$skill_level[$j]."' ";
                }

                if($j === count($skill_level) - 1){
                    $query2.=" ) ";
                }
            }
        }

    

        if($i == 0){
            $query1.= " and ( ";
        }else{
            $query1.=" OR ";
        }

        $query1.=" (user_skills.skills = '".$skill[$i]."' ";
        if($query2){
            $query1.=" AND ".$query2." ) ";
        }else{
            $query1.=" ) ";
        }
        


        if($i === count($skill) - 1){
            $query1.=" ) ";
        }
    //}

}

}
    

$users = DB::select(DB::raw($query.$query1));



    for ($j=0; $j < count($users); $j++) { 
        $jsonArray[$j]['id'] = $users[$j]->id;
        $jsonArray[$j]['first_name'] = $users[$j]->first_name;
        $jsonArray[$j]['last_name'] = $users[$j]->last_name;
        $jsonArray[$j]['picture'] = $users[$j]->picture;
         $friend = Friends::where('user_id',Auth::user()->id)->where('friend_id',$users[$j]->id)->count();
            $frequest = Friendrequest::where('user_id',Auth::user()->id)->where('friend_id',$users[$j]->id)->count();
            $freq = Friendrequest::where('user_id',$users[$j]->id)->where('friend_id',Auth::user()->id)->count();
            $follow = Follow::where('user_id',Auth::user()->id)->where('follow_user_id',$users[$j]->id)->count();


            $jsonArray[$j]['friend'] = ($friend > 0) ? true : false;
            $jsonArray[$j]['request_sent'] = ($frequest > 0) ? true : false;
            $jsonArray[$j]['request_received'] = ($freq > 0) ? true : false;
            $jsonArray[$j]['follow'] = ($follow > 0) ? true : false;
            $jsonArray[$j]['user_role'] = User::find($users[$j]->id)->isKnitter() ? 'Knitter' : 'Designer';
    }
        $array = array('users' => $jsonArray);
           return response()->json(['data' => $array]);
    }

    function sendFriendRequest(Request $request){
        $request->validate([
            'friend_id' => 'required|numeric'
        ]);
        $user_id = Auth::user()->id;
    	$friend_id = $request->friend_id;
    	$check = Friendrequest::where('user_id',$user_id)->where('friend_id',$friend_id)->count();
        if($user_id == $friend_id){
          return response()->json(['status' => 'fail','message' => 'You can not send request to your self.']);
            exit;
        }
    	if($check == 1){
    		return response()->json(['status' => 'fail','message' => 'You have already sent request to this user.']);
    		exit;
    	}
    	$user = User::find($friend_id);

    	$friendrequest = User::where('id',$friend_id)->first();

        $send = $friendrequest->sendFriendRequest($friend_id);
    	$user->notify(new FriendRequestNotification($friendrequest));

    	if($send){
    		return response()->json(['status' => 'success']);
    	}else{
    		return response()->json(['status' => 'fail']);
    	}
    }


    function cancelFriendRequest(Request $request){
        $request->validate([
            'friend_id' => 'required|numeric'
        ]);
    	$user_id = Auth::user()->id;
    	$friend_id = $request->friend_id;
    	$check = Friendrequest::where('user_id',$user_id)->where('friend_id',$friend_id)->count();
    	if($check == 1){
    		$del = Friendrequest::where('user_id',$user_id)->where('friend_id',$friend_id)->delete();
    		if($del){
    			return response()->json(['status' => 'success']);
    		}else{
    			return response()->json(['status' => 'fail']);
    		}

    	}else{
    		return response()->json(['status' => 'fail','message' => 'No friend request found for this user.']);
    	}
    }


    function rejectFriendRequest(Request $request){
        $request->validate([
            'friend_id' => 'required|numeric'
        ]);
        $id = $request->friend_id;
        $check = Friendrequest::where('user_id',$id)->where('friend_id',Auth::user()->id)->count();
        if($check == 1){
            $del = Friendrequest::where('user_id',$id)->where('friend_id',Auth::user()->id)->delete();
            if($del){
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'fail']);
            }

        }else{
            return response()->json(['status' => 'fail','message' => 'No friend request found for this user.']);
        }
    }


    function removeFriend(Request $request){
        $request->validate([
            'friend_id' => 'required|numeric'
        ]);
    	$user_id = Auth::user()->id;
    	$friend_id = $request->friend_id;

    	$del1 = Friends::where('user_id',Auth::user()->id)->where('friend_id',$friend_id)->delete();
    	$del2 = Friends::where('user_id',$friend_id)->where('friend_id',Auth::user()->id)->delete();

    	if($del1 && $del2){
    	return response()->json(['status' => 'success']);
    	}else{
    	return response()->json(['status' => 'fail']);
    	}
    }


    function acceptRequest(Request $request,User $friendRequestAccept){
        $request->validate([
            'friend_id' => 'required|numeric'
        ]);


    	$fid = $request->friend_id;
        $uid = Auth::user()->id;

        $friend_req = DB::table('friend_request')->where('user_id',$fid)->where('friend_id',$uid)->delete();

        $friendRequestAccept = User::where('id',$fid)->first();
        $fr = $friendRequestAccept->acceptRequest($request);
        $friendRequestAccept->notify(new FriendRequestAcceptNotification($friendRequestAccept));

         if($fr){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function follow_user(Request $request,User $follow){
        $request->validate([
            'follow_user_id' => 'required|numeric'
        ]);

        $user_id = Auth::user()->id;
        $follow_user_id = $request->follow_user_id;

        $check = Follow::where('user_id',$user_id)->where('follow_user_id',$follow_user_id)->count();
        if($check > 0){
            return response()->json(['status' => 'fail','message' => 'You are already following this person.']);
        }

        $follow = User::where('id',$follow_user_id)->first();
        $send = $follow->sendFollowRequest($request);
        $follow->notify(new FollowNotification($follow));
        if($send){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function unfollow_user(Request $request){
        $request->validate([
            'follow_user_id' => 'required|numeric'
        ]);

        $user_id = Auth::user()->id;
        $follow_user_id = $request->follow_user_id;

        $check = Follow::where('user_id',$user_id)->where('follow_user_id',$follow_user_id)->count();
        if($check > 0){
            $del = Follow::where('user_id',$user_id)->where('follow_user_id',$follow_user_id)->delete();

        if($del){
            return response()->json(['status' => 'success']);
        }else{
        return response()->json(['status' => 'fail']);
        }
        }else{
        return response()->json(['status' => 'fail','message' => 'You are not following this user.']);
        }
    }

    function user_gallery(){
        $jsonArray = array();
        $jsonArray1 = array();

        $timeline_photos = TimelineImages::where('user_id',Auth::user()->id)->get();
        $project_photos = Projectimages::where('user_id',Auth::user()->id)->get();
        for ($i=0; $i < count($timeline_photos); $i++) { 
            $jsonArray[$i]['image_path'] = $timeline_photos[$i]->image_path;
            $jsonArray[$i]['timeline'] = true;
            $jsonArray[$i]['project'] = false;
        }
        for ($j=0; $j < count($project_photos); $j++) { 
            $jsonArray1[$j]['image_path'] = $project_photos[$j]->image_path;
            $jsonArray1[$j]['timeline'] = false;
            $jsonArray1[$j]['project'] = true;
        }

        $check = array_merge($jsonArray, $jsonArray1);
        $array = array('gallery' => $check);
        return response()->json(['data' => $array]);
    }

    function suggested_connections(Request $request){
        $jsonArray = array();
        $friends = DB::select(DB::raw("select DISTINCT (t2.user_id) as suggested_user_id from users t1 join friends t2 on t1.id = t2.user_id WHERE t1.id != ".Auth::user()->id));
        for ($i=0; $i < count($friends); $i++) { 
$users = User::where('id',$friends[$i]->suggested_user_id)->first();
            $jsonArray[$i]['id'] = $users->id;
            $jsonArray[$i]['first_name'] = $users->first_name;
            $jsonArray[$i]['last_name'] = $users->last_name;
            $jsonArray[$i]['picture'] = $users->picture;
            $follow = Follow::where('user_id',Auth::user()->id)->where('follow_user_id',$users->id)->count();
            $friend = Friends::where('user_id',Auth::user()->id)->where('friend_id',$users->id)->count();
            $frequest = Friendrequest::where('user_id',Auth::user()->id)->where('friend_id',$users->id)->count();
            $freq = Friendrequest::where('user_id',$users->id)->where('friend_id',Auth::user()->id)->count();

            $jsonArray[$i]['friend'] = ($friend > 0) ? true : false;
            $jsonArray[$i]['request_sent'] = ($frequest > 0) ? true : false;
            $jsonArray[$i]['request_received'] = ($freq > 0) ? true : false;
            $jsonArray[$i]['follow'] = ($follow > 0) ? true : false;
            $jsonArray[$i]['user_role'] = User::find($users->id)->isKnitter() ? 'Knitter' : 'Designer';
        }

        $array = array('suggested' => $jsonArray);
        return response()->json(['data' => $array]);
    }

    function checkPrivacy($id,$privacy){
        
        $userCount = User::find($id)->settings()->where('name',$privacy)->count();
        if($userCount > 0){
            $user = User::find($id)->settings()->where('name',$privacy)->select('value')->first();
            return $user->value;
        }else{
            return 0;
        }
    }

    function my_profile(){
        $user_id = Auth::user()->id;
        $jsonArray = array();

        $user = User::where('id',$user_id)->get();
        for ($i=0; $i < count($user); $i++) { 
            $jsonArray[$i]['id'] = $user[$i]->id;
            $jsonArray[$i]['first_name'] = $user[$i]->first_name;
            $jsonArray[$i]['first_name_privacy'] = $this->checkPrivacy($user[$i]->id,'first_name_privacy');
            $jsonArray[$i]['last_name'] = $user[$i]->last_name;
            $jsonArray[$i]['last_name_privacy'] = $this->checkPrivacy($user[$i]->id,'last_name_privacy');
            $jsonArray[$i]['username'] = $user[$i]->username;
			$jsonArray[$i]['role'] = $user[$i]->userRole();
            $jsonArray[$i]['email'] = $user[$i]->email;
            $jsonArray[$i]['email_privacy'] = $this->checkPrivacy($user[$i]->id,'email_privacy');
            $jsonArray[$i]['mobile'] = $user[$i]->mobile;
            $jsonArray[$i]['mobile_privacy'] = $this->checkPrivacy($user[$i]->id,'mobile_privacy');
            $jsonArray[$i]['website'] = $user[$i]->profile->website;
            $jsonArray[$i]['postal_address'] = $user[$i]->address;
            $jsonArray[$i]['postal_address_privacy'] = $this->checkPrivacy($user[$i]->id,'postal_address_privacy');
			$jsonArray[$i]['picture'] = $user[$i]->picture;
           $jsonArray[$i]['aboutme'] = $user[$i]->profile->aboutme;

           $skills = User::find($user[$i]->id)->skills()->get();
           for ($j=0; $j < count($skills); $j++) { 
               $jsonArray[$i]['skills'][$j]['skill_name'] = $skills[$j]->skills;
               $jsonArray[$i]['skills'][$j]['rating'] = $skills[$j]->rating; 
           }
           $jsonArray[$i]['as_a_knitter_i_am'] = $user[$i]->profile->as_a_knitter_i_am;
           $jsonArray[$i]['i_knit_for'] = $user[$i]->profile->i_knit_for;
           $jsonArray[$i]['i_am_here_for'] = $user[$i]->profile->i_am_here_for;
           
           $images = TimelineImages::where('user_id',$user[$i]->id)->orderBy('updated_at')->select('image_path','updated_at')->get();
           $jsonArray[$i]['images'] = $images;
        }

        $array = array('user' => $jsonArray);
        return response()->json(['data' => $array]);

    }

    function maskValue($value){
    $mask_address =  str_repeat("*", strlen($value)-1) . substr($value, -2);
    return $mask_address;
    }

    function other_user_profile(Request $request){
        $user_id = $request->id;
        $jsonArray = array();

        $user = User::where('id',$user_id)->get();
        for ($i=0; $i < count($user); $i++) { 
            $jsonArray[$i]['id'] = $user[$i]->id;
            $jsonArray[$i]['first_name'] = $user[$i]->first_name;
            $jsonArray[$i]['first_name_privacy'] = $this->checkPrivacy($user[$i]->id,'first_name_privacy');
            $jsonArray[$i]['last_name'] = $user[$i]->last_name;
            $jsonArray[$i]['last_name_privacy'] = $this->checkPrivacy($user[$i]->id,'last_name_privacy');
            $jsonArray[$i]['username'] = $user[$i]->username;
			$jsonArray[$i]['role'] = $user[$i]->userRole();
            $jsonArray[$i]['email'] = $user[$i]->email;
            $jsonArray[$i]['email_privacy'] = $this->checkPrivacy($user[$i]->id,'email_privacy');
            $jsonArray[$i]['mobile'] = $user[$i]->mobile;
            $jsonArray[$i]['mobile_privacy'] = $this->checkPrivacy($user[$i]->id,'mobile_privacy');
            $jsonArray[$i]['website'] = $user[$i]->profile->website;
            $jsonArray[$i]['website_privacy'] = $this->checkPrivacy($user[$i]->id,'website_privacy');
            $jsonArray[$i]['postal_address'] = $user[$i]->address;
            $jsonArray[$i]['postal_address_privacy'] = $this->checkPrivacy($user[$i]->id,'postal_address_privacy');
			
			$jsonArray[$i]['picture'] = $user[$i]->picture;
           $jsonArray[$i]['aboutme'] = $user[$i]->profile->aboutme;

           $skills = User::find($user[$i]->id)->skills()->get();
		   if($skills->count() > 0){
           for ($j=0; $j < count($skills); $j++) { 
               $jsonArray[$i]['skills'][$j]['skill_name'] = $skills[$j]->skills;
               $jsonArray[$i]['skills'][$j]['rating'] = $skills[$j]->rating; 
           }
		   }else{
			   $jsonArray[$i]['skills'] = array();
		   }
           $jsonArray[$i]['as_a_knitter_i_am'] = $user[$i]->profile->as_a_knitter_i_am;
           $jsonArray[$i]['i_knit_for'] = $user[$i]->profile->i_knit_for;
           $jsonArray[$i]['i_am_here_for'] = $user[$i]->profile->i_am_here_for;
           
           $images = TimelineImages::where('user_id',$user[$i]->id)->orderBy('updated_at','desc')->select('image_path')->get();
           $jsonArray[$i]['images'] = $images;
        }

        $array = array('user' => $jsonArray);
        return response()->json(['data' => $array]);

    }

    function edit_aboutme(){
        $jsonArray = array();
        $aboutme = Auth::user()->profile->aboutme;
        $array = array("aboutme" => $aboutme);
        return response()->json(['data' => $array]);
    }

    function update_aboutme(Request $request){
        $array = array('aboutme' => $request->aboutme);
        if(Auth::user()->profile){
        $send = Auth::user()->profile->update($array);
        }else{
        $profile = new Userprofile;
        $profile->user_id = Auth::user()->id;
        $profile->aboutme = $request->aboutme;
        $send = $profile->save();
        }

        if($send){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail.']);
        }
    }

    function edit_skillSet(){
        $jsonArray = array();
        $skillset = Auth::user()->skills()->select('id','skills','rating')->get();
        $skills = MasterList::where('type','user_skill_set')->select('name')->get();
        $rating = MasterList::where('type','skill_level')->select('name')->get();
        $at = array(1,2,3,4,5);
        $as_a_knitter_i_am = Auth::user()->profile->as_a_knitter_i_am;
        for ($i=0; $i < count($rating); $i++) { 
            $jsonArray[$i]['name'] = $rating[$i]->name;
            $jsonArray[$i]['value'] = $at[$i];
        }
        $array = array("skillset" => $skillset,'as_a_knitter_i_am' => $as_a_knitter_i_am,'skills' => $skills,'rating' => $jsonArray);
        return response()->json(['data' => $array]);
    }

    function update_skillSet(Request $request){
        $id = $request->id;
        $skills = $request->skills;
        $rating = $request->rating;
        $as_a_knitter_i_am = $request->as_a_knitter_i_am;

        $arr = array('as_a_knitter_i_am' => $as_a_knitter_i_am);
        $update1 = Userprofile::where('user_id',Auth::user()->id)->update($arr);
			UserSkills::where('user_id',Auth::user()->id)->delete();
        for ($i=0; $i < count($skills); $i++) { 
           // if($id[$i] == 0){
                $array = array('user_id' => Auth::user()->id,'skills' => $skills[$i],'rating' => $rating[$i]);
                $update = UserSkills::insert($array);
            //}else{
               // $array = array('skills' => $skills[$i],'rating' => $rating[$i]);
              //  $update = UserSkills::where('id',$id[$i])->update($array);
            //}
        }

        

        if($update && $update1){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function editInterest(){
        $jsonArray = array();
        $jsonArray1 = array();
        $jsonArray2 = array();
        $interest = Auth::user()->profile;

        if($interest){
            $jsonArray['i_knit_for'] = $interest->i_knit_for;
            $jsonArray['i_am_here_for'] = $interest->i_am_here_for;
        }

        $a1 = array('Myself','Charity','Family');
        $a2 = array('Knitting','Learning','Casual Friends');

        for ($i=0; $i < count($a1); $i++) { 
            $jsonArray1[$i]['name'] = $a1[$i];
        }

        for ($j=0; $j < count($a2); $j++) { 
            $jsonArray2[$j]['name'] = $a2[$j];
        }

        $array = array('interest' => [$jsonArray],'i_knit_for' => $jsonArray1,'i_am_here_for' => $jsonArray2);
        return response(['data' => $array]);

    }

    function update_interest(Request $request){
        $i_knit_for = $request->i_knit_for;
        $i_am_here_for = $request->i_am_here_for;

         if($i_knit_for){
            $a = implode(',', $request->i_knit_for);
        }else{
            $a = '';
        }

        if($i_am_here_for){
            $b = implode(',', $request->i_am_here_for);
        }else{
            $b = '';
        }

        $array = array('i_knit_for' => $a,'i_am_here_for' => $b);
        if(Auth::user()->profile){
            $send = Auth::user()->profile->where('user_id',Auth::user()->id)->update($array);
        }else{
            $profile = new Userprofile;
            $profile->user_id = Auth::user()->id;
            $profile->i_knit_for = $a;
            $profile->i_am_here_for = $b;
            $send = $profile->save();
        }

        if($send){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail.']);
        }
    }

    function editcontact_details(){
        $jsonArray = array();

        $user = User::where('id',Auth::user()->id)->get();
        for ($i=0; $i < count($user); $i++) { 
            $jsonArray[$i]['id'] = $user[$i]->id;
            $jsonArray[$i]['first_name'] = $user[$i]->first_name;
            $jsonArray[$i]['first_name_privacy'] = $this->checkPrivacy($user[$i]->id,'first_name_privacy');
            $jsonArray[$i]['last_name'] = $user[$i]->last_name;
            $jsonArray[$i]['last_name_privacy'] = $this->checkPrivacy($user[$i]->id,'last_name_privacy');
            $jsonArray[$i]['username'] = $user[$i]->username;
            $jsonArray[$i]['email'] = $user[$i]->email;
            $jsonArray[$i]['email_privacy'] = $this->checkPrivacy($user[$i]->id,'email_privacy');
            $jsonArray[$i]['mobile'] = $user[$i]->mobile;
            $jsonArray[$i]['mobile_privacy'] = $this->checkPrivacy($user[$i]->id,'mobile_privacy');
            $jsonArray[$i]['website'] = $user[$i]->profile->website;
            $jsonArray[$i]['website_privacy'] = $this->checkPrivacy($user[$i]->id,'website_privacy');
            $jsonArray[$i]['address'] = $user[$i]->address;
            $jsonArray[$i]['address_privacy'] = $this->checkPrivacy($user[$i]->id,'address_privacy');

        }

        $array = array('contact_details' => $jsonArray);
        return response()->json(['data' => $array]);
    }


    function update_contact_details(Request $request){
        $validator = $request->validate([
            'first_name' => 'required|alpha|min:2|max:15',
            'last_name' => 'required|alpha|min:2|max:15'
        ]);

        
        $first_name = Auth::user()->settings->where('name','first_name_privacy')->count();
        $last_name = Auth::user()->settings->where('name','last_name_privacy')->count();
        $mobile = Auth::user()->settings->where('name','mobile_privacy')->count();
        $email = Auth::user()->settings->where('name','email_privacy')->count();
        $address = Auth::user()->settings->where('name','address_privacy')->count();
        $website = Auth::user()->settings->where('name','website_privacy')->count();

        $user = User::find(Auth::user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $save = $user->save();

        $array = array('website' => $request->website);
        Auth::user()->profile->where('user_id',Auth::user()->id)->update($array);

        if($first_name){
            $fn = array('value' => $request->first_name_privacy);
            UserSettings::where('user_id',Auth::user()->id)->where('name','first_name_privacy')->update($fn);
        }else{
            $fn = array('user_id' => Auth::user()->id, 'name' => 'first_name_privacy' ,'value' => $request->first_name_privacy,'created_at' => Carbon::now());
            UserSettings::insert($fn);
        }

        if($last_name){
            $ln = array('value' => $request->last_name_privacy);
            UserSettings::where('user_id',Auth::user()->id)->where('name','last_name_privacy')->update($ln);
        }else{
            $ln = array('user_id' => Auth::user()->id, 'name' => 'last_name_privacy' ,'value' => $request->last_name_privacy,'created_at' => Carbon::now());
            UserSettings::insert($ln);
        }

        if($mobile){
            $mb = array('value' => $request->mobile_privacy);
            UserSettings::where('user_id',Auth::user()->id)->where('name','mobile_privacy')->update($mb);
        }else{
            $mb = array('user_id' => Auth::user()->id, 'name' => 'mobile_privacy' ,'value' => $request->mobile_privacy,'created_at' => Carbon::now());
            UserSettings::insert($mb);
        }


        if($email){
            $em = array('value' => $request->email_privacy);
            UserSettings::where('user_id',Auth::user()->id)->where('name','email_privacy')->update($em);
        }else{
            $em = array('user_id' => Auth::user()->id, 'name' => 'email_privacy' ,'value' => $request->email_privacy,'created_at' => Carbon::now());
            UserSettings::insert($em);
        }


        if($address){
            $add = array('value' => $request->address_privacy);
            UserSettings::where('user_id',Auth::user()->id)->where('name','address_privacy')->update($add);
        }else{
            $add = array('user_id' => Auth::user()->id, 'name' => 'address_privacy' ,'value' => $request->address_privacy,'created_at' => Carbon::now());
            UserSettings::insert($add);
        }


        if($website){
            $wb = array('value' => $request->website_privacy);
            UserSettings::where('user_id',Auth::user()->id)->where('name','website_privacy')->update($wb);
        }else{
            $wb = array('user_id' => Auth::user()->id, 'name' => 'website_privacy' ,'value' => $request->website_privacy,'created_at' => Carbon::now());
            UserSettings::insert($wb);
        }

        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'error']);
        }
    }
	
	function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-.]/', '', $string); // Removes special chars.
     }


    function update_profile_picture(Request $request){
        $image = $request->file('file');
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $oname = $this->clean($image->getClientOriginalName());
        $filename = time().'-'.$oname;
        $ext = $image->getClientOriginalExtension();

        $s3 = \Storage::disk('s3');
        //exit;
        $filepath = 'knitfit/'.$filename;

        $ext = $ext;
        $img = Image::make($image);
        $height = Image::make($image)->height();
        $width = Image::make($image)->width();
        $img->orientate();
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->encode('jpg');
        $pu = $s3->put('/'.$filepath, $img->__toString(), 'public');

        $path = 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath;

        $user = User::find(Auth::user()->id);
        $user->picture = $path;
        $save = $user->save();

     if($save){
         return response()->json(['status' => 'success','picture' => $path]);
     }else{
        return response()->json(['status' => 'error']);
     }
    }
	
	function my_friend_requests(){
        $jsonArray = array();
        $jsonArray1 = array();
        $sentfriend_requests = Friendrequest::where('friend_request.user_id',Auth::user()->id)->get();
        $myfriend_requests = Friendrequest::where('friend_request.friend_id',Auth::user()->id)->get();

        for ($i=0; $i < count($sentfriend_requests); $i++) { 
            $user = User::where('id',$sentfriend_requests[$i]['friend_id'])->select('id as user_id','first_name','last_name','picture')->first();
            $jsonArray[$i]['user_id'] = $user->user_id;
            $jsonArray[$i]['first_name'] = $user->first_name;
            $jsonArray[$i]['last_name'] = $user->last_name;
			$jsonArray[$i]['picture'] = $user->picture;
			$jsonArray[$i]['user_role'] = User::find($user->user_id)->isKnitter() ? 'Knitter' : 'Designer';
            $jsonArray[$i]['created_at'] = $sentfriend_requests[$i]['created_at'];
        }

        for ($j=0; $j < count($myfriend_requests); $j++) { 
            $users = User::where('id',$myfriend_requests[$j]['user_id'])->select('id as user_id','first_name','last_name','picture')->first();
            $jsonArray1[$j]['user_id'] = $users->user_id;
            $jsonArray1[$j]['first_name'] = $users->first_name;
            $jsonArray1[$j]['last_name'] = $users->last_name;
			$jsonArray1[$j]['picture'] = $users->picture;
			$jsonArray1[$j]['user_role'] = User::find($users->user_id)->isKnitter() ? 'Knitter' : 'Designer';
            $jsonArray1[$j]['created_at'] = $myfriend_requests[$j]['created_at'];
        }

        $array = array('friend_requests_sent' => $jsonArray,'friend_requests_received' => $jsonArray1);
        return response()->json(['data' => $array]);
    }
}
