@extends('layouts.knitterapp')
@section('title','My Patterns')
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
                        <th>SKU #</th>
                        <th>Design name</th>
                        <th>Price</th>
                        <th>Sale price</th>
                        <th>Last updated</th>
                        <th>Status</th>
                        <th>Action</th>
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
        </style>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
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
                    ajax: '{{ url("designer/my-patterns") }}',
                    columns: [
                        { data: 'sku' },
                        { data: 'product_name' },
                        { data: 'price' },
                        { data: 'sale_price' },
                        { data: 'updated_at' },
                        { data: 'status' },
                        { data: 'action' }
                    ],
                    "order": [[ 0, "desc" ]]
                });

                var mybutton = $('<a href="{{ url("designer/create-pattern") }}" style="font-size:14px;border-radius:2px;color: #fff;" id="redirect" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right m-t-5"><i class="icofont icofont-plus"></i> Create Pattern</a>');
                $('#example_filter').append(mybutton);

                $(document).on('click','.workstatus',function (){
                    var id = $(this).attr('data-id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url : '{{ url("designer/check-pattern-status") }}',
                        type : 'POST',
                        data : 'id='+id,
                        beforeSend : function (){

                        },
                        success : function (res){
                            $("#workStatus").html(res);
                        },
                        complete : function (){

                        }
                    });
                });
            });
        </script>
    @endsection
