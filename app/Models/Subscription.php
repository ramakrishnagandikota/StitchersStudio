<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\SubscriptionProperties;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    public function user(){
    	return $this->belongsTo(User::class,'user_subscriptions','subscription_id','user_id');
    }

    public function subscriptionDetails(){
    	return $this->hasMany(SubscriptionProperties::class);
    }
}
