@extends('layouts.knitterapp')
@section('title','Subscriptions')
@section('content')
<div class="pcoded-wrapper" id="dashboard">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">
            <div class="main-body">
                <div class="page-wrapper">
                    <!-- Page-body start -->
                    <div class="page-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <h5 class="theme-heading m-b-20">Subscribe now</h5>
                            </div>
                        </div>
                        <!-- <h5 class="m-b-20">Knitter's Subscription</h5> -->
                        <div class="card p-20">
                        <div class="row">

                        	<div class="col-sm-4 col-lg-4 offset-lg-2 offset-md-2">
                                <div class="card text-center">
                                    <div class="card-header">
                                        <h2>Designer's Basic</h2>
                                        <span>$0.00/mo</span><br>
                                        <span style="font-size: 12px;visibility:hidden;">or 24.99/yr
                                            (30% off)</span>
                                    </div>
                                    <div class="card-body">
                                        <ul class="sub-table">
                                        <li class="f-w-700">
                                            Includes Basic Knitter features:
                                        </li>
                                            <li><i
                                                class="fa fa-check-circle right-align"></i> Project Library :
                                            </li>

                                            <li class="sub-points">1 free KnitFit custom pattern</li>
                                            <li class="sub-points">1 Pattern pdf for mobile optimized use</li>
                                            <li class="sub-points">Manage up to 5 projects</li>
                                            <li>
                                                <i
                                                class="fa fa-check-circle right-align"></i>Measurements: Store 1 measurement profile
                                            </li>

                                            <li>
                                                <i
                                                class="fa fa-check-circle right-align"></i> Connect: Share photos, projects, and updates
                                            </li>
                                            <li class="f-w-700">
                                                <i class="fa fa-plus-square"></i>Basic Designer features:<i class="fa fa-check-circle right-align"></i>
                                            </li>
                                            <li>
                                                <i
                                                class="fa fa-check-circle right-align"></i> Upload 10 traditional patterns-Curated
                                            </li>
                                            <li>
                                                <i
                                                class="fa fa-check-circle right-align"></i> Upload 10 traditional patterns-Curated
                                            </li>
                                            <li>
                                                <i
                                                class="fa fa-check-circle right-align"></i> Assistance with translation for 1 KnitFit™ Custom Pattern
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer text-muted">
                                        
                                    <!--<button
                                        class="btn btn-primary theme-btn btn-block">Try
                                        Free</button>-->
                                    </div>
                                  </div>
                            </div>
                                   
                            <div class="col-sm-4 col-lg-4">
                                <div class="card text-center">
                                    <div class="card-header">
                                        <h2>Designer's Premium</h2>
                                    <span>$2.99/mo</span><br>
                                    <span style="font-size: 12px;">or 24.99/yr
                                        (30% off)</span>
                                    </div>
                                    <div class="card-body">
                                        <ul class="sub-table">
                                        <li class="f-w-700">
                                            Includes Premium Knitter features:
                                        </li>
                                            <li> <i
                                                class="fa fa-check-circle right-align"></i> Project Library :
                                            </li>

                                            <li class="sub-points">Unlimited pattern pdf's for mobile use</li>
                                            <li class="sub-points">Unlimited KnitFit custom patterns</li>
                                            <li class="sub-points">Unlimited projects</li>
                                            <li>
                                                <i
                                                class="fa fa-check-circle right-align"></i>Measurements: Unlimited measurement profiles
                                            </li>
                                            <li>
                                                <i
                                                class="fa fa-check-circle right-align"></i>Generate unlimited KnitFit custom sized patterns
                                            </li><li>
                                                <i
                                                class="fa fa-check-circle right-align"></i>Connect: Share photos, projects, and updates
                                            </li>

                                            <li class="f-w-700">
                                                <i class="fa fa-plus-square"></i>Premium Designer features:<i class="fa fa-check-circle right-align"></i>
                                            </li>

                                            <li> <i
                                                class="fa fa-check-circle right-align"></i> Store Management tools :
                                            </li>

                                            <li class="sub-points">Unlimited traditional patterns-Curated</li>
                                            <li class="sub-points">Unlimited KnitFit™ Custom Patterns</li>
                                            <li class="sub-points">Support for your patterns including access to trained tech editors</li>
                                            <li class="sub-points">Track sales and revenue</li>
                                            
                                            <li class="text-muted"> <i
                                                class="fa fa-check-circle right-align"></i> Groups : (Coming soon)
                                            </li>

                                            <li class="sub-points text-muted">Create groups for designs, test knits and knit-alongs</li>
                                            <li class="sub-points text-muted">Share progress, photos, FAQ's with group members</li>
                                            <li class="sub-points text-muted">Broadcast messages to individual groups, all groups and all followers</li>
                                            
                                            <li class="text-muted"> <i
                                                class="fa fa-check-circle right-align"></i> Promotion : (Coming soon)
                                            </li>

                                            <li class="sub-points text-muted">Use promotion codes to boost pattern sales</li>
                                            <li class="sub-points text-muted">Promote engagement for new designs</li>
                                        </ul>
                                    </div>
                                    <div class="card-footer text-muted">
                                       
                                    <!--<button
                                        class="btn btn-primary theme-btn btn-block">Get
                                        Started</button>-->
                                    </div>
                                  </div>
                            </div>
                                                        
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


   

@endsection
@section('footerscript')
  <!-- Style.css -->
  <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/Marketplace/css/Marketplace.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/style.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
<style>
.addresss{position: absolute;top: 0;right: 0;float: right;}
    select,textarea{border: 1px solid #ccc;
    border-radius: 3px;
    width: 97%;
    padding: 3px;}
    input{border: 1px solid #ccc;
    border-radius: 3px;padding: 2px;}
    .Addnew{display: none;}
    .checkbox-primary input[type="checkbox"]:checked+label::before {
    background-color: #0d665c;
}
.checkbox-primary input[type="checkbox"]:checked+label::before {
    background-color: #0d665c;
    border-color: #0d665c
}
    .button-3:hover:hover {
    background-color: #cc8b86 ;
    border: 1px solid #cc8b86 ;
     padding: 3px 3px;
    color: #fff !important;
}
#mainNav{background-color: white;background-color: white;
    box-shadow: 2px 2px 2px #e6e4e4;}
.theme-logo{width: 110px;}
.container-fluid{padding-right: 60px;padding-left: 60px;}
body{background-color: #faf9f8;}
.centered-block{float: none;display: block;margin: 0 auto;}

.theme-btn{padding: 10px;}
.nav-tabs .slide {
    background: #0d665c;
}
.md-tabs .nav-item a {
    padding: 4px 0;
    font-size: 16px;
}
.table td, .table th,.table tr {
    border: 1px solid #b5b3b3;
}
.table td, .table th{padding: .80rem .40rem;}
.table-styling .table-info thead, .table-styling.table-info thead{border-bottom: 1px solid #b5b3b3;}
/* Track */
::-webkit-scrollbar-track {
  background: white;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #0d665c;
  border-radius: 6px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #0d665c;
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
.sub-points{font-size:13px;list-style: disc;margin-left:40px!important}
        .address {
            position: absolute;
            top: 0;
            right: 0;
            float: right;
        }

        select,
        textarea {
            border: 1px solid #ccc;
            border-radius: 3px;
            width: 97%;
            padding: 3px;
        }

        input {
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 2px;
        }

        #Addnew {
            display: none;
        }

        .checkbox-primary input[type="checkbox"]:checked+label::before {
            background-color: #0d665c;
        }

        .checkbox-primary input[type="checkbox"]:checked+label::before {
            background-color: #0d665c;
            border-color: #0d665c
        }

        .button-3:hover:hover {
            background-color: #cc8b86;
            border: 1px solid #cc8b86;
            padding: 3px 3px;
            color: #fff !important;
        }

        #mainNav {
            background-color: white;
            background-color: white;
            box-shadow: 2px 2px 2px #e6e4e4;
        }

        .theme-logo {
            width: 110px;
        }

        .container-fluid {
            padding-right: 15px;
            padding-left: 15px;
        }

        body {
            background-color: #faf9f8;
        }

        .centered-block {
            float: none;
            display: block;
            margin: 0 auto;
        }

        .theme-btn {
            padding: 10px;
            text-transform: uppercase;
            
        }

        .nav-tabs .slide {
            background: #0d665c;
        }

        .md-tabs .nav-item a {
            padding: 4px 0;
            font-size: 16px;
        }

        .Free,
        .Basic,
        .Premium {
            border-left: 0px solid #e4e4e4 !important;
        }

        #subscription-table {
            background-color: transparent;
        }

        .table-styling .table-info thead,
        .table-styling.table-info thead {
            border: none;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: white;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #0d665c;
            border-radius: 6px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #0d665c;
        }

        .theme-btn,
        .theme-outline-btn {
            padding: 5px;
            text-transform: uppercase;
        }

        .table th {
            padding: 10px 0px 10px 0px;
        }

        /* .pricing-section .table-left,
        .pricing-section .table-right {
            box-shadow: 0 5px 10px rgb(0 0 0 / 10%);
            border: 1px solid #EFEFEF;
        } */
        h2{font-size: 24px;color: black;}
        .pricing-details span{font-size: 34px;}
        .right-align{float: right;right: 0;
    font-size: 18px;
    color: #03655B;margin-right: 15px;margin-top: 5px;}
    .sub-table li{padding-bottom: 10px;text-align: left;margin-left: 10px;}
    .sub-table{margin-top:30px;margin-bottom: 3px;}
    .pricing-details{padding: 20px;}
    .muted-text{color:#cccccc!important}
    .logo{width: 58px;margin-right: 5px;margin-top: -2px;}
    .table-right,.table-left{background:linear-gradient(180deg, #0d665c 18%, #FFFFFF 12%);}
    .fa-plus-square{color: #dd8ca0;font-size: 16px;margin-right: 10px;}
    h1, h2, h3, h4, h6, span, table td{color: #FFFFFF;}
    .card-header{background-color: #0d665c!important}
    .card-body{height: 900px;}
    .card .card-header span{font-size: 28px;}
</style>
<script type="text/javascript" src="{{asset('node_modules/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>


@endsection
