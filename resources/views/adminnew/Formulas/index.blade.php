@extends('layouts.adminnew')
@section('title','Formulas list')
@section('section1')
<div class="page-body">
    <div class="row">
        <div class="col-lg-6"><h5 class="theme-heading p-10">Functions list</h5></div>
    </div>
    <div class="card p-20">
        <div class="dt-responsive table-responsive">

            <table id="example2"
                   class="table table-striped table-bordered nowrap">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Design variant</th>
                    <th>Function name</th>
					<th>Factor(in)</th>
                    <th>Factor(cm)</th>
                    <th>Modifier</th>
                    <th>Input variables</th>
                    <th>Output variables</th>
                    <th>Conditional statement</th>
                </tr>
                </thead>
                <tbody>
                @if($functions->count() > 0)
                    @foreach($functions as $func)

                <tr>
                    <th>{{$func->id}}</th>
                    <td>
                        @php $dsgnVarnt = $func->designVarients; @endphp
                        @if(count($dsgnVarnt) > 0)
                            @for($k=0;$k<count($dsgnVarnt);$k++)
                                {{ucfirst($dsgnVarnt[$k]->design_varient_name)}}<br>
                            @endfor
                        @endif

                    </td>
                    <td>{{$func->function_name}}</td>
					<td>
                        @if($func->factor_id_in != 0)
                        <?php $factor = App\Models\Patterns\Factor::where('id',$func->factor_id_in)->first(); ?>
                        {{ $factor->factor_name }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($func->factor_id_cm != 0)
                        <?php $factor = App\Models\Patterns\Factor::where('id',$func->factor_id_cm)->first(); ?>
                        {{ $factor->factor_name }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($func->modifier_id != 0)
                        <?php $modifier = App\Models\Patterns\Modifier::where('id',$func->modifier_id)->first(); ?>
                        {{ $modifier->modifier_name }}
                        @else
                            -
                        @endif
                    </td>
                    <td style="text-align: left;">
                        @php $inpvars = $func->inputVariables; @endphp
                        @if(count($inpvars) > 0)
                            @for($i=0;$i<count($inpvars);$i++)
                                {{ucfirst($inpvars[$i]->variable_name)}}<br>
                            @endfor
                        @endif

                    </td>
                    <td style="text-align: left;">
                        @php $outvars = $func->outputVariables; @endphp
                        @if(count($outvars) > 0)
                            @for($j=0;$j<count($outvars);$j++)
                                {{ucfirst($outvars[$j]->variable_name)}}<br>
                            @endfor
                        @endif
                    </td>
                    <td style="text-align: left;">
                        @if($func->cond_stmt_exists == 1)
                            @php $condStmt = $func->conditionalStatements; @endphp
                            @if(count($condStmt) > 0)
                                @for($j=0;$j<count($condStmt);$j++)
                                    <b>{!! ucfirst($condStmt[$j]->description) !!}</b> :- {!! $condStmt[$j]->statement_description !!}<br>
                                @endfor
                            @endif
                        @else
                            -
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
@endsection
@section('footerscript')
<style>
    .dataTables_filter .form-control{margin-top: 0px;line-height: 1.8;}
    .table td, .table th {
        padding: 0.55rem 0.75rem;
        font-size: 14px;
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

<script>
$(document).ready(function () {
    $('#example2').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'print',
            'csvHtml5',
            'pdfHtml5',
        ],

    })

});
    </script>
@endsection
