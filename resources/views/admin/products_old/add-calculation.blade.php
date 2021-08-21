@extends('admin.layouts.app')
@section('breadcrum')
<div class="col-md-12 col-12 align-self-center">
    <h3 class="text-themecolor">Calculations</h3>
    <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Calculations</li>
    </ol>
</div>
@endsection

@section('section1')
<div class="card col-12">

    <div class="alert alert-success alert-rounded hide" id="success">  <span id="message1">This is an example top alert. You can edit what u wish.</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    </div>

    <div class="alert alert-danger alert-rounded hide" id="error">  <span id="message2">This is an example top alert. You can edit what u wish.</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
    </div>

                            <div class="card-body">
                                <!-- 
<a class="btn waves-effect waves-light btn-success pull-right" href="{{url('admin/add-new-pattern')}}">Add New Pattern</a> -->
 <div class="btn-group pull-right">
          <button type="button" class="btn btn-success waves-effect waves-light " data-toggle="modal" data-target="#myModal" >
            Add New
          </button> 
          &nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-warning waves-effect waves-light delete" >
            Delete
          </button>
        </div>
<div class="clearfix"></div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="mytable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Variable</th>
                                <th>Formula</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="alldata">
                            @foreach($data as $da)
                            <tr id="t{{$da->id}}" class="@if($da->cal_formula == 'IF') @if($da->id != $da->ifid) hide @endif @endif">
                                <td>
                                    <input type="checkbox" name="id[]"class="check" value="{{$da->id}}" >
                                </td>
                                <td>{{$da->variable_name}}</td>
                                @if($da->cal_formula == 'MROUND')
                                <td>{{$da->cal_formula}}({{$da->operator1}},{{$da->operator2}})</td>
                                @elseif($da->cal_formula == 'IF')
                                <td>{{$da->cal_formula}}{{$da->operator1}} {{$da->operator2}}
<?php 
    $else = DB::table('measurement_calculation')->where('ifid',$da->id)->where('id','!=',$da->id)->get();
    ?>
    @foreach($else as $el)
    @if($el->operator3 == 'ELSEIF')
        {{$el->operator3}} {{$el->operator1}} {{$el->operator2}}
    @else
        {{$el->operator3}} {{$el->operator2}}
    @endif
    @endforeach

                                </td>
                                @else

                                <td>{{$da->cal_formula}}({{$da->operator1}})</td>
                                @endif
                                <td><a href="javascript:;">Edit<a/></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                            </div>
                        </div>

@endsection

@section('section2')


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Calculation</h4>
      </div>
      <div class="modal-body">
        <form id="calculation">
           
            <input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
            <input type="hidden" name="product_id" id="product_id" value="{{$id}}">
            <div class="form-group">
                <label>Variable Name</label>
                <select name="variable_name" id="variable_name" class="form-control" placeholder="Variable Name">
                    <option value=""  >Please select variable name</option>
                    @foreach($master_variables as $mv)
                    <option value="{{$mv->var_qname}}">{{$mv->var_name}}</option>
                    @endforeach
                </select>
                <p><span id="res"></span>
				<a href="javascript:;" class="pull-right" id="addvariable" >Add New</a> </p>
            </div>
			
			<div class="form-group hide" id="new_variable">
				<input type="text" name="new_variable_name" class="form-control" placeholder="New Variable Name">
			</div>

            <div class="form-group">
                <label>Formula</label>
                <select name="cal_formula" id="cal_formula" class="form-control">
                    <option value="">Please select formula</option>
                    @if(count($formulas) > 0)
                        @foreach($formulas as $fo)
                        <option value="{{$fo->formula}}">{{$fo->formula}}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div id="if" class="hide">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <a href="javascript:;" id="addif" title="Add more conditions" class="pull-right fa fa-plus"></a>
                            <label>Condition 1 </label>
                            <input type="text" name="operator1[]" class="form-control" placeholder="Condition 1">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Variable 1</label>
                            <input type="text" name="operator2[]" class="form-control" placeholder="Variable 1">
                        </div>
                    </div>

                </div>

                
                <div id="moreif"></div>

                <div class="form-group">
                    <label>Else Condition</label>
                    <input type="text" name="operator2[]" class="form-control" placeholder="ELSE">
                </div>

            </div>

            <div id="notif" class="hide">
            <div class="form-group">
                <label>Calculation</label>
                <input type="text" name="op1" class="form-control" placeholder="Calculation">
            </div>

            <div class="form-group" id="op2">
                <label>Operator 2</label>
                <input type="text" name="op2"  class="form-control" placeholder="Operator 2" >
            </div>
            </div>
                <input type="hidden" name="operator1[]" value="0">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save">Save changes</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('footerscript')
<style type="text/css">
    .alert-rounded{
    position: fixed;
    right: 0;
    top: 80px;
    z-index: 10000;
    }
    .select2{
    width: 100% !important;
      }
      #res{
        color: red;
      }
</style>

    <!-- icheck -->
    <link href="{{ asset('resources/assets/connect/assets/plugins/icheck/skins/all.css') }}" rel="stylesheet">
    <script src="{{ asset('resources/assets/connect/assets/plugins/icheck/icheck.js') }}"></script>
    <script src="{{ asset('resources/assets/connect/assets/plugins/icheck/icheck.init.js') }}"></script>

    <script src="{{ asset('resources/assets/connect/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>

    <link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
	$(function(){

        $("#mytable").dataTable();

        $("#variable_name").select2({
            placeholder: "Please select variable name",
            allowClear: true
        });
		
		$(document).on('click','#addvariable',function(){
			if($('#new_variable').hasClass('hide')){
			$('#new_variable').removeClass('hide');
			}else{
			$('#new_variable').addClass('hide');
			}

		});

        $(document).on('change','#cal_formula',function(){
            var va = $(this).val();
            if(va == 'IF'){
                $("#if").removeClass('hide');
                $("#notif").addClass('hide');
                $("#op2").addClass('hide');
            }else if(va == 'MROUND' || va == 'TRUNC'){
                $("#if").addClass('hide');
                $("#notif").removeClass('hide');
                $("#op2").removeClass('hide');
            }else{
                $("#notif").removeClass('hide');
                $("#if").addClass('hide');
                $("#op2").addClass('hide');
            }
        });

        var i=2;
        $(document).on('click','#addif',function(){
            var a = '<div class="row"  id="if'+i+'"><div class="col-md-6"><div class="form-group"> <a href="javascript:;" data-id="'+i+'" title="Remove condition" class="removeif pull-right fa fa-minus"></a> <label>Condition '+i+' </label> <input type="text" name="operator1[]" class="form-control" placeholder="Condition '+i+'"> </div></div><div class="col-md-6"> <div class="form-group"> <label>Variable '+i+'</label> <input type="text" name="operator2[]" class="form-control" placeholder="Variable '+i+'"> </div></div></div>';
            $("#moreif").append(a);
            i++;
        });

        $(document).on('click','.removeif',function(){
            var id = $(this).attr('data-id');
            if(confirm('Are you sure want to remove this ?')){
                $("#if"+id).remove();
            }
        });

        $(document).on('click','#save',function(){
            
            var Data = $("#calculation").serializeArray();

            $.ajax({
                url : '{{url("admin/save-calculation")}}',
                type : 'POST',
                data : Data,
                beforeSend : function(){
                    $(".loadings").show();
                },
                success : function(res){
                    if(res.message == 0){
                        $.get('{{url("admin/single-calc")}}/'+res.id,function(re){
                            $("#alldata").append(re);
                        });
                        $("#myModal").modal('hide');
                        $("#calculation")[0].reset();
                        $("#success").removeClass('hide').find('span#message1').html('Successfully added a measurement variable.');
                    }else{
                        $("#error").removeClass('hide').find('span#message2').html('Unable to add variable , please try again after some time.');
                    }
                },
                complete : function(){
                    $(".loadings").hide();
                    setTimeout(function(){
                        $("#success").addClass('hide').find('span#message1').html('');
                        $("#error").addClass('hide').find('span#message2').html('');
                    },3000);
                }
            });
        });

        $(document).on('click','.delete',function(){
            if(confirm('Are you sure want to remove this product ?')){
             $(".loadings").show();
            $(':checkbox:checked').each(function(i){
                var vv = $(this).val();
                $.get('{{url("admin/delete-calc")}}/'+$(this).val(),function(res){
                    if(res == 0){
                        $("#t"+vv).remove();
                        $("#success").removeClass('hide').find('span#message1').html('Successfully deleted a measurement variable.');
                    }else{
                        $("#error").removeClass('hide').find('span#message2').html('Unable to delete variable , please try again after some time.');
                    }
                    setTimeout(function(){ 
                        $("#success").addClass('hide').find('span#message1').html('');
                        $("#error").addClass('hide').find('span#message2').html('');
                        $(".loadings").hide();
                         },1000);
                });
            });

        }
            });


        $(document).on('change','#variable_name',function(){
            var variable_name = $("#variable_name").val();
            var pid = $("#product_id").val();
            var token = $("#token").val();
            var Data = 'variable_name='+variable_name+'&pid='+pid+'&_token='+token;

            $.ajax({
                url : '{{url("admin/check-calc-variable")}}',
                type : 'POST',
                data : Data,
                beforeSend : function(){
                    $("#save").prop('disabled',true);
                },
                success : function(res){
                    if(res != 0){
                        $("#res").html('Variable name already added for this pattern');
                        $("#save").prop('disabled',true);
                    }else{
                        $("#res").html('');
                        $("#save").prop('disabled',false);
                    }
                },
                complete : function(){

                }
            });
        });


	});
</script>
@endsection