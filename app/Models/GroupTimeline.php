<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTimeline extends Model
{

    protected $table = 'group_timelines';

    function comments(){
        return $this->hasMany(GroupTimelineComments::class);
    }

    function images(){
        return $this->hasMany(GroupTimelineImage::class);
    }

    function likes(){
        return $this->hasMany(GroupTimelineLikes::class);
    }

    function Commentlikes(){
        return $this->hasMany(GroupTimelineCommentLikes::class);
    }
}
