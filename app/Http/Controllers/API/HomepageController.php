<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;
use App\Mail\ContactFormMail;
use Carbon\Carbon;
use Validator;
use Mail;
use Redirect;
use DB;
use App\Mail\NewsletterAdminMail;
use App\Mail\NewsletterMail;
use \DrewM\MailChimp\MailChimp;

class HomepageController extends Controller
{
    function contact_us(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:2|max:25|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 0,'errors'=> $validator->getMessageBag()->toArray()]);
            exit;
        }

        $contact = new ContactUs;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        $contact->created_at = Carbon::now();
        $contact->ipaddress = $_SERVER['REMOTE_ADDR'];
        $save = $contact->save();

        if($save){
            $details = [
                'detail'=>'detail',
                'name'  => ucwords($request->name),
                'email' => $request->email,
                'message' => $request->message
                 ];

        \Mail::to('jane.nickerson@knitfitco.com')->send(new ContactFormMail($details));
        return response()->json(['status' => 1]);
        }else{
            return response()->json(['status' => 0]);
        }
    }


    function SignupNewsletter(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required|email'
        ]);
		
		if(isset($request->sub_type)){
			$sub_type = $request->sub_type;
		}else{
			$sub_type = 'signup';
		}

        if ($validator->fails()) {
            return response()->json(['status' => 0,'errors'=> $validator->getMessageBag()->toArray()]);
            exit;
        }

$subCount = DB::table('subscription')->count();
$newCount = $subCount+1;
$array = array('token' => md5($newCount),'subscription_type' => $sub_type,'email' => $request->email,'ipaddress' => $_SERVER['REMOTE_ADDR'],'created_at' => Carbon::now());

$save = DB::table('subscription')->insert($array);


        if($save){
$list_id = 'b4faf39507';
$MailChimp = new MailChimp('3a63ca7f3d9feb8c9a9145f32db52bb7-us4');
$result = $MailChimp->post("lists/".$list_id."/members", [
'email_address' => $request->email,
'status'        => 'subscribed',
]);

            $details = [
                'detail'=>'Signup',
                'email' => $request->email
                 ];

        \Mail::to('jane.nickerson@knitfitco.com')->send(new NewsletterAdminMail($details));
        return response()->json(['status' => 1]);
        }else{
            return response()->json(['status' => 0]);
        }
    }
}
