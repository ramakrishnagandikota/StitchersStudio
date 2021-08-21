<div class="containers">
    @foreach($timeline as $time)
        @component('Knitter.Groups.Community.posts', ['time' => $time]) @endcomponent
    @endforeach
</div>
