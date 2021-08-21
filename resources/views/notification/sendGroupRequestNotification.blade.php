<?php
$user = App\User::find($notification->data['groupInvitation']['requestSentById']);
$checkGroup = App\Models\GroupUser::where('group_id',$notification->data['groupInvitation']['group_id'])->where('user_id',Auth::user()->id)->count();
$groupRequest = App\Models\GroupRequest::where('id',$notification->data['groupInvitation']['groupRequestId'])->first();
?>
<div class="media">
    <img class="img-radius" src="{{ $user->picture }}" style="height: 40px;" alt="Generic placeholder image">
    <div class="media-body">
        <h5 class="notification-user" style="font-weight: normal;"><b>{{ $notification->data['sentBy'] }}</b> invited you to join the group <b>{{ $notification->data['groupInvitation']['group_name'] }}</b>.</h5>
        <p class="notification-msg">{{ $notification->data['groupInvitation']['title'] }}</p>
        <p class="notification-msg">{{ $notification->data['groupInvitation']['message'] }}</p>
        @if($checkGroup == 0)
            @if($groupRequest)
                @if($groupRequest->status == 1)
                    <p>
                        <button href="javascript:;" class="btn small-btn theme-btn invitationButton" data-groupId="{{$notification->data['groupInvitation']['group_id']}}" data-groupRequestId="{{$notification->data['groupInvitation']['groupRequestId']}}" 
                        data-designerBroadcastId="{{$notification->data['groupInvitation']['designerBroadcastId'] ?? 0 }}" 
                        style="color: #fff;">View details</button>
                    </p>
                @else
                    <p>
                        <button href="javascript:;" disabled class="btn small-btn theme-btn invitationButton" style="color: #fff;">Invitation Rejected</button>
                    </p>
                @endif
            @else
                <p>
                    <button href="javascript:;" disabled class="btn small-btn theme-btn invitationButton" style="color: #fff;">Invitation Rejected</button>
                </p>
            @endif
        @else
            <p>
                <button href="javascript:;" disabled class="btn small-btn theme-btn invitationButton" style="color: #fff;">Invitation Accepted</button>
            </p>
        @endif
        <span class="notification-time">{{ \Carbon\Carbon::parse($notification->data['sentTime'])->diffForHumans() }}</span>
    </div>
</div>
