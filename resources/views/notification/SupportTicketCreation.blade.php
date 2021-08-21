<?php
$picture = url('resources/assets/files/assets/images/logo-icon.png');
$user = App\User::where('id',$notification->data['support']['user_id'])->first();
?>
<div class="media">
<img class="img-radius" src="{{ $picture }}" alt="">
<div class="media-body">
<a href="{{url('/support/'.$notification->data['support']['ticket_id'].'/show')}}" style="padding: 0px !important;">
    <h5 class="notification-user">
        #{{$notification->data['support']['ticket_id']}}
    </h5></a>
<p class="notification-msg">New support ticket created by {{$user->first_name}} {{$user->last_name}}.</p>
<span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['sentTime'])->diffForHumans() }}</span>
</div>
</div>
