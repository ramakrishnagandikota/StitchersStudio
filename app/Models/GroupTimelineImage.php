<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTimelineImage extends Model
{
    protected $table = 'group_timeline_images';

    function timeline(){
        return $this->belongsTo(GroupTimeline::class);
    }
}
