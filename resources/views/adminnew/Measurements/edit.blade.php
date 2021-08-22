@extends('layouts.adminnew')
@section('title','Edit measurements')
@section('section1')
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
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Measurement name</label>
                                <input type="text" name="m_title" class="form-control" value="{{ $measurements->m_title ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Units of measurement</label>
                                <div><span>Inches</span>  &nbsp; <input type="radio" name="uom" class="uom" value="in" @if($measurements->uom == 'in') checked @endif ></div>
                                <div><span>Centimeters</span>  &nbsp; <input type="radio" name="uom" class="uom" value="cm" @if($measurements->uom == 'cm') checked @endif ></div>
                            </div>
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

                                            <select name="measurement_value_in[]" >
                                                <option value="">Please select a value</option>
                                                @for($i=$vars->v_inch_min;$i<= $vars->v_inch_max;$i+=0.25)
                                                    <option value="{{ $i }}" @foreach($measurementValues as $mv) @if($mv->measurement_variable_id == $vars->id) @if($mv->measurement_value == $i) selected @endif @endif @endforeach >{{ $i }}</option>
                                                @endfor
                                            </select>
                                        @else
                                            <select name="measurement_value_in[]" >
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

                                                    <select name="measurement_value_cm[]" >
                                                        <option value="">Please select a value</option>
                                                        @for($i=$vars->v_cm_min;$i<= $vars->v_cm_max;$i+=0.5)
                                                            <option value="{{ $i }}" @foreach($measurementValues as $mv) @if($mv->measurement_variable_id == $vars->id) @if($mv->measurement_value == $i) selected @endif @endif @endforeach >{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                @else

                                                    <select name="measurement_value_cm[]" >
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




                <input type="submit" class="btn theme-btn btn-primary btn-sm pull-right" value="Update measurement">
            </form>
        </div>

    </div>
@endsection
@section('footerscript')
<style>
    .hide{
        display: none;
    }
</style>
<link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
<script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('resources/assets/selectize/selectize.css')}}">
<script type="text/javascript" src="{{asset('resources/assets/selectize/selectize.min.js')}}"></script>
    <script>
        $(function(){
            $('select').selectize();

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
                }).on('status.field.bv', function(e, data) {
                data.bv.disableSubmitButtons(false);
            }).on('success.form.bv', function(e) {
                e.preventDefault();
                var $form = $(e.target);
                var bv = $form.data('bootstrapValidator');

                var Data = $("#update-measurements").serializeArray();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("measurements.update") }}',
                    type : 'POST',
                    data : Data,
                    beforeSend : function (){
                        $(".loading").show();
                    },
                    success : function(response){
                        if(response.status == 'success'){
                            notification('fa-check','success','Measurement created successfully.','success');
                            setTimeout(function (){
                                location.reload();
                            },1500);
                        }else{
                            notification('fa-times','Error','Unable to create measurement.Try again','danger');
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

        });
    </script>
@endsection
