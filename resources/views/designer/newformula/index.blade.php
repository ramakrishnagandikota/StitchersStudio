@extends('layouts.designerapp')
@section('title','New formula request')
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
                                                @if($form->f_status == 'Completed' || $form->f_status == 'Rejected')
                                                    <a href="{{ url('designer/view-formula/'.$form->enc_id) }}"><i class="fa fa-eye view-btn m-r-5"></i></a>
                                                    <a href="javascript:;" data-id="{{ encrypt($form->id) }}" class="deleteNewFormula"><i class="fa fa-trash delete-btn" ></i></a>
                                                @else
                                                    <a href="{{ url('designer/edit-formula/'.$form->enc_id) }}"><i class="fa fa-edit edit-btn m-r-5"></i></a>
                                                    <a href="javascript:;" data-id="{{ encrypt($form->id) }}" class="deleteNewFormula"><i class="fa fa-trash delete-btn" ></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                                <?php $i++; ?>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
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


    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select Pattern</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <div class="col-sm-8 col-lg-8 m-t-10">
                                @if($patterns->count() > 0)
                                <select class="form-control form-control-default" id="pattern-list">
                                    <option value="0" selected>--Select Pattern--</option>
                                    @foreach($patterns as $pat)
                                    <option value="{{ base64_encode($pat->id) }}">{{ $pat->name }}</option>
                                    @endforeach
                                </select>
                                    <span class="red pattern-list"></span>
                                @else
                                <div>You dont have any patterns to select.</div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success submit-btn" id="submitPattern">Continue</button>
                </div>
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
        .checkbox-column{width: 20px;padding: 2px 2px 9px 9px!important;}
        .checkbox-column>table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after{display: none!important;}
        .checkbox-column>table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:before{display: none!important;}
        .dataTables_filter .form-control{margin-top: 0px;line-height: 1.8;}
        .red{
            color: #c14d7d;
            font-weight: bold;
        }
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
            $('#example2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    'csvHtml5',
                    'pdfHtml5',
                ],
            });

            var mybutton = $('<button style="font-size:14px;border-radius:2px" data-toggle="modal" data-target="#myModal" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right"><i class="icofont icofont-plus"></i> Request new formula</button>')
            $('.dataTables_filter').append(mybutton);

            $(document).on('change','#pattern-list',function (){
                var value = $("#pattern-list").val();
                if(value == 0){
                    $(".pattern-list").html('This field is required.');
                    return false;
                }else{
                    $(".pattern-list").html('');
                }
            });

            $(document).on('click','#submitPattern',function (e){
                var value = $("#pattern-list").val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                if(value == 0){
                    $(".pattern-list").html('This field is required.');
                    return false;
                }else{
                    $(".pattern-list").html('');
                }

                window.location.assign('{{ url("designer/new-formula-request") }}/'+value);
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
                $.post('{{ route('designer.newFormula.workStatus') }}',Data)
                    .done(function (res){
                        $(".loading").hide();
                        $("#workStatusData").html(res);
                    })
                    .fail(function (xhr, status, error){
                        $(".loading").hide();
                        notification('fa-times','Oops..',error,'danger');
                    });
            });
        /*
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
            }); */


            $(document).on('click','.deleteNewFormula',function (){
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to delete this new formula.",
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

                        $.post('{{ route('designer.delete.newFormula.request') }}',Data)
                            .done(function (res){
                                setTimeout(function (){ location.reload(); },1000);
                                $(".loading").hide();
                                notification('fa-check','Yeah..','Formula deleted successfully.','success');
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
