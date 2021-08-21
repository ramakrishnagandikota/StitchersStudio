<div class="containers">
    @foreach($timeline as $time)
        @component('Designer.Groups.Community.posts', ['time' => $time]) @endcomponent
    @endforeach
</div>
