@extends('layouts.adminnew')
@section('title','Admin Dashboard')
@section('section1')



<div class="page-body">
	<div class="row">
	<div class="col-lg-12"><h5 class="theme-heading p-10">Dashboard</h5></div>
	</div>

	<div class="row">
		<div class="col-lg-7 col-md-12">
		    <div class="card">
		        <div class="card-header borderless">
		            <h5>Site Analytics</h5>
		            <span class="text-muted">For more details about usage, please refer <a href="https://www.amcharts.com/online-store/" target="_blank">amCharts</a> licences.</span>
		            <div class="card-header-right">
		                <!-- <ul class="list-unstyled card-option">
		                    <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>
		                    <li><i class="feather icon-maximize full-card"></i></li>
		                    <li><i class="feather icon-minus minimize-card"></i></li>
		                    <li><i class="feather icon-refresh-cw reload-card"></i></li>
		                    <li><i class="feather icon-trash close-card"></i></li>
		                    <li><i class="feather icon-chevron-left open-card-option"></i></li>
		                </ul> -->
		            </div>
		        </div>
		        <div class="card-block">
		            <div id="seo-ecommerce-barchart" style="height: 375px"></div>
		        </div>
		    </div>
		</div>

		<div class="col-lg-5 col-md-12">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-yellow">$30200</h4>
                            <h6 class="text-muted m-b-0">Revenue</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-bar-chart-2 f-28"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-yellow">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">% change</p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-up text-white f-16"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-green">290+</h4>
                            <h6 class="text-muted m-b-0">User</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-file-text f-28"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-green">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">% change</p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-up text-white f-16"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-red">145</h4>
                            <h6 class="text-muted m-b-0">Product</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-calendar f-28"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-red">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">% change</p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-down text-white f-16"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-block">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="text-c-blue">500</h4>
                            <h6 class="text-muted m-b-0">Feedback</h6>
                        </div>
                        <div class="col-4 text-right">
                            <i class="feather icon-thumbs-up f-28"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-c-blue">
                    <div class="row align-items-center">
                        <div class="col-9">
                            <p class="text-white m-b-0">% change</p>
                        </div>
                        <div class="col-3 text-right">
                            <i class="feather icon-trending-down text-white f-16"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card ">
                <div class="card-block ">
                    <h2 class="text-center f-w-400 ">8,421</h2>
                    <p class="text-center text-muted ">Unique Visitors</p>
                    <div id="monthlyprofit-3" style="height:30px"></div>
                    <div class="m-t-5">
                        <div class="row ">
                            <div class="col-6 text-center ">
                                <h6 class="f-20 f-w-400">2,849</h6>
                                <p class="text-muted f-14 m-b-0">Today</p>
                            </div>
                            <div class="col-6 text-center ">
                                <h6 class="f-20 f-w-400">3,587</h6>
                                <p class="text-muted f-14 m-b-0">Yesterday</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-6 col-md-12">
    <div class="card table-card">
        <div class="card-header borderless ">
            <h5>Projects</h5>
            <div class="card-header-right">
                <!-- <ul class="list-unstyled card-option">
                    <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>
                    <li><i class="feather icon-maximize full-card"></i></li>
                    <li><i class="feather icon-minus minimize-card"></i></li>
                    <li><i class="feather icon-refresh-cw reload-card"></i></li>
                    <li><i class="feather icon-trash close-card"></i></li>
                    <li><i class="feather icon-chevron-left open-card-option"></i></li>
                </ul> -->
            </div>
        </div>
        <div class="card-block">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Due Date</th>
                            <th class="text-right">Priority</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-inline-block align-middle">
                                    <img src="{{ asset('resources/assets/files/assets/images/avatar-4.jpg') }}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                        <h6>John Deo</h6>
                                        <p class="text-muted m-b-0">Graphics Designer</p>
                                    </div>
                                </div>
                            </td>
                            <td>Able Pro</td>
                            <td>Jun, 26</td>
                            <td class="text-right"><label class="label label-danger">Low</label></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-inline-block align-middle">
                                    <img src="{{ asset('resources/assets/files/assets/images/avatar-5.jpg') }}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                        <h6>Jenifer Vintage</h6>
                                        <p class="text-muted m-b-0">Web Designer</p>
                                    </div>
                                </div>
                            </td>
                            <td>Mashable</td>
                            <td>March, 31</td>
                            <td class="text-right"><label class="label label-primary">high</label></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-inline-block align-middle">
                                    <img src="{{ asset('resources/assets/files/assets/images/avatar-3.jpg') }}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                        <h6>William Jem</h6>
                                        <p class="text-muted m-b-0">Developer</p>
                                    </div>
                                </div>
                            </td>
                            <td>Flatable</td>
                            <td>Aug, 02</td>
                            <td class="text-right"><label class="label label-success">medium</label></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-inline-block align-middle">
                                    <img src="{{ asset('resources/assets/files/assets/images/avatar-5.jpg') }}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                    <div class="d-inline-block">
                                        <h6>David Jones</h6>
                                        <p class="text-muted m-b-0">Developer</p>
                                    </div>
                                </div>
                            </td>
                            <td>Guruable</td>
                            <td>Sep, 22</td>
                            <td class="text-right"><label class="label label-primary">high</label></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-right m-r-20">
                    <a href="#!" class=" b-b-primary text-primary">View all Projects</a>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-lg-6 col-md-12">
    <div class="card latest-update-card">
        <div class="card-header borderless ">
            <h5>Latest Updates</h5>
            <div class="card-header-right">
                <!-- <ul class="list-unstyled card-option">
                    <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>
                    <li><i class="feather icon-maximize full-card"></i></li>
                    <li><i class="feather icon-minus minimize-card"></i></li>
                    <li><i class="feather icon-refresh-cw reload-card"></i></li>
                    <li><i class="feather icon-trash close-card"></i></li>
                    <li><i class="feather icon-chevron-left open-card-option"></i></li>
                </ul> -->
            </div>
        </div>
        <div class="card-block">
            <div class="latest-update-box">
                <div class="row p-t-20 p-b-20">
                    <div class="col-auto text-right update-meta">
                        <p class="text-muted m-b-0 d-inline">4 hrs ago</p>
                        <i class="feather icon-briefcase bg-c-red update-icon"></i>
                    </div>
                    <div class="col">
                        <h6>+ 5 New Products were added!</h6>
                        <p class="text-muted m-b-0">Congratulations!</p>
                    </div>
                </div>
                <div class="row p-t-20 p-b-20">
                    <div class="col-auto text-right update-meta">
                        <p class="text-muted m-b-0 d-inline">1 day ago</p>
                        <i class="feather icon-check bg-c-green  update-icon"></i>
                    </div>
                    <div class="col">
                        <h6>Database backup completed!</h6>
                        <p class="text-muted m-b-0">Download the <span> <a href="#!" target="_top" class="text-c-blue">latest backup</a> </span>.</p>
                    </div>
                </div>
                <div class="row p-t-20 p-b-20">
                    <div class="col-auto text-right update-meta">
                        <p class="text-muted m-b-0 d-inline">2 day ago</p>
                        <i class="feather icon-facebook bg-facebook update-icon"></i>
                    </div>
                    <div class="col">
                        <h6>+1 Friend Requests</h6>
                        <p class="text-muted m-b-10">This is great, keep it up!</p>
                        <div class="table-responsive">
                            <table class="table table-hover m-b-0">
                                <tbody>
                                    <tr>
                                        <td class="b-none">
                                            <a href="#!" class="align-middle">
                                               <img src="{{ asset('resources/assets/files/assets/images/avatar-5.jpg') }}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                               <div class="d-inline-block">
                                                   <h6>Jeny William</h6>
                                                   <p class="text-muted m-b-0">Graphic Designer</p>
                                               </div>
                                           </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="b-none">
                                            <a href="#!" class="align-middle">
                                                <img src="{{ asset('resources/assets/files/assets/images/avatar-3.jpg') }}" alt="user image" class="img-radius img-40 align-top m-r-15">
                                                <div class="d-inline-block">
                                                    <h6>John Deo</h6>
                                                    <p class="text-muted m-b-0">Web Designer</p>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="#!" class="b-b-primary text-primary">View all Projects</a>
            </div>
        </div>
    </div>
</div>


<div class="col-xl-4 col-md-6">
    <div class="card">
        <div class="card-header">
            <h5>Total Leads</h5>
            <div class="card-header-right">                                                             <ul class="list-unstyled card-option">                                                                 <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>                                                                 <li><i class="feather icon-maximize full-card"></i></li>                                                                 <li><i class="feather icon-minus minimize-card"></i></li>                                                                 <li><i class="feather icon-refresh-cw reload-card"></i></li>                                                                 <li><i class="feather icon-trash close-card"></i></li>                                                                 <li><i class="feather icon-chevron-left open-card-option"></i></li>                                                             </ul>                                                         </div>
        </div>
        <div class="card-block">
            <p class="text-c-green f-w-500"><i class="fa fa-caret-up m-r-15"></i> 18% High than last month</p>
            <div class="row">
                <div class="col-4 b-r-default">
                    <p class="text-muted m-b-5">Overall</p>
                    <h5>76.12%</h5>
                </div>
                <div class="col-4 b-r-default">
                    <p class="text-muted m-b-5">Monthly</p>
                    <h5>16.40%</h5>
                </div>
                <div class="col-4">
                    <p class="text-muted m-b-5">Day</p>
                    <h5>4.56%</h5>
                </div>
            </div>
        </div>
        <div id="tot-lead" style="height:150px"></div>
    </div>
</div>
<div class="col-xl-4 col-md-6">
    <div class="card">
        <div class="card-header">
            <h5>Total Vendors</h5>
            <div class="card-header-right">                                                             <ul class="list-unstyled card-option">                                                                 <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>                                                                 <li><i class="feather icon-maximize full-card"></i></li>                                                                 <li><i class="feather icon-minus minimize-card"></i></li>                                                                 <li><i class="feather icon-refresh-cw reload-card"></i></li>                                                                 <li><i class="feather icon-trash close-card"></i></li>                                                                 <li><i class="feather icon-chevron-left open-card-option"></i></li>                                                             </ul>                                                         </div>
        </div>
        <div class="card-block">
            <p class="text-c-red f-w-500"><i class="fa fa-caret-down m-r-15"></i> 24% High than last month</p>
            <div class="row">
                <div class="col-4 b-r-default">
                    <p class="text-muted m-b-5">Overall</p>
                    <h5>68.52%</h5>
                </div>
                <div class="col-4 b-r-default">
                    <p class="text-muted m-b-5">Monthly</p>
                    <h5>28.90%</h5>
                </div>
                <div class="col-4">
                    <p class="text-muted m-b-5">Day</p>
                    <h5>13.50%</h5>
                </div>
            </div>
        </div>
        <div id="tot-vendor" style="height:150px"></div>
    </div>
</div>
<div class="col-xl-4 col-md-12">
    <div class="card">
        <div class="card-header">
            <h5>Invoice Generate</h5>
            <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li class="first-opt"><i class="feather icon-chevron-left open-card-option"></i></li>
                    <li><i class="feather icon-maximize full-card"></i></li>
                    <li><i class="feather icon-minus minimize-card"></i></li>
                    <li><i class="feather icon-refresh-cw reload-card"></i></li>
                    <li><i class="feather icon-trash close-card"></i></li>
                    <li><i class="feather icon-chevron-left open-card-option"></i></li>
                </ul>
            </div>
        </div>
        <div class="card-block">
            <p class="text-c-green f-w-500"><i class="fa fa-caret-up m-r-15"></i> 20% High than last month</p>
            <div class="row">
                <div class="col-4 b-r-default">
                    <p class="text-muted m-b-5">Overall</p>
                    <h5>68.52%</h5>
                </div>
                <div class="col-4 b-r-default">
                    <p class="text-muted m-b-5">Monthly</p>
                    <h5>28.90%</h5>
                </div>
                <div class="col-4">
                    <p class="text-muted m-b-5">Day</p>
                    <h5>13.50%</h5>
                </div>
            </div>
        </div>
        <div id="invoice-gen" style="height:150px"></div>
    </div>
</div>
	</div>

</div>
@endsection
@section('footerscript')
<!-- dashboard -->
<script src="{{ asset('resources/assets/files/assets/pages/chart/float/jquery.flot.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/chart/float/jquery.flot.categories.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/chart/float/curvedLines.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/chart/float/jquery.flot.tooltip.min.js') }}"></script>
<!-- amchart js -->
<script src="{{ asset('resources/assets/files/assets/pages/widget/amchart/amcharts.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/widget/amchart/serial.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/widget/amchart/light.js') }}"></script>
<!-- dashboard -->
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/pages/dashboard/custom-dashboard.js') }}"></script>
@endsection
