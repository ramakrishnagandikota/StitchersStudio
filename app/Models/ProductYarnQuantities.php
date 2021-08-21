<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductYarnQuantities extends Model
{

    protected $table = 'product_yarn_quantities';

    public function products(){
        return $this->belongsTo(Products::class);
    }
}
