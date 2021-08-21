<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FeedbackReplies;

class FeedbackRepliesImages extends Model
{
    protected $table = 'feedback_replies_images';
	
	public function feedbackReplies()
    {
        return $this->belongsTo(FeedbackReplies::class);
    }
}
