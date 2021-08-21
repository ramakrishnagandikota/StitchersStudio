<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'id' => $this->id,
            'notes' => $this->notes,
            'completed' => ($this->status == 2) ? true : false,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
