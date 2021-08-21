<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FormulaRequest;

class FrOutputVariables extends Model
{
    protected $table = 'p_fr_output_variables';

    public $timestamps = true;

    public function formulaRequest(){
        return $this->belongsToMany(FormulaRequest::class,
            'p_formula_requests_fr_output_variables',
            'p_fr_output_variables_id',
            'p_formula_requests_id');
    }
}
