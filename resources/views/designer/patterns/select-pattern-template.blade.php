@extends('layouts.designerapp')
@section('title','Select template')
@section('content')
    <div class="pcoded-wrapper" id="dashboard">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <div class="page-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <!--<h5 class="theme-heading p-10"><span class="template_name" data-placement="right" data-pk="">Template name here</span></h5> -->
                                </div>
                                <div class="col-lg-6">
                                    <!-- <button type="button" id="preview" class="btn theme-btn pull-right btn-sm waves-effect m-b-10 m-t-10 m-r-20"><i class="fa fa-eye"></i> Preview</button> -->
                                    <a href="{{ route('my.patterns') }}" class="btn theme-btn pull-right btn-sm waves-effect m-b-10 m-t-10 m-r-20">Back to patterns</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="row">


                                            <div class="col-md-12">
                                                <ul class="nav nav-tabs md-tabs" role="tablist">
                                                    <li class="nav-item nav-tab1">
                                                        <a class="nav-link" data-toggle="tab" href="#P-details" role="tab" aria-selected="false">
                                                            <button class="btn theme-btn btn-icon-tab waves-effect waves-light">
                                                                <span id="tab-no1">1</span>
                                                            </button>Pattern details <i class="fa"></i></a>
                                                        <div class="slide"></div>
                                                    </li>
                                                    <li class="nav-item nav-tab3">
                                                        <a class="nav-link active" data-toggle="tab" href="#pi" role="tab" aria-selected="false"><button class="btn theme-btn btn-icon-tab waves-effect waves-light">
                                                                <span id="tab-no3">2</span>
                                                            </button>Pattern instructions <i class="fa"></i></a>
                                                        <div class="slide"></div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>


                                        <form id="pattern-template">
                                        <div class="tab-pane" id="pi" role="tabpanel">
                                            <div class="row">
                                                <div class="container" style="padding-top:20px;">
                                                    <div class="justify-content-center row">
                                                        <div class="col-lg-4">

                                                                <input type="hidden" name="pattern_id" value="{{ encrypt($pattern_id) }}">

                                                            <select name="template_id" id="template_id" class="form-control">
                                                                <option value="">Select template</option>
                                                                @if($templates->count() > 0)
                                                                    @foreach($templates as $temp)
                                                                        <option value="{{ encrypt($temp->id) }}">{{ ucfirst($temp->template_name) }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="template_id red"></span>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <a href="javascript:;" id="selectTemplate" class="btn theme-btn btn-sm">Select Template</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        </form>

                                        <div class="col-lg-12 m-t-15" id="templateData">
                                            <!-- load content here -->
                                        </div>

                                        <div class="m-t-20 hide" id="templateSubmitButton">
                                            <div class="col-sm-12">
                                                <div class="text-center m-b-10">
                                                    <button data-toggle="modal" data-target="#exampleModalLong" type="button" class="btn theme-btn btn-primary waves-effect waves-light m-l-10">Attach template to pattern</button>
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
	
	 <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Pattern type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Select pattern type</label>
                        <select name="pattern_type" id="pattern_type" class="form-control">
                            <option value="">Please select pattern type</option>
                            <option value="1">Shaped</option>
                            <option value="0">Un shaped</option>
                        </select>
                        <span class="pattern_type red"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="attachPatternTemplate" class="btn theme-btn btn-primary waves-effect
                    waves-light">Confirm</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footerscript')
    <link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/connect/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/summernote/summernote.min.css') }}" />

    <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('resources/assets/connect/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.js') }}"></script>
    <style>
        .hide{
            display: none;
        }
		#templateSubmitButton{
            position: absolute;
            right: 0px;
            top: 36px;
        }
    </style>
    <script>
        $(function (){
            $(".nav-tab1").find("a").prop("disabled", true).css({'cursor': 'not-allowed', 'opacity': '0.5'});

            $('.summernote').summernote({
                height: 150,
                callbacks: {
                    onFocus: function(e) {
                        //alert($(this).attr('id'));
                        if($(this).summernote('isEmpty')){
                            $(this).summernote('code','');
                        }
                    },
                    onChange: function(e) {
                        var id = $(this).attr('id');
                        validateDescription(id);
                    },
                    onPaste: function(e) {
                        var id = $(this).attr('id');
                        validateDescription(id);
                    }
                }
            });

            $("#template_id").select2({
                placeholder: "Please Select a template",
                allowClear: true
            });
			
			$('#template_id').on('select2:unselect', function (e) {
                var data = e.params.data;
                //console.log(data.text);
                $("#templateSubmitButton").addClass('hide');
                $("#selectTemplate").removeClass('hide');
				$("#templateData").html('');
            });

            $(document).on('click','#selectTemplate',function (){
                var template_id = $("#template_id").val();
                if(template_id == ""){
                    $(".template_id").html('The template name is required.');
                    return false;
                }else{
                    $(".template_id").html('');
                }

                var Data = 'template_id='+template_id;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("get.pattern.template") }}',
                    type : 'POST',
                    data : Data,
                    beforeSend : function (){
                        $(".loading").show();
                    },
                    success : function (res){
                        if(res.error){
                            $("#templateData").html('');
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: res.message
                            });
                        }
                        $("#templateData").html(res);
                        $("#templateSubmitButton").removeClass('hide');
						$("#selectTemplate").addClass('hide');
                        $("#templateData input,#templateData select, #templateData textarea").prop('disabled',true);
                        $(".hint2mention").each(function(){
                            $(this).summernote('disable');
                        });
                        var acc = $("#templateData .accordion");
                        acc.each(function(){
                            var target = $(this).attr('data-target');
                            if(!$(target).hasClass('show')){
                                $(target).addClass('show');
                            }
                        });
                    },
                    complete : function (){
                        setTimeout(function(){ $(".loading").hide();},1000);
                    },
                    error : function(jqXHR){
                        if(jqXHR.responseJSON.exception){
                            //alert('The data passed is invalid.');
                            $("#templateData").html('');
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'The data passed is invalid.'
                            });
                        }
                    }
                });
            });

            $(document).on('change','#template_id',function (){
                var value = $(this).val();
                if(value == ""){
                    $(".template_id").html('The template name is required.');
                }else{
                    $(".template_id").html('');
                }
            });


            $(document).on('click','#attachPatternTemplate',function (){
				var template_id = $("#template_id").val();
                if(template_id == ""){
                    $(".template_id").html('The template name is required.');
                    return false;
                }else{
                    $(".template_id").html('');
                }
				
				if(pattern_type == ''){
                    $(".pattern_type").html('The pattern type is required.');
                    return false;
                }else{
                    $(".pattern_type").html('');
                }
				
                var Data = $("#pattern-template").serializeArray();
				Data.push({name: 'pattern_type', value: pattern_type });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("attach.pattern.template") }}',
                    type : 'POST',
                    data : Data,
                    beforeSend : function (){
                        $(".loading").show();
                    },
                    success : function (res){
                        if(res.status == 'success'){
                            notification('fa-check','Yeah..','Template attached successfully.','success');
                            setTimeout(function (){ window.location.assign(res.url); },1000);
                        }
                    },
                    complete : function (){
                        setTimeout(function(){ $(".loading").hide();},1000);
                    },
                    error : function(jqXHR){
                        if(jqXHR.responseJSON.exception){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'The data passed is invalid.'
                            });
                        }
                    }
                });

            });

        });
    </script>
@endsection
