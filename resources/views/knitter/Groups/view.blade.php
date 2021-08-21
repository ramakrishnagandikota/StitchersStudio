@if($groups->count() > 0)
    @foreach($groups as $group)
        @php
            $product = App\Models\Product_images::where('product_id',$group->product_id)->first();
            if($product){
                $image = $product->image_small;
            }else{
                $image = url("resources/assets/files/assets/images/knit-along.png");
            }
            $members = App\Models\GroupUser::where('group_id',$group->id)->count();
            $postsAvg = 0;
        @endphp
        <div class="posts col-lg-3 col-xl-3 col-md-4 hidethis" id="group{{$group->unique_id}}">
            <div class="rounded-card user-card">
                <div class="card">
                    <div class="img-hover">
                        <img class="img-fluid" src="{{$image}}" alt="round-img">
                        <div class="img-overlay">
                                            <span>
                                                <a href="{{ url('knitter/groups/'.$group->unique_id.'/faq') }}" class="btn btn-sm btn-primary" data-popup="lightbox">
                                                    <i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="View FAQ"></i>
                                                </a>
                                                <a href="javascript:;" class="btn btn-sm btn-primary exitGroup" data-id="{{ $group->unique_id }}">
                                                    <i class="fa fa-user-times" data-toggle="tooltip" data-placement="top" title="Exit group"></i>
                                                </a>
                                            </span>
                        </div>
                    </div>
                    <div class="text-center">
                        <h6 class="m-b-10 m-t-10">
                            <a class="f-16" href="{{ url('knitter/groups/'.$group->unique_id.'/community') }}">{{ $group->group_name }}</a>
                        </h6>
                        <p><a href="">{{$members}} Members</a> • {{$postsAvg}} posts a day</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
