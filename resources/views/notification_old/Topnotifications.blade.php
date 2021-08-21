

<li>
<h6>Notifications</h6>

    <h6 class="KFgreen pull-right"><a href="{{url('connect/friend-requests')}}" style="color: #0d665c;" class="waves-effect waves-light frnd-request"><i class="icofont icofont-users"></i> Friend requests</a></h6>

</li>

@if(count(Auth::user()->unreadNotifications) > 0)
  @foreach(Auth::user()->unreadNotifications  as $notification)
    @include('notification.'.class_basename($notification->type))
  @endforeach


@else

<p class="notification-msg text-center">No new notifications found.</p>

@endif


