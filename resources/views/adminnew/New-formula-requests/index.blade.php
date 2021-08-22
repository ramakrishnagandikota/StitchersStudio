@extends('layouts.adminnew')
@section('title','View pattern template')
@section('section1')
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6">
                <h5 class="theme-heading p-10">View template</h5>
            </div>
        </div>
        <div class="card p-20">
            <div class="dt-responsive table-responsive">
                <table id="example2"
                       class="table table-striped table-bordered nowrap">
                    <thead>
                    <tr>
                        <th>Sno</th>
                        <th>Formula name</th>
                        <th>Date requested</th>
                        <th>Date completed</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($formulas->count() > 0)
                        <?php $i=1; ?>
                        @foreach($formulas as $form)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ ucfirst($form->formula_name) }}</td>
                                <td>{{ $form->created_at }}</td>
                                <td>{{ $form->completed_at ? $form->completed_at : '---' }}</td>
                                <td><a href="javascript:;" class="workStatus" data-id="{{ $form->enc_id }}" data-toggle="modal" data-target="#workflow-Modal" >{{ $form->f_status }}</a></td>
                                <td>
                                  <a href="{{ url('adminnew/edit/new-formula-request/'.$form->enc_id) }}"><i class="fa fa-edit edit-btn m-r-5"></i></a>
                                  <!--<a href="javascript:;" data-id="{{ encrypt($form->id) }}" class="deleteNewFormula"><i class="fa fa-trash delete-btn" ></i></a> -->
                                </td>
                            </tr>
                            <?php $i++; ?>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!--Modal for Workflow Status-->
    <div class="modal fade" id="workflow-Modal" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title f-w-500">Status</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="workStatusData">


                </div>
                <div class="modal-footer">
                    <!-- <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                    <button  id="clear-all-tasks" type="button" class="btn btn-danger delete-card" data-dismiss="modal">Delete</button> -->
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerscript')
    <style>
        .dataTables_filter .form-control{margin-top: 0px;}
        .radio-btn{display: table;margin: 0 auto;top: -7px;}
        .table td, .table th {
            padding: 0.55rem 0.75rem;
            font-size: 14px;
        }
        .hide{
            display: none;
        }
        .modal-footer{
            padding: 0px !important;
            padding-top:1rem !important;
            border:0px !important;
        }
        .help-block {
            display: block;
            margin-top: 5px;
            *margin-bottom: 10px;
            color: #bc7c8f;
            font-weight:bold;
        }
        small, .small {
            font-size: 85%;
        }
        #example2_filter label:nth-child(1){
            float:right;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
    <link rel="stylesheet" type="text/css" HREF="{{ asset('resources/assets/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
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
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
            $('#example2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    'csvHtml5',
                    'pdfHtml5',
                ],
            });

            $(document).on('click','.workStatus',function (){
                var id = $(this).attr('data-id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var Data = 'id='+id;
                $(".loading").show();
                $.post('{{ route('adminnew.newFormula.workStatus') }}',Data)
                    .done(function (res){
                        $(".loading").hide();
                        $("#workStatusData").html(res);
                    })
                    .fail(function (xhr, status, error){
                        $(".loading").hide();
                        notification('fa-times','Oops..',error,'danger');
                    });
            });


        });
    </script>
@endsection
