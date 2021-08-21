<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class ProjectNotes extends Model
{
    protected $table = 'projects_notes';

    function projects(){
        return $this->belongsTo(Project::class);
    }
}
