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
    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('resources/assets/files/assets/images/favicon.ico') }}" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <!-- Required Fremwork -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/bower_components/bootstrap/css/bootstrap.min.css') }}">
    <!-- waves.css -->
    <link rel="stylesheet" href="{{ asset('resources/assets/files/assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
    <!-- feather icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/feather/css/feather.css') }}"><!-- themify-icons line icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/themify-icons/themify-icons.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/font-awesome/css/font-awesome.min.css') }}">
    <!-- Style.css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/icofont/css/icofont.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/style-admin.css') }}">
    <!-- added recently -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css')}}">
    <!-- added recently -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/widget.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.css')}}">

    <script>
        window.auth = {!! Auth::user() !!}
    </script>
    <style>
        .table td{padding: .45rem 0.75rem!important;border-top: 0px solid grey!important;}
        #mobile-coll {
            float: right;
            position: relative;
            margin-top: 0px;
        }
        .pcoded-navbar1{
            position: fixed !important;
        }
        .active-nav{
            width: 250px !important;
            background-color: #fff !important;
        }
        .pnav1{
            opacity: 1 !important;
            visibility: unset !important;
        }
        .pcoded[theme-layout="vertical"] .pcoded-navbar1 .pcoded-item>li:hover>a:before{
            content: unset !important;
        }
        .pcoded[theme-layout="vertical"] .pcoded-navbar1 .pcoded-item>li.active>a:before{
            content: unset !important;
        }
        .pcoded[theme-layout="vertical"][vertical-nav-type="collapsed"] .pcoded-navbar1 .pcoded-item>li.pcoded-trigger{
            width: 250px;
            background: #f5f5f5;
            -webkit-box-shadow: 0 2px 10px -1px rgba(69, 90, 100, 0.3);
            box-shadow: 0 2px 10px -1px rgba(69, 90, 100, 0.3);
        }
        .pcoded[theme-layout="vertical"][vertical-nav-type="collapsed"] .pcoded-navbar1 .pcoded-item>.pcoded-hasmenu.pcoded-trigger>.pcoded-submenu{
            width: 200px;
            background: #f5f5f5;
            -webkit-box-shadow: 0 2px 10px -1px rgba(69, 90, 100, 0.3);
            box-shadow: 0 2px 10px -1px rgba(69, 90, 100, 0.3);
        }
        .pcoded[theme-layout="vertical"][vertical-nav-type="collapsed"] .pcoded-navbar1 .pcoded-item>.pcoded-hasmenu.pcoded-trigger>.pcoded-submenu{
            left: 0px;
            position: relative;
        }
        .pcoded[theme-layout="vertical"][vertical-nav-type="collapsed"] .pcoded-navbar1 .pcoded-item>.pcoded-hasmenu.pcoded-trigger>.pcoded-submenu{
            box-shadow: none;
        }
        .pcoded[theme-layout="vertical"][vertical-nav-type="collapsed"] .pcoded-navbar1 .pcoded-item>li.pcoded-trigger>a .pcoded-mtext{
            padding-left: 0px;
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
    </style>
</head>

<body>
<!-- [ Pre-loader ] start -->
<div class="loading">
    <div class="loaders"></div>
</div>

<div class="loader-bg">
    <div class="loader-bar"></div>
</div>
<!-- [ Pre-loader ] end -->
<div id="pcoded" class="pcoded">
    <div class="pcoded-overlay-box"></div>
    <div class="pcoded-container navbar-wrapper">
        <!-- [ Header ] start -->
        <nav class="navbar header-navbar pcoded-header">
            <div class="navbar-wrapper">
                <div class="navbar-logo">
                    <a class="mobile-menu waves-effect waves-light" id="mobile-coll" style="left: -20px;" href="#!">
                        <i class="fa fa-navicon text-muted" style="border: 0px;"></i>
                    </a>
                    <a href="{{url('admin')}}">
                        <img class="img-fluid theme-logo" src="{{ asset('resources/assets/files/assets/images/logoNew.png') }}" alt="Theme-Logo" />
                    </a>
                    <a class="mobile-options waves-effect waves-light">
                        <i class="feather icon-more-horizontal"></i>
                    </a>
                </div>
                <div class="navbar-container container-fluid">
                    <ul class="nav-right">
                        <li class="header-notification id="">
                        <div class="dropdown-primary dropdown ">
                            <div class="dropdown-toggle " id="header-notification" data-toggle="dropdown" onclick="markAsRead({{count(Auth::user()->unreadNotifications)}});">
                                <i class="feather icon-bell"></i>
                                @if(count(Auth::user()->unreadNotifications) > 0)
                                    <span class="badge bg-c-red" id="notificationsCount">{{count(Auth::user()->unreadNotifications)}}</span>
                                @endif
                            </div>
                            <ul class="show-notification notification-view dropdown-menu" id="show-notification" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" style="height: 400px;overflow-y: scroll;">
                            
                            </ul>
                        </div>
                        </li>

                        <li class="user-profile header-notification">
                            <div class="dropdown-primary dropdown">
                                <div class="dropdown-toggle" data-toggle="dropdown" id="logoutMenu">
                                    <img src="{{Avatar::create(Auth::user()->first_name)->toBase64()}}" class="img-radius" alt="">
                                    <span>{{Auth::user()->username}}</span>
                                    <i class="feather icon-chevron-down"></i>
                                </div>
                                <ul class="show-notification profile-notification dropdown-menu" id="logoutMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
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
        <!--<button type="button" class="btn theme-btn btn-sm displayChatbox" id="showPreview">Preview</button> -->
        <div class="pcoded-main-container">
            <div class="pcoded-wrapper">
                <!-- [ navigation menu ] start -->
                <nav class="pcoded-navbar1">
                    <div class="pcoded-inner-navbar">
                        <div class="pcoded-navigation-label"></div>
                        <ul class="pcoded-item pcoded-left-item" >
                            <li class="{{Request::is('admin/dashboard') ? 'active' : ''}}" >
                                <a href="{{url('admin/dashboard')}}" class="waves-effect waves-dark " >
                                    <span class="pcoded-micon"><i class="feather icon-home"></i></span>
                                    <span class="pcoded-mtext">Dashboard</span>
                                </a>
                            </li>
                            
                            <li class="">
                                <a href="{{url('admin/feedback')}}" class="waves-effect waves-dark" >
                                <span class="pcoded-micon">
                                    <i class="feather icon-shield"></i>
                                </span>
                                    <span class="pcoded-mtext">Feedback</span>
                                </a>
                            </li>

                            <li class="">
                                <a href="{{url('admin/support')}}" class="waves-effect waves-dark" >
                                <span class="pcoded-micon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                    <span class="pcoded-mtext">Support Ticket</span>
                                </a>
                            </li>


                    </div>
                </nav>
                <!-- [ navigation menu ] end -->
                <div class="pcoded-content m-t-50" >
                    <!-- [ breadcrumb ] end -->
                    <div class="pcoded-inner-content" >
                        <div class="main-body">
                            <div class="page-wrapper">

                                @yield('section')

                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ style Customizer ] start -->

                <!-- [ style Customizer ] end -->
            </div>
        </div>
    </div>
</div>


<style>
    .show{
        display:block !important;
    }
    .hide{
        display: none;
    }
    .theme-btn{
        background: #0d665c !important;
    }
</style>

<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery/js/jquery.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/popper.js/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>

<!-- waves js -->
<script src="{{ asset('resources/assets/files/assets/pages/waves/js/waves.min.js') }}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
<!-- Custom js -->
<script src="{{ asset('resources/assets/files/assets/js/pcoded.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/js/vertical/vertical-layout.js') }}"></script>

<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js') }}"></script>

<link rel="stylesheet" type="text/css" href="{{asset('resources/assets/assets/css/animate.css')}}">
<script type="text/javascript" src="{{asset('resources/assets/assets/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script type="text/javascript" src="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script src="{{ asset('resources/assets/titlechanger/jquery.titlealert.js') }}"></script>



<script>

    var user_id = '{{ Auth::user()->id }}';
    /* window.Echo.private('newFormula-'+user_id+'4')
     .listen('.newFormulaRequestMessage', (e) => {
         console.log(e)
     });*/
    /* window.Echo.private('App.User.'+user_id)
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
         }); */
</script>

<script type="text/javascript">
    $(function(){
        $('.dropdown-toggle').dropdown();
        getAllNotifications();
        $("#mobile-coll").click(function(){
            $(".pcoded-navbar1").toggleClass('active-nav');
            $(".pcoded-navbar1 li span.pcoded-mtext").toggleClass('pnav1');
        });


        /*$("#header-notification").click(function (){
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
        });
    */


    });

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
                $("#notificationsCount").remove();
            }
        }else{
            getAllNotifications();
        }
    }
</script>
@yield('footerscript')
</body>

</html>
