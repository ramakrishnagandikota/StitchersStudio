<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use APP\month\Subscription;

class SubscriptionProperties extends Model
{
    protected $table = 'subscriptions_properties';



    public function subscription(){
    	return $this->belongsTo(Subscription::class);
    }
}
