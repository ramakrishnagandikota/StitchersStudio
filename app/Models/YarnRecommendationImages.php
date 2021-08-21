<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\YarnRecommendations;

class YarnRecommendationImages extends Model
{
    protected $table = 'p_pattern_yarn_recommendation_images';

    protected $guarded = [];

    public function yarns(){
        return $this->belongsTo(YarnRecommendations::class);
    }
}
