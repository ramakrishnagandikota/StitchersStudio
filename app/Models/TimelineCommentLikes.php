<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Timelinecomments;

class TimelineCommentLikes extends Model
{
    protected $table = 'timeline_comment_likes';
    protected $fillable = ['user_id','timeline_id','comment_id','created_at','ipaddress'];

    public function likable()
    {
        return $this->morphTo();
    }

    function timeline(){
        $this->belongsTo(Timelinecomments::class,'comment_id');
    }
}
