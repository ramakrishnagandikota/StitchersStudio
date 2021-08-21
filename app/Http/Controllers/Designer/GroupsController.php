<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\Follow;
use App\Models\Friends;
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
use App\User;
use App\Models\Products;
use App\Models\Product_images;
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
use App\Models\GroupFaqCategory;
use App\Models\DesignerBroadcast;
use App\Notifications\sendGroupRequestNotification;
use App\Notifications\SendGroupBroadcastMessage;
use App\Notifications\SendGroupBroadcastMessageToUsers;
use App\Models\GroupCategory;


class GroupsController extends Controller
{
    function __construct(){
        $this->middleware(['auth']);
    }

    function get_group_categories(Request $request){
        $jsonArray = array();
        $category = GroupCategory::where('user_id',Auth::user()->id)->get();
        $count = $category->count();
        $count1 = $category->count() + 1;

        if($category->count() > 0){
            for ($i=0;$i<$category->count();$i++){
                $jsonArray[$i]['id'] = $category[$i]->category_name;
                $jsonArray[$i]['text'] = $category[$i]->category_name;
            }
        }
        $jsonArray[$count]['id'] = 'Test knitter group';
        $jsonArray[$count]['text'] = 'Test knitter group';
        $jsonArray[$count1]['id'] = 'Knit along';
        $jsonArray[$count1]['text'] = 'Knit along';
        return response()->json(['results' => $jsonArray]);
    }

    function get_all_group_categories(Request $request){
        $category = GroupCategory::where('user_id',Auth::user()->id)->get();
        return view('Designer.Groups.categories',compact('category'));
    }

    function group_add_categories(){
        return view('Designer.Groups.add-category');
    }

    function group_save_categories(Request $request){
        $request->validate([
            'categoryName' => 'required'
        ]);
        try{
            $check = GroupCategory::where('user_id',Auth::user()->id)->where('category_name',$request->categoryName)->count();
            if($check > 0){
                return response()->json(['status' => 'fail','message' => 'This group type was already created.']);
                exit;
            }

            $category = new GroupCategory;
            $category->user_id = Auth::user()->id;
            $category->category_name = $request->categoryName;
            $category->ipaddress = $request->ip();
            $category->created_at = Carbon::now();
            $save = $category->save();
            if($save){
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'fail','message' => 'Unable to create group.']);
            }
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function group_categories_update(Request $request){
        $request->validate([
            'pk' => 'required',
            'value' => 'required'
        ]);

        try{
            $check = GroupCategory::where('category_name',$request->value)->count();
            if($check > 0){
                return response()->json(['status' => 'fail','message' => 'This group name was already created.']);
                exit;
            }
            $cat = GroupCategory::find($request->pk);
            $cat->category_name = $request->value;
            $save = $cat->save();
            if($save){
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'error']);
            }
        }catch (\Throwable $e){
            return response()->json(['status' => 'success']);
        }
    }

    function delete_group_category(Request $request){
        $request->validate([
            'id' => 'required'
        ]);
        $gc = GroupCategory::where('id',$request->id)->first();
        $check = Group::where('group_type',$gc->category_name)->count();
        if($check > 0){
            return response()->json(['status' => 'fail','message' => 'Unable to delete category, There are FAQ`s added to this category.']);
            exit;
        }

        $cat = GroupCategory::find($request->id);
        $save = $cat->delete();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail','message' => 'Unable to delete this category']);
        }
    }

    function index(Request $request){
        if($request->ajax()){
            $jsonArray = array();
            $groups = Group::where('user_id',Auth::user()->id)->where('is_deleted',0)->get();
            for($i=0;$i<$groups->count();$i++){
                if($groups[$i]->product_id != 0 || $groups[$i]->product_id != ''){
                    $product = Products::where('id',$groups[$i]->product_id)->first();
                    $product_name = $product->product_name;
                }else{
                    $product_name = '-';
                }
                
                $groupUserCount = GroupUser::where('group_id',$groups[$i]->id)->where('user_type','Member')->count();

                $jsonArray[$i]['group_name'] = '<a href="'.url("designer/groups/".$groups[$i]->unique_id."/show").'" class="underline">'.$groups[$i]->group_name.'</a>';
                $jsonArray[$i]['pattern_name'] = $product_name;
                $jsonArray[$i]['group_type'] = $groups[$i]->group_type;
                $jsonArray[$i]['date_created'] = date('F d, Y',strtotime($groups[$i]->start_date));
                $jsonArray[$i]['date_ended'] = date('F d, Y',strtotime($groups[$i]->end_date));
                $jsonArray[$i]['no_of_members'] = $groupUserCount;
                $jsonArray[$i]['status'] = ($groups[$i]->status == 1) ? '<label class="label label-success">Active</label>' : '<label class="label label-danger">Inactive</label>';
                $jsonArray[$i]['action'] = '<a href="'.url('designer/groups/'.$groups[$i]->unique_id.'/edit').'" class="fa fa-pencil"></a> | <a href="javascript:;" class="fa fa-trash delete-btn deleteGroup" data-id="'.$groups[$i]->unique_id.'"></a>';
            }
            return response()->json(['data' => $jsonArray]);
        }
        return view('Designer.Groups.index');
    }

    function create_group(Request $request){
        $products = Products::where('designer_name',Auth::user()->id)->get();
        return view('Designer.Groups.create',compact('products'));
    }

    function getProductImage(Request $request){
        $product_id = $request->product_id;
        $productImages = Product_images::where('product_id',$product_id)->first();
        if($productImages){
            return response()->json(['status' => true,'image' => $productImages->image_small]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    function save_group(Request $request){

        $request->validate([
            'group_name' => 'required',
            'group_type' => 'required',
            'group_description' => 'required',
            'expertise_level' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $group = new Group;
        $group->unique_id = time();
        $group->user_id = Auth::user()->id;
        $group->group_name = $request->group_name;
        $group->product_id = $request->product_name;
        $group->group_type = $request->group_type;
        $group->group_description = $request->group_description;
        $group->expertise_level = $request->expertise_level;
        $group->start_date = $request->start_date;
        $group->end_date = $request->end_date;
        if(isset($request->group_image)){
            $group->group_image = $request->group_image;
        }else{
            if($request->product_id){
                $group->group_image = $request->product_image;
            }else{
                $group->group_image = '';
            }
        }
        $group->ipaddress = $request->ip();
        $save = $group->save();
        if($save){
            $gu = new GroupUser;
            $gu->group_id = $group->id;
            $gu->user_id = Auth::user()->id;
            $gu->user_type = 'Admin';
            $gu->ipaddress = $request->ip();
            $gu->save();
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function show_group(Request $request){
        $id = $request->id;
        $group = Group::where('unique_id',$id)->first();
        $users = GroupUser::leftJoin('users','users.id','group_users.user_id')
                ->select('group_users.id','users.id as uid','users.first_name','users.last_name','users.email')
                ->where('group_users.group_id',$group->id)->where('user_type','Member')->get();
        $jsonArray = array();
        if($request->ajax()){

            for ($i=0;$i<$users->count();$i++){
                $j = $i+1;
                $user = User::find($users[$i]->uid);
                $jsonArray[$i]['id'] = '<div class="custom-control custom-checkbox collection-filter-checkbox"><input type="checkbox" class="custom-control-input main-checkbox" id="main-checkbox'.$j.'" name="checkbox[]" value="'.$users[$i]->id.'"><label class="custom-control-label" for="main-checkbox'.$j.'"></label></div>';
                $jsonArray[$i]['name'] = $users[$i]->first_name.' '.$users[$i]->last_name;
                $jsonArray[$i]['email'] = $users[$i]->email;
                if($user->hasRole('Knitter') && $user->hasRole('Designer')){
                    $jsonArray[$i]['user_role'] = 'Knitter,Designer';
                }else if($user->hasRole('Knitter')){
                    $jsonArray[$i]['user_role'] = 'Knitter';
                }else if($user->hasRole('Designer')){
                    $jsonArray[$i]['user_role'] = 'Designer';
                }else{
                    $jsonArray[$i]['user_role'] = 'No Role';
                }
                $jsonArray[$i]['action'] = '<a href="javascript:;" data-id="'.$users[$i]->id.'" title="Remove user from group" class="fa fa-trash delete-btn deleteUser"></a>';
            }
            return response()->json(['data' => $jsonArray]);
        }

        return view('Designer.Groups.members',compact('id','users','group'));
    }

    function edit_group(Request $request){
        $id = $request->id;
        $products = Products::where('designer_name',Auth::user()->id)->get();
        $group = Group::where('unique_id',$id)->first();
        $category = GroupCategory::where('user_id',Auth::user()->id)->get();
        return view('Designer.Groups.edit',compact('products','group','category'));
    }

    function update_group(Request $request){
        $request->validate([
            'group_name' => 'required',
            'group_type' => 'required',
            'group_description' => 'required',
            'expertise_level' => 'required',
            'start_date' => 'required',
            'end_date' => 'required'
        ]);

        $group = Group::find($request->id);
        $group->group_name = $request->group_name;
        $group->product_id = $request->product_name;
        $group->group_type = $request->group_type;
        $group->group_description = $request->group_description;
        $group->expertise_level = $request->expertise_level;
        $group->start_date = $request->start_date;
        $group->end_date = $request->end_date;
        $group->updated_ipaddress = $request->ip();
        $save = $group->save();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function delete_group(Request $request){
        $request->validate([
            'id' => 'required'
        ]);
        $array = array('status' => 0,'is_deleted' => 1,'deleted_at' => Carbon::now(),'deleted_ipaddress' => $request->ip());
        $uniqueId = $request->id;
        $delete = Group::where('unique_id',$uniqueId)->update($array);
        if($delete){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }
    /* Broadcast message */

    function broadcast_message(Request $request){
        $broadcast = DesignerBroadcast::where('user_id',Auth::user()->id)->get();
        if($request->ajax()){
            $jsonArray = array();
            for ($i=0;$i<$broadcast->count();$i++){
                $group = Group::where('id',$broadcast[$i]->group_id)->first();

                $jsonArray[$i]['title'] = $broadcast[$i]->title;
                $jsonArray[$i]['description'] = Str::limit($broadcast[$i]->description,40,'...');
                $jsonArray[$i]['notification_type'] = ($broadcast[$i]->notification_type == 'invitation') ? 'Invitation' : 'Broadcast';
                if($group){
                    $jsonArray[$i]['group_name'] = $group->group_name;
                }else{
                    $jsonArray[$i]['group_name'] = '-';
                }
                $jsonArray[$i]['send_message_to'] = $broadcast[$i]->send_message_to;
                $jsonArray[$i]['sent_at'] = $broadcast[$i]->created_at->diffForHumans();
                $jsonArray[$i]['action'] = '<a href="javascript:;" style="text-decoration:underline;" data-id="'.$broadcast[$i]->id.'" class="viewMessage">View</a>';
            }
            return response()->json(['data' => $jsonArray]);
        }
        $products = Products::where('designer_name',Auth::user()->id)->get();
        $groups = Group::where('user_id',Auth::user()->id)->get();
        return view('Designer.Groups.broadcast',compact('products','groups'));
    }

    public function openBroadcastMessage(Request $request){
        $id = $request->id;
        $broadcast = DesignerBroadcast::where('id',$id)->first();
        $groups = Group::where('id',$broadcast->group_id)->first();
        return view('Designer.Groups.open-broadcast',compact('broadcast','groups'));
    }

    function sendInvitation(Request $request){
        if($request->send_invite_to == 'pattern-groups'){
            $request->validate([
                'send_invite_to' => 'required',
                'groups_id' => 'required',
                'title' => 'required',
                'message' => 'required'
            ]);
        }else{
            $request->validate([
                'send_invite_to' => 'required',
                'title' => 'required',
                'message' => 'required'
            ]);
        }

    
        $usersArray = array();
        $usersArray1 = array();

        if($request->send_invite_to == 'friends'){
            $friends = Friends::where('user_id',Auth::user()->id)->get();
            foreach ($friends as $friend){
                array_push($usersArray,$friend->friend_id);
            }
        }else if($request->send_invite_to == 'followers'){
            $follow = Follow::where('user_id',Auth::user()->id)->get();
            foreach ($follow as $fol){
                array_push($usersArray,$fol->follow_user_id);
            }
        }else if($request->send_invite_to == 'frineds_followers'){
            $friends = Friends::where('user_id',Auth::user()->id)->get();
            $follow = Follow::where('user_id',Auth::user()->id)->get();
            foreach ($friends as $friend){
                array_push($usersArray,$friend->friend_id);
            }
            foreach ($follow as $fol){
                array_push($usersArray,$fol->follow_user_id);
            }
            $usersArray = array_unique($usersArray);
        }else if($request->send_invite_to == 'pattern-groups'){
            for ($i=0;$i< count($request->groups_id);$i++){
                $groupUsers = GroupUser::where('group_id',$request->groups_id[$i])->where('user_type','Member')->get();
                foreach ($groupUsers as $group){
                    array_push($usersArray,$group->user_id);
                }
            }
            $usersArray = array_unique($usersArray);
        }else if($request->send_invite_to == 'individuals'){
            $emails = $request->individual_emails;
            for($i=0;$i<count($request->individual_emails);$i++){
                $email = $request->individual_emails[$i];
                $user = User::where('email',$email)->first();
                if($user){
                    array_push($usersArray,$user->id);
                }else{
                    array_push($usersArray1,$request->individual_emails[$i]);
                }
            }
            $usersArray = array_unique($usersArray);
        }

        $db = new DesignerBroadcast;
        $db->user_id = Auth::user()->id;
        $db->group_id = $request->send_message_about;
        $db->notification_type = $request->notification_type;
        $db->send_message_to = $request->send_invite_to;
        if($request->groups_id){
            $db->pattern_groups = implode(',',$request->groups_id);
        }
        if($request->send_invite_to == 'individuals'){
            $db->individual_emails = implode(',', $request->individual_emails);
            $db->individual_emails_outside = implode(',', $usersArray1);
        }
        $db->title = $request->title;
        $db->description = $request->message;
        $db->ipaddress = $request->ip();
        $save = $db->save();


        $group = Group::where('id',$request->send_message_about)->first();


        for ($j=0;$j<count($usersArray);$j++){
            $groupUsersCount = GroupUser::where('group_id',$request->send_message_about)->where('user_id',$usersArray[$j])->count();
            if($groupUsersCount == 0){
                $gr = new GroupRequest;
                $gr->group_id = $request->send_message_about;
                $gr->group_user_id = Auth::user()->id;
                $gr->user_id = $usersArray[$j];
                $gr->ipaddress = $request->ip();
                $gr->save();

            $broadcast = array('group_id' => $group->id,'group_name' => $group->group_name,'title' => $request->title,'message' => $request->message,'requestSentBy' => Auth::user()->first_name.' '.Auth::user()->last_name,'requestSentById' => Auth::user()->id,'designerBroadcastId'=> $db->id ,'groupRequestId' => $gr->id,'created_at' => Carbon::now(),'ipaddress' => $request->ip());

            $user = User::find($usersArray[$j]);
            $user->notify(new sendGroupRequestNotification($broadcast));
            }
            
        }
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function sendGroupBroadcastMssage(Request $request){

        if($request->send_message_to == 'pattern-groups'){
            $request->validate([
                'send_message_to' => 'required',
                'groups_id' => 'required',
                'title' => 'required',
                'message' => 'required'
            ]);
        }else{
            $request->validate([
                'send_message_to' => 'required',
                'title' => 'required',
                'message' => 'required'
            ]);
        }

        $usersArray = array();
        $usersArray1 = array();

        if($request->send_message_to == 'friends'){
            $friends = Friends::where('user_id',Auth::user()->id)->get();
            foreach ($friends as $friend){
                array_push($usersArray,$friend->friend_id);
            }
        }else if($request->send_message_to == 'followers'){
            $follow = Follow::where('user_id',Auth::user()->id)->get();
            foreach ($follow as $fol){
                array_push($usersArray,$fol->follow_user_id);
            }
        }else if($request->send_message_to == 'frineds_followers'){
            $friends = Friends::where('user_id',Auth::user()->id)->get();
            $follow = Follow::where('user_id',Auth::user()->id)->get();
            foreach ($friends as $friend){
                array_push($usersArray,$friend->friend_id);
            }
            foreach ($follow as $fol){
                array_push($usersArray,$fol->follow_user_id);
            }
            $usersArray = array_unique($usersArray);
        }else if($request->send_message_to == 'pattern-groups'){
            for ($i=0;$i< count($request->groups_id);$i++){
                $groupUsers = GroupUser::where('group_id',$request->groups_id[$i])->where('user_type','Member')->get();
                foreach ($groupUsers as $group){
                    array_push($usersArray,$group->user_id);
                }
            }
            $usersArray = array_unique($usersArray);
        }else if($request->send_invite_to == 'individuals'){
            $emails = $request->individual_emails;
            for($i=0;$i<count($request->individual_emails);$i++){
                $email = $request->individual_emails[$i];
                $user = User::where('email',$email)->first();
                if($user){
                    array_push($usersArray,$user->id);
                }else{
                    array_push($usersArray1,$request->individual_emails[$i]);
                }
            }
            $usersArray = array_unique($usersArray);
        }

        $db = new DesignerBroadcast;
        $db->user_id = Auth::user()->id;
        $db->notification_type = $request->notification_type;
        $db->send_message_to = $request->send_message_to;
        if($request->groups_id){
            $db->pattern_groups = implode(',',$request->groups_id);
        }
        if($request->send_invite_to == 'individuals'){
            $db->individual_emails = implode(',', $request->individual_emails);
            $db->individual_emails_outside = implode(',', $usersArray1);
        }
        $db->title = $request->title;
        $db->description = $request->message;
        $db->ipaddress = $request->ip();
        $save = $db->save();

        for ($j=0;$j<count($usersArray);$j++){
            $broadcast = array('title' => $request->title,'message' => $request->message,'requestSentBy' => Auth::user()->first_name.' '.Auth::user()->last_name,'requestSentById' => Auth::user()->id,'created_at' => Carbon::now(),'ipaddress' => $request->ip());

            $user = User::find($usersArray[$j]);
            $user->notify(new SendGroupBroadcastMessage($broadcast));
        }
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function broadcastmsgToUsers(Request $request){
        $request->validate([
            'user_id' => 'required',
            'group_id' => 'required',
            'title' => 'required',
            'message' => 'required'
        ]);

        try{
            $group = Group::where('id',$request->group_id)->first();
            for ($i=0;$i<count($request->user_id);$i++){
                $gn = new GroupNotification;
                $gn->group_user_id = Auth::user()->id;
                $gn->group_id = $request->group_id;
                $gn->user_id = $request->user_id[$i];
                $gn->title = $request->title;
                $gn->description = $request->message;
                $gn->ipaddress = $request->ip();
                $gn->save();

                $broadcast = array('group_id' => $request->group_id,'group_name' => $group->group_name,'title' => $request->title,'message' => $request->message,'requestSentBy' => Auth::user()->first_name.' '.Auth::user()->last_name,'requestSentById' => Auth::user()->id,'messageSentTo' => $request->user_id[$i],'created_at' => Carbon::now(),'ipaddress' => $request->ip());

                $user = User::find($request->user_id[$i]);
                $user->notify(new SendGroupBroadcastMessageToUsers($broadcast));
            }
            return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }

    }

    function deleteGroupUser(Request $request){
        $request->validate([
            'id' => 'required|numeric'
        ]);
        try{
            $groupUser = GroupUser::find($request->id);
            $groupUser->delete();
            return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function getGroupInformation(Request $request){
        $request->validate([
            'groupId' => 'required',
            'groupRequestId' => 'required'
        ]);
        try{
            $groupId = base64_decode($request->groupId);
            $group = Group::where('id',$groupId)->first();
            if($group){
                $members = GroupUser::where('group_id',$group->id)->where('user_type','Member')->count();
                $designerInvitation = DesignerBroadcast::where('id',$request->designerBroadcastId)->first();
				
				if($group->group_image != ''){
					$groupImage = $group->group_image;
				}else{
					if($group->product_id){
						$productImage = Product_images::where('product_id',$designerInvitation->product_id)->first();
                        if($productImage){
                            $groupImage = $productImage->image_small;    
                        }else{
                            $groupImage = asset('resources/assets/files/assets/images/knit-along.png');
                        }
					}else{
						$groupImage = asset('resources/assets/files/assets/images/knit-along.png');
					}
				}
                return response()->json(['status' => 'success','group_name' => $group->group_name,'description' => $group->group_description,'unique_id' => $group->unique_id,'expertise_level' => $group->expertise_level,'start_date' => $group->start_date,'members' => $members,'title' => $designerInvitation->title,'message' => $designerInvitation->description,'groupImage' => $groupImage]);
            }else{
                return response()->json(['status' => 'fail','message' => 'The group id is invalid.']);
            }
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function ignoreGroupInvitationequest(Request $request){

        $request->validate([
            'id' => 'required'
        ]);

        try{
            $id = $request->id;
            $designerInvitation = GroupRequest::find($id);
            $designerInvitation->status = 0;
            $designerInvitation->save();
            return response()->json(['status' => 'success']);
        
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function acceptGroupInvitationequest(Request $request){

        $request->validate([
            'groupId' => 'required',
            'groupRequestId' => 'required'
        ]);

        try{
            $gr = GroupRequest::find($request->groupRequestId);
            $save = $gr->delete();

            if($save){
                $gm = new GroupUser;
                $gm->group_id = base64_decode($request->groupId);
                $gm->user_id = Auth::user()->id;
                $gm->user_type = 'Member';
                $gm->ipaddress = $request->ip();
                $gm->save();
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'fail','message' => 'Unable to add you to group']);
            }
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    /* groups faq */

    function show_group_faq(Request $request){

        $id = $request->id;
        $group = Group::where('unique_id',$id)->first();
        $faqs = GroupFaq::where('group_id',$group->id)->orderBy('id','DESC')->paginate(10);
        $categories = GroupFaqCategory::where('group_id',$group->id)->where('user_id',Auth::user()->id)->orderBy('id','DESC')->take(2)->get();
        if ($request->ajax()) {
            return view('Designer.Groups.Faq.faqs', compact('faqs'));
        }
        return view('Designer.Groups.Faq.index',compact('group','categories'));
    }

    function getFaqCategories(Request $request){
        $groupCategory = GroupFaqCategory::where('group_id',$request->id)->where('user_id',Auth::user()->id)->get();
        return view('Designer.Groups.Faq.Category.index',compact('groupCategory'));
    }

    function add_group_faq_category(Request $request){
        $id = $request->id;
        $group = Group::where('id',$id)->first();
        return view('Designer.Groups.Faq.Category.add',compact('group'));
    }

    function create_group_faq_category(Request $request){
        $request->validate([
            'group_id' => 'required',
            'categoryName' => 'required'
        ]);
        try{
            $group_id = base64_decode($request->group_id);
            $check = GroupFaqCategory::where('group_id',$group_id)->where('user_id',Auth::user()->id)->where('category_name',$request->categoryName)->count();
            if($check > 0){
                return response()->json(['status' => 'fail','message' => 'This group name was already created.']);
                exit;
            }

            $category = new GroupFaqCategory;
            $category->user_id = Auth::user()->id;
            $category->group_id = $group_id;
            $category->category_name = $request->categoryName;
            $category->ipaddress = $request->ip();
            $category->created_at = Carbon::now();
            $save = $category->save();
            if($save){
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'fail','message' => 'Unable to create group.']);
            }
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function categories_update(Request $request){
        $request->validate([
            'pk' => 'required',
            'value' => 'required'
        ]);

        try{
            $check = GroupFaqCategory::where('category_name',$request->value)->count();
            if($check > 0){
                return response()->json(['status' => 'fail','message' => 'This group name was already created.']);
                exit;
            }
            $cat = GroupFaqCategory::find($request->pk);
            $cat->category_name = $request->value;
            $save = $cat->save();
            if($save){
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'error']);
            }
        }catch (\Throwable $e){
            return response()->json(['status' => 'success']);
        }
    }

    function delete_group_faq_category(Request $request){
        $request->validate([
            'id' => 'required'
        ]);
        $check = GroupFaq::where('faq_category_id',$request->id)->count();
        if($check > 0){
            return response()->json(['status' => 'fail','message' => 'Unable to delete category, There are FAQ`s added to this category.']);
            exit;
        }

        $cat = GroupFaqCategory::find($request->id);
        $save = $cat->delete();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail','message' => 'Unable to delete this category']);
        }
    }

    function getGroupsFAQCategoriesSideMenu(Request $request){
        //$group = Group::where('id',$request->id)->first();
        $categories = GroupFaqCategory::where('group_id',$request->id)->orderBy('id','DESC')->take(2)->get();
        return view('Designer.Groups.Faq.faqSideMenu',compact('categories'));
    }

    function get_all_group_faq_categories(Request $request){
        $jsonArray = array();
        $category = GroupFaqCategory::all();
        for ($i=0;$i<$category->count();$i++){
            $jsonArray[$i]['id'] = $category[$i]->id;
            $jsonArray[$i]['text'] = $category[$i]->category_name;
        }
        return response()->json(['results' => $jsonArray]);
    }

    function saveFAQ(Request $request){
        $request->validate([
            'group_id' => 'required',
            'faq_title' => 'required',
            'faq_category_id' => 'required',
            'faq_description' => 'required'
        ]);

        try{
            $group_id = base64_decode($request->group_id);

            $faq = new GroupFaq;
            $faq->group_id = $group_id;
            $faq->user_id =Auth::user()->id;
            $faq->faq_unique_id = time();
            $faq->faq_category_id = $request->faq_category_id;
            $faq->faq_title = $request->faq_title;
            $faq->faq_description = $request->faq_description;
            $faq->ipaddress= $request->ip();
            $save = $faq->save();
            if($save){
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'fail','message' => 'Unable to save faq, Try again after sometime.']);
            }
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function edit_group_faq(Request $request){
        $request->validate([
            'id' => 'required'
        ]);

        $faq = GroupFaq::where('faq_unique_id',$request->id)->first();
        $category = GroupFaqCategory::where('group_id',$faq->group_id)->get();
        return view('Designer.Groups.Faq.edit',compact('faq','category'));
    }

    function update_group_faq(Request $request){
        $request->validate([
            'faq_id' => 'required',
            'faq_title' => 'required',
            'faq_category_id' => 'required',
            'faq_description' => 'required'
        ]);
        try{
            $faq = GroupFaq::find($request->faq_id);
            $faq->faq_category_id = $request->faq_category_id;
            $faq->faq_title = $request->faq_title;
            $faq->faq_description = $request->faq_description;
            $save = $faq->save();
            if($save){
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'fail','message' => 'Unable to save faq, Try again after sometime.']);
            }
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function delete_group_faq(Request $request){
        $request->validate([
            'id' => 'required'
        ]);
        try{
            $delete = GroupFaq::where('faq_unique_id',$request->id)->delete();
            if($delete){
                return response()->json(['status' => 'success']);
            }else{
                return response()->json(['status' => 'fail','message' => 'Unable to delete faq, Try again after sometime.']);
            }
        }catch (\Throwable $e){
            return response()->json(['status' => 'fail','message' => $e->getMessage()]);
        }
    }

    function group_faq_full_view(Request $request){
        $faq = GroupFaq::where('faq_unique_id',$request->id)->first();
        $group = Group::where('id',$faq->group_id)->first();
        $categories = GroupFaqCategory::where('group_id',$group->id)->orderBy('id','DESC')->take(2)->get();
        return view('Designer.Groups.Faq.faq-fullview',compact('faq','group','categories'));
    }

    /* community routes */
    function show_group_community(Request $request){
        $group = Group::where('unique_id',$request->group_id)->first();
        $timeline = GroupTimeline::leftJoin('users', 'users.id', 'group_timelines.user_id')
            ->select('group_timelines.*', 'users.id as uid', 'users.first_name', 'users.last_name', 'users.picture', 'users.username', 'users.email')
            ->where('group_timelines.status', 1)
            ->where('group_timelines.group_id',$group->id)
            ->orderBy('id','DESC')
            ->paginate(5);
        return view('Designer.Groups.Community.index',compact('group','timeline'));
    }

    function show_more(Request $request){
        $group_id = $request->group_id;
        $group = Group::where('id',$request->group_id)->first();
        $timeline = GroupTimeline::where('group_id',$group_id)->where('status',1)->orderBy('id','DESC')->take(2)->get();
        return view('Designer.Groups.Community.index',compact('timeline','group'));
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
        return view('Designer.Groups.Community.add-post',compact('friends','group'));
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
            return view('Designer.Groups.Community.index-dummy', compact('timeline', 'friends', 'follow'));
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
        return view('Designer.Groups.Community.edit-post',compact('timeline','timeline_images','friends','group'));
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
            return view('Designer.Groups.Community.index-dummy',compact('timeline','friends','follow'));
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
            return view('Designer.Groups.Community.comments',compact('com','i'));
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
            return view('Designer.Groups.Community.comments',compact('com','i'));
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
}
