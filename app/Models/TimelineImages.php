<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Timeline;

class TimelineImages extends Model
{
    protected $table = 'timeline_images';

    function timeline(){
    	return $this->belongsTo(Timeline::class);
    }
}
