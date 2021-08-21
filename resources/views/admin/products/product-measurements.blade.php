@extends('admin.layouts.app')
@section('breadcrum')
<div class="col-md-12 col-12 align-self-center">
    <h3 class="text-themecolor">Pattern Measurements</h3>
    <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pattern Measurements</li>
    </ol>
</div>
@endsection

@section('section1')

<div class="card col-12">
    <div class="card-body table-responsive">
<a class="btn waves-effect waves-light btn-success pull-right add-new" data-toggle="modal" data-target=".bs-example-modal-lg"  href="javascript:;">Add New Measurement</a>
<div class="clearfix"></div>

        <div class="">

        	<table id="myTable" class="table table-bordered table-striped">
        		<thead>
        			<tr>
        				<th>Id</th>
        				<th>Title</th>
        				<th>Image</th>
        				<th>Step</th>
        				<th>Action</th>
        			</tr>
        		</thead>
        		<tbody>
        			@foreach($measurements as $measure)
        			<tr>
        				<td>{{$measure->id}}</td>
        				<td>{{$measure->var_name}}</td>
        				<td><div><span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <img src="{{asset($measure->var_image) }}" />  <span class="tooltip-text">{{ucfirst($measure->var_description)}}</span></span> </span></div></td>
        				<td>{{$measure->step}}</td>
        				<td><a href="javascript:;" class="fa fa-pencil edit"  data-id="{{$measure->id}}" data-toggle="tooltip" title="Edit"></a> | <a href="javascript:;" data-toggle="tooltip" title="Delete" class="fa fa-trash-o delete" data-id="{{$measure->id}}"></a></td>
        			</tr>
        			@endforeach
        		</tbody>
        	</table>

        </div>

    </div>
</div>
@endsection

@section('section2')

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;z-index: 10000;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">Measurements</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
 	<div id="measurementsaddedit"></div>

 	<div class="modal-footer">
 		 <button type="button" class="btn btn-success waves-effect text-left" id="savem" >Save Measurements</button>
                <button type="button" class="btn btn-danger waves-effect text-left" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<input type="hidden" id="token" value="{{csrf_token()}}">

@endsection

@section('footerscript')
<style type="text/css">
	.error{
		color: red;
	}
	.select2-container--open{
		z-index:10000;
	}
	.select2{
		width: 100% !important;
    padding: .25rem .75rem;
    font-size: 1rem;
    line-height: 1.25;
    color: #495057;
    background-color: #fff;
    background-image: none;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: .25rem;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}

.select2-container--default .select2-selection--single{
	border: 0px !important;
}
	
</style>
<link href="{{ asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('resources/assets/connect/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{asset('node_modules/sweetalert/dist/sweetalert.min.js')}}"></script>
<script type="text/javascript">
	$(function(){
		$('#myTable').DataTable();
		
		var pid = '{{$id}}';
		$(document).on('click','.add-new',function(){
			$.get('{{url("admin/measurement-add")}}/'+pid,function(res){
				$("#measurementsaddedit").html(res);
				$(".select2").select2();
			});
		});
	
		$(document).on('click','#savem',function(){
			var formtype = $("#formtype").val();
			if(formtype == 1){
				var Data = $("#insert-measurements").serializeArray();
				var URL = '{{url("admin/insert-measurements")}}';
			}else{
				var Data = $("#update-measurements").serializeArray();
				var URL = '{{url("admin/update-measurements")}}';
			}

			var field_name = $("#field_name").val();
			var step = $("#step").val();
			var er = [];
			var cnt = 0;

			if(field_name == ""){
				$(".field_name").addClass('error').html('This field is required.');
				er+=cnt+1;
			}else{
				$(".field_name").removeClass('error').html('');
			}

			if(step == 0){
				$(".step").addClass('error').html('This field is required.');
				er+=cnt+1;
			}else{
				$(".step").removeClass('error').html('');
			}



			if(er != 0){
				return false;
			}


			$.ajax({
				url : URL,
				type : 'POST',
				data : Data,
				beforeSend : function(){
					$(".loadings").show();
				},
				success : function(res){
					if(res.status == 'fail'){
						swal('Error',res.response,'error');
					}else{
						$(".bs-example-modal-lg").modal('hide');
						swal('Success','Measurement added successfully.','success');
						setTimeout(function(){ location.reload(); },2000);
					}
				},
				complete : function(){
					$(".loadings").hide();
				}
			});
		});

		  /****Create Image ***/
		  /*
  $(document).on('change','#image',function(){
    var file_data = $('#image').prop('files')[0];
    var token = $('#token').val();
    var form_data = new FormData();
    form_data.append('file',file_data)
    form_data.append('_token',token)
    $.ajax({
      url : '{{url("admin/create-measurimage")}}', 
      dataType : 'html',
      cache :false,
      contentType : false,
      processData : false,
      data : form_data,
      type : "POST",
      beforeSend : function(){
      	$(".loadings").show();
        $("#savem").prop('disabled',true);
        $("#updatem").prop('disabled',true);
      },
      success : function(res){
        if(res == 0){
        $("#displayimage").html('Unable to upload image . Try again agter some time.');
        }else{
        $('#displayimage').html(res); 
    	}
      },
      complete : function(){
        $("#savem").prop('disabled',false);
        $("#updatem").prop('disabled',false);
        $(".loadings").hide();
      }
      
    });
    
  });

*/
/* edit measurement */

$(document).on('click','.edit',function(){
	$(".bs-example-modal-lg").modal('show');
	var id = $(this).attr('data-id');
	$.get('{{url("admin/edit-measurement")}}/'+id,function(res){
		$("#measurementsaddedit").html(res);
	});	
});

/* edit measurement */

$(document).on('click','.change-image',function(){
	$("#image").toggle();
	$("#fullimage").toggle();
});

/* delete measurement */

$(document).on('click','.delete',function(){
	var id = $(this).attr('data-id');
	var token = $('#token').val();
	if(confirm('Are you sure want to delete this measurement ?')){
var Data = 'id='+id+'&_token='+token;
		$.ajax({
				url : '{{url("admin/delete-measurement")}}',
				type : 'POST',
				data : Data,
				beforeSend : function(){
					$(".loadings").show();
				},
				success : function(res){
					if(res.response == 'success'){
						swal('Success','Measurement deleted successfully.','success');
						setTimeout(function(){ location.reload(); },2000);
					}else{
						swal('Fail',res.message,'error');
					}
				},
				complete : function(){
					$(".loadings").hide();
				}
			});

	}
});

/* delete measurement */

	});

	function countChar(val) {
        var len = val.value.length;
        if (len >= 150) {
          val.value = val.value.substring(0, 150);
          $('#charNum').text(0);
        } else {
          $('#charNum').text(150 - len);
        }
      };
</script>
@endsection