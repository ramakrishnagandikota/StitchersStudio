@extends('layouts.knitterapp')
@section('title','Support')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-lg-12">
                <label class="theme-heading f-w-600 m-b-20">View Ticket
                </label>
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
                    $('#example').DataTable({
                        dom: 'Bfrtip',
                        buttons: [
                            'print',
                            'csvHtml5',
                            'pdfHtml5',
                        ],
                        ajax: '{{ url("support") }}',
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

                    var mybutton = $('<a href="{{ url("support/create-ticket") }}" style="font-size:14px;border-radius:2px;color: #fff;" id="redirect" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right m-t-5"><i class="icofont icofont-plus"></i> Create Ticket</a>');
                    $('#example_filter').append(mybutton);
                });
            </script>
    @endsection
