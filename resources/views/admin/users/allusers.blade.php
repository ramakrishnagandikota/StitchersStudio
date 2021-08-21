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
<a class="btn waves-effect waves-light btn-success pull-right" href="{{url('admin/cususers-add')}}">Add New User</a>
<div class="clearfix"></div>
<div id="ress"></div>

<p>Filter : <select onchange="func(this.value);">
	<option value="all" @if($status == 'All') selected @endif >All</option>
	<option value="active" @if($status == 'Active') selected @endif >Active</option>
	<option value="inactive" @if($status == 'In Active') selected @endif >In Active</option>
</select>
&nbsp; &nbsp; Showing <strong>{{$status}}</strong> users.
</p>

<div class="table-responsive">
<table id="datatable" class="table table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Role</th>
						  <th>Measurements</th> 
						  <th>Projects</th>
                          <th>Status</th>
						  <th>IP</th>
						  <th>Date</th>
						  <th>Action</th>
						  
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
						  <td>@if($quer->hasRole('Admin')) <div>Admin</div> @endif @if($quer->hasRole('Knitter')) <div>Knitter</div> @endif  @if($quer->hasRole('Designer')) <div>Designer</div> @endif </td>
                          <td><a href="{{url('admin/users/'.base64_encode($quer->id).'/measurements')}}">{{$measurements}}</a></td>
						  <td><a href="{{url('admin/users/'.base64_encode($quer->id).'/projects')}}">{{$projects}}</a></td>
						  <td>@if($quer->status == 1) <span style="color:green;">Active</span> @else <span style="color: red;"> In Active</span> @endif</td>
						  
							<td>{{$quer->ipaddress}}</td>
							<td>{{date('d/M/Y',strtotime($quer->created_at))}}</td>
							<td><a href="{{url('admin/cususers-edit/'.$quer->id)}}" data-id="{{$quer->id}}" title="Edit" class="fa fa-pencil edit" ></a> &nbsp; | &nbsp; <a href="javascript:;" class="fa fa-trash delete" data-id="{{$quer->id}}" title="Delete"></a> 
							</td>
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
@section('section2')

@endsection
@section('footerscript')
   <script src="{{ asset('resources/assets/connect/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
$(function(){
$('#datatable').DataTable();
});

$(document).on('click','.delete',function(){
		var id = $(this).attr('data-id');
		if(confirm('Are you sure want to delete ?')){
			$.get("<?php echo url('admin/cususer-delete'); ?>/"+id,function(res){
				if(res == 0){			
				$("#ress").removeClass('alert alert-danger').addClass('alert alert-success').html('user deleted successfully.');
						setTimeout(function(){ location.reload(); },2000);
					}else{
						$("#ress").removeClass('alert alert-success').addClass('alert alert-danger').html('you have some errors while deleting a user,please check and try again.');
				}
				
				
			});
		}
	});

function func(value){
	if(value == 'active'){
		window.location.assign('{{url("admin/cususers-view/active")}}');
	}else if(value == 'inactive'){
		window.location.assign('{{url("admin/cususers-view/inactive")}}');
	}else{
		window.location.assign('{{url("admin/cususers-view")}}');
	}
}
</script>
@endsection