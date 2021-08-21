<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportComments extends Model
{

    protected $table = 'support_comments';

    protected $guarded = [];

    function support(){
        return $this->belongsTo(Support::class);
    }

    function SupportCommentsAttachments(){
        return $this->hasMany(SupportCommentsAttachments::class);
    }
}
