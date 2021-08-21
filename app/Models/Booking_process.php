<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Orders;
use App\Models\User;

class Booking_process extends Model
{
    protected $table = 'booking_process';

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function order(){
    	return $this->belongsTo(Orders::class);
    }
}
