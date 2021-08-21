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
                                <input placeholder="Name" type="text" class="form-control" id="m_title" name="m_title">
                                <span class="red m_title"></span>
                              </div>
                              <div class="col-lg-1"></div>
                              <div class="col-lg-2"> 
                                <input id="dropper-default" class="form-control" type="text" placeholder="Select your date" name="m_date" />
                                <span class="red m_date"></span>
                              </div>
                              <div class="col-lg-6">
                                 <div class="form-radio row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-2">
                                       
                                          <div class="radio radio-inline">
                                             <label>
                                             <input type="radio" id="radio1" checked="checked" name="measurement_preference" value="inches">
                                             <i class="helper"></i><span class="radio-text">Inches</span>
                                             </label>
                                          </div>
                                    </div>
                                    <div class="col-lg-2">
                                    <div class="radio radio-inline">
                                    <label>
                                    <input type="radio" id="radio2" name="measurement_preference" value="centimeters">
                                    <i class="helper"></i><span class="radio-text">Centimeters</span>
                                    </label>
                                    </div>
                                    
                                    </div> 

                                    <span class="red measurement_preference"></span> 
                                 </div>
                              </div>
                           </div>
                           <input type="hidden" id="imageurl" name="user_meas_image" value="https://via.placeholder.com/150X200">
                         
                           <!-- <div class="row">
                              <label class="col-sm-12 col-form-label">For Whom</label>
                              </div> -->
                           <div class="form-group row">
                              <div class="col-lg-12">
                               
                                 <!-- Upload  -->
                                 <label class="col-sm-12 col-form-label">Upload an image for this profile by selecting the Browse Files button</label>
                                 <br>    <br>
                              </div>
                              
                              <div class="col-lg-12" id="image">
                                 <div class="row">
                                    <div class="col-lg-6 m-l-15">

                              <input type="file" name="file[]" id="filer_input1" style="width: 600px;" data-jfiler-limit="1" data-jfiler-extensions="jpg,jpeg,png">
                                 
                                 <span class="red imageurl"></span>
                                    </div>
                                 </div>

                                   

                              </div>

            
                              <div class="col-md-12">
                                <div class="row" id="imageplace">
                                  

                              
                                </div>
                              </div>

                              </form>
                              <div class="col-lg-12">
                                 <button type="button" id="submit" class="btn btn-default theme-btn pull-right waves-effect m-r-10">Save</button>
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
   
   if(window.localStorage){
    var name = localStorage.getItem('m_title'); 
    $("#m_title").val(name);
   }


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


var ip = '<div class="box"><img src="'+data.path+'" style="width: 150px;height: 200px;margin-top: -5px;margin-left: -4px;"><span style="margin-top: 8px;"><a href="javascript:;" class="green icon1 ">Success</a><a href="#" data-url="'+data.path1+'" class="fa fa-trash-o pull-right icon2 delete-image"></a></span></div>';

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
   
   
   $(document).on('click','#submit',function(){
    
   $.ajaxSetup({
   headers: {
   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   }
   }); 
   var m_title = $("#m_title").val();
   var m_date = $("#dropper-default").val();
   var imageurl = $("#imageurl").val();
   
   var er = [];
   var cnt = 0;
   
   if(m_title == ""){
   $(".m_title").html('Please enter measurement name.');
   er+=cnt+1;
   }else{
   $(".m_title").html('');
   }

   if(m_date == ""){
   $(".m_date").html('Please select date.');
   er+=cnt+1;
   }else{
   $(".m_date").html('');
   }
   
   
   if(er != 0){
   return false;
   }
   
   
   
      var Data = $("#measurements").serializeArray();
   ////alert(JSON.stringify(Data))
   $.ajax({
   url : '{{url("knitter/create-measurements")}}',
   type : 'POST',
   data : Data,
   beforeSend : function(){

    $(".loading").show();
   },
   success : function(res){
   //alert(res)
   if(res.status =='fail'){
    //alert('unable to upload measurement.Try again later.');
     Notifi('fa-times','Success','Measurement set added successfully.','success');
   }else{
    $(".accordion:first-child").trigger('click');
    $("#submit").prop('disabled',true);
    $("#allmeasurements").removeClass('hide').html(res);
   //$('.js-example-basic-single').select2();
   $("form#measurements input").prop('disabled',true);
   }
   },
   complete : function(){
   $(".loading").hide();
   },
   error : function(jqXHR){
    $("form#measurements input").prop('disabled',false);
   }
   }); 
   });
   


     $(document).on('click','.delete-image',function(){
    var id = $("#id").val();
    var path = $(this).attr('data-url');
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
            url : "{{url('knitter/measurements/delete-only-picture')}}",
            type : 'POST',
            data : 'path='+path,
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