<?php

namespace App\Models;

use App\Models\Patterns\PatternTemplate;
use Illuminate\Database\Eloquent\Model;
use App\Models\YarnRecommendations;
use App\Models\PatternNeedles;
use App\Models\PatternImage;
use App\Models\PatternWorkStatus;
USE App\Models\PatternInstruction;
use App\User;

class Pattern extends Model
{
    protected $table = 'p_patterns';

    protected $guarded = [];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function templates(){
        return $this->belongsToMany(PatternTemplate::class,
            'p_pattern_pattern_template',
            'patterns_id',
            'pattern_template_id');
    }

    public function yarnRecommmendations(){
        return $this->hasMany(YarnRecommendations::class,'pattern_id');
    }

    public function needles(){
        return $this->hasMany(PatternNeedles::class,'pattern_id');
    }

    public function patternImages(){
        return $this->hasMany(PatternImage::class,'pattern_id');
    }

    public function workStatus(){
        return $this->hasMany(PatternWorkStatus::class,'pattern_id');
    }

    public function traditionalPatternpdf(){
        return $this->hasMany(PatternInstruction::class,'pattern_id');
    }
}
