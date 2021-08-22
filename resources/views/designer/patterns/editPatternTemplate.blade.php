@extends('layouts.designerapp')
@section('title',$template->template_name)
@section('content')
    <div class="pcoded-wrapper" id="dashboard">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6">
                <h5 class="theme-heading p-10"><span class="template_name" data-placement="right" data-pk="{{ $template->id }}">{{$template->template_name}}</span></h5></div>
            <div class="col-lg-6">
                <button type="button" id="preview" class="btn theme-btn pull-right btn-sm waves-effect m-b-10 m-t-10 m-r-20"><i class="fa fa-eye"></i> Preview</button>
                <a href="{{ url('designer/formula-requests') }}" class="btn theme-btn pull-right btn-sm waves-effect m-b-10 m-t-10 m-r-20">Request new formula</a>
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
                    <!-- section data start -->
                    <div id="section-data" class="p-10">
                        <!--<div class="js-form-status-holder">Auto save form message will show here</div>-->
                        <form class="form" id="description" method="POST" action="{{ route('designer.template.pattern.add.data') }}">
                            @csrf
                            <input type="hidden" name="fname" value="description">
                            <input type="hidden" name="id" value="{{ base64_encode($id) }}" >
                            <div class="row theme-row m-b-10">
                                <div class="card-header accordion active col-lg-12 col-sm-12" data-toggle="collapse" data-target="#PTsection1">
                                    <h5 class="card-header-text">Project Information</h5><i class="icon fa fa-caret-down pull-right micro-icons"></i> </div>
                            </div>
                            <div class="card-block collapse" id="PTsection1">
                                <textarea name="description" id="summernoteDescription" class="hint2mention summernoteDescription" required="required">{!! $template->description !!}</textarea>
                                <div class="row">
                                    <div class="col-lg-12"><button type="button" class="btn theme-btn btn-sm pull-right m-t-10 submitButton" data-id="description" >Save</button></div>
                                </div>
                            </div>
                        </form>




                    <!-- <form class="form" id="materials" method="POST" action="{{ route('template.pattern.add.data') }}">
                    @csrf
                        <input type="hidden" name="fname" value="materials">
                        <input type="hidden" name="id" value="{{ base64_encode($id) }}" >
                    <div class="row theme-row m-b-10">
                        <div class="card-header accordion active col-lg-12 col-sm-12" data-toggle="collapse" data-target="#PTsection2">
                            <h5 class="card-header-text">Materials</h5><i class="icon fa fa-caret-down pull-right micro-icons"></i> </div>
                    </div>
                    <div class="card-block collapse" id="PTsection2">
                        <textarea name="materials" class="hint2mention summernote" required="required">{!! $template->materials !!}</textarea>
                        <div class="row">
                            <div class="col-lg-12"><button type="button" class="btn theme-btn btn-sm pull-right m-t-10 submitButton" data-id="materials">Save</button></div>
                        </div>
                    </div>
                </form> -->

                    <!--      <form class="form" id="techniques" method="POST" action="{{ route('template.pattern.add.data') }}">
                    @csrf
                        <input type="hidden" name="fname" value="techniques">
                        <input type="hidden" id="template_id" name="id" value="{{ base64_encode($id) }}" >
                    <div class="row theme-row m-b-10">
                        <div class="card-header accordion active col-lg-12 col-sm-12" data-toggle="collapse" data-target="#PTsection3">
                            <h5 class="card-header-text">Techniques</h5><i class="icon fa fa-caret-down pull-right micro-icons"></i> </div>
                    </div>
                    <div class="card-block collapse" id="PTsection3">
                        <textarea name="techniques" class="hint2mention summernote" required="required" >{!! $template->techniques !!}</textarea>
                        <div class="row">
                            <div class="col-lg-12"><button type="button" class="btn theme-btn btn-sm pull-right m-t-10 submitButton" data-id="techniques">Save</button></div>
                        </div>
                    </div>

                </form> -->



                        <section id="loadingSections">
                            <h4 class="text-center">Please wait..Loading sections</h4>
                        </section>

                        <section id="newSection">

                        </section>


                    </div>
                    <!-- section data ends here -->


                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <button class="btn theme-btn btn-sm waves-effect m-b-20" data-toggle="modal" data-target="#sectionModal"><i class="fa fa-plus"></i> Add Section</button>
                        </div>
                    </div>
                    <br>

                    <?php
                    $status = $pattern->workStatus()->leftJoin('work_status','work_status.id','p_pattern_work_status.w_status')->select('work_status.name')->where('p_pattern_work_status.w_status',3)->orderBy('p_pattern_work_status.id','DESC')->first();

                    $status1 = $pattern->workStatus()->leftJoin('work_status','work_status.id','p_pattern_work_status.w_status')->select('work_status.name')->where('p_pattern_work_status.w_status',4)->orderBy('p_pattern_work_status.id','DESC')->first();
                    ?>

                    @if(!$status)
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <button class="btn theme-btn btn-sm waves-effect m-b-20 changeStatus" data-status="3" data-id="{{ encrypt($template->patterns()->first()->id) }}" ><i class="fa fa-bug"></i> Move pattern to testing</button>
                            </div>
                        </div>
                    @endif

                    @if($status)
                        @if(!$status1)
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <button class="btn theme-btn btn-sm waves-effect m-b-20 changeStatus" data-status="4" data-id="{{ encrypt($template->patterns()->first()->id) }}" ><i class="fa fa-check"></i> Move pattern to complete</button>
                                </div>
                            </div>

                        @endif
                    @endif



                </div>
            </div>
        </div>
    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- pattern template preview -->

    <!-- [ chat user list ] start -->
    <!-- <button type="button" class="btn theme-btn-pink btn-sm displayChatbox" id="showPreview"><i class="fa fa-eye"></i> Preview</button> -->
    <div id="sidebar" class="users preview-box-parent showTemplate">
        <div class="had-container">
            <div class="p-fixed users-main preview-box">
                <div class="user-box">
                    <div class="chat-search-box">
                        <a href="javascript:;" class="closePreview pull-right">
                            <i class="feather icon-x"></i>
                        </a>
                        <div class="right-icon-control">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card" style="box-shadow:none!important">

                                        <div id="templatePreview"  class="p-10"> <!-- id="section-data" -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="main-friend-list" >

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ chat user list ] end -->

    <!-- pattern template preview -->



    <!-- section modal starts -->
    <div class="modal fade" id="sectionModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Section</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="create-section">
                        <div class="form-group row" >
                            <label class="col-sm-12 form-label">Section Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="section_name" id="section_name" placeholder="Enter Section name">
                                <input type="hidden" id="error_count" value="0">
                            </div>
                            <!-- <label class="col-sm-12 col-form-label">Description</label> -->
                            <!-- <div class="col-sm-12">
                               <input type="text" class="form-control" id="AddTitle">
                               <p class="Error">Please Enter Title</p>
                            </div> -->
                        </div>
                        <!-- <div id="summernote" class="hint2mention"><p>Hello Summernote</p></div>
                      </div> -->
                        <div class="modal-footer">
                            <button type="button" class="btn theme-outline-btn" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn theme-btn"  >Create</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <input type="hidden" id="pattern_template_id" value="{{ $id }}" >
    <!-- section modal ends -->

    <!-- preview -modal -->

    <div class="modal fade" id="previewModal" role="dialog">
        <div class="modal-dialog modal-sm">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Select measurement profile</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="create-section">
                        <div class="form-group row" >
                            <label class="col-sm-12 form-label">Measuremet profile</label>
                            <div class="col-sm-12">
                                @if($measurements->count() > 0)
                                    <select id="measurement_id" name="measurement_id" class="form-control">
                                        <option value="0">Select a measurement profile</option>
                                        @foreach($measurements as $meas)
                                            <option value="{{ $meas->id }}">{{ $meas->m_title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger measurement_id"></span>

                                @else
                                    <p class="text-center">There are no measurment profiles in your account.</p>
                                @endif
                            </div>
                        </div>
                    </form>
                    @if($measurements->count() > 0)
                    <div class="modal-footer">
                        <button type="button" class="btn theme-outline-btn" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn theme-btn previewTemplate" data-template-id="{{$id}}">Preview template</button>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

	
	<!-- error moddal -->
    <div class="modal fade" id="errorModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Error Message</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div id="dialog" class="alert alert-danger"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn theme-outline-btn" data-dismiss="modal">Close</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <!-- error modal -->


    <!-- comment box --

    <div class="row">
        <div id="comment-sidebar" class="users comment-sidebar">
            <div class="had-container">
                <div class="p-fixed users-main">
                    <div class="user-box">
                        <div class="chat-search-box">
                            <a class="close-commentbox" class="closebtn" onclick="closecommentbar()">
                                <i class="feather icon-x"></i>
                            </a>
                        </div>
                        <div class="slimScrollDiv m-l-10 m-r-10">
                            <div class="main-friend-list">
                                <h5 class="theme-heading">Notes </h5>
                                <section id="task-container" class="comment-task-box">

                                </section>
                                <div class="form-material m-t-30">
                                    <div class="right-icon-control">
                                        <form class="form-material">
                                            <div class="form-group form-primary">
                                                <input type="text" name="task-insert" class="form-control" required="">
                                                <span class="form-bar"></span>
                                                <label class="float-label">Create your notes</label>
                                            </div>
                                        </form>
                                        <div class="form-icon ">
                                            <button class="btn btn-success theme-btn btn-icon  waves-effect waves-light" id="create-task">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button data-toggle="modal" data-dismiss="modal" data-target="#child-Modal" class="btn btn-sm theme-outline-btn m-b-0" type="button">Clear all notes</button>
                                    </div>
                                </div>

                                <!-- To Do Card List card end --
                            </div>
                            <div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 498px;"></div>
                            <div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<div>
            <a class="open-commentbox openbtn" id="commentBox" onclick="opencommentbar()">
                <i class="fa fa-pencil-square-o"></i>
            </a>
        </div> --
    </div>
    <!-- comment box -->
    <!-- preview modal -->

    <div class="progress" id="progressbar" style="position: fixed;top: 50px;display: none;">
        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    @php
        $array = array();

        for($i=0;$i<count($output_variables);$i++){
            $array[] = array_values((array)$output_variables[$i]->variable_name);
        }
    /*
        for ($j=0;$j<count($array);$j++){ if($j === count($array) - 1){ echo "'".$array[$j][0]."'"; }else{ echo "'".$array[$j][0]."',"; } } */


        $var = '"TITLE","UOM",';
        $me = 0;
        foreach($mvariables as $mea){
            $var_name = strtoupper($mea->variable_name);
            $v_name = str_replace(' ','_',$var_name);

            if($me == $mvariables->count() - 1){
                 $var.= '"'.$v_name.'"';
            }else{
                 $var.= '"'.$v_name.'",';
            }
            $me++;
        }
    @endphp

@endsection
@section('footerscript')
    <style>
        .highlight-colour{
            color: blue;
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
        .fa-trash{
            background-color: #dbdbdb !important;
        }
        .theme-light-row{
            padding: 4px;
            border-radius: 3px;
            background-color: #dadada;
        }
        .back_friendlist{
            z-index: 1;
        }
        .editable-container{
            position: absolute;
            background: #fff;
            top: -35px;
            padding: 7px;
            margin-top: -7px;
        }
        .editable-input > span.editable-clear-x{
            margin-top: -7px !important;
        }
        span.editable-container:after {
            content: '';
            position: absolute;
            left: 5px;
            bottom: -9px;
            margin: 0 auto;
            width: 0;
            height: 0px;
            border-top: 9px solid #fff;
            border-left: 9px solid transparent;
            border-right: 9px solid transparent;
        }
        .delete-yarn-details{
            position: absolute;
            right: 0px;
            top: 0;
        }
        .add-yarn-detail{
            position: absolute;
            right: 0px;
            top: 0px;
        }
        .conditionAccordionDisable a{
            pointer-events: none;
            opacity: 0.5;
        }
        a.yarnUrl{
            color: #0d665c !important;
            text-decoration: underline;
        }
        .open-commentbox{
            z-index: 10000 !important;
        }
        .sectionNotes{
            position: absolute;
            top: 13px;
            right: 55px;
            color: #0d665c;
        }
        .editable-container{
            z-index: 10000 !important;
        }
        .chat-search-box{
            height: 100%;
            overflow-y: scroll;
        }
        .closePreview{
            position: relative;
            z-index: 100000;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/summernote/summernote.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>

    <script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.min.js') }}"></script>
    <script src="{{ asset('node_modules/jquery.auto-save-form/jQuery.auto-save-form.js') }}"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('resources/assets/select2/select2.min.css') }}" >
    <script src="{{ asset('resources/assets/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('resources/assets/select2/select2-searchInputPlaceholder.js') }}"></script>


    <link href="{{ asset('node_modules/X-editable/dist/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet">
    <script src="{{ asset('node_modules/X-editable/dist/bootstrap3-editable/js/bootstrap-editable.js') }}"></script>

    <script src="{{ asset('resources/assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('resources/assets/ckeditor/adapters/jquery.js') }}"></script>
    <script>
        $(function(){
            getAllSections();
            summerNote();

            $(".nav-tab1").find("a").prop("disabled", true).css({'cursor': 'not-allowed', 'opacity': '0.5'});

           // $(".editable-submit").find('i').removeClass('fa-caret-down');
           // $(".editable-submit").find('i').removeClass('fa-caret-down');

            $('.template_name').editable({
                mode: 'inline',
                type: 'text',
                url: '{{route("designer.update.template.name")}}', // Send ajax request with new value on /post
                title: 'Enter Section Name'
            });

            $('[data-toggle="tooltip"]').tooltip();

            $('#create-section')
                .bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {
                        section_name: {
                            message: 'The section name is required.',
                            validators: {
                                notEmpty: {
                                    message: 'The section name is required.'
                                },
                                remote: {
                                    message: 'The section name is already in use. Please enter another one.',
                                    url: '{{ route("designer.check.section.name") }}',
                                    data:{
                                        'section_name' : $("#section_name").val(),
                                        'pattern_template_id' : $("#pattern_template_id").val()
                                    }
                                },
                                regexp: {
                                    regexp: /^([a-zA-Z0-9]+\s)*[a-zA-Z0-9]+$/,
                                    message: 'The section name can only consist of alphabets, numbers and spaces.'
                                }
                            }
                        }

                    }
                }).on('status.field.bv', function(e, data) {
                data.bv.disableSubmitButtons(false);
            }).on('success.form.bv', function(e) {
                e.preventDefault();

                var section_name = $("#section_name").val();
                var pattern_template_id = $("#pattern_template_id").val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route("designer.template.pattern.add.section") }}',
                    type: 'POST',
                    data: 'section_name='+section_name+'&pattern_template_id='+pattern_template_id,
                    beforeSend: function(){
                        $(".loading").show();
                    },
                    success: function(res){
                        if(res.status == 'success'){
                            getNewSection();
                            $("#sectionModal").modal('hide');
                            notification('fa-check','success','Section created successfully.','success');
                            $("#section_name").val('');
                        }else{
                            notification('fa-times','Error','Error in creating section.','danger');
                        }
                    },
                    complete: function(){
                        setTimeout(function(){
                            $(".loading").hide();
                        },1000);
                    },
                    error: function(){
                        notification('fa-times','Error','Error in creating section.','danger');
                    }
                });

            });

            $(document).on('change','.select-formula',function (){

                var did = $(this).attr('data-id');
                var value = $(this).val();
                var section_id = $(this).attr('data-section-id');
                var pattern_template_id = $("#pattern_template_id").val();
                var count = $(this).attr('data-count');
                var Data = 'function_id='+value+'&section_id='+section_id+'&did='+did+'&pattern_template_id='+pattern_template_id+'&dataCount='+count+'&again=0';


                if(value == ""){
                    return false;
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("designer.get.function.attributes") }}',
                    type : 'POST',
                    data: Data,
                    beforeSend : function (){
                        $(".loading").show();
                    },
                    success : function (res){
                        if(res.status == 'error'){
                            $("#select"+section_id).val("");
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: res.message
                            });

                            /* Swal.fire({
                                 title: 'Are you sure?',
                                 text: res.message,
                                 icon: 'warning',
                                 showCancelButton: true,
                                 confirmButtonColor: '#3085d6',
                                 cancelButtonColor: '#d33',
                                 confirmButtonText: 'Yes'
                             }).then((result) => {
                                 if (result.value == true) {


                                     //console.log('result confirmed');
                                     var Data = 'function_id='+value+'&section_id='+section_id+'&did='+did+'&pattern_template_id='+pattern_template_id+'&dataCount='+count+'&again=1';

                                     $.ajaxSetup({
                                         headers: {
                                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                         }
                                     });

                                     $.ajax({
                                         url: '{{ route("get.function.attributes") }}',
                                        type: 'POST',
                                        data: Data,
                                        beforeSend: function () {
                                            $(".loading").show();
                                        },
                                        success : function (res){
                                            $("#snippet"+count).html(res);
                                            summerNote();
                                        },
                                        complete : function(){
                                            $(".loading").hide();
                                        },
                                        error : function (){

                                        }

                                    });
                                }else{
                                    //console.log('result not confirmed');
                                    $("#select"+section_id).val("");
                                }
                            }) */
                        }else if(res.status == 'parent_error') {

                            $("#select"+section_id).val("");
                            var data = res.parentFunction;
                            var array = [],array1 = [];

                            /*$('.function_name').each(function () {
                                var val = $(this).val();
                                array1.push(val);
                            });*/

                            $.each(data , function (index, value){
                                //console.log(array1);
                                //console.log(index,value.id+' - '+value.function_name);
                                array.push('<b>'+value.function_name+'</b>');
                            });

                            //console.log(array);



                            /*for(var i = 0;i < array.length;i++){
                                if(array.length == 1){
                                    array+='<b>'+array[i]+'</b> ';
                                }else if(array.length == 2){
                                    if(i == (array.length) - 1){
                                        array+='and <b>'+array[i]+'</b>';
                                    }else{
                                        array+='<b>'+array[i]+'</b> ';
                                    }
                                }else{
                                    if(i == (array.length) - 1){
                                        array+='and <b>'+array[i]+'</b>';
                                    }else{
                                        array+='<b>'+array[i]+'</b> , ';
                                    }
                                }
                            }*/


                            //var array ='<b>'+res.message+'</b>';
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                html: 'To add <b>'+res.child_function+'</b>, you have to add '+array
                            });
                            array.length = 0;
                        }else{
                            $("#snippet"+count).html(res);
							setTimeout(function (){ 
								$('#select'+section_id).select2(); 
								$('[data-toggle="popover"]').popover({
									placement : 'top',
									trigger: 'hover'
								});
							},1000);
                            summerNote();
                        }
                    },
                    complete : function(){
                        $(".loading").hide();
                    },
                    error : OnError
                });

            });



            $(document).on('click','.sameAsCondition',function(){
                var condid = $(this).attr('data-condid');
                var k = $(this).attr('data-k');
                var sid = $(this).attr('data-sid');
                var tabid = $(this).attr('data-tabid');
                var checked = $(this).prop("checked");
                var href = $("#headingOne1"+tabid+" a").attr('href');
                var divId = $(this).attr('data-divId');

                //alert($('.snippets'+sid+' .summernote').length);

                if(checked == true){
                    $("#headingOne1"+tabid).addClass('conditionAccordionDisable');
                    $(href).removeClass('show');
                    $(this).next('input').val(1);

                    /* replicating content */
                    var cond1Val = [];
                    $(".cond_stmt_id"+sid).each(function(i){
                        var val = $(this).val();
                        //alert(".snippets"+sid+''+val+' textarea');
                        //alert($(".snippets"+sid+''+val+' .summernote').length);
                        if(val == 1){
                            $(".snippets"+sid+''+val+' .summernote').each(function(){
                                cond1Val.push($(this).val());
                            });
                        }
                    });


                    $(".snippets"+sid+''+condid+' .summernote').each(function(j) {
                        $(this).summernote('code','');
                        $(this).summernote('code',cond1Val[j]);
                    });
                    /* replicating content */
                }else{
                    $("#headingOne1"+tabid).removeClass('conditionAccordionDisable');
                    $(this).next('input').val(0);
                }



            });


        });
		
		function OnError(xhr, errorType, exception) {
            var responseText;
            $("#dialog").html("");
            //console.log(xhr.responseJSON.message);
            //console.log(xhr.responseJSON.file);
            //console.log(xhr.responseJSON.line);
            //console.log(xhr.responseJSON.message);
            try {
                responseText = xhr.responseJSON;
                //responseText = jQuery.parseJSON(xhr.responseText);
                $("#dialog").append("<div><b>" + errorType + ": " + exception + "</b></div><br />");
                $("#dialog").append("<div><u>Message</u>:" + responseText.message + "</div><br />");
                $("#dialog").append("<div><u>File</u>:" + responseText.file + "</div><br />");
                $("#dialog").append("<div><u>Line</u>:" + responseText.line + "</div><br />");
                $("#dialog").append("<div><u>Message</u>:" + responseText.message + "</div><br />");
            } catch (e) {
                responseText = xhr.responseText;
                $("#dialog").html(responseText);
            }
            $("#errorModal").modal('show');
        }

    </script>

    <script>
        $(function() {
            var $form = $('.form');
            var $formStatusHolder = $('.js-form-status-holder');
            // or with options
            $form.autoSaveForm({ delay: 10000 });

            // The following triggers confirm to the beforeSend, error and success ajax callbacks.
            $form.on('beforeSave.autoSaveForm', function (ev, $form, xhr) {
                // called before saving the form
                // here you can return false if the form shouldn't be saved
                // eg. because of validation errors.
                /*if (!$form.valid()) {
                    notification('fa-times','Error','Please fill the required fields.','danger');
                    return false;
                }*/
                notification('fa fa-spinner fa-spin','Please wait..','We are saving data.','warning');
                //$form.find('input').prop('disabled',true);
                // Let the user know we are saving
                //$formStatusHolder.html('Saving...');
                //$formStatusHolder.removeClass('text-danger');
            });

            $form.on('saveError.autoSaveForm', function (ev, $form, jqXHR, textStatus, errorThrown) {
                // The saving failed so tell the user
                $formStatusHolder.html('Saving failed! Please retry later.');
                $formStatusHolder.addClass('text-danger');

                setTimeout(function(){
                    $form.find('input').prop('disabled',false);
                    notification('fa-times','Error','Error in saving data.','danger');
                },3000);
            });
            $form.on('saveSuccess.autoSaveForm', function (ev, $form, data, textStatus, jqXHR) {
                // Now show the user we saved and when we did
                var d = new Date();
                $formStatusHolder.html('Saved! Last: ' + d.toLocaleTimeString());
                if(data.status == 'success'){
                    setTimeout(function(){
                        $form.find('input').prop('disabled',false);
                        notification('fa-check','success','Data saved successfully.','success');
                    },2000);
                }else{
                    setTimeout(function(){
                        $form.find('input').prop('disabled',false);
                        notification('fa-times','Error','Error in saving data.','danger');
                    },2000);
                }


            });

            $(document).on('click','.submitButton',function (){
                var id = $(this).attr('data-id');
                $("#"+id).trigger('save.autoSaveForm');
            });

            $(document).on('click','.submitSnippet',function (){
                var id = $(this).attr('data-id');
                var snippet_id = $(this).attr('data-snippet-id');
                var Data = $('#'+id).serializeArray();
                var summernote = $("#"+id+" .summernote");
                var select = $("#"+id+" select");
                var er = [];
                var cnt = 0;

                select.each(function(){
                    var sname = $(this).attr('id');
                    //alert(sname);
                    if($(this).val() == ''){
                        $("#"+id+" ."+sname).each(function(){
                            $(this).parent().addClass('show');
                        });
                        $("#"+id+" ."+sname).html('This field is required.');
                        er+=cnt+1;
                    }else{
                        $("#"+id+" ."+sname).html('');
                    }
                });

                summernote.each(function(){
                    if($(this).val() == ""){
                        $("#"+id+" .summernote-required").html('This field is required.');
                        er+=cnt+1;
                    }else{
                        $("#"+id+" .summernote-required").html('');
                    }
                });

                if(er != ""){
                    notification('fa-times','Error','Please fill all the required fields in snippet '+snippet_id,'danger');
                    return false;
                }

                saveData(Data);
            });

            $(document).on('click','.updateSnippet',function (){
                var id = $(this).attr('data-id');
                var snippet_id = $(this).attr('data-snippet-id');
                var Data = $('#'+id).serializeArray();
                var summernote = $("#"+id+" .summernote");
                var select = $("#"+id+" select");
                var er = [];
                var cnt = 0;

                
            select.each(function(){
                var sname = $(this).attr('id');
                //alert(sname);
                if($(this).val() == ''){
                    $("#"+id+" ."+sname).each(function(){
                        $(this).parent().addClass('show');
                    });
                    $("#"+id+" ."+sname).html('This field is required.');
                    er+=cnt+1;
                }else{
                    $("#"+id+" ."+sname).html('');
                }
            });

                summernote.each(function(){
                    if($(this).val() == ""){
                        $("#"+id+" .summernote-required").html('This field is required.');
                        er+=cnt+1;
                    }else{
                        $("#"+id+" .summernote-required").html('');
                    }
                });

                if(er != ""){
                    return false;
                }
                updateData(Data);
            });


            $(document).on('click','.deleteSection',function(){
                var id = $(this).attr('data-id');
                var pattern_template_id = $("#pattern_template_id").val();

                Swal.fire({
                    title: 'Are you sure ?',
                    text: "You want to delete the section and snippets",
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
                            url : '{{ route('designer.pattern.template.delete.section') }}',
                            type : 'POST',
                            data : 'section_id='+id+'&pattern_template_id='+pattern_template_id,
                            beforeSend : function (){
                                $(".loading").show();
                            },
                            success : function (res){
                                if(res.status == "success"){
                                    getAllSections();
                                    $(".section"+id).remove();
                                    Swal.fire(
                                        'Deleted!',
                                        'The section has been deleted.',
                                        'success'
                                    )
                                }else{
                                    Swal.fire(
                                        'Oops!',
                                        'unable to delete the section.Try again later.',
                                        'danger'
                                    )
                                }
                            },
                            complete : function (){
                                $(".loading").hide();
                            },
                            error : function (jqXHR, textStatus){
                                alert( "Request failed: " + textStatus.message );
                            }
                        });

                    }
                })

            });$(document).on('click','.deleteSnippet',function(){
                var id = $(this).attr('data-id');
                var pattern_template_id = $("#pattern_template_id").val();
                var server = $(this).attr('data-server');

                Swal.fire({
                    title: 'Are you sure ?',
                    text: "You want to delete the snippets",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {

                        if(server == 'false'){
                            $(".loading").show();
                            setTimeout(function(){
                                $(".loading").hide();
                                $("#snippet"+id).remove();
                                Swal.fire(
                                    'Deleted!',
                                    'The snippet has been deleted.',
                                    'success'
                                )
                            },1000);
                            return false;
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            url : '{{ route('designer.pattern.template.delete.snippet') }}',
                            type : 'POST',
                            data : 'snippet_id='+id+'&pattern_template_id='+pattern_template_id,
                            beforeSend : function (){
                                $(".loading").show();
                            },
                            success : function (res){
                                if(res.status == 'success'){
                                    getAllSections();
                                    /* $("#snippet"+id).remove(); */
                                    Swal.fire(
                                        'Deleted!',
                                        'The snippet has been deleted.',
                                        'success'
                                    )
                                }else{
                                    Swal.fire(
                                        'Oops!',
                                        'unable to delete the snippet.Try again later.',
                                        'danger'
                                    )
                                }
                            },
                            complete : function (){
                                $(".loading").hide();
                            },
                            error : function (jqXHR, textStatus){
                                alert( "Request failed: " + textStatus.message );
                            }
                        });

                    }
                })

            });

            $(document).on('click','#preview',function (){
                var options = {
                    backdrop: 'static',
                    keyboard: false
                };
                $("#previewModal").modal(options);
                $("#measurement_id").select2();
            });

            // open chat box
            $(document).on('click','.previewTemplate',function(e) {
                var template_id = $(this).attr('data-template-id');
                var measurement_id = $("#measurement_id").val();


                if(measurement_id == 0 || measurement_id == undefined){
                    $(".measurement_id").html('Select measurement profile');
                    setTimeout(function(){ $(".measurement_id").html('');},3000);
                    notification('fa-times','Error','Please select measurement profile.','danger');
                    return false;
                }else{
                    $(".measurement_id").html('');
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({

                    url : '{{ route("designer.pattern.template.preview") }}',
                    type : 'POST',
                    data : 'template_id='+template_id+'&measurement_id='+measurement_id,
                    enctype: 'multipart/form-data',
                    beforeSend : function(){

                        $(".loading").show();
                    },
                    success : function(res){

                        if(res){
                            $("#templatePreview").html(res);
							
                            $("#previewModal").modal('hide');
                            var my_val = $('.pcoded').attr('vertical-placement');
                            if (my_val == 'right') {
                                var options = {
                                    direction: 'right'
                                };
                            } else {
                                var options = {
                                    direction: 'left'
                                };
                            }
                            $('.showTemplate').toggle('slide', options, 500);
                            $('[data-toggle="tooltip"]').tooltip();
							
                        }
                    },
                    complete : function(){
                        $(".loading").hide();
                    },
                    error : function(jqXHR,textStatus){

                    }
                });
            });


            /* add yarn details */

            var yd = 1;
            $(document).on('click','.add-yarnDetail',function(){
                //var id = $("#addYarnData").find('.allYd').length;
                // var yd = parseInt(id)+1;
                var id = $(this).attr('data-id');
                var data = '<div class="col-md-6 allYd m-b-10 m-t-10" id="yd'+id+''+yd+'"><input type="text" class="form-control" name="yarn_title[]" placeholder="Yarn title"><br><input type="hidden" name="yarn_detail_id[]" value="0"><textarea name="yarn_details[]" class="form-control" required="required" placeholder="Enter yarn url"></textarea><a href="javascript:;" data-server="false" class="delete-yarn-details" data-id="'+id+''+yd+'"><i class="fa fa-trash"></i></a></div>';
                $("#addYarnData"+id).append(data);
                yd++;
            });

            $(document).on('click','.delete-yarn-details',function(){
                var id = $(this).attr('data-id');
                var server = $(this).attr('data-server');
                if(confirm('Are you sure want to remove this ?')){

                    if(server == 'true'){
                        $(".loading").show();
                        $.get("{{ url('designer/designer-template-delete-yarn-data') }}/"+id,function (res){
                            if(res.status == 'success'){
                                notification('fa-check','success','Yarn details deleted successfully.','success');
                                $("#yd"+id).remove();
                            }else{
                                notification('fa-times','Error','Problem in deleteting Yarn details.','danger');
                            }
                            $(".loading").hide();
                        });

                    }else{
                        $("#yd"+id).remove();
                    }
                }

            });

            $(document).on('click','.submityarnDetails',function(){
                var id = $(this).attr('data-id');
                var Data = $("#yarn_details"+id).serializeArray();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var URL = $("#yarn_details"+id).attr('action');


                $.ajax({
                    url : URL,
                    type : 'POST',
                    data : Data,
                    beforeSend : function(){
                        $(".loading").show();
                    },
                    success : function(res){
                        if(res.status == 'success'){
                            notification('fa-check','success','Yarn details added successfully.','success');
                            //getYarnDetails();
                            getAllSections(res.section_id);
                        }
                    },
                    complete : function(){
                        $(".loading").hide();
                    },
                    error : function(){
                        notification('fa-times','Error','Problem in adding Yarn details.','danger');
                    }
                })

            });


            /* events for ckeditor */

            /* $(document).on('keyup','.summernote',function(){
                 var condid = $(this).attr('data-condid');
                 var k = $(this).attr('data-k');
                 var sid = $(this).attr('data-sid');
                 var l = $(this).attr('data-l');
                 var value = $(this).val();
                 alert(condid +' - '+k+' - '+sid+' - '+l);
                 $(".cond_stmt_id"+sid).each(function(i){
                     var val = $(this).val();
                     k = parseInt(i)+1;
                    if(i > 0){
                        alert(val +' - '+k+' - '+sid+' - '+l);
                        $("#editor"+val+''+k+''+sid+''+l).val(value);
                    }
                 });
             }); */

            $(document).on('change','.select-factor',function(){
			   var value = $(this).val();
			   var name = $(this).attr('id');
			   if(value != ''){
				   $('.'+name).html('');
			   }else{
				   $('.'+name).html('This field is required.');
			   }
			});

            $(document).on('click','.accordion',function(){
                if($(this).hasClass('collapsed') == true){
                    $(this).find('i.icon').removeClass('fa fa-caret-up').addClass('fa fa-caret-down');
                }else{
                    $(this).find('i.icon').removeClass('fa fa-caret-down').addClass('fa fa-caret-up');
                }
            });


            $(document).on('click','.changeStatus',function (){
                var id = $(this).attr('data-id');
                var status = $(this).attr('data-status');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to mark this pattern complete.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value == true) {

                        var Data = 'id='+id+'&status='+status;
                        $(".loading").show();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.post('{{ route('release.pattern') }}',Data)
                            .done(function (res){
                                setTimeout(function (){ location.reload(); },1000);
                                $(".loading").hide();

                                Swal.fire(
                                    'Yeah!',
                                    'Your pattern completed successfully.',
                                    'success'
                                )
                            })
                            .fail(function (xhr, status, error){
                                $(".loading").hide();
                                notification('fa-times','Oops..',error,'danger');
                            });


                    }
                })
            });
			
			$(document).on('change','.select-factor',function (){
                var val = $(this).val();
                $(this).next('input').val(val);
            });

            $(document).on('change','.select-modifier',function (){
                var val = $(this).val();
                $(this).next('input').val(val);
            });

        });

        function getYarnDetails(){
            $.get('{{ url("designer/designer-template-get-yarn-data/".$id) }}',function(res){
                $("#yarnDetails1").html(res);
            });
        }

        /*function getAllSections(section_id){
            $.get("{{ url('designer/get-all-sections/'.$id) }}",function(res){
                $("#loadingSections").html(res);
                setTimeout(function (){
                    summerNote();
                    //turn to inline mode
                    $.fn.editable.defaults.mode = 'inline'; // popup default
                    $('.username').editable({
                        type: 'text',
                        url: '{{route("designer.update.section.name")}}', // Send ajax request with new value on /post
                        title: 'Enter Section Name'
                    });
                    $("#PTsection4"+section_id).addClass('show');
                },1000);
            });
        }*/
		function getAllSections(section_id){

            $.ajax({
                url: "{{ url('designer/get-all-sections/'.$id) }}",
                type: 'GET',
                beforeSend : function(){
                    $(".loading").show();
                },
                success: function(res){
                    $("#loadingSections").html(res);
                    setTimeout(function (){
                        summerNote();
                        //turn to inline mode
                        $.fn.editable.defaults.mode = 'inline'; // popup default
                        $('.username').editable({
                            type: 'text',
                            url: '{{route("designer.update.section.name")}}', // Send ajax request with new value on /post
                            title: 'Enter Section Name'
                        });
						$('[data-toggle="popover"]').popover({
							 placement : 'top',
							 trigger: 'hover'
						 });
                        $("#PTsection4"+section_id).addClass('show');
                    },1000);
                },
                error: function (data) {
                    $("#loadingSections").html('<h4 class="text-center">Unable to load sections.<a href="javascript:;" style="font-size: 22px;color: #c14d7d;" onclick="getAllSections()">Click here</a> to load sections.</h4>');
                },
                complete : function () {
                    $(".loading").hide();
                }
            });

        }
        function getNewSection(){
            $.get("{{ url('designer/get-new-sections/'.$id) }}",function(res){
                $("#newSection").append(res);
                $('.username').editable({
                    type: 'text',
                    url: '{{route("designer.update.section.name")}}', // Send ajax request with new value on /post
                    title: 'Enter Section Name'
                });
            });
        }


function addSnippet(section_id){
	$(".loading").show();
	var snippets = $("div.allsnippets").length;
	var count = parseInt(snippets) + 1;
	/* <option value="concatinate">Concatinate Snippet</option> */
	
	var pattern_template_id = $("#pattern_template_id").val();

$.get('{{ url("designer/remove-added-functions") }}/'+pattern_template_id,function (res) {
var select = $('#select'+section_id)
	.append($("<optgroup label='Select Snippet'></optgroup>"));
//$('#select'+section_id).empty();
	$.each(res.data, function(key, value) {
		//console.log(key+' - '+value.function_name+' - '+value.id);
		select.append($("<option></option>")
			.attr("value",value.id)
			.text(value.function_name));
		$('#select'+section_id).select2();
		$(".loading").hide();
	});
});

	var func = '<div class="allsnippets" id="snippet'+count+'"><form class="form " id="sectionForm'+section_id+count+'" method="POST" action="{{ route("save.snippet.data")}}"><input type="hidden" name="snippet_name" id="snippet_name" value="Snippet'+count+'" ><div class="form-group row m-b-zero p-10 bordered-box" id="add-function-box'+count+'"> <div class="col-lg-8 row-bg"> <h6 class="m-b-5 m-t-5">Snippet '+count+'</h6> </div><div class="col-lg-4 row-bg text-right"><a href="javascript:;" class="deleteSnippet fa fa-trash pull-right" data-server="false" data-id="'+count+'" ></a></div><div class="col-lg-12"> <div class="row"> @if($functions->count() > 0)<div class="col-md-5 m-b-20"> <select class="form-control fill select-formula" id="select'+section_id+'" name="function_name" data-section-id="'+section_id+'" data-count="'+count+'" data-id="'+section_id+count+'"> <option value="">Select a function</option><optgroup label="Select Snippet"><option value="empty">Empty Snippet</option><option value="yarndetails">Yarn Details Snippet</option></optgroup> </select>  </div>@endif <div id="functionData'+section_id+count+'" class="col-md-12"></div></div></div></div></form></div>';
	$("#addSnippet"+section_id).append(func);
}

        function summerNote(){

            $('.summernoteDescription').summernote({
                hint: {
                    mentions: [<?php echo $var; ?>],
                    match: /\B@(\w*)$/,
                    search: function (keyword, callback) {
                        callback($.grep(this.mentions, function (item) {
                            return item.indexOf(keyword) == 0;
                        }));
                    },
                    content: function (item) {
                        return '[[' + item + ']]';
                    }
                }
            });

            $(".summernoteDescription").on('summernote.focus', function() {
                var summernote1 = $(this);

                if(summernote1.summernote('isEmpty')){
                    summernote1.summernote('code','');
                }
            });

            setTimeout(function(){
                $(".sameAsCondition").each(function(){
                    var tabid = $(this).attr('data-tabid');
                    var checked = $(this).prop("checked");

                    if(checked == true){
                        $("#headingOne1"+tabid).addClass('conditionAccordionDisable');
                    }
                });
            },500);

        }

        function saveData(Data){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url : '{{ route("designer.save.snippet.data")}}',
                type : 'POST',
                data: Data,
                beforeSend : function (){
                    $(".loading").show();
                },
                success : function (res){
                    if(res.status == 'success'){
                        notification('fa-check','success','Section added successfully.','success');
                        $("#newSection").html('');
                        getAllSections(res.section_id);
                    }
                },
                complete : function(){
                    setTimeout(function(){ $(".loading").hide(); },1000);
                },
                error : function (){
                    notification('fa-times','Error','Problem in adding section.','danger');
                }

            });
        }

        function updateData(Data){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url : '{{ route("designer.update.snippet.data")}}',
                type : 'POST',
                data: Data,
                beforeSend : function (){
                    $(".loading").show();
                },
                success : function (res){
                    if(res.status == 'success'){
                        notification('fa-check','success','Section added successfully.','success');
                        getAllSections(res.section_id);
                    }
                },
                complete : function(){
                    setTimeout(function(){ $(".loading").hide(); },1000);
                },
                error : function (){
                    notification('fa-times','Error','Problem in adding section.','danger');
                }

            });
        }

        /*function opencommentbar(sectionId) {
            $("#comment-sidebar").css('width','340px');
            $.get("{{url('designer/getSectionComments')}}/"+sectionId,function (res){
                $("#task-container").html(res);
            });
        }

        /* Set the width of the sidebar to 0 (hide it) *
        function closecommentbar() {
            document.getElementById("comment-sidebar").style.width = "0";
        }*/

        /*
            (function($, window, undefined) {
                //is onprogress supported by browser?
                var hasOnProgress = ("onprogress" in $.ajaxSettings.xhr());

                //If not supported, do nothing
                if (!hasOnProgress) {
                    return;
                }

                //patch ajax settings to call a progress callback
                var oldXHR = $.ajaxSettings.xhr;
                $.ajaxSettings.xhr = function() {
                    var xhr = oldXHR.apply(this, arguments);
                    if(xhr instanceof window.XMLHttpRequest) {
                        xhr.addEventListener('progress', this.progress, false);
                    }

                    if(xhr.upload) {
                        xhr.upload.addEventListener('progress', this.progress, false);
                    }

                    return xhr;
                };
            })(jQuery, window); */
    </script>
@endsection
