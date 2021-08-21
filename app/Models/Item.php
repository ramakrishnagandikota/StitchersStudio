<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class Item extends Model
{
    //
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
