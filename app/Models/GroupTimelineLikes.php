<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTimelineLikes extends Model
{
    protected $table = 'group_timeline_likes';

    function timeline(){
        return $this->belongsTo(GroupTimeline::class);
    }
}
