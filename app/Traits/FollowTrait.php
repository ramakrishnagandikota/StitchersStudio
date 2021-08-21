<?php
namespace App\Traits;
use Auth;
use App\Models\Follow;
use App\User;
use Carbon\Carbon;


trait FollowTrait{
    
    public function followrequest()
    {
        return $this->morphMany(Follow::class,'followable')->latest();
    }
    
    public function sendFollowRequest($request){
        $follow = new Follow();
        $follow->user_id = Auth::user()->id;
        $follow->follow_user_id = $request->follow_user_id;
        $follow->created_at = Carbon::now();
        $follow->ipaddress = $_SERVER['REMOTE_ADDR'];
        
        $this->followrequest()->save($follow);
        
        return $follow;
    }
    
}


