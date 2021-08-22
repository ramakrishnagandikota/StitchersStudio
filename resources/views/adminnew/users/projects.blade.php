@extends('layouts.adminnew')
@section('title','Projects')
@section('section1')
<div class="page-body">
    <div class="row">
        <div class="col-lg-6">
            <h5 class="theme-heading p-10">Projects</h5>
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
                    <th>Type</th>
                    <th>UOM</th>
                    <th>Ease</th>
                    <th>Stitch gauge</th>
                    <th>Row gauge</th>
                    <th>created</th>
                </tr>
                </thead>
                <tbody>
                @if(count($projects) > 0)
                    @foreach($projects as $pro)
                        <?php
                        if($pro->uom == 'in' || $pro->uom == 'inches'){
                            $sgauge = DB::table('gauge_conversion')->where('id',$pro->stitch_gauge)->first();
                            $rgauge = DB::table('gauge_conversion')->where('id',$pro->row_gauge)->first();
                            $stitch_gauge = $sgauge->stitch_gauge_inch;
                            $row_gauge = $rgauge->row_gauge_inch;
                        }else if($pro->uom == 'cm'){
                            $sgauge = DB::table('gauge_conversion')->where('id',$pro->stitch_gauge)->first();
                            $rgauge = DB::table('gauge_conversion')->where('id',$pro->row_gauge)->first();
                            $stitch_gauge = $sgauge->stitches_10_cm;
                            $row_gauge = $rgauge->rows_10_cm;
                        }else{
                            $stitch_gauge = 0;
                            $row_gauge = 0;
                        }
                        ?>
                        <tr>
                            <td>{{$pro->id}}</td>
                            <td>{{$pro->name}}</td>
                            <td>{{$pro->pattern_type}}</td>
                            <td>{{($pro->uom == 'in' || $pro->uom == 'inches') ? 'Inches' : 'Cm'}}</td>
                            <td>{{$pro->ease}}</td>
                            <td>{{$stitch_gauge}}</td>
                            <td>{{$row_gauge}}</td>
                            <td>{{$pro->created_at ? date('d/M/Y',strtotime($pro->created_at)) : date('d/M/Y',strtotime($pro->updated_at))}}</td>
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
