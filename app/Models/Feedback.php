<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FeedbackImages;
use App\Models\FeedbackReplies;

class Feedback extends Model
{
    protected $table = 'feedback';

 	public function user()
    {
        return $this->belongsTo(User::class);
    }

    function feedbackImages(){
    	return $this->hasMany(FeedbackImages::class);
    }
	
	function feedbackReplies(){
    	return $this->hasMany(FeedbackReplies::class);
    }
}
