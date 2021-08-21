<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;

class FeedbackImages extends Model
{
    protected $table = 'feedback_images';

    public function feedback()
    {
        return $this->belongsTo(Feedback::class);
    }
}
