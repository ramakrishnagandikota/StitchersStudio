<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pattern;

class PatternImage extends Model
{
    protected $table = 'p_pattern_images';

    protected $guarded = [];

    public function patterns(){
        return $this->belongsTo(Pattern::class);
    }
}
