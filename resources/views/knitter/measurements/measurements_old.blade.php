@extends('layouts.knitterapp')
@section('title','Knitter Dashboard')
@section('content')
<div class="pcoded-wrapper" id="dashboard">
  <div class="pcoded-content">
      <div class="pcoded-inner-content">
          <div class="main-body">
              <div class="page-wrapper">
                  <div class="page-body">
                     <div class="row">
                         <div class="col-lg-12">
<section class="section-b-space ratio_asos">
<div class="collection-wrapper">
<div class="container">
<div class="row">
<div class="collection-content col">
<div class="page-main-content">
<div class="row">
<div class="col-sm-12">

  @if(session('message'))
<div class="alert alert-success">{{session('message')}}</div>
@endif

@if(session('error'))
<div class="alert alert-danger">{{session('error')}}</div>
@endif

  <div class="collection-product-wrapper">
      <div class="product-wrapper-grid">
          <div class="row card-bg">
              <div class="col-lg-4">
                  <h5 class="theme-heading page-header-title f-w-600 m-b-15">Measurement profile</h5></div>
              <div class="col-lg-8 m-b-10">
              @if(Auth::user()->subscription_type == 1)
                @if($meas->count() == 1)
                  <button id="add-measurement-profile-btn" class="btn waves-effect pull-right waves-light btn-primary theme-outline-btn" data-toggle="modal" data-target="#NoModal"><i class="icofont icofont-plus"></i>Add measurement profile</button>
                @else
                  <button id="add-measurement-profile-btn" class="btn waves-effect pull-right waves-light btn-primary theme-outline-btn" data-toggle="modal" data-target="#myModal"><i class="icofont icofont-plus"></i>Add measurement profile</button>
                @endif
              @else
              <button id="add-measurement-profile-btn" class="btn waves-effect pull-right waves-light btn-primary theme-outline-btn" data-toggle="modal" data-target="#myModal"><i class="icofont icofont-plus"></i>Add measurement profile</button>
              @endif


              </div>

@if($meas->count() > 0)
    @foreach($meas as $ms)

    <?php
    if($ms->user_meas_image){
      $img = $ms->user_meas_image;
    }else{
      $img = 'https://via.placeholder.com/200X250';
    }
    ?>
              <div class="col-xl-2 col-md-6 col-grid-box measurementbox id_{{$ms->id}}" id="card{{$ms->id}}">
                  <div class="product-box">
                      <div class="img-wrapper">
                          <div class="front">
                              <a class="measure" href="#"><img src="{{$img}}" class="img-fluid blur-up lazyload bg-img" alt=""></a>
                          </div>

                      </div>
                      <div class="product-detail">
                          <div>
                              <a href="{{url('knitter/measurements/edit/'.base64_encode($ms->id))}}"><h5 class="m-t-10 min-height-heading">{{ $ms->m_title ? ucwords($ms->m_title) : 'No Name' }}</h5></a>
                              <div class="editable-items">
                                  <a href="{{url('knitter/measurements/edit/'.base64_encode($ms->id))}}" ><i class="fa fa-pencil"></i></a>
                                  <i class="fa fa-trash getId" data-toggle="modal" data-dismiss="modal" data-target="#child-Modal" data-id="{{base64_encode($ms->id)}}"></i>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>

@endforeach

            @else

            <div class="col-lg-12 col-xl-12 col-md-9">
            <div class="card custom-card skew-card">
                    <div class="user-content card-bg m-l-40 m-r-40 m-b-40">
                            <img src="{{asset('resources/assets/files/assets/images/arrow.png') }}" id="arrow-img">
                        <h3 class="m-t-40 text-muted">Let's create your first measurement profile!</h3>
                        <h4 class="text-muted m-t-10 m-b-30">We'll take your measurements and get you ready to generate a custom pattern!</h4>
                    </div>

            </div>
        </div>

            @endif

          </div>
      </div>

  </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
                         </div>
                      </div>
                  </div>
              </div>
          </div>
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

             <!-- Modal -->
             <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                          <h5 class="modal-title">Measurement Details</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
  <form class="form-horizontal m-t-10" id="insert-measurements">
  @csrf
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Name</label>
      <div class="col-sm-10">
        <input placeholder="Name" type="text" name="measurement_name" id="measurement_name" class="form-control">
         <span class="measurement_name"></span>
      </div>
    </div>

    <input type="hidden" name="image1" value="" id="imageurl">
      </form>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Cancel</button>
         <button type="submit" id="submit" class="btn btn-success submit-btn" data-toggle="modal">Next</button>
    </div>
    </div>

                  </div>
                </div>


<div class="modal fade" id="NoModal" role="dialog">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                          <h5 class="modal-title">Subscription Required</h5>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
<p class="text-center" >You are in <b>Free subscription</b> now.</p>
<p class="text-center">Please upgrade your subscriptionto <b>Basic</b> to add more measurement profiles.</p>

                  </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger cancel-btn" data-dismiss="modal">Close</button>
    </div>
    </div>

                  </div>
                </div>



 <div class="row users-card justify-content-center m-t-10">


                   <input type="hidden" id="del_id" value="0">


                   <div class="col-lg-12 col-xl-12 col-md-9 hide" id="nomeasurements">
            <div class="card custom-card skew-card">
                    <div class="user-content card-bg m-l-40 m-r-40 m-b-40">
                            <img src="{{asset('resources/assets/files/assets/images/arrow.png') }}" id="arrow-img">
                        <h3 class="m-t-40 text-muted">Let's create your first measurement profile!</h3>
                        <h4 class="text-muted m-t-10 m-b-30">We'll take your measurements and get you ready to generate a custom pattern!</h4>
                    </div>

            </div>
        </div>
                                    <!-- Round card end -->
          </div>
@endsection

@section('footerscript')
<style type="text/css">
  .hide{
    display: none;
  }
  .custom-control-label::before
            {
                border: .8px solid #0d665c!important;
                background-color: transparent;
            }
            .list-group-item {

                padding: .75rem 0rem;
            }

            select option:hover,
    select option:focus,
    select option:active {
        background: linear-gradient(#000000, #000000);
        background-color: #000000 !important; /* for IE */
        color: #ffed00 !important;
    }
    a:hover{text-decoration: none;}

</style>
<!-- Custom js -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/e-commerce.css') }}">
        <!-- Theme css -->
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/color17.css') }}" media="screen" id="color">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/KnitfitEcommerce/assets/css/left-menu.css') }}">

<!-- slick js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/slick.js') }}"></script>
<!-- menu js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/menu.js') }}"></script>

<!-- lazyload js-->
<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/lazysizes.min.js') }}"></script>

<script src="{{ asset('resources/assets/KnitfitEcommerce/assets/js/script.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>

<script type="text/javascript">
  $(function(){

    var pro = localStorage.getItem('project');
   // alert(pro);
    //if(pro){
      //window.location.assign('url("knitter/project-library")}}');
    //}

setTimeout(function(){
    var divStyle = $(".measure");
        divStyle.each(function(index,i){
            var ss = $(this).prop("style");
            ss.removeProperty("background-position");
        });
    },1000);


    $(document).on('click','.getId',function(){

      var id = $(this).attr('data-id');
      $(".delete-card").attr('data-id',id);
      $("#del_id").val(atob(id));
    });

    $(document).on('click','.delete-card',function(){
      var id = $("#del_id").val();

      if(id != 0){
        $(".loading").show();
        $.get( "{{url('knitter/measurements/delete')}}/"+id, function( data ) {
          setTimeout(function(){ $(".loading").hide(); },1000);
          if(data == 0){
            $(".id_"+id).remove();
            if($(".measurementbox").length  == 0){
              $("#nomeasurements").removeClass('hide');
            }
            Swal.fire(
                      'Great!',
                      'Measurement profile removed successfully.',
                      'success'
                    )
          }else{
            Swal.fire(
                      'Oops!',
                      'Unable to remove Measurement profile',
                      'error'
                    )
          }

        });
      }else{
        Swal.fire(
                  'Oops!',
                  'Unable to delete.Please refresh the page and try again',
                  'error'
                )
      }

    });


//Notifi('fa-check','Success','Good boy');

    setTimeout(function(){ $('.alert-success').hide() },4000);

    $(document).on('change','#file-upload-form',function(e){
  e.preventDefault();
  $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
  });

    $.ajax({
      url: "{{url('knitter/upload-measurement-picture')}}",
      type: "POST",
      data:  new FormData(this),
      beforeSend: function(){
        $(".loading").show();
      },
      contentType: false,
      processData:false,
      success: function(data)
        {
          if(data.path != 0){
        //alert(data.path)
             $("#file-image").attr('src',data.path);
            $("#file-image1").attr('src',data.path);
            $("#imageurl").val(data.path);
            $("#imageurl1").val(data.path);
      //setTimeout(function(){ location.reload(); },1000);
            //swal('Success','Profile picture changed sucessfully','success');
          }else{
            //swal('Fail','Unable to upload file , Try again after some time.','error');
          }
        },
        complete : function(){
        $(".loading").hide();
        },
        error: function()
        {
        }
     });

});


    $(document).on('click','#submit',function(){
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
        var measurement_name = $("#measurement_name").val();

        var er = [];
        var cnt = 0;

        if(measurement_name == ""){
            $(".measurement_name").css('color','red').html('Please enter measurement name.');
            er+=cnt+1;
        }else{
            $(".measurement_name").css('color','').html('');
        }




        if(er != 0){
            return false;
        }

        //var name = localStorage.getItem('measurement_name');
        //alert(name);

        localStorage.setItem('m_title',measurement_name);
        window.location.assign('{{url("knitter/add-measurementset")}}');

     /*   var Data = $("#insert-measurements").serializeArray();
    ////alert(JSON.stringify(Data))
        $.ajax({
          url : 'url("knitter/create-measurements")',
          type : 'POST',
          data : Data,
          beforeSend : function(){

          },
          success : function(res){
        //alert(res)
            if(res.status == 'success'){
              window.location.assign(' url("knitter/measurements/edit")'+'/'+res.id);
            }else{
              alert('unable to upload measurement.Try again later.');
            }
          },
          complete : function(){

          }
        }); */
    });

  });


   function Notifi(icon,m,msg){

     $.notify({
            icon: 'fa '+icon,
            title: m+'!',
            message: msg
        },{
            element: 'body',
            position: null,
            type: "info",
            allow_dismiss: true,
            newest_on_top: true,
            showProgressbar: true,
            placement: {
                from: "top",
                align: "right"
            },
            offset: 20,
            spacing: 10,
            z_index: 10000,
            style: 'bootstrap',
            delay : 5000,
            animate: {
                enter: 'animated fadeInUp',
                exit: 'animated fadeOutDown'
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

</script>

@endsection
