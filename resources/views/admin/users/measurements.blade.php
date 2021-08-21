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
@section('section2')

@endsection
@section('footerscript')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
   <script src="{{ asset('resources/assets/connect/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
   <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>






<script type="text/javascript">
$(function(){
$('#datatable').DataTable({
	dom: 'Bfrtip',
        buttons: [
            /*'copyHtml5', */
            'excelHtml5',
            'csvHtml5'
            /*'pdfHtml5' */
        ]
});

});

</script>
@endsection