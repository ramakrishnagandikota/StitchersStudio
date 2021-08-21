@extends('layouts.adminnew')
    @section('title','Support')
	@section('section')
    <div class="page-body">
        <div class="row">
            <div class="col-lg-12">
                <label class="theme-heading f-w-600 m-b-20">View Ticket
                </label>
            </div>
        </div>

        <div class="row">

            <div class="col-xl-3 col-md-3 col-lg-3">
                <div class="card bg-c-red text-white widget-visitor-card">
                    <div class="card-block-small text-center">
                        <h2>{{$open}}</h2>
                        <h6>Open</h6>
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 col-lg-3">
                <div class="card text-white widget-visitor-card" style="background-color: #448aff;">
                    <div class="card-block-small text-center">
                        <h2>{{$inProgress}}</h2>
                        <h6>In progress</h6>
                        <i class="fa fa-spinner"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 col-lg-3">
                <div class="card bg-c-yellow text-white widget-visitor-card">
                    <div class="card-block-small text-center">
                        <h2>{{$closed}}</h2>
                        <h6>Closed</h6>
                        <i class="fa fa-pause-circle"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-3 col-lg-3">
                <div class="card bg-c-green text-white widget-visitor-card">
                    <div class="card-block-small text-center">
                        <h2>{{$resloved}}</h2>
                        <h6>Resolved</h6>
                        <i class="fa fa-check-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-20">
            <div class="dt-responsive table-responsive">
                <table id="example" class="table table-striped table-bordered nowrap dataTable">

                    <thead>
                    <tr>
                        <th>Ticket #</th>
                        <th>Name of the pattern</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Last updated</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- Round card end -->
    </div>
	@endsection
    @section('footerscript')
        <style>
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
            .dataTable.table td{text-align: left;}
            .card .card-block-small{padding: 0rem;}
            .widget-visitor-card{padding: 2px 0;}
            .label-primary{background-color: #448aff;}
            .link{
                text-decoration: underline;
                color: #c14d7d;
            }
        </style>

        <link rel="stylesheet" type="text/css"
              href="{{ asset('resources/assets/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/pages/data-table/css/buttons.dataTables.min.css') }}">
        <!-- data-table js -->
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
                $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'print',
                        'csvHtml5',
                        'pdfHtml5',
                    ],
                    ajax: '{{ url("admin/support") }}',
                    columns: [
                        { data: 'ticket_id' },
                        { data: 'pattern_name' },
                        { data: 'subject' },
                        { data: 'status' },
                        { data: 'priority' },
                        { data: 'updated_at' }
                    ],
                    "order": [[ 0, "desc" ]]
                });
            });
        </script>
    @endsection
