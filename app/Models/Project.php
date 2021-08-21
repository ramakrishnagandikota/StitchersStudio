<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Projectimages;
use App\Models\Projectneedle;
use App\Models\Projectyarn;
use App\Models\ProjectNotes;

class Project extends Model
{
    protected $table = 'projects';

    function users(){
        return $this->belongsTo(User::class);
    }

    function project_images(){
    	return $this->hasMany(Projectimages::class);
    }

    function project_needle(){
    	return $this->hasMany(Projectneedle::class);
    }

    function project_yarn(){
    	return $this->hasMany(Projectyarn::class);
    }

    function project_notes(){
        return $this->hasMany(ProjectNotes::class);
    }
}
