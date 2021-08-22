@if($feedback->count() > 0)
  @foreach($feedback as $fb)
<p class="f-14"><a href="{{url('adminnew/feedback/view/'.base64_encode($fb->id).'/'.Str::slug($fb->title))}}">{{$fb->title}}</a>
  <p>
    <span class="f-12 text-muted m-r-20">
      <i class="fa fa-user" aria-hidden="true"></i> By {{$fb->first_name}} {{$fb->last_name}}
    </span>
    <span class="f-12 text-muted">
      <i class="fa fa-calendar" aria-hidden="true"></i> 
      Posted on @if(date('Y-m-d') == date('Y-m-d',strtotime($fb->created_at)))
                  {{ \Carbon\Carbon::parse($fb->created_at)->diffForHumans()}}
                @else
                  {{date('F dS Y',strtotime($fb->created_at))}}
                @endif
    </span>
    @if($fb->updated_at)
    <span class="f-12 theme-heading pull-right m-r-30"><i class="fa fa-calendar m-l-30" aria-hidden="true"></i> Replied on {{date('F dS Y',strtotime($fb->updated_at))}}
    </span>
    @endif
  </p>
<hr>
</p>
   @endforeach  
@else
	<p class="f-14 text-center">No feedbacks to show.</p>
@endif 

{{$feedback->links()}}

