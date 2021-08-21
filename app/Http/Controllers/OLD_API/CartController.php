<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\API\Cart;
use App\Models\Products;
use App\Models\Product_images;
use Carbon\Carbon;
use App\Models\UserAddress;
use App\User;
use App\Models\Booking_process;

class CartController extends Controller
{
    function __construct(){
        $this->middleware('auth:api');
    }

    function sendJsonData($data){
		return response()->json(['data' => $data]);
	}

    function get_cart(){
        $jsonArray = array();

        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $count = count($cart);
        $sum = 0;
        for ($i=0; $i < count($cart); $i++) {

            $jsonArray[$i]['id'] = $cart[$i]->id;
            $product = Products::where('id',$cart[$i]->product_id)->select('id as product_id','product_name','price','sale_price','sale_price_start_date','sale_price_end_date')->get();

            for ($j=0; $j < count($product); $j++) {

        $date = strtotime(date('Y-m-d'));
        $dateStart = strtotime(date('Y-m-d',strtotime($product[$j]->sale_price_start_date)));
        $dateEnd = strtotime(date('Y-m-d',strtotime($product[$j]->sale_price_end_date)));

        if($date >= $dateStart && $date <= $dateEnd){
            $price = $product[$j]->sale_price;
        }else{
            $price = $product[$j]->price;
        }

        $sum=$sum+$price;
                $image = Product_images::where('product_id',$product[$j]->product_id)->select('image_small')->first();

                $jsonArray[$i]['product'][$j]['product_id'] = $product[$j]->product_id;
                $jsonArray[$i]['product'][$j]['product_name'] = $product[$j]->product_name;
                $jsonArray[$i]['product'][$j]['price'] = $price;
                $jsonArray[$i]['product'][$j]['images'] = $image->image_small;
            }

            $jsonArray[$i]['qty'] = 1;
        }

        $array = array('totalItemsCount' => $count,'total' => $sum,'cart' => $jsonArray);
        return $this->sendJsonData($array);
    }

    function add_cart(Request $request){
        if(!$request->product_id){
            return response()->json(['status' => 'fail','message' => 'Please pass product_id in post data.']);
            exit;
        }
		$purchased = Booking_process::where('user_id',Auth::user()->id)->where('product_id',$request->product_id)->count();
        if($purchased > 0){
            return response()->json(['status' => 'fail','message' => 'This product is already purchsed.']);
            exit;
        }
        $cartCount = Cart::where('user_id',Auth::user()->id)->where('product_id',$request->product_id)->count();
        $productCount = Products::where('id',$request->product_id)->count();
        if($productCount == 0){
            return response()->json(['status' => 'fail',"message" => 'Please add a product to cart']);
            exit;
        }

        if($cartCount > 0){
            return response()->json(['status' => 'fail',"message" => 'This product is already added to cart']);
            exit;
        }

        $cart = new Cart;
        $cart->user_id = Auth::user()->id;
        $cart->product_id = $request->product_id;
        $cart->created_at = Carbon::now();
        $cart->ipaddress = $_SERVER['REMOTE_ADDR'];
        $save = $cart->save();
        if($save){
            return $this->get_cart();
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function remove_item(Request $request){
        $id = $request->id;
        $cart = Cart::find($id);
        $save = $cart->delete();
        if($save){
            return $this->get_cart();
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function remove_all_items(){
        $delete = Cart::where('user_id',Auth::user()->id)->delete();
        if($delete){
            return $this->get_cart();
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function BuyNow(Request $request){
        if(!$request->product_id){
            return response()->json(['status' => 'fail','message' => 'Please pass product_id in post data.']);
            exit;
        }
        $cartCount = Cart::where('user_id',Auth::user()->id)->count();
        if($cartCount > 0){
            $delete = Cart::where('user_id',Auth::user()->id)->delete();
        }
        $cart = new Cart;
        $cart->user_id = Auth::user()->id;
        $cart->product_id = $request->product_id;
        $cart->created_at = Carbon::now();
        $cart->ipaddress = $_SERVER['REMOTE_ADDR'];
        $save = $cart->save();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }


    function user_address(){
       // $cart = Cart::where('user_id',Auth::user()->id)->count();
       // if($cart == 0){
       //     return response()->json(['status' => 'fail','message' => 'There are no items in cart for checkout.']);
        //    exit;
       // }
        $jsonArray = array();
        $address = UserAddress::where('user_id',Auth::user()->id)->get();
        for ($i=0; $i < count($address); $i++) {
            $jsonArray[$i]['id'] = $address[$i]->id;
            $jsonArray[$i]['first_name'] = $address[$i]->first_name;
            $jsonArray[$i]['last_name'] = $address[$i]->last_name;
            $jsonArray[$i]['email'] = $address[$i]->email;
            $jsonArray[$i]['mobile'] = $address[$i]->mobile;
            $jsonArray[$i]['address'] = $address[$i]->address;
            $jsonArray[$i]['city'] = $address[$i]->city;
            $jsonArray[$i]['state'] = $address[$i]->state;
            $jsonArray[$i]['country'] = $address[$i]->country;
            $jsonArray[$i]['zipcode'] = $address[$i]->zipcode;
            $jsonArray[$i]['is_default'] = ($address[$i]->is_default == 1) ? true : false;
        }

        $array = array('address' => $jsonArray);
        return $this->sendJsonData($array);
    }
}
