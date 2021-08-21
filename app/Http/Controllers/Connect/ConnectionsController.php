<?php

namespace App\Http\Controllers\Connect;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Models\Friends;
use App\Models\Friendrequest;
use App\Models\MasterList;
use App\Models\Follow;
use App\Traits\FriendRequestableTrait;
use App\Notifications\FriendRequestNotification;
use App\Traits\FriendRequestAcceptableTrait;
use App\Notifications\FriendRequestAcceptNotification;
use Carbon\Carbon;
use DB;
use App\Traits\FollowTrait;
use App\Notifications\FollowNotification;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use App\Models\Userprofile;
use App\Models\UserSettings;
use App\Models\TimelineImages;
use App\Models\Timeline;
use App\Models\TimelineShowPosts;
use App\Models\Projectimages;
use Validator;
use File;
use Image;
use Session;
use Redirect;
use App\Models\UserSkills;
use App\Models\Project;
use FcmClient;

class ConnectionsController extends Controller
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

    function index(Request $request){
    	$search = $request->get('search');
    	if($search){
    		//$friends = Friends::leftJoin('users','friends.friend_id','users.id')->select('friends.friend_id as user_id','users.enc_id','users.username','users.first_name','users.last_name','users.email','users.picture')->where('users.first_name', 'LIKE', "%{$search}%")->orWhere('users.last_name', 'LIKE', "%{$search}%")->where('friends.user_id',Auth::user()->id)->paginate(12);
    $friends = DB::table('friends')
            ->leftJoin('users', 'friends.friend_id', '=', 'users.id')
            ->where(function($query) use ($search){
            $query->where('users.first_name', 'LIKE', '%'.$search.'%');
            $query->orWhere('users.last_name', 'LIKE', '%'.$search.'%');
            $query->orWhere('users.username', 'LIKE', '%'.$search.'%');
            
            })
            ->where('friends.user_id', '=', Auth::user()->id)
            ->where('users.status', '=', 1)
            ->select('friends.friend_id as user_id','users.enc_id','users.username','users.first_name','users.last_name','users.email','users.picture')
            ->paginate(12);

    	}else{
    		$friends = Friends::leftJoin('users','users.id','friends.friend_id')
    				->where('friends.user_id',Auth::user()->id)->select('friends.id','users.id as user_id','users.first_name','users.last_name','users.email','users.username','users.picture')->paginate(12);

    	}
    	$skills = MasterList::where('type','skills')->get();
    	$skill_level = MasterList::where('type','skill_level')->get();
    	return view('connect.connections.index',compact('friends','skills','skill_level','search'));
    }

    function filter_my_connections(Request $request){


if($request->search){
    $search = $request->search;
}else{
    $search = $request->search1;
}


$skill = $request->skill;



$query = '';
$query1 = '';
$query2 = '';
$query3 = '';

$query4 = '';
$query5 = '';
$query6 = '';



    $query2.=" left join friends ON friends.friend_id = users.id ";
    $query3.=" friends.user_id = '".Auth::user()->id."' and ";


if($request->followers){
    $query4.=" left join follow on follow.user_id = users.id ";
    $query5.= "follow.follow_user_id = '".Auth::user()->id."' and";
}

if($request->search){
    $query6.=" and (users.first_name LIKE '%".$search."%' OR users.last_name LIKE '%".$search."%' OR users.username LIKE '%".$search."%')  ";
}


if($skill){
    $query.= "SELECT DISTINCT users.id,users.first_name,users.last_name,users.picture,users.username,users.email from user_skills left join users on users.id = user_skills.user_id ".$query2.$query4." WHERE ".$query3.$query5."  users.id != '".Auth::user()->id."' and users.status = 1 and (users.first_name LIKE '%".$search."%' OR users.last_name LIKE '%".$search."%' OR users.username LIKE '%".$search."%')  ";
}else{
    
    $query.= "SELECT DISTINCT users.id,users.first_name,users.last_name,users.picture,users.username,users.email from users ".$query2.$query4." WHERE ".$query3.$query5."  users.id != '".Auth::user()->id."' and users.status = 1 and (users.first_name LIKE '%".$search."%' OR users.last_name LIKE '%".$search."%' OR users.username LIKE '%".$search."%')  ";
}

/*
$query.= "SELECT DISTINCT users.id,users.first_name,users.last_name,users.picture,users.username,users.email from user_skills left join users on users.id = user_skills.user_id ".$query2.$query4." WHERE ".$query3.$query5."  users.id != '".Auth::user()->id."' and users.status = 1  ".$query6;
*/



if($skill){ 
 
    for ($i=0; $i < count($skill); $i++) { 

        $rating = $skill[$i].'_rating';
        $skill_level = $request->$rating;
        
$query2 = '';
        for ($j=0; $j < count($skill_level); $j++) { 

            if($skill_level[$j] > 0 && $skill_level[$j] < 6){
               if($j == 1){
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



$users = DB::select(DB::raw($query.$query1));
return view('connect.connections.my-connections-results',compact('users','search'));
    }

    function find_connections(Request $request){
        $skills = MasterList::where('type','skills')->get();
        $skill_level = MasterList::where('type','skill_level')->get();
        $myfriend_requests = Friendrequest::where('friend_request.friend_id',Auth::user()->id)->get();
        $suggested = DB::select(DB::raw("select DISTINCT (t2.user_id) as suggested_user_id from users t1 join friends t2 on t1.id = t2.user_id WHERE t1.id != ".Auth::user()->id)." limit 8");
        return view('connect.connections.find-connections',compact('skills','skill_level','myfriend_requests','suggested'));
    }
	
	function friend_requests_ajax(Request $request){
        $skills = MasterList::where('type','skills')->get();
        $skill_level = MasterList::where('type','skill_level')->get();
        $myfriend_requests = Friendrequest::where('friend_request.friend_id',Auth::user()->id)->get();
        return view('connect.connections.fr-ajax',compact('skills','skill_level','myfriend_requests'));
    }
	
	function show_suggested_connections(Request $request){
        $skills = MasterList::where('type','skills')->get();
        $skill_level = MasterList::where('type','skill_level')->get();
        $suggested = DB::select(DB::raw("select DISTINCT (t2.user_id) as suggested_user_id from users t1 join friends t2 on t1.id = t2.user_id WHERE t1.id != ".Auth::user()->id)." limit 8");
        return view('connect.connections.suggested-connections',compact('skills','skill_level','suggested'));
    }

    function filter_find_connections(Request $request){


if($request->search){
    $search = $request->search;
}else{
    $search = $request->search1;
}

if(!$search){
    $users = 0;
    return response()->json(['error' => 'Enter something in search.']);
    exit;
}
$skill = $request->skill;



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
        
$query2 = '';
        for ($j=0; $j < count($skill_level); $j++) { 

            if($skill_level[$j] > 0 && $skill_level[$j] < 6){
               if($j == 1){
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



$users = DB::select(DB::raw($query.$query1));
return view('connect.connections.find-connections-results',compact('users','search'));
    }



    function sendFriendRequest(Request $request,User $friendrequest){
    	$user_id = Auth::user()->id;
    	$friend_id = $request->friend_id;
    	$check = Friendrequest::where('user_id',$user_id)->where('friend_id',$friend_id)->count();
        if($user_id == $friend_id){
          return response()->json(['error' => 'You can not send request to your self.']);
            exit;
        }
    	if($check == 1){
    		return response()->json(['error' => 'You have already sent request to this user.']);
    		exit;
    	}
    	$user = User::find($friend_id);

    	$friendrequest = User::where('id',$friend_id)->first();

        $send = $friendrequest->sendFriendRequest($friend_id);
		
		/* Mobile push notifications */
			$content = ucfirst(Auth::user()->first_name).' '.Auth::user()->last_name.' sends you friend request to connect.';
			$this->sendMobileNotification('You have a new friend request',$content,$friend_id);
			/* Mobile push notifications */
    	$user->notify(new FriendRequestNotification($friendrequest));

    	if($send){
    		return response()->json(['success' => 'Your friend request has sent.']);
    	}else{
    		return response()->json(['error' => 'Unable to send request at this time.Try again after some time.']);
    	}
    }

    function cancelFriendRequest(Request $request){
    	$user_id = Auth::user()->id;
    	$friend_id = $request->friend_id;
    	$check = Friendrequest::where('user_id',$user_id)->where('friend_id',$friend_id)->count();
    	if($check == 1){
    		$del = Friendrequest::where('user_id',$user_id)->where('friend_id',$friend_id)->delete();
    		if($del){
    			return response()->json(['success' => 'Successfully removed friend request.']);
    		}else{
    			return response()->json(['error' => 'Unable to remove friend request.']);
    		}

    	}else{
    		return response()->json(['error' => 'No friend request found for this user.']);
    	}
    }

    function rejectFriendRequest(Request $request){
        $id = $request->id;
        $check = Friendrequest::where('id',$id)->count();
        if($check == 1){
            $del = Friendrequest::where('id',$id)->delete();
            if($del){
                return response()->json(['success' => 'Successfully removed friend request.']);
            }else{
                return response()->json(['error' => 'Unable to remove friend request.']);
            }

        }else{
            return response()->json(['error' => 'No friend request found for this user.']);
        }
    }

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


    function acceptRequest(Request $request,User $friendRequestAccept){
    	$fid = $request->friend_id;
        $uid = Auth::user()->id;

        $friend_req = DB::table('friend_request')->where('user_id',$fid)->where('friend_id',$uid)->delete();

        $friendRequestAccept = User::where('id',$fid)->first();
        $fr = $friendRequestAccept->acceptRequest($request);
		
		/* Mobile push notifications */
			$content = ucfirst(Auth::user()->first_name).' '.Auth::user()->last_name.' accepted your friend requests.';
			$this->sendMobileNotification('Your friend request accepted.',$content,$fid);
			/* Mobile push notifications */
			
        $friendRequestAccept->notify(new FriendRequestAcceptNotification($friendRequestAccept));
		$this->checkTimelinePostsFriendsAdd($uid,$fid);
         if($fr){
            return response()->json(['success' => 'Request accepted, user added to friend list.']);
        }else{
            return response()->json(['error' => 'Unable to accept request.']);
        }
    }

    function follow_user(Request $request,User $follow){
        $user_id = Auth::user()->id;
        $follow_user_id = $request->follow_user_id;

        $check = Follow::where('user_id',$user_id)->where('follow_user_id',$follow_user_id)->count();
        if($check > 0){
            return response()->json(['error' => 'You are already following this person.']);
        }

        $follow = User::where('id',$follow_user_id)->first();
        $send = $follow->sendFollowRequest($request);
		/* Mobile push notifications */
			$content = ucfirst(Auth::user()->first_name).' '.Auth::user()->last_name.' is following you';
			$this->sendMobileNotification('You have a notification for follow.',$content,$follow_user_id);
			/* Mobile push notifications */
			
        $follow->notify(new FollowNotification($follow));
		$this->checkTimelinePostsFollowersAdd($user_id,$follow_user_id);
        if($send){
            return response()->json(['success' => 'You are successfully following the person.']);
        }else{
            return response()->json(['error' => 'Unable to send follow request.']);
        }
    }

    function unfollow_user(Request $request){
        $user_id = Auth::user()->id;
        $follow_user_id = $request->follow_user_id;

        $check = Follow::where('user_id',$user_id)->where('follow_user_id',$follow_user_id)->count();
        if($check > 0){
            $del = Follow::where('user_id',$user_id)->where('follow_user_id',$follow_user_id)->delete();
		$this->deleteTimelinePostsfollowersAdd($follow_user_id,$user_id);
        if($del){
            return response()->json(['success' => 'Unfollowing User. You may not receive notifications from this user.']);
        }else{
        return response()->json(['error' => 'Unable to send unfollow request.']);
        }
        }else{
        return response()->json(['error' => 'You are not following this user.']);
        }
    }


    function markAsRead(){
        $user = User::find(Auth::user()->id);
        $user->unreadNotifications->markAsRead();
    }

    function my_profile(Request $request){
        $timeline = Timeline::where('user_id',Auth::user()->id)->orderBy('updated_at','desc')->paginate(20);
        $timeline_images = TimelineImages::where('user_id',Auth::user()->id)->get();
        return view('connect.profile.my-profile',compact('timeline','timeline_images'));
    }


    function user_profile(Request $request){
        $id = $request->id;
        try {
            $decrypted = decrypt($id);
            $user = User::where('id',$decrypted)->first();

$timeline_public = Timeline::where('privacy','public')->where('user_id',$user->id)->get();
$timeline_friends = Timeline::where('privacy','friends')->where('user_id',$user->id)->get();
$timeline_followers = Timeline::where('privacy','followers')->where('user_id',$user->id)->get();
$friends = Friends::where('user_id',$user->id)->where('friend_id',Auth::user()->id)->count();
$follow = Follow::where('user_id',$user->id)->where('follow_user_id',Auth::user()->id)->count();

       // $timeline = Timeline::where('user_id',$user->id)->orderBy('updated_at','desc')->paginate(10);
        //$timeline_images = TimelineImages::where('user_id',$user->id)->get();
       // 

            /* $timeline_images = Timeline::leftJoin('timeline_images','timeline_images.timeline_id','timeline.id')
                ->where('timeline_images.user_id',$user->id)
                ->where('timeline.privacy','!=','only-me')
                ->select('timeline_images.image_path')->get(); */
        } catch (DecryptException $e) {
            return view('notfound');
        }

        return view('connect.profile.userProfile',compact('user','timeline_public','timeline_friends','timeline_followers','friends','follow'));
    }

    function profile_addAboutme(Request $request){
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
            return response()->json(['success' => 'About me added successfully.']);
        }else{
            return response()->json(['error' => 'Unable to add, Try again after sometime.']);
        }
    }

    function profile_getSkillset(Request $request){

        return view('connect.profile.show-skillset');
    }

    function profile_editSkillset(Request $request){
        $master_list = MasterList::where('type','user_skill_set')->get();
        return view('connect.profile.edit-skillset',compact('master_list'));
    }

    function profile_addskillSet(Request $request){
        //print_r($request->all());
        //exit;
        $rating = $request->rating;
        $skills = $request->professional_skills;

        if($skills){
            UserSkills::where('user_id',Auth::user()->id)->delete();
            foreach ($rating as $key => $rate) {
            //echo $key.' - '.$rate."<br>";
                if($rate == 0){
                    unset($rating[$key]);
                }
            }
            $rates = array_values($rating);

            for ($j=0; $j < count($skills); $j++) { 
                $array1 = array('user_id' => Auth::user()->id,'skills' => $skills[$j],'rating' => $rates[$j],'created_at' => Carbon::now());
            $update = UserSkills::insert($array1);
            }
        }

        //echo $rate;

        $array = array('as_a_knitter_i_am' => $request->as_a_knitter_i_am);
        if(Auth::user()->profile){
        $send = Auth::user()->profile->where('user_id',Auth::user()->id)->update($array);
        }else{
        $profile = new Userprofile;
        $profile->user_id = Auth::user()->id;
        $profile->as_a_knitter_i_am = $request->as_a_knitter_i_am;
        //$profile->rate_yourself = $request->rate_yourself;
        $send = $profile->save();
        }

        if($send){
            return response()->json(['success' => 'Skill sets added!']);
        }else{
            return response()->json(['error' => 'Unable to add, Try again after sometime.']);
        }
    }

    function profile_getInterest(Request $request){
        return view('connect.profile.show-interest');
    }

    function profile_editInterest(Request $request){
        return view('connect.profile.edit-interest');
    }

    function profile_addInterest(Request $request){

        $a = implode(',', $request->i_knit_for);
        $b = implode(',', $request->i_am_here_for);

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
            return response()->json(['success' => 'Interests added successfully.']);
        }else{
            return response()->json(['error' => 'Unable to add, Try again after sometime.']);
        }
    }

    function profile_getDetails(Request $request){
        return view('connect.profile.show-details');
    }

    function profile_editDetails(Request $request){
        return view('connect.profile.edit-details');
    }

    function profile_addDetails(Request $request){

        //echo '<pre>';
        //print_r($request->all());
        //echo '</pre>';
        //exit;

        $validator = $request->validate([
                'first_name' => 'required|alpha|min:2|max:15',
                'last_name' => 'required|alpha|min:2|max:15'
            ]);

        $mobile = Auth::user()->settings->where('name','mobile_privacy')->count();
        $email = Auth::user()->settings->where('name','email_privacy')->count();
        $address = Auth::user()->settings->where('name','address_privacy')->count();
        $website = Auth::user()->settings->where('name','website_privacy')->count();

        //echo $request->mobile_privacy.' - '.$email.' - '.$address.' - '.$website;
        //exit;

        $user = User::find(Auth::user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $save = $user->save();

        $array = array('website' => $request->website);
        Auth::user()->profile->where('user_id',Auth::user()->id)->update($array);


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
            return response()->json(['success' => 'Profile added successfully.']);
        }else{
            return response()->json(['error' => 'Unable to add, Try again after sometime.']);
        }
    }

    function user_gallery(){
        $timeline_images = TimelineImages::where('user_id',Auth::user()->id)->get();
        //$project_images = Projectimages::where('user_id',Auth::user()->id)->get();
		$project_images = Project::leftJoin('projects_images','projects.id','projects_images.project_id')
							->select('projects_images.*')
							->where('projects.is_deleted',0)
							->where('projects.user_id',Auth::user()->id)
							->get();
        return view('connect.connections.gallery',compact('timeline_images','project_images'));
    }

    function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

       return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
    }

    function profile_picture(Request $request){
        $image = $request->file('file');
            $fname = $this->clean($image->getClientOriginalName());
            $filename = time().'-'.$fname;
            $ext = $image->getClientOriginalExtension();

         $s3 = \Storage::disk('s3');
        //exit;
        $filepath = 'knitfit/'.$filename;

        if($ext == 'pdf'){
            $pu = $s3->put('/'.$filepath, file_get_contents($image),'public');
        }else{
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
        }

       if($pu){
        $user = User::find(Auth::user()->id);
        $user->picture = 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath;
        $user->save();

         return response()->json(['path' => 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath,'ext' => $ext]);
     }else{
        echo 'error';
     }

    }

    function friend_requests(Request $request){
        $skills = MasterList::where('type','skills')->get();
        $skill_level = MasterList::where('type','skill_level')->get();
        $sentfriend_requests = Friendrequest::where('friend_request.user_id',Auth::user()->id)->get();
        $myfriend_requests = Friendrequest::where('friend_request.friend_id',Auth::user()->id)->where('user_id','!=',649)->get();
        return view('connect.connections.friend-requests',compact('skills','skill_level','sentfriend_requests','myfriend_requests'));
    }
	
	 function checkTimelinePostsFriendsAdd($user_id,$friend_id){

        //echo $user_id.' - '.$friend_id;

        
        $timeline = Timeline::where('user_id',$user_id)->where('privacy','friends')->get();
        if($timeline->count() > 0){
            
        for ($i=0; $i < count($timeline); $i++) { 
            $tuser_id = $timeline[$i]->user_id;
            $timeline_id = $timeline[$i]->id;
            $friend_id = $friend_id;

            //echo 'Line 1 : '.$tuser_id.' - '.$timeline_id.' - '.$friend_id.'<br>';

            $array[] = [
                'user_id' => $tuser_id,
                'timeline_id' => $timeline_id,
                'show_user_id' => $friend_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

       
        foreach ($array as $da) {
            //echo 'Line 1 : '.$user_id.' - '.$da['timeline_id'].' - '.$friend_id.'<br>';
            TimelineShowPosts::insert($da);
        }

    }

      // exit;

        $timeline1 = Timeline::where('user_id',$friend_id)->where('privacy','friends')->get();

    if($timeline1->count() > 0){
        for ($j=0; $j < count($timeline1); $j++) { 
            $tuser_id1 = $timeline1[$j]->user_id;
            $timeline_id1 = $timeline1[$j]->id;


            //echo 'Line 2 : '.$tuser_id1.' - '.$timeline_id1.' - '.$user_id.'<br>';

            $array1[] = [
                'user_id' => $tuser_id1,
                'timeline_id' => $timeline_id1,
                'show_user_id' => $user_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        foreach ($array1 as $da1) {
            //echo 'Line 2 : '.$friend_id.' - '.$da1['timeline_id'].' - '.$user_id.'<br>';
            TimelineShowPosts::insert($da1);
        }

    }
        
    }


    function deleteTimelinePostsFriendsAdd($user_id,$friend_id){
        $timeline = Timeline::where('user_id',$user_id)->where('privacy','friends')->get();
        $timeline1 = Timeline::where('user_id',$friend_id)->where('privacy','friends')->get();
        if($timeline->count() > 0){
            for ($i=0; $i < count($timeline); $i++) { 
            TimelineShowPosts::where('user_id',$user_id)->where('timeline_id',$timeline[$i]->id)->where('show_user_id',$friend_id)->delete();
            }
        }

        if($timeline1->count() > 0){
             for ($j=0; $j < count($timeline1); $j++) { 
            TimelineShowPosts::where('user_id',$friend_id)->where('timeline_id',$timeline1[$j]->id)->where('show_user_id',$user_id)->delete();
        }
        }
    }

    function checkTimelinePostsFollowersAdd($user_id,$follow_user_id){
        $timeline = Timeline::where('user_id',$follow_user_id)->where('privacy','followers')->get();
        if($timeline->count() == 0){
            return;
        }
        for ($i=0; $i < count($timeline); $i++) { 
            $tuser_id = $timeline[$i]->user_id;
            $timeline_id = $timeline[$i]->id;

            $array[] = [
                'user_id' => $tuser_id,
                'timeline_id' => $timeline_id,
                'show_user_id' => $user_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }
        //$data = array_chunk($array, 100);
        foreach ($array as $da) {
            TimelineShowPosts::insert($da);
        }
    }

    function deleteTimelinePostsfollowersAdd($follow_user_id,$user_id){
        $timeline = Timeline::where('user_id',$follow_user_id)->where('privacy','followers')->get();
        if($timeline->count() == 0){
            return;
        }
        for ($i=0; $i < count($timeline); $i++) { 
            TimelineShowPosts::where('user_id',$follow_user_id)->where('timeline_id',$timeline[$i]->id)->where('show_user_id',$user_id)->delete();
        }
    }

}
