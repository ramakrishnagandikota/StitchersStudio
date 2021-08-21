<?php
$picture = url('resources/assets/files/assets/images/logo-icon.png');
$support = App\Models\Support::where('ticket_id',$notification->data['support']['ticket_id'])->first();
$user = App\User::where('id',$support->user_id)->first();
?>
<div class="media">
<img class="img-radius" src="{{ $picture }}" alt="">
<div class="media-body">
    <p class="notification-msg">You received a reply for support ticket 
    @if(Auth::user()->hasRole('Admin'))
    <a href="{{url('/admin/support/'.$notification->data['support']['ticket_id'].'/show')}}" style="padding: 0px !important;">
        <b>#{{$notification->data['support']['ticket_id']}}</b>
    </a>
    @else
    <a href="{{url('/support/'.$notification->data['support']['ticket_id'].'/show')}}" style="padding: 0px !important;">
        #{{$notification->data['support']['ticket_id']}}
    </a>
    @endif
</p>
<span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['sentTime'])->diffForHumans() }}</span>
</div>
</div>
