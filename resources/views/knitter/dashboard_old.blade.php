@extends('layouts.knitterapp')
@section('title','Knitter Dashboard')
@section('content')



<div class="pcoded-wrapper" id="dashboard">

<div class="pcoded-content">

<div class="pcoded-inner-content">
<div class="main-body">
	<div class="page-wrapper">
		<!-- Page-body start -->
		<div class="page-body">
			<div class="row">
				<div class="col-xl-12">
					<h4>Hi, {{Auth::user()->first_name}} {{Auth::user()->last_name}} </h4>
				</div>
            </div>

            @php
            $menus = App\Models\Menu::where('status','!=',0)->get();

            $num=1;
            @endphp

			<div class="row">
				<div class="col-xl-12 col-sm-12 m-l-40 m-r-20 m-t-20">
					<ul id="menu-container">
                @foreach($menus as $menu)
                <?php $link = (string) $menu->link; ?>
						<li>
							<figure class="m-b-5 {{Request::is($link) ? 'active-menu' : ''}} ">
								<a href="{{url($link ? $link : 'javascript:;')}}"><img class="dashboard-icons @if($menu->status == 2) disabled-menu @endif" src="{{ asset('resources/assets/files/assets/icon/custom-icon/'.$menu->menu_icon) }}" ></a>
								<figcaption class="text-muted text-center">{{$menu->name}}</figcaption>
							</figure>

						</li>
				@endforeach


					</ul>
				</div>

			</div>

			<div class="row">
				<div class="col-xl-12">
					<h4 class="m-b-30 m-t-30">Recent</h4>
				</div>
			</div>

		<div id="load-measurements">
			<h4 class="text-center">Unable to get the measurements <a href='javascript:;' onclick="load_measurements()">Click Here</a> to load measurements</h4>
		</div>

         <input type="hidden" id="del_id" value="0">
         <input type="hidden" id="del_type" value="0">
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
                           <h6 class="text-center">Do You really want to Delete selected Profile ?</h6>
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
</style>
<script type="text/javascript">
	$(function(){

load_measurements();



		$(document).on('click','.getId',function(){
            var id = $(this).attr('data-id');
            var type = $(this).attr('data-type');
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
