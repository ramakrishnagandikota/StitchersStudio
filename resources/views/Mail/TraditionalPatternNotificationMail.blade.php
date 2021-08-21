<html>
<head>
    <title>{{$details['title']}}</title>
</head>
<body>
<p>Hi {{$details['userName']}},</p>
<p>{{$details['product_name']}} {!!$details['description']!!}.
    @if($details['statusType'] == 'review_designer') <a href="{{ $details['pattern_url'] }}">Click here to open</a> @endif </p>
	
@if($details['temp_password'] != '')
	@if($details['statusType'] == 'review_designer')
		<p>Login with below email and password</p>
		<p>Email : {{$details['email']}}</p>
		<p>Temporary password : {{$details['temporary_password']}}</p>
	@endif
@else 
		<p>Login with below email and password</p>
		<p>Email : {{$details['email']}}</p>
		<p>Temporary password : Your stitchers studio password</p>
@endif

@if($details['description2'])
	<p>{!!$details['description2']!!}</p>
	@endif
<p style="margin-top:50px;text-align:center;">This mail is generated from {{url('/')}}</p>
</body>
</html>
