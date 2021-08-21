<?php

namespace App\Http\Controllers\Knitter;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Friends;
use App\Models\GroupFaqCategory;
use App\Models\GroupTimeline;
use App\Models\GroupTimelineCommentLikes;
use App\Models\GroupTimelineComments;
use App\Models\GroupTimelineImage;
use App\Models\GroupTimelineLikes;
use App\Notifications\GroupPostCommentLikeNotification;
use App\Notifications\GroupPostCommentNotification;
use App\Notifications\GroupPostLikeNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Products;
use Auth;
use Image;
use Illuminate\Support\Str;
use DB;
use File;
use Validator;
use Paginate;
use Redirect;
use Carbon\Carbon;
use App\Models\Group;
use App\Models\Groupmembers;
use App\Models\GroupFaq;
use App\Models\GroupNotification;
use App\Models\GroupRequest;
use App\Models\GroupUser;

class GroupsController extends Controller
{
    function __construct(){
        $this->middleware(['auth']);
    }

    function index(Request $request){
        if($request->ajax()){
            $groups = Group::leftJoin('group_users','group_users.group_id','groups.id')
                ->select('groups.id','groups.unique_id','groups.group_name','groups.group_image')
                ->where('group_users.user_id',Auth::user()->id)->where('groups.status',1)->paginate(8);
            return view('Knitter.Groups.view',compact('groups'));
        }
        $groups = Group::leftJoin('group_users','group_users.group_id','groups.id')
            ->select('groups.id','groups.unique_id','groups.group_name','groups.group_image')
            ->where('group_users.user_id',Auth::user()->id)->where('groups.status',1)->paginate(8);

        return view('Knitter.Groups.index',compact('groups'));
    }

    function search_group(Request $request){
        if($request->get('search')){
            $search = $request->get('search');
        }else{
            $search = '';
        }

        $groups = Group::leftJoin('group_users','group_users.group_id','groups.id')
            ->select('groups.id','groups.unique_id','groups.group_name')
            ->where('group_users.user_id',Auth::user()->id)
            ->where('groups.group_name','LIKE','%'.$search.'%')->where('groups.status',1)->paginate(8);

        return view('Knitter.Groups.search',compact('groups','search'));
    }

    function view_group_members(Request $request){
        $id = $request->id;
        $group = Group::where('unique_id',$id)->first();
        $members = GroupUser::leftJoin('users','users.id','group_users.user_id')
                    ->select('users.id as uid','users.first_name','users.last_name','users.email','users.picture')
                    ->where('group_users.group_id',$group->id)
                    ->where('group_users.user_id','!=',Auth::user()->id)->paginate(8);
        return view('Knitter.Groups.members',compact('group','members'));
    }

    function search_group_members(Request $request){
        $id = $request->id;
        $search = $request->get('search');
        $group = Group::where('unique_id',$id)->first();
        if(!$search){
            $members = array();
            $search = '';
            return view('Knitter.Groups.members-search',compact('group','members','search'));
        }
        $members = GroupUser::leftJoin('users','users.id','group_users.user_id')
            ->select('group_users.id','users.id as uid','users.first_name','users.last_name','users.email','users.picture')
            ->where('group_users.group_id',$group->id)
            ->where('group_users.user_id','!=',Auth::user()->id)
            ->where(function($query){
                $search = request()->get('search');
                $query->where('users.first_name','LIKE','%'.$search.'%')
                    ->orWhere('users.last_name','LIKE','%'.$search.'%');
            })->paginate(8);

        return view('Knitter.Groups.members-search',compact('group','members','search'));
    }

    function view_group_faq(Request $request){
        $id = $request->id;
        $group = Group::where('unique_id',$id)->first();
        $faqs = GroupFaq::where('group_id',$group->id)->orderBy('id','DESC')->paginate(10);
        $categories = GroupFaqCategory::where('group_id',$group->id)->orderBy('id','DESC')->take(2)->get();
        if ($request->ajax()) {
            return view('Knitter.Groups.Faq.faqs', compact('faqs'));
        }
        return view('Knitter.Groups.Faq.index',compact('group','categories'));
    }

    function search_group_faq(Request $request){
        $group_id = $request->group_id;
        $search = $request->search;
        $group = Group::where('unique_id',$group_id)->first();
        $faqs = GroupFaq::where('group_id',$group->id)->where('faq_title','LIKE','%'.$search.'%')->orderBy('id','DESC')->paginate(10);
        return view('Knitter.Groups.Faq.search',compact('group','faqs'));
    }

    function group_faq_fullview(Request $request){
        $faq = GroupFaq::where('faq_unique_id',$request->id)->first();
        $group = Group::where('id',$faq->group_id)->first();
        $categories = GroupFaqCategory::orderBy('id','DESC')->take(2)->get();
        return view('Knitter.Groups.Faq.faq-fullview',compact('faq','group','categories'));
    }

    function exit_group(Request $request){
        $group = Group::where('unique_id',$request->id)->first();
        $guser = GroupUser::where('group_id',$group->id)->where('user_id',Auth::user()->id)->delete();
        if($guser){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function show_group_community(Request $request){
        $group = Group::where('unique_id',$request->group_id)->first();
        $timeline = GroupTimeline::leftJoin('users', 'users.id', 'group_timelines.user_id')
            ->select('group_timelines.*', 'users.id as uid', 'users.first_name', 'users.last_name', 'users.picture', 'users.username', 'users.email')
            ->where('group_timelines.status', 1)
            ->where('group_timelines.group_id',$group->id)
            ->orderBy('id','DESC')
            ->paginate(5);
        return view('Knitter.Groups.Community.index',compact('group','timeline'));
    }

    function show_more(Request $request){
        $group_id = $request->group_id;
        $group = Group::where('id',$request->group_id)->first();
        $timeline = GroupTimeline::where('group_id',$group_id)->where('status',1)->orderBy('id','DESC')->take(2)->get();
        return view('Knitter.Groups.Community.index',compact('timeline','group'));
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

    function showAddPost(Request $request){
        $group = Group::where('id',$request->group_id)->first();
        $friends = Friends::leftJoin('users','users.id','friends.friend_id')
            ->where('friends.user_id',Auth::user()->id)
            ->select('users.id','users.first_name','users.last_name','users.picture','users.username','users.email')->get();
        return view('Knitter.Groups.Community.add-post',compact('friends','group'));
    }

    function timeline_addDetails(Request $request)
    {
        if ($request->tag_friends) {
            $tag = implode(',', $request->tag_friends);
        } else {
            $tag = '';
        }


        $timeline = new GroupTimeline;
        $timeline->group_id = $request->group_id;
        $timeline->user_id = Auth::user()->id;
        $timeline->post_content = $request->post_content;
        $timeline->tag_friends = $tag;
        $timeline->location = $request->location;
        $timeline->privacy = 1;
        $timeline->created_at = Carbon::now();
        $timeline->ipaddress = $request->ip();
        $save = $timeline->save();
        if ($save) {

            if ($request->image) {
                for ($i = 0; $i < count($request->image); $i++) {
                    $images = new GroupTimelineImage;
                    $images->group_id = $request->group_id;
                    $images->user_id = Auth::user()->id;
                    $images->group_timeline_id = $timeline->id;
                    $images->image_path = $request->image[$i];
                    $images->created_at = Carbon::now();
                    $images->ipaddress = $request->ip();
                    $images->save();
                }
            }

            //$id = $request->id;
            $timeline = GroupTimeline::leftJoin('users', 'users.id', 'group_timelines.user_id')
                ->select('group_timelines.*', 'users.id as uid', 'users.first_name', 'users.last_name', 'users.picture', 'users.username', 'users.email')
                ->where('group_timelines.status', 1)
                ->where('group_timelines.group_id',$timeline->group_id)
                ->where('group_timelines.id', '=', $timeline->id)->orderBy('id', 'DESC')
                ->get();
            $friends = Friends::where('user_id', Auth::user()->id)->select('user_id', 'friend_id')->get();
            $follow = Follow::where('user_id', Auth::user()->id)->select('user_id', 'follow_user_id')->get();
            return view('Knitter.Groups.Community.index-dummy', compact('timeline', 'friends', 'follow'));
        } else {
            return response()->json(['error' => 'Unable to add post,Try again after sometime.']);
        }
    }

    function editAddPost(Request $request){
        $group = Group::where('id',$request->group_id)->first();
        $friends = Friends::leftJoin('users','users.id','friends.friend_id')
            ->where('friends.user_id',Auth::user()->id)
            ->select('users.id','users.first_name','users.last_name','users.picture','users.username','users.email')->get();
        $timeline = GroupTimeline::where('id',$request->id)->first();
        $timeline_images = GroupTimelineImage::where('group_timeline_id',$request->id)->get();
        return view('Knitter.Groups.Community.edit-post',compact('timeline','timeline_images','friends','group'));
    }

    function timeline_updateDetails(Request $request){
        if($request->tag_friends){
            $tag = implode(',', $request->tag_friends);
        }else{
            $tag = '';
        }

        $timeline = GroupTimeline::find($request->id);
        $timeline->post_content = $request->post_content;
        $timeline->tag_friends = $tag;
        $timeline->location = $request->location;
        $timeline->privacy = $request->post_privacy;
        $timeline->updated_at = Carbon::now();
        $timeline->ipaddress = $_SERVER['REMOTE_ADDR'];
        $save = $timeline->save();
        if($save){

            if($request->image){
                for ($i=0; $i < count($request->image); $i++) {
                    $images = new GroupTimelineImage;
                    $images->group_id = $request->group_id;
                    $images->user_id = Auth::user()->id;
                    $images->group_timeline_id = $timeline->id;
                    $images->image_path = $request->image[$i];
                    $images->created_at = Carbon::now();
                    $images->ipaddress = $_SERVER['REMOTE_ADDR'];
                    $images->save();
                }
            }

            //$id = $request->id;
            $timeline = GroupTimeline::leftJoin('users','users.id','group_timelines.user_id')
                ->select('group_timelines.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')
                ->where('group_timelines.status',1)
                ->where('group_timelines.id','=',$timeline->id)->orderBy('id','DESC')
                ->get();
            $friends = Friends::where('user_id',Auth::user()->id)->select('user_id','friend_id')->get();
            $follow = Follow::where('user_id',Auth::user()->id)->select('user_id','follow_user_id')->get();
            return view('Knitter.Groups.Community.index-dummy',compact('timeline','friends','follow'));
        }else{
            return response()->json(['error' => 'Unable to add post,Try again after sometime.']);
        }
    }

    function timeline_addLike(Request $request){
        $likeCount = GroupTimelineLikes::where('user_id',Auth::user()->id)->where('group_timeline_id',$request->timeline_id)->count();
        if($likeCount > 0){
            return response()->json(['error' => 'You have already liked this post.']);
            exit;
        }
        $like = new GroupTimelineLikes;
        $like->group_id = $request->group_id;
        $like->user_id = Auth::user()->id;
        $like->group_timeline_id = $request->timeline_id;
        $like->like = 1;
        $like->ipaddress = $request->ip();
        $save = $like->save();

        if($save){
            $timeline = GroupTimeline::where('id',$request->timeline_id)->first();
            $user = User::find($timeline->user_id);
            if($timeline->user_id != Auth::user()->id){
                $user->notify(new GroupPostLikeNotification($timeline));
            }
            return response()->json(['success' => 'Post liked successfully.']);
        }else{
            return response()->json(['error' => 'Unable to like post.']);
        }
    }

    function timeline_unLikePost(Request $request){
        $user_id = Auth::user()->id;
        $timeline_id = $request->timeline_id;
        $unlike = GroupTimelineLikes::where('user_id',$user_id)->where('group_timeline_id',$timeline_id)->delete();
        if($unlike){
            return response()->json(['success' => 'Post unliked successfully.']);
        }else{
            return response()->json(['error' => 'Unable to unlike post,Try again after sometime.']);
        }
    }

    function timeline_deletePost(Request $request){
        $timeline = GroupTimeline::find($request->timeline_id);
        $timeline->status = 0;
        $timeline->is_deleted = 1;
        $timeline->deleted_at = Carbon::now();
        $timeline->deleted_ipaddress = $request->ip();
        $save = $timeline->save();

        if($save){
            return response()->json(['success' => 'Post deleted successfully.']);
        }else{
            return response()->json(['error' => 'Unable to delete post,Try again after sometime.']);
        }
    }

    function timeline_addComment(Request $request){
        $comment = new GroupTimelineComments;
        $comment->group_id = $request->group_id;
        $comment->user_id = Auth::user()->id;
        $comment->group_timeline_id = $request->timeline_id;
        $comment->comment = $request->comment;
        $comment->ipaddress = $request->ip();
        $save = $comment->save();
        if($save){
            $timeline = GroupTimeline::where('id',$request->timeline_id)->first();
            $user = User::find($timeline->user_id);
            if($timeline->user_id != Auth::user()->id){
                $user->notify(new GroupPostCommentNotification($timeline));
            }

            $com = GroupTimelineComments::leftJoin('users','users.id','group_timeline_comments.user_id')
                ->select('group_timeline_comments.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')
                ->where('group_timeline_comments.status',1)
                ->where('group_timeline_comments.id',$comment->id)
                ->where('user_id',Auth::user()->id)
                ->first();
            $i = 0;
            return view('Knitter.Groups.Community.comments',compact('com','i'));
            //return response()->json(['success' => 'Comment posted successfully.']);
        }else{
            return response()->json(['error' => 'Unable to post comment.']);
        }
    }

    function deleteImage(Request $request){
        $id = $request->id;
        $image = GroupTimelineImage::find($id);
        $del = $image->delete();
        if($del){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function timeline_addCommentLike(Request $request){
        $request->validate([
            'group_id' => 'required',
            'timeline_id' => 'required',
            'comment_id' => 'required',
        ]);
        $like = new GroupTimelineCommentLikes;
        $like->group_id = $request->group_id;
        $like->user_id = Auth::user()->id;
        $like->group_timeline_id = $request->timeline_id;
        $like->comment_id = $request->comment_id;
        $like->like = 1;
        $like->ipaddress = $request->ip();
        $save = $like->save();

        if($save){
            $comment = GroupTimelineComments::where('id',$request->comment_id)->first();
            if(Auth::user()->id != $comment->user_id){
                $comment->user->notify(new GroupPostCommentLikeNotification($comment));
            }
            return response()->json(['success' => 'Comment liked successfully.']);
        }else{
            return response()->json(['error' => 'Unable to like the comment.']);
        }
    }

    function timeline_unLikeComment(Request $request){
        $comment_id = $request->comment_id;
        $comment = GroupTimelineCommentLikes::where('comment_id',$comment_id)->where('user_id',Auth::user()->id)->count();
        if($comment > 0){
            $comment = GroupTimelineCommentLikes::where('comment_id',$comment_id)->where('user_id',Auth::user()->id)->delete();
            if($comment){
                return response()->json(['success' => 'Like removed successfully.']);
            }else{
                return response()->json(['error' => 'Unable to remove like.']);
            }
        }else{
            return response()->json(['error' => 'You dont have access to remove this like.']);
        }
    }

    function timeline_UpdateComment(Request $request){
        $comment_id = $request->cid;
        $comment = $request->comment;

        $array = array('comment' => $comment,'updated_at' => Carbon::now());
        $save = GroupTimelineComments::where('id',$comment_id)->update($array);
        if($save){
            $com = GroupTimelineComments::leftJoin('users','users.id','group_timeline_comments.user_id')
                ->select('group_timeline_comments.*','users.id as uid','users.first_name','users.last_name','users.picture','users.username','users.email')
                ->where('group_timeline_comments.id',$comment_id)
                ->first();
            $i = 0;
            return view('Knitter.Groups.Community.comments',compact('com','i'));
            //return response()->json(['success' => 'Comment updated successfully.']);
        }else{
            return response()->json(['error' => 'Unable to update comment,Try again after sometime.']);
        }
    }

    function timeline_deleteComment(Request $request){
        $id = $request->comment_id;
        $check = GroupTimelineComments::where('id',$id)->where('user_id',Auth::user()->id)->count();
        if($check > 0){
            $delete = GroupTimelineComments::where('id',$id)->where('user_id',Auth::user()->id)->delete();
            if($delete){
                return response()->json(['success' => 'Comment deleted successfully.']);
            }else{
                return response()->json(['error' => 'Unable to delete comment.Try again after sometime.']);
            }
        }else{
            return response()->json(['error' => 'You dont have access to delete this comment']);
        }
    }

    /* connect controller */
    function removeFriend(Request $request){
        $user_id = Auth::user()->id;
        $friend_id = $request->friend_id;

        $del1 = Friends::where('user_id',Auth::user()->id)->where('friend_id',$friend_id)->delete();
        $del2 = Friends::where('user_id',$friend_id)->where('friend_id',Auth::user()->id)->delete();
        $this->deleteTimelinePostsFriendsAdd($user_id,$friend_id);
        if($del1 && $del2){
            return response()->json(['success' => 'User removed from friends list.']);
        }else{
            return response()->json(['error' => 'Unable to remove user.']);
        }
    }
}
