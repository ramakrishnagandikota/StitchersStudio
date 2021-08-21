<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportAttachments extends Model
{

    protected $table = 'support_attachments';

    protected $guarded = [];

    function support(){
        return $this->belongsTo(Support::class);
    }
}
