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
            <p>Filter : <select onchange="func(this.value);">
                    <option value="all" @if($status == 'All') selected @endif >All</option>
                    <option value="active" @if($status == 'Active') selected @endif >Active</option>
                    <option value="inactive" @if($status == 'In Active') selected @endif >In Active</option>
                </select>
                &nbsp; &nbsp; Showing <strong>{{$status}}</strong> users.
            </p>

            <table id="example2" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Measurements</th>
                    <th>Projects</th>
                    <th>Status</th>
                    <th>IP</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @if(count($query) > 0)
                    @foreach($query as $quer)
                        <?php
                        $measurements = DB::table('user_measurements')->where('user_id',$quer->id)->count();
                        $projects = DB::table('projects')->where('user_id',$quer->id)->count();
                        ?>
                        <tr>
                            <td>{{$quer->id}}</td>
                            <td>{{$quer->first_name}} &nbsp; {{$quer->last_name}}</td>
                            <td>{{$quer->email}}</td>
                            <td><a href="{{url('adminnew/users/'.base64_encode($quer->id).'/measurements')}}">{{$measurements}}</a></td>
                            <td><a href="{{url('adminnew/users/'.base64_encode($quer->id).'/projects')}}">{{$projects}}</a></td>
                            <td>@if($quer->status == 1) <span style="color:green;">Active</span> @else <span style="color: red;"> In Active</span> @endif</td>
                        <!--<td><a href="{{url('adminnew/cususers-edit/'.$quer->id)}}" data-id="{{$quer->id}}" title="Edit" class="fa fa-pencil edit" ></a> &nbsp; | &nbsp; <a href="javascript:;" class="fa fa-trash delete" data-id="{{$quer->id}}" title="Delete"></a>
							</td>-->
                            <td>{{$quer->ipaddress}}</td>
                            <td>{{date('d/M/Y',strtotime($quer->created_at))}}</td>
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

        setTimeout(function(){
            var mybutton = $('<a href="{{ route('cususers.add') }}" style="font-size:14px;border-radius:2px" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right addUser" > Add User</a>');
            $('#example2_filter').append(mybutton);
        },1000);


        $(document).on('click','.delete',function(){
            var id = $(this).attr('data-id');
            if(confirm('Are you sure want to delete ?')){
                $.get("<?php echo url('adminnew/cususer-delete'); ?>/"+id,function(res){
                    if(res == 0){
                        $("#ress").removeClass('alert alert-danger').addClass('alert alert-success').html('user deleted successfully.');
                        setTimeout(function(){ location.reload(); },2000);
                    }else{
                        $("#ress").removeClass('alert alert-success').addClass('alert alert-danger').html('you have some errors while deleting a user,please check and try again.');
                    }


                });
            }
        });



    });

    function func(value){
        if(value == 'active'){
            window.location.assign('{{url("adminnew/cususers-view/active")}}');
        }else if(value == 'inactive'){
            window.location.assign('{{url("adminnew/cususers-view/inactive")}}');
        }else{
            window.location.assign('{{url("adminnew/cususers-view")}}');
        }
    }
</script>
@endsection
