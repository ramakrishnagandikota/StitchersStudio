<?php

namespace App\Models\Patterns;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\Snippet;

class ConditionalVariablesOutput extends Model
{
    protected $table = 'p_conditional_variables_outputs';

    public $timestamps = true;

    public function snippets(){
        return $this->belongsToMany(Snippet::class,
            'p_snippets_conditional_variables_outputs',
            'conditional_variables_output_id',
            'snippets_id');
    }
}
