<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>Hi {{ $details['userName'] }},</p>
	<p>{{ $details['adminName'] }} invited you to Stitchers Studio.</p>
	<p>{{ $details['title'] }}</p>
	<p>{!! $details['message'] !!}</p>
</body>
</html>