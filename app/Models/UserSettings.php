<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserSettings extends Model
{
    protected $table = 'user_settings';

    protected $fillable = ['user_id'];

    function user(){
    	return $this->belongsTo(User::class);
    }
}
