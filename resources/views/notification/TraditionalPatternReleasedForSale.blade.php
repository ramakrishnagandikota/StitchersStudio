<?php
$picture = url('resources/assets/files/assets/images/logo-icon.png');

if(Auth::user()->id == 8){
	$urls = url('/admin/browse-patterns');
}else{
	$urls = url('/designer/my-patterns');
}
?>
<div class="media">
<img class="img-radius" src="{{ $picture }}" alt="">
<div class="media-body">
<a href="{{ $urls }}" style="padding: 0px !important;">
    <h5 class="notification-user">
        {{$notification->data['product']['product_name']}}
    </h5></a>
<p class="notification-msg">Pattern released for sale by {{ $notification->data['sentBy'] }}</p>
<span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['sentTime'])->diffForHumans() }}</span>
</div>
</div>
