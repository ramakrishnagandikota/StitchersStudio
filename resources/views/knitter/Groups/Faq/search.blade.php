<ul class="list-group" id="resultsUl">
    @if($faqs->count() > 0)
        @foreach($faqs as $faq)
            <li class="list-group-item">
                <a href="{{ url('knitter/groups/faq/'.$faq->faq_unique_id.'/show') }}">{{ $faq->faq_title }}</a>
            </li>
        @endforeach
    @else
        <li class="list-group-item" style="text-align: center;font-style: italic;">No results to show for search criteria.</li>
    @endif
</ul>
<style>
    #resultsUl{
        position: absolute;
        z-index: 1;
        background: #faf9f8;
        width: 95%;
        box-shadow: 1px 0px 4px 0px #727272;
        border: 1px solid #d9d9d9;
    }
    #resultsUl li{
        margin-left: 0px;
        margin-right: 0px;
    }
</style>
