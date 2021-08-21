<?php

namespace App\Models\Patterns;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\Functions;
use App\Models\Patterns\ConditionalVariable;

class IfConditions extends Model
{
    protected $table = 'p_if_conditions';

    public function functions(){
        return $this->belongsToMany(Functions::class,'p_functions_if_conditions','if_conditions_id','functions_id');
    }

    public function conditionalVariables(){
        return $this->belongsToMany(ConditionalVariable::class,'p_if_conditions_conditional_variables','if_conditions_id','conditional_variables_id');
    }
}
