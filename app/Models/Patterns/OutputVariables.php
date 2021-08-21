<?php

namespace App\Models\Patterns;

use App\Models\Patterns\Functions;
use Illuminate\Database\Eloquent\Model;

class OutputVariables extends Model
{
    protected $table = 'p_output_variables';

    public function functions(){
        return $this->belongsToMany(Functions::class,'p_functions_measurement_variables','output_variables_id','functions_id');
    }
}
