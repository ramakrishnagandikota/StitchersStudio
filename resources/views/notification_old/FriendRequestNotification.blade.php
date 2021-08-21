<?php 
if($notification->data['requestSentBy']['picture']){
		$picture = $notification->data['requestSentBy']['picture'];
	}else{
		$picture = 'https://via.placeholder.com/150?text='.$notification->data['requestSentBy']['first_name'];
	}

if($notification->data['requestSentBy']['username']){
	$username = $notification->data['requestSentBy']['username'];
}else{
	$exp = explode(",",$notification->data['requestSentBy']['email']);
	$username = $exp[0];
}
?>
<li>
<div class="media">
<img class="img-radius" src="{{ $picture }}" alt="">
<div class="media-body">
<a href="{{url('connect/profile/'.$username.'/'.encrypt($notification->data['requestSentBy']['id']))}}"><h5 class="notification-user">{{ ucfirst($notification->data['requestSentBy']['first_name']) }} {{ $notification->data['requestSentBy']['last_name'] }}</h5></a>
<p class="notification-msg">sent a friend request to connect with you.</p>
<span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['RequestSentAt'])->diffForHumans() }}</span>
</div>
</div>
</li>