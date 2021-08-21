<!DOCTYPE html>
<html lang="en">

<head>
    <title>KnitFit | @yield('title')</title>
    <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 10]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Gradient Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->

    <link rel="icon" href="{{ asset('resources/assets/files/assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- Google font-->     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/bower_components/bootstrap/css/bootstrap.min.css')}}">
    <!-- waves')}} -->
    <link rel="stylesheet" href="{{ asset('resources/assets/files/assets/pages/waves/css/waves.min.css')}}" type="text/css" media="all">
    <!-- feather icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/feather/css/feather.css')}}">
    <!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/themify-icons/themify-icons.css')}}">
    <!-- ico font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/icofont/css/icofont.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/font-awesome/css/font-awesome.min.css')}}">
     <!-- <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/simple-line-icons/css/simple-line-icons.css')}}"> -->
    <!-- Style')}} -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.css')}}">

	<!--<script src="{{ asset('public/js/manifest.js') }}"></script>
    <script src="{{ asset('public/js/vendor.js') }}"></script>
    <script src="{{ asset('public/js/app.js') }}" ></script>-->

<style>
    [type=radio] {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

/* IMAGE STYLES */
[type=radio] + img {
  cursor: pointer;
}

/* CHECKED STYLES */
[type=radio]:checked + img {
    border: 2px solid #0f3833;
    padding: 8px;
    border-radius: 6px;
}
</style>
</head>

<body>
@php
if(Auth::check()){
if(Auth::user()->isAdmin()){
    $url = 'admin';
}elseif (Auth::user()->isKnitter()) {
    $url = '/ashboard';
}elseif (Auth::user()->isDesigner()) {
    $url = 'dashboard';
}else{
    $url = '/';
}
}else{
	$url = '/';
}
@endphp
    <div class="loading">
  <div class="loaders"></div>
</div>
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
    <div class="loader-bar"></div>
</div>
<div id="app">
    <example-component></example-component>
</div>
<!-- [ Pre-loader ] end -->
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <!-- [ Header ] start -->
        <nav class="navbar header-navbar pcoded-header">
            <div class="navbar-wrapper">
                <div class="navbar-logo">

                    <a href="https://stitchersstudio.com/website">
                        <img class="img-fluid theme-logo" src="{{ asset('resources/assets/files/assets/images/logoNew.png')}}" alt="Theme-Logo" />
                    </a>
                    <a class="mobile-options waves-effect waves-light">
                        <i class="feather icon-more-horizontal"></i>
                    </a>
                </div>
                <div class="navbar-container container-fluid">
                    <!-- <ul class="nav-left">
                        <li class="header-search">
                            <div class="main-search morphsearch-search">
                                <div class="input-group">
                                        <span class="input-group-prepend search-close">
										<i class="feather icon-x input-group-text"></i>
									</span>
                                    <input type="text" class="form-control" placeholder="Enter Keyword">
                                    <span class="input-group-append search-btn">
										<i class="feather icon-search input-group-text"></i>
									</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                <i class="full-screen feather icon-maximize"></i>
                            </a>
                        </li>
                    </ul> -->

                    <ul class="nav-right">
					@yield('designer-groups-menu')
                            <li class="header-notification toggle-menu">
                                    <div class="dropdown-primary dropdown">
                                        <div class="displayChatbox dropdown-toggle" data-toggle="dropdown">
                                                <i class="fa fa-navicon"></i>
                                        </div>
                                    </div>
                                </li>
                       <!-- <li>
                            <div class="text-center">
                                <a href="url('subscription')}}" class="btn btn-primary">Subscribe</a>
                            </div>
                        </li>
                        <li>
                            <a href="{{url('knitter/subscription')}}" class="waves-effect waves-light">
                               Subscription
                            </a>
                        </li> --
<li>
  <a style="color: #0d665c" href="{{url('feedback')}}"><i class="fa fa-comments"></i> Send us Feedback</a>
</li>
<!--
<li style="{{Request::is('knitter/dashboard') ? 'display:block;' : 'display:none;'}}">
  <a target="_blank" onclick="saveSession()"  style="color: #0d665c" href="{{url('Knitfit-help')}}"><i class="fa fa-file-text"></i> Help</a>
</li>

<li>
  <a target="_blank" onclick="saveSession()"  style="color: #0d665c" href="{{url('Knitfit-help')}}"><i class="fa fa-file-text"></i> Help</a>
</li>
-->
<li class="header-notification"  >
<div class="dropdown-primary dropdown">
<div class="dropdown-toggle" data-toggle="dropdown" id="header-notification" onclick="markAsRead({{count(Auth::user()->unreadNotifications)}});">
<i class="feather icon-bell"></i>

@if(count(Auth::user()->unreadNotifications) > 0)
<span class="badge bg-c-red">{{count(Auth::user()->unreadNotifications)}}</span>
@endif
</div>
<ul id="show-notification" class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" style="max-height: 400px;overflow-y: scroll;">

  </ul>
</div>
</li>

@php
if(Auth::user()->picture){
  $pic = Auth::user()->picture;
}else{
    $a = Auth::user()->first_name;
    $firstChar = mb_substr($a, 0, 1, "UTF-8");
  $pic = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.$firstChar;
}
@endphp

                        <li class="user-profile header-notification">
                            <div class="dropdown-primary dropdown">
                                <div class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="{{ $pic }}" class="img-radius" alt="User-Profile-Image">
                                    <span>{{Auth::user()->first_name}}</span>
                                    <i class="feather icon-chevron-down"></i>
                                </div>
                                <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                                    <li>
										<a href="{{url('connect/myprofile')}}">
											<i class="fa fa-photo"></i> <span>Studio</span>
										</a>
									</li>
									<li>
										<a href="{{url('my-account')}}">
											<i class="fa fa-user"></i> Account
										</a>
									</li>
									<li>
										<a href="{{url('knitter/subscription')}}">
											<i class="fa fa-dollar"></i> Subscription
										</a>
									</li>
									<li>
										<a href="{{url('feedback')}}">
											<i class="fa fa-comment"></i> <span>Send us feedback</span>
										</a>
									</li>

									<li>
										<a href="{{url('logout')}}">
											<i class="feather icon-log-out"></i> Logout
										</a>
									</li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </nav>
        <!-- [ Header ] end -->

       <div class="pcoded-main-container">
       @yield('content')

        </div>

        <div id="sidebar" class="users p-chat-user showChat">
            <div class="had-container">
                <div class="p-fixed users-main">
                    <div class="user-box">
                        <div class="chat-search-box">
                            <a class="back_friendlist">
                            <i class="feather icon-x"></i>
                        </a>
						@if(Auth::user()->hasRole('Knitter') && Auth::user()->hasRole('Designer'))
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(Auth::user()->hasRole('Knitter') && !Auth::user()->hasRole('Designer')) show @endif" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Knitter</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(Auth::user()->hasRole('Knitter') && Auth::user()->hasRole('Designer')) show active @endif" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Designer</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
						<!--  -->
                            <div class="tab-pane fade @if(Auth::user()->hasRole('Knitter') && !Auth::user()->hasRole('Designer')) show active @endif" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                @include('layouts.menu.menu')
                            </div>
                            <div class="tab-pane fade @if(Auth::user()->hasRole('Knitter') && Auth::user()->hasRole('Designer')) show active @endif" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                @include('layouts.menu.menu-designer')
                            </div>
                        </div>
                        <!-- include menu here -->
                        @elseif(Auth::user()->hasRole('Knitter'))
                            @include('layouts.menu.menu')
                        @elseif(Auth::user()->hasRole('Designer'))
                            @include('layouts.menu.menu-designer')
                        @else

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


<div class="modal fade" id="session-Modal" role="dialog">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
            <h5 class="modal-title">Session Timeout</h5>
      </div>
      <div class="modal-body">
          <p class="text-center">You're session has expired. Please <a href="{{url('login')}}" style="color: #bc7c8f;">login</a> again </p>
      </div>
    </div>
  </div>
</div>

         
<!-- Modal View details Knit along -->
<div class="modal fade" id="view-details-knit-along" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Atitle">knit along Invitation</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body text-center m-t-15" >
                <input type="hidden" id="AgroupRequestId" value="0">
                <input type="hidden" id="AdesignerBroadcastId" value="0">
                <input type="hidden" id="AgroupId" value="0">
                <div class="card" style="box-shadow:none">
                    <div class="card-header">
                        <div class="media">
                            <a class="media-left media-middle" href="#">
                                <img class="media-object img-60" id="AgroupImage" src="{{ asset('resources/assets/files/assets/images/knit-along.png') }}" alt="Generic placeholder image">
                            </a>
                            <div class="media-body media-middle">
                                <div class="company-name">
                                    <p class="text-left" id="Agroup_name">Peekaboo sweater Knit along group</p>
                                    <span class="text-muted f-14 f-w-600 text-left" id="Astart_date"> Start date : June 16, 2021</span>
                                    <span class="text-muted f-14 f-w-600 text-left" id="Amembers"> End date : July 02, 2021</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block">
                        <h6 class="job-card-desc text-left">Description</h6>
                        <p class="text-muted text-left" id="Adescription">
                            The Peekaboo Sweater is meant to be shapely, yet comfortable. However, you may decide how tight or loose you want the sweater to be by selecting the ease you want added to your measurements. As the designer, I recommend a small amount of ease - about 1.5 to 2 inches.
                            You will need the following measurements for this sweater when you generate your custom pattern:
                            Lower Edge Circumference 
                            Lower Edge to Underarm
                            Lower Edge to Waist
                        </p>
                        <p class="text-left job-card-desc f-14">Skill level</p>
                        <div class="job-meta-data text-left" id="Aexpertise_level"><i class="icofont icofont-safety"></i>Proficient</div>
                        <div class="text-center">
                            <button type="button" class="btn theme-outline-btn waves-effect waves-light btn-md" id="ignoreInvitation"> &nbsp;&nbsp;&nbsp;&nbsp;Ignore&nbsp;&nbsp;&nbsp;&nbsp;</button>
                            <button type="button" class="btn theme-btn waves-effect waves-light btn-md" id="acceptInvitation"> Accept invitation</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
        </div>
    </div>
	
	
 <style type="text/css">
 .nav-pills .nav-link{
        border-radius: 0px;
    }
    .nav-pills .nav-link.active, .nav-pills .nav-link.active:focus, .nav-pills .nav-link.active:hover, .nav-pills .nav-link.active, .nav-pills .nav-link.active:focus, .nav-pills .nav-link.active:hover, .nav-pills .nav-link.active.active, .nav-pills .nav-link.active.active:focus, .nav-pills .nav-link.active.active:hover {
        border-bottom: 2px solid #0d665c !important;
    }
    figure a{
        border-bottom: 0px !important;
    }
    .userMenu li{
        padding: 10px;
    }
    #menunConent{
        padding: 10px;
    }
.loaders {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #bc7c8f;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  position: absolute;
    margin: auto;
    top: 250px;
	left: 570px !important;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.loading{
    display: none;
      background: #00000085;
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: 10000;
    padding: 0px;
    top: 0px;

}
.header-navbar .navbar-wrapper .navbar-container .badge{
    width:auto !important;
}
/* sweet alert customizes css */
  .swal2-icon.swal2-success [class^=swal2-success-line]{
	  background-color: #0d665c !important;
  }
  .swal2-icon.swal2-success .swal2-success-ring{
	  border:.25em solid rgb(13, 102, 92)
  }
  .swal2-styled.swal2-confirm {

    background-color: #0d665c !important;
    color: #fff !important;
    border: 1px solid #0d665c !important;
  }
  .swal2-icon.swal2-error [class^=swal2-x-mark-line]{
	  background-color: #bc7c8f !important;
  }
  .swal2-icon.swal2-error {
    border-color: #bc7c8f !important;
    color: #bc7c8f !important;
}
.swal2-styled.swal2-cancel {
    background-color: #bc7c8f !important;
}
.swal2-icon.swal2-warning {
    border-color: #bc7c8f !important;
    color: #bc7c8f !important;
}
.alert-success {
    background-color: #fff;
    border-color: #0d665c;
    color: #0d665c;
}
.alert-danger {
    background-color: #fff;
    border-color: #bc7c8f;
    color: #bc7c8f;
}
.brand-color{
  color: #0d665c !important;
}
figure{
	width: 136px !important;
}
figure:hover {
    background-color: white !important;
    /*padding: 0px !important;*/
    cursor: pointer !important;
}
.addBlur{
        filter:blur(5px) !important;
    }
 </style>
 <script type="text/javascript">
     var URL = "{{url('/')}}";
     var PAGE = '';
 </script>
<!-- Required Jquery -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery/js/jquery.min.js')}}"></script>

<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-ui/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/popper.js/js/popper.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/bootstrap/js/bootstrap.min.js')}}"></script>
<!-- waves js -->
<script src="{{ asset('resources/assets/files/assets/pages/waves/js/waves.min.js')}}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js')}}"></script>
<!-- modernizr js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/modernizr/js/modernizr.js')}}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/modernizr/js/css-scrollbars.js')}}"></script>

<script src="{{ asset('resources/assets/files/assets/js/pcoded.min.js')}}"></script>
<script src="{{ asset('resources/assets/files/assets/js/vertical/vertical-layout.min.js')}}"></script>
<script src="{{ asset('resources/assets/files/assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>

<script type="text/javascript" src="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.js')}}"></script>


<!-- Bootstrap Notification js-->
<link rel="stylesheet" type="text/css" href="{{asset('resources/assets/assets/css/animate.css')}}">
<script type="text/javascript" src="{{asset('resources/assets/assets/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{ asset('resources/assets/titlechanger/jquery.titlealert.js') }}"></script>

<script>
    /*var user_id = '{{ Auth::user()->id }}';
    window.Echo.private('App.User.'+user_id)
        .notification((notification) => {
            //console.log(notification);
            var notificationsCount = $("#notificationsCount").html();
            var newCount = parseInt(notificationsCount) + 1;
            if(notificationsCount){
                $("#notificationsCount").html(newCount);
                $.titleAlert('You have '+newCount+' notifications.', {interval:500, stopOnFocus:true});
            }else{
                $("#header-notification").append('<span class="badge bg-c-red" id="notificationsCount">1</span>');
                $.titleAlert('You have a new notification.', {interval:500, stopOnFocus:true});
            }
            getAllNotifications();
        });*/
		
		$(function(){
            $(document).on('click','.invitationButton',function (){
            $("#view-details-knit-along").addClass('addBlur');
            $(".loading").show();
            var groupId = $(this).attr('data-groupId');
            var groupRequestId = $(this).attr('data-groupRequestId');
            var designerBroadcastId = $(this).attr('data-designerBroadcastId');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post('{{ url('designer/getGroupInformation') }}',{groupId:btoa(groupId),groupRequestId:groupRequestId,designerBroadcastId:designerBroadcastId},function (res){
				//console.log(res);
               if(res.status == 'success'){
                   $("#Atitle").html(res.title);
                   $("#Agroup_name").html(res.group_name);
                   $("#Astart_date").html('Start date : '+res.start_date);
                   $("#Amembers").html('No of members : '+res.members);
                   $("#Adescription").html(res.message);
                   $("#Aexpertise_level").html('<i class="icofont icofont-safety"></i> '+res.expertise_level);
                   $("#view-details-knit-along").modal('show');
                   $("#AgroupRequestId").val(groupRequestId);
                   $("#AdesignerBroadcastId").val(designerBroadcastId)
                   $("#AgroupId").val(groupId);
				   $("#AgroupImage").attr('src',res.groupImage);
                   setTimeout(function (){ $("#view-details-knit-along").removeClass('addBlur'); },1000);
               }else{
                   Swal.fire(
                       'Oops..!',
                       'Unable to show this notification. Try again after sometime.',
                       'danger'
                   );
               }
            });
            $(".loading").hide();
        });

        $(document).on('click','#ignoreInvitation',function (){
            var id = $("#AgroupRequestId").val();
            var designerBroadcastId = $("#AdesignerBroadcastId").val()
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to ignore this request ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, ignore it!'
            }).then((result) => {
				
                if (result.value == true) {
                    $(".loading").show();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.post('{{ url("designer/ignoreGroupInvitationequest") }}',{id:id,designerBroadcastId:designerBroadcastId},function (res){
                        if(res.status == 'success'){
                            $("#view-details-knit-along").modal('hide');
                            Swal.fire(
                                'Removed!',
                                'Invitation rejected.',
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
            });
        });

        $(document).on('click','#acceptInvitation',function (){
            $(".loading").show();
            var groupId = $("#AgroupId").val();
            var groupRequestId = $("#AgroupRequestId").val();
            var designerBroadcastId = $("#AdesignerBroadcastId").val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post('{{ url('designer/acceptGroupInvitationequest') }}',{groupId:btoa(groupId),groupRequestId:groupRequestId,designerBroadcastId:designerBroadcastId},function (res){
                if(res.status == 'success'){
                    $("#view-details-knit-along").modal('hide');
                    Swal.fire(
                        'Yeah..!',
                        'Invitation accepted & you have successfully joined in the group.',
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
            $(".loading").hide();
        });
        });
		
</script>


<script>
function notifyMe(timeline,name,body,picture) {
  // Let's check if the browser supports notifications
  if (!("Notification" in window)) {
    alert("This browser does not support desktop notification");
  }

  // Let's check if the user is okay to get some notification
  else if (Notification.permission === "granted") {
    // If it's okay let's create a notification
  var options = {
        body: body,
        icon: picture,
        dir : "ltr"
    };
  var notification = new Notification(name,options);
  }

  // Otherwise, we need to ask the user for permission
  // Note, Chrome does not implement the permission static property
  // So we have to check for NOT 'denied' instead of 'default'
  else if (Notification.permission !== 'denied') {
    Notification.requestPermission(function (permission) {
      // Whatever the user answers, we make sure we store the information
      if (!('permission' in Notification)) {
        Notification.permission = permission;
      }

      // If the user is okay, let's create a notification
      if (permission === "granted") {
        var options = {
              body: body,
              icon: picture,
              dir : "ltr"
          };
        var notification = new Notification(name,options);
      }
    });
  }

  // At last, if the user already denied any notification, and you
  // want to be respectful there is no need to bother them any more.
}
</script>

<style type="text/css">
    [data-notify="progressbar"] {
    margin-bottom: 0px;
    position: absolute;
    bottom: 0px;
    left: 0px;
    width: 100%;
    height: 5px;
}

.red{
color: #bc7c8f;
font-weight:bold;
font-size: 12px;
}
</style>

<script type="text/javascript">
  var is_session_exist = 0;


function check_session(){
  $.get('{{url("checkSession")}}',function(res){
      //alert(res.status);
      if(res.status == false){

          $('#session-Modal').modal({
          backdrop: 'static',
          keyboard: false,
         });
         is_session_exist = 1;

      }
  });
}


    $(function(){
        getAllNotifications();
		
		$(document).on('click','#header-notification',function(){
			$("#show-notification").fadeIn();
		});
		
		$(document).on('click','body',function(){
			$("#show-notification").fadeOut();
		});
    });


function getAllNotifications(){
  $.get('{{url("showAllNotifications")}}',function(res){
    $("#show-notification").html(res);
  });
}

function markAsRead(data){
var length = $("#show-notification li").length;
if(length > 1){
  if(data > 0){
      $.get('{{url("connect/markAsRead")}}');
      $("#NotificationCount").remove();
    }
}else{
  getAllNotifications();
}
}

var countint = setInterval(function(){
 check_session();
 
  if(is_session_exist == 1)
  {
   clearInterval(countint);
  }
}, 1800000);

function saveSession(){
    localStorage.setItem('session','dashboard');
}

function notification(icon,status,msg,type){
        $.notify({
            icon: 'fa '+icon,
            title: status+'!',
            message: msg
        },{
            element: 'body',
            position: null,
            type: type,
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: true,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 10000,
            delay: 6000,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
                '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
                '<span data-notify="icon"></span> ' +
                '<span data-notify="title">{1}</span> ' +
                '<span data-notify="message">{2}</span>' +
                '<div class="progress" data-notify="progressbar">' +
                '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                '</div>' +
                '<a href="{3}" target="{4}" data-notify="url"></a>' +
                '</div>'
        });
    }
</script>
@yield('footerscript')



</body>

</html>
