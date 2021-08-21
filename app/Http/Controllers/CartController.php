<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use App\User;
use App\Models\Products;
use Auth;
use Session;
use App\Models\UserAddress;
use App\Models\Country;

class CartController extends Controller
{
	function get_cart(){
    	$oldCart = Session::has('cart') ? Session::get('cart') : null;
    	$cart = new Cart($oldCart);
    	$data = $cart->items;
        $totalPrice = $cart->totalPrice;
    	return view('shopping.cart',compact('data','totalPrice'));
    }

        function add_to_cart(Request $request){

        if($request->ajax()){
            if($request->session()->exists('cart')){
            $oldCart = $request->session()->get('cart');
        }else{
            $oldCart = null;
        }

        $cart = new Cart($oldCart);
        $product = Products::find($request->product_id);

        $products = $cart->items;

        if($products){
            foreach($products as $pro){
                $pid = $pro['item']['id'];
                $designer_name = $pro['item']['designer_name'];
                if($pid == $product->id){
                   return response()->json(['error' => 'fail','message' => 'This product is already in cart.']);
                   exit;
                }

                if($designer_name != $product->designer_name){
                    return response()->json(['error' => 'fail','message' => 'Add the product of the same designer.']);
                    exit;
                }
            }
        }

        $add = $cart->add($product,$request->product_id);
        $request->session()->put('cart',$cart);

        }else{
            if($request->session()->exists('cart')){
            $oldCart = $request->session()->get('cart');
        }else{
            $oldCart = null;
        }

        $cart = new Cart($oldCart);
        $product = Products::find($request->product_id);

        $products = $cart->items;
        foreach($products as $pro){
            $pid = $pro['item']['id'];
            if($pid == $product->id){
               Session::flash('error','This product is already added in cart.');
               return redirect('/shop-patterns');
               exit;
            }
        }

        $add = $cart->add($product,$request->product_id);
        $request->session()->put('cart',$cart);

        return redirect('checkout');
        }
    }

    function my_cart(Request $request){
       // if(!Session::has('cart')){
           // return redirect('shop-patterns');
       // }

    	$page = '';
    	$perPage = '';
        $oldCart = Session::get('cart');
    	$cart = new Cart($oldCart);
    	$data = $cart->items;
    	$totalPrice = $cart->totalPrice;
    	return view('shopping.mycart',compact('data','totalPrice','page','perPage'));
    }

    function remove_all_items(Request $request){
        if($request->ajax()){
            Session::forget('cart');
            return response()->json(['status' => 'success']);
        }else{
            Session::forget('cart');
            return redirect()->back();
        }


    }

    public function getReduseByOne($id){
    	$oldCart = Session::has('cart') ? Session::get('cart') : null;
    	$cart = new Cart($oldCart);
    	$cart->reduceByOne($id);
    	if(count($cart->items) > 0){
    		$sess = Session::put('cart',$cart);
    	}else{
    		$sess = Session::forget('cart');
    	}
    	//return redirect()->back();
    }

    function checkout(){
    	if(!Auth::check()){
    		return redirect('login');
    		exit;
    	}
        if(!Session::has('cart')){
            return redirect('shop-patterns');
        }
    	$page = '';
    	$perPage = '';
    	$oldCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($oldCart);
        $data = $cart->items;

        $totalPrice = $cart->totalPrice;
		$country = Country::all();
    	return view('shopping.checkout',compact('page','perPage','data','totalPrice','country'));
    }

    function getUserAddress(){
    	if(!Auth::check()){
    		return response()->json(['error' => 'Please login to proceed for checkout.']);
    		exit;
    	}
    	$address = UserAddress::where('user_id',Auth::user()->id)->get();
    	return view('shopping.useraddress',compact('address'));
    }

    function buy_now(Request $request){
        $pid = $request->pid;
        $pro = Products::where('pid',$pid)->first();
        if($request->session()->exists('cart')){
            Session::forget('cart');
        }

        $oldCart = null;


        $cart = new Cart($oldCart);
        $product = Products::find($pro->id);

        $products = $cart->items;
      /*  foreach($products as $pro){
            $pid = $pro['item']['id'];
            if($pid == $product->id){
               Session::flash('error','This product is already added in cart.');
               return redirect('/shop-patterns');
               exit;
            }
        } */

        $add = $cart->add($product,$pro->id);
        $request->session()->put('cart',$cart);

        return redirect('checkout');
    }



}
