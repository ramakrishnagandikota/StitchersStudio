<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserAddress extends Model
{
    protected $table = 'user_address';

    function users(){
        return $this->belongsTo(User::class);
    }
}
