<?php

namespace App\Http\Controllers\Admin;

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
use App\Models\PushNotificationDeviceData;
use Carbon\Carbon;

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
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
        $broadcast = Broadcasting::all();
        return view('admin.broadcast.index',compact('broadcast'));
    }

    public function broadcast_notify(Request $request){
		if(!Auth::user()->hasRole('Admin')){
			return response()->json(['error' => 'You have loggedin with a different role.']);
			exit;
		}
        //$user = User::find(1);
        //event(new SendMessage($user));
        return view('admin.broadcast.broadcast');
    }

    public function broadcast_user(Request $request){
        try{

            $message = Broadcasting::create($request->all());
            $users = User::where('id',1)->get();
            $serverKey = 'AAAARPoR2c0:APA91bGuYpM8HuBShyIZERRG0zZKvDlkl6nk3aUVFdq8nJMxbL821_21XLgIhMKnmlYWsGsKEevDH8TNhMq5Ei40owRTmorRzACXQXAO74awX8EFQIElmY6oeBsjEYiz8ZZXJ7EJNy6_';
            $senderId = '296253249997';
            $client = new \Fcm\FcmClient($serverKey, $senderId);
            $myObjArray = array('click-action' => 'FCM_PLUGIN_ACTIVITY','notification_foreground' => true);
            $notification = new \Fcm\Push\Notification();
			
			
			//print_r($request->all());
			//exit;

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
                    //if($user->id == 1){
                        //broadcast(new NotificationToUser($user->id,$message));
                        $user->notify(new AdminToUserNotification($message));
                    //}
                    //$this->pusher->trigger('notify-user'.$user->id, 'notifyUser', $message);
                    //$user->notify(new AdminToUserNotification($message));
                }
                /* web notifications */
            }else{
                /* Android & IOS*/
				
				
				for($i=0;$i<count($users);$i++){
					$android = $users[$i]->android_device_id;
					$ios = $users[$i]->ios_device_id;
					
					if(!empty($android)){
						//echo "Android - ".$users[$i]->android_device_id."<br>";
						$notification
							->addRecipient($android)
							->setTitle($request->title.' - Android')
							->setBody($request->message)
							->setSound("default")
							->addDataArray($myObjArray);

						$send = $client->send($notification);
					}
					
					if(!empty($ios)){
						//echo "IOS - ".$users[$i]->ios_device_id."<br>";
						$notification
							->addRecipient($ios)
							->setTitle($request->title.' - IOS')
							->setBody($request->message)
							->setSound("default")
							->addDataArray($myObjArray);

						$send = $client->send($notification);
					}
				}

                /* android & IOS*/
            }
			//exit;
            return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'error','message' => $e->getMessage()]);
        }
    }
	
	
	function broadCastToDevice(Request $request){
		try{
		$platform = $request->platform;
		
		//$title = $request->title;
		//$message = $request->message;
		
		$message= new Broadcasting;
		$message->title = $request->title;
		$message->message = $request->message;
		$message->platform = implode(',',$platform);;
		$message->created_at = Carbon::now();
		$message->save();
		
		
		for($i=0;$i<count($platform);$i++){
			
			if($platform[$i] == 'web'){
				$users = User::where('status',1)->get();
				foreach ($users as $user){
                    $user->notify(new AdminToUserNotification($message));
				}
			}
			
			if($platform[$i] == 'android'){
				$devices = PushNotificationDeviceData::where('device_type','android')->where('device_token','!=','null')->get();
				foreach($devices as $dev){
					$serverKey = 'AAAARPoR2c0:APA91bGuYpM8HuBShyIZERRG0zZKvDlkl6nk3aUVFdq8nJMxbL821_21XLgIhMKnmlYWsGsKEevDH8TNhMq5Ei40owRTmorRzACXQXAO74awX8EFQIElmY6oeBsjEYiz8ZZXJ7EJNy6_';
					$senderId = '296253249997';
					$client = new \Fcm\FcmClient($serverKey, $senderId);
					$myObjArray = array('click-action' => 'FCM_PLUGIN_ACTIVITY','notification_foreground' => true);
					$notification = new \Fcm\Push\Notification();
				
					$notification
						->addRecipient($dev->device_token)
						->setTitle($request->title)
						->setBody($request->message)
						->setSound("default")
						->addDataArray($myObjArray);

					$send = $client->send($notification);
				}
			}
			
			if($platform[$i] == 'ios'){
			
				$devices = PushNotificationDeviceData::where('device_type','ios')->where('device_token','!=','null')->get();
				foreach($devices as $dev){
					$serverKey = 'AAAARPoR2c0:APA91bGuYpM8HuBShyIZERRG0zZKvDlkl6nk3aUVFdq8nJMxbL821_21XLgIhMKnmlYWsGsKEevDH8TNhMq5Ei40owRTmorRzACXQXAO74awX8EFQIElmY6oeBsjEYiz8ZZXJ7EJNy6_';
					$senderId = '296253249997';
					$client = new \Fcm\FcmClient($serverKey, $senderId);
					$myObjArray = array('click-action' => 'FCM_PLUGIN_ACTIVITY','notification_foreground' => true);
					$notification = new \Fcm\Push\Notification();
				
					$notification
						->addRecipient($dev->device_token)
						->setTitle($request->title)
						->setBody($request->message)
						->setSound("default")
						->addDataArray($myObjArray);

					$send = $client->send($notification);
				}
			}
		}
		
			
		return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'error','message' => $e->getMessage()]);
        }
	}
	
	function getAllDeviceIds(){
		$users = User::where('status',1)->where('ios_device_id','!=','')->get();
		echo count($users);
		echo '<br>';
		foreach ($users as $user){
			echo $user->id.' - '.$user->android_device_id.'<br>';
			/*$push = new PushNotificationDeviceData;
			$push->user_id = $user->id;
			$push->device_type = 'ios';
			$push->device_token = $user->ios_device_id;
			$push->created_at = Carbon::now();
			$push->save();*/
		}
	}
	
	function sendNotificationToDevice(){
		try{
		$serverKey = 'AAAARPoR2c0:APA91bGuYpM8HuBShyIZERRG0zZKvDlkl6nk3aUVFdq8nJMxbL821_21XLgIhMKnmlYWsGsKEevDH8TNhMq5Ei40owRTmorRzACXQXAO74awX8EFQIElmY6oeBsjEYiz8ZZXJ7EJNy6_';
		$senderId = '296253249997';
		$client = new \Fcm\FcmClient($serverKey, $senderId);
		$myObjArray = array('click-action' => 'FCM_PLUGIN_ACTIVITY','notification_foreground' => true);
		$notification = new \Fcm\Push\Notification();
	
		$notification
			->addRecipient("fuGMQPbyRZGk8qnxb7Fwi-:APA91bFwGN3dzEHgH99qw6f71Lu0CtDxc-c00BE1ve8xhAV4sEMScztBdg0qm5mdStrF4JvNEZeuu_2qzAn6pkIRDGc5tYnm0NNSPLSvaLWOVwUFLZMtMWgtMfCJ46H8LwjKQgfiNPAD")
			->setTitle("Test")
			->setBody("Test message to chandu")
			->setSound("default")
			->addDataArray($myObjArray);

		$send = $client->send($notification);
					return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'error','message' => $e->getMessage()]);
        }
					exit;
		try{
		$serverKey = 'AAAAmpEtTT4:APA91bHonBp5-slxujVeaaRENJFf92C2S6zO4Kw6uqBSFBrffbsty11OHK2OFga_ItqRFNd9XOD96MAhb_rRfTwoYke0c7qh9E4ugEmTiKy3qAxfvoMNplrKcvAm5dm1sknn0igtHKvm';
		$senderId = '663860628798';
		$client = new \Fcm\FcmClient($serverKey, $senderId);
		$myObjArray = array('click-action' => 'FCM_PLUGIN_ACTIVITY','notification_foreground' => true);
		$notification = new \Fcm\Push\Notification();
	
		$notification
			->addRecipient('d8aITIWPjDQ:APA91bElnV_aYzd9v4TqObq6DqM-Dn0LCUktAaJl3NLcvj4g4djLpMXLXdIRysOS2-uOtpy2kcLS38_0ovvHXSzPdB6zMbSlMKQCCSvzeyI6QDdX8gN2FTRTKelebw2RYDmFyg7Ltya-')
			->setTitle('Test')
			->setBody('Test message')
			->setSound("default")
			->addDataArray($myObjArray);

		$send = $client->send($notification);
		return response()->json(['status' => 'success']);
        }catch (\Throwable $e){
            return response()->json(['status' => 'error','message' => $e->getMessage()]);
        }
	}
}
