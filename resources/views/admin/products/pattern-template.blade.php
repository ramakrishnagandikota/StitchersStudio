@extends('layouts.admin')
@section('breadcrum')

@endsection

@section('section1')

<div class="card col-12" id="content">
@if($pdf)
	{!! $pdf->content !!}
@endif
</div>
<form id="patternContent">
	@csrf
	@if($pdf)
	<input type="hidden" name="id" value="{{$pdf->id}}">
	<input type="hidden" name="content" id="dataContent" value="{{$pdf->content}}">
	@else
	<input type="hidden" name="id" value="0">
	<input type="hidden" name="content" id="dataContent" value="">
	<input type="hidden" name="product_id" value="{{$product->id}}">
	@endif
	
</form>
<div class="col-md-6">
	<button type="button" class="btn footer-block-buttons-left theme-btn btn-block waves-effect m-b-10 m-t-10 m-l-10 btn-primary" data-toggle="modal" data-target="#large-Modal">Add Pattern</button>
</div>

<div class="col-md-6">
	<button type="button" class="btn footer-block-buttons-left theme-btn btn-block waves-effect m-b-10 m-t-10 m-l-10 btn-success" id="submitPattern" >Submit Pattern</button>
</div>


<div class="modal fade" id="large-Modal" tabindex="-1" role="dialog" style="z-index: 1050; display: none;" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Title</h4>
                                <button type="button" class="close closeModel" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- <h5>Default Modal</h5> -->
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Add Title</label>
                                        <div class="col-sm-10">
                                           <input type="text" class="form-control" id="AddTitle">
                                           <p class="Error">Please Enter Title</p>
                                        </div>
                                </div>
                                <div class="card-block">
                                                <div id="editor">
                                                    <h1>Hello world!</h1>
                                                    <p>Write here something</p>
                                                </div>
                                </div>
                                </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect closeModel" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary waves-effect waves-light " id="saveData">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
@endsection

@section('section2')

@endsection

@section('footerscript')
<style type="text/css">
	.theme-row,.card-header{
		background: #c5c5c5 !important;
	}
</style>
<link rel="stylesheet" href="{{ asset('resources/assets/files/assets/pages/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css') }}">

<script src="{{ asset('resources/assets/files/assets/pages/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/ckeditor/samples/js/sample.js') }}"></script>
<script type="text/javascript">
	$(function(){

		CKEDITOR.replace('editor');
		   //var count = 0 ;
        $("#saveData").click(function(){
        	var count = $("div.theme-row").length;
            var section;
            
            count=count+1;
          //  alert(count);
            var editor = CKEDITOR.instances['editor'].getData();
            
          //  alert(editor);
            var title = $("#AddTitle").val();
            if( title === ''){
               $(".Error").show();
               return false;
            }
            else{
                $("#AddTitle").val("");
                CKEDITOR.instances['editor'].setData('');
                $(".Error").hide();
                $('#large-Modal').modal('hide');

            }
            // var desc = CKEDITOR.instances['editor1'].getData();
            // var firstPElement = $( editor ,"p").first().text();
            // var title = $('#editor1').html();
           
            var acc =('<div class="row theme-row m-b-11" id="accordion'+count+'"><div class="card-header accordion col-lg-11 panel-group" ><h5 class="card-header-text" contenteditable="true">'+ title +'</h5></div><div class="col-lg-1 m-t-15"><i class="fa fa-trash-o mini-icons" onclick="Delete('+count+')"></i><i class="fa fa-caret-down micro-icons"  data-toggle="collapse"  data-target="#section'+count+'"></i></button></div></div><div class="card-block collapse show" id="section'+count+'"><div class="row"><div class="col-sm-12 col-xl-12 " contenteditable="true">'+editor+'</div></div></div></div>')
            $('.card').append(acc);
            setTimeout(function(){ 
            	var data = $("#content").html();
            	$("#dataContent").val(data);
            },1000);
            
        });

        $(".closeModel").click(function(){
            $("#AddTitle").val("");
                CKEDITOR.instances['editor'].setData('');
        });

        $(document).on('click','#submitPattern',function(){
        	
        	var Data = $("#patternContent").serializeArray();
        	$.ajax({
        		url : '{{url("admin/add-pattern-instructions")}}',
        		type : 'POST',
        		data : Data,
        		beforeSend : function(){

        		},
        		success : function(res){
        			if(res.status == 'Success'){
        				alert('success');
        				location.reload();
        			}else{
        				alert('error in uploading');
        			}
        		},
        		complete : function(){

        		}
        	});
        });
	});


	function Delete(a){
		if(confirm('Are you sure want to delete ?')){
			$("#section"+a).remove();
			$("#accordion"+a).remove();

			setTimeout(function(){ 
				var data = $("#content").html();
        		$("#dataContent").val(data);
			},1000);
		}

		
	}
</script>
@endsection