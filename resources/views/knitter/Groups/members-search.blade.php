@extends('layouts.knitterapp')
@section('title',$group->group_name.' members')
@section('content')
<div class="pcoded-wrapper" id="dashboard">
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
    
    @section('designer-groups-menu')
        <li><a href="{{ url('knitter/my-groups') }}" class="waves-effect waves-light">Groups</a></li>
        <li><a href="{{ url('knitter/groups/'.$group->unique_id.'/members') }}" class="waves-effect waves-light active">Group members</a></li>
        <li><a href="{{ url('knitter/groups/'.$group->unique_id.'/community') }}" class="waves-effect waves-light">Community</a></li>
        <li><a href="{{ url('knitter/groups/'.$group->unique_id.'/faq') }}" class="waves-effect waves-light">FAQ's</a></li>
    @endsection
    <div class="page-body">
        <div class="row">
            <div class="col-lg-12">
                <label class="theme-heading f-w-600 m-b-20">{{ $group->group_name }} : Group members
                </label>
            </div>
        </div>

        <div class="row justify-content-md-center">
            <div class="col-lg-10">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <form action="{{ url('knitter/groups/'.$group->unique_id.'/members/search') }}">
                                <div class="rounded rounded-pill">
                                    <div class="input-group" style="margin-bottom: 1px;">
                                        <input required type="search" name="search" value="{{ $search }}" placeholder="Search for group members..." aria-describedby="button-addon1" class="form-control border-0">
                                        <div class="input-group-append">
                                            <button  type="submit" class="btn btn-link text-primary searchresult"><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="row users-card containers">
                            @if(count($members) > 0)
                                @foreach($members as $mem)
                                    <div class="col-lg-4 col-xl-3 col-md-4 posts">
                                        <div class="rounded-card user-card">
                                            <div class="card">
                                                <div class="img-hover">
                                                    <img class="img-fluid img-radius p-10" src="{{$mem->picture}}" alt="round-img">
                                                    <div class="img-overlay img-radius">
                                                <span>
                                                    <a href="" data-toggle="modal" data-target="#removeFriendModal" class="btn btn-sm btn-primary removeFriend"><i class="fa fa-user-times" data-toggle="tooltip" data-placement="top" title="Remove member"></i></a>
                                                </span>
                                                    </div>
                                                </div>
                                                <div class="user-content">
                                                    <a href=""><h4 class="">{{ $mem->first_name.' '.$mem->last_name }}</h4></a>
                                                    <p class="m-b-0 text-muted">Technical designer</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="clearfix"></div>
                                <div class="text-center col-md-12">
                                    {{ $members->links('vendor.pagination.bootstrap-4') }}
                                </div>
                            @else
                                <p class="text-center" style="width: 100%;">No users to show in this group</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Round card end -->
    </div>

</div>
</div>
</div>
</div>
</div>
@endsection
    @section('footerscript')
        <style>
            .fa-pencil{
                background-color: unset !important;
                color: #c38a9b !important;
                padding: 0px !important;
            }
            .underline{
                border-bottom: 2px dotted #c38a9b;
            }
            #gpages{
                display: none;
            }
            .nav-right li .active {
                border-bottom: 1px solid #0d665c;
                color: #0d665c;
                font-weight: 500;
            }
            .kf-pink{
                color: red;
            }
            .help-block{
                color: red;
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
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
        <script>
            $(function (){
                addDataToUrl();
            });
            function addDataToUrl(){
                $(".page-item a").each(function (){
                    var href = $(this).attr('href');
                    $(this).attr('href',href+'&search={{$search}}');
                });
            }
        </script>

    @endsection
