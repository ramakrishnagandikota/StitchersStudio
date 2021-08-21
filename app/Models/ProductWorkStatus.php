<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class ProductWorkStatus extends Model
{

    protected $table = 'product_work_status';

    public function products(){
        return $this->belongsTo(Products::class);
    }
}
