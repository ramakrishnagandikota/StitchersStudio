<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class ProductComments extends Model
{
    protected $table = 'product_comments';

    public function products(){
    	return $this->belongsTo('App\Models\Products');
    }
}
