@extends('layouts.adminnew')
@section('title','Pattern specific measurements')
@section('section1')
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6">
                <h5 class="theme-heading p-10">Pattern specific measurements</h5>
            </div>
        </div>
        <div class="card p-20">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                @if(Session::has('success'))
                    <div class="alert alert-success">{{ Session::get('success') }}</div>
                @endif

                @if(Session::has('error'))
                    <div class="alert alert-danger">{{ Session::get('error') }}</div>
                @endif
            <div class="dt-responsive table-responsive">
                <form method="POST" action="{{ route('add.pattern.specific.measurements') }}">
                    @csrf
                <table id="" class="table table-striped table-bordered nowrap">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Inches</th>
                            <th>Cm</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if($measurementVariables->count() > 0)
                            <?php $i=1; ?>
                            @foreach($measurementVariables as $ms)
                                <?php
                                $mname = str_replace('_',' ',ucfirst($ms->variable_name));
                                ?>
                                <tr class="trs" id="trs{{$i}}">
                                    <td>{{$i}}<input type="hidden"  value="{{$ms->id}}"></td>
                                    <td><input type="text"  class="form-control" placeholder="Measurement Name" value="{{$mname}}" ></td>
                                    <td><input type="text"  class="form-control" value="{{$ms->variable_description}}" placeholder="Measurement Notes"></td>
                                    <td>
                                        <div class="row">
                                        <!-- <div class="col-md-9">
                                              <input type="file" id="uploadImage{{$i}}" class="uploadImage" data-id="{{$i}}" ><input type="hidden" id="measurement_image{{$i}}">
                                            </div> -->
                                            <div class="col-md-3"><span class="mytooltip tooltip-effect-2"> <span class="tooltip-item">?</span> <span class="tooltip-content clearfix"> <img src="{{asset($ms->variable_image) }}" />  <span class="tooltip-text">{{ucfirst($ms->variable_description)}}</span></span> </span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><input type="number" readonly="readonly" min="0" class="form-control" placeholder="Min value" value="{{ $ms->v_inch_min }}">
                                        <input type="number" readonly="readonly"  class="form-control" min="0" placeholder="Max value" value="{{ $ms->v_inch_max }}"></td>
                                    <td><input type="number" readonly="readonly"  min="0" class="form-control" placeholder="Min value" value="{{ $ms->v_cm_min }}">
                                        <input type="number" readonly="readonly"  class="form-control" min="0" placeholder="Max value" value="{{ $ms->v_cm_max }}"></td>
                                </tr>
                                <?php $i++; ?>
                        @endforeach
                    @endif

                        <tr class="trs" id="trs1">
                            <td>{{ $measurementVariables->count() +1 }} <input type="hidden" name="measurement_id" value="0"></td>
                            <td><input type="text" name="variable_name" class="form-control @error('variable_name') is-invalid @enderror" value="" placeholder="Measurement Name" ></td>
                            <td><input type="text" name="variable_description" class="form-control" value="" placeholder="Measurement Notes"></td>
                            <td><input type="file" id="uploadImage1" class="uploadImage" data-id="1" >
                                <input type="hidden" name="variable_image" id="variable_image1" ></td>
                            <td><input type="number" name="v_inch_min" min="0" class="form-control @error('v_inch_min') is-invalid @enderror" placeholder="Min value">
                                <input type="number" name="v_inch_max" class="form-control @error('v_inch_max') is-invalid @enderror" min="0" placeholder="Max value"></td>
                            <td><input type="number" name="v_cm_min" min="0" class="form-control @error('v_cm_min') is-invalid @enderror" placeholder="Min value">
                                <input type="number" name="v_cm_max" class="form-control @error('v_cm_max') is-invalid @enderror" min="0" placeholder="Max value"></td>
                        </tr>
                    </tbody>

                </table>

                    <div class="form-group">
                        <button class="btn theme-btn pull-right" type="submit">Add new variable</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


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
        input[type="file"] {
            display: block !important;
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

            $(document).on('change', '.uploadImage', function(){
                var id = $(this).attr('data-id');
                var name = $('input[type=file]').val().split('\\').pop();
                var form_data = new FormData();
                var ext = name.split('.').pop().toLowerCase();
                if(jQuery.inArray(ext, ['gif','png','jpg','jpeg']) == -1)
                {
                    alert("Invalid Image File");
                }
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("uploadImage"+id).files[0]);
                var f = document.getElementById("uploadImage"+id).files[0];
                var fsize = f.size||f.fileSize;
                if(fsize > 2000000)
                {
                    alert("Image File Size is very big");
                }
                else
                {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    form_data.append("file", document.getElementById("uploadImage"+id).files[0]);
                    $.ajax({
                        url:"{{url('admin/upload-image')}}",
                        method:"POST",
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend:function(){
                            $('.loading').show();
                        },
                        success:function(data)
                        {
                            if(data){
                                $("#variable_image"+id).val(data.path);
                            }
                        },
                        complete : function(){
                            $('.loading').hide();
                        }
                    });
                }
            });

        });
    </script>
@endsection
