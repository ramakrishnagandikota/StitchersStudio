@extends('layouts.designerapp')
@section('title','My Patterns')
@section('content')
    <div class="pcoded-wrapper">
        <div class="pcoded-content">
            <div class="pcoded-inner-content">
                <div class="main-body">
                    <div class="page-wrapper">
                        <!-- Page-body start -->
<form id="update-formula">
                            <div class="page-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <label class="theme-heading f-w-600 m-b-20">Request output formula : {{ ucfirst($formula->formula_name) }} </label>
                                        <button type="button" class="btn theme-btn btn-sm pull-right waves-effect" data-toggle="modal" data-target="#myModal2">Help</button>
                                        <a href="{{ route('formula.requests') }}" class="btn theme-btn btn-sm pull-right waves-effect m-r-10" >Back to formula requests</a>
                                        <!-- To Do Card List card start -->
                                        <div class="card">

                                            <div class="card-block">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">Output formula name<span class="red">*</span></label>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <input type="text" class="form-control" id="formula_name" name="formula_name" placeholder="Enter new formula name" value="{{ $formula->formula_name }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="form-label">List of input variable<span class="red">*</span></label>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    @php
                                                                        $var = '';
                                                                        $meas = explode(',',$formula->input_variables);
                                                                        for($i=0;$i<count($meas);$i++){
                                                                        $measurements = App\Models\MeasurementVariables::where('id',$meas[$i])->first();

                                                                        if($i == count($meas) - 1){
                                                                            $m = $measurements->variable_name;
                                                                        }else{
                                                                            $m = $measurements->variable_name.',';
                                                                        }
                                                                            $var.=ucfirst($m);
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
                                                                                    <input type="text" class="form-control" id="factor_name_inch" name="factor_name_inch" placeholder="Enter factor name" value="{{ $formula->factor_name_inch }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Factor min value</label>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <input type="text" class="form-control" id="min_value_in" name="min_value_in" placeholder="Enter min value" value="{{ $formula->min_value_in }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Factor max value</label>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <input type="text" class="form-control" id="max_value_in" name="max_value_in" placeholder="Enter max value" value="{{ $formula->max_value_in }}">
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
                                                                                    <input type="text" class="form-control" id="factor_name_cm" name="factor_name_cm" placeholder="Enter factor name" value="{{ $formula->factor_name_cm }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Factor min value</label>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <input type="text" class="form-control" id="min_value_cm" name="min_value_cm" placeholder="Enter min value" value="{{ $formula->min_value_cm }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Factor max value</label>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <input type="text" class="form-control" id="max_value_cm" name="max_value_cm" placeholder="Enter max value" value="{{ $formula->max_value_cm }}">
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
                                                                                    <input type="text" class="form-control" id="modifier_name" name="modifier_name" placeholder="Enter modifier name" value="{{ $formula->modifier_name }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Modifier min value</label>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <input type="text" class="form-control" id="min_value" name="min_value" placeholder="Enter min value" value="{{ $formula->min_value }}">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Modifier max value</label>
                                                                            <div class="row">
                                                                                <div class="col-md-12">
                                                                                    <input type="text" class="form-control" id="max_value" name="max_value" placeholder="Enter max value" value="{{ $formula->max_value }}">
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

                                                    @if($formula->outputVariables()->count() > 0)
                                                        <?php $j=1; ?>
                                                        @foreach($formula->outputVariables as $out)
                                                            <div class="col-lg-12 variables m-t-15" id="variable{{$j}}">
                                                                <input type="hidden" name="output_variable_id[]" value="{{ $out->id }}">
                                                                <div class="grey-box">
                                                                    <div class="card-header accordion active col-lg-12 col-sm-12"
                                                                         data-toggle="collapse" data-target="#section1">
                                                                        <h5 class="card-header-text">Output variable {{$j}}</h5>

                                                                        <a href="javascript:;" id="delete{{$j}}" data-j="{{ $j }}" data-id="{{ $out->id }}" data-server="true" class="pull-right fa @if(($j == $formula->outputVariables()->count()) && ($j != 1)) fa-trash @endif deleteOutput" ></a>

                                                                        <!-- <i class="fa fa-caret-down pull-right micro-icons"></i> -->
                                                                    </div>
                                                                    <div class="custom-card-block">
                                                                        <div class="row">
                                                                            <div class="col-md-4">
                                                                                <div class="form-group">
                                                                                    <label class="form-label">Output variable name<span class="red">*</span></label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <input type="text" class="form-control" id="output_variable_name" name="output_variable_name[]" placeholder="Enter output variable name" value="{{ $out->output_variable_name }}">
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
                                                                                            <textarea class="form-control" cols="60%" placeholder="Formula details" id="formula" name="formula[]">{{ $out->formula }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="form-label">Add comment</label>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <textarea class="form-control" cols="60%" placeholder="Comments" id="comments" name="comments[]">{{ $out->comments }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php $j++ ?>
                                                        @endforeach
                                                    @endif

                                                </div>

                                                <!-- add more -->
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
</form>
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
                                    <p class="text-center">No comments to show</p>
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
                                                    <img class="media-object img-radius" src="{{ Auth::user()->picture }}" alt="">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="m-t-15">Comment from {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h6>
                                            </div>
                                        </div> -->
                                        <form id="admin-comment" method="POST">
                                            @csrf
                                            <input type="hidden" name="formula_id" value="{{ encrypt($formula->id) }}">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <textarea class="summernote" id="comments" name="comments"></textarea>
                                                    <span class="red comment"></span>
                                                </div>
                                            </div>
                                        </form>
                                            <div class="col-lg-12 text-center">
                                                <button type="button"  class="btn theme-btn waves-effect m-b-10 m-t-10 m-r-20" onclick="submitForm()" >Add comment</button>
                                            </div>


                                    </div>
                                </div>
                            </div>
                        </div>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/summernote/summernote.min.css') }}" />

    <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('resources/assets/connect/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>
    <script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.min.js') }}"></script>
    <script src="{{asset('resources/assets/infinite-scroll.pkgd.min.js')}}"></script>
    <script>
        var $container = $(".containers");
        var $containers;
        $(function (){
            $('#update-formula input,#update-formula select,#update-formula textarea').prop('disabled',true);

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
                        if($(".summernote").summernote('isEmpty')){
                            $(".summernote").summernote('code','');
                        }
                    }
                }
            });

            $(".containers").infiniteScroll({
                path: function() {
                    if(this.loadCount <= {{$fcomments->lastPage()}}){
                        var pageNumber = ( this.loadCount + 2 ) * 1;
                        return '{{url("designer/view-formula/".$formula->enc_id."?page=")}}'+pageNumber;
                    };
                },
                append: '.comments',
                history: false,
                status: '.page-load-status',
                scrollThreshold: 100,
                hideNav: '.pagination',
            });

        });

        function submitForm(){
            var comment = $("#comments").val();

            if(comment == ''){
                $(".comment").html('Please fill comments.');
                notification('fa-times','Oops..','Please fill the comments to proceed.','danger');
                return false;
            }else{
                $(".comment").html('');
            }


            var Data = $("#admin-comment").serializeArray();

            $(".theme-btn").prop('disabled',true);
            $(".loading").show();
            $.post('{{ url("designer/formula-request/add-comment")  }}',Data)
                .done(function(res){
                    $(".loading").hide();
                    $(".containers").append(res);
                    notification('fa-check','Yeah..','Formula updated successfully.','success');
                    $(".summernote").summernote('code','');
                    $('.comment').html('');
                    $(".theme-btn").prop('disabled',false);
                    //setTimeout(function (){ window.location.assign("{{ route('admin.new.formula.requests') }}") },1500);
                })
                .fail(function(xhr, status, error) {
                    $(".loading").hide();
                    notification('fa-times','Oops..',error,'danger');
                    $(".theme-btn").prop('disabled',false);
                });
        }
    </script>
@endsection
