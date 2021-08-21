<?php
if($notification->data['followingBy']['picture']){
		$picture = $notification->data['followingBy']['picture'];
	}else{
		$picture = 'https://via.placeholder.com/150?text='.$notification->data['followingBy']['first_name'];
	}

if($notification->data['followingBy']['username']){
	$username = $notification->data['followingBy']['username'];
}else{
	$exp = explode(",",$notification->data['followingBy']['email']);
	$username = $exp[0];
}
?>

<div class="media">
<img class="img-radius" src="{{ $picture }}" alt="">
<div class="media-body">
<h5 class="notification-user">

	<h5>
	<a href="{{url('connect/profile/'.$username.'/'.encrypt($notification->data['followingBy']['id']))}}"> {{ ucfirst($notification->data['followingBy']['first_name']) }} {{ $notification->data['followingBy']['last_name'] }}</a>
	</h5>
<p class="notification-msg">is following you.</p>
<span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['requestTime'])->diffForHumans() }}</span>
</div>
</div>
