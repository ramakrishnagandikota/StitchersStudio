<?php

namespace App\Models\Patterns;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\Functions;

class Factor extends Model
{
    protected $table = 'p_factor';

    public function functions(){
        return $this->belongsToMany(Functions::class,'p_functions_factor','factor_id','functions_id');
    }
}
