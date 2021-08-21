<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportCommentsAttachments extends Model
{

    protected $table = 'support_comments_attachments';

    protected $guarded = [];

    function SupportComments(){
        return $this->belongsTo(SupportComments::class);
    }
}
