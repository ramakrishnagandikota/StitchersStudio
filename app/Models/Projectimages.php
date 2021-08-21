<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project;

class Projectimages extends Model
{
    protected $table = 'projects_images';

    function projects(){
        return $this->belongsTo(Project::class);
    }
}
