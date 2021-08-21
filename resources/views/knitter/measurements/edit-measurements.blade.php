@extends('layouts.knitterapp')
@section('title','Knitter Dashboard')
@section('content')
<div class="pcoded-wrapper">
   <div class="pcoded-content">
      <div class="pcoded-inner-content">
         <div class="main-body">
            <div
               class="page-wrapper">
               <!-- Page-body start -->
               <div class="page-body">
                  <div class="row">
                     <div class=" card col-lg-12">
                        <p>
                        <h5
                           class="card-header-text theme-heading"></h5>
                        </p> <!-- personal card
                           start --> <!--First Accordion Starts here-->
                        <div class="row
                           outline-row m-b-10">
                           <div  class="card-header accordion col-lg-11"
                              data-toggle="collapse" data-target="#section1">
                              <h5
                                 class="card-header-text">Measurement Profile</h5>
                           </div>
                           <div
                              class="col-lg-1 m-t-15"> <i class="fa fa-caret-down pull-right
                              micro-icons"></i> </button> </div>
                        </div>
                        <div class="card-block
                           collapse show" id="section1">
                           <div class="row">
                              <div class="col-lg-4 radio-text m-b-10">Name</div>
                              <div class="col-lg-4 radio-text">Measurements were taken on..</div>
                              <div class="col-lg-4 radio-text">Unit of measurement</div>
                           </div>
                           <form id="measurements">
                            @csrf
                           <div class="row">
                              <div class="col-lg-3">
                                <input placeholder="Name" type="text" class="form-control" id="m_title" name="m_title" value="{{$me->m_title}}">
                                <span class="red m_title"></span>
                              </div>
                              <div class="col-lg-1"></div>
                              <div class="col-lg-2">
                                <input id="dropper-default" class="form-control" type="text" placeholder="Select your date" name="m_date" value="{{date('m/d/Y',strtotime($me->m_date))}}" />
                                <span class="red m_date"></span>
                              </div>
                              <div class="col-lg-6">
                                 <div class="form-radio row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2">

                                          <div class="radio radio-inline">
                                             <label>
                                             <input type="radio" id="radio1" class="radio" @if($me->measurement_preference == 'inches') checked disabled @endif name="measurement_preference" value="inches">
                                             <i class="helper"></i><span class="radio-text">Inches</span>
                                             </label>
                                          </div>
                                    </div>
                                    <div class="col-lg-2">
                                    <div class="radio radio-inline">
                                    <label>
                                    <input type="radio" id="radio2" class="radio" @if($me->measurement_preference == 'centimeters') checked disabled @endif  name="measurement_preference" value="centimeters">
                                    <i class="helper"></i><span class="radio-text">Centimeters</span>
                                    </label>
                                    </div>

                                    </div>

                                    <span class="red measurement_preference"></span>
                                 </div>
                              </div>
                           </div>
                           <input type="hidden" id="imageurl" name="user_meas_image" value="{{$me->user_meas_image}}">

                           <!-- <div class="row">
                              <label class="col-sm-12 col-form-label">For Whom</label>
                              </div> -->
                           <div class="form-group row">
                              <div class="col-lg-12">

                                 <!-- Upload  -->
                                 <label class="col-sm-12 col-form-label">Upload an image for this profile by selecting the Browse Files button</label>
                                 <br>    <br>
                              </div>

                              <div class="col-lg-12 @if($me->user_meas_image != "https://via.placeholder.com/200X250") hide @endif " id="image">
                                 <div class="row">
                                    <div class="col-lg-6 m-l-15">

                                     <input type="file" name="file[]" id="filer_input1" style="width: 600px;" data-jfiler-limit="1" data-jfiler-extensions="jpg,jpeg,png">

                                 <span class="red imageurl"></span>
                                    </div>
                                 </div>



                              </div>

            </form>

<!--
    <div class="col-md-12">
    <div class="row @if($me->user_meas_image == "https://via.placeholder.com/200X250") hide @endif " id="imageplace">

    <div class="box">
        @if($me->user_meas_image)
        <img src="{{$me->user_meas_image}}" style="width: 150px;height: 200px;">
        @endif
        <span style="margin-top: 8px;">
            <a href="javascript:;" class="icon1"></a>
            <a href="javascript:;" data-id="{{$me->id}}" data-url="@if($me->user_meas_image){{$me->user_meas_image}}@endif" class="fa fa-trash-o pull-right icon2 delete-image"></a>
        </span>
    </div>



    </div>
    </div>
-->

<div class="col-lg-12">
<section class="section-b-space ratio_asos @if($me->user_meas_image == "https://via.placeholder.com/200X250") hide @endif " id="imageplace">
<div class="collection-wrapper">

<div class="row">
<div class="collection-content col">
<div class="page-main-content">
<div class="row">
<div class="col-sm-12">
<div class="collection-product-wrapper">
<div class="product-wrapper-grid">
<div class="row">
<div class="col-xl-2 col-md-6 col-grid-box">
<div class="product-box" style="margin-top:0px;">
    <div class="img-wrapper">
        <div class="front">
            <a href="#" class="measure" ><img src="{{$me->user_meas_image}}" class="img-fluid blur-up lazyload bg-img" alt=""></a>
        </div>
    </div>
    <div class="product-detail">
        <div>
            <div class="editable-items delete-image" data-id="{{$me->id}}" data-url="@if($me->user_meas_image){{$me->user_meas_image}}@endif">
            <i class="fa fa-trash" ></i>
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
</div>
</div>
</div>

</div>
</section>
</div>


                           </div>
                           <!--First Accordion Ends here -->
                           <!-- <div class="sub-title">Example 1</div> -->
                        </div>
                     </div>
                  </div>
                  <div class="row hide" id="allmeasurements">

                  </div>


               </div>
               <!-- Page-body end -->
            </div>
         </div>
      </div>
   </div>
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirm measurements</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="confirmVariables">

      </div>
	  <div class="row text-center m-t-30 m-b-30">
        <div class="col-lg-12">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Edit measurements</button>
			<button type="button" onclick="savedata();" class="btn theme-btn btn-primary waves-effect waves-light">Confirm measurements</button>
		</div>
	  </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Edit measurements</button>
        <button type="button" onclick="savedata();" class="btn theme-btn btn-primary waves-effect waves-light">Confirm measurements</button>
      </div> -->
    </div>
  </div>
</div>
<input type="hidden" id="UnsavedChanges" value="0">
@endsection
@section('footerscript')


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


<script type="text/javascript">
  var URL = '{{url("knitter/upload-measurement-picture")}}';
</script>

<link href="{{ asset('resources/assets/select2/select2.min.css') }}" rel="stylesheet" />
    <!-- Date-time picker css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/pages/advance-elements/css/bootstrap-datetimepicker.css') }}">
 <!-- Date-time picker css -->
   <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/pages/advance-elements/css/bootstrap-datetimepicker.css') }}">
   <!-- Date-Dropper css -->
   <link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/bower_components/datedropper/css/datedropper.min.css') }}" />
 <!-- jquery file upload Frame work -->
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/jquery.filer.css') }}" type="text/css" rel="stylesheet" />
<link href="{{ asset('resources/assets/files/assets/pages/jquery.filer/css/themes/jquery.filer-dragdropbox-theme.css') }}" type="text/css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">

<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/jquery.filer/js/jquery.filer.min.js') }}"></script>
<script src="{{ asset('resources/assets/files/assets/pages/filer/custom-filer.js') }}" type="text/javascript"></script>
<script src="{{ asset('resources/assets/files/assets/pages/filer/jquery.fileuploads.init.js') }}" type="text/javascript"></script>
<!-- Select 2 js -->


<link rel="stylesheet" type="text/css" href="{{asset('resources/assets/select2/select2.min.css')}}">
<script type="text/javascript" src="{{asset('resources/assets/select2/select2.full.min.js')}}"></script>


    <!-- Bootstrap date-time-picker js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/pages/advance-elements/moment-with-locales.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/pages/advance-elements/bootstrap-datetimepicker.min.js') }}"></script>
<!-- Date-range picker js -->
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/bootstrap-daterangepicker/js/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/datedropper/js/datedropper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/pages/advance-elements/custom-picker.js') }}"></script>
<script type="text/javascript" src="{{asset('resources/assets/select2/select2-searchInputPlaceholder.js')}}"></script>


<script src="{{ asset('resources/assets/rkjs/index.js') }}"></script>
<style type="text/css">
  .custom-file-upload {
   cursor: pointer;
  border: 2px dashed #C8CBCE;
    display: inline-block;
    padding:50px 220px;
    line-height: 1.5;
    color: #0d665c;
}

.custom-file-upload span{
  border: 1px solid #0d665c;
  padding: 10px;
}
.custom-file-upload span:hover{
  background-color: #0d665c;
  color: #fff;
  border:1px solid #0d665c;
}

#upload-photo {
   opacity: 0;
   position: absolute;
   z-index: -1;
}


.box{
      height: 240px;
    width: 175px;
  margin:3px;
    padding: 10px;
    border: 1px solid #e1e1e1;
    border-radius: 3px;
    background: #fff;
    -webkit-box-shadow: 0px 0px 3px rgba(0,0,0,0.06);
    -moz-box-shadow: 0px 0px 3px rgba(0,0,0,0.06);
    box-shadow: 0px 0px 3px rgba(0,0,0,0.06);
}
.icon2{
  margin-top: 5px;
}
.green{
  color: green;
}
.hide{
  display: none;
}
.red{
color: #bc7c8f;
font-weight:bold;
font-size: 12px;
}
.full-width{
  width: 100%;
}
.header-navbar .navbar-wrapper .navbar-container .header-notification .show-notification li img, .header-navbar .navbar-wrapper .navbar-container .header-notification .profile-notification li img{
	height : 48px !important;
}
#confirmVariables{height: 70vh;overflow-y: scroll;}
thead>tr{background-color: #dcdcdc;}
</style>

<script type="text/javascript">
    

    function HandleFieldChange()
    {
        $("#UnsavedChanges").val(1);
    }

    window.onbeforeunload = function(e) {
    if ($("#UnsavedChanges").val() == 1){
            return 'Are your sure you want to leave this profile without saving?';
        }
    }

   $(function(){

    $("input").change(function(){
        HandleFieldChange();
    });
    $("select").change(function(){
        HandleFieldChange();
    });
    $("textarea").change(function(){
        HandleFieldChange();
    });
    $("input:checkbox").click(function(){
        HandleFieldChange();
    });
    $("input:radio").click(function(){
        HandleFieldChange();
    });

    get_variables();

    setTimeout(function(){
    var divStyle = $(".measure");
        divStyle.each(function(index,i){
            var ss = $(this).prop("style");
            ss.removeProperty("background-position");
        });
    },1000);


   $('[data-toggle="tooltip"]').tooltip();
   $('[data-toggle="popover"]').popover({
        html: true,
        content: function() {
            return $('#primary-popover-content').html();
        }
    });


   $(document).on("mouseout" , ".hover-placeholder" , function () {

        $(this).removeAttr('placeholder');

    });

    $(document).on("mouseover" , ".hover-placeholder" , function () {

        if($(this).val() == ''){
            $(this).attr('placeholder' , "_ . _");
        }
    });

   $(document).on('change','#file-upload-form',function(e){
   e.preventDefault();

   var id = atob($("#id").val());

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


var ip = '<div class="box"><img src="'+data.path+'" style="width: 150px;height: 200px;"><span style="margin-top: 8px;"><a href="javascript:;" class="green icon1 delete-image">Success</a><a href="#" data-id="'+id+'" data-url="'+data.path1+'"  class="fa fa-trash-o pull-right icon2 delete-image" data-type="insert"></a></span></div>';

$("#imageplace").removeClass('hide').html(ip);
$("#image").addClass('hide');
   //alert(data.path)
   //$("#file-image").attr('src',data.path);
   //$("#file-image1").attr('src',data.path);
   $("#imageurl").val(data.path);
   //$("#imageurl1").val(data.path);
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
   
   $("input[type='radio']").click(function(){
        var radioValue = $("input[name='measurement_preference']:checked").val();
        if(radioValue == 'inches'){
          var r1 = 'centimeters';
          var check = $("#radio2");
        }else{
          var r1 = 'inches';
          var check = $("#radio1");
        }
          if(confirm('If you change the measurement preference , the data may get lost ?')){
              get_variables(radioValue);
              check.prop('disabled',false);
              if(radioValue == 'inches'){
                $("#radio1").prop('disabled',true);
              }else{
                $("#radio2").prop('disabled',true);
              }
          }else{
            check.prop('checked',true);
          }
        
    });

 /* $("input[type='radio']").click(function(){
        var radioValue = $("input[name='measurement_preference']:checked").val();
		mp = radioValue;
        if(radioValue != '{{$me->measurement_preference}}'){

          if(confirm('If you change the measurement preference , the data may get lost ?')){
            $(".loading").show();
    var id = '{{base64_encode($id)}}';
    $.get('{{url("knitter/get-measurement-variables/")}}/'+id+'/'+mp,function(res){
      $("#allmeasurements").removeClass('hide').html(res);
      setTimeout(function(){ 
	  $(".loading").hide();
	  $(".js-example-basic-single").val(0);
		$('.js-example-basic-single').select2({
		placeholder: 'Select an option',
		searchInputPlaceholder: 'Search from list'
	  }).trigger('change');
	  },1000);
    });
				 
          }else{
				$(".loading").show();
    var id = '{{base64_encode($id)}}';
    $.get('{{url("knitter/get-measurement-variables/")}}/'+id+'/'+mp,function(res){
      $("#allmeasurements").removeClass('hide').html(res);
	  $(".loading").hide();
	});
			$("#radio1").prop("checked", true);
          }
        }else{

           if(confirm('If you change the measurement preference , the data may get lost ?')){
              $(".loading").show();
    var id = '{{base64_encode($id)}}';
    $.get('{{url("knitter/get-measurement-variables/")}}/'+id+'/'+mp,function(res){
      $("#allmeasurements").removeClass('hide').html(res);
	  $(".loading").hide();
	});
              $("#radio1").prop("checked", true);
           }else{

            $(".loading").show();
    var id = '{{base64_encode($id)}}';
    $.get('{{url("knitter/get-measurement-variables/")}}/'+id+'/'+mp,function(res){
      $("#allmeasurements").removeClass('hide').html(res);
      setTimeout(function(){ 
	  $(".loading").hide();
	  $(".js-example-basic-single").val(0);
		$('.js-example-basic-single').select2({
		placeholder: 'Select an option',
		searchInputPlaceholder: 'Search from list'
	  }).trigger('change');
	  },1000);
    });
				
					
				  
			
				  
			  }
     

           }

        
    }); */

  $(document).on('click','.delete-image',function(){
    var id = $(this).attr('data-id');
    var path = $(this).attr('data-url');
    var type = $(this).attr('data-type');
      Swal.fire({
        title: 'Are you sure want to delete this image ?',
        text: "",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        closeOnClickOutside: false,
        closeOnEsc: false,
        allowOutsideClick: false,
        showClass: {
          popup: 'animated fadeInDown faster'
        },
        hideClass: {
          popup: 'animated fadeOutUp faster'
        }
      }).then((result) => {
        if (result.value) {

          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });

          $.ajax({
            url : "{{url('knitter/measurements/delete-picture')}}",
            type : 'POST',
            data : 'id='+id+'&path='+path+'&type='+type,
            beforeSend : function(){
              $(".loading").show();
            },
            success : function(data){

              if(data.status == 'success'){
                $("#imageplace").addClass('hide');
                $("#image").removeClass('hide');
                $("#imageurl").val(0);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
            }else{
                Swal.fire(
                  'Not Deleted!',
                  'Server Error , Please try again after some time..',
                  'error'
                )
            }
            },
            complete : function(){
              $(".loading").hide();
            }
          })



        }
      });
  });


   });

  function getAllData(){
	  
	    var er = [];
	var cnt = 0;
	
	$('.myselect').each(function(){
		var val = $(this).hasClass('error');
		if(val == true){
			er+=cnt+1;
		}
	});
	
	
	if(er != ''){
		Swal.fire({
		  icon: 'error',
		  title: 'Oops...',
		  text: 'Please fill valid data for measurements.'
		});
		return false;
	}else{
		var options = {
			backdrop: 'static',
			keyboard : false
		}
		$('.bd-example-modal-lg').modal(options);
	}
	  
	  var radio1 = $("#radio1").prop('checked');
    var radio2 = $("#radio2").prop('checked');

    if(radio1 == true){
      var mp = '"'
    }else{
      var mp = 'cm';
    }
	
    var Data = $("#bodymeasurements").serializeArray();


    //alert(JSON.stringify(Data));
    var new_str;
    var obj = JSON.stringify(Data);
    var aa = JSON.parse(obj);
    var cc = '<p class="f-14 m-b-10" style="color: #000000;">Please review and confirm that these measurements are correct</p><div class="table-responsive"><table class="table table-styling confrim-measurement table-info">';
    for ($i = 2; $i < aa.length; $i++){
      var heading = aa[$i]['name'].replace(/[^a-zA-Z ]/g, " ");
      new_str = heading.charAt(0).toUpperCase()+heading.slice(1);



      if($i == 2){
        cc+='<thead><tr><th class="t-heading">Body size</th><th></th><th></th><th></th></tr></thead><tbody>';
      }else if($i == 8){
        cc+='<thead><tr><th class="t-heading">Body length</th><th></th><th></th><th></th></tr></thead><tbody>';
      }else if($i == 10){
        cc+='<thead><tr><th class="t-heading">Arm size</th><th></th><th></th><th></th></tr></thead><tbody>';
      }else if($i == 14){
        cc+='<thead><tr><th class="t-heading">Arm length</th><th></th><th></th><th></th></tr></thead><tbody>';
      }else if($i == 18){
        cc+='<thead><tr><th class="t-heading">Neck and Shoulders</th><th></th><th></th><th></th></tr></thead><tbody>';
      }




      if($i < 18){

        var j = parseInt($i) + 3;
      var heading1 = aa[j]['name'].replace(/[^a-zA-Z ]/g, " ");
      var new_str1 = heading1.charAt(0).toUpperCase()+heading1.slice(1);
	  
	  var value = (aa[$i]['value'] == "") ? 0 : aa[$i]['value'];
      var value1 = (aa[j]['value'] == "") ? 0 : aa[j]['value'];
	  
	  //console.log($i+','+new_str+' - '+value);
	  //console.log($i+','+new_str1+' - '+value1);

        if($i == 2 || $i == 3 || $i == 4){
          cc+='<tr><th>'+new_str+'</th><td>'+value+' '+mp+'</td>'+'<th>'+new_str1+'</th><td>'+value1+' '+mp+'</td></tr>';
        }else if($i == 5 || $i == 6 || $i == 7){
          cc+='';
        }else{
          if($i % 2 === 0){
            cc+='<tr><th>'+new_str+'</th><td>'+value+' '+mp+'</td>';
          }else{
            cc+='<th>'+new_str+'</th><td>'+value+' '+mp+'</td></tr>';
          }
        }

    }else{
		var j = parseInt($i);
      var heading1 = aa[j]['name'].replace(/[^a-zA-Z ]/g, " ");
      var new_str1 = heading1.charAt(0).toUpperCase()+heading1.slice(1);
	  
	  var value = (aa[$i]['value'] == "") ? 0 : aa[$i]['value'];
      var value1 = (aa[j]['value'] == "") ? 0 : aa[j]['value'];
	  
      if($i % 2 !== 0){
        cc+='<tr><th>'+new_str+'</th><td>'+value1+' '+mp+'</td>';
      }else{
        cc+='<th>'+new_str+'</th><td>'+value1+' '+mp+'</td></tr>';
      }
    }





    }
    cc+='</tbody></div>';
    //alert(cc);

    $("#confirmVariables").html(cc);
  }

   function get_variables(val){

    if(val){
      if(val == 'inches'){
      var mp = 'inches';
    }else{
      var mp = 'centimeters';
    }
    }else{
      var mp = '{{$me->measurement_preference}}';
    }

    if(!mp){
      alert('Please select measurement preference.');
      return false;
    }
    $(".loading").show();
    var id = '{{base64_encode($id)}}';
    $.get('{{url("knitter/get-measurement-variables/")}}/'+id+'/'+mp,function(res){
      $("#allmeasurements").removeClass('hide').html(res);
      setTimeout(function(){ $(".loading").hide(); },1000);
    });

   }

   function Notifi(icon,m,msg,info){

     $.notify({
            icon: 'fa '+icon,
            title: m+' !',
            message: msg
        },{
            element: 'body',
            position: null,
            type: info,
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
