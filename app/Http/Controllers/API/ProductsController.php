<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Products;
use App\Models\ProductComments;
use App\Models\Product_images;
use App\Models\MasterList;
use App\Models\NeedleSizes;
use App\Models\GaugeConversion;
use App\Models\ProductDesignerMeasurements;
use Carbon\Carbon;
use App\Models\ProductWishlist;
use DB;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCommentsResource;
use App\Models\Booking_process;
use App\Models\API\Cart;
use App\Models\Orders;

class ProductsController extends Controller
{

	public function sendResponse($result)
    {
    	$response = [
            'data'    => $result,
            'login_user_id' => (Auth::check()) ? Auth::user()->id : '0'
        ];


        return response()->json($response, 200);
    }

    function get_all_filters(){
    	$garmentType = MasterList::where('type','garment_type')->get();
        $garmentConstruction = MasterList::where('type','garment_construction')->get();
        $designElements = MasterList::where('type','design_elements')->get();
        $shoulderConstruction = MasterList::where('type','shoulder_construction')->get();

        $jsonArray['garmentType'] = array();
        $jsonArray['garmentConstruction'] = array();
        $jsonArray['designElements'] = array();
        $jsonArray['shoulderConstruction'] = array();
        $jsonArray['designer'] = array();
        $jsonArray['patternType'] = array();

        for ($i=0; $i < count($garmentType); $i++) {
        	$jsonArray['garmentType'][$i]['name'] = $garmentType[$i]->name;
            $jsonArray['garmentType'][$i]['slug'] = $garmentType[$i]->slug;
            $jsonArray['garmentType'][$i]['isChecked'] = false;
        }

        for ($j=0; $j < count($garmentConstruction); $j++) {
        	$jsonArray['garmentConstruction'][$j]['name'] = $garmentConstruction[$j]->name;
            $jsonArray['garmentConstruction'][$j]['slug'] = $garmentConstruction[$j]->slug;
            $jsonArray['garmentConstruction'][$j]['isChecked'] = false;
        }

        for ($k=0; $k < count($designElements); $k++) {
        	$jsonArray['designElements'][$k]['name'] = $designElements[$k]->name;
            $jsonArray['designElements'][$k]['slug'] = $designElements[$k]->slug;
            $jsonArray['designElements'][$k]['isChecked'] = false;
        }

        for ($l=0; $l < count($shoulderConstruction); $l++) {
        	$jsonArray['shoulderConstruction'][$l]['name'] = $shoulderConstruction[$l]->name;
            $jsonArray['shoulderConstruction'][$l]['slug'] = $shoulderConstruction[$l]->slug;
            $jsonArray['shoulderConstruction'][$l]['isChecked'] = false;
        }

        $jsonArray['designer'][0]['name'] = 'Knit Fit Couture';
        $jsonArray['designer'][0]['slug'] = 'knit-fit-couture';
        $jsonArray['designer'][0]['isChecked'] = false;

        $jsonArray['patternType'][0]['name'] = 'Custom';
        $jsonArray['patternType'][0]['slug'] = 'custom';
        $jsonArray['patternType'][0]['isChecked'] = false;

        $jsonArray['patternType'][1]['name'] = 'Non Custom';
        $jsonArray['patternType'][1]['slug'] = 'non-custom';
        $jsonArray['patternType'][1]['isChecked'] = false;

        return $this->sendResponse($jsonArray, '');
    }


    function get_products_data_all(Request $request){
		try{
		if((Auth::user()->remainingDays() == 0) && (Auth::user()->isBasic() == true)){
			Auth::user()->subscription()->detach();
			Auth::user()->subscription()->attach(['1']);
        }
		
        $jsonArray = array();

        $orderBy = ($request->get('orderBy')) ? $request->get('orderBy') : 'Newest_first';

        if($orderBy == 'Newest_first'){
            $products = Products::orderBy('id','DESC')->where('status',1)->get();
        }else if($orderBy == 'Low_to_high'){
            $products = Products::orderBy('price','ASC')->where('status',1)->get();
        }else if($orderBy == 'High_to_low'){
            $products = Products::orderBy('price','DESC')->where('status',1)->get();
        }else if($orderBy == 'Popular'){
            $products = DB::table("products")
	    ->select('products.*',DB::raw("SUM(product_comments.rating)/COUNT(product_comments.rating) as rate"))
	    ->leftjoin("product_comments","product_comments.product_id","=","products.id")->orderBy('rate','DESC')
	    ->groupBy("products.id")
	    ->where('products.status',1)->get();
        }else{
            $products = Products::where('status',1)->get();
        }

    	for ($i=0; $i < count($products); $i++) {
    		$jsonArray[$i]['id'] = $products[$i]->id;
    		$jsonArray[$i]['product_name'] = $products[$i]->product_name;
    		$jsonArray[$i]['is_custom'] = ($products[$i]->is_custom == 1) ? 'custom' : 'non-custom';
    		if($products[$i]->sale_price_start_date <= date('Y-m-d') && $products[$i]->sale_price_end_date >= date('Y-m-d')){
    			$jsonArray[$i]['price'] = number_format($products[$i]->price,2);
    			$jsonArray[$i]['sale_price'] = number_format($products[$i]->sale_price,2);
    		}else{
    			$jsonArray[$i]['price'] = number_format($products[$i]->price,2);
    			$jsonArray[$i]['sale_price'] = '';
    		}

    		$jsonArray[$i]['garment_type'] = $products[$i]->garment_type;
    		$jsonArray[$i]['garment_construction'] = $products[$i]->garment_construction;
    		$jsonArray[$i]['design_elements'] = $products[$i]->design_elements;
    		$jsonArray[$i]['shoulder_construction'] = $products[$i]->shoulder_construction;

    		$image = Product_images::where('product_id',$products[$i]->id)->select('image_small')->first();
    		$jsonArray[$i]['image'] = $image ? $image->image_small : 'https://via.placeholder.com/176x225.png?text=No Image';
			$designer_name = User::where('id',$products[$i]->designer_name)->first();
			$jsonArray[$i]['designer'] = ($designer_name) ? $designer_name->username : null;
			$jsonArray[$i]['designer_name'] = ($designer_name) ? $designer_name->first_name.' '.$designer_name->last_name : null;
    		$rate = DB::table("products")
	    ->select(DB::raw("SUM(product_comments.rating)/COUNT(product_comments.rating) as rate"))
	    ->leftjoin("product_comments","product_comments.product_id","=","products.id")->where('products.id',$products[$i]->id)->orderBy('rate','DESC')
	    ->groupBy("products.id")->first();

        $jsonArray[$i]['rating'] = (int) $rate->rate;
        $jsonArray[$i]['wishlist'] = ProductWishlist::where('product_id',$products[$i]->id)->where('user_id',Auth::user()->id)->count();
		$purchased = Orders::leftjoin('booking_process','orders.id','booking_process.order_id')
						->select('booking_process.*')
						->where('orders.user_id',Auth::user()->id)
						->where('booking_process.product_id',$products[$i]->id)
						->where('orders.order_status','Success')
						->count();
						//Booking_process::where('user_id',Auth::user()->id)->where('product_id',$products[$i]->id)->where('')->count();
        $jsonArray[$i]['purchased'] = ($purchased > 0) ? true : false;
		
    	}

    	return $this->sendResponse($jsonArray, '');
		}catch(Throwable  $e){
			info($e->getMessage());
		}
    }

    function show(Products $product){
		try{
			return new ProductResource($product);
		}catch(Throwable  $e){
			info($e->getMessage());
		}
    }

    function get_product(Request $request){
		try{
			
		if((Auth::user()->remainingDays() == 0) && (Auth::user()->isBasic() == true)){
			Auth::user()->subscription()->detach();
			Auth::user()->subscription()->attach(['1']);
        }
		
        $jsonArray = array();
    	$products = Products::where('id',$request->id)->where('status',1)->get();
        for ($i=0; $i < count($products); $i++) {
            $jsonArray[$i]['id'] = $products[$i]->id;
            $jsonArray[$i]['product_name'] = $products[$i]->product_name;
            $jsonArray[$i]['product_description'] = $products[$i]->product_description;
            $jsonArray[$i]['details'] = $products[$i]->short_description;
            $jsonArray[$i]['materials'] = $products[$i]->material_needed;
            $jsonArray[$i]['additional_information'] = $products[$i]->gauge_description;
            $jsonArray[$i]['price'] = number_format($products[$i]->price,2);
            $jsonArray[$i]['sale_price'] = number_format($products[$i]->sale_price,2);
            $jsonArray[$i]['sale_price_start_date'] = $products[$i]->sale_price_start_date;
            $jsonArray[$i]['sale_price_end_date'] = $products[$i]->sale_price_end_date;
			$jsonArray[$i]['is_custom'] = ($products[$i]->is_custom == 1) ? 'custom' : 'non-custom';
            $rate = DB::table("products")
	    ->select(DB::raw("SUM(product_comments.rating)/COUNT(product_comments.rating) as rate"))
	    ->leftjoin("product_comments","product_comments.product_id","=","products.id")->where('products.id',$products[$i]['id'])->orderBy('rate','DESC')
	    ->groupBy("products.id")->first();

        $jsonArray[$i]['rating'] = (int) $rate->rate;

        $jsonArray[$i]['image'] = Product_images::where('product_id',$products[$i]['id'])->select('image_small')->get();
            $comments = ProductComments::where('product_id',$products[$i]->id)->select('id','user_id','rating','name','email','comment','created_at')->orderBy('id','desc')->get();
			$purchased = Orders::leftjoin('booking_process','orders.id','booking_process.order_id')
						->select('booking_process.*')
						->where('orders.user_id',Auth::user()->id)
						->where('booking_process.product_id',$products[$i]->id)
						->where('orders.order_status','Success')
						->count();
        $jsonArray[$i]['purchased'] = ($purchased > 0) ? true : false;
		
		$addedToCart = Cart::where('user_id',Auth::user()->id)->where('product_id',$products[$i]->id)->count();
		$jsonArray[$i]['addedToCart'] = ($addedToCart > 0) ? true : false;
		
if($comments->count() > 0){
for ($j=0; $j < count($comments); $j++) {
    $jsonArray[$i]['comments'][$j]['id'] = $comments[$j]->id;
    $jsonArray[$i]['comments'][$j]['user_id'] = $comments[$j]->user_id;
    $jsonArray[$i]['comments'][$j]['rating'] = $comments[$j]->rating;
    $jsonArray[$i]['comments'][$j]['name'] = $comments[$j]->name;
    $jsonArray[$i]['comments'][$j]['email'] = $comments[$j]->email;
	$userImage = User::where('id',$comments[$j]->user_id)->select('picture')->first();
	$jsonArray[$i]['comments'][$j]['picture'] = $userImage->picture;
    $jsonArray[$i]['comments'][$j]['comment'] = $comments[$j]->comment;
    $jsonArray[$i]['comments'][$j]['created_at'] = $comments[$j]->created_at->diffForHumans();

$voteCount = DB::table('product_vote_unvote')->where('comment_id',$comments[$j]->id)->where('product_id',$products[$i]->id)->where('vote',1)->count();
$unvoteCount = DB::table('product_vote_unvote')->where('comment_id',$comments[$j]->id)->where('product_id',$products[$i]->id)->where('unvote',1)->count();

$uservoteCount = DB::table('product_vote_unvote')->where('user_id',Auth::user()->id)->where('comment_id',$comments[$j]->id)->where('product_id',$products[$i]->id)->where('vote',1)->count();
$userunvoteCount = DB::table('product_vote_unvote')->where('user_id',Auth::user()->id)->where('comment_id',$comments[$j]->id)->where('product_id',$products[$i]->id)->where('unvote',1)->count();

$jsonArray[$i]['comments'][$j]['vote']= $voteCount;
$jsonArray[$i]['comments'][$j]['unvote'] = $unvoteCount;

$jsonArray[$i]['comments'][$j]['vote_logged_in_user']= ($uservoteCount == 1) ? true : false;
$jsonArray[$i]['comments'][$j]['unvote_logged_in_user'] = ($userunvoteCount == 1) ? true : false;

}
}else{
    $jsonArray[$i]['comments'] = array();
}
            $jsonArray[$i]['wishlist'] = (Auth::check()) ? ProductWishlist::where('product_id',$products[$i]->id)->where('user_id',Auth::user()->id)->count() : '0';
        }

        return $this->sendResponse($jsonArray, '');
		}catch(Throwable  $e){
			info($e->getMessage());
		}
    }

    function add_comment(Request $request){
        if(!Auth::check()){
            return response()->json(['status' => 'fail','message' => 'Please login to post a comment.']);
            exit;
        }
		$request->validate([
            'product_id' => 'required',
            'rating' => 'required',
            'name' => 'required',
            'email' => 'required',
            'comment' => 'required',
        ]);
        $comment = new ProductComments;
        $comment->user_id = Auth::user()->id;
        $comment->product_id = $request->product_id;
        $comment->rating = $request->rating;
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = $request->comment;
        $comment->created_at = Carbon::now();
        $comment->ipaddress = $_SERVER['REMOTE_ADDR'];
        $save = $comment->save();

        if($save){
            $comm = new ProductCommentsResource($comment);
            $array = array('comments' => [$comm]);
            return $this->sendResponse($array);
        }else{
            return response()->json(['status' => 'fail','message' => 'Unable to post a comment.']);
        }
    }

    function delete_comment(Request $request){
        if(!Auth::check()){
            return response()->json(['status' => 'fail','message' => 'Please login to delete a comment.']);
            exit;
        }
        $check = ProductComments::where('id',$request->comment_id)->where('user_id',Auth::user()->id)->count();
        if($check == 0){
            return response()->json(['status' => 'fail','message' => 'You are not authorized to delete this comment.']);
            exit;
        }
        $comment = ProductComments::find($request->comment_id);
        $delete = $comment->delete();
        if($delete){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail','message' => 'Unable to delete a comment.']);
        }
    }

    function wishlist(){
		if((Auth::user()->remainingDays() == 0) && (Auth::user()->isBasic() == true)){
			Auth::user()->subscription()->detach();
			Auth::user()->subscription()->attach(['1']);
        }
		
        $jsonArray = array();
        $wishlist = ProductWishlist::leftJoin('products','products.id','product_wishlist.product_id')->select('product_wishlist.id','product_wishlist.product_id','products.product_name','products.price','products.sale_price','products.sale_price_start_date','products.sale_price_end_date','product_wishlist.created_at')->where('product_wishlist.user_id',Auth::user()->id)->get();

        for ($i=0; $i < count($wishlist); $i++) {
            $jsonArray[$i]['id'] = $wishlist[$i]->id;
            $jsonArray[$i]['product_id'] = $wishlist[$i]->product_id;
            $jsonArray[$i]['product_name'] = $wishlist[$i]->product_name;
            $image = Product_images::where('product_id',$wishlist[$i]->product_id)->first();
            $jsonArray[$i]['image'] = isset($image->image_small) ? $image->image_small : 'https://dummyimage.com/200x300&text='.$wishlist[$i]->product_name;
            if($wishlist[$i]->sale_price_start_date <= date('Y-m-d') && $wishlist[$i]->sale_price_end_date >= date('Y-m-d')){
    			$jsonArray[$i]['price'] = $wishlist[$i]->price;
    			$jsonArray[$i]['sale_price'] = $wishlist[$i]->sale_price;
    		}else{
    			$jsonArray[$i]['price'] = $wishlist[$i]->price;
    			$jsonArray[$i]['sale_price'] = '';
    		}
            $jsonArray[$i]['created_at'] = $wishlist[$i]->created_at;
        }
        return $this->sendResponse($jsonArray, '');
    }

    function add_wishlist(Request $request){
        $request->validate([
			'product_id' => 'required|numeric'
		]);
        $id = $request->product_id;

        $check = ProductWishlist::where('product_id',$id)->where('user_id',Auth::user()->id)->count();
        if($check > 0){
            return response()->json(['status' => 'fail','message' => 'The product already added to wishlist']);
        }

        $wishlist = new ProductWishlist;
        $wishlist->user_id = Auth::user()->id;
        $wishlist->product_id = $id;
        $wishlist->created_at = Carbon::now();
        $wishlist->ipaddress = $_SERVER['REMOTE_ADDR'];
        $save = $wishlist->save();

        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    function remove_wishlist(Request $request){
        $request->validate([
			'product_id' => 'required|numeric'
		]);
        $id = $request->product_id;
        $count = ProductWishlist::where('product_id',$id)->count();
        if($count > 0){
            $save = ProductWishlist::where('product_id',$id)->where('user_id',Auth::user()->id)->delete();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
        }else{
            return response()->json(['status' => 'fail','message' => 'This product is not in wishlist.']);
        }

    }
	
	function remove_all_wishlist(Request $request){
        
        $save = ProductWishlist::where('user_id',Auth::user()->id)->delete();
        if($save){
            return response()->json(['status' => 'success']);
        }else{
            return response()->json(['status' => 'fail']);
        }
        
    }


function vote_comment(Request $request){
        $request->validate([
            'product_id' => 'required',
            'comment_id' => 'required',
        ]);

        $user_id = Auth::user()->id;
        $comment_id = $request->comment_id;
        $product_id = $request->product_id;

        $voteCheck = DB::table('product_vote_unvote')->where('user_id',$user_id)->where('comment_id',$comment_id)->where('product_id',$product_id)->where('vote',1)->count();

        if($voteCheck == 0){
            $arr = array('user_id' => $user_id,'comment_id' => $comment_id,'product_id' => $product_id,'vote' => 1,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
            $ins = DB::table('product_vote_unvote')->insert($arr);
            $msg = 'You have voted successfully.';
        }else{
            $ins = DB::table('product_vote_unvote')->where('user_id',$user_id)->where('comment_id',$comment_id)->where('vote',1)->delete();
            $msg = 'Vote removed successfully.';
        }


        if($ins){
            return response()->json(['status' => 'success','message' => $msg]);
        }else{
            return response()->json(['status' => 'fail','message' => 'Unable to vote for this comment.']);
        }
    }

    function unvote_for_comment(Request $request){
        $request->validate([
            'product_id' => 'required',
            'comment_id' => 'required',
        ]);

        $user_id = Auth::user()->id;
        $comment_id = $request->comment_id;
        $product_id = $request->product_id;

    $unvoteCheck = DB::table('product_vote_unvote')->where('user_id',$user_id)->where('comment_id',$comment_id)->where('product_id',$product_id)->where('unvote',1)->count();

    if($unvoteCheck == 0){
        $arr3 = array('user_id' => $user_id,'comment_id' => $comment_id,'product_id' => $product_id,'unvote' => 1,'created_at' => Carbon::now(),'ipaddress' => $_SERVER['REMOTE_ADDR']);
        $ins2 = DB::table('product_vote_unvote')->insert($arr3);
        $msg = 'You have unvoted successfully.';
    }else{
        $ins2 = DB::table('product_vote_unvote')->where('user_id',$user_id)->where('comment_id',$comment_id)->where('unvote',1)->delete();
        $msg = 'You have removed you unvote successfully.';
    }

        if($ins2){
            return response()->json(['status' => 'success','message' => $msg]);
        }else{
            return response()->json(['status' => 'fail','message' => 'Unable to unvote for this comment.']);
        }
}


}
