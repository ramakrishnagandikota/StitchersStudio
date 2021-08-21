<?php

namespace App\Models\Patterns;

use App\Models\Patterns\PatternTemplate;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\Snippet;

class Section extends Model
{
    protected $table = 'p_sections';

    public function patterntemplate(){
        return $this->belongsToMany(PatternTemplate::class,
            'p_pattern_template_sections',
            'sections_id',
            'pattern_template_id');
    }

    public function snippets(){
        return $this->belongsToMany(Snippet::class,
            'p_section_snippets',
            'sections_id',
            'snippets_id');
    }
}
