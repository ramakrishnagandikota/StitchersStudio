<?php
$picture = url('resources/assets/files/assets/images/logo-icon.png');
?>

<div class="media">
    <img class="img-radius" src="{{ $picture }}" alt="">
    <div class="media-body">
        <a href="#" style="padding: 0px !important;">
            <h5 class="notification-user">
            {{ $notification->data['userNotification']['title'] }} from {{ $notification->data['sentBy'] }}
            </h5></a>
        <p class="notification-msg">{{ $notification->data['userNotification']['message'] }}</p>
        <p></p>
        <span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['sentTime'])->diffForHumans() }}</span>
    </div>
</div>
