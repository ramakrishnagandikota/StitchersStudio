<?php 
if($notification->data['acceptedBy']['picture']){
		$picture = $notification->data['acceptedBy']['picture'];
	}else{
		$picture = 'https://via.placeholder.com/150?text='.$notification->data['acceptedBy']['first_name'];
	}

if($notification->data['acceptedBy']['username']){
	$username = $notification->data['acceptedBy']['username'];
}else{
	$exp = explode(",",$notification->data['acceptedBy']['email']);
	$username = $exp[0];
}
?>
<li>
<div class="media">
<img class="img-radius" src="{{ $picture }}" alt="">
<div class="media-body">
<a href="{{url('connect/profile/'.$username.'/'.encrypt($notification->data['acceptedBy']['id']))}}" style="padding: 0px !important;">
	<h5 class="notification-user">
		{{ ucfirst($notification->data['acceptedBy']['first_name']) }} {{ $notification->data['acceptedBy']['last_name'] }}
	</h5></a>
<p class="notification-msg">accepted your friend request</p>
<span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['acceptedTime'])->diffForHumans() }}</span>
</div>
</div>
</li>