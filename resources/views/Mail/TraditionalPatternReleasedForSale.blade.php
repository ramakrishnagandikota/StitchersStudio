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
<p>{{$details['product_name']}} pattern was released for sale.</p>
</body>
</html>