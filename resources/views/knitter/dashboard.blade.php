@extends('layouts.knitterapp')
@section('title','Knitter Dashboard')
@section('content')



<div class="pcoded-wrapper" id="dashboard">

<div class="pcoded-content">

<div class="pcoded-inner-content">
<div class="main-body">
	<div class="page-wrapper">

@if(env('SHOW_MAINTANANCE') == true)

<div class="card mb-3">
  <div class="row no-gutters">
    <div class="col-md-1">
      <img src="{{asset('resources/assets/maintanance-icon.png')}}" class="card-img" alt="...">
    </div>
    <div class="col-md-11">
      <div class="row">
      <div class="card-body">
        <h5 class="card-title" style="margin-bottom: 10px;">MAINTENANCE NOTIFICATION <!--<span class="pull-right maintenance"><a href="javascript:;" onclick="closeMaintanance()" class="fa fa-times"></a></span> --></h5>
        <p class="card-text">Please note that we will be performing important server maintenance on 23rd July from 11PM to 24th July 11AM EDT, during which time the server will be unavailable. If you are in the middle of something important, please save your work or hold off on any critical actions until we are finished.</p>
      </div>
      </div>
    </div>
  </div>
</div>

@endif

@if(Auth::user()->isSubscriptionExpired())
@if(Auth::user()->remainingDays() <= 5)
  <div class="col-lg-12 alert alert-danger">
You have only {{Auth::user()->remainingDays()}} days of subscription. Your subscription ends on {{date('d/F/Y',strtotime(Auth::user()->sub_exp))}}.
</div>
@endif

@else
<div class="col-lg-12 alert alert-danger">
Your subscription is ended.
</div>
@endif



		<!-- Page-body start -->
		<div class="page-body">
		@if(Auth::user()->hasRole('Knitter') && Auth::user()->hasRole('Designer'))
			<div class="row">
				<div class="col-lg-6 m-b-5">
					<ul class="nav nav-tabs md-tabs" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#knitter" role="tab"><span id="tab-heading">Knitter's Dashboard</span></a>
							<div class="slide"></div>
						</li>
						
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#designer" role="tab">Designer's Dashboard</a>
							<div class="slide"></div>
						</li>
						
					</ul>
				</div>
			</div>
			@endif
			
			<div class="col-lg-12 col-xl-12">
				<div class="tab-content m-30">
				@if(Auth::user()->hasRole('Knitter'))
					<div class="tab-pane active" id="knitter" role="tabpanel">
						<div class="row">
							<div class="col-xl-12">
								<h4>Hi, {{Auth::user()->first_name}} {{Auth::user()->last_name}} </h4>
							</div>
						</div>
				

						<div class="row">
							<div class="col-xl-12 col-sm-12 m-l-40 m-r-20 m-t-20">
								@component('layouts.menu.knitter-dashboard-menu') @endcomponent
							</div>

						</div>

						<div class="row">
							<div class="col-xl-12">
								<h4 class="m-b-30 m-t-30">Recent</h4>
							</div>
						</div>

						<div id="load-measurements">
							<!--<h4 class="text-center">Unable to get the measurements <a href='javascript:;' onclick="load_measurements()">Click Here</a> to load measurements</h4> -->
							<h4 class="text-center" id="loadingArea">Loading...</h4>
						</div>

						 <input type="hidden" id="del_id" value="0">
						 <input type="hidden" id="del_type" value="0">
					</div>
					@endif
					@if(Auth::user()->hasRole('Designer'))
					<div class="tab-pane @if(!Auth::user()->hasRole('Knitter') && Auth::user()->hasRole('Designer')) active @endif" id="designer" role="tabpanel">
						<div class="row">
							<div class="col-xl-12">
								<h4>Hi, {{Auth::user()->first_name}} {{Auth::user()->last_name}} </h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-12 col-sm-12 m-l-40 m-r-20 m-t-20">
								@component('layouts.menu.designer-dashboard-menu') @endcomponent
							</div>

						</div>

						<div class="row">
							<div class="col-xl-12">
								<h4 class="m-b-30 m-t-30">Recent</h4>
							</div>
						</div>
						
						<div class="row users-card">

                                @if($patterns->count() > 0)
                                    @foreach($patterns as $pat)
                                        @php
                                            $mainPhoto = $pat->images()->get();
                                            if($mainPhoto->count() > 0){
                                                $photo = $pat->images()->first()->image_small;
                                            }else{
                                                $photo = 'https://via.placeholder.com/150';
                                            }
                                        @endphp
                                        <div class="col-lg-2 col-xl-2 col-md-2">
                                            <div class="rounded-card user-card custom-card">

                                                <div class="img-hover">
                                                    <!-- <img class="img-fluid img-radius fixed-width-img" src="../../files/assets/images/user-card/The Boyfriend Sweater.jpg" alt="round-img"> -->
                                                </div>
                                                <div class="user-content card">
                                                    <div style="background-image: url({{ $photo }});
                                                        background-size: cover;height: 240px;"></div>
                                                    <h4 class="m-t-15 fixed-height m-l-5 m-r-5">{{ ucfirst
                                                    ($pat->product_name) }}</h4>
                                                    <p class="m-b-0 text-muted m-l-5 m-r-5 m-b-10">Status : {{ ($pat->status == 1) ? 'Active' : 'InActive' }}</p>
                                                    <div class="editable-items">
                                                        <a href="{{ url('designer/main/view/pattern/'.$pat->pid.'/'
                                                        .$pat->slug)}}" class="fa fa-eye" style="color: #0d665b;
                                                        font-size: 13px;padding: 10px;background: #fff;" class=""
                                                           data-toggle="tooltip" data-placement="top" title="View
                                                           pattern"></a> &nbsp;&nbsp;
                                                        <!--<a href="javascript:;" data-id="{{ encrypt($pat->id) }}"
                                                            class="fa fa-trash deletePattern" data-toggle="tooltip"
                                                            data-placement="top" title="Delete pattern"></a>-->
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-lg-12 col-xl-12 col-md-9">
                                        <div class="card custom-card skew-card">
                                            <div class="user-content m-l-40 m-r-40 m-b-40">
                                                <h4 class="text-muted m-t-30 m-b-30">You dont' have any patterns for
                                                    review
                                                </h4>
                                            </div>

                                        </div>
                                    </div>
                                @endif

                            </div>
						
					</div> 
					@endif
				</div>
			</div>
																	
																	
			
	</div>
	<!-- Page-body end -->
</div>
</div>
</div>
</div>
<!-- Main-body end -->


                <!--Modal will load after pressing delete -->

        <div class="modal fade" id="child-Modal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                          <h5 class="modal-title">Confirmation</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p></p>
                           <p class="text-center"> <img class="img-fluid" src="{{asset('resources/assets/files/assets/images/delete.png') }}" alt="Theme-Logo" /></p>
                           <h6 class="text-center">Do You really want to Delete selected <span id="pro"></span> ?</h6>
                           <p></p>
                    </div>
                    <div class="modal-footer">
                            <button class="btn waves-effect waves-light btn-primary theme-outline-btn" data-dismiss="modal">Cancel</button>
                            <button type="button" data-id="0" class="btn btn-danger delete-card" data-dismiss="modal">Delete</button>
                    </div>
                  </div>
                </div>
              </div>

        <!--Child Modal Ends here-->
</div>

@endsection

@section('footerscript')

<!-- Custom js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/assets/jquery.loadingdotdotdot.js')}}"></script>
<style type="text/css">
    .active-menu:hover{
        border-top: 1px solid #0d665c;
        border-bottom: 2px solid #0d665c;
        box-shadow: 1px 1px 1px 1px #0d665c2e;
    }
.pdf-thumb {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    width: 100%;
    height: 240px!important;
    background-color: rgb(189, 127, 145);
    color: white;
    font-weight: 600;
}
.pdf-thumb p{
	color: #fff !important;
	margin-top:100px !important;
}
.disabled{
    opacity: 0.5 !important;
    pointer-events: none !important;
}
figcaption {
    font-size: 14px;
}
.dashboard-icons
  {
   # height:40px ;
    #margin:20px 0px 12px 42px;
	height: 50px;
    display: flex;
    margin: 0 auto;
  }
  
  .fixed-logo{width: 80px;margin-right: 10px;}
    .nav-tabs .slide{height: 2px;}
    .card .card-block{padding-top: 0px;}
    .nav-tabs{border-bottom: 1px solid transparent;}
    #tab-heading{vertical-align: middle;}
    .nav-link{font-size: 15px!important;}
    .md-tabs .nav-item a{padding: 5px 0px 10px 0px;}
    .sub-title{border-bottom: none;}
    .card-background{background-color: #ececec!important;}
    figure {
    width: 136px;
    display: inline-block;
    box-shadow: 4px 4px 16px 2px #f2f2f2;
    background-color: white;
    padding: 27px 0px 27px 0px;
    margin: 0px 8px 0 8px;
    border: .2px solid transparent;
    margin-bottom: 10px;}
    .nav-item .active{font-weight: 600;color: #0d665c!important;}
	.nav-tabs .slide{
		background: #0d665c !important
	}
</style>
<script type="text/javascript">
	$(function(){

load_measurements();

$("#loadingArea").Loadingdotdotdot({
    "speed": 400,
    "maxDots": 4,
    "word": "Loading"
});



		$(document).on('click','.getId',function(){
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');
			if(type == 'projects'){
                $("#pro").html('Project');
            }else{
                $("#pro").html('Profile');
            }
			$(".delete-card").attr('data-id',id);
            $("#del_id").val(atob(id));
            $("#del_type").val(type);
		});

		$(document).on('click','.delete-card',function(){
            var type = $("#del_type").val();
            var id = $("#del_id").val();
            if(type == 'projects'){
                var title = 'Projects';
                var LINK = "delete-project/"+id;
            }else{
                var title = 'Measurement set';
                var LINK = "measurements/delete/"+id;
            }

			if(id != 0){
				$.get(LINK, function( data ) {
					if(data == 0 || data.status == 'success'){
						$(".id_"+id).remove();
						load_measurements();
						Swal.fire(
		                  'Great!',
		                  title+' removed successfully.',
		                  'success'
		                )
					}else{
						Swal.fire(
		                  'Oops!',
		                  'Unable to remove '+title,
		                  'fail'
		                )
					}

				});
			}else{
				Swal.fire(
                  'Oops!',
                  'Unable to delete.Please refresh the page and try again',
                  'fail'
                )
			}

        });


	});


	function notify(icon,status,msg){
		$.notify({
            icon: 'fa '+icon,
            title: status+'!',
            message: msg
        },{
            element: 'body',
            position: null,
            type: "info",
            allow_dismiss: true,
            newest_on_top: false,
            showProgressbar: true,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 10000,
            delay: 3000,
            animate: {
                enter: 'animated fadeInDown',
                exit: 'animated fadeOutUp'
            },
            icon_type: 'class',
            template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
            '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
            '<span data-notify="icon"></span> ' +
            '<span data-notify="title">{1}</span> ' +
            '<span data-notify="message">{2}</span>' +
            '<div class="progress" data-notify="progressbar">' +
            '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
            '</div>' +
            '<a href="{3}" target="{4}" data-notify="url"></a>' +
            '</div>'
        });
	}

	function load_measurements(){
		try {

			$.ajax({
			    url: "{{url('knitter/load-measurements')}}",
			    type: 'GET',
			    success: function(data){
			        $("#load-measurements").html(data);
			    },
			    error: function(data) {
			        //alert('woops!'); //or whatever
			        notify('fa-times','Error','Your data could not be loaded.Please try again after some time.')
			    }
			});

		}catch(err) {
			//alert(err);
		  $("#load-measurements").html("Unable to get the measurements <a href='javascript:;' >Click Here</a> to load the data");
		}
	}
</script>
@endsection
