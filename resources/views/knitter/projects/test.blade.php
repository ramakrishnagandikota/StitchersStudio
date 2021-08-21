

<div class="pcoded-wrapper">

<div class="pcoded-content">

<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
<!-- Page-body start -->

<div class="page-body">
<div class="row">
<div class="col-xl-4">
<h5 class="theme-heading"><a href="{{url('knitter/project-library')}}"><i class="fa fa-home theme-heading m-r-10"></i></a>{{ucfirst($project->name)}}</h5>
</div>
<div class="col-xl-8 m-b-10 text-right tabber">
<a href="{{url('knitter/project-library')}}" class="btn btn-theme tablike-bt-outlined waves-effect">Project library</a>
<a href="{{url('knitter/project/'.$project->token_key.'/images')}}" class="btn btn-theme tablike-bt-outlined waves-effect">Images</a>
<a href="{{url()->current().'?download=true'}}" class="btn btn-success theme-btn-sm waves-effect waves-light" style="margin-top:0px" id="export-PDF" data-src="{{url('knitter/generate-custom-pattern/'.$id.'/'.$slug)}}"><i class="icofont icofont-print f-20"></i></a>
<!--a href="#!" class="btn btn-default tablike-bt-fill waves-effect">Progress</a> -->
</div>

<div class=" card col-lg-12 p-b-30 m-b-5" id="printable">
<h5 class="card-header-text theme-heading"></h5>
<!-- personal card start -->
<!--First Accordion Starts here-->
<div class="row outline-row m-b-10">
<div class="card-header accordion col-lg-11" data-toggle="collapse" data-target="#section1">
<h5 class="card-header-text">Project information</h5>
</div>
<div class="col-lg-1 m-t-15">
<i class="fa fa-caret-down pull-right micro-icons"></i>
</button>
</div>
</div>
<div class="card-block collapse" id="section1">
<div class="card-block non-custom-pattern">
<div class="row">
<div class="col-lg-8 col-sm-12">
<!--First Accordion Starts here-->
<div class="row theme-row m-b-10">
<div class="card-header border-accordion1 accordion active col-lg-12 col-sm-12" data-toggle="collapse" data-target="#non-custom-design">
<h5 class="card-header-text">Design
                            </h5><i class="fa fa-caret-down pull-right micro-icons"></i>
</div>
</div>
<div class="card-block collapse show" id="non-custom-design">

<div class="form-group row m-b-zero">
<div class="col-md-5">
    <div class="form-group">
        <label class="col-form-label f-w-600">Name
        </label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{ucfirst($project->name)}}</label>
            </div>

        </div>
    </div>
</div>
@if($project->pattern_type)
<div class="col-md-5">
    <div class="form-group">
        <label class="col-form-label f-w-600">Skill level
        </label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{ucfirst($product->skill_level)}}</label>
            </div>

        </div>
    </div>
</div>
@endif
<div class="col-lg-12">
    <div class="form-group">
        <label class="col-form-label f-w-600">Description
        </label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{$project->description}}</label>
            </div>

        </div>

    </div>
</div>
</div>
</div>
<!--End of First Accordion-->

<!--Second Accordion Starts here-->
<div class="row theme-row m-b-10">
<div class="card-header border-accordion1 accordion col-lg-12" data-toggle="collapse" data-target="#yarn-n-tools">
<h5 class="card-header-text">Yarn and tools</h5>
<i class="fa fa-caret-down pull-right micro-icons"></i>
</div>

</div>
<div class="card-block collapse" id="yarn-n-tools">
<div class="form-group row m-b-zero" id="yarn-row-noncustom">
<div class="col-lg-8 row-bg">
    <h6 class="m-b-10">Yarn</h6>
</div>
<div class="col-lg-4 text-right row-bg">
</div>
@if($project_yarn->count() > 0)
<?php $i=0; ?>
@foreach($project_yarn as $py)
<div class="col-md-4">
    <div class="form-group m-b-zero">
        <label class="col-form-label f-w-600">Yarn used</label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{ $py->yarn_used ? $py->yarn_used : 'NA'}}</label>
            </div>

        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label f-w-600">Fiber type used</span>
        </label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{ $py->fiber_type ? $py->fiber_type : 'NA' }}</label>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label f-w-600">Yarn weight used
            </span>
        </label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{ $py->yarn_weight ? $py->yarn_weight : 'NA' }}</label>
            </div>

        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label f-w-600">Colorway</label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{ $py->colourway ? $py->colourway : 'NA' }}</label>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label f-w-600">Dye lot</label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{ $py->dye_lot ? $py->dye_lot : 'NA' }}</label>
            </div>

        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label f-w-600">Skeins</label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{ $py->skeins ? $py->skeins : 'NA' }}</label>
            </div>
        </div>
    </div>
</div>
<div class="col-lg-12">
    <hr>
</div>
<?php $i++; ?>
@endforeach
@endif
</div>

<div class="form-group row m-b-zero" id="needle-row-noncustom">
<div class="col-lg-8 row-bg">
    <h6 class="m-b-10 f-w-600">Needle</h6>
</div>
<div class="col-lg-4 text-right row-bg">

</div>
@if($project_needle->count() > 0)
@foreach($project_needle as $pn)
<?php

?>
<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label f-w-600">Needle</label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">US {{$pn->us_size}} {{ $pn->mm_size ? ' - '.$pn->mm_size.' mm' : '' }} </label>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
</div>

</div>
<!--End of Second Accordion-->

<!--Third Accordion Starts here-->
<div class="row theme-row m-b-10">
<div class="card-header border-accordion1 accordion col-lg-12" data-toggle="collapse" data-target="#gauge">
<h5 class="card-header-text">Gauge</h5>
<i class="fa fa-caret-down pull-right micro-icons"></i>
</div>
</div>
<div class="card-block collapse" id="gauge">
<div class="row">
<div class="col-md-4">
    <div class="form-radio">
        <h6 class="text-muted m-b-10 f-w-600" style="color: #6f6f6f!important;">Unit of measurement</h6>
            <div class="radio radio-inline m-r-10">
                <label class="col-form-label m-l-15"> {{$project->uom == 'in' ? 'Inches' : 'Centimeters' }}</label>
            </div>
        <br>
    </div>
</div>
<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label f-w-600">Stitch gauge</label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{$project->uom == 'in' ? $stitch_gauge->stitch_gauge_inch.' sts / 1 Inches' : $stitch_gauge->stitches_10_cm.' sts / 10 Centimeters' }}</label>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label f-w-600">Row gauge</label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{$project->uom == 'in' ? $row_gauge->row_gauge_inch.' sts / 1 Inches' : $row_gauge->rows_10_cm.' sts / 10 Centimeters' }}</label>
            </div>
        </div>
    </div>
</div>
</div>

</div>
<!--End of Third Accordion-->

<!--Fourth Accordion Starts here-->
<div class="row theme-row m-b-10">
<div class="card-header border-accordion1 accordion col-lg-12" data-toggle="collapse" data-target="#section4-NC">
<h5 class="card-header-text">Measurement profile and ease</h5>
<i class="fa fa-caret-down pull-right micro-icons"></i>
</div>
</div>
<div class="card-block collapse" id="section4-NC">
<div class="row form-group">
<div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label f-w-600">
            Reference a measurement profile
        </label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">For {{ $measurements->m_title ? ucfirst($measurements->m_title) : '' }}</label>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group m-b-zero">
        <label class="col-form-label f-w-600">Your ease preference
        </label>
        <div class="row">
            <div class="col-md-12">
                <label class="col-form-label m-l-15">{{ $project->uom == 'in' ? $project->ease.'"' : $project->ease.'cm' }}</label>
            </div>
        </div>
    </div>
</div>
</div>

</div>
<!--End of Fourth Accordion-->

<!--Fifth Accordion-->
<div class="row theme-row m-b-10">
    <div class="card-header border-accordion1 accordion col-lg-12" data-toggle="collapse" data-target="#section5-NC">
        <h5 class="card-header-text">Pattern-specific measurements</h5>
        <i class="fa fa-caret-down pull-right micro-icons"></i>
    </div>
</div>
<div class="card-block collapse" id="section5-NC">
    <div class="row form-group">

        @if($pdm->count() > 0)
        @foreach($pdm as $pd)
        <?php
        $name = ucfirst($pd->measurement_name);
        ?>
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-form-label f-w-600"> {{str_replace('_',' ',$name)}}
                </label>
                <div class="row">
                    <div class="col-md-12">
                        <label class="col-form-label m-l-15">{{ $pd->measurement_value ? $pd->measurement_value : 'NA' }}</label>
                    </div>

                </div>
            </div>
        </div>
        @endforeach

        @endif

    </div>
</div>

</div>
<div class="col-lg-4 col-sm-12">

<div class="form-group row">
<!-- <label class="col-sm-12 col-lg-12 col-form-label">Knitted For</label> -->
@if($project_images->count() > 0)
<?php foreach($project_images as $pi); ?>
<div class="col-sm-12 col-lg-12">
<img src="{{$pi->image_path ? $pi->image_path : ''}}" alt="" style="width:100%; ">
</div>
@endif
</div>
</div>

</div>

</div>
</div>

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
        <!-- <span class="delete-note">Double click on Note to Delete it</span> -->
        <h5 class="text-center blank-message">You don't have any Notes</h5>
        <br>
        <p></p>
        <ul id="task-list">
            @if($project_notes->count() > 0)
            @foreach($project_notes as $note)
            <li id="task-card{{$note->id}}" data-id="{{$note->id}}" class="{{ $note->status == 2 ? 'complete' : '' }}">
                <i class="fa fa-trash delete-item" data-id="{{$note->id}}"></i>
                <p>{{$note->notes}}</p>
            </li>
            @endforeach

            @endif
        </ul>
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

    <!-- To Do Card List card end -->
</div>
<div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 498px;"></div>
<div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>
</div>
</div>
</div>
</div>
</div>
<div>
<a class="open-commentbox openbtn" id="commentBox" onclick="opencommentbar()">
<i class="fa fa-pencil-square-o"></i>
</a>
</div>
</div>
</div>
</div>

<div class="row m-b-10">
<div class="col-lg-12 card panel-group" id="accordion">

<!--New Accordion Starts here-->
<div class="row">

{!! $cont !!}

</div>
<!--New Accordion Ends here-->
<!--New Accordion Starts here-->

</div>
</div>
</div>

</div>

</div>
<!-- Page-body end -->

</div>
</div>
</div>



<div class="modal fade" id="child-Modal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                          <h5 class="modal-title">Confirmation</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p></p>
                           <p class="text-center"> <img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo" /></p>
                           <h6 class="text-center">Do you really want to delete all notes ?</h6>
                           <p></p>
                    </div>
                    <div class="modal-footer">
                            <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                            <button  id="clear-all-tasks" type="button" class="btn btn-danger delete-card" data-dismiss="modal">Delete</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="delete-single-Modal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                          <h5 class="modal-title">Confirmation</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p></p>
                        <input type="hidden" id="notes_id" value="0">
                           <p class="text-center"> <img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo" /></p>
                           <h6 class="text-center">Do You really want to delete a selected note ?</h6>
                           <p></p>
                    </div>
                    <div class="modal-footer">
                            <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger delete-single-card" data-dismiss="modal">Delete</button>
                    </div>
                  </div>
                </div>
              </div>

<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

<script type="text/javascript">
    var insertTaskURL = '{{url("knitter/addNotes")}}';
    var completeTaskURL = '{{url("knitter/noteComplete")}}';
    var deleteAllNote = '{{url("knitter/deleteAllNote")}}';
    var project_id = '{{$project->id}}';
</script>

<script type="text/javascript">
$(document).ready(function() {
    onloadScript();
    $('[data-toggle="tooltip"]').tooltip();

    $('[data-toggle="popover"]').popover({
        html: true,
        content: function() {
            return $('#primary-popover-content').html();
        }
    });

    $('.delete-single-card').click(function()
    {
        var notes_id = $("#notes_id").val();

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.post('{{url("knitter/deleteNote")}}', { id: notes_id},function(res){
        if(res.status == 'success'){
          $("#task-card"+notes_id).remove();
          if($("#task-list li").length > 0){
            $('.blank-message').show();
          }
        }else{
          alert('Unable to mark the note complete, Try again after some time.');
        }
      });

    });


    var active = false;

    $('#toogleAccordion').click(function () {
        if (active) {
            active = false;
            $('.card-block').collapse('show');
            $('.panel-title').attr('data-toggle', '');
            $(this).text('Collapse all');
        } else {
            active = true;
            $('.card-block').collapse('hide');
            $('.panel-title').attr('data-toggle', 'collapse');
            $(this).text('Show all');
        }
    });

    $('#accordion').on('show.bs.collapse', function () {
        if (active) $('#accordion .in').collapse('hide');
    });

    $('#export-PDF').click(function(){
       // $('.card-block').collapse('show');
        //setTimeout(printPDF(),5000);

    var src = $(this).attr('data-src');
    $.get(src,function(res){
        window.open(res,'_blank');
    });

    });


$(document).on('click','.print',function(){
    var src = $(this).attr('data-src');
    $.get(src,function(res){
        window.open(res,'_blank');
    });
});

});


function opencommentbar() {
    document.getElementById("comment-sidebar").style.width = "340px";
}

/* Set the width of the sidebar to 0 (hide it) */
function closecommentbar() {
    document.getElementById("comment-sidebar").style.width = "0";
}

function onloadScript(){
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    }
  });
}
}

function printPDF()
{
    window.print();
}
</script>
