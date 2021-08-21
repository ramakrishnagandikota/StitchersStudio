<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use DB;
use App\User;
use Auth;

class ProductCommentsResource extends JsonResource
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
            'user_id' => $this->user_id,
            'rating' => $this->rating,
            'name' => $this->name,
            'email' => $this->email,
			'picture' => Auth::user()->picture,
            'comment' => $this->comment,
            'created_at' => $this->created_at->diffForHumans(),
            'voteCount' => DB::table('product_vote_unvote')->where('comment_id',$this->id)->where('vote',1)->count(),
            'unvoteCount' => DB::table('product_vote_unvote')->where('comment_id',$this->id)->where('unvote',1)->count()
        ];
    }
}
