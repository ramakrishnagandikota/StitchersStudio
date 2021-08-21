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
    <script>
        window.auth = {!! Auth::user() !!}
    </script>
<!-- <script src="{{ asset('public/js/app.js') }}" async defer></script>-->
  <!--  <script src="{{ asset('public/js/manifest.js') }}"></script>
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
        .subscription{color: #c14d7d;}
        .subscription{
            animation:blinkingText 1.2s infinite;
        }
        @keyframes blinkingText{
            0%{     color: #c14d7d    }
            49%{    color:#c14d7d  }
            60%{    color: transparent; }
            99%{    color:transparent;  }
            100%{   color: #c14d7d;     }
        }
    </style>
	@include('layouts.analytics')
</head>

<body>


@php
    if(Auth::user()->isAdmin()){
        $url = 'admin';
    }elseif (Auth::user()->isKnitter()) {
        $url = 'knitter/dashboard';
    }elseif (Auth::user()->isDesigner()) {
        $url = 'designer/main/dashboard';
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
    <!-- [ Pre-loader ] end -->
    <div id="pcoded" class="pcoded" >
        <div class="pcoded-overlay-box"></div>
        <div  class="pcoded-container navbar-wrapper" >
            <!-- [ Header ] start -->
            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">
                    <div class="navbar-logo">

                        <a href="{{url($url)}}">
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
                            <!--<li><span class="subscription"><i class="fa fa-money"></i> Free
                            subscription</span></li>-->
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
                            <a href="{{url('designer/subscription')}}" class="waves-effect waves-light">
                               Subscription
                            </a>
                        </li> -->
                        <!--<li style="{{Request::is('designer/dashboard') ? 'display:block;' : 'display:none;'}}">
  <a target="_blank" onclick="saveSession()"  style="color: #0d665c" href="{{url('Knitfit-help')}}"><i class="fa fa-file-text"></i> Help</a>
</li>
                            <li>
                                <a style="color: #0d665c" href="{{url('feedback')}}"><i class="fa fa-comments" aria-hidden="true"></i> Feedback</a>
                            </li>
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
-->
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
                                    <div class="dropdown-toggle" data-toggle="dropdown" id="logoutMenu">
                                        <img src="{{ $pic }}" class="img-radius" alt="User-Profile-Image">
                                        <span>{{Auth::user()->first_name}}</span>
                                        <i class="feather icon-chevron-down"></i>
                                    </div>
                                    <ul class="show-notification profile-notification dropdown-menu" id="logoutMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">

                                       <!-- <li>
                                            <a href="{{url('connect/myprofile')}}">
                                                <i class="feather icon-user"></i> <span>My profile</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('connect/myprofile')}}">
                                                <i class="ti-user"></i> Update profile picture
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('change-password')}}">
                                                <i class="feather icon-settings"></i> Reset password
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{url('designer/subscription')}}">
                                                <i class="fa fa-usd"></i> Subscription
                                            </a>
                                        </li>-->

                                       <li>
                                           <a href="javascript:;" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
                                               <i class="fa fa-key"></i> Change password
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

            <div class="pcoded-main-container" >
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
                                @php
                                    $menus = App\Models\Menu::where('status','!=',0)->get();

                                    $num=1;
                                @endphp

                                <div class="row right-menubar">

                                    <div class="col-lg-6 col-6">
                                        <figure>
                                            <a href="{{url('designer/main/dashboard') }}"><img class="dashboard-icons "
                                                                                           src="{{ asset('resources/assets/files/assets/icon/custom-icon/home.png') }}"></a>
                                            <figcaption class="text-muted text-center">Dashboard</figcaption>
                                        </figure>
                                    </div>
                                <!--
<div class="col-lg-6 col-6">
  <figure>
    <a href="{{url('designer/setup-variables')}}"><img class="dashboard-icons " src="https://knitfitnew.test:4434/resources/assets/files/assets/icon/custom-icon/Projects.png"></a>
    <figcaption class="text-muted text-center">Variable setup</figcaption>
  </figure>
</div>
-->
                                    <div class="col-lg-6 col-6">
                                        <figure>
                                            <a href="{{ route('designer.main.my.patterns') }}"><img class="dashboard-icons " src="{{ asset
                                            ('resources/assets/files/assets/icon/custom-icon/pattern.png') }}"></a>
                                            <figcaption class="text-muted text-center">My Patterns</figcaption>
                                        </figure>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="change_password">
                @csrf
            <div class="modal-body">

                <div id="change-password"></div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Old password</label>
                        <input type="password" class="form-control" id="old_password" name="old_password"
                               placeholder="Enter old password">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">New password</label>
                        <div class="form-primary">
                            <input type="password" id="input-password" maxlength="16" name="new_password"
                                   class="form-control" placeholder="Enter new password">
                            <span toggle="#input-password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            <span class="form-bar"></span>
                            <!-- <label class="float-label text-muted">Password</label> -->
                            <span class="red password">@if($errors->first('password')) {{$errors->first('password')}} @endif</span>
                        </div>
                        <div class="" id="password-validation-box">
                            <div class="validate-password" method="post" action="#">
                                <fieldset class="fieldset-password">
                                    <div id="password-info" class="hide">
                                        <ul>
                                            <li id="length" class="invalid clearfix">
                                  <span class="icon-container">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                  </span>
                                                At least 8 characters
                                            </li>
                                            <li id="capital" class="invalid clearfix">
                                  <span class="icon-container">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                  </span>
                                                At least 1 uppercase letter
                                            </li>
                                            <li id="lowercase" class="invalid clearfix">
                                  <span class="icon-container">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                  </span>
                                                At least 1 lowercase letter
                                            </li>
                                            <li id="number-special" class="invalid clearfix">
                                  <span class="icon-container">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                  </span>
                                                <span title="&#33; &#64; &#35;  &#92; &#36; &#37; &#94; &#38; &#42; " class="special-characters tip">Special character</span>
                                            </li>
                                            <li id="number-special1" class="invalid clearfix">
                                  <span class="icon-container">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                  </span>
                                                At least 1 number or <span title="&#33; &#64; &#35;  &#92; &#36; &#37; &#94; &#38; &#42; " class="special-characters tip"></span>
                                            </li>
                                        </ul>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Conform new password</label>
                        <input type="password" class="form-control" id="confirm_new_password"
                               name="confirm_new_password" placeholder="Confirm new password">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Change password</button>
            </div>
            </form>
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



<style type="text/css">
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
        left: 600px !important;
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
    #password-info {
        margin:0 auto;
        overflow: hidden;
        text-shadow: 0 1px 0 #fff;
        padding: 6px;
        border: 1px solid #ddd;
        z-index: 9;
        /*top: 40px;*/
        width: 94%;
        position: absolute;
        box-shadow:1px 4px 12px 4px #bdbcbc;
        background-color: #ffffff;
    }
    #password-info ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    #password-info ul li {
        padding: 0px 4px 0px 46px;
        margin-bottom: 1px;
        background: #f4f4f4;
        font-size: 12px;
        transition: 250ms ease;
        position: relative;
    }
    #password-info ul li .icon-container {
        display: block;
        width: 40px;
        background: #ddd;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        text-align: center;
    }
    #password-info ul li .icon-container .fa {
        color: white;
        padding-top: 0px;
        position: relative;
        top: 0px;
    }
    #password-info ul li .tip {
        color: #5ca6d5;
        text-decoration: underline;
    }
    #password-info ul li.valid {
        color: #0d665c;
    }
    #password-info ul li.valid .icon-container {
        background-color: #0d665c;
    }
    #password-info ul li span.invalid {
        color: #ff642e;
    }
    .toggle-password{position: absolute;top: 10px;right: 20px;}
    .help-block {
        display: block;
        margin-top: 5px;
        *margin-bottom: 10px;
        color: #bc7c8f;
        font-weight:bold;
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

<link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
<script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

<!-- Bootstrap Notification js-->
<link rel="stylesheet" type="text/css" href="{{asset('resources/assets/assets/css/animate.css')}}">
<script type="text/javascript" src="{{asset('resources/assets/assets/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
<script src="{{ asset('resources/assets/titlechanger/jquery.titlealert.js') }}"></script>


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
    .showTemplate{
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        z-index: 1030;
        background-color: #fff;
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
        $('#exampleModal').on('show.bs.modal', function (e) {
            $("#password-validation-box").css('display','none');
        })
        $('.dropdown-toggle').dropdown();

        $('#change_password')
            .bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: '', //fa fa-check
                    invalid: '', //fa fa-exclamation
                    validating: 'fa fa-spinner fa-spin'
                },
                fields: {
                    new_password: {
                        validators: {
                            notEmpty: {
                                message: 'The new password is required.'
                            },
                            stringLength: {
                                min: 8,
                                max: 16,
                                message: '     '
                            },

                            regexp: {
                                regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/,
                                message: 'Invalid password format.'
                            }
                        }
                    },
                    confirm_new_password: {
                        validators: {
                            notEmpty: {
                                message: 'The confirm new password is required.'
                            },
                            identical: {
                                field: 'password',
                                message : 'The new password & confirm new password should be same.'
                            }
                        }
                    },
                }
            }).on('success.form.bv', function(e,data) {
                e.preventDefault();
                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');

            $.ajax({
                url : '{{url("designer/main/change-password")}}',
                type : 'POST',
                data : $form.serialize(),
                beforeSend : function(){
                    $(".loading").show();
                },
                success : function(res){
                    if(res.status == 'success'){
                        $("#change-password").addClass('alert alert-success').html("Password changed successfully.");
                        $("#change_password")[0].reset();
                        $('#exampleModal').modal('hide');
                    }else{
                        $("#change-password").addClass('alert alert-danger').html("Unable to change password.Try " +
                            "again after sometime.");
                    }
                },
                complete : function(){
                    $(".loading").hide();
                },
                error: function (jqXHR, exception) {
                    var err = eval("(" + jqXHR.responseText + ")");
                    if(err.errors.password){
                        $('.password').html(err.errors.password);
                    }

                    if(err.errors.confirm_password){
                        $('.confirm_password').html(err.errors.confirm_password);
                    }

                }
            });
            }).on('status.field.bv', function(e, data) {
                data.bv.disableSubmitButtons(false);
            });
        //getAllNotifications();

        /* $("#header-notification").click(function (){
             //alert($("#show-notification").hasClass('show'));
             if($("#show-notification").hasClass('show') == true){
                 $("#show-notification").removeClass('show');
             }else{
                 $("#show-notification").addClass('show');
             }
             //alert($("#show-notification"));
         });

         $("#logoutMenu").click(function (){
             //alert($("#show-notification").hasClass('show'));
             if($("#logoutMenu1").hasClass('show') == true){
                 $("#logoutMenu1").removeClass('show');
             }else{
                 $("#logoutMenu1").addClass('show');
             }
             //alert($("#show-notification"));
         });*/

        $('.closePreview').on('click', function() {
            var my_val = $('.pcoded').attr('vertical-placement');
            if (my_val == 'right') {
                var options = {
                    direction: 'right'
                };
            } else {
                var options = {
                    direction: 'left'
                };
            }
            $('.showTemplate').toggle('slide', options, 500);
            $('.showTemplate').css('display', 'block');
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
            delay: 3000,
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
<script>
    // Tooltips
    // -----------------------------------------

    // Only initialise tooltips if devices is non touch
    if (!('ontouchstart' in window)) {
        //$('.tip').tooltip();
    }

    //$('[data-toggle="tooltip"]').tooltip();

    // Password Validation
    // -----------------------------------------

    $(function passwordValidation() {

        var pwdInput = $('#input-password');
        var pwdInputText = $('#input-password-text'); // This is the input type="text" version for showing password
        var pwdValid = false;

        function validatePwdStrength() {

            var pwdValue = $(this).val(); // This works because when it's called it's called from the pwdInput, see end

            // Validate the length
            if (pwdValue.length > 7) {
                $('#length').removeClass('invalid').addClass('valid');
                pwdValid = true;
            } else {
                $('#length').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }

            // Validate capital letter
            if (pwdValue.match(/[A-Z]/)) {
                $('#capital').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#capital').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }

            // Validate lowercase letter
            if (pwdValue.match(/[a-z]/)) {
                $('#lowercase').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#lowercase').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }

            // special character
            if (pwdValue.match(/[\!@#$%\^&*\\]/)) {
                $('#number-special').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#number-special').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }

            // Validate number
            if (pwdValue.match(/[\d\\]/)) {
                $('#number-special1').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#number-special1').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }



        }

        function validatePwdValid(form, event) {
            if (pwdValid === true) {
                form.submit();
            } else {
                $('#alert-invalid-password').removeClass('hide');
                event.preventDefault();
            }
        }

        pwdInput.bind('change keyup input', validatePwdStrength); // Keyup is a bit unpredictable
        pwdInputText.bind('change keyup input', validatePwdStrength); // This is the input type="text" version for showing password
    }); // END passwordValidation()

    $("#input-password").focusin(function() {
        $("#password-validation-box").show();
    }).focusout(function () {
        $("#password-validation-box").hide();
    });
</script>
@yield('footerscript')


</div>
</body>

</html>
