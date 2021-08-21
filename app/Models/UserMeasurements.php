<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Support\Str;

class UserMeasurements extends Model
{
    protected $table = 'user_measurements';

    protected $guarded = [];
    //protected $fillable = ['user_id','m_title','slug','m_description','measurement_preference'];

    protected static function boot(){
        parent::boot();

        static::creating(function($measurement){
            $measurement->slug = Str::slug($measurement->m_title);
        });
    }

    public function getRouteKeyName(){
        return 'id';
    }

    public function getPathAttribute(){
        echo "measurements/$this->id";
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
