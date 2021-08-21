<?php

namespace App\Models;

use App\Models\Product_images;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductDesignerMeasurements;
use App\Models\ProductComments;
use App\Models\ProductYarnRecommendations;
use App\Models\ProductNeedles;
use App\Models\ProductInstruction;
use App\Models\ProductReferenceImages;
use App\Models\ProductWorkStatus;
use App\Models\ProductYarnQuantities;


class Products extends Model
{
    protected $table='products';

    public function comments(){
    	return $this->hasMany(ProductComments::class,'product_id')->latest();
    }

    public function images(){
    	return $this->hasMany(Product_images::class,'product_id');
    }

    public function yarnRecommmendations(){
        return $this->hasMany(ProductYarnRecommendations::class,'product_id');
    }

    public function needles(){
        return $this->hasMany(ProductNeedles::class,'product_id');
    }

    public function patternImages(){
        return $this->hasMany(Product_images::class,'product_id');
    }

    public function traditionalPatternpdf(){
        return $this->hasMany(ProductInstruction::class,'product_id');
    }
	
	public function patternInstructions(){
        return $this->hasMany(ProductInstruction::class,'product_id');
    }

	
	public function referenceImages(){
        return $this->hasMany(ProductReferenceImages::class,'product_id');
    }
	
	public function workStatus(){
        return $this->hasMany(ProductWorkStatus::class,'product_id');
    }

    public function yarnQuantities(){
        return $this->hasMany(ProductYarnQuantities::class,'product_id');
    }

}
