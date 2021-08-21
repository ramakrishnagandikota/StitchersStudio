<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Orders extends Model
{
    protected $table = 'orders';

    function users(){
    	$this->belongsTo(User::class);
    }
}
