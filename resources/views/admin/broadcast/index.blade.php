@extends('layouts.admin')
@section('breadcrum')
    <div class="col-md-12 col-12 align-self-center">
        <h3 class="text-themecolor">Users</h3>
        <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
        </ol>
    </div>

@endsection

@section('section1')
    <div class="card col-12">
        <div class="card-body">
            <a class="btn waves-effect waves-light btn-success pull-right" href="{{ route("admin.broadcast.notify")
            }}">Create new message</a>
            <div class="clearfix"></div>
            <div id="ress"></div>

            <div class="table-responsive">
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
    </div>


@endsection
@section('section2')

@endsection
@section('footerscript')
    <script src="{{ asset('resources/assets/connect/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <script type="text/javascript">
        $(function(){
            $('#example2').DataTable();
        });
    </script>
@endsection
