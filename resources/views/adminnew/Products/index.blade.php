@extends('layouts.adminnew')
@section('title','Patterns')
@section('section1')
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6">
                <h5 class="theme-heading p-10">Patterns</h5>
            </div>
        </div>
        <div class="card p-20">
            <div class="dt-responsive table-responsive">
                <table id="example2" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>SKU</th>
                        <th>Pattern name</th>
                        <th>Patern type</th>
                        <th>Pattern go live date</th>
                        <th>Created date</th>
                        <th>Status</th>
                        <th>Created by</th>
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
                                <td>{{ ucfirst($pat->pattern_type) }}</td>
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
                                    @if($status)
                                        <a href="javascript:;" class="openStatus" data-id="{{ $pat->id }}" data-toggle="modal" data-target="#workflow-Modal" style="text-decoration: underline;color: #0d665c;">{{ $status->name }}</a> &nbsp;&nbsp;
                                        @if($status->name == 'Completed')
                                            <a href="javascript:;" data-id="{{ encrypt($pat->id) }}" data-toggle="tooltip" data-placement="top" title="Release pattern" class="releasePattern"><i class="fa fa-toggle-off" aria-hidden="true" style="color: #0d665c;"></i></a>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ $pat->first_name.' '.$pat->last_name }}</td>
                                <td>
                                    @if(Auth::user()->id == $pat->user_id)
                                    <a href="{{ url('adminnew/edit-pattern/'.$pat->pid.'/'.$pat->slug)}}" class="fa
                                    fa-pencil" style="color: #0d665b;font-size: 13px;padding: 0px;background: none;" class="" data-toggle="tooltip" data-placement="top" title="Edit pattern"></a> |
                                    <a href="javascript:;" data-id="{{ encrypt($pat->id) }}" class="fa fa-trash deletePattern" data-toggle="tooltip" data-placement="top" title="Delete pattern"></a>
                                    @else
                                        <a href="javascript:;" data-id="{{ encrypt($pat->id) }}" class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Delete pattern"></a>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!--
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Pattern Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select type of pattern</label>
                        <input type="radio"> Custom
                        <input type="radio"> Traditional
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn thtmt-btn btn-primary">Continue</button>
                </div>
            </div>
        </div>
    </div>
    -->
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
    <link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
    <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('resources/assets/select2/select2.min.css') }}" >
    <script src="{{ asset('resources/assets/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('resources/assets/select2/select2-searchInputPlaceholder.js') }}"></script>

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

            setTimeout(function () {
                var mybutton = $('<a href="{{ url('adminnew/add-pattern/traditional') }}"  style="font-size:14px;border-radius:2px" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right" > Add Traditional Pattern</a>');
                $('#example2_filter').append(mybutton);
            }, 1000);

        });

    </script>
@endsection
