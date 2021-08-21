<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class Projectyarn extends Model
{
    protected $table = 'projects_yarn';

    function projects(){
        return $this->belongsTo(Project::class);
    }
}
