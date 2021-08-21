<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FormulaRequest;

class FrComments extends Model
{
    protected $table = 'p_fr_comments';

    public $timestamps = true;

    public function formulaRequest(){
        return $this->belongsToMany(FormulaRequest::class,
            'p_formula_requests_fr_comments',
            'p_fr_comments_id',
            'p_formula_requests_id');
    }
}
