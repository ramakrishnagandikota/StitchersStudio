<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workprogress extends Model
{
    protected $table = 'work_progress';

    function get_my_images(){
    	$q = $this->hasMany('App\Models\Workimages');
    	$q->getQuery()->where('user_id',Auth::user()->id);
    	return $q;
    }
}
