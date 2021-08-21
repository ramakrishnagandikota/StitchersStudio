<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTimelineCommentLikes extends Model
{
    protected $table = 'group_timeline_comment_likes';

    function timeline(){
        return $this->belongsTo(GroupTimeline::class);
    }

    function comments(){
        $this->belongsTo(GroupTimelineComments::class,'comment_id');
    }

}
