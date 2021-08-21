<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pattern;

class PatternNeedles extends Model
{
    protected $table = 'p_pattern_needles';

    protected $guarded = [];

    public function patterns(){
        return $this->belongsTo(Pattern::class);
    }
}
