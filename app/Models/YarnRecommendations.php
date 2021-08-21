<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pattern;
use App\Models\YarnRecommendationImages;

class YarnRecommendations extends Model
{
    protected $table = 'p_pattern_yarn_recommendations';

    protected $guarded = [];

    public function patterns(){
        return $this->belongsTo(Pattern::class);
    }

    public function yarnImages(){
        return $this->hasMany(YarnRecommendationImages::class,'p_pattern_yarn_recommendation_id');
    }
}
