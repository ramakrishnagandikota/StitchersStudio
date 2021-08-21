@extends('layouts.admin')
@section('breadcrum')
<div class="col-md-12 col-12 align-self-center">
    <h3 class="text-themecolor">Patterns</h3>
    <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Patterns</li>
    </ol>
</div>
@endsection

@section('section1')
<div class="card col-12">
                            <div class="card-body">

    @if(Session::has('success'))
        <div class="alert alert-success">
            {{Session::get('success')}}
        </div>
    @endif

    @if(Session::has('fail'))
        <div class="alert alert-success">
            {{Session::get('fail')}}
        </div>
    @endif

                                <!--
<a class="btn waves-effect waves-light btn-success pull-right" href="{{url('admin/add-new-pattern')}}">Add New Pattern</a> -->

<div class="pull-left">
    <p class="text-left">Apply Filters :  </p>
<select class="form-control" onchange="changeTabledata(this.value)" id="filter">
    <option value="all">All</option>
    <option value="active">Active</option>
    <option value="inactive">InActive</option>
</select>
</div>


 <div class="btn-group pull-right">

  <button type="button" class="btn btn-success dropdown-toggle waves-effect waves-light " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Add New Product
</button>
<div class="dropdown-menu">
    <a class="dropdown-item" href="{{url('admin/add-traditional-pattern')}}">Add traditional pattern</a>
    <a class="dropdown-item" href="{{url('admin/add-new-pattern')}}">Add pattern</a>
    <a class="dropdown-item" href="#">Add Yarn</a>
</div>
</div>
<?php
$array = array('Peekaboo Cabled Sweater Variables_in.xlsx','Peekaboo Cabled Sweater Variables_cm.xlsx','Boyfriend Master Variables_in.xlsx','Boyfriend Master Variables_cm.xlsx','Emilys Sweater Variables_in.xlsx','Emilys Sweater Variables_cm.xlsx','Marshas Lacy Tee Master Variables_in.xlsx','Marshas Lacy Tee Master Variables_cm.xlsx','Off-the-shoulder RuffleTee Master Variables_in.xlsx','Off-the-shoulder RuffleTee Master Variables_cm.xlsx','Trevors V-neck Master Variables_in.xlsx','Trevors V-neck Master Variables_cm.xlsx');

?>

<div class="btn-group pull-right" style="margin-right: 18px;">
    <a href="#" class="mdi mdi-information"  data-toggle="tooltip" data-html="true" title="" ></a> &nbsp;
  <button type="button" class="btn btn-success dropdown-toggle waves-effect waves-light " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-toggle="tooltip" title="Upload excel sheet">
    Upload excel sheet <span class="mdi mdi-cloud-upload"></span>
  </button>
  <div class="dropdown-menu">
    <a class="btn-file">Upload excel<input type="file" id="upload-excel" onchange="addPackage();"  /></a>
  </div>
</div>


<div class="clearfix"></div>

<div class="table-responsive">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
            	<th>Id</th>
                <th>Name</th>
                <th>File name</th>
                <th>Type</th>
                <th>Price($)</th>
                <th>Sale Price($)</th>
                <th>Sku</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        	<?php $i=1; ?>
        	@foreach($products as $da)
            @php
                $wStatus = App\Models\ProductWorkStatus::where('product_id',$da->id)->orderBy('id','desc')->first();
            @endphp
            <tr>
                <td>{{$da->id}}</td>
                <td>{{Str::limit($da->product_name,20)}}</td>
                <td>{{ $da->measurement_file }}</td>
                <td>@if($da->is_custom == 1) Custom @else Traditional @endif</td>
                <td>@if($da->price == 0) FREE @else {{$da->price}} @endif</td>
                <td>@if($da->sale_price == 0) NO @else {{$da->sale_price}} @endif</td>
                <td>{{$da->sku}}</td>
                <td>
                    @if($da->is_custom == 1)
                        @if($da->status == 1) 
                            <span style="color:green;">Active</span> 
                        @else 
                            <span style="color: red;"> In Active</span> 
                        @endif
                    @else
						{{ $wStatus->w_status }}
                        <!--<a href="javascript:;" class="workStatus" data-toggle="modal" data-target="#workflow-Modal" data-id="{{base64_encode($da->id)}}">{{ $wStatus->w_status }}</a>-->
                    @endif
                </td>
                <td>
                    @if($da->is_custom == 1)
                	<a href="{{url('admin/products-edit/'.$da->pid)}}" class="fa fa-pencil" data-toggle="tooltip" title="Edit"></a>
                        | <a href="javascript:;" data-toggle="tooltip" title="Delete" class="fa fa-trash-o delete-product" data-id="{{$da->id}}"></a>
                        | <a href="{{url('admin/create-pattern/'.$da->id.'/in')}}" class="mdi mdi-chemical-weapon"  data-toggle="tooltip" title="Setup Pattern Template" ></a>
                        | <a href="{{url('admin/create-pattern/'.$da->id.'/cm')}}" class="mdi mdi-chemical-weapon"  data-toggle="tooltip" title="Setup Pattern Template" ></a>
                        | <a href="{{url('admin/product/armhole-shaping/'.$da->id.'/7') }}" class="fa fa-hand-pointer-o"
                             title="Armhole shaping" ></a>
                    @else
                        <a href="{{url('admin/edit-traditional-pattern/'.base64_encode($da->id))}}" class="fa
                        fa-pencil" data-toggle="tooltip" title="Edit"></a> | 
						<a href="{{url('admin/create-pattern/'.$da->id.'/in')}}" class="mdi mdi-chemical-weapon"  data-toggle="tooltip" title="Setup Pattern Template" ></a>
                        | <a href="javascript:;" data-toggle="tooltip" title="Delete" class="fa fa-trash-o delete-product" data-id="{{$da->id}}"></a>
                    @endif

                </td>
            </tr>
            <?php $i++; ?>
            @endforeach
        </tbody>
    </table>
</div>
                            </div>
                        </div>


    <div class="modal fade" id="workflow-Modal" role="dialog">
        <div class="modal-dialog modal-sm custom-modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title f-w-500">Status</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="workStatus">

                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('section2')

@endsection

@section('footerscript')
<style type="text/css">
    .btn-file {
    position: relative;
    overflow: hidden;
}

    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: text;
        display: block;
    }
    .order-card {
                color: #fff;
                overflow: hidden;
            }
            .subscription{color: #c14d7d;}
            .subscription{
                animation:blinkingText 1.2s infinite;
            }
            @keyframes blinkingText{
                0%{     color: #c14d7d    }
                49%{    color:#c14d7d  }
                60%{    color: transparent; }
                99%{    color:transparent;  }
                100%{   color: #c14d7d;     }
            }
            .table#example td{font-size: 14px !important;}
            .dataTable.table td{text-align: center;}
            .card .card-block-small{padding: 0rem;}
            .widget-visitor-card{padding: 2px 0;}
            .label-primary{background-color: #448aff;}
            .link{
                text-decoration: underline;
                color: #c14d7d;
            }
            .fa-pencil{
                background-color: #fff;
                color: #0d665c;
                font-size: 12px;
                padding: 0px;
            }
            .checkbox-column{width: 20px;padding: 2px 2px 9px 9px!important;}
            .checkbox-column>table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after{display: none!important;}
            .checkbox-column>table.dataTable thead .sorting:before, table.dataTable thead .sorting_asc:before, table.dataTable thead .sorting_desc:before, table.dataTable thead .sorting_asc_disabled:before, table.dataTable thead .sorting_desc_disabled:before{display: none!important;}
            .dataTables_filter .form-control{margin-top: 0px;line-height: 1.8;}
            .vl-3{height: 31px;}
            .vl-1{top:90px}
            .custom-modal{max-width: 360px;}
            .workstatus{
                color: #dd8ca0 !important;
            }
            .Designaccepted{
                background: #9ccc65 !important;
            }
            .Patternreleasedtodesigner{
                background: #618c2f !important;
            }
            .Patternreleasedforsale{
                background: #446d14 !important;
            }
            .Designersubmits{
                background: #599219 !important;
            }
</style>
    <script src="{{ asset('resources/assets/connect/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
	$(function(){
        var stor = localStorage.getItem('filter');
        $("select#filter").val(stor);


		$('#myTable').DataTable();

        $(document).on('click','.delete-product',function(){
            var id = $(this).attr('data-id');
            if(confirm('Are you sure want to remove this product ?')){
                $(".loadings").show();
                $.get('{{url("admin/delete-product")}}/'+id,function(res){
                    if(res.status == 'Success'){
                        location.reload();
                    }else{
                        alert('unable to remove product , Try again after some time.');
                    }
                    setTimeout(function(){ $(".loadings").hide(); },1000);
                });
            }
        });


                $(document).on('click','.workStatus',function (){
                    var id = $(this).attr('data-id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url : '{{ url("designer/check-pattern-status") }}',
                        type : 'POST',
                        data : 'id='+id,
                        beforeSend : function (){

                        },
                        success : function (res){
                            $("#workStatus").html(res);
                        },
                        complete : function (){

                        }
                    });
                });

	});

    function changeTabledata(val){
        localStorage.setItem('filter',val);
            if(val == 'all'){
                window.location.assign('{{url("admin/browse-patterns")}}/'+val);
            }else if(val == 'active'){
                window.location.assign('{{url("admin/browse-patterns")}}/'+val);
            }else{
                window.location.assign('{{url("admin/browse-patterns")}}/'+val);
            }
    }


function addPackage()
{
   var file_data = $("#upload-excel").prop("files")[0];
  var form_data = new FormData();
  form_data.append("file", file_data)

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
            $.ajax({
                url: "{{url('admin/upload-excel-sheet')}}",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                beforeSend : function(){
                  $(".loadings").show();
                },
                success : function(res){
                   if(res.status == 'success'){
                    alert('file uploaded successfully.');
                   }else{
                    alert('File name was not matching.please upload a correct file.');
                   }
                },
                complete : function(){
                  $(".loadings").hide();
                }
            });
}

</script>
@endsection
