<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $table = 'user_login';
	
	protected $fillable = [
		'device_type','ipaddress'
	];
}
