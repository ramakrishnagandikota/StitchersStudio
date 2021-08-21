<?php
namespace App\Traits;
use Auth;
use App\Models\Timelinecomments;
use App\User;
use Carbon\Carbon;


trait PostCommentableTrait{
    
    public function comment()
    {
        return $this->morphMany(Timelinecomments::class,'commentable')->latest();
    }
    
    public function addComment($request){
        $comment = new Timelinecomments();
        $comment->user_id = Auth::user()->id;
        $comment->timeline_id = $request->timeline_id;
        $comment->comment =$request->comment;
        $comment->created_at = Carbon::now();
        $comment->ipaddress = $_SERVER['REMOTE_ADDR'];
        
        $this->comment()->save($comment);
        
        return $comment;
    }
    
}


