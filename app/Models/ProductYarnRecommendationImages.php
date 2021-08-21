<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductYarnRecommendationImages extends Model
{
    protected $table = 'product_yarn_recommendation_images';

    protected $guarded = [];

    public function yarns(){
        return $this->belongsTo(ProductYarnRecommendations::class);
    }
}
