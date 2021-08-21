<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserSkills extends Model
{
    protected $table = 'user_skills';

    function users(){
    	return $this->belongsTo(User::class);
    }
}
