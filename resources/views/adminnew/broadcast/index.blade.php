@extends('layouts.adminnew')
@section('title','Broadcasting')
@section('section1')
    <div class="page-body">
    <div class="row">
        <div class="col-lg-12">
            <label class="theme-heading f-w-600 m-b-20">Broadcast
            </label>
        </div>
    </div>
    <div class="card p-20">
        <div class="dt-responsive table-responsive">
            <table id="example2"
                   class="table table-striped table-bordered nowrap">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Date/Time</th>
                    <th>Platform</th>
                </tr>
                </thead>
                <tbody>
                @if($broadcast->count() > 0)
                    @foreach($broadcast as $bc)
                <tr>
                    <td>{{ $bc->id }}</td>
                    <td>{{ $bc->title }}</td>
                    <td>{{ $bc->message }}</td>
                    <td>{{ $bc->created_at }}</td>
                    <td>{{ $bc->platform }}</td>
                </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <!-- Round card end -->
</div>

@endsection
@section('footerscript')
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
        $(function (){
            $('#example2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    'csvHtml5',
                    'pdfHtml5',
                ],
            });

            setTimeout(function(){
                var mybutton = $('<a href="{{ route("broadcast.notify") }}" style="font-size:14px;border-radius:2px;margin-top:5px" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right"><i class="icofont icofont-ui-network"></i> &nbsp;Create new</a>;');
                $('#example2_filter').append(mybutton);
            },1000);
        });
    </script>
@endsection
