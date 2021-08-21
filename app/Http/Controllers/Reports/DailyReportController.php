<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;
use DB;
use Validator;
use Redirect;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendUsersInfo;
use App\Models\Project;

class DailyReportController extends Controller
{
    function sendProjectsReport(Request $request){
		$projects = DB::table('projects')
					->leftJoin('users', 'users.id', '=', 'projects.user_id')
					->select('projects.id','projects.name','projects.pattern_type','projects.status as project_status','projects.is_deleted','projects.created_at','users.id as user_id','users.first_name','users.last_name','users.email','users.status')
					->where('users.status',1)
					->get();
		
		$file = storage_path('users\projects.xlsx');
		$filename = storage_path('users\projects-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('projects');
		
		

		$coloumns = array('Project id','Project name','Project type','Project status','Project deleted','Project created','User id','First name','Last Name','Email','User status');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1');
		
		for ($i=0; $i < count($coloumns); $i++) { 
			$worksheet->getCell($alpha[$i])->setValue($coloumns[$i]);
		}
		
		$j = 2;
		foreach($projects as $pro){
			if($pro->project_status == 1){
				$project_status = 'Generated';
			}else if($pro->project_status == 2){
				$project_status = 'Work in progress';
			}else if($pro->project_status == 3){
				$project_status = 'Completed';
			}else{
				$project_status = 'Invalid';
			}
			
			if($pro->is_deleted == 1){
				$deleted = 'Yes';
			}else{
				$deleted = 'No';
			}
			
			if($pro->status == 1){
				$status = 'Active';
			}else{
				$status = 'InActive';
			}
			
			$worksheet->getCell('A'.$j)->setValue($pro->id);
			$worksheet->getCell('B'.$j)->setValue($pro->name);
			$worksheet->getCell('C'.$j)->setValue($pro->pattern_type);
			$worksheet->getCell('D'.$j)->setValue($project_status);
			$worksheet->getCell('E'.$j)->setValue($deleted);
			$worksheet->getCell('F'.$j)->setValue($pro->created_at);
			$worksheet->getCell('G'.$j)->setValue($pro->user_id);
			$worksheet->getCell('H'.$j)->setValue($pro->first_name);
			$worksheet->getCell('I'.$j)->setValue($pro->last_name);
			$worksheet->getCell('J'.$j)->setValue($pro->email);
			$worksheet->getCell('K'.$j)->setValue($status);

			$j++;
		}
		
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
			$save = $writer->save($filename);
			$content = file_get_contents($filename);
			
			$details = array(
        	'message' => 'Projects data till '.date('Y-m-d'),
        	'filename' => $filename,
			'subject' => 'Projects data'
        );
		
		$email = ['jane.nickerson@knitfitco.com','dnickerson@noetic-data.com','nitinb@pluraltechnology.com','rkrishna021@gmail.com'];
		//$email = ['ramagkrishna91@gmail.com'];
		
         Mail::to($email)
	    //->cc(env('REPORTS_EMAIL_CC'))
	    ->send(new SendUsersInfo($details));

	    unlink($filename);
	    exit;
		
		
	}
	
	function sendMeasurementsReport(Request $request){
		$measurements = DB::table('user_measurements')
					->leftJoin('users', 'users.id', '=', 'user_measurements.user_id')
					->select('user_measurements.id','user_measurements.m_title','user_measurements.measurement_preference','user_measurements.created_at','users.id as user_id','users.first_name','users.last_name','users.email','users.status')
					->where('users.status',1)
					->get();
					
		$file = storage_path('users\measurements.xlsx');
		$filename = storage_path('users\measurements-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('measurements');
		
		

		$coloumns = array('Measurement id','Measurement title','UOM','Measurement created','User id','First name','Last Name','Email','User status');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1','I1');
		
		for ($i=0; $i < count($coloumns); $i++) { 
			$worksheet->getCell($alpha[$i])->setValue($coloumns[$i]);
		}
		
		$j = 2;
		foreach($measurements as $pro){
			if($pro->status == 1){
				$status = 'Active';
			}else{
				$status = 'InActive';
			}
			
			$worksheet->getCell('A'.$j)->setValue($pro->id);
			$worksheet->getCell('B'.$j)->setValue($pro->m_title);
			$worksheet->getCell('C'.$j)->setValue($pro->measurement_preference);
			$worksheet->getCell('D'.$j)->setValue($pro->created_at);
			$worksheet->getCell('E'.$j)->setValue($pro->user_id);
			$worksheet->getCell('F'.$j)->setValue($pro->first_name);
			$worksheet->getCell('G'.$j)->setValue($pro->last_name);
			$worksheet->getCell('H'.$j)->setValue($pro->email);
			$worksheet->getCell('I'.$j)->setValue($status);
			$j++;
		}
		
		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
			$save = $writer->save($filename);
			$content = file_get_contents($filename);
			
			$details = array(
        	'message' => 'Measurements data till '.date('Y-m-d'),
        	'filename' => $filename,
			'subject' => 'Measurements data'
        );
		
		$email = ['jane.nickerson@knitfitco.com','dnickerson@noetic-data.com','nitinb@pluraltechnology.com','rkrishna021@gmail.com'];
		//$email = ['ramagkrishna91@gmail.com'];
		
         Mail::to($email)
	    //->cc(env('REPORTS_EMAIL_CC'))
	    ->send(new SendUsersInfo($details));

	    unlink($filename);
	    exit;
	}
	
	function sendUsersReport(Request $request){
		$sql = "SELECT DISTINCT users.id,users.first_name,users.last_name,users.email,
			IF(users.status > 0, 'Verified', 'Not Verified') AS STATUS,users.created_at,users.ipaddress,
			CASE 
			WHEN oauth_provider = 'facebook' THEN 'Facebook'
			WHEN oauth_provider = 'google' THEN 'Google'
			ELSE 'Website'
			END AS Register_From,
			subscriptions.name AS Subscription,users.sub_exp FROM users 
			LEFT JOIN user_subscriptions on user_subscriptions.user_id = users.id
			LEFT JOIN subscriptions ON subscriptions.id = user_subscriptions.subscription_id
			WHERE (users.id != 8 AND users.id != 1 AND users.id != 2 AND users.id != 6 AND users.id != 7 AND users.id != 20 AND users.id != 21 AND users.id != 22 AND users.id != 176 AND users.id != 181 AND users.id != 256 AND users.id != 420 AND users.id != 430 AND users.id != 531 AND users.id != 534 AND users.id != 535 AND users.id != 548 AND users.id != 785) ORDER BY id ASC";

		$query = DB::select(DB::raw($sql));
		
		$file = storage_path('users\users.xlsx');
		$filename = storage_path('users\users-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('Users');

		$coloumns = array('User Id','First Name','Last Name','Email','Status','Registered Date','Registered From','Subscription','Expiry','Device Type','Login Time','User Ipaddress','Subscription status','Payment Date');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1');



		for ($i=0; $i < count($coloumns); $i++) { 
			$worksheet->getCell($alpha[$i])->setValue($coloumns[$i]);
		}


		$j=2;
		foreach ($query as $key) {
		$last_login = DB::table('user_login')->where('user_id',$key->id)->latest()->first();
		if($last_login){
			$device_type = $last_login->device_type;
			$login_time = $last_login->created_at;
		}else{
			$device_type = '';
			$login_time = '';
		}
		
		$paypal_payments = DB::table('paypal_payments')->where('user_id',$key->id)->where('status','Success')->latest()->first();
		if($paypal_payments){
			$subscribed = 'Subscribed';
			$payment_date = $paypal_payments->created_at;
		}else{
			$subscribed = '';
			$payment_date = '';
		}
		
			$worksheet->getCell('A'.$j)->setValue($key->id);
			$worksheet->getCell('B'.$j)->setValue($key->first_name);
			$worksheet->getCell('C'.$j)->setValue($key->last_name);
			$worksheet->getCell('D'.$j)->setValue($key->email);
			$worksheet->getCell('E'.$j)->setValue($key->STATUS);
			$worksheet->getCell('F'.$j)->setValue($key->created_at);
			$worksheet->getCell('G'.$j)->setValue($key->Register_From);
			$worksheet->getCell('H'.$j)->setValue($key->Subscription);
			$worksheet->getCell('I'.$j)->setValue($key->sub_exp);
			$worksheet->getCell('J'.$j)->setValue($device_type);
			$worksheet->getCell('K'.$j)->setValue($login_time);
			$worksheet->getCell('L'.$j)->setValue($key->ipaddress);
			$worksheet->getCell('M'.$j)->setValue($subscribed);
			$worksheet->getCell('N'.$j)->setValue($payment_date);
		$j++;
		}



		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $save = $writer->save($filename);
        $content = file_get_contents($filename);

        $details = array(
        	'message' => 'Unique users data till '.date('Y-m-d'),
        	'filename' => $filename,
			'subject' => 'Unique users data'
        );
		
		$email = ['jane.nickerson@knitfitco.com','dnickerson@noetic-data.com','nitinb@pluraltechnology.com','rkrishna021@gmail.com'];
		//$email = ['ramagkrishna91@gmail.com'];
		
         Mail::to($email)
	    //->cc(env('REPORTS_EMAIL_CC'))
	    ->send(new SendUsersInfo($details));

	    unlink($filename);
	    exit;
	}
	
	function sendUsersWeeklyReport(){
		$currentDateTime = Carbon::today()->setTime(0, 0, 0);
        $newDateTime = Carbon::now()->subDays(7)->setTime(0, 0, 0);
		
		$sql = "SELECT DISTINCT users.id,users.first_name,users.last_name,users.email,
			IF(users.status > 0, 'Verified', 'Not Verified') AS STATUS,users.created_at,users.ipaddress,
			CASE 
			WHEN oauth_provider = 'facebook' THEN 'Facebook'
			WHEN oauth_provider = 'google' THEN 'Google'
			ELSE 'Website'
			END AS Register_From,
			subscriptions.name AS Subscription,users.sub_exp FROM users 
			LEFT JOIN user_subscriptions on user_subscriptions.user_id = users.id
			LEFT JOIN subscriptions ON subscriptions.id = user_subscriptions.subscription_id
			WHERE users.created_at > '".$newDateTime."' and (users.id != 8 AND users.id != 1 AND users.id != 2 AND users.id != 6 AND users.id != 7 AND users.id != 20 AND users.id != 21 AND users.id != 22 AND users.id != 176 AND users.id != 181 AND users.id != 256 AND users.id != 420 AND users.id != 430 AND users.id != 531 AND users.id != 534 AND users.id != 535 AND users.id != 548 AND users.id != 785) ORDER BY id ASC";

		$query = DB::select(DB::raw($sql));
		
		$file = storage_path('users\users-weekly.xlsx');
		$filename = storage_path('users\users-weekly-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('Users');

		$coloumns = array('User Id','First Name','Last Name','Email','Status','Registered Date','Registered From','Subscription','Expiry','Device Type','Login Time','User Ipaddress','Subscription status','Payment Date');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1');



		for ($i=0; $i < count($coloumns); $i++) { 
			$worksheet->getCell($alpha[$i])->setValue($coloumns[$i]);
		}


		$j=2;
		foreach ($query as $key) {
		$last_login = DB::table('user_login')->where('user_id',$key->id)->latest()->first();
		if($last_login){
			$device_type = $last_login->device_type;
			$login_time = $last_login->created_at;
		}else{
			$device_type = '';
			$login_time = '';
		}
		
		$paypal_payments = DB::table('paypal_payments')->where('user_id',$key->id)->where('status','Success')->latest()->first();
		if($paypal_payments){
			$subscribed = 'Subscribed';
			$payment_date = $paypal_payments->created_at;
		}else{
			$subscribed = '';
			$payment_date = '';
		}
		
			$worksheet->getCell('A'.$j)->setValue($key->id);
			$worksheet->getCell('B'.$j)->setValue($key->first_name);
			$worksheet->getCell('C'.$j)->setValue($key->last_name);
			$worksheet->getCell('D'.$j)->setValue($key->email);
			$worksheet->getCell('E'.$j)->setValue($key->STATUS);
			$worksheet->getCell('F'.$j)->setValue($key->created_at);
			$worksheet->getCell('G'.$j)->setValue($key->Register_From);
			$worksheet->getCell('H'.$j)->setValue($key->Subscription);
			$worksheet->getCell('I'.$j)->setValue($key->sub_exp);
			$worksheet->getCell('J'.$j)->setValue($device_type);
			$worksheet->getCell('K'.$j)->setValue($login_time);
			$worksheet->getCell('L'.$j)->setValue($key->ipaddress);
			$worksheet->getCell('M'.$j)->setValue($subscribed);
			$worksheet->getCell('N'.$j)->setValue($payment_date);
		$j++;
		}



		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $save = $writer->save($filename);
        $content = file_get_contents($filename);

        $details = array(
        	'message' => 'Unique users data till from '.$newDateTime.' to '.$currentDateTime,
        	'filename' => $filename,
			'subject' => 'Unique users data'
        );
		
		$email = ['jane.nickerson@knitfitco.com','dnickerson@noetic-data.com','caitlyn.robbins@knitfitco.com','rkrishna021@gmail.com'];
		//$email = ['ramagkrishna91@gmail.com'];
		
         Mail::to($email)
	    //->cc(env('REPORTS_EMAIL_CC'))
	    ->send(new SendUsersInfo($details));

	    unlink($filename);
	    exit;
	}
	
	function sendUsersReportWithProjectsCount(Request $request){
		$sql = "SELECT DISTINCT users.id,users.first_name,users.last_name,users.email,
			IF(users.status > 0, 'Verified', 'Not Verified') AS STATUS,users.created_at,users.ipaddress,
			CASE 
			WHEN oauth_provider = 'facebook' THEN 'Facebook'
			WHEN oauth_provider = 'google' THEN 'Google'
			ELSE 'Website'
			END AS Register_From,
			subscriptions.name AS Subscription,users.sub_exp FROM users 
			LEFT JOIN user_subscriptions on user_subscriptions.user_id = users.id
			LEFT JOIN subscriptions ON subscriptions.id = user_subscriptions.subscription_id where users.is_internal_tester = 0 ORDER BY users.id ASC";

		$query = DB::select(DB::raw($sql));
		
		$file = storage_path('users\users.xlsx');
		$filename = storage_path('users\users-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('Users');

		$coloumns = array('User Id','First Name','Last Name','Email','Status','Registered Date','Registered From','Subscription','Expiry','Device Type','Login Time','User Ipaddress','Subscription status','Payment Date','Projects','Subscription type');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1');



		for ($i=0; $i < count($coloumns); $i++) { 
			$worksheet->getCell($alpha[$i])->setValue($coloumns[$i]);
		}


		$j=2;
		foreach ($query as $key) {
		$last_login = DB::table('user_login')->where('user_id',$key->id)->latest()->first();
		if($last_login){
			$device_type = $last_login->device_type;
			$login_time = $last_login->created_at;
		}else{
			$device_type = '';
			$login_time = '';
		}
		
		$paypal_payments = DB::table('paypal_payments')->where('user_id',$key->id)->where('status','Success')->latest()->first();
		if($paypal_payments){
			$subscribed = 'Subscribed';
			$payment_date = $paypal_payments->created_at;
			
			if($paypal_payments->plan_id == 'P-664992417B445373VL4I6CFQ'){
				$subscription_type = 'Monthly';
			}else if($paypal_payments->plan_id == 'P-72C45040SG5797743L27JWOA'){
				$subscription_type = 'Yearly';
			}else{
				$subscription_type = '';
			}
		}else{
			$subscribed = '';
			$payment_date = '';
			$subscription_type = '';
		}
		
		$projectsCount = Project::where('user_id',$key->id)->where('is_deleted',0)->count();
		
			$worksheet->getCell('A'.$j)->setValue($key->id);
			$worksheet->getCell('B'.$j)->setValue($key->first_name);
			$worksheet->getCell('C'.$j)->setValue($key->last_name);
			$worksheet->getCell('D'.$j)->setValue($key->email);
			$worksheet->getCell('E'.$j)->setValue($key->STATUS);
			$worksheet->getCell('F'.$j)->setValue($key->created_at);
			$worksheet->getCell('G'.$j)->setValue($key->Register_From);
			$worksheet->getCell('H'.$j)->setValue($key->Subscription);
			$worksheet->getCell('I'.$j)->setValue($key->sub_exp);
			$worksheet->getCell('J'.$j)->setValue($device_type);
			$worksheet->getCell('K'.$j)->setValue($login_time);
			$worksheet->getCell('L'.$j)->setValue($key->ipaddress);
			$worksheet->getCell('M'.$j)->setValue($subscribed);
			$worksheet->getCell('N'.$j)->setValue($payment_date);
			$worksheet->getCell('O'.$j)->setValue($projectsCount);
			$worksheet->getCell('P'.$j)->setValue($subscription_type);
		$j++;
		}



		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $save = $writer->save($filename);
        $content = file_get_contents($filename);

        $details = array(
        	'message' => 'Users & projects data till '.date('Y-m-d'),
        	'filename' => $filename,
			'subject' => 'Users & projects data'
        );
		
		$email = ['chandra.gogineni@pluraltechnology.com','rkrishna021@gmail.com'];
		//$email = ['ramagkrishna91@gmail.com'];
		
         Mail::to($email)
	    //->cc(env('REPORTS_EMAIL_CC'))
	    ->send(new SendUsersInfo($details));

	    unlink($filename);
	    exit;
	}
}
