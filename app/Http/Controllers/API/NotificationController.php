<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Carbon\Carbon;

class NotificationController extends Controller
{
    function unread_notifications(){
    	$jsonArray = array();
        $notifications = Auth::user()->unreadNotifications;
        $count = Auth::user()->unreadNotifications->count();
        $fcount = Auth::user()->unreadNotifications->where('type','App\\Notifications\\FriendRequestNotification')->count();
        $i=0;
        foreach ($notifications as $notification) {
        	if($notification->type == 'App\\Notifications\\LikeToPostNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['LikedBy']['first_name']).' '.ucfirst($notification->data['LikedBy']['last_name']);
                $jsonArray[$i]['message'] = 'liked your post';
                $jsonArray[$i]['picture'] = $notification->data['LikedBy']['picture'];
                $jsonArray[$i]['time'] = Carbon::parse($notification->data['repliesTime'])->diffForHumans();
                $jsonArray[$i]['timeline_id'] = $notification->data['timeline']['id'];
                $jsonArray[$i]['friend_request'] = false;
                $jsonArray[$i]['connect'] = true;
                $jsonArray[$i]['user'] = false;
                $jsonArray[$i]['notification_type'] = 'LikeToPost';

            }else if($notification->type == 'App\\Notifications\\CommentToPostNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['commentedBy']['first_name']).' '.ucfirst($notification->data['commentedBy']['last_name']);
                $jsonArray[$i]['message'] = 'commented on your post';
                $jsonArray[$i]['picture'] = $notification->data['commentedBy']['picture'];
                $jsonArray[$i]['time'] = Carbon::parse($notification->data['repliesTime'])->diffForHumans();
                $jsonArray[$i]['timeline_id'] = $notification->data['timeline']['id'];
                $jsonArray[$i]['friend_request'] = false;
                $jsonArray[$i]['connect'] = true;
                $jsonArray[$i]['user'] = false;
                $jsonArray[$i]['notification_type'] = 'CommentToPost';
            
            }else if($notification->type == 'App\\Notifications\\FollowNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['followingBy']['first_name']).' '.ucfirst($notification->data['followingBy']['last_name']);
                $jsonArray[$i]['message'] = 'is following you.';
                $jsonArray[$i]['picture'] = $notification->data['followingBy']['picture'];
                $jsonArray[$i]['time'] = Carbon::parse($notification->data['requestTime'])->diffForHumans();
                $jsonArray[$i]['user_id'] = $notification->data['followingBy']['id'];
                $jsonArray[$i]['friend_request'] = false;
                $jsonArray[$i]['connect'] = false;
                $jsonArray[$i]['user'] = true;
                $jsonArray[$i]['notification_type'] = 'Follow';

            }else if($notification->type == 'App\\Notifications\\FriendRequestAcceptNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['acceptedBy']['first_name']).' '.ucfirst($notification->data['acceptedBy']['last_name']);
                $jsonArray[$i]['message'] = 'accepted your friend request.';
                $jsonArray[$i]['picture'] = $notification->data['acceptedBy']['picture'];
                $jsonArray[$i]['time'] = Carbon::parse($notification->data['acceptedTime'])->diffForHumans();
                $jsonArray[$i]['user_id'] = $notification->data['acceptedBy']['id'];
                $jsonArray[$i]['friend_request'] = true;
                $jsonArray[$i]['connect'] = false;
                $jsonArray[$i]['user'] = false;
                $jsonArray[$i]['notification_type'] = 'FriendRequestAccept';

            }else if($notification->type == 'App\\Notifications\\FriendRequestNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['requestSentBy']['first_name']).' '.ucfirst($notification->data['requestSentBy']['last_name']);
                $jsonArray[$i]['message'] = 'sent a friend request to connect with you.';
                $jsonArray[$i]['picture'] = $notification->data['requestSentBy']['picture'];
                $jsonArray[$i]['time'] = Carbon::parse($notification->data['RequestSentAt'])->diffForHumans();
                $jsonArray[$i]['user_id'] = $notification->data['requestSentBy']['id'];
                $jsonArray[$i]['friend_request'] = true;
                $jsonArray[$i]['connect'] = false;
                $jsonArray[$i]['user'] = false;
                $jsonArray[$i]['notification_type'] = 'FriendRequest';

            }else if($notification->type == 'App\\Notifications\\LikeToCommentNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['LikedBy']['first_name']).' '.ucfirst($notification->data['LikedBy']['last_name']);
                $jsonArray[$i]['message'] = 'liked your comment.';
                $jsonArray[$i]['picture'] = $notification->data['LikedBy']['picture'];
                $jsonArray[$i]['time'] = Carbon::parse($notification->data['repliesTime'])->diffForHumans();
                $jsonArray[$i]['timeline_id'] = $notification->data['timeline']['id'];
                $jsonArray[$i]['friend_request'] = false;
                $jsonArray[$i]['connect'] = true;
                $jsonArray[$i]['user'] = false;
                $jsonArray[$i]['notification_type'] = 'LikeToComment';

            }else{

            }
        	
        	$jsonArray[$i]['seen'] = ($notification->read_at == null) ? false : true;

        $i++;
        }
        $array = array('count' => $count,'friend_requests' => $fcount,'notifications' => $jsonArray);
        return response()->json(['data' => $array]);
    }

    function all_notifications(){
    	$jsonArray = array();
        $notifications = Auth::user()->notifications;
        $count = Auth::user()->notifications->count();
        $fcount = Auth::user()->unreadNotifications->where('type','App\\Notifications\\FriendRequestNotification')->count();
        $i=0;
        foreach ($notifications as $notification) {
        	if($notification->type == 'App\\Notifications\\LikeToPostNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['LikedBy']['first_name']).' '.ucfirst($notification->data['LikedBy']['last_name']);
        		$jsonArray[$i]['message'] = 'liked your post';
        		$jsonArray[$i]['picture'] = $notification->data['LikedBy']['picture'];
        		$jsonArray[$i]['time'] = Carbon::parse($notification->data['repliesTime'])->diffForHumans();
                $jsonArray[$i]['timeline_id'] = $notification->data['timeline']['id'];
                $jsonArray[$i]['friend_request'] = false;
                $jsonArray[$i]['connect'] = true;
                $jsonArray[$i]['user'] = false;
                $jsonArray[$i]['notification_type'] = 'LikeToPost';

        	}else if($notification->type == 'App\\Notifications\\CommentToPostNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['commentedBy']['first_name']).' '.ucfirst($notification->data['commentedBy']['last_name']);
        		$jsonArray[$i]['message'] = 'commented on your post';
        		$jsonArray[$i]['picture'] = $notification->data['commentedBy']['picture'];
        		$jsonArray[$i]['time'] = Carbon::parse($notification->data['repliesTime'])->diffForHumans();
                $jsonArray[$i]['timeline_id'] = $notification->data['timeline']['id'];
                $jsonArray[$i]['friend_request'] = false;
                $jsonArray[$i]['connect'] = true;
                $jsonArray[$i]['user'] = false;
                $jsonArray[$i]['notification_type'] = 'CommentToPost';
        	
        	}else if($notification->type == 'App\\Notifications\\FollowNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['followingBy']['first_name']).' '.ucfirst($notification->data['followingBy']['last_name']);
        		$jsonArray[$i]['message'] = 'is following you.';
        		$jsonArray[$i]['picture'] = $notification->data['followingBy']['picture'];
        		$jsonArray[$i]['time'] = Carbon::parse($notification->data['requestTime'])->diffForHumans();
                $jsonArray[$i]['user_id'] = $notification->data['followingBy']['id'];
                $jsonArray[$i]['friend_request'] = false;
                $jsonArray[$i]['connect'] = false;
                $jsonArray[$i]['user'] = true;
                $jsonArray[$i]['notification_type'] = 'Follow';

        	}else if($notification->type == 'App\\Notifications\\FriendRequestAcceptNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['acceptedBy']['first_name']).' '.ucfirst($notification->data['acceptedBy']['last_name']);
        		$jsonArray[$i]['message'] = 'accepted your friend request.';
        		$jsonArray[$i]['picture'] = $notification->data['acceptedBy']['picture'];
        		$jsonArray[$i]['time'] = Carbon::parse($notification->data['acceptedTime'])->diffForHumans();
                $jsonArray[$i]['user_id'] = $notification->data['acceptedBy']['id'];
                $jsonArray[$i]['friend_request'] = true;
                $jsonArray[$i]['connect'] = false;
                $jsonArray[$i]['user'] = false;
                $jsonArray[$i]['notification_type'] = 'FriendRequestAccept';

        	}else if($notification->type == 'App\\Notifications\\FriendRequestNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['requestSentBy']['first_name']).' '.ucfirst($notification->data['requestSentBy']['last_name']);
        		$jsonArray[$i]['message'] = 'sent a friend request to connect with you.';
        		$jsonArray[$i]['picture'] = $notification->data['requestSentBy']['picture'];
        		$jsonArray[$i]['time'] = Carbon::parse($notification->data['RequestSentAt'])->diffForHumans();
                $jsonArray[$i]['user_id'] = $notification->data['requestSentBy']['id'];
                $jsonArray[$i]['friend_request'] = true;
                $jsonArray[$i]['connect'] = false;
                $jsonArray[$i]['user'] = false;
                $jsonArray[$i]['notification_type'] = 'FriendRequest';

        	}else if($notification->type == 'App\\Notifications\\LikeToCommentNotification'){
                $jsonArray[$i]['id'] = $notification->id;
                $jsonArray[$i]['name'] = ucfirst($notification->data['LikedBy']['first_name']).' '.ucfirst($notification->data['LikedBy']['last_name']);
        		$jsonArray[$i]['message'] = 'liked your comment.';
        		$jsonArray[$i]['picture'] = $notification->data['LikedBy']['picture'];
        		$jsonArray[$i]['time'] = Carbon::parse($notification->data['repliesTime'])->diffForHumans();
                $jsonArray[$i]['timeline_id'] = $notification->data['timeline']['id'];
                $jsonArray[$i]['friend_request'] = false;
                $jsonArray[$i]['connect'] = true;
                $jsonArray[$i]['user'] = false;
                $jsonArray[$i]['notification_type'] = 'LikeToComment';

        	}else{

        	}
        	
        	$jsonArray[$i]['seen'] = ($notification->read_at == null) ? false : true;

        $i++;
        }
        $array = array('count' => $count,'friend_requests' => $fcount,'notifications' => $jsonArray);
        return response()->json(['data' => $array]);
    }

    function markAsRead(){
    	$user = User::find(Auth::user()->id);
        $user->unreadNotifications->markAsRead();
    }
	
	function deleteNotification(Request $request){
        $id = $request->id;
        $user = User::find(Auth::user()->id);
        $delete = $user->notifications()->where('id',$id)->delete();
        if($delete){
            return response()->json(['status' => 'success','message' => 'Notification deleted successfully.']);
        }else{
            return response()->json(['status' => 'fail','message' => 'Unable to delete notification.Try again after sometime.']);
        }
    }
}
