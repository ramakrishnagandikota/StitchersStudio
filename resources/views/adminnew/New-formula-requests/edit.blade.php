@extends('layouts.adminnew')
@section('title','View pattern template')
@section('section1')
    <!-- Page-body start -->
    <div class="page-body">
        <div class="row">
            <div class="col-xl-12">
                <label class="theme-heading f-w-600 m-b-20">Request output formula
                </label>
                <button type="button" class="btn theme-btn btn-sm pull-right waves-effect"  data-toggle="modal" data-target="#myModal">Help</button>
                <!-- To Do Card List card start -->
                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">Request submitted by
                                    </label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>{{ ucfirst($formulas->first_name).' '.$formulas->last_name }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">Request submitted on
                                    </label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>{{ date('m/d/Y',strtotime($formulas->created_at)) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">Output formula name
                                    </label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h6>{{ $formulas->formula_name }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">List of input variable
                                    </label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            @php
                                            $var = '';
                                            $meas = explode(',',$formulas->input_variables);
                                            for($i=0;$i<count($meas);$i++){
												
                                            $measurements = DB::table('p_measurement_variables')->where('id',$meas[$i])->first();

											if($measurements){
												if($i == count($meas) - 1){
													$m = $measurements->variable_name;
												}else{
													$m = $measurements->variable_name.',';
												}
												$var.=ucfirst($m);
									 
                                            }else{
												$var.='';
											}
											}
                                            $var.='';
                                            @endphp
                                            <h6>{{ $var }}</h6>
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
                                                            <h6>{{ $formulas->factor_name_inch }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Factor min value</label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>{{ $formulas->min_value_in }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Factor max value</label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>{{ $formulas->max_value_in }}</h6>
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
                                                            <h6>{{ $formulas->factor_name_cm }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Factor min value</label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>{{ $formulas->min_value_cm }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Factor max value</label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>{{ $formulas->max_value_cm }}</h6>
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
                                                            <h6>{{ $formulas->modifier_name }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Modifier min value</label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>{{ $formulas->min_value }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-label">Modifier max value</label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>{{ $formulas->max_value }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($formulas->outputVariables()->count() > 0)
                        <div class="row first-row">
                            <?php $k = 1; ?>
                                @foreach($formulas->outputVariables as $form)
                            <div class="col-lg-12 m-t-10">
                                <div class="grey-box">
                                    <div class="card-header accordion active col-lg-12 col-sm-12" data-toggle="collapse" data-target="#section1">
                                        <h5 class="card-header-text">Output variable {{$k}}
                                        </h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                                    </div>
                                    <div class="custom-card-block">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="col-form-label">Output variable name
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h6>{{ $form->output_variable_name }}</h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Formula
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <textarea disabled cols="60%">{{ $form->formula }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">Comment
                                                    </label>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <textarea disabled cols="60%">{{ $form->comments }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
							<?php $k++; ?>
                            @endforeach
                        </div>


                        @endif
                    </div>
                </div>


                <div class="col-md-12">
                    <h5 class="m-b-15">Comments</h5>
                </div>

                <div class="card ">
                    <div class="card-block">
                        <div class="row containers">
                            @if($fcomments->count() > 0)
                            @foreach($fcomments as $comment)
                                <?php
                                    $user = App\User::find($comment->user_id);
                                    if($user->picture){
                                        $pic = $user->picture;
                                    }else{
                                        $pic = Avatar::create($comment->first_name)->toBase64();
                                    }
                                ?>
                            <div class="col-lg-12 comments">
                                <div class="media">
                                    <div class="media-right friend-box">
                                        <a href="#">
                                            <img class="media-object img-radius" src="{{ $pic }}" alt="">
                                        </a>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="m-t-10">{{ $comment->first_name }} {{ $comment->last_name }} <span style="font-size:12px;color:#b3b3b3;margin-left: 15px;"><i class="icofont icofont-wall-clock f-12"></i> {{ $comment->created_at->diffForHumans() }}</span>
                                           @if($user->hasRole('Admin')) <span class="chips">Admin</span> @endif
                                        </h6>
                                        <div class="msg-reply @if($comment->user_id == Auth::user()->id) chat-box-receive @else chat-box-posted @endif p-10 f-14 m-t-15">{!! $comment->comments !!}</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach


                        </div>

                        <div class="page-load-status text-center">
                            <p class="infinite-scroll-request">Loading...</p>
                            <p class="infinite-scroll-last">End of comments</p>
                            <p class="infinite-scroll-error">No more comments to load</p>
                        </div>

                        @else
                            <p class="text-center" id="nocomments" style="margin:auto;">No comments to show.</p>
                        @endif

                    </div>
                </div>

                <div class="col-md-12">
                    <h6 class="m-b-15">Write your comment</h6>
                </div>

                <div class="card">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-group">
                                    <!--<div class="media">
                                        <div class="media-right friend-box">
                                            <a href="#">
                                                <img class="media-object img-radius" src="{{ Avatar::create(Auth::user()->first_name)->toBase64() }}" alt="">
                                            </a>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="m-t-15">Write your comment</h6>
                                        </div>
                                    </div> -->
                                    <form id="admin-comment">
                                        @csrf
                                        <input type="hidden" name="formula_id" value="{{ encrypt($formulas->id) }}">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <textarea class="summernote" id="comments" name="comments"></textarea>
                                            <span class="red comment"></span>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @if($formulas->f_status == 'In Review')
                <div class="col-lg-12 text-center">
                    <a href="{{ route('admin.new.formula.requests') }}" class="btn theme-outline-btn waves-effect m-b-10 m-t-10 m-r-20">Cancel</a>
                    <button type="button" class="btn theme-btn waves-effect m-b-10 m-t-10 m-r-20" onclick="submitForm('update')">Update</button>
                    <button type="button" class="btn theme-btn waves-effect m-b-10 m-t-10 m-r-20" onclick="submitForm('update_complete')" >Update & Move to Completed</button>
                    <button type="button" class="btn theme-btn waves-effect m-b-10 m-t-10 m-r-20" onclick="submitForm('update_rejected')" >Update & Move to Rejected</button>
                </div>
            @endif

            @if($formulas->f_status == 'Completed')
                <div class="col-lg-12 text-center">
                    <a href="{{ route('admin.new.formula.requests') }}" class="btn theme-outline-btn waves-effect m-b-10 m-t-10 m-r-20">Cancel</a>
                    <button type="button" class="btn theme-btn waves-effect m-b-10 m-t-10 m-r-20" onclick="submitForm('update')">Update</button>
                </div>
            @endif

        </div>
    </div>
    <!-- Page-body end -->
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
        .red{
            color: #bc7c8f;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/summernote/summernote.min.css') }}" />
    <script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.min.js') }}"></script>
    <script src="{{asset('resources/assets/infinite-scroll.pkgd.min.js')}}"></script>
    <script>
        var $container = $(".containers");
        var $containers;
        $(function() {
           //var $container = $(".containers");
            $('[data-toggle="tooltip"]').tooltip()
            $('.summernote').summernote({
                height : '150px',
                callbacks: {
                    onChange: function(contents, $editable) {
                        if(contents == "" || contents == '<p><br></p>'){
                            $(".comment").html('Please fill comments.');
                            return false;
                        }else{
                            $('.comment').html('');
                        }
                    },
                    onFocus: function() {
                        $(".summernote").summernote('code','');
                    }
                }
            });


            $(".containers").infiniteScroll({
                path: function() {
                    if(this.loadCount <= {{$fcomments->lastPage()}}){
                        var pageNumber = ( this.loadCount + 2 ) * 1;
                        return '{{url("adminnew/edit/new-formula-request/".$formulas->enc_id."?page=")}}'+pageNumber;
                    };
                },
                append: '.comments',
                history: false,
                status: '.page-load-status',
                scrollThreshold: 100,
                hideNav: '.pagination',
            });


        });

        function submitForm(type){
            var comment = $("#comments").val();

            if(comment == ''){
                $(".comment").html('Please fill comments.');
                notification('fa-times','Oops..','Please fill the comments to proceed.','danger');
                return false;
            }else{
                $(".comment").html('');
            }


            var Data = $("#admin-comment").serializeArray();
            Data.push({name: 'type', value: type});
            $(".theme-btn").prop('disabled',true);
            $(".loading").show();
            $.post('{{ route("admin.completed.new.formula") }}',Data)
            .done(function(res){
                $(".loading").hide();
                $(".containers").append(res);
                notification('fa-check','Yeah..','Formula updated successfully.','success');
                $(".summernote").summernote('code','');
                $('.comment').html('');
                $(".theme-btn").prop('disabled',false);
                //setTimeout(function (){ window.location.assign("{{ route('admin.new.formula.requests') }}") },1500);
				//if($(".comments").length == 0){
					$("#nocomments").hide();
				//}
            })
            .fail(function(xhr, status, error) {
                $(".loading").hide();
                notification('fa-times','Oops..',error,'danger');
                $(".theme-btn").prop('disabled',false);
            });
        }

        function getInfiniteScroll(){
            $(".containers").infiniteScroll({
                path: function() {
                    if(this.loadCount <= {{$fcomments->lastPage()}}){
                        var pageNumber = ( this.loadCount + 2 ) * 1;
                        return '{{url("adminnew/edit/new-formula-request/".$formulas->enc_id."?page=")}}'+pageNumber;
                    };
                },
                append: '.comments',
                history: false,
                status: '.page-load-status',
                scrollThreshold: 100,
                hideNav: '.pagination',
            });
        }
    </script>
@endsection
