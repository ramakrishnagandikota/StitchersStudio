<div class="table-responsive">
<table class="table table-bordered">
	<tr>
		<th>Title</th><td>{{$broadcast->title}}</td>
	</tr>
	<tr>
		<th>Message</th><td style="word-break: break-word;
    white-space: break-spaces;"><div style="height: auto;
    overflow-y: auto;">{{$broadcast->description}}</div></td>
	</tr>
	<tr>
		<th>Type</th><td>{{$broadcast->notification_type}}</td>
	</tr>
	<tr>
		<th>Group name</th><td>{{ $groups ? $groups->group_name : '-'}}</td>
	</tr>
	<tr>
		<th>Sent to</th><td>{{$broadcast->send_message_to}}
			@if($broadcast->send_message_to == 'pattern-groups')
				@php
					$exp = explode(',',$broadcast->pattern_groups);
				@endphp
				(
					@for($i=0;$i<count($exp);$i++)
						@php $groups = App\Models\Group::where('id',$exp[$i])->first(); @endphp
						@if($groups)
						<span>{{ $groups->group_name }}</span>
						@endif
					@endfor
					)
			@endif
		</td>
	</tr>
	@if($broadcast->send_message_to == 'individuals')
	<tr>
		<th>User emails</th><td style="word-break: break-word;
    white-space: break-spaces;"><div style="height: auto;
    overflow-y: auto;">{{$broadcast->individual_emails}}</div></td>
	</tr>
	@if($broadcast->individual_emails_outside)
	<tr>
		<th>External users</th><td>{{$broadcast->individual_emails_outside}}<br><small style="color:#dd8ca0">(External users will not receive notifications.)</small></td>
	</tr>
	@endif
	@endif
	<tr>
		<th>Sent at</th><td>{{\Carbon\Carbon::parse($broadcast->created_at)->diffForHumans()}}</td>
	</tr>
</table>
</div>