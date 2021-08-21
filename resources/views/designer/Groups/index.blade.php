@extends('layouts.knitterapp')
@section('title','My Groups')
@section('content')
<div class="pcoded-wrapper" id="dashboard">
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
<div class="page-body">
    <div class="row">
        <div class="col-lg-12">
            <label class="theme-heading f-w-600 m-b-20">Your groups
            </label>
        </div>
    </div>

    <div class="card p-20">
        <div class="dt-responsive "><!-- table-responsive -->
            <table id="example" class="table table-striped table-bordered nowrap dataTable">
                <thead>
                <tr>
                    <th>Group name</th>
                    <th>Pattern name</th>
                    <th>Group type</th>
                    <th>Date created</th>
                    <th>Date ended</th>
                    <th>No. of Members</th>
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

</div>
</div>
</div>
</div>
</div>
@endsection
@section('footerscript')
    <style>
        .fa-pencil{
            background-color: unset !important;
            padding: 0px !important;
        }
        .fa{
            color: #c38a9b !important;
        }
        .underline{
            border-bottom: 2px dotted #c38a9b;
        }
        #example_filter{
            float: right;
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
    <script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

    <script>
        $(function (){
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    'csvHtml5',
                    'pdfHtml5',
                ],
                ajax: '{{ url("designer/groups") }}',
                columns: [
                    { data: 'group_name' },
                    { data: 'pattern_name' },
                    { data: 'group_type' },
                    { data: 'date_created' },
                    { data: 'date_ended' },
                    { data: 'no_of_members' },
                    { data: 'status' },
                    { data: 'action' }
                ],
                "order": [[ 0, "desc" ]]
            });

            var mybutton = $('<a href="{{ url("designer/create-group") }}" style="font-size:14px;border-radius:2px;color: #fff;" id="redirect" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right m-t-5"><i class="icofont icofont-plus"></i> Create Group</a>');
            $('#example_filter').append(mybutton);

            $(document).on('click','.deleteGroup',function (){
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this project ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value == true) {
                        $(".loading").show();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.post('{{ url("designer/deleteGroup") }}',{id:id},function (res){
                            if(res.status == 'success'){
                                $('#example').DataTable().ajax.reload();
                                Swal.fire(
                                    'Deleted..!',
                                    'Project deleted successfully.',
                                    'success'
                                );
                                $(".loading").hide();
                            }else{
                                Swal.fire(
                                    'Oops..!',
                                    res.message,
                                    'danger'
                                );
                                $(".loading").hide();
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection