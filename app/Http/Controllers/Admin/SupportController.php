<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Support;
use App\Models\SupportComments;
use App\Models\SupportAttachments;
use App\Models\SupportCommentsAttachments;
use Auth;
use App\User;
use Carbon\Carbon;
use DB;
use Mail;
use Image;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Str;
use App\Mail\SupportTicketCreationMail;
use App\Mail\SupportTicketReplyMail;
use App\Notifications\SupportTicketClose;
use App\Notifications\SupportTicketCreation;
use App\Notifications\SupportTicketReInitiate;
use App\Notifications\SupportTicketReply;
use App\Notifications\SupportTicketResolve;
use App\Notifications\SupportTicketCreationToUser;

class SupportController extends Controller
{
    function index(Request $request){
        $jsonArray = array();
        if($request->ajax()){
            $support = Support::latest()->get();
            for ($i=0;$i<count($support);$i++){
                if($support[$i]->pattern_name != ''){
                    $product = Products::where('id',$support[$i]->pattern_name)->first();
                    $name = $product ? $product->product_name : '';
                }else{
                    $name = $support[$i]->other_name.'(Other)';
                }
                $jsonArray[$i]['ticket_id'] = '<a href="'.url("admin/support/".$support[$i]->ticket_id."/show").'" class="link">'.$support[$i]->ticket_id.'</a>';
                $jsonArray[$i]['pattern_name'] = $name;
                $jsonArray[$i]['subject'] = $support[$i]->subject;
                if($support[$i]->status == 1){
                    $jsonArray[$i]['status'] = '<span class="red-border"><i class="fa fa-circle text-danger m-r-10"></i>Open</span>';
                }else if($support[$i]->status == 2){
                    $jsonArray[$i]['status'] = '<span class="blue-border"><i class="fa fa-circle text-primary m-r-10"></i>In progress</span>';
                }else if($support[$i]->status == 3){
                    $jsonArray[$i]['status'] = '<span class="orange-border"><i class="fa fa-circle text-success m-r-10"></i>Resolved</span>';
                }else{
                    $jsonArray[$i]['status'] = '<span class="green-border"><i class="fa fa-circle text-warning m-r-10"></i>Closed</span>';
                }

                if($support[$i]->priority == 1){
                    $jsonArray[$i]['priority'] = '<label class="label label-success">Low</label>';
                }else if($support[$i]->priority == 2){
                    $jsonArray[$i]['priority'] = '<label class="label label-primary">Medium</label>';
                }else{
                    $jsonArray[$i]['priority'] = '<label class="label label-danger">High</label>';
                }
                $jsonArray[$i]['updated_at'] = date('d M Y',strtotime($support[$i]->updated_at));
            }
            return response()->json(['data' => $jsonArray]);
        }
        $open = Support::where('status',1)->count();
        $inProgress = Support::where('status',2)->count();
        $resloved = Support::where('status',3)->count();
        $closed = Support::where('status',4)->count();
        return view('admin.Support.index',compact('open','inProgress','closed','resloved'));
    }

    function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-.]/', '', $string); // Removes special chars.
    }

    function upload_image(Request $request){
        $image = $request->file('files');
        for ($i=0; $i < count($image); $i++) {
            $fname = $this->clean($image[$i]->getClientOriginalName());
            $filename = time().'-'.$fname;
            $ext = $image[$i]->getClientOriginalExtension();

            $s3 = \Storage::disk('s3');
            //exit;
            $filepath = 'knitfit/'.$filename;

            if($ext == 'pdf'){
                $pu = $s3->put('/'.$filepath, file_get_contents($image[$i]),'public');
            }else{
                $ext = 'jpg';
                $img = Image::make($image[$i]);
                $height = Image::make($image[$i])->height();
                $width = Image::make($image[$i])->width();
                $img->orientate();
                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->encode('jpg');
                $pu = $s3->put('/'.$filepath, $img->__toString(), 'public');
            }

            if($pu){
                return response()->json(['path1' => $filepath, 'path' => 'https://s3.us-east-2.amazonaws.com/knitfitcoall/'.$filepath,'ext' => $ext]);
            }else{
                echo 'error';
            }
        }
    }


    function remove_image(Request $request){
        return true;
    }

    function show_ticket(Request $request){
        /*for ($i=1;$i<=50;$i++){
            SupportComments::create(['user_id' => 2,'support_id' => 14,'support_comment' => 'This is comment number'.$i.', Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum']);
        }*/
        $ticket_id = $request->ticket_id;
        $support = Support::where('ticket_id',$ticket_id)->first();
        if($support){
            return view('admin.Support.show',compact('support'));
        }
        return redirect('admin/support');
    }

    function support_reply(Request $request){
        $ticket_id = $request->ticket_id;
        $support = Support::where('ticket_id',$ticket_id)->first();
        if($support){
            $reply = $support->SupportComments()->orderBy('id','DESC')->paginate(10);
            return view('admin.Support.support-replies',compact('reply','support'));
        }
        return response()->json(['status' => false]);
    }

    function saveReply(Request $request){
        $request->validate([
            'support_comment' => 'required'
        ]);
        $support_id = base64_decode($request->support_id);
        $checkReply = SupportComments::where('support_id',$support_id)->count();
        if($checkReply  == 0){
            Support::where('id',$support_id)->update(['status' => 2]);
        }
        $comment = new SupportComments;
        $comment->user_id = Auth::user()->id;
        $comment->support_id = base64_decode($request->support_id);
        $comment->support_comment = $request->support_comment;
        $comment->ipaddress = $request->ip();
        $save = $comment->save();
        if($save){
            if($request->image){
                for ($i=0;$i<count($request->image);$i++){
                    $attachment = new SupportCommentsAttachments;
                    $attachment->user_id= Auth::user()->id;
                    $attachment->support_comments_id = $comment->id;
                    $attachment->attachment_url = $request->image[$i];
                    $attachment->attachment_type = $request->ext[$i];
                    $attachment->ipaddress = $request->ip();
                    $attachment->save();
                }
            }
            $support = Support::where('id',base64_decode($request->support_id))->first();
            $user = User::where('id',$support->user_id)->first();
            $details = [
                'ticket_id' => $support->ticket_id,
                'subject' => $support->subject,
                'support_comment' => $request->support_comment,
                'reinitiated' => isset($request->reinitiated) ? true : false,
                'ticket_created_by' => $user->first_name.' '.$user->last_name,
                'email' => $user->email
            ];
            //Mail::to($user->email)->send(new SupportTicketReplyMail($details));

            //$user = User::find(2);
            //$user->notify(new SupportTicketReply($details));

            $user1 = User::find($support->user_id);
            $user1->notify(new SupportTicketReply($details));

            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    function reInitiate_ticket(Request $request){
        $ticket_id = base64_decode($request->ticket_id);
        $support = Support::where('ticket_id',$ticket_id)->first();
        if($support){
            Support::where('ticket_id',$ticket_id)->update(['status' => 2]);
            $user1 = User::find($support->user_id);
            $user1->notify(new SupportTicketReInitiate($support));
            return view('Pages.Support.reiniate-ticket',compact('support'));
        }
        return response()->json(['status' => false]);
    }

    function close_ticket(Request $request){
        $ticket_id = base64_decode($request->ticket_id);
        $support = Support::where('ticket_id',$ticket_id)->first();
        if($support){
            Support::where('ticket_id',$ticket_id)->update(['status' => 4]);
            $user1 = User::find($support->user_id);
            $user1->notify(new SupportTicketClose($support));
            return view('Pages.Support.reiniate-ticket',compact('support'));
        }
        return response()->json(['status' => false]);
    }

    function resolve_ticket(Request $request){
        $ticket_id = base64_decode($request->ticket_id);
        $support = Support::where('ticket_id',$ticket_id)->first();
        if($support){
            Support::where('ticket_id',$ticket_id)->update(['status' => 3]);
            $user1 = User::find($support->user_id);
            $user1->notify(new SupportTicketResolve($support));
            return view('Pages.Support.reiniate-ticket',compact('support'));
        }
        return response()->json(['status' => false]);
    }
}
