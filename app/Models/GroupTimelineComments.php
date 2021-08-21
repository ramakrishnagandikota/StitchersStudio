<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTimelineComments extends Model
{
    protected $table = 'group_timeline_comments';

    function timeline(){
        return $this->belongsTo(GroupTimeline::class);
    }

    function likes(){
        return $this->hasMany(GroupTimelineCommentLikes::class,'comment_id');
    }
}
