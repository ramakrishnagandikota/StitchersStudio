@if($categories->count() > 0)
    @foreach($categories as $cat)
        <?php
        $faqs1 = App\Models\GroupFaq::where('faq_category_id',$cat->id)->orderBy('id','DESC')->take(5)->get();
        ?>
        @if($faqs1->count() > 0)
            <div class="card">
                <div class="card-header">
                    <h5 class="card-header-text"><i class="fa fa-info-circle m-r-10"></i>{{ $cat->category_name }}</h5>
                </div>
                <div class="card-block task-details">
                    <ul style="list-style: circle;padding-left: 20px;padding-right: 10px;">
                        @if($faqs1->count() > 0)
                            @foreach($faqs1 as $fa)
                                <li><p><a href="{{ url('designer/groups/faq/'.$fa->faq_unique_id.'/show') }}">{{ $fa->faq_title }}</a></p></li>
                            @endforeach
                        @else
                            <li><p class="text-center">No posts to show in this category</p></li>
                        @endif
                    </ul>
                </div>
            </div>
        @endif
    @endforeach
@endif
