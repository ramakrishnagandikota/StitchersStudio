<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcasting extends Model
{
    protected $table = 'broadcasting';

    protected $fillable = [
        'title', 'message', 'platform', 'schedule_at'
    ];
}
