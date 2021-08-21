@extends('layouts.adminnew')
    @section('title','Ticket details #'.$support->ticket_id)
	@section('section')
    <div class="page-body">
        <div class="row">
            <div class="col-lg-8">
                <label class="theme-heading f-w-600 m-b-20">Ticket details : #{{ $support->ticket_id }}
                </label>
            </div>
            <div class="col-lg-4 text-right">
                @if($support->status == 1)
                    <label class="label label-success ticket-badge">Open</label>
                @elseif($support->status == 2)
                    <label class="label label-primary ticket-badge">In progress</label>
                @elseif($support->status == 3)
                    <label class="label label-warning ticket-badge">Resolved</label>
                @else
                    <label class="label label-danger ticket-badge">Closed</label>
                @endif
            </div>
        </div>
        <div class="card p-30">
            @php
            $user = App\User::where('id',$support->user_id)->first();
            @endphp
            <!-- <label class="label label-success ticket-badge">Open</label> -->
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="int1">Created by</label>
                        <div class="row">
                            <div class="col-md-12 ui-widget">
                                <input type="text" class="form-control hover-placeholder ui-autocomplete-input" value="{{$user->first_name}} {{ $user->last_name }}" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    @if($support->query_related_to != 'Other')
                    <div class="form-group">
                        <label for="int1">Pattern name</label>
                        <div class="row">
                            <div class="col-md-12 ui-widget">
                                @php
                                    $product = App\Models\Products::where('id',$support->pattern_name)->select(['product_name'])->first();
                                @endphp
                                <input type="text" class="form-control form-control-default" value="{{ $product ? $product->product_name : '' }}" disabled>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="form-group">
                        <label for="int1">Name</label>
                        <div class="row">
                            <div class="col-md-12 ui-widget">
                                <input type="text" class="form-control form-control-default" value="{{ $support->other_name }}" disabled>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-lg-3">
                    <div class="form-group">
                        <label for="int1">Priority</label>
                        <div class="row">
                            <div class="col-md-12 ui-widget">
                                @php
                                    if($support->priority == 1){
                                        $priority = 'Low';
                                    }else if($support->priority == 2){
                                        $priority = 'Medium';
                                    }else{
                                        $priority = 'High';
                                    }
                                @endphp
                                <input type="text" class="form-control form-control-default" value="{{$priority}}" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label for="int1">Query related to</label>
                        <div class="row">
                            <div class="col-md-12 ui-widget">
                                <input type="text" class="form-control form-control-default" value="{{$support->query_related_to}}" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="int1">Ticket subject</label>
                        <div class="row">
                            <div class="col-md-12 ui-widget">
                                <input type="text" class="form-control hover-placeholder ui-autocomplete-input" value="{{$support->subject}}" disabled>
                                <span class="small-text">In general,what is this ticket about?</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="int1">Related url</label>
                        <div class="row">
                            <div class="col-md-12 ui-widget">
                                <input type="text" class="form-control hover-placeholder ui-autocomplete-input" value="{{$support->related_url}}" disabled>
                                <span class="small-text">Optional,but very helpful.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12"><label for="int1" class="f-w-600">Ticket description</label><span class="small-text"> (Please be as descriptive as possible regarding the details fo this Ticket.)</span></div>
                <div class="col-md-12">
                    <div class="form-group border-box">
                        <div class="row">
                            <div class="col-md-12">
                                {!! $support->description !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <!-- File upload card start -->
                    <div class="card">
                        <div class="card-header">
                            <h5>Attachments</h5>
                        </div>
                        <div class="card-block">
                            @if($support->SupportAttachments()->count() > 0)
                                @php
                                    $pdf = $support->SupportAttachments()->where('attachment_type','=','pdf')->get();
                                    $images = $support->SupportAttachments()->where('attachment_type','!=','pdf')->get();
                                @endphp
                                @if($images->count() > 0)
                                    <h5>Images</h5>
                                    <hr>
                                    <div class="gg-container col-md-12">
                                        <div class="gg-box dark" id="square-1">
                                            <?php $i=1; ?>
                                            @foreach($images as $attach)
                                                <img data-id="{{$i}}" class=" self_posted all sectionContent" src="{{ $attach->attachment_url }}">
                                                <?php $i++; ?>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <br>
                                @if($pdf->count() > 0)
                                    <h5>Pdf</h5>
                                    <hr>
                                    @foreach($pdf as $attach1)
                                        <div class="col-md-1 pdf">
                                            <a href="{{ $attach1->attachment_url }}" target="_blank"><i class="fa fa-file-pdf-o fa-5x"></i></a>
                                        </div>
                                    @endforeach
                                @endif
                            @else
                                <p class="text-center">No attachments to show for this ticket.</p>
                            @endif
                        </div>
                    </div>
                    <!-- File upload card end -->
                </div>
                <!-- coments here -->



                <div class="col-lg-12">
                    <div class="card p-10">
                        <div class="card-block">
                            <div class="row" id="supportReply">
                                <div class="col-lg-12">
                                    <h5 class="text-center">Unable to load replies for this ticket.<a href="javascript:;" onclick="showAllReplies({{$support->ticket_id}},1)">Click here</a> to load coments.</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- comments here -->
                <div class="row" style="width: 100%">
                    <div class="col-lg-12" id="ticketReinitiate">
                        @if(($support->status != 3) && ($support->status != 4))
                            <form id="support-reply">
                                <div class="col-lg-12" id="reply-summernote">
                                    <div class="form-group">
                                        <label for="int1">Your Response</label>
                                        <input type="hidden" id="support_id" name="support_id" value="{{ base64_encode($support->id) }}">
                                        <input type="hidden" id="ticket_id" name="ticket_id" value="{{ base64_encode($support->ticket_id) }}">
                                        <textarea class="hint2mention summernote" name="support_comment" id="support_comment"></textarea>
                                    </div>

                                    <div class="card">
                                        <div class="card-header">
                                            <h5 style="color: #c14d7d;text-decoration: underline;cursor: pointer;" onclick="showAttachments()">Add Attachments</h5>
                                        </div>
                                        <div class="card-block attachment-box">
                                            <!-- <div class="sub-title">Example 1</div> -->
                                            <input type="file" name="files[]" id="filer_input1" multiple="multiple">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 m-t-20">
                                    <div class="text-center m-b-10">
                                        <button type="submit" class="btn theme-btn btn-primary waves-effect waves-light m-l-10" >Reply to ticket</button>
                                        &nbsp;
                                        <button type="button" id="closeTicket" class="btn theme-btn btn-primary waves-effect waves-light m-l-10" data-id="{{ base64_encode($support->ticket_id) }}" >Close ticket</button>
                                        &nbsp;
                                        <button type="button" id="resolveTicket" class="btn theme-btn btn-primary waves-effect waves-light m-l-10" data-id="{{ base64_encode($support->ticket_id) }}" >Ticket Resolved</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="col-sm-12 m-t-20">
                                <div class="text-center m-b-10">
                                    <button type="button" id="reInitiate" data-id="{{ base64_encode($support->ticket_id) }}" class="btn theme-btn btn-primary waves-effect waves-light m-l-10" >Re-initiate ticket</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
	@endsection
    @section('footerscript')
        <script type="text/javascript">
            var URL = '{{url("admin/support/uploadImage")}}';
            var URL1 = '{{url("admin/support/removeImage")}}';
        </script>
        <style>
            .subscription{color: #c14d7d;}
            .subscription{
                animation:blinkingText 1.2s infinite;
            }
            @keyframes blinkingText{
                0%{     color: #c14d7d    }
                49%{    color:#c14d7d  }
                60%{    color: transparent; }
                99%{    color:transparent;  }
                100%{   color: #c14d7d;     }
            }
            .note-color,.note-insert,.note-view,.attachment-box{display: none;}
            .jFiler-input-choose-btn{background-color: transparent;
                border: 1px solid #0d665c;
                color: #0d665c !important;font-weight: 300;
                border-radius: 0px;}
            .border-box {
                border: 1px solid #d0cfcf;
                padding: 10px;
                border-radius: 3px;
            }
            .pdf{
                border: 1px solid #ddd;
                padding: 18px;
            }
            .pdf a{
                color: #c14d7d !important;
            }
            .chips {
                background-color: #0d665c;
                border-radius: 20px;
                color: #fff;
                padding: 2px 8px 2px 8px;
                font-size: 10px;
                margin-left: 15px;
            }
            .help-block{
                color: red;
            }
        </style>
        <!-- filer js -->
        <link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
        <link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />
        <script src="{{asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
        <script type="text/javascript" src="{{asset('resources/assets/files/assets/pages/filer/support-fileupload.init.js')}}"></script>
        <!-- summernote -->
        <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/summernote/summernote.min.css') }}" />
        <script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('resources/assets/marketplace/js/grid-gallery.css') }}">
        <script src="{{ asset('resources/assets/marketplace/js/grid-gallery_support.js') }}"></script>
        <!-- bootstrap validator -->
        <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

        <script>
            $(function (){

                enableReplyForm();
                enableSummernote();
                showAllReplies({{$support->ticket_id}},1);


                /*gridGallery({
                    selector: "#square-1",
                    layout: "square"
                });*/


                $(document).on('click', '.pagination a', function(event){
                    event.preventDefault();
                    var page = $(this).attr('href').split('page=')[1];
                    showAllReplies({{$support->ticket_id}},page);
                    setTimeout(function(){
                        window.scroll({
                            top: 900,
                            left: 0,
                            behavior: 'smooth'
                        });
                    },1000);
                });



                $(document).on('click','.sectionContent',function (){
                    $(".gg-container").find('div#gg-screen').not(':first').remove();
                });

                $(document).on('click','#reInitiate',function(){
                    var id = $(this).attr('data-id');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url : '{{ route("AdminreInitiateTcket") }}',
                        type : 'POST',
                        data: 'ticket_id='+id,
                        beforeSend : function (){
                            $("#reInitiate").html("<i class='fa fa-spinner fa-spin'></i> Please wait, Re-initiating your ticket...");
                        },
                        success : function (res){
                            if(res.status == false){
                                notification('fa-times','Oops..','Unable to re-initiate your ticket. Try again after sometime.','danger');
                            }else{
                                setTimeout(function (){
                                    notification('fa-check','Yeah..','Your ticket has been re-initiated successfully.','success');
                                    $('#ticketReinitiate').html(res);
                                    enableSummernote();
                                    enableReplyForm();
                                },2000);
                            }
                        },
                        complete : function (){

                        },
                        error : function (){

                        }
                    });
                });

                
                $(document).on('click','#closeTicket',function (){
                    var id = $(this).attr('data-id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url : '{{ route("admin.closeTicket") }}',
                        type : 'POST',
                        data: 'ticket_id='+id,
                        beforeSend : function (){
                            //$("#closeTicket").html("<i class='fa fa-spinner fa-spin'></i> Please wait, closing your ticket...");
                            $(".loader-bg").show();
                        },
                        success : function (res){
                            if(res.status == false){
                                notification('fa-times','Oops..','Unable to close your ticket. Try again after sometime.','danger');
                            }else{
                                notification('fa-check','Yeah..','Your ticket has been closed successfully.','success');
                                window.scrollTo({top: 0, behavior: 'smooth'});
                                setTimeout(function (){ location.reload(); },1000);
                            }
                        },
                        complete : function (){
                            $(".loader-bg").hide();
                        },
                        error : function (){

                        }
                    });
                });


                $(document).on('click','#resolveTicket',function (){
                    var id = $(this).attr('data-id');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url : '{{ route("admin.resolveTicket") }}',
                        type : 'POST',
                        data: 'ticket_id='+id,
                        beforeSend : function (){
                            //$("#closeTicket").html("<i class='fa fa-spinner fa-spin'></i> Please wait, closing your ticket...");
                            $(".loader-bg").show();
                        },
                        success : function (res){
                            if(res.status == false){
                                notification('fa-times','Oops..','Unable to resolve your ticket. Try again after sometime.','danger');
                            }else{
                                notification('fa-check','Yeah..','Your ticket has been resolved successfully.','success');
                                window.scrollTo({top: 0, behavior: 'smooth'});
                                setTimeout(function (){ location.reload(); },1000);
                            }
                        },
                        complete : function (){
                            $(".loader-bg").hide();
                        },
                        error : function (){

                        }
                    });
                });

            });

            function showAttachments() {
                $(".attachment-box").toggle();
            }

            function showAllReplies(ticket_id,page){
                //var page = $(this).attr('href').split('page=')[1];
                $.get("{{ url('admin/support/reply') }}/"+ticket_id+"?page="+page,function (res){
                    if(res.status == false){
                        $("#supportReply").html("Unable to get comments now.Try again after sometime.");
                    }else{
                        $("#supportReply").html(res);
                        setTimeout(function(){ loadImagePlugin(); },1000);
                    }
                });
            }

            function enableSummernote(){
                $('.summernote').summernote({
                    height: 150,
                    placeholder: 'Enter your query in detail...',
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
            }

            function enableReplyForm(){
                var $validations = $('#support-reply');

                $validations.bootstrapValidator({
                    excluded: [':disabled'],
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {
                        support_comment: {
                            message: 'The support comment field is not valid',
                            validators: {
                                callback: {
                                    message: 'The description is required.',
                                    callback: function(value, validator) {
                                        var code = $('[name="support_comment"]').summernote('code');
                                        // <p><br></p> is code generated by Summernote for empty content
                                        return (code !== '' && code !== '<p><br></p>');
                                    }
                                }
                            }
                        },
                    }
                }).on('status.field.bv', function(e, data) {
                    data.bv.disableSubmitButtons(false);
                }).on('error.field.bv', function(e, data) {
                    //notification('fa-times','Oops..','Please fill the reply for the ticket.','danger');
                }).on('success.form.bv', function(e,data) {
                    e.preventDefault();
                    var $form = $(e.target);
                    var bv = $form.data('bootstrapValidator');
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var Data = $("#support-reply").serializeArray();
                    var ticket_id = '{{ $support->ticket_id }}';

                    $.ajax({
                        url : '{{ route("AdminsaveReply") }}',
                        type : 'POST',
                        data: Data,
                        beforeSend : function (){
                            $(".loader-bg").show();
                        },
                        success : function (res){
                            if(res.status == true){
                                notification('fa-check','Yeah..','Reply submitted successfully.','success');
                                $('#support_comment').summernote('reset');
                                setTimeout(function (){ showAllReplies(ticket_id,1) },1000);
                                $(".jFiler-items").remove();
                                $("#filer_input1").val(null);
                            }else{
                                notification('fa-times','Oops..','Unable to submit a reply. Try again after sometime.','danger');
                            }
                        },
                        complete : function (){
                            $(".loader-bg").hide();
                        },
                        error : function (){

                        }
                    });
                });
            }

            function validateDescription(id){
                $('#support-reply').data('bootstrapValidator').revalidateField(id);
            }
        </script>
    @endsection
