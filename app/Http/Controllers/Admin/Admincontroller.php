<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Models\MeasurementVariables;
use File;
use Image;
use App\Mail\SendInvitationToDesigner;
use Mail;

class Admincontroller extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    function get_admin_home(){
        if(!Auth::user()->hasRole('Admin')){
            return response()->json(['error' => 'You have loggedin with a different role.']);
            exit;
        }
        //$measurements = MeasurementVariables::all();
        $measurements = 0;
        return view('admin/index',compact('measurements'));
    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }

    function upload_image(Request $request){
        $image = $request->file('file');
        $oname = $this->clean($image->getClientOriginalName());
            $filename = time().'-'.$oname;
            $ext = $image->getClientOriginalExtension();

         $s3 = \Storage::disk('s3');
        //exit;
        $filepath = 'knitfit/'.strtolower($filename);


        $ext = 'jpg';
        $img = Image::make($image);
        $height = Image::make($image)->height();
        $width = Image::make($image)->width();
        $img->orientate();
        $img->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->encode('jpg');
        $pu = $s3->put('/'.$filepath, $img->__toString(), 'public');


       if($pu){
         return response()->json(['path1' => $filepath, 'path' => 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath,'ext' => $ext]);
     }else{
        echo 'error';
     }

    }

    function update_measurements_index(Request $request){
        $id = $request->id;
        for ($i=0; $i < count($id); $i++) {
            $meas = MeasurementVariables::find($id[$i]);
            $meas->variable_image = $request->image[$i];
            $meas->variable_description = $request->variable_description[$i];
            $meas->save();
        }

        return redirect()->back();
    }

    public function UserInvitation()
    {
        $users = User::where('status',1)->get();
        return view('Admin.UserInvitation.index',compact('users'));
    }

    public function SendInvitation(Request $request)
    {
        $designer_name = $request->designer_name;
        $user = User::where('email',$designer_name)->first();
        if($user){
            if($user->hasRole('Designer')){
                return response()->json(['status' => false,"message" => 'This user already has a designer role.']);
            }else{
            
                User::where('id',$user->id)->update(['invited_as_designer' => 1]);

                $ccMail = array("rkrishna021@gmail.com");
                $details =  [
                    'adminName' => Auth::user()->first_name,
                    'userName' => $user->first_name,
                    'title' => "You are invited as a designer.click on the below link and get access.",
                    'message' => "<a href='".url("login?identity=".base64_encode($designer_name)."&invited=yes&new=no")."'>Click here & get access</a>",
                    'alreadyUer' => true,
                ];
                \Mail::to($user->email)->cc($ccMail)->send(new SendInvitationToDesigner($details));
                    return response()->json(['status' => true,"message" => 'User invited successfully.']);
            }
        }else{
            $ccMail = array("rkrishna021@gmail.com");
                $details =  [
                    'adminName' => Auth::user()->first_name,
                    'userName' => $designer_name,
                    'title' => "You are invited as a designer.click on the below link and get access.",
                    'message' => "<a href='".url("register?identity=".base64_encode($designer_name)."&invited=yes&new=yes")."'>Click here & get access</a>",
                    'alreadyUer' => false,
                ];
                \Mail::to($designer_name)->cc($ccMail)->send(new SendInvitationToDesigner($details));
                    return response()->json(['status' => true,"message" => 'User invited successfully']);
        }
    }
}
