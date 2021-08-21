<?php

namespace App\Models\Patterns;

use App\Models\Patterns\Snippet;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\ConditionalStatement;

class Instructions extends Model
{
    protected $table ='p_instructions';

    function instructionsConditionalStatements(){
        return $this->belongsToMany(ConditionalStatement::class,
            'p_conditional_statements_insructions',
            'instructions_id',
            'conditional_statements_id');
    }

    function sections(){
        return $this->belongsToMany(Snippet::class,
            'p_snippet_instructions',
            'instructions_id',
            'snippets_id');
    }
}
