@if($noReply->count() > 0)
	@foreach($noReply as $nr)
    <p class="f-14"><a href="{{url('adminnew/feedback/view/'.base64_encode($nr->id).'/'.Str::slug($nr->title))}}">{{$nr->title}}</a>
        <br><span class="f-12 text-muted">
        @if(date('Y-m-d') == date('Y-m-d',strtotime($nr->created_at)))
			{{ \Carbon\Carbon::parse($nr->created_at)->diffForHumans()}}
		@else
    		{{date('F dS Y',strtotime($nr->created_at))}}
		@endif
		</span>
        <hr>
    </p>   
    @endforeach
@else
    <p class="f-14 text-center">No feedbacks to reply.</p>
@endif

{{$noReply->links()}}