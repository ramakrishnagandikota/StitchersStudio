<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Timeline;
use App\Traits\PostLikableTrait;

class Timelinelikes extends Model
{
    use PostLikableTrait;

    protected $table = 'timeline_likes';
    protected $fillable = ['user_id','timeline_id','created_at','ipaddress'];

    public function likable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(Timeline::class);
    }

    public function timeline(){
        return $this->belongsTo(Timeline::class);
    }
}
