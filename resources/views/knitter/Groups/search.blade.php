@extends('layouts.knitterapp')
@section('title','My subscribed groups')
@section('content')
<div class="pcoded-wrapper" id="dashboard">
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">

    <div class="page-body m-t-15">
        <div class="row">
            <div class="col-xl-8 col-lg-8 col-sm-8">
                <h5 class="m-b-30 theme-heading">Search : {{$search}}</h5>
            </div>
        </div>
        <div class="row justify-content-md-center m-t-10" id="mygroupDiv">
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ url('knitter/groups/search') }}"  autocomplete="off">
                                <div class="rounded rounded-pill">
                                    <div class="input-group" style="margin-bottom: 1px;">
                                        <input type="search" name="search" id="search" value="{{ $search }}" placeholder="Search for group..." aria-describedby="button-addon1" class="form-control border-0">
                                        <div class="input-group-append">
                                            <button  type="submit" class="btn btn-link text-primary searchresult"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="row users-card containers" id="myGroups">
                            @if($groups->count() > 0)
                                @foreach($groups as $group)
                                    @php
                                        $product = App\Models\Product_images::where('product_id',$group->product_id)->first();
                                        if($product){
                                            $image = $product->image_small;
                                        }else{
                                            $image = url("resources/assets/files/assets/images/knit-along.png");
                                        }
                                        $members = App\Models\GroupUser::where('group_id',$group->id)->where('user_type','Member')->count();
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
                                    <div class="page-load-status">
                                        {{$groups->links('vendor.pagination.bootstrap-4')}}
                                    </div>
                            @else
                                <p class="text-center" style="width:100%;">No groups found for your search.</p>
                            @endif
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
</div>
</div>
</div>
@endsection
    @section('footerscript')
        <style>
            .hide{
                display: none;
            }
            .red{
                border: 1px solid #bc7c8f !important;
            }
            .loader-ellips {
                font-size: 20px; /* change size here */
                position: relative;
                width: 4em;
                height: 1em;
                margin: 10px auto;
            }

            .loader-ellips__dot {
                display: block;
                width: 1em;
                height: 1em;
                border-radius: 0.5em;
                background: #0d665c !important; /* change color here */
                position: absolute;
                animation-duration: 0.5s;
                animation-timing-function: ease;
                animation-iteration-count: infinite;
            }

            .loader-ellips__dot:nth-child(1),
            .loader-ellips__dot:nth-child(2) {
                left: 0;
            }
            .loader-ellips__dot:nth-child(3) { left: 1.5em; }
            .loader-ellips__dot:nth-child(4) { left: 3em; }

            @keyframes reveal {
                from { transform: scale(0.001); }
                to { transform: scale(1); }
            }

            @keyframes slide {
                to { transform: translateX(1.5em) }
            }

            .loader-ellips__dot:nth-child(1) {
                animation-name: reveal;
            }

            .loader-ellips__dot:nth-child(2),
            .loader-ellips__dot:nth-child(3) {
                animation-name: slide;
            }

            .loader-ellips__dot:nth-child(4) {
                animation-name: reveal;
                animation-direction: reverse;
            }
        </style>
        <script src="{{asset('resources/assets/infinite-scroll.pkgd.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
        <script>

            $(function (){
                addDataToUrl();
                $(document).on('click','.exitGroup',function (){
                    var id = $(this).attr('data-id');
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to exit from this group ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(".loading").show();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.post('{{ url("knitter/groups/exit") }}',{id:id},function (res){
                                if(res.status == 'success'){
                                    $("#group"+id).remove();
                                    Swal.fire(
                                        'Yeah..!',
                                        'You have exited from group..',
                                        'success'
                                    );
                                    $(".loading").hide();
                                }else{
                                    Swal.fire(
                                        'Oops..!',
                                        res.message,
                                        'danger'
                                    );
                                    $(".loading").hide();
                                }
                            });
                        }
                    })
                });
            });

            function addDataToUrl(){
                $(".page-item a").each(function (){
                    var href = $(this).attr('href');
                    $(this).attr('href',href+'&search={{$search}}');
                });
            }
        </script>
    @endsection