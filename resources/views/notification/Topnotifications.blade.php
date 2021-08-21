

<li>
<h6>Notifications</h6>
<a href="{{url('connect/friend-requests')}}" class="waves-effect waves-light frnd-request">
    <h6 class="KFgreen"><i class="icofont icofont-users"></i> Friend requests</h6>
</a>
</li>
<?php 
$notifi = Auth::user()->notifications()->latest()->get();
?>
@if(count($notifi) > 0)

  @foreach($notifi  as $notification)
  <li style="@if($notification->read_at == null) background: #dedede; @endif ">
    @include('notification.'.class_basename($notification->type))
  </li>
  @endforeach

@else

<p class="notification-msg text-center">No new notifications found.</p>

@endif


