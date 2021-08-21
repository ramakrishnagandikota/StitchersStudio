@php 
$website_privacy = $user->settings()->where('name','website_privacy')->select('value')->first();
$friend = App\Models\Friends::where('user_id',Auth::user()->id)->where('friend_id',$user->id)->count();
$follow = App\Models\Follow::where('user_id',Auth::user()->id)->where('follow_user_id',$user->id)->count();

function maskAddress($value){
    $mask_address =  str_repeat("*", strlen($value)-1) . substr($value, -2);
    return $mask_address;
}
@endphp

@if($website_privacy)

@if($website_privacy->value == 'only-me')
	@if(Auth::user()->id == $user->id)
		{{ $user->profile->website ? $user->profile->website : '' }}
	@else
		{{maskAddress($user->profile->website)}}
	@endif
@elseif($website_privacy->value == 'friends')
	@if($friend == 0)
		{{maskAddress($user->profile->website)}}
	@else
		{{ $user->profile->website ? $user->profile->website : '' }}
	@endif
@elseif($website_privacy->value == 'followers')
	@if($follow == 0)
		{{maskAddress($user->profile->website)}}
	@else
		{{ $user->profile->website ? $user->profile->website : '' }}
	@endif
@else
	{{ $user->profile->website ? $user->profile->website : '' }}
@endif

@else
{{ $user->profile->website ? $user->profile->website : '' }}
@endif