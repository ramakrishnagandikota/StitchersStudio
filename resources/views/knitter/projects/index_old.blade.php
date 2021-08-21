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
     <div class="col-xl-4">
        <h5 class="theme-heading"><a href="#"><i class="fa fa-home theme-heading m-r-10"></i></a> Project Library </h5>
     </div>
     <div class="col-xl-8 text-right tabber">
        <a href="{{url('knitter/create-project')}}" class="btn btn-theme tablike-bt-fill waves-effect">Create Project</a>
        <a href="{{url('knitter/project-library/archive')}}" class="btn btn-default tablike-bt-outlined waves-effect">My Archive</a>
        <!--a href="#!" class="btn btn-default tablike-bt-outlined waves-effect">Notes</!--a>
           <a href="#!" class="btn btn-default tablike-bt-fill waves-effect">Progress</a> -->
     </div>
  </div>
  <div class="row m-t-30">
     <!--Not Started Starts here-->
     <div class="col-lg-3 col-xl-3">
        <!-- Draggable Without Images card start -->
        <h5 class="card-header-text m-b-20 text-muted">New patterns</h5>
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
<li id="new_patterns{{$ord->pid}}" data-id="0">
  <div class="col-md-12 m-b-20">
      <div class="card-sub-custom">
          <div class="card-block">
              <div class="row">
                  <div class="col-lg-4" >
<div class="card-img-bg" style="background-image: url({{ $image  }});background-size: cover;background-position: center center;display: block;height: 99px;"></div>
                  </div>
             <div class="col-lg-8">
                 <h6 class="card-title">{{ucfirst($ord->product_name)}}</h6>

      </div>
          </div>
              </div>
              <div class="card-footer-custom">
                  <div class="dropdown-secondary dropdown text-right">
                      <span class="m-r-60"><i class="fa fa-calendar-check-o text-muted m-r-10 f-12"></i><span class="text-muted f-12">{{date('d M, Y',strtotime($ord->created_at))}}</span></span>

                   <!--  <button class="btn-vert-toggle text-muted" type="button" id="dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                   <div class="dropdown-menu notifications" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                     <a class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#myModal"> Post on the wall</a>
                       <a class="dropdown-item waves-light waves-effect note" href="#!" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" >Add To archive</a>

                   </div> -->
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
     <div class="col-lg-3 col-xl-3">
        <!-- Draggable Without Images card start -->
        <h5 class="card-header-text m-b-20 text-muted">Generated Patterns</h5>
        <div class="card-block">
           <div class="row">
              <ul  id="sortable2" class='droptrue'>
                 @if($generatedpatterns->count() > 0)

                @foreach($generatedpatterns as $gp)
                <?php
$measurement = DB::table('user_measurements')->where('id',$gp->measurement_profile)->select('m_title')->first();
if($measurement){
    $title = $measurement->m_title;
}else{
    $title = 'No Name';
}
                $image = DB::table('projects_images')->where('project_id',$gp->pid)->first();
        if($image){
			//if($image->image_ext == 'pdf' || $image->image_ext == 'PDF')
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
                                 <div class="col-lg-4">
								@if($image->image_ext == 'pdf' || $image->image_ext == 'PDF')
									 <div class=" pdf-thumb ">
									<p> PDF </p>
								</div>
								@else
                                <div class=" card-img-bg" style="background-image: url({{ $i1  }});background-size: cover;background-position: center center;display: block;height: 99px;"></div>
								@endif
                                 </div>
                                <div class="col-lg-8">

                                @if($gp->pattern_type == 'custom')
                                <a href="{{url('knitter/generate-custom-pattern/'.$gp->token_key.'/'.Str::slug($gp->name))}}">
                                <h6 class="card-title">{{ucfirst($gp->name)}}</h6> </a>
                                @elseif($gp->pattern_type == 'non-custom')
                                <a href="{{url('knitter/generate-noncustom-pattern/'.$gp->token_key.'/'.Str::slug($gp->name))}}">
                                    <h6 class="card-title">{{ucfirst($gp->name)}}</h6> </a>
                                @else
                                    <a href="{{url('knitter/generate-pattern/'.$gp->token_key.'/'.Str::slug($gp->name))}}"><h6 class="card-title">{{ucfirst($gp->name)}}</h6></a>
                                @endif

                                <span class="f-10">Profile : {{ $title }}</span>
                                </div>
                             </div>
                          </div>
                          <div class="card-footer-custom">
                             <div class="dropdown-secondary dropdown text-right">
                                <span class="m-r-60"><i class="fa fa-calendar-check-o text-muted m-r-10 f-12"></i><span class="text-muted f-12" id="date{{$gp->pid}}">{{date('d M, Y',strtotime($gp->updated_at))}}</span></span>
                                <button class="btn-vert-toggle text-muted" type="button" id="dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu notifications" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                  <!-- <a class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#myModal"> Post on the wall</a> -->
                                   <a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$gp->pid}}" >Add To archive</a>
                                   <a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="{{$gp->pid}}" data-target="#delete-Modal"> Delete</a>
                                </div>
                                <!-- end of dropdown menu -->
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
        <!-- Draggable Without Images card end -->
     </div>
     <!--In Progress Ends here-->
     <!--Completed Starts here-->
     <div class="col-lg-3 col-xl-3">
        <!-- Draggable Without Images card start -->
        <h5 class="card-header-text m-b-20 text-muted">Work in Progress</h5>
        <div class="card-block">
           <div class="row">

              <ul  id="sortable3" class='droptrue'>
                @if($workinprogress->count() > 0)
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
          $i2 = '';
        }
                ?>
                 <li class="" id="workinprogress{{$wp->pid}}" data-id="{{$wp->pid}}">
                    <div class="col-md-12 m-b-20">
                       <div class="card-sub-custom">
                          <div class="card-block">
                             <div class="row">
                                 <div class="col-lg-4 ">
								 @if($image2->image_ext == 'pdf' || $image2->image_ext == 'PDF')
									 <div class=" pdf-thumb ">
									<p> PDF </p>
								</div>
								@else
								 <div class="card-img-bg" style="background-image: url({{ $i2  }});background-size: cover;background-position: center center;display: block;height: 99px;">
                                </div>
								 @endif
                                 </div>
                                <div class="col-lg-8">

                                    @if($wp->pattern_type == 'custom')
                                    <a href="{{url('knitter/generate-custom-pattern/'.$wp->token_key.'/'.Str::slug($wp->name))}}"><h6 class="card-title"> {{ucfirst($wp->name)}}</h6></a>
                                    @elseif($wp->pattern_type == 'non-custom')
                                    <a href="{{url('knitter/generate-noncustom-pattern/'.$wp->token_key.'/'.Str::slug($wp->name))}}"><h6 class="card-title"> {{ucfirst($wp->name)}}</h6></a>
                                    @else
                                    <a href="{{url('knitter/generate-pattern/'.$wp->token_key.'/'.Str::slug($wp->name))}}"><h6 class="card-title"> {{ucfirst($wp->name)}}</h6></a>
                                    @endif
                                    <span class="f-10">Profile : {{$title1}}</span>

                                </div>
                             </div>
                          </div>
                          <div class="card-footer-custom">
                             <div class="dropdown-secondary dropdown text-right">
                                <span class="m-r-60"><i class="fa fa-calendar-check-o text-muted m-r-10 f-12"></i><span class="text-muted f-12" id="date{{$wp->pid}}" >{{date('d M, Y',strtotime($wp->updated_at))}}</span></span>
                                <button class="btn-vert-toggle text-muted" type="button" id="dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu notifications" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                  <!-- <a class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#myModal"> Post on the wall</a> -->
                                   <a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$wp->pid}}" >Add To archive</a>
                                   <a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="{{$wp->pid}}" data-target="#delete-Modal"> Delete</a>
                                </div>
                                <!-- end of dropdown menu -->
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
        <!-- Draggable Without Images card end -->
     </div>
     <!--Completed Ends here-->
     <!--Completed Starts here-->
     <div class="col-lg-3 col-xl-3">
        <!-- Draggable Without Images card start -->
        <h5 class="card-header-text m-b-20 text-muted">Completed</h5>
        <div class="card-block">
           <div class="row">

              <ul  id="sortable4" class='droptrue'>
                @if($completed->count() > 0)
                @foreach($completed as $com)
                <?php
    $measurement2 = DB::table('user_measurements')->where('id',$com->measurement_profile)->select('m_title')->first();
    if($measurement2){
    $title2 = $measurement2->m_title;
}else{
    $title2 = 'No Name';
}
                $image3 = DB::table('projects_images')->where('project_id',$com->pid)->first();
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
                                 <div class="col-lg-4">
								 @if($image3->image_ext == 'pdf' || $image3->image_ext == 'PDF')
									 <div class=" pdf-thumb ">
									<p> PDF </p>
								</div>
								@else
                                <div class="card-img-bg" style="background-image: url({{ $i3  }});background-size: cover;background-position: center center;display: block;height: 99px;">
                                    </div>
								@endif
                                 </div>
                                <div class="col-lg-8">

                                  @if($com->pattern_type == 'custom')
                                    <a href="{{url('knitter/generate-custom-pattern/'.$com->token_key.'/'.Str::slug($com->name))}}"><h6 class="card-title"> {{ucfirst($com->name)}}</h6></a>
                                    @elseif($com->pattern_type == 'non-custom')
                                    <a href="{{url('knitter/generate-noncustom-pattern/'.$com->token_key.'/'.Str::slug($com->name))}}"><h6 class="card-title"> {{ucfirst($com->name)}}</h6></a>
                                    @else
                                    <a href="{{url('knitter/generate-pattern/'.$com->token_key.'/'.Str::slug($com->name))}}"><h6 class="card-title"> {{ucfirst($com->name)}}</h6></a>
                                    @endif

                                   <span class="f-10">Profile : {{ $title2 }}</span>
                                </div>
                             </div>
                          </div>
                          <div class="card-footer-custom">
                             <div class="dropdown-secondary dropdown text-right">
                                <span class="m-r-60"><i class="fa fa-calendar-check-o text-muted m-r-10 f-12"></i><span class="text-muted f-12" id="date{{$com->pid}}">{{date('d M, Y',strtotime($com->updated_at))}}</span></span>
                                <button class="btn-vert-toggle text-muted" type="button" id="dropdown6" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                                <div class="dropdown-menu notifications" aria-labelledby="dropdown6" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                  <!--  <a class="dropdown-item waves-light waves-effect" data-toggle="modal" data-target="#myModal"> Post on the wall</a> -->
                                   <a class="dropdown-item waves-light waves-effect note moveToArchive" href="javascript:;" data-type="success" data-from="top" data-animation-in="animated fadeInRight" data-animation-out="animated fadeOutRight" data-id="{{$com->pid}}" >Add To archive</a>
                                   <a class="dropdown-item waves-light waves-effect deleteAction" data-toggle="modal" data-id="{{$com->pid}}" data-target="#delete-Modal"> Delete</a>
                                </div>
                                <!-- end of dropdown menu -->
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

@endsection
@section('footerscript')
<style type="text/css">
  .hide{
    display: none;
  }
  .card-sub-custom h6{
      margin-bottom: 0px !important;
  }
.pdf-thumb {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    width: 80px;
    height: 100px!important;
    background-color: rgb(189, 127, 145);
    color: white;
    font-weight: 600;
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

          }else{
            notify('fa fa-times','danger',' ','Unable to delete project, Try again after sometime.');
          }
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
