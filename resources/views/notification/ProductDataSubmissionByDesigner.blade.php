<?php
$picture = url('resources/assets/files/assets/images/logo-icon.png');
?>
<div class="media">
<img class="img-radius" src="{{ $picture }}" alt="">
<div class="media-body">
<a href="{{url('/admin/browse-patterns')}}" style="padding: 0px !important;">
    <h5 class="notification-user">
        {{$notification->data['product']['product_name']}}
    </h5></a>
<p class="notification-msg">Traditional pattern data uploaded {{ $notification->data['sentBy'] }}</p>
<span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['sentTime'])->diffForHumans() }}</span>
</div>
</div>
