<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class Projectneedle extends Model
{
    protected $table = 'projects_needle';

    

    function projects(){
        return $this->belongsTo(Project::class);
    }
}
