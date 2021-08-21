<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Traits\FollowTrait;

class Follow extends Model
{
	use FollowTrait;
	
    protected $table = 'follow';

    protected $fillable = ['user_id','friend_id','created_at','ipaddress'];
    
    function followrequest(){
        return $this->morphTo();
    }

    function user(){
    	return $this->belongsTo(User::class);
    }
}
