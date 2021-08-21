<?php

namespace App\Models\Patterns;

use App\Models\Patterns\Functions;
use Illuminate\Database\Eloquent\Model;

class DesignType extends Model
{
    protected $table = 'p_design_type';

    function functions(){
        return $this->belongsToMany(Functions::class,'p_design_type_functions','design_type_id','functions_id')->where('p_functions.status',1);
    }
}
