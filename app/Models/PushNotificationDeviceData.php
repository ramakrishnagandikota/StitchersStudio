<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PushNotificationDeviceData extends Model
{
    protected $table = 'push_notification_device_data';
	
	public $timestamps = true;
	//private $fillable = ['user_id'];
}
