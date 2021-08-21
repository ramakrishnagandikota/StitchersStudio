@if(Auth::check())
	<table border="1" style="border-collapse: collapse;">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>{{Auth::user()->id}}</td>
				<td>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</td>
				<td>{{Auth::user()->email}}</td>
			</tr>
		</tbody>
	</table>
@else
	User Details : User not loggedin
@endif
<p>This error is generated from {{url('/')}}</p>
<br>
{!! $content !!}