<?php
$user = App\User::find($notification->data['groupUserInvitation']['requestSentById']);
?>
<div class="media">
    <img class="img-radius" src="{{ $user->picture }}" style="height: 40px;" alt="{{ $notification->data['sentBy'] }}">
    <div class="media-body">
        <h5 class="notification-user" style="font-weight: normal;">You have received a message <b>{{ $notification->data['groupUserInvitation']['title'] }}</b> from <b>{{ $notification->data['groupUserInvitation']['group_name'] }}</b> group.</h5>
        <p class="notification-msg">{{ $notification->data['groupUserInvitation']['message'] }} </p>
        <span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['sentTime'])->diffForHumans() }}</span>
    </div>
</div>
