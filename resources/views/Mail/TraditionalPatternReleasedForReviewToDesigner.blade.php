<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
@php
$user = App\User::where('id',$details['designer_name'])->first();
@endphp
<p>Hi {{ $user->first_name }} {{ $user->last_name }},</p>
<p>Thank you for using Stitchers Studio.</p>
<p>Your pattern {{$details['product_name']}} was released for review.</p>
<p>If any changes are necessary, select the pencil icon to edit the information in the Pattern Details and Pattern Review fields and select "Submit the patter for review".</p>
</body>
</html>