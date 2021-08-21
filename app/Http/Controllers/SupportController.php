<?php

namespace App\Http\Controllers;

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
use App\Models\MasterList;
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
            $support = Auth::user()->support()->latest()->get();
            for ($i=0;$i<count($support);$i++){
                if($support[$i]->pattern_name != ''){
                    $product = Products::where('id',$support[$i]->pattern_name)->first();
                    $name = $product ? $product->product_name : '';
                }else{
                    $name = $support[$i]->other_name.'(Other)';
                }
                
                $jsonArray[$i]['ticket_id'] = '<a href="'.url("support/".$support[$i]->ticket_id."/show").'" class="link">'.$support[$i]->ticket_id.'</a>';
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
        return view('Pages.Support.index');
    }

    function create_new_ticket(){
        $topic = MasterList::where('type','support')->where('status',1)->get();
        $orders = DB::table('orders')
            ->leftJoin('booking_process', 'booking_process.order_id', 'orders.id')
            ->leftJoin('products', 'booking_process.product_id', 'products.id')
            ->select('booking_process.id','booking_process.created_at','products.id as pid','products.product_name','products.is_custom')
            ->where('booking_process.category_id', 1)
            ->where('booking_process.user_id', Auth::user()->id)
            ->where('booking_process.is_archive', 0)
            ->where('orders.order_status', 'Success')
            ->orderBy('orders.id','desc')
            ->get();
        return view('Pages.Support.create',compact('topic','orders'));
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

    function saveTicket(Request $request){
        if($request->pattern_name){
            $request->validate([
                'query_related_to' => 'required',
                'pattern_name' => 'required',
                'priority' => 'required',
                'subject' => 'required',
                'description' => 'required'
            ]);
        }else{
            $request->validate([
                'query_related_to' => 'required',
                'other_name' => 'required',
                'priority' => 'required',
                'subject' => 'required',
                'description' => 'required'
            ]);
        }
        

        $ticket_id = time();

        $support = new Support;
        $support->user_id = Auth::user()->id;
        $support->ticket_id = $ticket_id;
        if($request->query_related_to == 'Other'){
            $support->other_name = $request->other_name;
        }else{
            $support->pattern_name = $request->pattern_name;
        }
        $support->priority = $request->priority;
        $support->query_related_to = $request->query_related_to;
        $support->subject = $request->subject;
        $support->related_url = $request->related_url;
        $support->description = $request->description;
        $support->ipaddress = $request->ip();
        $save = $support->save();

        if($save){
            if($request->image){
                for ($i=0;$i<count($request->image);$i++){
                    $attachment = new SupportAttachments;
                    $attachment->user_id= Auth::user()->id;
                    $attachment->support_id = $support->id;
                    $attachment->attachment_url = $request->image[$i];
                    $attachment->attachment_type = $request->ext[$i];
                    $attachment->ipaddress = $request->ip();
                    $attachment->save();
                }
            }

            /*Mail::to('jane.nickerson@knitfitco.com')->send(new SupportTicketCreationMail($support));*/
            Auth::user()->notify(new SupportTicketCreationToUser($support));
            $user = User::find(8);
            $user->notify(new SupportTicketCreation($support));
            return response()->json(['status' => true]);
        }else{
            return response()->json(['status' => false]);
        }
    }

    function show_ticket(Request $request){
        /*for ($i=1;$i<=50;$i++){
            SupportComments::create(['user_id' => 2,'support_id' => 14,'support_comment' => 'This is comment number'.$i.', Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry`s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum']);
        }*/
        $ticket_id = $request->ticket_id;
        $support = Support::where('ticket_id',$ticket_id)->first();
        if($support){
            return view('Pages.Support.show',compact('support'));
        }
        return redirect('support');
    }

    function support_reply(Request $request){
        $ticket_id = $request->ticket_id;
        $support = Support::where('ticket_id',$ticket_id)->first();
        if($support){
            $reply = $support->SupportComments()->orderBy('id','DESC')->paginate(10);
            return view('Pages.Support.support-replies',compact('reply','support'));
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

            $user = User::find(8);
            $user->notify(new SupportTicketReply($details));

            //$user1 = User::find($support->user_id);
            //$user1->notify(new SupportTicketReply($details));
                       
            
            //Mail::to('jane.nickerson@knitfitco.com')->send(new SupportTicketReplyMail($details));
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
            $user = User::find(8);
            $user->notify(new SupportTicketReInitiate($support));
            return view('Pages.Support.reiniate-ticket',compact('support'));
        }
        return response()->json(['status' => false]);
    }

    function close_ticket(Request $request){
        $ticket_id = base64_decode($request->ticket_id);
        $support = Support::where('ticket_id',$ticket_id)->first();
        if($support){
            Support::where('ticket_id',$ticket_id)->update(['status' => 4]);
            $user = User::find(8);
            $user->notify(new SupportTicketClose($support));
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }
}
