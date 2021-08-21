<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Traits\FriendRequestAcceptableTrait;

class Friends extends Model
{
	use FriendRequestAcceptableTrait;
	
    protected $table = 'friends';

    protected $fillable = ['user_id','friend_id'];

    public function friendrequestacceptable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
