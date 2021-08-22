@extends('layouts.designerapp')
@section('title','My Patterns')
@section('content')
<div class="pcoded-wrapper">
<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
<!-- Page-body start -->
    <form id="formulas-form" method="POST" >
        <input type="hidden" name="pattern_id" value="{{ $patterns->id }}">
<div class="page-body">
<div class="row">
<div class="col-xl-12">
<label class="theme-heading f-w-600 m-b-20">Request output formula : {{ ucfirst($patterns->name) }} </label>
<button type="button"
    class="btn theme-btn btn-sm pull-right waves-effect"
    data-toggle="modal" data-target="#myModal2">Help</button>
<!-- To Do Card List card start -->
<div class="card">

<div class="card-block">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label">Output formula name<span class="red">*</span></label>
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="formula_name" name="formula_name" placeholder="Enter new formula name">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="form-label">List of input variable<span class="red">*</span></label>
                <div class="row">
                    <div class="col-md-12">
                        <select class="form-control fill select-factor" id="input_variables" name="input_variables[]" multiple >
                            @if($measurements->count() > 0)
                                @foreach($measurements as $meas)
                                    <option value="{{ $meas->id }}">{{ ucfirst($meas->variable_name) }}</option>
                                @endforeach
                            @endif
                        </select>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row first-row m-b-10" id="factor">
        <div class="col-lg-12 variables" id="variable1">
            <div class="grey-box">
                <div class="card-header accordion active col-lg-12 col-sm-12"
                     data-toggle="collapse" data-target="#section1">
                    <h5 class="card-header-text">Factor</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                </div>
                <div class="custom-card-block">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Factor name(Inches)</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="factor_name_inch" name="factor_name_inch" placeholder="Enter factor name">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Factor min value</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="min_value_in" name="min_value_in" placeholder="Enter min value">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Factor max value</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="max_value_in" name="max_value_in" placeholder="Enter max value">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Factor name(Cm)</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="factor_name_cm" name="factor_name_cm" placeholder="Enter factor name">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Factor min value</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="min_value_cm" name="min_value_cm" placeholder="Enter min value">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Factor max value</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="max_value_cm" name="max_value_cm" placeholder="Enter max value">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row first-row m-b-10" id="modifier">
        <div class="col-lg-12 variables" >
            <div class="grey-box">
                <div class="card-header accordion active col-lg-12 col-sm-12"
                     data-toggle="collapse" data-target="#section1">
                    <h5 class="card-header-text">Modifier</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                </div>
                <div class="custom-card-block">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Modifier name</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="modifier_name" name="modifier_name" placeholder="Enter modifier name">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Modifier min value</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="min_value" name="min_value" placeholder="Enter min value">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Modifier max value</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="max_value" name="max_value" placeholder="Enter max value">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row first-row" id="outputVariables">
        <div class="col-lg-12 variables" id="variable1">
            <div class="grey-box">
                <div class="card-header accordion active col-lg-12 col-sm-12"
                     data-toggle="collapse" data-target="#section1">
                    <h5 class="card-header-text">Output variable 1</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                </div>
                <div class="custom-card-block">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Output variable name<span class="red">*</span></label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="text" class="form-control" id="output_variable_name" name="output_variable_name[]" placeholder="Enter output variable name">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Add formula<span class="red">*</span></label>
                                <div class="row">
                                    <div class="col-md-12">
                                    <textarea class="form-control" cols="60%" placeholder="Formula details" id="formula" name="formula[]"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Add comment</label>
                                <div class="row">
                                    <div class="col-md-12">
                                    <textarea class="form-control" cols="60%" placeholder="Comments" id="comments" name="comments[]"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-lg-12 text-center m-t-10" id="button-row">
            <button type="button" id="addMore" class="btn theme-btn waves-effect Go">Add more</button>
        </div>
    </div>
</div>

</div>
</div>

</div>
<div class="col-lg-12 text-center">
<button type="button"
class="btn theme-outline-btn waves-effect m-b-10 m-t-10 m-r-20">Cancel</button>
<button type="submit"  class="btn theme-btn waves-effect m-b-10 m-t-10 m-r-20" id="save-btn" >Submit request</button>
</div>
</div>
</form>
</div>


<!-- Page-body end -->
</div>
</div>
</div>
</div>


<div class="modal fade" id="myModal2" role="dialog" >
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Request output formula</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="payment-box">

                    <div class="card">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group m-b-0">
                                        <label class="col-form-label">Output formula name
                                        </label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="f-14 m-b-0">No of stitches to cast on</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-form-label">List of input variable
                                        </label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <p class="f-14">Lower edge circumference,Waist,Bust,Ease,Stitch gauge</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row first-row">
                                <div class="col-lg-12">
                                    <div class="grey-box">
                                        <div class="card-header accordion active col-lg-12 col-sm-12" data-toggle="collapse" data-target="#section1">
                                            <h5 class="card-header-text">Output variable 1
                                            </h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                                        </div>
                                        <div class="custom-card-block">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Output
                                                            variable name
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <p class="f-14 m-b-0">NO_OF_STITCHES_TO_CAST_ON</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group m-b-0">
                                                        <label class="col-form-label">Add
                                                            formula
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <p class="f-14">CO [[NO_OF_STITCHES_TO_CAST_ON]] Stitches.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row first-row m-t-10">
                                <div class="col-lg-12">
                                    <div class="grey-box">
                                        <div class="card-header accordion active col-lg-12 col-sm-12" data-toggle="collapse" data-target="#section1">
                                            <h5 class="card-header-text">Output variable 2
                                            </h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                                        </div>
                                        <div class="custom-card-block">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group m-b-0">
                                                        <label class="col-form-label">Output
                                                            variable name
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <p class="f-14 m-b-0">NO_OF_STITCHES_TO_CAST_ON</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label">Add
                                                            formula
                                                        </label>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <p class="f-14">CO [[NO_OF_STITCHES_TO_CAST_ON]] Stitches.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footerscript')
    <style>
        .red{
            color: #c14d7d;
            font-weight: bold;
        }
        .help-block {
            display: block;
            margin-top: 5px;
            *margin-bottom: 10px;
            color: #bc7c8f;
            font-weight:bold;
        }
    </style>
    <link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/connect/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('resources/assets/connect/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>
    <script>
        $(function (){
            var $validations = $('#formulas-form');

            $("#input_variables").select2({
                placeholder: "Select input variables",
                allowClear: true
            });

            $(document).on('click','#addMore',function (){
                var variableLength =$(".variables").length;
                var prevId = variableLength;
                var nextId = variableLength + 1;
                //alert(variableLength+' - '+prevId+' - '+ nextId);
               var data = '<div class="col-lg-12 variables m-t-15" id="variable'+nextId+'">\n' +
                   '            <div class="grey-box">\n' +
                   '                <div class="card-header accordion active col-lg-12 col-sm-12"\n' +
                   '                     data-toggle="collapse" data-target="#section1">\n' +
                   '                    <h5 class="card-header-text">Output variable '+nextId+'</h5><a href="javascript:;" data-id="'+nextId+'" data-server="false" data-j="'+nextId+'" class="pull-right fa fa-trash deleteOutput" id="delete'+nextId+'"></a>\n' +
                   '                </div>\n' +
                   '                <div class="custom-card-block">\n' +
                   '                    <div class="row">\n' +
                   '                        <div class="col-md-4">\n' +
                   '                            <div class="form-group">\n' +
                   '                                <label class="form-label">Output variable name<span class="red">*</span></label>\n' +
                   '                                <div class="row">\n' +
                   '                                    <div class="col-md-12">\n' +
                   '                                        <input type="text" class="form-control" id="output_variable_name" name="output_variable_name[]" placeholder="Enter output variable name">\n' +
                   '                                    </div>\n' +
                   '                                </div>\n' +
                   '                            </div>\n' +
                   '                        </div>\n' +
                   '                    </div>\n' +
                   '                    <div class="row">\n' +
                   '                        <div class="col-md-6">\n' +
                   '                            <div class="form-group">\n' +
                   '                                <label class="form-label">Add formula<span class="red">*</span></label>\n' +
                   '                                <div class="row">\n' +
                   '                                    <div class="col-md-12">\n' +
                   '                                    <textarea class="form-control" cols="60%" placeholder="Formula details" id="formula" name="formula[]"></textarea>\n' +
                   '                                    </div>\n' +
                   '                                </div>\n' +
                   '                            </div>\n' +
                   '                        </div>\n' +
                   '                        <div class="col-md-6">\n' +
                   '                            <div class="form-group">\n' +
                   '                                <label class="form-label">Add comment</label>\n' +
                   '                                <div class="row">\n' +
                   '                                    <div class="col-md-12">\n' +
                   '                                    <textarea class="form-control" cols="60%" placeholder="Comments" id="comments" name="comments[]"></textarea>\n' +
                   '                                    </div>\n' +
                   '                                </div>\n' +
                   '                            </div>\n' +
                   '                        </div>\n' +
                   '                    </div>\n' +
                   '                </div>\n' +
                   '            </div>\n' +
                   '        </div>';

               $("#outputVariables").append(data);
                $("#delete"+prevId).removeClass('fa-trash')
                $validations.bootstrapValidator('addField', 'output_variable_name[]');
                $validations.bootstrapValidator('addField', 'formula[]');
            });

            /* form validations */


            $validations.find('[name="input_variables[]"]')
                .select2({
                    placeholder: "Select input variables",
                    allowClear: true
                })
                .change(function(e) {
                    $validations.data('bootstrapValidator').validateField('input_variables');
                })
                .end();

            $validations.bootstrapValidator({
                excluded: [':disabled'],
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: '', //fa fa-check
                    invalid: '', //fa fa-exclamation
                    validating: 'fa fa-spinner fa-spin'
                },
                fields: {
                    formula_name: {
                        message: 'The formula name is required.',
                        validators: {
                            notEmpty: {
                                message: 'The formula name is required.'
                            },
                            regexp: {
                                regexp: /^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/,
                                message: 'The formula name should have only alphabets, numbers and spaces.'
                            }
                        }
                    },
                    'input_variables[]': {
                        message: 'The input variables are required.',
                        validators: {
                            notEmpty: {
                                message: 'The input variables are required.'
                            }
                        }
                    },
                    'output_variable_name[]': {
                        message: 'The output variable is required.',
                        validators: {
                            notEmpty: {
                                message: 'The output variable is required.'
                            }
                        }
                    },
                    'formula[]': {
                        message: 'The formula is required.',
                        validators: {
                            notEmpty: {
                                message: 'The formula is required.'
                            }
                        }
                    }

                }
            }).on('status.field.bv', function(e, data) {
                data.bv.disableSubmitButtons(false);
            }).on('error.field.bv', function(e, data) {

            }).on('success.form.bv', function(e,data) {
                e.preventDefault();

                var Data = $validations.serializeArray();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $(".loading").show();
                $.post('{{ route("designer.add.new.formula") }}',Data)
                .done(function(res){
                    $(".loading").hide();
                    notification('fa-check','Yeah..','Formula submitted successfully.','success');
                    setTimeout(function (){ window.location.assign(res.url) },1500);
                })
                .fail(function(xhr, status, error) {
                    $(".loading").hide();
                    notification('fa-times','Oops..',error,'danger');
                });
            });


            $(document).on('click','.deleteOutput',function (){
                var id = $(this).attr('data-id');
                var j = $(this).attr('data-j');
                var server = $(this).attr('data-server');
                var len = $(".variables").length;
                var prevId = len - 1;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value == true) {
                        $(".loading").show();
                        $("#variable"+j).remove();
                        if(prevId != 1){
                            $("#delete"+prevId).addClass('fa-trash');
                        }
                        notification('fa-check','Yeah..','Output variable deleted successfully.','success');
                        setTimeout(function (){ $(".loading").show(); },1000);
                    }
                });
            });

        });



    </script>
@endsection
