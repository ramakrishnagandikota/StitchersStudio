@extends('layouts.tempdesignerapp')
@section('title','My Patterns')
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
                                    <label class="theme-heading f-w-600 m-b-20">Pattern Library
                                    </label>
                                </div>
                            </div>
                            <div class="card p-20">
                                <div class="dt-responsive table-responsive">
                                    <table id="example"
                                           class="table table-striped table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>SKU</th>
                                            <th>Pattern name</th>
                                            <th>Pattern go live date</th>
                                            <th>Created date</th>
                                            <th>Status</th>
                                            <th>Review</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($patterns->count() > 0)
                                            <?php $i=1; ?>
                                            @foreach($patterns as $pat)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $pat->sku }}</td>
                                                    <td>{{ $pat->product_name }}</td>
                                                    <td>{{ date('m/d/Y',strtotime($pat->pattern_go_live_date)) }}</td>
                                                    <td>{{ date('m/d/Y',strtotime($pat->created_at)) }}</td>
                                                    <td>
                                                        @if($pat->status == 1) <span style="color:green;
">Active</span> @else <span style="color: red;"> In Active</span> @endif
                                                    </td>
                                                    <td>
                                                        @if($pat->in_review == 0) <span style="color:green;
"></span> @else <span style="color: red;"> In Review</span> @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ url('designer/main/view/pattern/'.$pat->pid.'/'
                                                        .$pat->slug)}}" class="fa fa-eye" style="color: #0d665b;
                                                        font-size: 13px;padding: 0px;background: none;" class="" data-toggle="tooltip" data-placement="top" title="Edit pattern"></a>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-lg-4"><button class="btn waves-effect pull-right waves-light btn-primary theme-outline-btn rejected" data-toggle="modal" data-target="#workflow-Modal"><i class="icofont icofont-plus"></i>Rejected</button></div>
                                    <div class="col-lg-4"><button class="btn waves-effect pull-right waves-light btn-primary theme-outline-btn accepted" data-toggle="modal" data-target="#workflow-Modal"><i class="icofont icofont-plus"></i>Accepted</button></div>
                                    <div class="col-lg-4"><button class="btn waves-effect pull-right waves-light btn-primary theme-outline-btn cancelled" data-toggle="modal" data-target="#workflow-Modal"><i class="icofont icofont-plus"></i>Cancelled</button></div>
                                    <div class="col-lg-4"></div>
                                </div> -->


                                <!-- Round card end -->
                            </div>
                        </div>
                        <!-- Page-body end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- Main-body end -->

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
    <div class="modal fade" id="delete-Modal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title f-w-500">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <p></p>
                    <p class="text-center"> <img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo"></p>
                    <h6 class="text-center f-w-500">Do you really want to delete this Measurement set ?</h6>
                    <!-- <h6 class="text-center">Action cannot be Undone !</h6> -->
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                    <button id="clear-all-tasks" type="button" class="btn btn-danger delete-card" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerscript')
    <style>
        .checkbox-column{width: 20px;padding: 2px 2px 9px 9px!important;}
        .checkbox-column>table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after{display: none!important;}
        .checkbox-column>table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:before{display: none!important;}
        .dataTables_filter .form-control{margin-top: 0px;line-height: 1.8;}
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/StatusTracker.css') }}">
    <!-- Data Table Css -->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('resources/assets/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/pages/data-table/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/widget.css') }}">

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
    <script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

    <script>
        $(function(){
            $('[data-toggle="tooltip"]').tooltip()
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    'csvHtml5',
                    'pdfHtml5',
                ],
            });
            

            $(".accepted").click(function()
                {
                    $(".accept-card").removeClass("halted");
                    //$(".reject-card,.cancelled-card").hide();
                    $(".in-progress").addClass("halted");
                }
            )
            $(".rejected").click(function()
                {
                    $(".reject-card").show();
                    //$(".accept-card,.cancelled-card").hide();
                    $(".completed,.in-progress,.bg-c-blue,.accept-card").addClass("halted");
                }
            )
            $(".cancelled").click(function()
                {
                    //$(".cancelled-card").show();
                    //$(".reject-card").hide();
                    $(".in-progress").removeClass("halted");
                }
            )


            $(document).on('click','.openStatus',function (){
                var id = $(this).attr('data-id');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var Data = 'id='+id;
                $(".loading").show();
                $.post('#',Data)
                    .done(function (res){
                        $(".loading").hide();
                        $("#workStatusData").html(res);
                    })
                    .fail(function (xhr, status, error){
                        $(".loading").hide();
                        notification('fa-times','Oops..',error,'danger');
                    });
            });

            $(document).on('click','.releasePattern',function (){
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to release this pattern.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value == true) {

                        var Data = 'id='+id+'&status=5';
                        $(".loading").show();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.post('#',Data)
                            .done(function (res){
                                setTimeout(function (){ location.reload(); },2000);
                                $(".loading").hide();

                                Swal.fire(
                                    'Yeah!',
                                    'Your pattern released successfully.',
                                    'success'
                                )
                            })
                            .fail(function (xhr, status, error){
                                $(".loading").hide();
                                notification('fa-times','Oops..',error,'danger');
                            });


                    }
                })
            });


            $(document).on('click','.deletePattern',function (){
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to delete this pattern.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value == true) {

                        var Data = 'id='+id;
                        $(".loading").show();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.post('#',Data)
                            .done(function (res){
                                setTimeout(function (){ location.reload(); },2000);
                                $(".loading").hide();

                                Swal.fire(
                                    'Yeah!',
                                    'Your pattern delete successfully.',
                                    'success'
                                )
                            })
                            .fail(function (xhr, status, error){
                                $(".loading").hide();
                                notification('fa-times','Oops..',error,'danger');
                            });


                    }
                })
            });

        });
    </script>
@endsection
