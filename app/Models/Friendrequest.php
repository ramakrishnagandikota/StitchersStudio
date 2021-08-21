<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\FriendRequestableTrait;
use App\User;

class Friendrequest extends Model
{
	use FriendRequestableTrait;

    protected $table = 'friend_request';

    protected $fillable = ['user_id','friend_id','created_at','ipaddress'];
    
    function friendrequest(){
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
