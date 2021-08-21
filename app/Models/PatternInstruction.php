<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatternInstruction extends Model
{
    protected $table = 'p_pattern_instructions';

    protected $guarded = [];

    public function patterns(){
        return $this->belongsTo(Pattern::class);
    }
}
