@extends('layouts.adminnew')
@section('title','Users')
@section('section1')
<div class="page-body">
    <div class="row">
        <div class="col-lg-6">
            <h5 class="theme-heading p-10">Users</h5>
        </div>
    </div>
    <div class="card p-20">
        <div class="dt-responsive table-responsive">
            <table id="example2" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>E-Mail</th>
                    <th>Admin</th>
                    <th>Knitter</th>
                    <th>Wholesaler</th>
                    <th>Designer</th>
                    <th>Advertaiser</th>
                    <th>Retailer</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <form action="{{ route('admin.assign') }}" method="post">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                            <td>{{ $user->email }} <input type="hidden" name="email" value="{{ $user->email }}"></td>
                            <td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Admin') ? 'checked' : '' }} name="role_admin"    ></td>
                            <td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Knitter') ? 'checked' : '' }} name="role_knitter"></td>
                            <td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Wholesaler') ? 'checked' : '' }} name="role_wholesaler"></td>
                            <td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Designer') ? 'checked' : '' }} name="role_designer"></td>
                            <td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Advertaiser') ? 'checked' : '' }} name="role_advertaiser"></td>
                            <td><input type="checkbox" class="js-switch" data-color="#26c6da" data-size="small" {{ $user->hasRole('Retailer') ? 'checked' : '' }} name="role_retailer"></td>
                            {{ csrf_field() }}
                            <td><button type="submit" class="btb btn-sm theme-btn">Assign</button></td>
                        </form>
                    </tr>

                @endforeach

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

<link href="{{ asset('resources/assets/connect/assets/plugins/switchery/dist/switchery.min.css') }}" rel="stylesheet" />
<script src="{{ asset('resources/assets/connect/assets/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
<script src="{{ asset('resources/assets/connect/assets/plugins/switchery/dist/switchery.min.js') }}"></script>

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

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        $('.js-switch').each(function() {
            new Switchery($(this)[0], $(this).data());
        });

    });
</script>
@endsection
