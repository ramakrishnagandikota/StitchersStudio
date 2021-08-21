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
<meta name="author" content="Phoenixcoded" />
<!-- Favicon icon -->

<link rel="icon" href="{{ asset('resources/assets/files/assets/images/favicon.ico')}}" type="image/x-icon">
<!-- Google font-->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
<!-- Required Fremwork -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/bower_components/bootstrap/css/bootstrap.min.css')}}">
<!-- waves.css -->
<link rel="stylesheet" href="{{ asset('resources/assets/files/assets/pages/waves/css/waves.min.css') }}" type="text/css" media="all">
<!-- feather icon -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/feather/css/feather.css') }}">
<!-- themify-icons line icon -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/themify-icons/themify-icons.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/typicons-icons/css/typicons.min.css') }}">
<!-- ico font -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/icofont/css/icofont.css') }}">
<!-- Font Awesome -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/font-awesome/css/font-awesome.min.css') }}">
<!-- typicon icon -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/icon/typicons-icons/css/typicons.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/slick.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/slick-theme.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/animate.css') }}">
<!-- Style.css -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/e-commerce.css') }}">
<!-- Theme css -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/color17.css') }}" media="screen" id="color">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/left-menu.css') }}">
@include('layouts.analytics')
</head>

<body>
    @auth
@php
if(Auth::user()->isAdmin()){
    $url = 'admin';
}elseif (Auth::user()->isKnitter()) {
    $url = 'knitter/dashboard';
}elseif (Auth::user()->isDesigner()) {
    $url = 'designer/dashboard';
}else{
    $url = '/';
}
@endphp
@endauth
<!-- [ Pre-loader ] start -->
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

<a href="{{env('WORDPRESS_APP_URL')}}">
<img class="img-fluid theme-logo" src="{{ asset('resources/assets/files/assets/images/logoNew.png') }}" alt="Theme-Logo" />
</a>
<a class="mobile-options waves-effect waves-light">
<i class="feather icon-more-horizontal"></i>
</a>
</div>
<div class="navbar-container container-fluid">
<ul class="nav-left">
<!-- <li class="text-muted f-14 welcome-knitfit">Welcome to our store Knitfit</li>
<li class="text-muted f-14 call-us"><i class="fa fa-phone" aria-hidden="true"></i> Call Us: 123-456-7890</li> -->
</ul>
<ul class="nav-right">
<li class="header-notification toggle-menu">
<div class="dropdown-primary dropdown">
<div class="displayChatbox dropdown-toggle" data-toggle="dropdown">
<i class="fa fa-navicon"></i>
</div>
</div>
</li>
<!-- <li><a href="../../Knitter/Nini/Dashboard.html">Home</a></li> 
<li class="active"><a href="{{url('shop-patterns')}}">Shop patterns</a></li>-->
@if(Auth::check())
<li class="myaccount"><a href="{{url('my-account')}}">Account</a></li>
@endif

<li class="header-notification p-l-0 p-r-5">
<div class="dropdown-primary dropdown" id="cart-div">


</div>
</li>
@auth
<li>
<a href="{{url('feedback')}}" style="text-decoration:none;"><i class="fa fa-comments"></i> Send us Feedback
</a>
</li>
@endauth
<!-- 
<li>
  <a target="_blank"  style="color: #0d665c" href="https://stitchersstudio.com/website/support/help-articles/"><i class="fa fa-file-text"></i> Help</a>
</li>
-->
@auth
@php
if(Auth::user()->picture){
  $pic = Auth::user()->picture;
}else{
    $a = Auth::user()->first_name;
    $firstChar = mb_substr($a, 0, 1, "UTF-8");
  $pic = 'https://via.placeholder.com/150/cccccc/bc7c8f?text='.$firstChar;
}
@endphp
@endauth
<!-- <li class="mobile-wishlist p-0 m-l-10"><a href="my-whislist.html"><i class="fa fa-heart" aria-hidden="true"></i></a></li> -->
@if(Auth::check())
<li class="user-profile header-notification">
<div class="dropdown-primary dropdown">
<div class="dropdown-toggle" data-toggle="dropdown">
<img src="{{ $pic }}" class="img-radius" alt="User-Profile-Image">
<span>{{ucfirst(Auth::user()->first_name)}}</span>
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
@else
    <li>
    <a href="{{url('login')}}">Login</a>
    </li>

    <li>
    <a href="{{url('register')}}">Register</a>
    </li>
@endif
</ul>
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
<div class="page-body">
<div class="row">
<div class="col-lg-12">
<!-- section start -->

@yield('content')
<!-- section End -->


<!-- footer start -->
<footer class="footer-light">
<div class="light-layout">
    <div class="container">
        <section class="small-section border-section border-top-0">
            <div class="row">
                <div class="col-lg-6">
                    <div class="subscribe">
                        <div>
                            <h4>Want expert tips on getting that perfect fit?</h4>
                            <p>Sign up to receive for our helpful, inspiring, and delightfully un-spammy newsletters!</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <form class="form-inline subscribe-form auth-form needs-validation" >
                        <div class="form-group mx-sm-3">
                            <input type="text" class="form-control" id="mce-EMAIL" placeholder="Enter your email" required="required">
                            <span class="red mce-EMAIL"></span>
                        </div>

                        <button type="button" class="btn theme-outline-btn waves-effect waves-light " id="mc-submit">Subscribe</button>
                    </form>
                </div>
            </div>
        </section>
    </div>
</div>
<section class="section-b-space light-layout">

</section>
<div class="sub-footer">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-md-6 col-sm-12">
                <div class="footer-end">
                    <p><i class="fa fa-copyright" aria-hidden="true"></i> {{date('Y')}} <a href="{{env('WORDPRESS_APP_URL')}}">StitchersStudio</a></p>
                </div>
            </div>
            <div class="col-xl-6 col-md-6 col-sm-12">

            </div>
        </div>
    </div>
</div>
</footer>
</div>
</div>
</div>
</div>
<!-- Page-body end -->
</div>
</div>
</div>
</div>
<!-- Main-body end -->

</div>
</div>

@if(Auth::check())
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
@endif
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
.loader {
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
left: 0px !important;
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
    z-index: 1;
    padding: 0px;
    top: 0px;

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
.red{
color: #bc7c8f;
font-weight:bold;
font-size: 12px;
}
.progress-bar-success{
	background-color: #0d665b !important;
}

.progress-bar-danger{
	background-color: #bc7c8f !important;
}
.alert-success {
    background-color: #fff !important;
    border-color: #0d665c !important;
    color: #0d665c !important;
}
.alert-danger {
    background-color: #fff !important;
    border-color: #bc7c8f !important;
    color: #bc7c8f !important;
}
.theme-logo{
	width: 120px !important;
}
.active a{
    border-bottom: 0px !important;
}
.addBlur{
        filter:blur(5px) !important;
    }
</style>
<!-- latest jquery-->
 <script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery/js/jquery.min.js') }}"></script>

<!-- menu js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/menu.js') }}"></script>

<!-- lazyload js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/lazysizes.min.js') }}"></script>

<!-- popper js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/popper.min.js') }}"></script>

<!-- slick js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/slick.js') }}"></script>

<!-- Bootstrap js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/bootstrap.js') }}"></script>

<!-- Bootstrap Notification js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/bootstrap-notify.min.js') }}"></script>

<!-- Theme js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/script.js') }}"></script>


<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-ui/js/jquery-ui.min.js') }}"></script>

<!-- menu js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/menu.js') }}"></script>

<!-- lazyload js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/lazysizes.min.js') }}"></script>

<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
<!-- modernizr js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/modernizr/js/modernizr.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/modernizr/js/css-scrollbars.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/waves/js/waves.min.js') }}"></script>
<!-- Todo js -->

<script src="{{ asset('resources/assets/files/assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/js/vertical/vertical-layout.min.js') }}"></script>

<!-- Custom js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js') }}"></script>



<script type="text/javascript">


$(function(){
            $(document).on('click','.invitationButton',function (){
            $("#view-details-knit-along").addClass('addBlur');
            $(".loading").show();
            var groupId = $(this).attr('data-groupId');
            var groupRequestId = $(this).attr('data-groupRequestId');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post('{{ url('designer/getGroupInformation') }}',{groupId:btoa(groupId),groupRequestId:groupRequestId},function (res){
				console.log(res);
               if(res.status == 'success'){
                   $("#Atitle").html(res.title);
                   $("#Agroup_name").html(res.group_name);
                   $("#Astart_date").html('Start date : '+res.start_date);
                   $("#Amembers").html('No of members : '+res.members);
                   $("#Adescription").html(res.message);
                   $("#Aexpertise_level").html('<i class="icofont icofont-safety"></i> '+res.expertise_level);
                   $("#view-details-knit-along").modal('show');
                   $("#AgroupRequestId").val(groupRequestId);
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
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to ignore this request ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value == true) {
                    $(".loading").show();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.post('{{ url("designer/ignoreGroupInvitationequest") }}',{id:id},function (res){
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post('{{ url('designer/acceptGroupInvitationequest') }}',{groupId:btoa(groupId),groupRequestId:groupRequestId},function (res){
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
        getCart();

        var uel = '{{url()->current()}}';


        $(document).on('click','.remove-item',function(){
        if(confirm('Are you sure want to remove item from cart ?')){
            var id = $(this).attr('data-id');
        $.get('{{url("remove-item")}}/'+id,function(res){
    getCart();
    if(uel == '{{url("/checkout")}}'){
        window.location.assign('{{url("shop-patterns")}}')
    }
    addProductCartOrWishlist('fa-check','Success','Product Successfully removed from cart','success');
        });
        }
    });


$(document).on('click','#mc-submit',function(e){
            e.preventDefault();
            var email = $("#mce-EMAIL").val();
            var er = [];
            var cnt = 0;
            if(email == ""){
                $(".mce-EMAIL").html('Email field is required.');
                er+=cnt+1;
            }else{
                $(".mce-EMAIL").html('');
            }
			
			if(er != ""){
                return false;
            }

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    url : '{{url("subscribe-newsletters")}}',
    type : 'POST',
    data : 'email='+email,
    beforeSend : function(){
        $(".loader-bg").show();
    },
    success : function(res){
        $("#mce-EMAIL").val('');
        addProductCartOrWishlist('fa-check','success','You have subscribed to our newsletters.','success');
        setTimeout(function(){ location.reload(); },2000);
        //addProductCartOrWishlist('fa-times','Oops!','Unable to subscribe to our newsletters, Try again after some time.','danger');
    },
    complete : function(){
        $(".loader-bg").hide();
    },
    error: function (jqXHR, textStatus, errorThrown) {
  var err = eval("(" + jqXHR.responseText + ")");

        if(err.message == 'Unauthenticated.'){
            addProductCartOrWishlist('fa-times','Oops!','Please login to subscribe for newsletters','danger');
        }

        if(err.errors){
            addProductCartOrWishlist('fa-times','Oops!',err.errors.email,'danger');
        }
  }
});

        });

    });
    function getCart(){
    $("#cart-div").load('{{ url("load-cart") }}');
    }


var countint = setInterval(function(){
 check_session();
 
  if(is_session_exist == 1)
  {
   clearInterval(countint);
  }
}, 1800000);

</script>
@yield('footerscript')
</body>

</html>
