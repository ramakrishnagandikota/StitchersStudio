@extends('layouts.adminnew')
@section('title','Sample Instructions')
@section('section1')
    <div class="page-body">
        <div class="row">
            <div class="col-lg-6"><h5 class="theme-heading p-10">Sample Instructions</h5></div>
        </div>
        <div class="card p-20">
            <div class="dt-responsive table-responsive">

                <table id="example2" class="table table-striped table-bordered nowrap">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Function name</th>
                        <th>Sample instruction</th>
                        <th>Sample Output</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Function name</th>
                        <th>Sample instruction</th>
                        <th>Sample Output</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                </table>
            </div>


        </div>
    </div>



    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sample Instruction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="updateOutputVariables">
                        <input type="hidden" name="id" id="id" value="0">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Function Name</label>
                            <input type="text" readonly id="function_name" class="form-control" placeholder="Function name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Sample Instruction</label>
                            <textarea id="sample_instruction" name="sample_instruction" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Output Instruction</label>
                            <textarea id="output_instruction" name="output_instruction" class="form-control"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="save" class="btn btn-success">Save Instructions</button>
                </div>
            </div>
        </div>
    </div>

    <?php $v=0; $variables = ''; ?>
    @foreach($outputVariables as $ov)
        @php
            if($v == $outputVariables->count() - 1){
                $variables.= '"'.$ov->variable_name.'",';
            }else{
                $variables.= '"'.$ov->variable_name.'",';
            }

        @endphp
        <?php $v++; ?>
    @endforeach
    <?php
    $variables.='';
    ?>
@endsection
@section('footerscript')
    <style>
        .dataTables_filter .form-control{margin-top: 0px;line-height: 1.8;}
        .table td, .table th {
            padding: 0.55rem 0.75rem;
            font-size: 14px;
        }
        .table td:nth-child(2),td:nth-child(3){
            text-align: left !important;
        }
        #example2_filter label:nth-child(1){
            float:right;
        }
        .fa-pencil{
            color: #333 !important;
            padding: 0px !important;
            background: none !important;
        }
        .addReadMoreWrapTxt.showmorecontent .SecSec,
        .addReadMoreWrapTxt.showmorecontent .readLess {
            display: block;
        }
        .addReadMore.showlesscontent .SecSec,
        .addReadMore.showlesscontent .readLess {
            display: none;
        }

        .addReadMore.showmorecontent .readMore {
            display: none;
        }
        .readMore,.readLess,#loadMores,#top {
            color: #0d665c;
            font-weight: bold;
            cursor: pointer;
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

    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/summernote/summernote.min.css') }}" />
    <script type="text/javascript" src="{{ asset('resources/assets/summernote/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            setTimeout(function(){ AddReadMore(); summernote(); },2000);
            $('#example2').DataTable({
                "ajax": '{{ route('adminnew.sampleInstructions') }}',
                "columns": [
                    { "data": "id" },
                    { "data": "function_name" },
                    { "data": "sample_instruction" },
                    { "data": "output_instruction" },
                    { "data": "action" }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    'csvHtml5',
                    'pdfHtml5',
                ]
            });


            $(document).on('click','.editSampleInstructions',function (){
                var id = $(this).attr('data-id');
                //var summernote = $("#sample_instruction").summernote();
                var summernote1 = $("#output_instruction").summernote();

                $.get('{{ url("adminnew/edit-sampleinstructions/") }}/'+id,function (res){
                    $("#id").val(res.id);
                    $("#function_name").val(res.function_name);
                    $("#sample_instruction").summernote('code',res.sample_instruction);
                    summernote1.summernote('code',res.output_instruction);
                });
            });

            $(document).on('click','#save',function (){
                var Data = $("#updateOutputVariables").serializeArray();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url : '{{ route("adminnew.updateSampleInstructions") }}',
                    type : 'POST',
                    data : Data,
                    beforeSend : function (){
                        $(".loading").show();
                    },
                    success : function (res){
                        if(res.status == 'success'){
                            $("#updateOutputVariables")[0].reset();
                            $(".bd-example-modal-lg").modal('hide');
                            $('#example2').DataTable().ajax.reload();
                            setTimeout(function(){ AddReadMore(); },3000);
                        }else{
                            alert('Unable to update data.Please refresh & try again.');
                        }
                    },
                    error : function (){
                        alert('Unable to update data.Please refresh & try again.');
                    },
                    complete : function (){
                        $(".loading").hide();
                    }
                });
            });

        });

        function AddReadMore() {
            //This limit you can set after how much characters you want to show Read More.
            var carLmt = 50;
            // Text to show when text is collapsed
            var readMoreTxt = " ... Read More";
            // Text to show when text is expanded
            var readLessTxt = " Read Less";


            //Traverse all selectors with this class and manupulate HTML part to show Read More
            $(".addReadMore").each(function() {
                if ($(this).find(".firstSec").length)
                    return;

                var allstr = $(this).text();
                if (allstr.length > carLmt) {
                    var firstSet = allstr.substring(0, carLmt);
                    var secdHalf = allstr.substring(carLmt, allstr.length);
                    var strtoadd = firstSet + "<span class='SecSec'>" + secdHalf + "</span><span class='readMore'  title='Click to Show More'>" + readMoreTxt + "</span><span class='readLess' title='Click to Show Less'>" + readLessTxt + "</span>";
                    $(this).html(strtoadd);
                }

            });
            //Read More and Read Less Click Event binding
            $(document).on("click", ".readMore", function() {
                //alert('clicked')
                $(this).closest(".addReadMore").removeClass("showlesscontent").addClass('showmorecontent');
            });

            $(document).on("click", ".readLess", function() {
                //alert('clicked')
                $(this).closest(".addReadMore").removeClass("showmorecontent").addClass('showlesscontent');
            });
        }

        function summernote(){
            $("#sample_instruction").summernote({
                hint: {
                    mentions: [<?php echo $variables; ?>],
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
        }
    </script>
@endsection
