@extends('layouts.admin')
@section('breadcrum')
<div class="col-md-12 col-12 align-self-center">
    <h3 class="text-themecolor">Dashboard</h3>
    <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
    </ol>
</div>
@endsection

@section('section1')



 <div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Coming soon</h4>
            @if($measurements)
        <form action="{{url('admin/update-measurements-index')}}" method="POST">
            @csrf
            <table class="table table-bordered">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Description</th>
                </tr>
            @foreach($measurements as $meas)
                <tr>
                <td><input type="hidden" name="id[]" value="{{$meas->id}}"> {{$meas->id}}</td>
                <td>{{$meas->variable_name}}</td>
                <td>@if($meas->variable_image)
                    {{$meas->variable_image}}
                    @else
                    <input type="file" id="file{{$meas->id}}" onchange="addPackage({{$meas->id}})" class="file" data-id="{{$meas->id}}">

                    @endif
                    <input type="hidden" name="image[]" id="path{{$meas->id}}" value="{{ $meas->variable_image ? $meas->variable_image : 0 }}" >
                    </td>
                <td><textarea class="form-control" name="variable_description[]" id="variable_description{{$meas->id}}">{{$meas->variable_description}}</textarea></td>
                </tr>
            @endforeach
            </table>
            <input type="submit" name="submit" >
            </form>
            @endif
        </div>
    </div>
</div>
<div class="clearfix"></div>

@endsection

@section('section2')

@endsection

@section('footerscript')


<script type="text/javascript">
	$(function(){

	});

    function addPackage(id)
{
   var file_data = $("#file"+id).prop("files")[0];
  var form_data = new FormData();
  form_data.append("file", file_data)

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
            $.ajax({
                url: "{{url('admin/upload-images')}}",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                beforeSend : function(){
                  $(".preloader").show();
                },
                success : function(res){
                  if(res){
                      $("#path"+id).val(res.path);
                  }
                },
                complete : function(){
                  $(".preloader").hide();
                }
            });
}
</script>
@endsection
