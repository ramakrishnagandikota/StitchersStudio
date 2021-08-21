<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class ProductInstruction extends Model
{
    protected $table = 'product_instructions';

    public function products(){
        return $this->belongsTo(Products::class);
    }
}
