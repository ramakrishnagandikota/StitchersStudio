<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatternWorkStatus extends Model
{
    protected $table = 'p_pattern_work_status';

    protected $guarded = [];

    public $timestamps = true;

    public function patterns(){
        return $this->belongsTo(Pattern::class);
    }
}
