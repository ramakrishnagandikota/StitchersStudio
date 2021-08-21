<?php

namespace App\Models\Patterns;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\IfConditions;

class ConditionalVariable extends Model
{
    protected $table = 'p_conditional_variables';

    public function functions(){
        return $this->belongsTo(Functions::class);
    }

    public function IfConditions(){
        return $this->belongsToMany(IfConditions::class,'p_if_conditions_conditional_variables','conditional_variables_id','if_conditions_id');
    }
}
