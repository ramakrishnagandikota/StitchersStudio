<?php
if($notification->data['LikedBy']['picture']){
		$picture = $notification->data['LikedBy']['picture'];
	}else{
		$picture = 'https://via.placeholder.com/150?text='.$notification->data['LikedBy']['first_name'];
	}
?>

<div class="media">
<img class="img-radius" src="{{ $picture }}" alt="">
<div class="media-body">
<a href="{{url('connect/notifications/timeline/'.encrypt($notification->data['timeline']['timeline_id']))}}" style="padding: 0px !important;">
	<h5 class="notification-user">
		@if(Auth::user()->id == $notification->data['LikedBy']['id'])
		You
		@else
		{{ ucfirst($notification->data['LikedBy']['first_name']) }} {{ $notification->data['LikedBy']['last_name'] }}
		@endif
	</h5></a>
<p class="notification-msg">Liked your comment</p>
<span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['repliesTime'])->diffForHumans() }}</span>
</div>
</div>

