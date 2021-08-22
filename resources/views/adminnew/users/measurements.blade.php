@extends('layouts.adminnew')
@section('title','Measurements')
@section('section1')
<div class="page-body">
    <div class="row">
        <div class="col-lg-6">
            <h5 class="theme-heading p-10">Measurements</h5>
        </div>
    </div>
    <div class="card p-20">
        <p><strong>Name :</strong> {{$user->first_name}} {{$user->last_name}} , <strong>Email :</strong> {{$user->email}}</p>
        <a href="{{url('adminnew/cususers-view')}}" style="position: absolute;top: 19px;right: 28px;">Back to users</a>
        <div class="clearfix"></div>

        <div class="dt-responsive table-responsive">
            <table id="example2" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>UOM</th>
                    <th>Hips</th>
                    <th>Waist</th>
                    <th>waist front</th>
                    <th>Bust</th>
                    <th>Bust front</th>
                    <th>Bust back</th>
                    <th>Waist to underarm</th>
                    <th>Armhole depth</th>
                    <th>Wrist circumference</th>
                    <th>Forearm circumference</th>
                    <th>Upperarm circumference</th>
                    <th>Shoulder circumference</th>
                    <th>Wrist to underarm</th>
                    <th>Wrist to elbow</th>
                    <th>Elbow to underarm</th>
                    <th>Wrist to top of shoulder</th>
                    <th>Depth of neck</th>
                    <th>Neck width</th>
                    <th>Neck circumference</th>
                    <th>Neck to shoulder</th>
                    <th>Shoulder to shoulder</th>
                    <th>created</th>
                </tr>
                </thead>
                <tbody>
                @if(count($measurements) > 0)
                    @foreach($measurements as $meas)
                        <tr>
                            <td>{{$meas->id}}</td>
                            <td>{{$meas->m_title}}</td>
                            <td>{{$meas->measurement_preference}}</td>
                            <td>{{$meas->hips}}</td>
                            <td>{{$meas->waist}}</td>
                            <td>{{$meas->waist_front}}</td>
                            <td>{{$meas->bust}}</td>
                            <td>{{$meas->bust_front}}</td>
                            <td>{{$meas->bust_back}}</td>
                            <td>{{$meas->waist_to_underarm}}</td>
                            <td>{{$meas->armhole_depth}}</td>
                            <td>{{$meas->wrist_circumference}}</td>
                            <td>{{$meas->forearm_circumference}}</td>
                            <td>{{$meas->upperarm_circumference}}</td>
                            <td>{{$meas->shoulder_circumference}}</td>
                            <td>{{$meas->wrist_to_underarm}}</td>
                            <td>{{$meas->wrist_to_elbow}}</td>
                            <td>{{$meas->elbow_to_underarm}}</td>
                            <td>{{$meas->wrist_to_top_of_shoulder}}</td>
                            <td>{{$meas->depth_of_neck}}</td>
                            <td>{{$meas->neck_width}}</td>
                            <td>{{$meas->neck_circumference}}</td>
                            <td>{{$meas->neck_to_shoulder}}</td>
                            <td>{{$meas->shoulder_to_shoulder}}</td>
                            <td>{{$meas->created_at ? date('d/M/Y',strtotime($meas->created_at)) : date('d/M/Y',strtotime($meas->updated_at))}}</td>
                        </tr>

                    @endforeach
                @else
                    <tr class="text-center"><td colspan="6">No Records To Show</td></tr>
                @endif
                </tbody>
            </table>
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
    $(document).ready(function () {

        $('#example2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'print',
                'csvHtml5',
                'pdfHtml5',
            ],
        });

    });
</script>
@endsection
