<?php
$user = App\User::find($notification->data['groupBroadcast']['requestSentById']);
?>
<div class="media">
    <img class="img-radius" src="{{ $user->picture }}" style="height: 40px;" alt="{{ $notification->data['sentBy'] }}">
    <div class="media-body">
        <h5 class="notification-user" style="font-weight: normal;">{{ $notification->data['groupBroadcast']['title'] }}.</h5>
        <p class="notification-msg">{{ $notification->data['groupBroadcast']['message'] }}</p>
        <span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['sentTime'])->diffForHumans() }}</span>
    </div>
</div>
