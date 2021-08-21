<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;
use App\Models\FeedbackRepliesImages;

class FeedbackReplies extends Model
{
    protected $table = 'feedback_replies';
	
	public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
	
	function feedbackRepliesImages(){
    	return $this->hasMany(FeedbackRepliesImages::class);
    }
}
