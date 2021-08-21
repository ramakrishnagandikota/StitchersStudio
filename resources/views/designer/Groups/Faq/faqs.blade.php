@if($faqs->count() > 0)
    <?php $i = 0; ?>
    @foreach($faqs as $faq)
        <div class="card accordionBox">
            <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link btn-block text-left accordion @if($i == 0) collapsed @endif" data-id="{{$i}}" type="button" data-toggle="collapse" data-target="#collapseOne{{$i}}" aria-expanded="true" aria-controls="collapseOne{{$i}}">
                        {{ $faq->faq_title }}
                    </button>
                    <span class="upDownIcon"><a href="javascript:;" data-id="{{ $faq->faq_unique_id }}" class="fa fa-pencil editFaq"></a>&nbsp;&nbsp;<a href="javascript:;" data-id="{{ $faq->faq_unique_id }}" class="fa fa-trash deleteFaq"></a> </span>
                </h2>
            </div>

            <div id="collapseOne{{$i}}" class="collapse @if($i == 0) show @endif " aria-labelledby="headingOne" data-parent="#accordionExample">
                <div class="card-body" style="text-align: justify;">
                    {!! $faq->faq_description !!}
                </div>
            </div>
        </div>
        <?php $i++; ?>
    @endforeach
    <div class="text-center m-t-20">
        {!! $faqs->links('vendor.pagination.bootstrap-4') !!}
    </div>
@else
    <div class="col-md-12">
        <h5 class="text-center">No FAQ's added for this group.</h5>
    </div>
@endif
