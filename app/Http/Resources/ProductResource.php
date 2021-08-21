<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use App\Models\ProductWishlist;
use DB;

class ProductResource extends JsonResource
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
        $data = [
            'id' => $this->id,
            'product_name' => $this->product_name,
            'details' => $this->short_description,
            'product_description' => $this->product_description,
            'additional_information' => $this->additional_information,
            'skill_level' => $this->skill_level,
            'category' => ($this->category_id == 1) ? 'Pattern' : 'Yarn',
            'is_custom' => ($this->is_custom == 1) ? 'Custom' : 'Non Custom',
            'design_type' => $this->design_type,
            'product_go_live_date' => $this->product_go_live_date,
            'status' => $this->status,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'sale_price_start_date' => $this->sale_price_start_date,
            'sale_price_end_date' => $this->sale_price_end_date,
            'images' => ProductImageResource::collection($this->images),
            'comments' => ProductCommentsResource::collection($this->comments),
            'wishlist' => (Auth::check()) ? ProductWishlist::where('product_id',$this->id)->where('user_id',Auth::user()->id)->count() : '0',
        ];

        $rate = DB::table("products")
	    ->select(DB::raw("SUM(product_comments.rating)/COUNT(product_comments.rating) as rate"))
	    ->leftjoin("product_comments","product_comments.product_id","=","products.id")->where('products.id',$data['id'])->orderBy('rate','DESC')
	    ->groupBy("products.id")->first();

        $data['rating'] = (int) $rate->rate;

        return $data;
    }
}
