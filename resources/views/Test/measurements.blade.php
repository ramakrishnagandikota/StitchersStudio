<html>
<head>

</head>
<body>
@if(Session::has('success'))
	<p style="color:green;">{{ Session::get('success') }}</p>
@endif
<div style="border:1px solid #000;padding:10px;">
<form method="POST" action="{{ url('test/duplicate-measurements') }}" >
@csrf
<div>
	<select onchange="checkMeasurements(this.value)">
	<option value="Select user for measurements">Select user for measurements</option>
	@foreach($user as $us)
	<option value="{{ $us->id}}" @if($user_id == $us->id) selected @endif >{{ $us->id }} - {{$us->email}}</option>
	@endforeach
	</select>
<br><br>
	@if(count($measurements) > 0)
		@foreach($measurements as $meas)
	<input type="hidden" name="measurement_id[]" value="{{ $meas->id }}" >
		<div>{{ $meas->id}} - {{$meas->m_title}}</div><br>
		@endforeach
	@endif
</div>

<br>
Copy measurements to : 
<select name="user_id">
<option value="Select User">Select user</option>
@foreach($user as $us)
<option value="{{ $us->id}}">{{ $us->id }} - {{$us->email}}</option>
@endforeach
</select>
@if(count($measurements) > 0)
<input type="submit" name="submit" value="Copy Measurements">
@endif
</form>
</div>

<script>
function checkMeasurements(value){
	window.location.assign('{{ url("test/measurements") }}/'+value);
}
</script>
</body>
</html>