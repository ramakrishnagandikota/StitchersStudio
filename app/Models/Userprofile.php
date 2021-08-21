<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Userprofile extends Model
{
	protected $gaurded = [];

    protected $table = 'user_profile';

    protected $fillable = ['aboutme'];

    public function user(){
    	return $this->belongsTo(User::class);
    }

}
