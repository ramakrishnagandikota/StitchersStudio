<div class="containers">
@foreach($timeline as $time)

@if($time->privacy == 'only-me')
    @if(Auth::user()->id == $time->user_id)
        @component('connect.timeline.posts', ['time' => $time]) @endcomponent
    @endif
@endif

@if($time->privacy == 'friends')
@if(Auth::user()->id == $time->user_id)
    @component('connect.timeline.posts', ['time' => $time]) @endcomponent
@endif
    @foreach($friends as $friend)
        @if($friend->friend_id == $time->user_id)
            @component('connect.timeline.posts', ['time' => $time]) @endcomponent
        @endif
    @endforeach
@endif

@if($time->privacy == 'followers')
@if(Auth::user()->id == $time->user_id)
    @component('connect.timeline.posts', ['time' => $time]) @endcomponent
@endif
    @foreach($follow as $foll)
        @if($foll->follow_user_id == $time->user_id)
            @component('connect.timeline.posts', ['time' => $time]) @endcomponent
        @endif
    @endforeach
@endif

@if($time->privacy == 'public')
    @component('connect.timeline.posts', ['time' => $time]) @endcomponent
@endif
@endforeach
</div>
