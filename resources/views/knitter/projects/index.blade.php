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
  
  
  @if(Auth::user()->isSubscriptionExpired() == false) <!-- false means subscription expired -->
<div class="col-lg-12 alert alert-danger">
<a href="javascript:;" data-toggle="modal" data-target="#ProjectsModal" data-backdrop="static" data-keyboard="false">Why are only five of my projects available ?</a>
</div>
@endif


<div class="modal fade" id="ProjectsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subscription</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Unlimited projects are available as a subscriber. Your 1 month trial knitters subscription has expired. To continue to access multiple projects (recommended) please subscribe. We sincerely thank you for your support. <a href="{{url('knitter/subscription')}}">Click here to subscribe</a></p>
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>



@if(Auth::user()->hasSubscription('Basic'))
    @if(Auth::user()->isSubscriptionExpired())
    @if(Auth::user()->remainingDays() <= $projectLimit->subscription_limit)
      <div class="col-lg-12 alert alert-danger">
    You have only {{Auth::user()->remainingDays()}} days left in your subscription. Your subscription ends on {{date('d/F/Y',strtotime(Auth::user()->sub_exp))}}. <a href="{{url('knitter/subscription')}}">Click here</a> to upgrade.
    </div>
    @endif

    @else
    <div class="col-lg-12 alert alert-danger">
    Your subscription is ended.
    </div>
    @endif
@endif

     <div class="col-xl-4">
        <h5 class="theme-heading"><a href="#"><i class="fa fa-home theme-heading m-r-10"></i></a> Project Library
            <span class="mytooltip tooltip-effect-2" style="z-index:1000">
                <span class="tooltip-item">?</span>
                <span class="tooltip-content clearfix Customtooltip" id="Customtooltip">
                    <span class="tooltip-text" style="width: 100%;"><a href="{{env('WORDPRESS_APP_URL')}}/adding-patterns-to-project-library/" target="_blank"><b class="f-w-800">Learn how</b></a> to add patterns to your project library</span>
                </span>
            </span>
            </h5>
     </div>
     <div class="col-xl-8 text-right tabber">
    @if(Auth::user()->isBasic())
      @if(Auth::user()->isSubscriptionExpired())
        <a href="{{url('knitter/projects/external/create')}}" class="btn btn-theme tablike-bt-fill waves-effect">Upload Pattern</a>
      @else
        <a href="javascript:;"  class="btn btn-theme tablike-bt-fill waves-effect OnLoadModal">Upload Pattern</a>
      @endif
    @else
     @if($projectsCount > 4)
        <a href="javascript:;" class="btn btn-theme tablike-bt-fill waves-effect OnLoadModal">Upload Pattern</a>
     @else
        <a href="{{url('knitter/projects/external/create')}}" class="btn btn-theme tablike-bt-fill waves-effect">Upload Pattern</a>
     @endif
  @endif
  <a href="{{url('knitter/todo')}}" class="btn btn-default tablike-bt-outlined theme-btn-pink waves-effect">To-Do</a>
        <a href="{{url('knitter/project-library/archive')}}" class="btn btn-default tablike-bt-outlined waves-effect">My Archive</a>
        <!--a href="#!" class="btn btn-default tablike-bt-outlined waves-effect">Notes</!--a>
           <a href="#!" class="btn btn-default tablike-bt-fill waves-effect">Progress</a> -->
     </div>
  </div>


@php 
$projects = DB::table('projects')->where('user_id',Auth::user()->id)->where('is_archive',0)->where('is_deleted',0)->orderBy('updated_at','ASC')->select('id','name','updated_at')->take(5)->get();
@endphp

  <div class="row m-t-30 justify-content-center">
     <!--Not Started Starts here-->
     <div class="col-lg-4 col-xl-4">
        <!-- Draggable Without Images card start -->
        <h5 class="card-header-text m-b-20 text-muted">New patterns
            <span class="mytooltip tooltip-effect-2" >
                <span class="tooltip-item">?</span>
                <span class="tooltip-content clearfix Customtooltip" id="Customtooltip1">
                    <span class="tooltip-text" style="width: 100%;">Projects for patterns purchased in StitchersStudio Shop or uploaded using the Upload Pattern button will appear here. Click on the menu on your Project to edit project details or generate custom patterns
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
    $image = 'https://dummyimage.com/200x200&text=No%20image';
  }
 ?>
<li id="new_patterns{{$ord->id}}" data-id="0">
  <div class="col-md-12 m-b-20">
      <div class="card-sub-custom">
          <div class="card-block">
              <div class="row">
                  <div class="col-lg-4" >
<div class="card-img-bg" style="background-image: url({{ $image  }});background-size: cover;background-position: center center;display: block;height: 124px;">

</div>
                  </div>
             <div class="col-lg-8">
                 <h6 class="card-title">{{ucfirst($ord->product_name)}}</h6>
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

                    @if($ord->is_custom == 1)
                       <a class="dropdown-item waves-light waves-effect note" href="{{ url
                       ('knitter/projects/custom/'.base64_encode($ord->pid).'/create') }}"
                          data-type="success" data-from="top" data-animation-in="animated fadeInRight"
                          data-animation-out="animated fadeOutRight" data-id="">Create Project</a>
                       @else
                           <a class="dropdown-item waves-light waves-effect note" href="{{ url
                       ('knitter/projects/traditional/'.base64_encode($ord->pid).'/create') }}"
                              data-type="success" data-from="top" data-animation-in="animated fadeInRight"
                              data-animation-out="animated fadeOutRight" data-id="">Create Project</a>
                       @endif

                       <a class="dropdown-item waves-light waves-effect note addArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$ord->id}}">Add to Archive</a>

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
     <!--<div class="col-lg-3 col-xl-3">
        <!-- Draggable Without Images card start --
        <h5 class="card-header-text m-b-20 text-muted">Generated Patterns</h5>
        <div class="card-block">
           <div class="row">
              <ul  id="sortable2" class='droptrue'>
                 @if($generatedpatterns->count() > 0)

                @foreach($generatedpatterns as $gp)
                <?php
if(Auth::user()->hasSubscription('Free')){
  if($gp->pid == $projects->id){
    $disabled = 0;
  }else{
    $disabled = 1;
  }
}else{
  $disabled = 0;
}

$measurement = DB::table('user_measurements')->where('id',$gp->measurement_profile)->select('m_title')->first();
if($measurement){
    $title = $measurement->m_title;
}else{
    $title = 'No Name';
}
        $image = DB::table('projects_images')->where('project_id',$gp->pid)->where('image_ext','!=','pdf')->first();
        if($image){
          $i1 = $image->image_path;
        }else{
          $i1 = 'https://dummyimage.com/200x200&text=No%20image';
        }
                ?>

                 <li class="@if($disabled == 1) disabled @endif" @if($disabled == 0) id="generatedpatterns{{$gp->pid}}" data-id="{{$gp->pid}}"  @endif >
                    <div class="col-md-12 m-b-20">
                       <div class="card-sub-custom">
                          <div class="card-block">
                             <div class="row">
                                 <div class="col-lg-4">
                                <div class=" card-img-bg" style="background-image: url({{ $i1  }});background-size: cover;background-position: center center;display: block;height: 99px;"></div>
                                 </div>
                                <div class="col-lg-8">
                            @if($disabled == 0)
                                @if($gp->pattern_type == 'custom')
                                <a href="{{url('knitter/generate-custom-pattern/'.$gp->token_key.'/'.Str::slug($gp->name))}}">
                                <h6 class="card-title">{{ucfirst($gp->name)}}</h6> </a>
                                @elseif($gp->pattern_type == 'non-custom')
                                <a href="{{url('knitter/generate-noncustom-pattern/'.$gp->token_key.'/'.Str::slug($gp->name))}}">
                                    <h6 class="card-title">{{ucfirst($gp->name)}}</h6> </a>
                                @else
                                    <a href="{{url('knitter/generate-pattern/'.$gp->token_key.'/'.Str::slug($gp->name))}}"><h6 class="card-title">{{ucfirst($gp->name)}}</h6></a>
                                @endif
                            @else
                              <a href="javascript:;">
                                <h6 class="card-title">{{ucfirst($gp->name)}}</h6> </a>

                            @endif
                                <div class="f-10"><strong>profile :</strong> {{ $title }}</div>
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

                                @if($disabled == 0)
                                <div class="dropdown-menu notifications" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" id="dropdown{{$gp->pid}}">
                                  <!-- <a class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#myModal"> Post on the wall</a> --
                                   <a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$gp->pid}}" >Add to Archive</a>
                                   
                                   <a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$gp->pid}}" data-dropid="sortable3" data-current="generatedpatterns" data-target="workinprogress" >Add to Work in Progress</a>

                                   <a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$gp->pid}}" data-dropid="sortable4" data-current="generatedpatterns" data-target="completed" >Add to Complete</a>

                                   <a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="{{$gp->pid}}" data-target="#delete-Modal"> Delete</a>
                                </div>
                                @endif
                                <!-- end of dropdown menu --
                             </div>
                          </div>
                       </div>
                    </div>
                 </li>
                 @endforeach
                 @endif
              </ul>

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
                    <span class="tooltip-content clearfix Customtooltip" id="Customtooltip">
                        <span class="tooltip-text" style="width: 100%;">After you add pattern information and save your project, it will appear here.
                        </span>
                </span>
            </span>
            </h5>
        <div class="card-block">
           <div class="row">

              <ul  id="sortable3" class='droptrue'>
                @if($workinprogress->count() > 0)
                    <?php $wip = 1; ?>
                @foreach($workinprogress as $wp)
                <?php
                $measurement1 = DB::table('user_measurements')->where('id',$wp->measurement_profile)->select('m_title')->first();
                $image2 = DB::table('projects_images')->where('project_id',$wp->pid)->first();
                if($measurement1){
    $title1 = $measurement1->m_title;
}else{
    $title1 = 'No Name';
}
        if($image2){
            $i2 = $image2->image_path;
        }else{
          $i2 = 'https://dummyimage.com/200x200&text=No%20image';
        }
        
    $parray = array();
    if(Auth::user()->hasSubscription('Free')){
        if($projects->count() > 0){
            foreach($projects as $p){
                array_push($parray,$p->id);
            }
        }
    }else{
        $parray = array();
    }
    
    //print_r($parray);     
    //echo '<br>';
    //echo $wp->pid;
    if(Auth::user()->hasSubscription('Free')){
    if(in_array($wp->pid,$parray)){
        $disabled1 = 0;
    }else{
        $disabled1 = 1;
    }
}else{
  $disabled1 = 0;
}
?>

                    <li class="@if($disabled1 == 1) disabled @endif" @if($disabled1 == 0) id="workinprogress{{$wp->pid}}"  @endif data-id="{{$wp->pid}}" > 
                    <div class="col-md-12 m-b-20">
                       <div class="card-sub-custom">
                          <div class="card-block">
                             <div class="row">
                                 <div class="col-lg-4 ">
                                <div class="card-img-bg" style="background-image: url({{ $i2  }});background-size: cover;background-position: center center;display: block;height: 124px;"></div> 
                                </div>
                                <div class="col-lg-8">
                            @if($disabled1 == 0)
                                    @if($wp->pattern_type == 'custom')
                                    <a href="{{url('knitter/generate-custom-pattern/'.$wp->token_key.'/'.Str::slug($wp->name))}}"><h6 class="card-title"> {{ucfirst($wp->name)}}</h6></a>
                                    @elseif($wp->pattern_type == 'non-custom')
                                    <a href="{{url('knitter/generate-noncustom-pattern/'.$wp->token_key.'/'.Str::slug($wp->name))}}"><h6 class="card-title"> {{ucfirst($wp->name)}}</h6></a>
                                    @else
                                    <a href="{{url('knitter/generate-pattern/'.$wp->token_key.'/'.Str::slug($wp->name))}}"><h6 class="card-title"> {{ucfirst($wp->name)}}</h6></a>
                                    @endif
                            @else
                              <a href="javascript:;"><h6 class="card-title"> {{ucfirst($wp->name)}}</h6></a>
                            @endif
                            @if($wp->pattern_type == 'custom')
                                <img class="img-fluid strip-image" src="{{ asset('resources/assets//files/assets/images/headerLogo-old.png') }}" alt="Theme-Logo" />
                                @endif
                                    <div class="f-10"><strong>profile :</strong> {{$title1}}</div>
                                <div class="f-10 m-b-30">
                                  <u class="view-more" data-title="{{ucfirst($wp->name)}}" data-id="{{$wp->pid}}" data-toggle="modal" data-target="#CarddetailsModal" >View more
                                  </u>
                                </div>
                                </div>
                             </div>
                          </div>
                          <div class="card-footer-custom">
                             <div class="dropdown-secondary dropdown text-right">
                                <span class="m-r-60"><i class="fa fa-calendar-check-o text-muted m-r-10 f-12"></i><span class="text-muted f-12" id="date{{$wp->pid}}" >{{date('d M, Y',strtotime($wp->updated_at))}}</span></span>
                                <button class="btn-vert-toggle text-muted" type="button" id="dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>

                                @if($disabled1 == 0)
                                <div class="dropdown-menu notifications" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" id="dropdown{{$wp->pid}}">
                                  <!-- <a class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#myModal"> Post on the wall</a> -->
                                   <a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$wp->pid}}" >Add to Archive</a>

                                   <!--<a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$wp->pid}}" data-dropid="sortable2" data-current="workinprogress" data-target="generatedpatterns" >Add to Generated Patterns</a> -->

                                   <a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$wp->pid}}" data-dropid="sortable4" data-current="workinprogress" data-target="completed">Add to Complete</a>
                                   @if($wp->pattern_type == 'custom')
                                   <a class="dropdown-item waves-light waves-effect"  
                                   href="{{ url('knitter/projects/custom/'.base64_encode($wp->product_id).'/create') }}" target="_blank" > Create a copy</a>
                                   @elseif($wp->pattern_type == 'non-custom')
                                       <a class="dropdown-item waves-light waves-effect"  
                                   href="{{ url('knitter/projects/traditional/'.base64_encode($wp->product_id).'/create') }}"  > Create a copy</a>
                                   @endif
                                   <a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="{{$wp->pid}}" data-target="#delete-Modal"> Delete</a>
                                </div>
                                @endif
                                <!-- end of dropdown menu -->
                             </div>
                          </div>
                       </div>
                    </div>
                 </li>
                 <?php $wip++; ?>
                 @endforeach
              @endif
              </ul>
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
                    <span class="tooltip-content clearfix Customtooltip" id="Customtooltip">
                        <span class="tooltip-text" style="width: 100%;">Gaze upon all your gorgeous and neatly organized finished objects!</span>
                </span>
            </span>
            </h5>
        <div class="card-block">
           <div class="row">

              <ul  id="sortable4" class='droptrue'>
                @if($completed->count() > 0)
                    <?php $copm = 1; ?>
                @foreach($completed as $com)
                <?php
    $measurement2 = DB::table('user_measurements')->where('id',$com->measurement_profile)->select('m_title')->first();


    if($measurement2){
    $title2 = $measurement2->m_title;
}else{
    $title2 = 'No Name';
}



        
        $parray1 = array();
    if(Auth::user()->hasSubscription('Free')){
        if($projects->count() > 0){
            foreach($projects as $p){
                array_push($parray1,$p->id);
            }
        }
    }else{
        $parray1 = array();
    }
    if(Auth::user()->hasSubscription('Free')){
    if(in_array($com->pid,$parray1)){
        $disabled2 = 0;
    }else{
        $disabled2 = 1;
    }
}else{
  $disabled2 = 0;
}


                $image3 = DB::table('projects_images')->where('project_id',$com->pid)->first();
        if($image3){
          $i3 = $image3->image_path;
        }else{
          $i3 = 'https://dummyimage.com/200x200&text=No%20image';
        }
                ?>
                 <li class="@if($disabled2 == 1) disabled @endif" @if($disabled2 == 0) id="completed{{$com->pid}}" data-id="{{$com->pid}}" @endif >
                    <div class="col-md-12 m-b-20">
                       <div class="card-sub-custom">
                          <div class="card-block">
                             <div class="row">
                                 <div class="col-lg-4">
                                <div class="card-img-bg" style="background-image: url({{ $i3  }});background-size: cover;background-position: center center;display: block;height: 124px;">
                                
                                    </div>
                                 </div>
                                <div class="col-lg-8">
                            @if($disabled2 == 0)
                                  @if($com->pattern_type == 'custom')
                                    <a href="{{url('knitter/generate-custom-pattern/'.$com->token_key.'/'.Str::slug($com->name))}}"><h6 class="card-title"> {{ucfirst($com->name)}}</h6></a>
                                    @elseif($com->pattern_type == 'non-custom')
                                    <a href="{{url('knitter/generate-noncustom-pattern/'.$com->token_key.'/'.Str::slug($com->name))}}"><h6 class="card-title"> {{ucfirst($com->name)}}</h6></a>
                                    @else
                                    <a href="{{url('knitter/generate-pattern/'.$com->token_key.'/'.Str::slug($com->name))}}"><h6 class="card-title"> {{ucfirst($com->name)}}</h6></a>
                                    @endif
                            @else
                              <a href="javascript:;"><h6 class="card-title"> {{ucfirst($com->name)}}</h6></a>
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


                                <button class="btn-vert-toggle text-muted" type="button" id="dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i>
                                </button>
                                @if($disabled2 == 0)
                                <div class="dropdown-menu notifications" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut" id="dropdown{{$com->pid}}">
                                  <!--  <a class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#myModal"> Post on the wall</a> -->
                                   <a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$com->pid}}" >Add to Archive</a>
                                   <!--<a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$com->pid}}" data-dropid="sortable2" data-current="completed" data-target="generatedpatterns" >Add to Generated patterns</a> -->

                                   <a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$com->pid}}" data-dropid="sortable3" data-current="completed" data-target="workinprogress">Add to Work in Progress</a>
                                   @if($com->pattern_type == 'custom')
                                   <a class="dropdown-item waves-light waves-effect"  
                                   href="{{ url('knitter/projects/custom/'.base64_encode($com->product_id).'/create') }}" target="_blank"> Create a copy</a>
                                   @elseif($com->pattern_type == 'non-custom')
                                   <a class="dropdown-item waves-light waves-effect"  
                                   href="{{ url('knitter/projects/traditional/'.base64_encode($com->product_id).'/create') }}" > Create a copy</a>
                                   @else
                                       
                                   @endif
                                   <a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="{{$com->pid}}" data-target="#delete-Modal"> Delete</a>
                                </div>
                                @endif
                                <!-- end of dropdown menu -->
                             </div>
                          </div>
                       </div>
                    </div>
                 </li>
                 <?php $copm++; ?>
                 @endforeach
              @endif
              </ul>
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
      
       <div class="modal fade" id="OnLoadModal" role="dialog">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
          <div class="modal-header">
                <!--<h6 class="modal-title" id="project-title">Marsha's Lacy Tee</h6>-->
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
            <div class="modal-body text-center">
                <p>You currently have a free subscription. To add another project,<br> please <a href="{{ url('knitter/subscription')}}" style="color:#c14d7d">subscribe here</a></p>
            </div>
          
          </div>
        </div>
      </div>
      
@endsection
@section('footerscript')
<style type="text/css">
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
  .hide{
    display: none;
  }
  .card-sub-custom h6{
      margin-bottom: 0px !important;
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
.lh{
  line-height: 1 !important;
}

 
     .view-more{margin-top: 2px;cursor: pointer;}
    .view-more:hover{margin-top: 2px;cursor: pointer;color: #0d665b;font-weight: 600;}
    .mytooltip .tooltip-item {
    padding: 1px 5px 0px 5px!important;
    font-size: 12px!important;
}
.theme-btn-pink{padding: 4px 18px 4px 18px;background-color: #dd8ca0!important;}
.theme-btn-pink:hover{padding: 4px 18px 4px 18px!important;}
.date{position: absolute;bottom: 6px;}
.strip-image{
    top: 3px;
    position: absolute;
    width: 24px;
    margin-left: 0px;
    right: 8px;
}
  .theme-btn-pink {
      color: #ffffff!important;
      border: 1px solid #c38a9b !important;
  }
  .mytooltip{z-index: unset;}
    .mytooltip .tooltip-content{bottom: unset;top: 0% !important;}
    #Customtooltip,#Customtooltip1{
        margin: 20px 0 -146px -75px!important;
    }
    #Customtooltip1::after {
    top: -18% !important;
    left: 130px;
    position: absolute !important;
    -ms-transform: rotate(180deg) !important;
    -webkit-transform: rotate(180deg) !important;
    transform: rotate(180deg) !important;
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
    localStorage.removeItem('project');
    $(document).on('click','.moveToArchive',function(){
      var id = $(this).attr('data-id');

      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        url : '{{url("knitter/project-to-archive")}}',
        type : 'POST',
        data: 'id='+id,
        beforeSend : function(){
          $(".loading").show();
        },
        success : function(res){
          if(res.status == 'success'){
            $("#generatedpatterns"+id+",#workinprogress"+id+",#completed"+id).remove();
            notify('fa fa-check','success',' ','Project has been added to archive');
          }else{
            notify('fa fa-times','danger',' ','Unable to add project to archive, Try again after sometime.');
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
            notify('fa fa-check','success',' ','Project deleted successfully');
            setTimeout(function(){ location.reload(); },1000);
          }else{
            notify('fa fa-times','danger',' ','Unable to delete project, Try again after sometime.');
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
      var dropdown = '<a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" >Add To Archive</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" data-dropid="sortable4" data-current="workinprogress" data-target="completed">Add To Completed</a><a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="'+id+'" data-target="#delete-Modal"> Delete</a>';
    }else if(target == 'completed'){
      var dropdown = '<a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" >Add To Archive</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" data-dropid="sortable3" data-current="completed" data-target="workinprogress">Add To Work in progress</a><a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="'+id+'" data-target="#delete-Modal"> Delete</a>';
    }else{
    var dropdown = '<a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" >Add To Archive</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" data-dropid="sortable3" data-current="workinprogress" data-target="workinprogress" >Add To Work in progress</a><a class="dropdown-item waves-light waves-effect note moveProject" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="'+id+'" data-dropid="sortable4" data-current="generatedpatterns" data-target="completed" >Add To Completed</a><a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="'+id+'" data-target="#delete-Modal"> Delete</a>';
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



$(document).on('click','.addArchive',function(){
    var id = $(this).attr('data-id');

    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $.ajax({
        url : '{{url("knitter/order-to-archive")}}',
        type : 'POST',
        data: 'id='+id,
        beforeSend : function(){
          $(".loading").show();
        },
        success : function(res){
          if(res.status == 'success'){
            $("#new_patterns"+id).remove();
            notify('fa fa-check','success',' ','New pattern has been added to archive');
          }else{
            notify('fa fa-times','danger',' ','Unable to add pattern to archive, Try again after sometime.');
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


$(document).on('click','.OnLoadModal',function(){
    var options = {
        backdrop: 'static',
        keyboard : false
    }
    $("#OnLoadModal").modal(options);
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
            timer: 2000,
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
