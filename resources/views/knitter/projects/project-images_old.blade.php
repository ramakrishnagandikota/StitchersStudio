@extends('layouts.knitterapp')
@section('title','Knitter Project Library')
@section('content')

<div class="pcoded-wrapper">

<div class="pcoded-content">
<div class="pcoded-inner-content">
<div class="main-body">
<div class="page-wrapper">
    <!-- Page-body start -->
    <div class="page-body">
        <div class="row m-t-50 m-b-20">
                <div class="col-xl-4">
                        <h5 class="theme-heading"><a href="{{url('knitter/create-project')}}"><i class="fa fa-home theme-heading m-r-10"></i></a>Images </h5>
                    </div>
                        <div class="col-xl-8 text-right tabber">
                            <a href="{{url('knitter/project-library')}}" class="btn btn-default tablike-bt-outlined waves-effect">Project library</a>
                            @if($project->pattern_type == 'external')
                            <a href="{{url('knitter/generate-pattern/'.$project->token_key.'/'.Str::slug($project->name))}}" class="btn btn-default tablike-bt-outlined  waves-effect">Pattern instructions</a>
                            @elseif($project->pattern_type == 'custom')
                            <a href="{{url('knitter/generate-custom-pattern/'.$project->token_key.'/'.Str::slug($project->name))}}" class="btn btn-default tablike-bt-outlined  waves-effect">Pattern instructions</a>
                            @else
                            <a href="{{url('knitter/generate-noncustom-pattern/'.$project->token_key.'/'.Str::slug($project->name))}}" class="btn btn-default tablike-bt-outlined  waves-effect">Pattern instructions</a>
                            @endif
                            <!-- <a href="Ref-images.html" class="btn btn-default tablike-bt-fill waves-effect">Images</a> -->
                            <!--a href="#!" class="btn btn-default tablike-bt-fill waves-effect">Progress</a> -->
                         </div>
        </div>
        <div class="row">
            <div class="col-lg-12 card">
           <!-- File upload card start -->
                    <div class="row theme-row m-b-10 m-t-10">
                        <div class="card-header border-accordion1 accordion active col-lg-12" data-toggle="collapse" data-target="#section1">
                            <h5 class="card-header-text">Reference images</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                        </div>
                       
                    </div>

                     <!-- Image gallery card start -->

                <div class="collapse show" id="section1">
                    <div class="card-block">
                        <!-- <p> Add this code <code>data-gallery="example-gallery"</code> to see image gallery in lightbox popup. </p> -->
                        <div class="row custom-padding-row">
                            @if($product_images->count() > 0)
                            @foreach($product_images as $pim)
                            <div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12 custom-padding-column">
                                <a href="{{$pim->image_large}}" data-toggle="lightbox" data-gallery="example-gallery">
                                    <img src="{{$pim->image_large}}" class="img-fluid m-b-10" alt="">
                                </a>
                            </div>
                            @endforeach
                            @else
                            <p class="text-center">No reference images found for this project.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- Image gallery card end -->
                     
        </div>
       
            <!-- File upload card end -->
        </div>
      


        <div class="row">
            <div class="col-lg-12 card">
           <!-- File upload card start -->
                    <div class="row theme-row m-b-10 m-t-10">
                        <div class="card-header border-accordion1 accordion active col-lg-12" data-toggle="collapse" data-target="#section2">
                            <h5 class="card-header-text">My images</h5><i class="fa fa-caret-down pull-right micro-icons"></i>
                        </div>
                       
                        </div>
                     
                        <!-- Image gallery card start -->
                <div class="collapse" id="section2">
                    <div class="card-block">
                        <!-- <p> Add this code <code>data-gallery="example-gallery"</code> to see image gallery in lightbox popup. </p> -->
                        
                        <div class="row custom-padding-row" id="gallery_images">
                        	@if($project_images->count() > 0)
                           @foreach($project_images as $pi)
                            <div class="col-xl-2 col-lg-3 col-sm-3 col-xs-12 custom-padding-column">
                                <a href="{{$pi->image_path}}" data-toggle="lightbox" data-gallery="example-gallery">
                                    <img src="{{$pi->image_path}}" class="img-fluid m-b-10" alt="">
                                </a>
                            </div>
                            
                           @endforeach
                           @endif
                        </div>
                        
                    </div>
                    <hr class="m-t-0">
                    <div class="card-block">
                        <input type="file" name="file[]" id="filer_input1" multiple="multiple">
                        </div>
                </div>
                <!-- Image gallery card end -->
                  
        </div>
       
            <!-- File upload card end -->
        </div>
      
    </div>
</div>
</div>
</div>
</div>
</div>

@endsection

@section('footerscript')
<noscript>
<style>
    .es-carousel ul{
        display:block;
    }
    
</style>
</noscript>

<style>
.img-radius{border-radius: 5px !important}
.pcoded-inner-content{margin-top: 0px;}
.pcoded .pcoded-header {
background: white;
box-shadow:1px 0px 6px 0px #bfbfbf;
}
.jFiler-input-dragDrop{width: 70% !important}
</style>
<script type="text/javascript">
	var URL = '{{url("knitter/project/my-images/".$project->id)}}';
    var PAGE = '';
</script>
<!-- light-box css -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/bower_components/ekko-lightbox/css/ekko-lightbox.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/bower_components/lightbox2/css/lightbox.css') }}">
 <!-- jquery file upload Frame work -->
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />

	<!-- light-box js -->
	<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/ekko-lightbox/js/ekko-lightbox.js') }}"></script>
	<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/lightbox2/js/lightbox.js') }}"></script>

	<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

<script src="{{ asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/filer/project-images.fileupload.init.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    //light box
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>

@endsection