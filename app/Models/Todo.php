<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Todo extends Model
{
    protected $table = 'todo';

    protected $guarded = [];

    public function getRouteKeyName(){
        return 'id';
    }

    public function getPathAttribute(){
        echo "todo/$this->id";
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
