@extends('layouts.adminnew')
@section('title','Hierarchy')
@section('section1')
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6"><h5 class="theme-heading p-10">Output variables</h5></div>
        </div>
        <div class="card p-20">
            <div class="dt-responsive table-responsive">

                <table id="example2" class="table table-striped table-bordered nowrap">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Function name</th>
                        <th>Dependency with</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Function name</th>
                        <th>Dependency with</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>


        </div>
    </div>



    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Output variable</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addHierarchy">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Function name</label>
                                        <select name="child_functions_id" id="child_functions_id" class="form-control select2">
                                            <option value="">Please select function name</option>
                                            @if($functions->count() > 0)
                                                @foreach($functions as $func)
                                                    <option value="{{ $func->id }}">{{ $func->function_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Dependency with</label>
                                        <select name="parent_functions_id" id="parent_functions_id" class="form-control select2">
                                            <option value="">Please select function name</option>
                                            @if($functions->count() > 0)
                                                @foreach($functions as $func1)
                                                    <option value="{{ $func1->id }}">{{ $func1->function_name
                                                    }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="save" class="btn btn-success">Save Hierarchy</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerscript')
    <style>
        .dataTables_filter .form-control{margin-top: 0px;line-height: 1.8;}
        .table td, .table th {
            padding: 0.55rem 0.75rem;
            font-size: 14px;
        }
        .table td:nth-child(2),td:nth-child(3){
            text-align: left;
        }
        #example2_filter label:nth-child(1){
            float:right;
        }
        .fa-pencil{
            color: #333 !important;
            padding: 0px !important;
            background: none !important;
        }
        .addReadMoreWrapTxt.showmorecontent .SecSec,
        .addReadMoreWrapTxt.showmorecontent .readLess {
            display: block;
        }
        .addReadMore.showlesscontent .SecSec,
        .addReadMore.showlesscontent .readLess {
            display: none;
        }

        .addReadMore.showmorecontent .readMore {
            display: none;
        }
        .readMore,.readLess,#loadMores,#top {
            color: #0d665c;
            font-weight: bold;
            cursor: pointer;
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

    <link rel="stylesheet" href="{{ asset('resources/assets/select2/select2.min.css') }}" >
    <script src="{{ asset('resources/assets/select2/select2.full.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            $(".select2").select2();
            //setTimeout(function(){ AddReadMore(); },2000);
            $('#example2').DataTable({
                "ajax": '{{ route('adminnew.hierarchy') }}',
                "columns": [
                    { "data": "id" },
                    { "data": "child_function" },
                    { "data": "parent_function" },
                    { "data": "action" },
                ],
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    'csvHtml5',
                    'pdfHtml5',
                ]
            });

            setTimeout(function(){
                var mybutton = $('<a style="font-size:14px;border-radius:2px" class="btn-sm theme-btn waves-effect ' +
                    'waves-light btn-info pull-right" data-toggle="modal" data-target=".bd-example-modal-lg" href="#"> Create new</a>');
                $('#example2_filter').append(mybutton);
            },1000);


            $(document).on('click','.deleteHierarchy',function (){
                var id = $(this).attr('data-id');

                if(confirm('Are you sure want to delete this dependency ?')){
					$(".loading").show();
                    $.get('{{ url("adminnew/deleteHierarchy") }}/'+id,function (res){
                        if(res.status == 'success'){
                            alert('Dependency deleted successfully..');
                            $('#example2').DataTable().ajax.reload();
                        }else{
                            alert('Unable to delete dependency : '+res.message);
                        }
						$(".loading").hide();
                    });
                }
            });

            $(document).on('click','#save',function (){
                var Data = $("#addHierarchy").serializeArray();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("adminnew.addHierarchy") }}',
                    type : 'POST',
                    data : Data,
                    beforeSend : function (){
                        $(".loading").show();
                    },
                    success : function (res){
                        if(res.status == 'success'){
                            $("#addHierarchy")[0].reset();
                            $(".bd-example-modal-lg").modal('hide');
                            $('#example2').DataTable().ajax.reload();
                        }else{
                            alert('Unable to add hierarchy.Please refresh & try again.' + res.message);
                        }
                    },
                    error : function (){
                        alert('Unable to add hierarchy.Please refresh & try again.' + res.message);
                    },
                    complete : function (){
                        $(".loading").hide();
                    }
                });
            });

        });

    </script>
@endsection
