@php 
$email_privacy = $user->settings()->where('name','email_privacy')->select('value')->first();
$friend = App\Models\Friends::where('user_id',Auth::user()->id)->where('friend_id',$user->id)->count();
$follow = App\Models\Follow::where('user_id',Auth::user()->id)->where('follow_user_id',$user->id)->count();

function maskEmail($value){
    $mask_email =  str_repeat("*", strlen($value)-1) . substr($value, -2);
    return $mask_email;
}
@endphp

@if($email_privacy)

@if($email_privacy->value == 'only-me')
	@if(Auth::user()->id == $user->id)
		{{ $user->email ? $user->email : 'NA' }}
	@else
		{{maskEmail($user->email)}}
	@endif
@elseif($email_privacy->value == 'friends')
	@if($friend == 0)
		{{maskEmail($user->email)}}
	@else
		{{ $user->email ? $user->email : 'NA' }}
	@endif
@elseif($email_privacy->value == 'followers')
	@if($follow == 0)
		{{maskEmail($user->email)}}
	@else
		{{ $user->email ? $user->email : 'NA' }}
	@endif
@else
	{{ $user->email ? $user->email : 'NA' }}
@endif

@else
{{ $user->email ? $user->email : 'NA' }}
@endif