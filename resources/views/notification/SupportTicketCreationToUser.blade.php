<?php
$picture = url('resources/assets/files/assets/images/logo-icon.png');
?>
<div class="media">
<img class="img-radius" src="{{ $picture }}" alt="">
<div class="media-body">
    <p class="notification-msg">New support ticket
<a href="{{url('/support/'.$notification->data['support']['ticket_id'].'/show')}}" style="padding: 0px !important;">
        <b>#{{$notification->data['support']['ticket_id']}}</b>
    </a>
created by you.</p>
<span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['sentTime'])->diffForHumans() }}</span>
</div>
</div>
