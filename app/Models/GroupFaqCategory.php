<?php

namespace App\Models;

use App\Models\GroupFaq;
use Illuminate\Database\Eloquent\Model;

class GroupFaqCategory extends Model
{

    protected $table = 'group_faq_categories';

    function faqs(){
        return $this->hasMany(GroupFaq::class,'faq_category_id');
    }
}
