<?php

namespace App\Models\Patterns;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\Functions;

class MeasurementVariables extends Model
{
    protected $table = 'p_measurement_variables';

    function functions(){
        return $this->belongsToMany(Functions::class,'p_functions_measurement_variables','measurement_variables_id','functions_id');
    }
}
