<?php

namespace App\Models\Patterns;

use App\Models\Patterns\ConditionalStatement;
use App\Models\Patterns\Section;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\Instructions;
use App\Models\Patterns\YarnDetails;
use App\Models\Patterns\PatternTemplate;
use App\Models\Patterns\SnippetFactorModifier;
use App\Models\Patterns\ConditionalVariablesOutput;

class Snippet extends Model
{
    protected $table = 'p_snippets';

    public function sections(){
        return $this->belongsToMany(Section::class,
            'p_section_snippets',
            'snippets_id',
            'sections_id');
    }

    function snippetConditionalStatements(){
        return $this->belongsToMany(ConditionalStatement::class,
            'p_snippets_conditional_statements',
            'snippets_id',
            'conditional_statements_id');
        /*return $this->belongsToMany(ConditionalStatement::class,
            'p_snippets_same_conditions',
            'snippets_id',
            'conditional_statements_id')->withPivot(['sameAsCondition']);*/
    }

    function instructions(){
        return $this->belongsToMany(Instructions::class,
            'p_snippet_instructions',
            'snippets_id',
            'instructions_id');
    }

    public function yarnDetails(){
        return $this->belongsToMany(YarnDetails::class,
            'p_snippets_yarn_details',
            'snippets_id',
            'yarn_details_id');
    }

    public function patternTemplate(){
        return $this->belongsTo(PatternTemplate::class);
    }

    public function factors(){
        return $this->hasMany(SnippetFactorModifier::class,'snippets_id');
    }

    public function modifiers(){
        return $this->hasMany(SnippetFactorModifier::class,'snippets_id');
    }

    public function conditionalVariableOutput(){
        return $this->belongsToMany(ConditionalVariablesOutput::class,
            'p_snippets_conditional_variables_outputs',
            'snippets_id',
            'conditional_variables_output_id');
    }
}
