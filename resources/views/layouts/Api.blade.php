<?php header('Set-Cookie: cross-site-cookie='.url('/').'; SameSite=None; Secure'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
<title>StitchersStudio | @yield('title')</title>
<!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 10]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<!-- Meta -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="Gradient Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
<meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
<meta name="author" content="Knitfit" />
<!-- Favicon icon -->
<!-- <script src=" asset('public/js/app.js') }}" defer></script> -->
<link rel="icon" href="{{ asset('resources/assets/files/assets/images/favicon.ico') }}" type="image/x-icon">
<!-- Google font-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
<!-- Required Fremwork -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/bower_components/bootstrap/css/bootstrap.min.css') }}">
<!-- waves.css -->
<link rel="stylesheet" href="{{ asset('resources/assets/files/assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
<!-- feather icon -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/feather/css/feather.css') }}">
<!-- themify-icons line icon -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/themify-icons/themify-icons.css') }}">
<!-- ico font -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/icofont/css/icofont.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/font-awesome/css/font-awesome.min.css') }}">
<!-- Style.css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/material-design/css/material-design-iconic-font.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/marketplace/css/Marketplace.css') }}">
<link rel="stylesheet" href="{{ asset('resources/assets/marketplace/src/images-grid-custom.css') }}">

 <link rel="stylesheet" type="text/css" href="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('resources/assets/assets/css/animate.css')}}">
 <script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery/js/jquery.min.js') }}"></script>
@include('layouts.analytics')
</head>
<body >
<!-- [ Pre-loader ] start -->
<div class="loader-bg">
<div class="loader-bar"></div>
</div>
<!-- [ Pre-loader ] end -->
<div id="pcoded" class="pcoded">
<div class="pcoded-overlay-box"></div>
<div class="pcoded-container navbar-wrapper">
    <nav class="navbar header-navbar pcoded-header">
        <div class="navbar-wrapper">
        <div class="navbar-logo">

        <a href="{{env('WORDPRESS_APP_URL')}}">
        <img class="img-fluid theme-logo" src="{{ asset('resources/assets/files/assets/images/logoNew.png') }}" alt="Theme-Logo" />
        </a>
        <a class="mobile-options waves-effect waves-light">
        <i class="feather icon-more-horizontal"></i>
        </a>
        </div>

        </div>

        </nav>
<!-- [ Header ] end -->

<!-- [ chat message ] end -->
<div class="pcoded-main-container">
<div class="pcoded-wrapper" id="dashboard">

<div class="pcoded-content">

<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
<!-- Page-body start -->

@yield('content')
</div>
<!-- Page-body end -->
</div>
</div>
</div>
</div>
<!-- Main-body end -->
</div>
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
$menus = App\Models\Menu::all();

$num=1;
@endphp

<div class="row right-menubar">
 @foreach($menus as $menu)
<?php $link = (string) $menu->link;

?>
  <div class="col-lg-6 col-6">
    <figure class="no-bg">
      <a href="{{url($link ? $link : 'javascript:;')}}" class="m-l-10">
        <img class="icon-img {{Request::is($link) ? 'active-menu' : ''}} @if($menu->status == 2) disabled-menu @endif" src="{{ asset('resources/assets/files/assets/icon/custom-icon/'.$menu->menu_icon) }}" />
      </a>
      <figcaption class="text-muted text-center {{Request::is($link) ? 'active-menu-text' : ''}}">{{$menu->name}}</figcaption>
    </figure>
  </div>

<?php $num++; ?>
@endforeach
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
</div>



</div>
</div>


</body>

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
.header-navbar .navbar-wrapper .navbar-container .badge{
    width:auto !important;
}
.brand-color{
  color: #0d665c !important;
}
</style>
<!-- Required Jquery -->

<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/popper.js/js/popper.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/bootstrap/js/bootstrap.min.js') }}"></script>


<!-- waves js -->
<script src="{{ asset('resources/assets/files/assets/pages/waves/js/waves.min.js') }}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
<!-- modernizr js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/modernizr/js/modernizr.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/modernizr/js/css-scrollbars.js') }}"></script>

<!-- Bootstrap Notification js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/bootstrap-notify.min.js') }}"></script>

<!-- Bootstrap Notification js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/bootstrap-notify.min.js') }}"></script>

<script src="{{ asset('resources/assets/files/assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/js/vertical/vertical-layout.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<!-- Custom js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js') }}"></script>
<script src="{{ asset('resources/assets/marketplace/src/images-grid-custom.js') }}"></script>

<script type="text/javascript" src="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.js')}}"></script>


@yield('footerscript')
</html>
