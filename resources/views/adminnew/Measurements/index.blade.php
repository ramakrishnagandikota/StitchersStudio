@extends('layouts.adminnew')
@section('title','Measurements')
@section('section1')
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6">
                <h5 class="theme-heading p-10">Measurements</h5>
            </div>
        </div>
        <div class="card p-20">
            <div class="dt-responsive table-responsive">
                <table id="example2"
                       class="table table-striped table-bordered nowrap">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Measurement Profile</th>
                        <th>Created at</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($measurements->count() > 0)
                        @foreach($measurements as $meas)
                            <tr>
                                <th>{{$meas->id}}</th>
                                <td>{{$meas->m_title}}</td>
                                <td>{{date('d-m-Y',strtotime($meas->created_at))}}</td>
                                <td>{{$meas->status == 1 ? 'Active' : 'In Active' }}</td>
                                <td>
                                    <a href="{{ url('adminnew/measurements/'.base64_encode($meas->id).'/show') }}"><i class="fa fa-edit edit-btn m-r-5" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"></i></a>
                                    <!--<a href="javascript:;"><i class="fa fa-copy copy-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Copy"></i></a> -->
                                    <a href="javascript:;" class="deleteMeasurements" data-id="{{$meas->id}}"><i class="fa fa-trash delete-btn" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" ></i></a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div class="modal fade" id="summernoteModal" role="dialog">
        <div class="modal-dialog modal-md">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Measurement</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="tab-content card-block">
                                <div class="tab-pane active" id="Newone" role="tabpanel">
                                    <form id="create-template" method="POST" action="{{route("create.measurement.profile")}}">
                                        @csrf
                                        <label class="col-sm-12 form-label m-t-15">Measurement Name<span class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="m_title" id="m_title" placeholder="Enter measurement name">
                                        </div>

                                        <label class="col-sm-12 form-label m-t-15">UOM<span class="text-danger">*</span></label>
                                        <div class="col-sm-12">
                                            <input type="radio" name="uom" id="uom" value="in" > Inches
                                            <input type="radio" name="uom" id="uom1" value="cm" > Centimeters
                                        </div>

                                        <div class="modal-footer">
                                            <button data-dismiss="modal" class="btn theme-outline-btn" >Close</button>
                                            <button type="submit" id="submit" class="btn theme-btn" id="createMeasurement" >Create</button>
                                        </div>
                                    </form>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal -->
@endsection
@section('footerscript')
    <style>
        .dataTables_filter .form-control{margin-top: 0px;}
        .radio-btn{display: table;margin: 0 auto;top: -7px;}
        .table td, .table th {
            padding: 0.55rem 0.75rem;
            font-size: 14px;
        }
        .hide{
            display: none;
        }
        .modal-footer{
            padding: 0px !important;
            padding-top:1rem !important;
            border:0px !important;
        }
        .help-block {
            display: block;
            margin-top: 5px;
            *margin-bottom: 10px;
            color: #bc7c8f;
            font-weight:bold;
        }
        small, .small {
            font-size: 85%;
        }
        #example2_filter label:nth-child(1){
            float:right;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
    <link rel="stylesheet" type="text/css" HREF="{{ asset('resources/assets/files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/pages/data-table/css/buttons.dataTables.min.css') }}">
    <!-- data-table js -->
    <script src="{{ asset('resources/assets/files/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/data-table/js/jszip.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/data-table/js/pdfmake.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/data-table/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/jszip.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/vfs_fonts.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/bower_components/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/bower_components/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('resources/assets/files/assets/pages/data-table/extensions/buttons/js/extension-btns-custom.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
    <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('resources/assets/select2/select2.min.css') }}" >
    <script src="{{ asset('resources/assets/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('resources/assets/select2/select2-searchInputPlaceholder.js') }}"></script>

    <script>
        $(document).ready(function () {

            $('#example2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    'csvHtml5',
                    'pdfHtml5',
                ],
            });

            setTimeout(function(){
                var mybutton = $('<button style="font-size:14px;border-radius:2px" class="btn-sm theme-btn waves-effect waves-light btn-info pull-right createTemplate" > Create new</button>');
                $('#example2_filter').append(mybutton);
            },1000);

            $(document).on('click','.createTemplate',function(){
                var options = {
                    backdrop: 'static',
                    keyboard: false
                };
                $("#summernoteModal").modal(options);
            });



            $('#create-template')
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
                                remote: {
                                    url: '{{ route("check.measurement.name") }}',
                                    message: 'The template name is already in use. Please enter another one.'
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

                var Data = $("#create-template").serializeArray();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("create.measurement.profile") }}',
                    type : 'POST',
                    data : Data,
                    beforeSend : function (){
                        $(".loading").show();
                    },
                    success : function(response){
                        if(response.status == 'success'){
                            notification('fa-check','success','Measurement created successfully.','success');
                            setTimeout(function (){
                                window.location.assign(response.URL);
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



            $(document).on('click','.deleteTemplate',function(){
                var template_id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Are you sure ?',
                    text: "You want to delete the template",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url : '{{ route("delete.pattern.template") }}',
                            type : 'POST',
                            data : 'template_id='+template_id,
                            beforeSend : function(){
                                $(".loading").show();
                            },
                            success : function(res){
                                if(res.status == 'success'){
                                    setTimeout(function(){ location.reload(); },1500);
                                    Swal.fire(
                                        'Deleted!',
                                        'The template has been deleted.',
                                        'success'
                                    );

                                }else{
                                    Swal.fire(
                                        'Oops!',
                                        'Unable to delete template,Try again later.',
                                        'danger'
                                    );
                                }
                            },
                            complete : function(){
                                $(".loading").hide();
                            },
                            error : function (jqXHR,testStatus){
                                console.log("Error"+ testStatus);
                            }
                        })

                    }
                });
            });


        });
    </script>
@endsection
