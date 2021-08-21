<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Product_images extends Model
{
    protected $table = 'product_images';

    public function products(){
    	return $this->belongsTo(Products::class);
    }
}
