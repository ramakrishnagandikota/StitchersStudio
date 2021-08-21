@extends('layouts.connect')
@section('title','My Gallery')
@section('content')

 <!-- Page-body start -->
<div class="page-body m-t-15">
           <!-- Page body start -->
<div class="page-body gallery-page">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
             <a href="#accordion1" class="list-group-item list-group-item f-w-600" style="margin-bottom: 11px;" data-toggle="collapse" data-parent="#MainMenu"> Filter photos <i class="fa fa-caret-down pull-right m-t-5"></i></a>
             <div class="collapse show" id="accordion1">
                 <div class="list-group-item" style="border-bottom: none;">
                     <div class="col-lg-12">
                                     <div class="skills-mutliSelect" id="collection-filter">
                                         <ul>
                                         <label class="container">All
                                             <input type="checkbox" value="all">
                                             <span class="checkmark"></span>
                                         </label>
                                         <label class="container">Posted by me
                                             <input type="checkbox" value="self_posted">
                                             <span class="checkmark"></span>
                                         </label>
                                       <!--  <label class="container">Tagged in
                                         <input type="checkbox" value="tagged_in">
                                             <span class="checkmark"></span>
                                         </label> -->
                                         <label class="container">My project photos
                                         <input type="checkbox" value="my_project">
                                             <span class="checkmark"></span>
                                             </label>
                                         </ul>
                                     </div>
                         </div>
                     </div>
             </div>
            </div>
         </div>
        <!-- image grid -->
        <div class="col-sm-9">
            <!-- Image grid card start -->
            <div class="card">

                <div class="content">
                    <!--<h4 class="text-center m-t-20">2018</h4> -->
                    <div class="gg-container">
                        
                    <div class="gg-box dark" id="square-1">
@if($timeline_images->count() > 0)
<?php $i=1; ?>
    @foreach($timeline_images as $ti)
        <img data-id="{{$i}}" class=" self_posted all hide sectionContent" src="{{ $ti->image_path }}">
<?php $i++; ?>
    @endforeach
@endif

@if($project_images->count() > 0)
<?php $j= $timeline_images->count() +1; ?>
    @foreach($project_images as $pi)
    <img data-id="{{$j}}" class="my_project all hide sectionContent" src="{{ $pi->image_path }}">
<?php $j++; ?>
    @endforeach
@endif
                    </div>
    @if($timeline_images->count() > 0 && $project_images->count() > 0)
    <div style="color: #bbd6bb;font-size: 16px;text-decoration: underline;text-align: center;margin-bottom: 15px;margin-bottom: 10px;"><a href="javascript:;" id="show-more">Show more</a></div>
    @else
    <div class="text-center p-b-20">No Images to show in gallery</div>
    @endif
                    </div>
                </div>


            </div>
            <!-- Image grid card end -->
        </div>
    </div>
</div>
                        <!-- Page body end -->
</div>
@endsection
@section('footerscript')
<style>

       .hide{
    	display: none;
    }
</style>
<script type="text/javascript">
  var CLOSE = '{{asset('resources/assets/marketplace/images/close.png')}}';
</script>

<script src="{{ asset('resources/assets/files/assets/pages/waves/js/waves.min.js') }}"></script>
<!-- jquery slimscroll js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-slimscroll/js/jquery.slimscroll.js') }}"></script>
<!-- modernizr js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/modernizr/js/modernizr.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/modernizr/js/css-scrollbars.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/lightbox2/js/lightbox.min.js') }}"></script>

<link rel="stylesheet" href="{{ asset('resources/assets/marketplace/js/grid-gallery.css') }}">
<script src="{{ asset('resources/assets/marketplace/js/grid-gallery-original.js') }}"></script>

    <script>
    	var sections = $('.sectionContent');
        $(document).ready(function() {

        	updateContentVisibility();

  /*  gridGallery({
      selector: "#horizontal-1",
      layout: "horizontal"
    }); */
    gridGallery({
      selector: "#square-1",
      layout: "square"
    });

            var x = 30;
var totalImages = $("#square-1 > img.hide").length;
//$(".fbphotobox img").hide();

$("#square-1 > img.hide:lt("+x+")").removeClass('hide');

$(document).on('click','#show-more',function(){ debugger
    var hidden = $("#square-1 > img.hide").length;
    //alert(hidden);
	if(x < hidden){
		x = 30;
	}else{
		x = hidden;
	}
	$("#square-1 > img.hide:lt("+x+")").removeClass('hide');

	setTimeout(function(){
    var hiddennew = $("#square-1 > img.hide").length;
    if(hiddennew == 0){
      $("#show-more").addClass('hide');
    }
  },2000);
});


$("#collection-filter :checkbox").click(updateContentVisibility);

        });


function updateContentVisibility(){
    var checked = $("#collection-filter :checkbox:checked");
    //if(sections.length == 0){

            //}
    if(checked.length){
        sections.addClass('hide');
        checked.each(function(){
            $("." + $(this).val()).removeClass('hide');

        });
    } else {
        //sections.removeClass('hide');
    }

     if ( $("div.sectionContent:visible").length === 0){
        $("#noproducts").removeClass('hide');
     }else{
        $("#noproducts").addClass('hide');
     }

}
    </script>

@endsection
