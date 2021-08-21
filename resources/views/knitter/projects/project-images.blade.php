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
                            <div class="gg-container col-md-12">
                                <div class="gg-box dark" id="square-1">
                                    <?php $i=1; ?>
                            @foreach($product_images as $pim)
                                <img data-id="{{$i}}" class=" self_posted all hide sectionContent" src="{{ $pim->image }}">
                                <?php $i++; ?>
                            @endforeach
                               </div>
                            </div>
                            @else
                            <p class="text-center" style="width: 100%;">No reference images found for this project.</p>
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
                            <div class="gg-container">
                                <div class="gg-box dark" id="square-2">
                                    <?php $j=1; ?>
                           @foreach($project_images as $pi)
                                @if($pi->image_ext != 'pdf')
                                <img data-id="{{$j}}" class=" self_posted all hide sectionContent" src="{{ $pi->image_path }}">
                                @endif
                                <?php $j++; ?>
                           @endforeach
                       </div>
                   </div>
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

<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

<script src="{{ asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/filer/project-images.fileupload.init.js') }}" type="text/javascript"></script>

<link rel="stylesheet" href="{{ asset('resources/assets/marketplace/js/grid-gallery.css') }}">
<script src="{{ asset('resources/assets/marketplace/js/grid-gallery-original.js') }}"></script>

@if($product_images->count() > 0)
<script type="text/javascript">
    //light box
    $(function(){
		gridGallery({
		  selector: "#square-1",
		  layout: "square"
		});
    });
</script>
@endif

@if($project_images->count() > 0)
<script type="text/javascript">
    //light box
    $(function(){
        gridGallery({
          selector: "#square-2",
          layout: "square"
        });
    });
</script>
@endif
@endsection