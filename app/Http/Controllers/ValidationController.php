<?php

namespace App\Http\Controllers;

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
use App\Mail\SendSalesInformationMail;
use App\Mail\SendSubscriptionInformationMail;

class ValidationController extends Controller
{
    function validate_first_name(Request $request){
    	$validator = $request->validate([
            'first_name' => 'required|alpha|min:2|max:15',
        ]);
    }
	
	function send_email(){
    	
    	$sql = "SELECT DISTINCT users.id,users.first_name,users.last_name,users.email,
IF(users.status > 0, 'Verified', 'Not Verified') AS STATUS,users.created_at,users.ipaddress,
			CASE 
			WHEN oauth_provider = 'facebook' THEN 'Facebook'
			WHEN oauth_provider = 'google' THEN 'Google'
			ELSE 'Website'
			END AS Register_From,
			subscriptions.name AS Subscription,users.sub_exp,
			user_measurements.m_title,projects.name,projects.pattern_type,projects.status as project_status FROM users 
			LEFT JOIN user_subscriptions on user_subscriptions.user_id = users.id
			LEFT JOIN subscriptions ON subscriptions.id = user_subscriptions.subscription_id
			LEFT JOIN user_measurements ON user_measurements.user_id = users.id 
			LEFT JOIN projects on projects.user_id = users.id
			WHERE (users.id != 8 AND users.id != 1 AND users.id != 2 AND users.id != 6 AND users.id != 7 AND users.id != 20 AND users.id != 21 AND users.id != 22 AND users.id != 176 AND users.id != 181 AND users.id != 256 AND users.id != 420 AND users.id != 430 AND users.id != 531 AND users.id != 534 AND users.id != 535 AND users.id != 548 AND users.id != 785) ORDER BY id ASC";

		$query = DB::select(DB::raw($sql));
		
		$file = storage_path('users\users.xlsx');
		$filename = storage_path('users\users-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('Users');

		$coloumns = array('User Id','First Name','Last Name','Email','Status','Registered Date','Registered From','Subscription','Expiry','Measurement Name','Project Name','Project Type','Project status');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1',);



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
		
		if($key->project_status == 1){
			$project_status = 'Generated';
		}else if($key->project_status == 2){
			$project_status = 'Work in progress';
		}else if($key->project_status == 3){
			$project_status = 'Completed';
		}else{
			$project_status = 'Deleted / InActive';
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
			$worksheet->getCell('J'.$j)->setValue($key->m_title);
			$worksheet->getCell('K'.$j)->setValue($key->name);
			$worksheet->getCell('L'.$j)->setValue($key->pattern_type);
			$worksheet->getCell('M'.$j)->setValue($project_status);
			/*$worksheet->getCell('N'.$j)->setValue($device_type);
			$worksheet->getCell('O'.$j)->setValue($login_time);
			$worksheet->getCell('P'.$j)->setValue($key->ipaddress);
			$worksheet->getCell('Q'.$j)->setValue($subscribed);
			$worksheet->getCell('R'.$j)->setValue($payment_date);*/
		$j++;
		}



		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $save = $writer->save($filename);
        $content = file_get_contents($filename);

        $details = array(
        	'message' => 'Users data till '.date('Y-m-d'),
        	'filename' => $filename,
			'subject' => 'Unique users data with projects and measurements'
        );
		
		$email = ['jane.nickerson@knitfitco.com','dnickerson@noetic-data.com','nitinb@pluraltechnology.com','rkrishna021@gmail.com'];
		//$email = ['rkrishna021@gmail.com','ramagkrishna91@gmail.com','krama998@gmail.com'];
		
         Mail::to($email)
	    //->cc(env('REPORTS_EMAIL_CC'))
	    ->send(new SendUsersInfo($details));

	    unlink($filename);
	    exit;
    }
	
	
	function send_unique_users_email(){
    	
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
		/*if($paypal_payments){
			if($key->Subscription == 'Basic'){
				$subscribed = 'Subscribed';
				$payment_date = $paypal_payments->created_at;
			}else{
				$subscribed = '';
				$payment_date = '';
			}
			
		}else{
			$subscribed = '';
			$payment_date = '';
		}*/
		
			if($key->Subscription == 'Basic'){
				$subscribed = 'Subscribed';
				if($paypal_payments){
					$payment_date = $paypal_payments->created_at;
				}else{
					$payment_date = '';
				}
				
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
		//$email = ['rkrishna021@gmail.com'];
		
         Mail::to($email)
	    //->cc(env('REPORTS_EMAIL_CC'))
	    ->send(new SendUsersInfo($details));

	    unlink($filename);
	    exit;
    }


    function download_excel(){
    	
    	$sql = "SELECT DISTINCT users.id,users.first_name,users.last_name,users.email,
IF(users.status > 0, 'Verified', 'Not Verified') AS STATUS,users.created_at,users.ipaddress,
			CASE 
			WHEN oauth_provider = 'facebook' THEN 'Facebook'
			WHEN oauth_provider = 'google' THEN 'Google'
			ELSE 'Website'
			END AS Register_From,
			subscriptions.name AS Subscription,users.sub_exp,
			user_measurements.m_title,projects.name,projects.pattern_type,projects.status as project_status FROM users 
			LEFT JOIN user_subscriptions on user_subscriptions.user_id = users.id
			LEFT JOIN subscriptions ON subscriptions.id = user_subscriptions.subscription_id
			LEFT JOIN user_measurements ON user_measurements.user_id = users.id 
			LEFT JOIN projects on projects.user_id = users.id
			WHERE (users.id != 8 AND users.id != 1 AND users.id != 2 AND users.id != 6 AND users.id != 7 AND users.id != 20 AND users.id != 21 AND users.id != 22 AND users.id != 176 AND users.id != 181 AND users.id != 256 AND users.id != 420 AND users.id != 430 AND users.id != 531 AND users.id != 534 AND users.id != 535 AND users.id != 548 AND users.id != 785) ORDER BY id ASC";

		$query = DB::select(DB::raw($sql));
		
		$file = storage_path('users\users.xlsx');
		$filename = storage_path('users\users-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('Users');

		$coloumns = array('User Id','First Name','Last Name','Email','Status','Registered Date','Registered From','Subscription','Expiry','Measurement Name','Project Name','Project Type','Project Status','Device Type','Login Time','User Ipaddress','Subscription status','Payment Date');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1','R1');



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
		
		if($key->project_status == 1){
			$project_status = 'Generated';
		}else if($key->project_status == 2){
			$project_status = 'Work in progress';
		}else if($key->project_status == 3){
			$project_status = 'Completed';
		}else{
			$project_status = 'Deleted / InActive';
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
			$worksheet->getCell('J'.$j)->setValue($key->m_title);
			$worksheet->getCell('K'.$j)->setValue($key->name);
			$worksheet->getCell('L'.$j)->setValue($key->pattern_type);
			$worksheet->getCell('M'.$j)->setValue($project_status);
			$worksheet->getCell('N'.$j)->setValue($device_type);
			$worksheet->getCell('O'.$j)->setValue($login_time);
			$worksheet->getCell('P'.$j)->setValue($key->ipaddress);
			$worksheet->getCell('Q'.$j)->setValue($subscribed);
			$worksheet->getCell('R'.$j)->setValue($payment_date);
		$j++;
		}



		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $save = $writer->save($filename);
        $content = file_get_contents($filename);

      /*  $details = array(
        	'message' => 'Users data till '.date('Y-m-d'),
        	'filename' => $filename
        );

         Mail::to('rkrishna021@gmail.com')
	    ->cc('ramagkrishna91@gmail.com')
	    ->send(new SendUsersInfo($details)); */

	    header("Content-Disposition: attachment; filename=users-".date('Y-m-d').".xlsx");
		unlink($filename);
		exit($content);
    }
	
    /* function send_email(){
    	
    	$sql = "SELECT users.id,users.first_name,users.last_name,users.email,IF(users.status > 0, 'Verified', 'Not Verified') AS STATUS,users.created_at,users.ipaddress,
			CASE 
			WHEN oauth_provider = 'facebook' THEN 'Facebook'
			WHEN oauth_provider = 'google' THEN 'Google'
			ELSE 'Website'
			END AS Register_From,
			subscriptions.name AS Subscription,users.sub_exp,
			user_measurements.m_title,projects.name,projects.pattern_type FROM users 
			LEFT JOIN user_measurements ON user_measurements.user_id = users.id LEFT JOIN projects on projects.user_id = users.id
			LEFT JOIN subscriptions ON subscriptions.id = users.subscription_type 
			WHERE (users.id != 8 AND users.id != 1 AND users.id != 2 AND users.id != 6 AND users.id != 7 AND users.id != 20 AND users.id != 21 AND users.id != 22) ORDER BY id ASC";

		$query = DB::select(DB::raw($sql));
		
		$file = storage_path('users\users.xlsx');
		$filename = storage_path('users\users-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('Users');

		$coloumns = array('First Name','Last Name','Email','Status','Registered Date','Registered From','Subscription','Expiry','Measurement Name','Project Name','Project Type','User Ipaddress');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1');



		for ($i=0; $i < count($coloumns); $i++) { 
			$worksheet->getCell($alpha[$i])->setValue($coloumns[$i]);
		}


		$j=2;
		foreach ($query as $key) {
			//$worksheet->getCell('A'.$j)->setValue($key->id);
			$worksheet->getCell('A'.$j)->setValue($key->first_name);
			$worksheet->getCell('B'.$j)->setValue($key->last_name);
			$worksheet->getCell('C'.$j)->setValue($key->email);
			$worksheet->getCell('D'.$j)->setValue($key->STATUS);
			$worksheet->getCell('E'.$j)->setValue($key->created_at);
			$worksheet->getCell('F'.$j)->setValue($key->Register_From);
			$worksheet->getCell('G'.$j)->setValue($key->Subscription);
			$worksheet->getCell('H'.$j)->setValue($key->sub_exp);
			$worksheet->getCell('I'.$j)->setValue($key->m_title);
			$worksheet->getCell('J'.$j)->setValue($key->name);
			$worksheet->getCell('K'.$j)->setValue($key->pattern_type);
			$worksheet->getCell('L'.$j)->setValue($key->ipaddress);
		$j++;
		}



		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $save = $writer->save($filename);
        $content = file_get_contents($filename);

        $details = array(
        	'message' => 'Users data till '.date('Y-m-d'),
        	'filename' => $filename
        );
		
		/* Mail::to('rkrishna021@gmail.com')->send(new SendUsersInfo($details)); *

         //$email = ['jane.nickerson@knitfitco.com','dnickerson@noetic-data.com','caitlyn.robbins@knitfitco.com'];
         $email = ['rkrishna021@gmail.com'];
         Mail::to($email)
	    ->send(new SendUsersInfo($details));
	
	    unlink($filename);
	    exit;
    }


    function download_excel(){
    	
    	$sql = "SELECT users.id,users.first_name,users.last_name,users.email,IF(users.status > 0, 'Verified', 'Not Verified') AS STATUS,users.created_at,
			CASE 
			WHEN oauth_provider = 'facebook' THEN 'Facebook'
			WHEN oauth_provider = 'google' THEN 'Google'
			ELSE 'Website'
			END AS Register_From,
			subscriptions.name AS Subscription,users.sub_exp,
			user_measurements.m_title,projects.name,projects.pattern_type FROM users 
			LEFT JOIN user_measurements ON user_measurements.user_id = users.id LEFT JOIN projects on projects.user_id = users.id
			LEFT JOIN subscriptions ON subscriptions.id = users.subscription_type 
			WHERE (users.id != 8 AND users.id != 1 AND users.id != 2 AND users.id != 6 AND users.id != 7 AND users.id != 20 AND users.id != 21 AND users.id != 22) ORDER BY id ASC";

		$query = DB::select(DB::raw($sql));
		
		$file = storage_path('users\users.xlsx');
		$filename = storage_path('users\users-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('Users');

		$coloumns = array('First Name','Last Name','Email','Status','Registered Date','Registered From','Subscription','Expiry','Measurement Name','Project Name','Project Type');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1');



		for ($i=0; $i < count($coloumns); $i++) { 
			$worksheet->getCell($alpha[$i])->setValue($coloumns[$i]);
		}


		$j=2;
		foreach ($query as $key) {
			//$worksheet->getCell('A'.$j)->setValue($key->id);
			$worksheet->getCell('A'.$j)->setValue($key->first_name);
			$worksheet->getCell('B'.$j)->setValue($key->last_name);
			$worksheet->getCell('C'.$j)->setValue($key->email);
			$worksheet->getCell('D'.$j)->setValue($key->STATUS);
			$worksheet->getCell('E'.$j)->setValue($key->created_at);
			$worksheet->getCell('F'.$j)->setValue($key->Register_From);
			$worksheet->getCell('G'.$j)->setValue($key->Subscription);
			$worksheet->getCell('H'.$j)->setValue($key->sub_exp);
			$worksheet->getCell('I'.$j)->setValue($key->m_title);
			$worksheet->getCell('J'.$j)->setValue($key->name);
			$worksheet->getCell('K'.$j)->setValue($key->pattern_type);
		$j++;
		}



		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $save = $writer->save($filename);
        $content = file_get_contents($filename);

      /*  $details = array(
        	'message' => 'Users data till '.date('Y-m-d'),
        	'filename' => $filename
        );

         Mail::to('rkrishna021@gmail.com')
	    ->cc('ramagkrishna91@gmail.com')
	    ->send(new SendUsersInfo($details)); 

	    header("Content-Disposition: attachment; filename=users-".date('Y-m-d').".xlsx");
		unlink($filename);
		exit($content);
    } */

    function download_excel_request(Request $request){
    	$start_date = date('Y-m-d 00:00:00',strtotime($request->start_date));
    	$end_date = date('Y-m-d 00:00:00',strtotime($request->end_date));


    	$sql = "SELECT DISTINCT users.id,users.first_name,users.last_name,users.email,
IF(users.status > 0, 'Verified', 'Not Verified') AS STATUS,users.created_at,users.ipaddress,
			CASE 
			WHEN oauth_provider = 'facebook' THEN 'Facebook'
			WHEN oauth_provider = 'google' THEN 'Google'
			ELSE 'Website'
			END AS Register_From,
			subscriptions.name AS Subscription,users.sub_exp,
			user_measurements.m_title,projects.name,projects.pattern_type FROM users 
			LEFT JOIN user_subscriptions on user_subscriptions.user_id = users.id
			LEFT JOIN subscriptions ON subscriptions.id = user_subscriptions.subscription_id
			LEFT JOIN user_measurements ON user_measurements.user_id = users.id 
			LEFT JOIN projects on projects.user_id = users.id
			WHERE (users.id != 8 AND users.id != 1 AND users.id != 2 AND users.id != 6 AND users.id != 7 AND users.id != 20 AND users.id != 21 AND users.id != 22 AND users.id != 176 AND users.id != 181 AND users.id != 256 AND users.id != 420 AND users.id != 430 AND users.id != 531 AND users.id != 534 AND users.id != 535 AND users.id != 548 AND users.id != 785) and users.status = 1 and (users.created_at >= '".$start_date."' and users.created_at <= '".$end_date."') ORDER BY id ASC";

		$query = DB::select(DB::raw($sql));
		
		$file = storage_path('users\users.xlsx');
		$filename = storage_path('users\users-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('Users');

		$coloumns = array('User Id','First Name','Last Name','Email','Status','Registered Date','Registered From','Subscription','Expiry','Measurement Name','Project Name','Project Type','Device Type','Login Time','User Ipaddress','Subscription status','Payment Date');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1','Q1');



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
			$worksheet->getCell('J'.$j)->setValue($key->m_title);
			$worksheet->getCell('K'.$j)->setValue($key->name);
			$worksheet->getCell('L'.$j)->setValue($key->pattern_type);
			$worksheet->getCell('M'.$j)->setValue($device_type);
			$worksheet->getCell('N'.$j)->setValue($login_time);
			$worksheet->getCell('O'.$j)->setValue($key->ipaddress);
			$worksheet->getCell('P'.$j)->setValue($subscribed);
			$worksheet->getCell('Q'.$j)->setValue($payment_date);
		$j++;
		}



		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $save = $writer->save($filename);
        $content = file_get_contents($filename);
        

    	if($request->type == 'email'){

    		$details = array(
        	'message' => 'Users data till '.date('Y-m-d'),
        	'filename' => $filename,
        	'dates' => 'Users data between '.$start_date.' and '.$end_date
        );
	
		$email = ['rkrishna021@gmail.com'];
         Mail::to($email)
	    ->send(new SendUsersInfo($details));
	    unlink($filename);
		}else{
			$content = file_get_contents($filename);
			header("Content-Disposition: attachment; filename=users-".date('Y-m-d').".xlsx");
			exit($content);
		}

		exit;
		
    }
	
	function get_login_with_user_id(Request $request){
		$user_id = $request->user_id;
		Auth::loginUsingId($user_id, true);
		if(Auth::user()->hasRole('Knitter')){
			return redirect('knitter/dashboard');
		}else if(Auth::user()->hasRole('Designer')){
			return redirect('designer/main/dashboard');
		}else{
			return response()->json(["error" => "seems you dont have any role here.Please contact administrator."]);
		}
	}
	
	
	function get_products_purchase(){
		$yesterday = date("Y-m-d 00:00:00", mktime(0, 0, 0, date("m") , date("d")-40,date("Y")));
		$today = date('Y-m-d 23:59:59');
		$users = User::leftJoin('orders','orders.user_id','users.id')
					->leftJoin('booking_process','booking_process.order_id','orders.id')
					->select('users.id','users.first_name','users.last_name','users.email','orders.order_number','orders.order_status','orders.order_date','booking_process.product_id','booking_process.product_name','booking_process.setpayment')
					->where('users.is_internal_tester',0)
					//->where('orders.order_status','Success')
					//->whereBetween('orders.order_date',[$yesterday,$today])
					->get();

		$file = storage_path('users\user-purchase.xlsx');
		$filename = storage_path('users\user-purchase-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('Users');

		$coloumns = array('User Id','First Name','Last Name','Email','Order id','Order status','Order date','Product id','Product name','Sale price');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1','I1','J1');



		for ($i=0; $i < count($coloumns); $i++) { 
			$worksheet->getCell($alpha[$i])->setValue($coloumns[$i]);
		}


		$j=2;
		foreach ($users as $key) {
			$worksheet->getCell('A'.$j)->setValue($key->id);
			$worksheet->getCell('B'.$j)->setValue($key->first_name);
			$worksheet->getCell('C'.$j)->setValue($key->last_name);
			$worksheet->getCell('D'.$j)->setValue($key->email);
			$worksheet->getCell('E'.$j)->setValue($key->order_number);
			$worksheet->getCell('F'.$j)->setValue($key->order_status);
			$worksheet->getCell('G'.$j)->setValue($key->order_date);
			$worksheet->getCell('H'.$j)->setValue($key->product_id);
			$worksheet->getCell('I'.$j)->setValue($key->product_name);
			$worksheet->getCell('J'.$j)->setValue(number_format($key->setpayment),2);
		$j++;
		}



		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $save = $writer->save($filename);
        $content = file_get_contents($filename);

        $details = array(
        	'message' => 'Sales information till '.date('Y-m-d'),
        	'filename' => $filename,
			'subject' => 'Sales information'
        );
		
		//$email = ['jane.nickerson@knitfitco.com','dnickerson@noetic-data.com','caitlyn.robbins@knitfitco.com','nitinb@pluraltechnology.com','rkrishna021@gmail.com'];
		$email = ['rkrishna021@gmail.com'];
		
         Mail::to($email)
	    //->cc(env('REPORTS_EMAIL_CC'))
	    ->send(new SendSalesInformationMail($details));

	    unlink($filename);
	    exit;	
	}
	
	function get_all_subscription_users_data(){
		$users = User::where('status',1)->where('is_internal_tester',0)->get();
		

		$file = storage_path('users\users.xlsx');
		$filename = storage_path('users\users-'.date('Y-m-d').'.xlsx');

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
		$worksheet = $spreadsheet->getSheetByName('Users');

		$coloumns = array('User Id','First Name','Last Name','Email','Subscription','Amount','Subscription Date','Expiry');
		$alpha = array('A1','B1','C1','D1','E1','F1','G1','H1');


		for ($i=0; $i < count($coloumns); $i++) { 
			$worksheet->getCell($alpha[$i])->setValue($coloumns[$i]);
		}

		$j=2;
		foreach ($users as $key) {
		$paypal_payments = DB::table('paypal_payments')->where('user_id',$key->id)->where('status','Success')->latest()->first();
		if($paypal_payments){
			$expiry = $paypal_payments->expiry;
			$payment_date = $paypal_payments->created_at;
			if($paypal_payments->plan_id == 'P-70289111JT019254YL4LLIIQ'){
				$amount = '2.99';
			}else{
				$amount = '24.99';
			}
		}else{
			$expiry = '';
			$payment_date = '';
			$amount = '';
		}

		if($key->hasSubscription('Free')){
			$subscription = 'Free';
		}else if($key->hasSubscription('Basic')){
			$subscription = 'Basic';
		}else{
			$subscription = '';
		}



			$worksheet->getCell('A'.$j)->setValue($key->id);
			$worksheet->getCell('B'.$j)->setValue($key->first_name);
			$worksheet->getCell('C'.$j)->setValue($key->last_name);
			$worksheet->getCell('D'.$j)->setValue($key->email);
			$worksheet->getCell('E'.$j)->setValue($subscription);
			$worksheet->getCell('F'.$j)->setValue($amount);
			$worksheet->getCell('G'.$j)->setValue($payment_date);
			$worksheet->getCell('H'.$j)->setValue($expiry);
		$j++;
		}

		$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $save = $writer->save($filename);
        $content = file_get_contents($filename);

        $details = array(
        	'message' => 'Ssubscription information till '.date('Y-m-d'),
        	'filename' => $filename,
			'subject' => 'Ssubscription information'
        );
		
		//$email = ['jane.nickerson@knitfitco.com','dnickerson@noetic-data.com','caitlyn.robbins@knitfitco.com','nitinb@pluraltechnology.com','rkrishna021@gmail.com'];
		$email = ['rkrishna021@gmail.com'];
		
         Mail::to($email)
	    //->cc(env('REPORTS_EMAIL_CC'))
	    ->send(new SendSubscriptionInformationMail($details));

	    unlink($filename);
	    exit;	
	}
}
