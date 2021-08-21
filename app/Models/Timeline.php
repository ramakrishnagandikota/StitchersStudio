<?php

namespace App\Models;
use Auth;
use App\User;
use App\Models\Timelinecomments;
use App\Models\TimelineImages;
use App\Models\Timelinelikes;
use App\Traits\PostLikableTrait;
use App\Traits\PostCommentableTrait;
use App\Traits\CommentLikableTrait;

use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
	use PostLikableTrait,PostCommentableTrait,CommentLikableTrait;

    protected $table = 'timeline';

      public function user()
    {
        return $this->belongsTo(User::class);
    }

    function comments(){
    	return $this->hasMany(Timelinecomments::class);
    }

    function images(){
    	return $this->hasMany(TimelineImages::class);
    }

    function likes(){
        return $this->hasMany(Timelinelikes::class);
    }

    function Commentlikes(){
        return $this->hasMany(Timelinelikes::class);
    }
}
