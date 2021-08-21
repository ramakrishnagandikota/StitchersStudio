@extends('layouts.knitterapp')
@section('title','Sales & Revenue')
@section('content')
<br><br><br>
    <div class="page-body">
        <div class="row">
            <div class="col-lg-12">
                <label class="theme-heading f-w-600 m-b-20">Sales & Revenue
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Monthly Sales</h5>
                        <!-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="fa fa-cog"></b></a>
                                <div class="dropdown-menu">
                                    <form action="" id="form_login" style="margin: 0; padding: 3px 15px" accept-charset="utf-8" method="post">
                                        <div class="form-group">
                                            <label>Select Year</label>
                                            <select class="form-control" id="year">
                                                <option value="">Selct Year</option>
                                                @for($i=date('Y'); $i>=2019; $i--)
                                                <option value="{{$i}}" @if($i == date('Y')) selected @endif >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Select Month</label>
                                            <select class="form-control" id="month">
                                                <option value="">Select Month</option>
                                                @for ($m=1; $m<=12; $m++)
                                                <?php
                                                    $month = date('F', mktime(0,0,0,$m, 1, date('Y')));
                                                    $month1 = date('m', mktime(0,0,0,$m, 1, date('Y')));
                                                ?>
                                                    <option value="{{$month1}}" @if($month == date('F')) selected @endif >{{$month}}</option>
                                                @endfor

                                            </select>
                                        </div>
                                        <p class="navbar-text">
                                            <button type="button" id="barChart" class="btn btn-primary theme-btn btn-sm">Submit</button>
                                        </p>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div id="chart_Combo" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Yearly Sales</h5>
                        <!-- <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span> -->
                        <ul class="nav pull-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="fa fa-cog"></b></a>
                                <div class="dropdown-menu">
                                    <form action="" id="form_login" style="margin: 0; padding: 3px 15px" accept-charset="utf-8" method="post">
                                        <div class="form-group">
                                            <label>Select Year</label>
                                            <select class="form-control" id="year_pie">
                                                <option value="">Selct Year</option>
                                                @for($i=date('Y'); $i>=2019; $i--)
                                                    <option value="{{$i}}" @if($i == date('Y')) selected @endif >{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <p class="navbar-text">
                                            <button type="button" id="pieChart" class="btn btn-primary theme-btn btn-sm">Submit</button>
                                        </p>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-block">
                        <div id="chart_Donut" style="width: 100%; height: 300px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-20">
            <div class="dt-responsive table-responsive">
                <table id="example" class="table table-striped table-bordered nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pattern name</th>
                        <th>Sold on</th>
                        <th>Status</th>
                        <th>Price</th>
                        <th>Purchased by</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- Round card end -->
    </div>

    <!--Modal for Workflow Status-->
    <div class="modal fade" id="workflow-Modal" role="dialog">
        <div class="modal-dialog modal-sm custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title f-w-500">Status</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="workStatus">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

    @endsection
    @section('footerscript')
        <style>
            .order-card {
                color: #fff;
                overflow: hidden;
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
            .table#example td{font-size: 14px !important;}
            .dataTable.table td{text-align: center;}
            .card .card-block-small{padding: 0rem;}
            .widget-visitor-card{padding: 2px 0;}
            .label-primary{background-color: #448aff;}
            .link{
                text-decoration: underline;
                color: #c14d7d;
            }
            .fa-pencil{
                background-color: #fff;
                color: #0d665c;
                font-size: 12px;
                padding: 0px;
            }
            .checkbox-column{width: 20px;padding: 2px 2px 9px 9px!important;}
            .checkbox-column>table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after{display: none!important;}
            .checkbox-column>table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:before{display: none!important;}
            .dataTables_filter .form-control{margin-top: 0px;line-height: 1.8;}
            .vl-3{height: 31px;}
            .vl-1{top:90px}
            .custom-modal{max-width: 360px;}
            .workstatus{
                color: #dd8ca0 !important;
            }
            .Designaccepted{
                background: #9ccc65 !important;
            }
            .Patternreleasedtodesigner{
                background: #618c2f !important;
            }
            .Patternreleasedforsale{
                background: #446d14 !important;
            }
            .Designersubmits{
                background: #599219 !important;
            }
            /* high chart css */
            .highcharts-figure, .highcharts-data-table table {
                min-width: 310px;
                max-width: 800px;
                margin: 1em auto;
            }

            #chart_Combo,#chart_Donut {
                /*height: 400px !important;*/
            }

            .highcharts-data-table table {
                font-family: Verdana, sans-serif;
                border-collapse: collapse;
                border: 1px solid #EBEBEB;
                margin: 10px auto;
                text-align: center;
                width: 100%;
                max-width: 500px;
            }
            .highcharts-data-table caption {
                padding: 1em 0;
                font-size: 1.2em;
                color: #555;
            }
            .highcharts-data-table th {
                font-weight: 600;
                padding: 0.5em;
            }
            .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
                padding: 0.5em;
            }
            .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
                background: #f8f8f8;
            }
            .highcharts-data-table tr:hover {
                background: #f1f7ff;
            }
            .dropdown-toggle::after {
                display: inline-block;
                width: 0;
                height: 0;
                margin-left: .255em;
                vertical-align: .255em;
                content: "";
                border-top: 0em;
                border-right: 0em;
                border-bottom: 0;
                border-left: 0em;
            }
            .fa-cog{
                font-size: 18px;
            }
            .highcharts-credits{
                display: none !important;
            }
        </style>

        <link rel="stylesheet" type="text/css"
              href="{{ asset('resources/assets/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/pages/data-table/css/buttons.dataTables.min.css') }}">

       <!-- high charts -->
        <script src="{{ asset('resources/assets/highcharts/code/highcharts.js') }}"></script>
        <script src="{{ asset('resources/assets/highcharts/code/modules/variable-pie.js') }}"></script>
        <script src="{{ asset('resources/assets/highcharts/code/modules/exporting.js') }}"></script>
        <script src="{{ asset('resources/assets/highcharts/code/modules/export-data.js') }}"></script>
        <script src="{{ asset('resources/assets/highcharts/code/modules/accessibility.js') }}"></script>
        <!-- data-table js -->
		<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
		
        <script src="{{ asset('resources/assets/files/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/assets/pages/data-table/js/jszip.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/assets/pages/data-table/js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/assets/pages/data-table/js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/buttons.flash.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/jszip.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/buttons.colVis.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/bower_components/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/bower_components/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/extension-btns-custom.js') }}"></script>
        <script>
            $(document).ready(function () {

                //loadPieChart(1);

                $.get('{{ url("designer/salesData") }}',function (res){
                    console.log(res);
                    loadBarChart(res);
                });

                $.get('{{ url("designer/salesPieData") }}',function (res){
                    console.log(res);
                    loadPieChart(res);
                });



                /* charts ends here */

                $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'print',
                        'csvHtml5',
                        'pdfHtml5',
                    ],
                    ajax: '{{ url("designer/sales") }}',
                    columns: [
                        { data: 'id' },
                        { data: 'product_name' },
                        { data: 'sold_on' },
                        { data: 'status' },
                        { data: 'price' },
                        { data: 'purchased_by' }
                    ],
                    "order": [[ 0, "desc" ]]
                });
				
				setTimeout(function(){ $("#example_filter").addClass('pull-right'); },1000);

                $(document).on('click','#barChart',function (){
                    var year = $("#year").val();
                    var month = $("#month").val();

                    var chart1 = $('#chart_Combo').highcharts();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url : '{{ url("designer/salesData") }}',
                        type : 'POST',
                        data : 'year='+year+'&month='+month,
                        beforeSend : function (){
                            $(".loading").show();
                        },
                        success : function (res){
                            loadBarChart(res);
                        },
                        complete : function (){
                            $(".loading").hide();
                        }
                    });
                });

                $(document).on('click','#pieChart',function (){
                    var year = $("#year_pie").val();

                    var chart1 = $('#chart_Donut').highcharts();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url : '{{ url("designer/salesPieData") }}',
                        type : 'POST',
                        data : 'year='+year,
                        beforeSend : function (){
                            $(".loading").show();
                        },
                        success : function (res){
                            loadPieChart(res);
                        },
                        complete : function (){
                            $(".loading").hide();
                        }
                    });
                });

            });

            function loadBarChart(res){
                Highcharts.chart('chart_Combo', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Sales for '+res.month+' '+res.year
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        categories: [
                            res.month
                        ],
                        crosshair: false
                    },
                    yAxis: {
                        min: 0,
                        title: {
                            text: 'Puchase count'
                        }
                    },
                    tooltip: {
                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                            '<td style="padding:0"><b>{point.y}</b></td></tr>',
                        footerFormat: '</table>',
                        shared: false,
                        useHTML: true
                    },
                    legend: {
                        enabled: true
                    },
                    plotOptions: {
                        column: {
                            pointPadding: 0.2,
                            borderWidth: 0
                        }
                    },
                    series: res.products
                });
            }

            function loadPieChart(res){
                Highcharts.chart('chart_Donut', {
                    chart: {
                        type: 'variablepie'
                    },
                    title: {
                        text: 'Patterns purchased in '+res.year
                    },
                    tooltip: {
                        headerFormat: '',
                        /*formatter: function() {
                            console.log(this);
                            console.log(this.series.userOptions['date']);
                            return '<span style="color:{point.color}">\u25CF</span> <b> '+this.key+'</b><br/>' +
                                'No of patterns sold: <b>'+this.y+'</b><br/>' +
                                'Amount earned in USD: <b>'+this.point.options.z+'</b><br/>'
                        }*/
                        pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                            'No of patterns sold: <b>{point.y}</b><br/>' +
                            'Amount earned in USD: <b>{point.z}</b><br/>'
                    },
                    series: [{
                        minPointSize: 10,
                        innerSize: '20%',
                        zMin: 0,
                        name: 'countries',
                        data: res.products
                    }]
                });
            }
        </script>
    @endsection
