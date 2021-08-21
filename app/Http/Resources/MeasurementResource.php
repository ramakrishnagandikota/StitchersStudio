<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Auth;
use App\Models\UserMeasurements;

class MeasurementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
		$sub = Auth::user()->remainingDays();
		$mes = UserMeasurements::where('user_id',Auth::user()->id)->orderBy('id','ASC')->first();
		
        return [
            'id' => $this->id,
            'm_title' => $this->m_title,
            'slug' => Str::slug($this->m_title),
            'm_description' => $this->m_description,
            'm_date' => date('Y-m-d',strtotime($this->m_date)),
            'measurement_preference' => $this->measurement_preference,
            'user_meas_image' => $this->user_meas_image,
            'ext' => $this->ext,
            'hips' => $this->hips,
            'waist' => $this->waist,
            'waist_front' => $this->waist_front,
            'bust' => $this->bust,
            'bust_front' => $this->bust_front,
            'bust_back' => $this->bust_back,
            'waist_to_underarm' => $this->waist_to_underarm,
            'armhole_depth' => $this->armhole_depth,
            'wrist_circumference' => $this->wrist_circumference,
            'forearm_circumference' => $this->forearm_circumference,
            'upperarm_circumference' => $this->upperarm_circumference,
            'shoulder_circumference' => $this->shoulder_circumference,
            'wrist_to_underarm' => $this->wrist_to_underarm,
            'wrist_to_elbow' => $this->wrist_to_elbow,
            'elbow_to_underarm' => $this->elbow_to_underarm,
            'wrist_to_top_of_shoulder' => $this->wrist_to_top_of_shoulder,
            'depth_of_neck' => $this->depth_of_neck,
            'neck_width' => $this->neck_width,
            'neck_circumference' => $this->neck_circumference,
            'neck_to_shoulder' => $this->neck_to_shoulder,
            'shoulder_to_shoulder' => $this->shoulder_to_shoulder,
            'in_preview' => $this->in_preview,
			'show' => ($sub == 0) ? (($mes->id == $this->id) ? true : false) : true
        ];
    }
}
