<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\SupportComments;

class Support extends Model
{

    protected $table = 'support';

    protected $guarded = [];

    function users(){
        return $this->belongsTo(User::class);
    }

    function SupportComments(){
        return $this->hasMany(SupportComments::class);
    }

    function SupportAttachments(){
        return $this->hasMany(SupportAttachments::class,'support_id');
    }
}
