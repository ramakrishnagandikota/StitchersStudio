@extends('layouts.designerapp')
@section('title','Edit measurements')
@section('content')
    <div class="pcoded-wrapper" id="dashboard">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6">
                <h5 class="theme-heading p-10">Edit measurements</h5>
            </div>
        </div>

        <div class="card p-20">
            <form id="update-measurements">
                <input type="hidden" name="m_id" id="m_id" value="{{ $measurements->id }}">
                <div class="col-md-12">
                    <div class="row m-b-10">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Measurement name</label>
                                <input type="text" name="m_title" class="form-control inputs" value="{{ $measurements->m_title ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Units of measurement</label>
                                <div><span>Inches</span>  &nbsp; <input type="radio" name="uom" class="uom inputs" value="in" @if($measurements->uom == 'in') checked @endif ></div>
                                <div><span>Centimeters</span>  &nbsp; <input type="radio" name="uom" class="uom" value="cm" @if($measurements->uom == 'cm') checked @endif ></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($measurements->m_image != 'https://knitfitco.com')

                                <div class="profile-pic col-md-4">
                                    <img src="{{ $measurements->m_image }}" id="image" style="width: 100%;">
                                    <div class="edit"><a href="javascript:;" class="deleteImage" data-id="{{ $measurements->id }}"><i class="fa fa-trash fa-lg"></i></a></div>
                                </div>

                            @endif
                            <input type="file" class="inputs" name="file[]" id="filer_input0" data-jfiler-limit="1" data-jfiler-extensions="jpg,jpeg,png" >

                        </div>
                    </div>


                </div>



                <div class="col-md-12 @if($measurements->uom == 'in') show @else hide @endif"  id="in" >

                    @if($measurementVariables->count() > 0)
                        @foreach($measurementVariables as $mvars)
                        <?php
                            $bt = str_replace('_',' ',$mvars->variable_type); $v_type = ucfirst($bt);
                        ?>


                    <div class="row theme-row m-b-10">
                        <div class="card-header accordion col-lg-11" data-toggle="collapse" data-target="#section3{{$mvars->id}}">
                            <h5 class="card-header-text">{{ $v_type }}</h5>
                        </div>
                        <div class="col-lg-1 m-t-15">
                            <i class="fa fa-caret-down pull-right micro-icons"></i>
                        </div>
                    </div>

                    <div class="card-block collapse show" id="section3{{$mvars->id}}">
                        <div class="row">
                            @php
                                $mvariables = App\Models\Patterns\MeasurementVariables::where('variable_type',$mvars->variable_type)->get();
                            @endphp
                            @foreach($mvariables as $vars)
                                <?php
                                $var_name = $vars->variable_name;
                                $var_name1 = strtolower($var_name);
                                $var_name2 = str_replace(' ','_',$var_name1);
                                ?>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>{{ ucfirst($var_name) }}</label>
                                        <input type="hidden" name="measurement_variable_id_in[]" class="form-control" value="{{ $vars->id }}">
                                        @if($measurementValues->count() > 0)

                                            <select name="measurement_value_in[]" class="inputs" >
                                                <option value="">Please select a value</option>
                                                @for($i=$vars->v_inch_min;$i<= $vars->v_inch_max;$i+=0.25)
                                                    <option value="{{ $i }}" @foreach($measurementValues as $mv) @if($mv->measurement_variable_id == $vars->id) @if($mv->measurement_value == $i) selected @endif @endif @endforeach >{{ $i }}</option>
                                                @endfor
                                            </select>
                                        @else
                                            <select name="measurement_value_in[]" class="inputs" >
                                                <option value="">Please select a value</option>
                                                @for($i=$vars->v_inch_min;$i<= $vars->v_inch_max;$i+=0.25)
                                                    <option value="{{ $i }}" >{{ $i }}</option>
                                                @endfor
                                            </select>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                @endif
                </div>


                <div class="col-md-12 @if($measurements->uom == 'cm') show @else hide @endif"  id="cm" >

                    @if($measurementVariables->count() > 0)
                        @foreach($measurementVariables as $mvars)
                            <?php
                            $bt = str_replace('_',' ',$mvars->variable_type); $v_type = ucfirst($bt);
                            ?>


                            <div class="row theme-row m-b-10">
                                <div class="card-header accordion col-lg-11" data-toggle="collapse" data-target="#section3{{$mvars->id}}">
                                    <h5 class="card-header-text">{{ $v_type }}</h5>
                                </div>
                                <div class="col-lg-1 m-t-15">
                                    <i class="fa fa-caret-down pull-right micro-icons"></i>
                                </div>
                            </div>

                            <div class="card-block collapse show" id="section3{{$mvars->id}}">
                                <div class="row">
                                    @php
                                        $mvariables = App\Models\Patterns\MeasurementVariables::where('variable_type',$mvars->variable_type)->get();
                                    @endphp
                                    @foreach($mvariables as $vars)
                                        <?php
                                        $var_name = $vars->variable_name;
                                        $var_name1 = strtolower($var_name);
                                        $var_name2 = str_replace(' ','_',$var_name1);
                                        ?>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ ucfirst($var_name) }}</label>
                                                <input type="hidden" name="measurement_variable_id_cm[]" class="form-control" value="{{ $vars->id }}">
                                                @if($measurementValues->count() > 0)

                                                    <select name="measurement_value_cm[]" class="inputs" >
                                                        <option value="">Please select a value</option>
                                                        @for($i=$vars->v_cm_min;$i<= $vars->v_cm_max;$i+=0.5)
                                                            <option value="{{ $i }}" @foreach($measurementValues as $mv) @if($mv->measurement_variable_id == $vars->id) @if($mv->measurement_value == $i) selected @endif @endif @endforeach >{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @else

                                                    <select name="measurement_value_cm[]" class="inputs" >
                                                        <option value="">Please select a value</option>
                                                        @for($i=$vars->v_cm_min;$i<= $vars->v_cm_max;$i+=0.5)
                                                            <option value="{{ $i }}" >{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>




                <input type="button" id="confirmMeasurements" class="btn theme-btn btn-primary btn-sm pull-right" value="Update measurement">
            </form>
        </div>

    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="summernoteModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Measurement</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style="height: 350px;overflow-y: scroll;">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="tab-content card-block">
                                <div class="tab-pane active" id="confirmVariables" role="tabpanel">


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group pull-right" >
                        <button type="button"  class="btn theme-btn btn-primary btn-md m-r-10" data-dismiss="modal">Close</button>
                        <input type="button" id="submitMeasurements" class="btn theme-btn btn-primary btn-md pull-right" value="Confirm Measurements">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
    <input type="hidden" id="m_image" value="{{ $measurements->m_image }}">
@endsection
@section('footerscript')
    <script>
        var URL1 = '{{ route("designer.image.upload") }}';
        var URL2 = '';
    </script>
<style>
    .hide{
        display: none;
    }
    [type=radio] {
        position: relative !important;
        opacity: 1 !important;
        height: auto !important;
        width: auto !important;
    }
    .profile-pic {
        position: relative;
        display: inline-block;
    }

    .profile-pic:hover .edit {
        display: block;
    }

    .edit {
        padding-top: 7px;
        padding-right: 7px;
        position: absolute;
        right: 0;
        top: 0;
        display: none;
    }
    .grey{
        background: #d3d3d3 !important;
    }
</style>

<link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
<script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('resources/assets/selectize/selectize.css')}}">
<script type="text/javascript" src="{{asset('resources/assets/selectize/selectize.min.js')}}"></script>

<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css')}}" type="text/css" rel="stylesheet" />
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css')}}" type="text/css" rel="stylesheet" />
<script src="{{ asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js')}}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/filer/designer-create-patterns-jquery.fileupload.init.js')}}" type="text/javascript"></script>

    <script>
        $(function(){
            $('select').selectize();

            validateForm();



            setTimeout(function (){
                var m_image = $("#m_image").val();

                if(m_image){
                    $(".jFiler-theme-dragdropbox").hide();
                }
            },1000);

            measurementsImages('filer_input0',URL1,URL2);

            $(document).on('click','.uom',function (){
                var val = $(this).val();
                if(val == 'in'){
                    $("#in").show();
                    $("#cm").hide();
                }else{
                    $("#in").hide();
                    $("#cm").show();
                }
            });

            $(document).on('click','#confirmMeasurements',function (){
                $('#update-measurements').data('bootstrapValidator').validate();
                var valid = $('#update-measurements').data('bootstrapValidator').isValid();

                if(valid == true){
                    $("#summernoteModal").modal('show');
                    getAllData();
                }
            });

            $(document).on('click','#submitMeasurements',function (){
                var Data = $("#update-measurements").serializeArray();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("designer.measurements.update") }}',
                    type : 'POST',
                    data : Data,
                    beforeSend : function (){
                        $("#submitMeasurements").prop('disabled',true);
                        $(".loading").show();
                    },
                    success : function(response){
                        if(response.status == 'success'){
                            notification('fa-check','success','Measurement updated successfully.','success');
                            setTimeout(function (){
                                window.location.assign('{{ url("designer/measurements") }}');
                            },1000);
                        }else{
                            notification('fa-times','Error','Unable to update measurement.Try again','danger');
                            setTimeout(function (){
                                location.reload();
                            },1000);
                        }
                    },
                    complete : function (){
                        setTimeout(function (){
                            $(".loading").hide();
                        },2000);
                    },
                    error : function (){

                    }
                });
            });




/*
.on('success.form.bv', function(e) {
                e.preventDefault();
                $("#summernoteModal").modal('show');
                getAllData();
                return false;
                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');

                var Data = $("#update-measurements").serializeArray();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("designer.measurements.update") }}',
                    type : 'POST',
                    data : Data,
                    beforeSend : function (){
                        $(".loading").show();
                    },
                    success : function(response){
                        if(response.status == 'success'){
                            notification('fa-check','success','Measurement updated successfully.','success');
                            setTimeout(function (){
                                location.reload();
                            },1500);
                        }else{
                            notification('fa-times','Error','Unable to update measurement.Try again','danger');
                            setTimeout(function (){
                                location.reload();
                            },1500);
                        }
                    },
                    complete : function (){
                        setTimeout(function (){
                            $(".loading").hide();
                        },1500);
                    },
                    error : function (){

                    }
                });
            });
 */

            $(document).on('click','.deleteImage',function (){
               var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    console.log(result);
                    if (result.value == true) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        var Data = 'id='+id;
                        $.ajax({
                            url : '{{ route("designer.delete.measurement.image") }}',
                            type : 'POST',
                            data : Data,
                            beforeSend : function (){
                                $(".loading").show();
                            },
                            success : function(response){
                                if(response.status == 'success'){
                                    $(".profile-pic").remove();
                                    notification('fa-check','success','Image deleted successfully.','success');
                                    setTimeout(function (){
                                        $(".jFiler-theme-dragdropbox").show();
                                    },1000);
                                }else{
                                    notification('fa-times','Error','Unable to delete image.Try again','danger');
                                }
                            },
                            complete : function (){
                                setTimeout(function (){
                                    $(".loading").hide();
                                },1500);
                            },
                            error : function (){

                            }
                        });
                    }
                });

            });

        });

        function getAllData(){
            var cc = '<p class="f-14 m-b-10" style="color: #000000;">Please review and confirm that these measurements are correct</p><div class="table-responsive"><table class="table table-styling confrim-measurement table-info">';

            var uom = $('input[name=uom]:checked').val()
            var data = $("#update-measurements div#"+uom+" label");
            var data1 = $("#update-measurements div#"+uom+" select.inputs");

            if(uom == 'in'){
                var UOM = '"';
            }else{
                var UOM = 'cm';
            }

            for (var i=0;i<data.length;i++){

                var mvalue = (data[i].value == '') ? 0 : data[i].value;

                if(i == 0){
                    cc+='<thead><tr class="grey"><th class="t-heading">Body size</th><th></th><th></th><th></th></tr></thead><tbody>';
                }else if(i == 7){
                    cc+='<thead><tr class="grey"><th class="t-heading">Body length</th><th></th><th></th><th></th></tr></thead><tbody>';
                }else if(i == 9){
                    cc+='<thead><tr class="grey"><th class="t-heading">Arm size</th><th></th><th></th><th></th></tr></thead><tbody>';
                }else if(i == 13){
                    cc+='<thead><tr class="grey"><th class="t-heading">Arm length</th><th></th><th></th><th></th></tr></thead><tbody>';
                }else if(i == 17){
                    cc+='<thead><tr class="grey"><th class="t-heading">Neck and Shoulders</th><th></th><th></th><th></th></tr></thead><tbody>';
                }else if(i == 22){
                    cc+='<thead><tr class="grey"><th class="t-heading">Pattern specific measurements</th><th></th><th></th><th></th></tr></thead><tbody>';
                }

                //console.log(i+' - '+data[i].innerHTML);

                if(i >= 0 && i< 7){
                    if(i % 2 === 0){
                        cc+='<tr><th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td>';
                    }else{
                        cc+='<th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td></tr>';
                    }
                }else if(i >= 7 && i< 9){
                    if(i % 2 === 0){
                        cc+='<tr><th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td>';
                    }else{
                        cc+='<th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td></tr>';
                    }
                }else if(i >= 9 && i < 13){
                    if(i % 2 === 0){
                        cc+='<tr><th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td>';
                    }else{
                        cc+='<th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td></tr>';
                    }
                }else if(i >= 13 && i < 17){
                    if(i % 2 === 0){
                        cc+='<tr><th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td>';
                    }else{
                        cc+='<th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td></tr>';
                    }
                }else if(i >= 17 && i < 22){
                    if(i % 2 === 0){
                        cc+='<tr><th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td>';
                    }else{
                        cc+='<th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td></tr>';
                    }
                }else if(i >= 22){
                    if(i % 2 === 0){
                        cc+='<tr><th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td>';
                    }else{
                        cc+='<th>'+data[i].innerHTML+'</th><td>'+data1[i].value+' '+UOM+'</td></tr>';
                    }
                }


            }
            cc+='</tbody></div>'
            $("#confirmVariables").html(cc);
        }

        function validateForm(){
            $('#update-measurements')
                .bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {
                        uom : {
                            message: 'The UOM is required.',
                            validators: {
                                notEmpty: {
                                    message: 'The UOM is required.'
                                }
                            }
                        },
                        m_title: {
                            message: 'The measurement name is required.',
                            validators: {
                                notEmpty: {
                                    message: 'The measurement name is required.'
                                },
                                regexp: {
                                    regexp: /^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/,
                                    message: 'The template name can only consist of alphabets, numbers and spaces.'
                                }
                            }
                        }

                    }
                });
        }
    </script>
@endsection
