<?php

namespace App\Http\Controllers\AdminNew;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use FcmClient;
use App\Models\Broadcasting;
use App\Notifications\AdminToUserNotification;
use Illuminate\Notifications\Notification;
use App\Events\NotificationToUser;
use Pusher\Pusher;
use App\Events\SendMessage;

class BroadcastController extends Controller
{
    private $options;
    private $pusher;

    public function __construct(){
        $this->middleware('auth');

        $this->options = array(
            'cluster' => 'ap2',
            'useTLS' => true
        );
        $this->pusher = new Pusher(
            '7d576fddddf65cdd614e',
            '0626271d26c834013620',
            '334221',
            $this->options
        );
    }

    public function broadcast(){
        $broadcast = Broadcasting::all();
        return view('adminnew.broadcast.index',compact('broadcast'));
    }

    public function broadcast_notify(Request $request){
        $user = User::find(1);
        event(new SendMessage($user));
        return view('adminnew.broadcast.broadcast');
    }

    public function broadcast_user(Request $request){
        try{

        $message = Broadcasting::create($request->all());
        $users = User::where('status',1)->get();
        $serverKey = 'AAAACxHbqBM:APA91bECETY9b6pSkEQMrORwoZYG0eqP25iw-6xnbHbS59bZKSE8S_TlGsoRgMeG2pEqAcmUntz6hrBevMHbdd4HC9tIRu7EVs5-JCDSkqiULZBR-SPZ6XYPYm4mbKrfV6itDHemkGKf';
        $senderId = '47544248339';
        $client = new \Fcm\FcmClient($serverKey, $senderId);
        $myObjArray = array('click-action' => 'FCM_PLUGIN_ACTIVITY','notification_foreground' => true);
        $notification = new \Fcm\Push\Notification();

        if($request->platform == 'all'){
            /* web notifications */
            foreach ($users as $user){
                $user->notify(new AdminToUserNotification($message));
            }
            /* web notifications */

            /* Android & IOS*/
            foreach ($users as $use){
                if($use->android_device_id){
                    $notification
                        ->addRecipient($use->android_device_id)
                        ->setTitle($request->title)
                        ->setBody($request->message)
                        ->setSound("default")
                        ->addDataArray($myObjArray);

                    $send = $client->send($notification);
                }

                if($use->ios_device_id){
                    $notification
                        ->addRecipient($use->ios_device_id)
                        ->setTitle($request->title)
                        ->setBody($request->message)
                        ->addDataArray($myObjArray);

                    $send = $client->send($notification);
                }
            }

            /* android & IOS*/

        }else if($request->platform == 'web'){
            /* web notifications */
            foreach ($users as $user){
                if($user->id == 1){
                    //broadcast(new NotificationToUser($user->id,$message));
                    $this->broadcast(new SendMessage($user));
                }
                //$this->pusher->trigger('notify-user'.$user->id, 'notifyUser', $message);
                //$user->notify(new AdminToUserNotification($message));
            }
            /* web notifications */
        }else{
            /* Android & IOS*/
            foreach ($users as $use){
                if($use->android_device_id){
                    $notification
                        ->addRecipient($use->android_device_id)
                        ->setTitle($request->title)
                        ->setBody($request->message)
                        ->setSound("default")
                        ->addDataArray($myObjArray);

                    $send = $client->send($notification);
                }

                if($use->ios_device_id){
                    $notification
                        ->addRecipient($use->ios_device_id)
                        ->setTitle($request->title)
                        ->setBody($request->message)
                        ->addDataArray($myObjArray);

                    $send = $client->send($notification);
                }
            }

            /* android & IOS*/
        }
            return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'error','message' => $e->getMessage()]);
        }
    }
}
