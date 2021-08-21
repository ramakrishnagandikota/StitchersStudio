<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('resources/assets/connect/assets/images/favicon.png') }}">
    <title>StitchersStudio - Dashboard</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('resources/assets/connect/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="{{ asset('resources/assets/connect/assets/css/style.css') }}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{ asset('resources/assets/connect/assets/css/colors/green.css') }}" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.css')}}">
<style type="text/css">
    .topbar .top-navbar .navbar-header{
        background: #6e9399;
    }
    .loading{
    position: fixed;
    z-index: 100000;
    background: #c7c7c794;
    width: 100%;
    height: 100%;
    display: none;
}
</style>
</head>

<body class="fix-header fix-sidebar card-no-border">
        <?php
          $userss = App\User::find(Auth::user()->id);
          $user = App\User::where('id',Auth::user()->id)->first();
          ?>

          <div class="loading">
       <center style="margin-top:250px;" > <img src="{{asset('resources/assets/preloader.gif')}}" style="height: 100px;"> </center>
    </div>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{url('/admin/dashboard')}}">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('resources/assets/connect/assets/images/logo.png') }}" alt="homepage" style="width:50px" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{ asset('resources/assets/connect/assets/images/logo.png') }}" alt="homepage" style="width:45px" class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         </span> </a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== hidden-sm-down hidden-sm-down-->
                        <li class="nav-item  search-box hidden-sm-down"> <a class="nav-link hidden-sm-down  text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                        </li>
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->

                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">

                        <li class="nav-item">
                            <a class="nav-link text-muted text-muted waves-effect waves-dark" href="{{url('admin')}}" data-toggle="tooltip" title="Admin Dashboard" > <i class="mdi mdi-home"></i>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link text-muted text-muted waves-effect waves-dark" href="{{url('connect')}}" data-toggle="tooltip" title="Connect" > <i class="mdi mdi-access-point-network"></i>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-muted text-muted waves-effect waves-dark" href="{{url('shop-designs')}}" data-toggle="tooltip"  title="Shop Designs" > <i class="mdi mdi-cart"></i>
                            </a>
                        </li>


                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                                @if(count(Auth::user()->unreadNotifications) > 0)
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                                @endif
                            </a>
                            <div class="dropdown-menu mailbox dropdown-menu-right scale-up" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">You have {{count(Auth::user()->unreadNotifications)}} new messages</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/3.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ asset(Auth::user()->picture) }}" alt="user" class="profile-pic" />
                        &nbsp;<span class="hidden-sm-down">  {{ ucwords(Auth::user()->first_name) }} </span></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="{{ asset(Auth::user()->picture) }}" alt="user"></div>
                                            <div class="u-text">
                                                <h4>{{ ucwords(Auth::user()->first_name) }}</h4>
                                                <!-- <p class="text-muted">{{ Auth::user()->email }}</p> --><a href="{{url('connect/profile')}}" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{url('connect/profile')}}"><i class="ti-user"></i> My Profile</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-settings"></i> Change Password</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="{{url('logout')}}"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->

                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile" style="background: url({{ asset('resources/assets/connect/assets/images/background/user-info.jpg') }}) no-repeat;">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="{{ asset(Auth::user()->picture) }}" alt="user" /> </div>
                    <!-- User profile text-->
                    <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown text-center" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">{{ucwords(Auth::user()->first_name)}} (Admin)</a>
                        <div class="dropdown-menu animated flipInY"> <a href="#" class="dropdown-item"><i class="ti-user"></i> My Profile</a> <a href="#" class="dropdown-item"><i class="ti-wallet"></i> My Balance</a> <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                            <div class="dropdown-divider"></div> <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                            <div class="dropdown-divider"></div> <a href="login.html" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a> </div>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">Menu</li>
                        <li> <a class="waves-effect waves-dark" href="{{url('admin')}}"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a></li>

						<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="fa fa-edit"></i><span class="hide-menu">Customers</span></a>
                           <ul aria-expanded="false" class="collapse">
                               <li><a href="{{url('admin/cususers-view')}}">Users</a></li>
                               <li><a href="{{url('admin/manage/users-role')}}">Assign Roles</a></li>
                           </ul>
                       </li>

                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-arrange-send-backward"></i><span class="hide-menu">My Store</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li> <a class="has-arrow" href="#" aria-expanded="false">My Products</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="{{url('admin/browse-patterns')}}">Browse Patterns</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <!--<li> <a class="waves-effect waves-dark" href="{{url('admin/password-generator')}}"><i class="mdi mdi-key"></i><span class="hide-menu">Password Generator </span></a></li>-->
						<li> <a class="waves-effect waves-dark" href="{{url('admin/broadcast')}}"><i class="mdi
                        mdi-network"></i><span class="hide-menu">Broadcast </span></a></li>
						
						<li> <a class="waves-effect waves-dark" href="{{url('admin/feedback')}}"><i class="mdi
                        mdi-message"></i><span class="hide-menu">Feedback </span></a></li>
						
						<li> <a class="waves-effect waves-dark" href="{{url('admin/invite-designers')}}"><i class="mdi
                        mdi-account-plus"></i><span class="hide-menu">Invite designers </span></a></li>
						
						<li class="">
                                <a href="{{url('admin/support')}}" class="waves-effect waves-dark" >
                                <span class="pcoded-micon">
                                    <i class="fa fa-envelope"></i>
                                </span>
                                    <span class="pcoded-mtext">Support Ticket</span>
                                </a>
                            </li>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <div class="sidebar-footer">
                <!-- item--><a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
                <!-- item--><a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
                <!-- item--><a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a> </div>
            <!-- End Bottom points-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles" >
                    @yield('breadcrum')

                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">

                    <!-- all div's start here -->

                    @yield('section1')
                    <div class="clearfix"></div>
                    @yield('section2')

                </div>
                <!-- Row -->


                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © {{date('Y')}} Knit fit Couture</footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
<script src="{{ asset('resources/assets/connect/assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('resources/assets/connect/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('resources/assets/connect/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('resources/assets/connect/assets/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('resources/assets/connect/assets/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('resources/assets/connect/assets/js/sidebarmenu.js') }}"></script>
    <!--stickey kit -->
    <script src="{{ asset('resources/assets/connect/assets/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
    <script src="{{ asset('resources/assets/connect/assets/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <script type="text/javascript" src="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.js')}}"></script>

    <!--Custom JavaScript -->
    <script src="{{ asset('resources/assets/connect/assets/js/custom.min.js') }}"></script>

        <link rel="stylesheet" type="text/css" href="{{asset('resources/assets/assets/css/animate.css')}}">
        <script type="text/javascript" src="{{asset('resources/assets/assets/bootstrap-notify/bootstrap-notify.min.js')}}"></script>

    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
<style type="text/css">
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


<script>
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
        @yield('footerscript')
</body>

</html>
