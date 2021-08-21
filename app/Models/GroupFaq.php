<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GroupFaqCategory;

class GroupFaq extends Model
{

    function category(){
        return $this->belongsTo(GroupFaqCategory::class,'faq_category_id');
    }
}
