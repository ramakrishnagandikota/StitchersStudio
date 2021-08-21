<?php

namespace App\Traits;
use Auth;
use App\Models\Friends;

trait FriendRequestAcceptableTrait
{
    public function friendrequestaccept()
    {
        return $this->morphMany(Friends::class,'friendrequestacceptable')->latest();
    }

    public function acceptRequest($request)
    {
        $friend = new Friends();
        $friend->user_id = Auth::user()->id;
        $friend->friend_id = $request->friend_id;
        $friend->ipaddress = $_SERVER['REMOTE_ADDR'];
        $this->friendrequestaccept()->save($friend);

        $friends = new Friends();
        $friends->friend_id = Auth::user()->id;
        $friends->user_id = $request->friend_id;
        $friends->ipaddress = $_SERVER['REMOTE_ADDR'];
        $this->friendrequestaccept()->save($friends);

        return $friend;
    }
}
