<?php

namespace App\Models\Patterns;

use App\Models\Pattern;
use App\Models\Patterns\Section;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patterns\YarnDetails;
use App\Models\Patterns\Snippet;
use App\User;

class PatternTemplate extends Model
{
    protected $table = 'p_pattern_template';

    function users(){
        return $this->belongsTo(User::class);
    }

    public function getAllSections(){
        return $this->belongsToMany(Section::class,
            'p_pattern_template_sections',
            'pattern_template_id',
            'sections_id');
    }

    public function getNewSection(){
        return $this->belongsToMany(Section::class,
            'p_pattern_template_sections',
            'pattern_template_id',
            'sections_id')->latest();
    }

    /*public function yarnDetails(){
        return $this->belongsToMany(YarnDetails::class,
            'p_pattern_template_yarn_details',
            'pattern_template_id',
            'yarn_details_id');
    }*/

    public function patterns(){
        return $this->belongsToMany(Pattern::class,
            'p_pattern_pattern_template',
            'pattern_template_id',
            'patterns_id');
    }

    public function snippets(){
        return $this->hasMany(Snippet::class,'pattern_template_id');
    }

}
