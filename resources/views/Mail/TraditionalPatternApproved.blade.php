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
<p>Thank you for submitting your design to StitchersStudio.</p>
<p>Your pattern, {{$details['product_name']}}, has been approved!</p>
<!--<p>Proceed to upload other information about the patern & submit for review.</p>-->
<p>The next step is for you to log in to your designer account and enter all of the descriptive information about the pattern & upload all files needed.</p>
</body>
</html>