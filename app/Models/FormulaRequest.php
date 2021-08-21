<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FrOutputVariables;
use App\User;
use App\Models\FrComments;

class FormulaRequest extends Model
{
    protected $table = 'p_formula_requests';

    public $timestamps = true;

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function outputVariables(){
        return $this->belongsToMany(FrOutputVariables::class,
            'p_formula_requests_fr_output_variables',
            'p_formula_requests_id',
            'p_fr_output_variables_id');
    }

    public function comments(){
        return $this->belongsToMany(FrComments::class,
            'p_formula_requests_fr_comments',
            'p_formula_requests_id',
            'p_fr_comments_id');
    }
}
