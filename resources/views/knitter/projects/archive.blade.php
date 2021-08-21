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
  <div class="row">

@if(Auth::user()->isSubscriptionExpired())
@if(Auth::user()->remainingDays() <= 5)
  <div class="col-lg-12 alert alert-danger">
You have only {{Auth::user()->remainingDays()}} days left in your subscription. Your subscription ends on {{date('d/F/Y',strtotime(Auth::user()->sub_exp))}}.
</div>
@endif

@else
<div class="col-lg-12 alert alert-danger">
Your subscription is ended.
</div>
@endif


     <div class="col-xl-4">
        <h5 class="theme-heading"><a href="Create-Project.html"><i class="fa fa-home theme-heading m-r-10"></i></a> My archive </h5>
     </div>
     <div class="col-xl-8 text-right tabber">
              <a href="{{url('knitter/project-library')}}" class="btn btn-default tablike-bt-outlined waves-effect">Project library</a>
        <!--a href="#!" class="btn btn-default tablike-bt-outlined waves-effect">Notes</!--a>
           <a href="#!" class="btn btn-default tablike-bt-fill waves-effect">Progress</a> -->
     </div>
  </div>
  <div class="row m-t-30 justify-content-center">

@php 
$projects = Auth::user()->projects()->where('is_deleted',0)->first();
@endphp

     <!--Not Started Starts here-->
     <div class="col-lg-4 col-xl-4">
        <!-- Draggable Without Images card start -->
        <h5 class="card-header-text m-b-20 text-muted">New Patterns
		<span class="mytooltip tooltip-effect-2" >
                <span class="tooltip-item">?</span>
                <span class="tooltip-content clearfix" id="Customtooltip">
                    <span class="tooltip-text" style="width: 100%;">Patterns purchased in StitchersStudio Shop will appear here. Click on your project to add details and save it to move this project to 'Works in Progress'.
                    </span>
                </span>
            </span>
			</h5>
        <div class="card-block">
           <div class="row">
            @if($orders->count() > 0)
              <ul id="sortable1" class='droptrue'>
@foreach($orders as $ord)
<?php
$images = App\Models\Product_images::where('product_id',$ord->pid)->first();
if($images){
  $image = $images->image_small;
  }else{
    $image = 'https://via.placeholder.com/200?text='.$ord->product_name;
  }
 ?>
<li id="new_patterns{{$ord->id}}" data-id="0">
  <div class="col-md-12 m-b-20">
      <div class="card-sub-custom">
          <div class="card-block">
              <div class="row">
                <div class="col-lg-4" style="background-image: url({{ $image  }});background-size: cover;background-position: center center;display: block;height: 124px;">
				
                </div>
             <div class="col-lg-8"><h6 class="card-title">{{ucfirst($ord->product_name)}}</h6>
			 @if($ord->is_custom == 1)
<img class="img-fluid strip-image" src="{{ asset('resources/assets//files/assets/images/headerLogo-old.png') }}" alt="Theme-Logo" />
@endif
      </div>
          </div>
              </div>
              <div class="card-footer-custom">
                  <div class="dropdown-secondary dropdown text-right">
                      <span class="m-r-60"><i class="fa fa-calendar-check-o text-muted m-r-10 f-12"></i><span class="text-muted f-12">{{date('d M, Y',strtotime($ord->created_at))}}</span></span>
                  <button class="btn-vert-toggle text-muted" type="button" id="dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                   <div class="dropdown-menu notifications" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                   <!--    <a class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#myModal"> Post on the wall</a> -->
                       <a class="dropdown-item waves-light waves-effect note addProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$ord->id}}" >Add back to project library</a>

                   </div>
                   <!-- end of dropdown menu -->
               </div>
           </div>
      </div>
  </div>
</li>
@endforeach
              </ul>
              @else
          <p>No available orders</p>
              @endif
           </div>
        </div>
        <!-- Draggable Without Images card end -->
     </div>
     <!--Not Started Ends here-->
     <!--In Progress Starts Here-->
    <!-- <div class="col-lg-3 col-xl-3">
        <!-- Draggable Without Images card start --
        <h5 class="card-header-text m-b-20 text-muted">Generated Patterns</h5>
        <div class="card-block">
           <div class="row">
            @if($generatedpatterns->count() > 0)
              <ul  id="sortable2" class='droptrue'>

                @foreach($generatedpatterns as $gp)
                <?php
$measurement = DB::table('user_measurements')->where('id',$gp->measurement_profile)->select('m_title')->first();
if($measurement){
    $title = $measurement->m_title;
}else{
    $title = 'No Name';
}
                $image = App\Models\Project::find($gp->pid)->project_images()->where('image_ext','!=','pdf')->first();
                if($image){
          $i1 = $image->image_path;
        }else{
          $i1 = '';
        }
                ?>
                 <li class="" id="generatedpatterns{{$gp->pid}}" data-id="{{$gp->pid}}">
                    <div class="col-md-12 m-b-20">
                       <div class="card-sub-custom">
                          <div class="card-block">
                             <div class="row">
                                <div class="col-lg-4" >
                                <div class="card-img-bg" style="background-image: url({{ $i1  }});background-size: cover;background-position: center center;display: block;height: 99px;">
                                </div>
                                </div>
                                <div class="col-lg-8">

                                   @if($gp->pattern_type == 'custom')
                                <a href="{{url('knitter/generate-custom-pattern/'.$gp->token_key.'/'.Str::slug($gp->name))}}"><h6 class="card-title">{{ucfirst($gp->name)}}</h6></a>
                                @elseif($gp->pattern_type =='non-custom')
                                <a href="{{url('knitter/generate-noncustom-pattern/'.$gp->token_key.'/'.Str::slug($gp->name))}}"><h6 class="card-title">{{ucfirst($gp->name)}}</h6></a>
                                @else
                                    <a href="{{url('knitter/generate-pattern/'.$gp->token_key.'/'.Str::slug($gp->name))}}"><h6 class="card-title">{{ucfirst($gp->name)}}</h6></a>
                                @endif
                                <div class="f-10"><strong>profile :</strong> {{ $title}}</div>
								<div class="f-10 m-b-30">
                                  <u class="view-more" data-title="{{ucfirst($gp->name)}}" data-id="{{$gp->pid}}" data-toggle="modal" data-target="#CarddetailsModal" >View more
                                  </u>
                                </div>
                                </div>
                             </div>
                          </div>
                          <div class="card-footer-custom">
                             <div class="dropdown-secondary dropdown text-right">
                                <span class="m-r-60"><i class="fa fa-calendar-check-o text-muted m-r-10 f-12"></i><span class="text-muted f-12" id="date{{$gp->pid}}">{{date('d M, Y',strtotime($gp->updated_at))}}</span></span>
                                <button class="btn-vert-toggle text-muted" type="button" id="dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu notifications" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" id="dropdown{{$gp->pid}}">
                                 <!--  <a class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#myModal"> Post on the wall</a> --
                                 <a class="dropdown-item waves-light waves-effect note addToProjects" href="javascript:;"  data-id="{{$gp->pid}}" >Add back to project library</a>

                                 <a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$gp->pid}}" data-dropid="sortable3" data-current="generatedpatterns" data-target="workinprogress" >Add To Work in progress</a>

                                   <a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$gp->pid}}" data-dropid="sortable4" data-current="generatedpatterns" data-target="completed" >Add To Complete</a>

                                   
                                   <a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="{{$gp->pid}}" data-target="#delete-Modal"> Delete</a>
                                </div>
                                <!-- end of dropdown menu --
                             </div>
                          </div>
                       </div>
                    </div>
                 </li>
                 @endforeach
              </ul>
              @else
              <ul  id="sortable2" class='droptrue'>


              </ul>
              @endif
           </div>
        </div>
        <!-- Draggable Without Images card end --
     </div> -->
     <!--In Progress Ends here-->
     <!--Completed Starts here-->
     <div class="col-lg-4 col-xl-4">
        <!-- Draggable Without Images card start -->
        <h5 class="card-header-text m-b-20 text-muted">Work in Progress
			<span class="mytooltip tooltip-effect-2" >
                <span class="tooltip-item">?</span>
                    <span class="tooltip-content clearfix" id="Customtooltip">
                        <span class="tooltip-text" style="width: 100%;">After you add pattern information and save your project, it will appear here.
                        </span>
                </span>
            </span>
		</h5>
        <div class="card-block">
           <div class="row">
              @if($workinprogress->count() > 0)
              <ul  id="sortable3" class='droptrue'>
                @foreach($workinprogress as $wp)
                <?php
                  $measurement1 = DB::table('user_measurements')->where('id',$wp->measurement_profile)->select('m_title')->first();
                  if($measurement1){
    $title1 = $measurement1->m_title;
}else{
    $title1 = 'No Name';
}
                $image2 = App\Models\Project::find($wp->pid)->project_images()->where('image_ext','!=','pdf')->first();
                if($image2){
          $i2 = $image2->image_path;
        }else{
          $i2 = '';
        }
                ?>
                 <li class="" id="workinprogress{{$wp->pid}}" data-id="{{$wp->pid}}" >
                    <div class="col-md-12 m-b-20">
                       <div class="card-sub-custom">
                          <div class="card-block">
                             <div class="row">
                                <div class="col-lg-4" >
                                    <div class="card-img-bg" style="background-image: url({{ $i2  }});background-size: cover;background-position: center center;display: block;height: 124px;">
									
                                </div>
                                </div>
                                <div class="col-lg-8">

                                   @if($wp->pattern_type == 'custom')
                                    <a href="{{url('knitter/generate-custom-pattern/'.$wp->token_key.'/'.Str::slug($wp->name))}}"><h6 class="card-title"> {{ucfirst($wp->name)}}</h6></a>
                                    @elseif($wp->pattern_type == 'non-custom')
                                    <a href="{{url('knitter/generate-noncustom-pattern/'.$wp->token_key.'/'.Str::slug($wp->name))}}"> <h6 class="card-title">{{ucfirst($wp->name)}}</h6></a>
                                    @else
                                    <a href="{{url('knitter/generate-pattern/'.$wp->token_key.'/'.Str::slug($wp->name))}}"><h6 class="card-title"> {{ucfirst($wp->name)}}</h6></a>
                                    @endif
									@if($wp->pattern_type == 'custom')
								<img class="img-fluid strip-image" src="{{ asset('resources/assets//files/assets/images/headerLogo-old.png') }}" alt="Theme-Logo" />
								@endif

                                    <div class="f-10"><strong>Measurement profile :</strong> {{ $title1 }}</div>
									<div class="f-10 m-b-30">
                                  <u class="view-more" data-title="{{ucfirst($wp->name)}}" data-id="{{$wp->pid}}" data-toggle="modal" data-target="#CarddetailsModal" >View more
                                  </u>
                                </div>
                                </div>
                             </div>
                          </div>
                          <div class="card-footer-custom">
                             <div class="dropdown-secondary dropdown text-right">
                                <span class="m-r-60"><i class="fa fa-calendar-check-o text-muted m-r-10 f-12"></i><span class="text-muted f-12" id="date{{$wp->pid}}">{{date('d M, Y',strtotime($wp->updated_at))}}</span></span>
                                <button class="btn-vert-toggle text-muted" type="button" id="dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu notifications" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" id="dropdown{{$wp->pid}}">
                                 <!--  <a class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#myModal"> Post on the wall</a> -->
                                   <a class="dropdown-item waves-light waves-effect note addToProjects" href="javascript:;"  data-id="{{$wp->pid}}" >Add back to project library</a>
                                  <!-- <a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$wp->pid}}" data-dropid="sortable2" data-current="workinprogress" data-target="generatedpatterns" >Add To Generated patterns</a> -->

                                   <a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$wp->pid}}" data-dropid="sortable4" data-current="workinprogress" data-target="completed">Add To Complete</a>
                                   <a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="{{$wp->pid}}" data-target="#delete-Modal"> Delete</a>
                                </div>
                                <!-- end of dropdown menu -->
                             </div>
                          </div>
                       </div>
                    </div>
                 </li>
                 @endforeach
              </ul>
              @else
              <ul  id="sortable3" class='droptrue'>

              </ul>
              @endif
           </div>
        </div>
        <!-- Draggable Without Images card end -->
     </div>
     <!--Completed Ends here-->
     <!--Completed Starts here-->
     <div class="col-lg-4 col-xl-4">
        <!-- Draggable Without Images card start -->
        <h5 class="card-header-text m-b-20 text-muted">Completed
		
			<span class="mytooltip tooltip-effect-2" >
                <span class="tooltip-item">?</span>
                    <span class="tooltip-content clearfix" id="Customtooltip">
                        <span class="tooltip-text" style="width: 100%;">Gaze upon all your gorgeous and neatly organized finished objects!</span>
                </span>
            </span>
			</h5>
        <div class="card-block">
           <div class="row">
              @if($completed->count() > 0)
              <ul  id="sortable4" class='droptrue'>
                @foreach($completed as $com)
                <?php
                $measurement2 = DB::table('user_measurements')->where('id',$com->measurement_profile)->select('m_title')->first();
                if($measurement2){
    $title2 = $measurement2->m_title;
}else{
    $title2 = 'No Name';
}
                $image3 = App\Models\Project::find($com->pid)->project_images()->where('image_ext','!=','pdf')->first();
                if($image3){
          $i3 = $image3->image_path;
        }else{
          $i3 = '';
        }
                ?>
                 <li class="" id="completed{{$com->pid}}" data-id="{{$com->pid}}">
                    <div class="col-md-12 m-b-20">
                       <div class="card-sub-custom">
                          <div class="card-block">
                             <div class="row">
                                <div class="col-lg-4" >
                                    <div class="card-img-bg"  style="background-image: url({{ $i3  }});background-size: cover;background-position: center center;display: block;height: 124px;">
									
                                </div>
                                </div>
                                <div class="col-lg-8">

                                   @if($com->pattern_type == 'custom')
                                    <a href="{{url('knitter/generate-custom-pattern/'.$com->token_key.'/'.Str::slug($com->name))}}"> <h6 class="card-title">{{ucfirst($com->name)}}</h6></a>
                                    @elseif($com->pattern_type == 'non-custom')
                                    <a href="{{url('knitter/generate-noncustom-pattern/'.$com->token_key.'/'.Str::slug($com->name))}}"> <h6 class="card-title">{{ucfirst($com->name)}}</h6></a>
                                    @else
                                    <a href="{{url('knitter/generate-pattern/'.$com->token_key.'/'.Str::slug($com->name))}}"><h6 class="card-title"> {{ucfirst($com->name)}}</h6></a>
                                    @endif
									@if($com->pattern_type == 'custom')
								<img class="img-fluid strip-image" src="{{ asset('resources/assets//files/assets/images/headerLogo-old.png') }}" alt="Theme-Logo" />
								@endif
                                    <div class="f-10"><strong>profile :</strong> {{ $title2 }}</div>
									<div class="f-10 m-b-30">
                                  <u class="view-more" data-title="{{ucfirst($com->name)}}" data-id="{{$com->pid}}" data-toggle="modal" data-target="#CarddetailsModal" >View more
                                  </u>
                                </div>
                                </div>
                             </div>
                          </div>
                          <div class="card-footer-custom">
                             <div class="dropdown-secondary dropdown text-right">
                                <span class="m-r-60"><i class="fa fa-calendar-check-o text-muted m-r-10 f-12"></i><span class="text-muted f-12" id="date{{$com->pid}}">{{date('d M, Y',strtotime($com->updated_at))}}</span></span>
                                <button class="btn-vert-toggle text-muted" type="button" id="dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu notifications" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" id="dropdown{{$com->pid}}">
                                 <!--  <a class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#myModal"> Post on the wall</a> -->
                                   <a class="dropdown-item waves-light waves-effect note addToProjects" href="javascript:;"  data-id="{{$com->pid}}" >Add back to project library</a>
                                   <!--<a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$com->pid}}" data-dropid="sortable2" data-current="completed" data-target="generatedpatterns" >Add To Generated patterns</a> -->

                                   <a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$com->pid}}" data-dropid="sortable3" data-current="completed" data-target="workinprogress">Add To Work in progress</a>
                                   <a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="{{$com->pid}}" data-target="#delete-Modal"> Delete</a>
                                </div>
                                <!-- end of dropdown menu -->
                             </div>
                          </div>
                       </div>
                    </div>
                 </li>
                 @endforeach
              </ul>
              @else
              <ul  id="sortable4" class='droptrue'>

              </ul>
              @endif
           </div>
        </div>
        <!-- Draggable Without Images card end -->
     </div>
     <!--Completed Ends here-->
  </div>
</div>
<!-- Page-body end -->
        </div>
     </div>
  </div>
</div>
<!-- Main-body end -->
</div>


    <!--Modal for Delete Confirmation-->
    <div class="modal fade" id="delete-Modal" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
                  <h5 class="modal-title">Confirmation</h5>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <input type="hidden" id="project_id" value="0">
                <p></p>
                   <p class="text-center"> <img class="img-fluid" src="{{ asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo" /></p>
                   <h6 class="text-center">Do you really want to delete this pattern ?</h6>
                   <h6 class="text-center">Action cannot be undone !</h6>
                   <p></p>
            </div>
            <div class="modal-footer">
                    <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                    <button  id="clear-all-tasks" type="button" class="btn btn-danger delete-card" data-dismiss="modal">Delete</button>
            </div>
          </div>
        </div>
      </div>

<!-- Modal for Card details -->
        <!-- Modal -->
        <div class="modal fade" id="CarddetailsModal" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h6 class="modal-title" id="project-title">Marsha's Lacy Tee</h6>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" id="project-info">
                
                        <!-- <div class="card-img-bg" style="background-image: url(../../files/assets/images/user-card/Marshas-Lacy-Tee.jpg);background-size: cover;background-position: center center;display: block;height: 124px;"></div></div> -->
                        <!-- <img class="img-fluid" src="../../files/assets/images/user-card/Marshas-Lacy-Tee.jpg"></div> -->
            </div>
              <!-- <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div> -->
            </div>
          </div>
        </div>
      <!--End of Modal for Card details-->
	  
@endsection
@section('footerscript')
<style type="text/css">
  .hide{
    display: none;
  }
.disabled{
    opacity: 0.5 !important;
    pointer-events: none !important;
}
.alert-danger{
  border: 1px solid #bc7c8f !important;
    border-radius: 5px !important;
    font-size: 15px !important;
}
 .view-more{margin-top: 2px;cursor: pointer;}
 .view-more:hover{margin-top: 2px;cursor: pointer;color: #0d665b;font-weight: 600;}
 #sortable1 .card-sub-custom:before{
	content: '' !important;
}
#sortable2 .card-sub-custom:before{
	content: '' !important;
}
#sortable3 .card-sub-custom:before{
	content: '' !important;
}
#sortable4 .card-sub-custom:before{
	content: '' !important;
}
.strip-image{
	top: 3px;
    position: absolute;
    width: 24px;
    margin-left: 0px;
    right: 8px;
}
</style>
<script type="text/javascript">
  var URL = '{{url("/")}}';
  var DATE = "{{date('d M, Y')}}";
</script>
<!-- Notification.css -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/pages/notification/notification.css') }}">
   <!-- Animate.css -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/bower_components/animate.css/css/animate.css') }}">
<!-- Custom js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/pages/sortable-custom.js') }}"></script>
<!-- notification js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/bootstrap-growl.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/pages/notification/notification.js') }}"></script>

<script type="text/javascript">
	$(function(){
    $(document).on('click','.addToProjects',function(){
      var id = $(this).attr('data-id');

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        url : '{{url("knitter/project-to-library")}}',
        type : 'POST',
        data: 'id='+id,
        beforeSend : function(){
          $(".loading").show();
        },
        success : function(res){
          if(res.status == 'success'){
            $("#generatedpatterns"+id+",#workinprogress"+id+",#completed"+id).remove();
            notify('fa fa-check','success',' ','Project has been added to project library.');
          }else{
            notify('fa fa-times','error',' ','Unable to add project to project library., Try again after sometime.');
          }
        },
        complete : function(){
          $(".loading").hide();
        }
      });
    });

    $(document).on('click','.deleteAction',function(){
      var id = $(this).attr('data-id');
      $("#project_id").val(id);
    });

    $(document).on('click','.delete-card',function(){
      var id = $("#project_id").val();

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        url : '{{url("knitter/delete-project")}}',
        type : 'POST',
        data: 'id='+id,
        beforeSend : function(){
          $(".loading").show();
        },
        success : function(res){
          if(res.status == 'success'){
            $("#generatedpatterns"+id+",#workinprogress"+id+",#completed"+id).remove();
            notify('fa fa-check','success',' ','Project has been removed from Archive and Added back to Project Library');
            $("#generatedpatterns"+id).remove();
          }else{
            notify('fa fa-times','danger',' ','Unable to add project to project library, Try again after sometime.');
          }
        },
        complete : function(){
          $(".loading").hide();
        }
      });

    });



$(document).on('click','.moveProject',function(){
    var id = $(this).attr('data-id');
    var dropid = $(this).attr('data-dropid');
    var currentPlace = $(this).attr('data-current');
    var target = $(this).attr('data-target');

    if(dropid == 'sortable2'){
      var dropTo = 1;
    }else if(dropid == 'sortable3'){
      var dropTo = 2;
    }else{
      var dropTo = 3;
    }


    if(target == 'workinprogress'){
      var dropdown = '<a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" >Add To Archive</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" data-dropid="sortable2" data-current="workinprogress" data-target="generatedpatterns" >Add To Generated patterns</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" data-dropid="sortable4" data-current="workinprogress" data-target="completed">Add To Completed</a><a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="'+id+'" data-target="#delete-Modal"> Delete</a>';
    }else if(target == 'completed'){
      var dropdown = '<a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" >Add To Archive</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" data-dropid="sortable2" data-current="completed" data-target="generatedpatterns">Add To Generated patterns</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" data-dropid="sortable3" data-current="completed" data-target="workinprogress">Add To Work in progress</a><a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="'+id+'" data-target="#delete-Modal"> Delete</a>';
    }else{
    var dropdown = '<a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" >Add To Archive</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" data-dropid="sortable3" data-current="generatedpatterns" data-target="workinprogress" >Add To Work in progress</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" data-dropid="sortable4" data-current="generatedpatterns" data-target="completed" >Add To Completed</a><a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="'+id+'" data-target="#delete-Modal"> Delete</a>';
    }


    

    var Data = 'id='+id+'&status='+dropTo;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

     $.ajax({
        url : '{{url("knitter/project/change-status")}}',
        type: 'POST',
        data : Data,
        beforeSend : function(){
			$(".loading").show();
        },
        success : function(res){
            $div = $("#"+currentPlace+""+id).clone();
            $div.attr('id',target+''+id);
            $div.find("#dropdown"+id).html(dropdown);
            $div.find("#dropdown"+id).removeClass('show');
            $("#"+dropid).prepend($div);
            $div.find("#date"+id).html(DATE);
            $("#"+currentPlace+""+id).remove();
        },
        complete : function(){
			$(".loading").hide();
        }
    }); 
});


$(document).on('click','.addProject',function(){
    var id = $(this).attr('data-id');

    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        url : '{{url("knitter/order-to-library")}}',
        type : 'POST',
        data: 'id='+id,
        beforeSend : function(){
          $(".loading").show();
        },
        success : function(res){
          if(res.status == 'success'){
            $("#new_patterns"+id).remove();
            notify('fa fa-check','success',' ','Available pattern has been added to archive');
          }else{
            notify('fa fa-times','danger',' ','Unable to available pattern to archive, Try again after sometime.');
          }
        },
        complete : function(){
          $(".loading").hide();
        }
      });

});


$(document).on('click','.view-more',function(){
    var id = $(this).attr('data-id');
    var title = $(this).attr('data-title');

    $("#project-title").html(title);
    
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

    $.ajax({
        url : '{{url("knitter/getProjectInfo")}}',
        type : 'POST',
        data : 'id='+id,
        beforeSend : function(){
            $(".loading").show();
        },
        success : function(res){
            $("#project-info").html(res);
        },
        complete : function(){
            $(".loading").hide();
        }
    });
});


	});


  function notify(icon, type,title, msg){
        $.growl({
            icon: icon,
            title: title,
            message: msg,
            url: ''
        },{
            element: 'body',
            type: type,
            allow_dismiss: true,
            placement: {
                from: 'top',
                align: 'right'
            },
            offset: {
                x: 30,
                y: 30
            },
            spacing: 10,
            z_index: 999999,
            delay: 2500,
            timer: 1000,
            url_target: '_blank',
            mouse_over: false,
            animate: {
                enter: 'animated fadeInRight',
                exit: 'animated fadeOutRight'
            },
            icon_type: 'class',
            template: '<div data-growl="container" class="alert" role="alert">' +
            '<button type="button" class="close" data-growl="dismiss">' +
            '<span aria-hidden="true">&times;</span>' +
            '<span class="sr-only">Close</span>' +
            '</button>' +
            '<span data-growl="icon"></span>' +
            '<span data-growl="title"></span>' +
            '<span data-growl="message"></span>' +
            '<a href="#" data-growl="url"></a>' +
            '</div>'
        });
    };
</script>
@endsection
