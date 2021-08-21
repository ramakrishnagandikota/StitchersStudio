<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductNeedles extends Model
{
    protected $table = 'product_needles';

    public function products(){
        return $this->belongsTo(Products::class);
    }
}
