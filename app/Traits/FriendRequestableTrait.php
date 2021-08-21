<?php
namespace App\Traits;
use Auth;
use App\Models\Friendrequest;
use App\User;
use Carbon\Carbon;


trait FriendRequestableTrait{
    
    public function friendrequest()
    {
        return $this->morphMany(Friendrequest::class,'friendrequestable')->latest();
    }
    
    public function sendFriendRequest($request){
        $frequest = new Friendrequest();
        $frequest->user_id = Auth::user()->id;
        $frequest->friend_id = $request;
        $frequest->created_at = Carbon::now();
        $frequest->ipaddress = $_SERVER['REMOTE_ADDR'];
        
        $this->friendrequest()->save($frequest);
        
        return $frequest;
    }
    
}


