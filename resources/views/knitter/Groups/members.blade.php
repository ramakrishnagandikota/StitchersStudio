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
                                        <input type="search" name="search" id="searchconnections" placeholder="Search for group members..." aria-describedby="button-addon1" class="form-control border-0">
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
                            @if($members->count() > 0)
                                @foreach($members as $mem)
    @php
    $friend = App\Models\Friends::where('user_id',Auth::user()->id)->where('friend_id',$mem->uid)->count();
    $follow = App\Models\Follow::where('user_id',Auth::user()->id)->where('follow_user_id',$mem->uid)->count();
    $frequest = App\Models\Friendrequest::where('user_id',Auth::user()->id)->where('friend_id',$mem->uid)->count();
    $myfrequest = App\Models\Friendrequest::where('user_id',$mem->uid)->where('friend_id',Auth::user()->id)->count();
    @endphp
                            <div class="col-lg-4 col-xl-3 col-md-4 posts">
                                <div class="rounded-card user-card">
                                    <div class="card">
                                        <div class="img-hover">
                                            <img class="img-fluid img-radius p-10" src="{{$mem->picture}}" alt="round-img">
                                            <div class="img-overlay img-radius">
                                                <span>
                                                   @if($friend == 1)
                                                        <a href="#" class="btn btn-sm btn-primary unfriend" id="friend{{$mem->uid}}" data-toggle="tooltip" data-id="{{$mem->uid}}" data-placement="top" title="Unfriend"data-popup="lightbox"> <i class="fa fa-user-times"></i></a>
                                                    @else
                                                        @if($frequest == 0)
                                                            @if($myfrequest == 0)
                                                                <a href="javascript:;" id="friend{{$mem->uid}}" class="btn btn-sm btn-primary friendRequest" data-toggle="tooltip" data-placement="top" title="Add Friend" data-id="{{$mem->uid}}" data-popup="lightbox"> <i class="fa fa-user-plus"></i></a>
                                                            @else
                                                                <a href="javascript:;" id="friend{{$mem->uid}}" class="btn btn-sm btn-primary acceptRequest" data-toggle="tooltip" data-placement="top" title="Accept Request" data-id="{{$mem->uid}}" data-popup="lightbox"> <i class="fa fa-user-plus"></i></a>
                                                            @endif
                                                        @else
                                                            <a href="javascript:;" id="friend{{$mem->uid}}" class="btn btn-sm btn-primary cancelRequest" data-toggle="tooltip" data-placement="top" title="Request Sent" data-id="{{$mem->uid}}" data-popup="lightbox"> <i class="fa fa-user-plus"></i></a>
                                                        @endif
                                                    @endif

                                                    @if($follow == 1)
                                                        <a href="javascript:;" id="follow{{$mem->uid}}" class="btn btn-sm btn-primary unfollow" data-id="{{$mem->uid}}" data-toggle="tooltip" data-placement="top" title="Unfollow" ><i class="fa icofont icofont-undo"></i></a>
                                                    @else
                                                        <a href="javascript:;" id="follow{{$mem->uid}}" class="btn btn-sm btn-primary follow" data-id="{{$mem->uid}}" data-toggle="tooltip" data-placement="top" title="Follow" ><i class="fa icofont icofont-ui-social-link"></i></a>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                        <div class="user-content">
                                            <a href=""><h4 class="">{{ $mem->first_name.' '.$mem->last_name }}</h4></a>
                                            @php $user = App\User::find($mem->uid); @endphp
                                            @if($user->hasRole('Knitter') && $user->hasRole('Designer'))
                                            <p class="m-b-0 text-muted">Knitter,Designer</p>
                                            @else
                                            <p class="m-b-0 text-muted">Knitter</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @endforeach
                            @else
                            <p class="text-center">No users to show in this group</p>
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
        <script src="{{asset('resources/assets/infinite-scroll.pkgd.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
        <script>
            /* infinite-scroll code */
            var $container = $(".containers");
            $container.infiniteScroll({
                //path: '.pagination__next',
                path: function() {
                    // alert(this.loadCount);
                    if(this.loadCount <= {{$members->lastPage()}}){
                        var pageNumber = ( this.loadCount + 2 ) * 1;
                        return '{{url("knitter/groups/".$group->unique_id."/members?page=")}}'+pageNumber;
                    }

                    //return '/articles/P' + pageNumber;
                },
                append: '.posts',
                history: false,
                status: '.page-load-status',
                scrollThreshold: 100,
                hideNav: '.pagination',
            });

            $(function (){
                $(document).on('click','.unfriend',function(){
                    var id = $(this).attr('data-id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    Swal.fire({
                        title: '',
                        text: "Are you sure want to remove this user from friend list ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Remove'
                    }).then((result) => {
                        if (result.value) {

                            $.ajax({
                                url : '{{url("connect/removeFriend")}}',
                                type : 'POST',
                                data : 'friend_id='+id,
                                beforeSend : function(){
                                    $(".loader-bg").show();
                                    $("#friend"+id).find('i').removeClass('fa-user-times').addClass('fa-spinner fa-spin');
                                },
                                success : function(res){
                                    if(res.success){
                                        $('#myModal').modal('toggle');
                                        $("#popupMessage").html('You have successfully unfriend this person!');
                                        $("#popupClass").html('<img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo">');
                                        setTimeout(function(){ $('#myModal').modal('hide'); },2000);
                                        $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-plus');
                                        $("#friend"+id).attr('data-original-title','Add Friend');
                                        $("#friend"+id).removeClass('unfriend').addClass('friendRequest');
                                        //addProductCartOrWishlist('fa fa-check','success',res.success);
                                    }else{
                                        $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user');
                                        addProductCartOrWishlist('fa fa-times','error',res.error);
                                    }
                                },
                                complete : function(){
                                    $(".loader-bg").hide();
                                }
                            });


                        }
                    });
                });

                $(document).on('click','.friendRequest',function(){
                    var id = $(this).attr('data-id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    $.ajax({
                        url : '{{url("connect/sendFriendRequest")}}',
                        type : 'POST',
                        data : 'friend_id='+id,
                        beforeSend : function(){
                            $(".loader-bg").show();
                            $("#friend"+id).find('i').removeClass('fa-user-plus').addClass('fa-spinner fa-spin');
                        },
                        success : function(res){
                            if(res.success){
                                $('#myModal').modal('toggle');
                                $("#popupMessage").html('Request has been successfully sent!');
                                $("#popupClass").html('<i class="fa fa-check f-46 KFgreen"></i>');
                                setTimeout(function(){ $('#myModal').modal('hide'); },2000);
                                $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-times');
                                $("#friend"+id).attr('data-original-title','Request Sent');
                                $("#friend"+id).removeClass('friendRequest').addClass('cancelRequest');
                                //addProductCartOrWishlist('fa fa-check','success',res.success);

                            }else{
                                $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-plus');
                                addProductCartOrWishlist('fa fa-times','error',res.error);
                            }
                        },
                        complete : function(){
                            $(".loader-bg").hide();
                        }
                    });
                });

                $(document).on('click','.acceptRequest',function(){
                    var id = $(this).attr('data-id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url : '{{url("connect/acceptRequest")}}',
                        type : 'POST',
                        data : 'friend_id='+id,
                        beforeSend : function(){
                            $(".loader-bg").show();
                            $("#friend"+id).find('i').removeClass('fa-user-plus').addClass('fa-spinner fa-spin');
                        },
                        success : function(res){
                            if(res.success){
                                $('#myModal').modal('toggle');
                                $("#popupMessage").html('Friend request has been accepted!');
                                $("#popupClass").html('<i class="fa fa-check f-46 KFpink"></i>');
                                setTimeout(function(){ $('#myModal').modal('hide'); },2000);

                                $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user');
                                $("#friend"+id).attr('data-original-title','Unfriend');
                                $("#friend"+id).removeClass('acceptRequest').addClass('unfriend');
                                //addProductCartOrWishlist('fa fa-check','success',res.success);
                                checkFriendRequests();
                            }else{
                                $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-plus');
                                addProductCartOrWishlist('fa fa-times','error',res.error);
                            }
                        },
                        complete : function(){
                            $(".loader-bg").hide();
                        }
                    });
                });

                $(document).on('click','.cancelRequest',function(){
                    var id = $(this).attr('data-id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    Swal.fire({
                        title: '',
                        text: "Are you sure want to remove this friend request ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Remove'
                    }).then((result) => {
                        if (result.value) {

                            $.ajax({
                                url : '{{url("connect/cancelFriendRequest")}}',
                                type : 'POST',
                                data : 'friend_id='+id,
                                beforeSend : function(){
                                    $(".loader-bg").show();
                                    $("#friend"+id).find('i').removeClass('fa-user-times').addClass('fa-spinner fa-spin');
                                },
                                success : function(res){
                                    if(res.success){
                                        $('#myModal').modal('toggle');
                                        $("#popupMessage").html('Request has been cancled!');
                                        $("#popupClass").html('<img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo">');
                                        setTimeout(function(){ $('#myModal').modal('hide'); },2000);


                                        $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-plus');
                                        $("#friend"+id).attr('data-original-title','Add Friend');
                                        $("#friend"+id).removeClass('cancelRequest').addClass('friendRequest');
                                        //addProductCartOrWishlist('fa fa-check','success',res.success);
                                    }else{
                                        $("#friend"+id).find('i').removeClass('fa-spinner fa-spin').addClass('fa-user-times');
                                        addProductCartOrWishlist('fa fa-times','error',res.error);
                                    }
                                },
                                complete : function(){
                                    $(".loader-bg").hide();
                                }
                            });
                        }

                    });
                });

                $(document).on('click','.unfollow',function(){
                    var id = $(this).attr('data-id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url : '{{url("connect/unfollow")}}',
                        type : 'POST',
                        data : 'follow_user_id='+id,
                        beforeSend : function(){
                            $(".loader-bg").show();
                            $("#follow"+id).find('i').removeClass('icofont-undo').addClass('fa-spinner fa-spin');
                        },
                        success : function(res){
                            if(res.success){
                                $('#myModal').modal('toggle');
                                $("#popupMessage").html('You have unfollowed the person now!!');
                                $("#popupClass").html('<i class="icofont icofont-undo f-46 KFpink"></i>');
                                setTimeout(function(){ $('#myModal').modal('hide'); },2000);

                                $("#follow"+id).find('i').removeClass('fa-spinner fa-spin').addClass('icofont-ui-social-link');
                                $("#follow"+id).attr('data-original-title','Follow');
                                $("#follow"+id).removeClass('unfollow').addClass('follow');
                                //addProductCartOrWishlist('fa fa-check','success',res.success);

                            }else{
                                $("#follow"+id).find('i').removeClass('fa-spinner fa-spin').addClass('icofont-ui-social-link');
                                addProductCartOrWishlist('fa fa-times','error',res.error);
                            }
                        },
                        complete : function(){
                            $(".loader-bg").hide();
                        }
                    });
                });

                $(document).on('click','.follow',function(){
                    var id = $(this).attr('data-id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });


                    $.ajax({
                        url : '{{url("connect/follow")}}',
                        type : 'POST',
                        data : 'follow_user_id='+id,
                        beforeSend : function(){
                            $(".loader-bg").show();
                            $("#follow"+id).find('i').removeClass('icofont icofont-ui-social-link').addClass('fa-spinner fa-spin');
                        },
                        success : function(res){
                            if(res.success){

                                $('#myModal').modal('toggle');
                                $("#popupMessage").html('You are following this person now!');
                                $("#popupClass").html('<i class="fa fa-check f-46 KFpink"></i>');

                                setTimeout(function(){ $('#myModal').modal('hide'); },2000);

                                $("#follow"+id).find('i').removeClass('fa-spinner fa-spin').addClass('icofont icofont-undo');
                                $("#follow"+id).attr('data-original-title','Unfollow');
                                $("#follow"+id).removeClass('follow').addClass('unfollow');
                                //addProductCartOrWishlist('fa fa-check','success',res.success);
                            }else{
                                $("#follow"+id).find('i').removeClass('fa-spinner fa-spin').addClass('icofont-undo');
                                addProductCartOrWishlist('fa fa-times','error',res.error);
                            }
                        },
                        complete : function(){
                            $(".loader-bg").hide();
                        }
                    });

                });


            });
        </script>
    @endsection