<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductYarnRecommendationImages;

class ProductYarnRecommendations extends Model
{
    protected $table = 'product_yarn_recommendations';

    protected $gaurded = [];

    public function products(){
        return $this->belongsTo(Products::class);
    }

    public function yarnImages(){
        return $this->hasMany(ProductYarnRecommendationImages::class,'product_yarn_recommendation_id');
    }
}
