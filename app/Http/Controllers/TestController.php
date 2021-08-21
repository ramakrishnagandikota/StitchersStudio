<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\UserMeasurements;
use App\User;
use Session;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use File;

class TestController extends Controller
{
    function index(){
		$products = Products::where('id','>=',13)->get();
		return view('Test.index',compact('products'));
	}
	
	function measurements(Request $request){
		if($request->user_id){
			$user_id = $request->user_id;
			$measurements = UserMeasurements::where('user_id',$request->user_id)->get();
		}else{
			$measurements = array();
		}
		$user = User::where('status',1)->get();
		return view('Test.measurements',compact('measurements','user','user_id'));
	}
	
	function replicate_measurements(Request $request){
		try{
			
			if($request->measurement_id){
				for($i=0;$i<count($request->measurement_id);$i++){
					$measurement_id = $request->measurement_id[$i];
					$measurements = UserMeasurements::find($measurement_id);
					$newmeasurements = $measurements->replicate();
					$newmeasurements->user_id = $request->user_id;
					$newmeasurements->save();
				}
			}
			
			Session::flash('success','Measurements copied to user successfully.');
			
			return redirect()->back();
		}catch(\Exception $e){
			echo $e->getMessage();
		}
	}
	
	function excel(){
		$targetPath = storage_path('Janemeasurements.xlsx');
		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
		$worksheet = $spreadsheet->getSheetByName('Janemeasurements');
		
		
			
		
	}
	
	
}
