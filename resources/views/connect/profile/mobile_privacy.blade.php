@php 
$mobile_privacy = $user->settings()->where('name','mobile_privacy')->select('value')->first();
$friend = App\Models\Friends::where('user_id',Auth::user()->id)->where('friend_id',$user->id)->count();
$follow = App\Models\Follow::where('user_id',Auth::user()->id)->where('follow_user_id',$user->id)->count();

function maskPhoneNumber($number){
    
    $mask_number =  str_repeat("*", strlen($number)-1) . substr($number, -2);
    
    return $mask_number;
}
@endphp

@if($mobile_privacy)

@if($mobile_privacy->value == 'only-me')
	@if(Auth::user()->id == $user->id)
		{{ $user->mobile ? $user->mobile : 'NA' }}
	@else
		{{maskPhoneNumber($user->mobile)}}
	@endif
@elseif($mobile_privacy->value == 'friends')
	@if($friend == 0)
		{{maskPhoneNumber($user->mobile)}}
	@else
		{{ $user->mobile ? $user->mobile : 'NA' }}
	@endif
@elseif($mobile_privacy->value == 'followers')
	@if($follow == 0)
		{{maskPhoneNumber($user->mobile)}}
	@else
		{{ $user->mobile ? $user->mobile : 'NA' }}
	@endif
@else
	{{ $user->mobile ? $user->mobile : 'NA' }}
@endif

@else
{{ $user->mobile ? $user->mobile : 'NA' }}
@endif