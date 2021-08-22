@extends('layouts.designerapp')
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
                                            <th>Template name</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($patterns->count() > 0)
                                            @foreach($patterns as $pat)
                                        <tr>
                                            <td>{{ $pat->id }}</td>
                                            <td>{{ $pat->sku }}</td>
                                            <td>{{ $pat->name }}</td>
                                            <td>{{ date('m/d/Y',strtotime($pat->pattern_go_live_date)) }}</td>
                                            <td>{{ date('m/d/Y',strtotime($pat->created_at)) }}</td>
                                            <td>
                                                @php
                                                $status = $pat->workStatus()->leftJoin('work_status','work_status.id','p_pattern_work_status.w_status')->select('work_status.name')->orderBy('p_pattern_work_status.id','DESC')->first();

$template = $pat->templates()->first();
if($template){
    $template_id = $template->id;
    $template_name = $template->template_name;
}else{
    $template_id = 0;
    $template_name = '';
}
                                                @endphp
                                                <a href="javascript:;" class="openStatus" data-id="{{ $pat->id }}" data-toggle="modal" data-target="#workflow-Modal" style="text-decoration: underline;color: #0d665c;">@if($status){{ $status->name }} @endif</a> &nbsp;&nbsp;
												@if($status)
													@if($status->name == 'Completed')
														<a href="javascript:;" data-id="{{ encrypt($pat->id) }}" data-toggle="tooltip" data-placement="top" title="Release pattern" class="releasePattern"><i class="fa fa-toggle-off" aria-hidden="true" style="color: #0d665c;"></i></a>
													@endif
												@endif

                                                </td>
                                            <td>{{ $template_name }}</td>
                                            <td><a href="{{ url('designer/edit/pattern/'.$pat->pid.'/'.$pat->slug)}}" class="fa fa-pencil" style="color: #0d665b;font-size: 13px;padding: 0px;background: none;" class="" data-toggle="tooltip" data-placement="top" title="Edit pattern"></a> |
                                                @if($template_name)
                                                <a href="{{ url('designer/template/'.base64_encode($template_id).'/'.Str::slug($template_name)) }}" class="fa fa-book" class="" data-toggle="tooltip" data-placement="top" title="Edit pattern template"></a> |
                                                @else
                                                    <a href="{{ url('designer/pattern/select-template/'.base64_encode($pat->id).'/'.Str::slug($template_name)) }}" class="fa fa-book" class="" data-toggle="tooltip" data-placement="top" title="Select pattern template"></a> |
                                                @endif
                                                     <a href="javascript:;" data-id="{{ encrypt($pat->id) }}" class="fa fa-trash deletePattern" data-toggle="tooltip" data-placement="top" title="Delete pattern"></a> </td>
                                        </tr>
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

            var mybutton = $('<a href="{{route('create.pattern')}}" style="font-size:14px;border-radius:2px" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right"><i class="icofont icofont-plus"></i> Create Pattern</a>;')
            $('.dataTables_filter').append(mybutton);

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
                $.post('{{ route('getWorkStatus') }}',Data)
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

                        $.post('{{ route('release.pattern') }}',Data)
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

                        $.post('{{ route('delete.pattern') }}',Data)
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
