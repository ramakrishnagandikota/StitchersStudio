<?php
namespace App\Traits;
use Auth;
use App\Models\Timelinelikes;
use App\User;
use Carbon\Carbon;


trait PostLikableTrait{
    
    public function like()
    {
        return $this->morphMany(Timelinelikes::class,'likable')->latest();
    }
    
    public function addLike($request){
        $like = new Timelinelikes();
        $like->user_id = Auth::user()->id;
        $like->timeline_id = $request->timeline_id;
        $like->like = 1;
        $like->created_at = Carbon::now();
        $like->ipaddress = $_SERVER['REMOTE_ADDR'];
        
        $this->like()->save($like);
        
        return $like;
    }
    
}


