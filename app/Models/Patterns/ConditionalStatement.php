<?php

namespace App\Models\Patterns;

use App\Models\Patterns\Functions;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\Snippet;
use App\Models\Patterns\Instructions;

class ConditionalStatement extends Model
{
    protected $table = 'p_conditional_statements';

    public function functions(){
        return $this->belongsToMany(Functions::class,
            'p_functions_conditional_statements',
            'conditional_statements_id',
            'functions_id');
    }

    function snippets(){
        return $this->belongsToMany(Snippet::class,
            'p_snippets_conditional_statements',
            'conditional_statements_id',
            'snippets_id');
    }

    function instructions(){
        return $this->belongsToMany(Instructions::class,
            'p_conditional_statements_insructions',
            'conditional_statements_id',
            'instructions_id');
    }
}
