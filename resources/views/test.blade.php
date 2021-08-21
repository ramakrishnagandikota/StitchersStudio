<?php
/*
function ip_details($IPaddress) 
{
    $json       = file_get_contents("http://ipinfo.io/{$IPaddress}");
    $details    = json_decode($json);
    return $details;
}

$IPaddress  =  '49.206.38.63';

$details    =   ip_details("$IPaddress");

echo '<pre>';
print_r($details);
echo '</pre>';

exit;
*/
$timeline = DB::table('timeline')->get();
?>

@foreach($timeline as $tl)
<p>Timeline - {{$tl->id}}</p>
<table border="1" style="border-collapse:collapse;">
<tr>
<td>{{$tl->id}}</td>
<td>{{$tl->user_id}}</td>
<td>
@if($tl->privacy == 'public')
	
<?php 
$users = DB::table('users')->get();
?>
INSERT INTO `timeline_show_posts` (`user_id`, `timeline_id`, `show_user_id`, `created_at`, `updated_at`, `ipaddress`) VALUES
@foreach($users as $user)
<span style="display:none;">public {{$user->id}}</span>
	({{$tl->user_id}}, {{$tl->id}}, {{$user->id}}, NULL, NULL, NULL),
@endforeach
@elseif($tl->privacy == 'friends')
<?php 
$friends = DB::table('friends')->where('user_id',$tl->user_id)->get();
?>
INSERT INTO `timeline_show_posts` (`user_id`, `timeline_id`, `show_user_id`, `created_at`, `updated_at`, `ipaddress`) VALUES
@foreach($friends as $frnd)
<span style="display:none;">friends {{$frnd->friend_id}}</span>
({{$tl->user_id}}, {{$tl->id}}, {{$user->id}}, NULL, NULL, NULL),
@endforeach
@else
	
@endif


</td>
</tr>
</table>
<br>
@endforeach

