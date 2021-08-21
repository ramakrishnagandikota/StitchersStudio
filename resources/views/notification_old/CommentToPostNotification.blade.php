<?php 
if($notification->data['commentedBy']['picture']){
		$picture = $notification->data['commentedBy']['picture'];
	}else{
		$picture = 'https://via.placeholder.com/150?text='.$notification->data['commentedBy']['first_name'];
	}
?>
<li>
<div class="media">
<img class="img-radius" src="{{ $picture }}" alt="">
<div class="media-body">
<a href="{{url('connect/notifications/timeline/'.encrypt($notification->data['timeline']['id']))}}" style="padding: 0px !important;">
	<h5 class="notification-user">
		@if(Auth::user()->id == $notification->data['commentedBy']['id'])
		You
		@else
		{{ ucfirst($notification->data['commentedBy']['first_name']) }} {{ $notification->data['commentedBy']['last_name'] }}
		@endif
	</h5></a>
<p class="notification-msg">commented your post</p>
<span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['repliesTime'])->diffForHumans() }}</span>
</div>
</div>
</li>