@extends('layouts.admin')
@section('breadcrum')
<div class="col-md-12 col-12 align-self-center">
    <h3 class="text-themecolor">Users</h3>
    <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Measurements</a></li>
    </ol>
</div>

@endsection

@section('section1')
<div class="card col-12">
<div class="card-body">
<p><strong>Name :</strog> {{$user->first_name}} {{$user->last_name}} , <strong>Email :</strong> {{$user->email}}</p>
<a href="{{url('admin/cususers-view')}}">Back to users</a>
<div class="clearfix"></div>
<div id="ress"></div>
<div class="table-responsive">
<table id="datatable" class="table table-striped table-bordered">
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
if($pro->stitch_gauge != 0 && $pro->row_gauge != 0){
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
                          <td>{{$pro->ease ? $pro->ease : 0}}</td>
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


</script>
@endsection