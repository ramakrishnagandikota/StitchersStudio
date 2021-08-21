<?php

namespace App\Models\Patterns;

use App\Models\Patterns\PatternTemplate;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\Snippet;

class YarnDetails extends Model
{
    protected $table = 'p_yarn_details';

    protected $fillable = ['yarn_content'];

    /* public function patterntemplate(){
        return $this->belongsToMany(PatternTemplate::class,
            'p_pattern_template_yarn_details',
            'yarn_details_id',
            'pattern_template_id');
    }*/


    public function snippets(){
        return $this->belongsToMany(Snippet::class,
            'p_snippets_yarn_details',
            'yarn_details_id',
            'snippets_id');
    }
}
