<?php

namespace App\Http\Controllers\Designer;

use App\Http\Controllers\Controller;
use App\Models\Booking_process;
use App\Models\Orders;
use App\Models\Products;
use Illuminate\Http\Request;
use App\User;
use Auth;
use DB;

class SalesController extends Controller
{
    function __construct(){
        $this->middleware(['auth']);
    }

    function index(Request $request){
        /*$p = DB::select(DB::raw("SELECT orders.id,orders.order_number,orders.designer_id,products.designer_name,products.id AS pid,products.product_name FROM orders LEFT JOIN booking_process bp ON bp.order_id = orders.id
LEFT JOIN products ON products.id = bp.product_id ORDER BY products.id desc"));

        for ($i=0;$i<count($p);$i++){
			//echo 'order_number = '.$p[$i]->order_number.' - designer_id = '.$p[$i]->designer_id.' - pid = '.$p[$i]->pid.' product_name = '.$p[$i]->product_name.' designer_name = '.$p[$i]->designer_name.'<br>';
            $array = array('designer_id' => $p[$i]->designer_name);//
            Orders::where('id',$p[$i]->id)->update($array);
			echo 'Updated order id = '.$p[$i]->id.'<br>';
        }
        exit;*/

        if($request->ajax()){
            $jsonArray = array();
            $orders = Orders::leftJoin('booking_process','booking_process.order_id','orders.id')
                    ->select('orders.*','booking_process.product_id','booking_process.product_name','booking_process.setpayment')
                    ->where('orders.designer_id',Auth::user()->id)->orderBy('orders.order_number','DESC')->get();
            for ($i=0;$i<count($orders);$i++){
                $user = User::where('id',$orders[$i]->user_id)->first();
                $jsonArray[$i]['id'] = $orders[$i]->order_number;
                $jsonArray[$i]['product_name'] = $orders[$i]->product_name;
                $jsonArray[$i]['sold_on'] = $orders[$i]->order_date;
                $jsonArray[$i]['status'] = ($orders[$i]->order_status == 'Cancled') ? 'Canceled' : $orders[$i]->order_status;
                $jsonArray[$i]['price'] = number_format($orders[$i]->setpayment,2);
                $jsonArray[$i]['purchased_by'] = $user ? $user->first_name.' '.$user->last_name : '';
            }
            return response()->json(['data' => $jsonArray]);
        }
        return view('Pages.Sales.index');
    }

    function getChartData(Request $request){
        if($request->year){
            $year = $request->year;
        }else{
            $year = date('Y');
        }

        if($request->month){
            $month = $request->month;
            $currentMonth = date('F', mktime(0, 0, 0, $month, 10));
        }else{
            $month = date('m');
            $currentMonth = date('F');
        }

        $jsonArray = array();

        $products = Products::leftJoin('booking_process','booking_process.product_id','products.id')
                    ->leftJoin('orders','orders.id','booking_process.product_id')
                    ->select('booking_process.product_id',DB::raw('COUNT(booking_process.product_id) as count'))
                    ->where('products.designer_name',Auth::user()->id)
                    ->where('orders.order_status','Success')
                    ->whereYear('booking_process.created_at',$year)
                    ->whereMonth('booking_process.created_at',$month)
                    ->groupBy('product_id')
                    ->havingRaw('COUNT(product_id)')
                    ->orderByRaw('COUNT(product_id) DESC')
                    ->limit(10)
                    ->get();

        //print_r($products);
        for ($i=0;$i<count($products);$i++){
            $pro = Products::where('id',$products[$i]->product_id)->first();
            $jsonArray[$i]['name'] = $pro->product_name;
            $jsonArray[$i]['data'] = [$products[$i]->count];
        }

        return response()->json(['month' => $currentMonth,'products' => $jsonArray,'year' => $year]);
    }

    function getPieChartData(Request $request){
        if($request->year){
            $year = $request->year;
        }else{
            $year = date('Y');
        }

        $jsonArray = array();
        $products = Products::leftJoin('booking_process','booking_process.product_id','products.id')
            ->leftJoin('orders','orders.id','booking_process.product_id')
            ->select('booking_process.product_id',DB::raw('COUNT(booking_process.product_id) as count,SUM(setpayment) as sp'))
            ->where('products.designer_name',Auth::user()->id)
            ->where('orders.order_status','Success')
            ->whereYear('booking_process.created_at',$year)
            ->groupBy('product_id')
            ->havingRaw('COUNT(product_id)')
            ->orderByRaw('COUNT(product_id) DESC')
            ->limit(10)
            ->get();

        for ($i=0;$i<count($products);$i++){
            $pro = Products::where('id',$products[$i]->product_id)->first();
            $jsonArray[$i]['name'] = $pro->product_name;
            $orderCount = Booking_process::where('product_id',$products[$i]->product_id)->whereYear('created_at',$year)->count();
            $jsonArray[$i]['y'] = $orderCount;
            $jsonArray[$i]['z'] = (float) number_format($products[$i]->sp,2);
        }
        return response()->json(['products' => $jsonArray,'year' => $year]);
    }
}
