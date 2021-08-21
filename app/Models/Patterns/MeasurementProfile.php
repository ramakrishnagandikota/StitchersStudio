<?php

namespace App\Models\Patterns;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\MeasurementValues;

class MeasurementProfile extends Model
{
    protected $table = 'p_measurement_profile';

    protected $guarded = [];

    function measurementvalues(){
        return $this->hasMany(MeasurementValues::class,'measurement_profile_id');
    }
}
