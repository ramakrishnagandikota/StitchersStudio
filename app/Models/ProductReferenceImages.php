<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class ProductReferenceImages extends Model
{
    protected $table = 'product_reference_images';

    public function products(){
        return $this->belongsTo(Products::class);
    }
}
