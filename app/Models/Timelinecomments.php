<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Timeline;
use App\Traits\PostCommentableTrait;
use App\Models\TimelineCommentLikes;
use App\Traits\CommentLikableTrait;
use App\User;

class Timelinecomments extends Model
{
	use PostCommentableTrait,CommentLikableTrait;

    protected $fillable = ['user_id','timeline_id','comment','created_at','ipaddress'];
    protected $table = 'timeline_comments';

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    function timeline(){
        $this->belongsTo(Timeline::class);
    }

    function likes(){
        return $this->hasMany(TimelineCommentLikes::class,'comment_id');
    }
}
