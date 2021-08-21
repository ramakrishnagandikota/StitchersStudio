
@if(!empty($details['dates']))
{{$details['dates']}}
@else
{{$details['message']}}
@endif

<p>Report generated from {{url('/')}}</p>