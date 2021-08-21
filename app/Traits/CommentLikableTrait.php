<?php
namespace App\Traits;
use Auth;
use App\Models\TimelineCommentLikes;
use App\User;
use Carbon\Carbon;


trait CommentLikableTrait{

    public function Commentlike()
    {
        return $this->morphMany(TimelineCommentLikes::class,'likable')->latest();
    }

    public function addCommentLike($request){
        $like = new TimelineCommentLikes();
        $like->user_id = Auth::user()->id;
        $like->timeline_id = $request->timeline_id;
        $like->comment_id = $request->comment_id;
        $like->like = 1;
        $like->created_at = Carbon::now();
        $like->ipaddress = $_SERVER['REMOTE_ADDR'];

        $this->Commentlike()->save($like);

        return $like;
    }

}


