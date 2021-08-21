<?php

namespace App\Models\Patterns;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\Functions;

class Modifier extends Model
{
    protected $table = 'p_modifier';

    public function functions(){
        return $this->belongsToMany(Functions::class,'p_functions_modifier','modifier_id','functions_id');
    }
}
