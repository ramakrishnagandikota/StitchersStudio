@php 
$address_privacy = $user->settings()->where('name','address_privacy')->select('value')->first();
$friend = App\Models\Friends::where('user_id',Auth::user()->id)->where('friend_id',$user->id)->count();
$follow = App\Models\Follow::where('user_id',Auth::user()->id)->where('follow_user_id',$user->id)->count();

function maskAddress($value){
    $mask_address =  str_repeat("*", strlen($value)-1) . substr($value, -2);
    return $mask_address;
}
@endphp

@if($address_privacy)

@if($address_privacy->value == 'only-me')
	@if(Auth::user()->id == $user->id)
		{{ $user->address ? $user->address : '' }}
	@else
		{{maskAddress($user->address)}}
	@endif
@elseif($address_privacy->value == 'friends')
	@if($friend == 0)
		{{maskAddress($user->address)}}
	@else
		{{ $user->address ? $user->address : '' }}
	@endif
@elseif($address_privacy->value == 'followers')
	@if($follow == 0)
		{{maskAddress($user->address)}}
	@else
		{{ $user->address ? $user->address : '' }}
	@endif
@else
	{{ $user->address ? $user->address : '' }}
@endif

@else
{{ $user->address ? $user->address : '' }}
@endif