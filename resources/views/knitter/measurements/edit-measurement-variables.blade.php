

<div class=" card col-lg-12">
                        <p>
                        <h5 class="card-header-text theme-heading">Measurements</h5>
                        </p>
                        <!-- personal card start -->

                        <form id="bodymeasurements">
                           @csrf
                          <input type="hidden" name="id" id="id" value="{{base64_encode($id)}}">


                        <!--Third Accordion-->
                        <div class="row theme-row m-b-10">
                           <div class="card-header accordion col-lg-11" data-toggle="collapse" data-target="#section3">
                              <h5 class="card-header-text">Body size</h5>
                           </div>
                           <div class="col-lg-1 m-t-15" data-toggle="collapse" data-target="#section3" >
                              <i class="fa fa-caret-down pull-right micro-icons"></i>
                              </button>
                           </div>
                        </div>
                        <div class="card-block collapse show" id="section3">
                           <div class="row">

        <?php
      /*  $array1 = array('hips','waist','waist_front','bust','bust_front','bust_back');
        $array2 = array('waist_to_underarm','armhole_depth');
        $array3 = array('wrist_circumference','forearm_circumference','upper_arm_circumference','shoulder_circumference');
        $array4 = array('length_to_underarm','length_wrist_to_elbow','length_elbow_to_underarm','arm_length_to_top_of_shoulder');
        $array5 = array('depth_of_neck','neck_width','neck_circumference','neck_to_shoulder','shoulder_to_shoulder'); */
        ?>

        @foreach($body_size as $bs)
            <?php
            if($mp == 'inches'){
               $min = $bs->v_inch_min;
               $max = $bs->v_inch_max;
               $ran = '0.25';
            }else{
               $min = $bs->v_cm_min;
               $max = $bs->v_cm_max;
               $ran = '0.5';
            }

            $name = strtolower($bs->variable_name);
            $namesmall = strtolower($bs->variable_name);
            $unamesmall = str_replace(' ','_',$namesmall);
            ?>
                              <div class="col-md-2">
                                 <div class="form-group">
                                    <label for="int1"> @if($name == 'bust') {{ucfirst($name)}} / Chest @else {{ucfirst($name)}} @endif
                                       <span class="mytooltip tooltip-effect-2">
                                       <span class="tooltip-item">?</span>
                                       <span class="tooltip-content clearfix">
                                       <img src="{{$bs->variable_image}}" alt="" >
                                       <span class="tooltip-text">{{$bs->variable_description}}</span>
                                       </span>
                                       </span>
                                    </label>
                                    <div class="row">
                                       <div class="col-md-12 ui-widget">
                                          <select class="js-example-basic-single col-sm-12 form-control" id="{{str_replace(' ','_',$namesmall)}}" name="{{str_replace(' ','_',$namesmall)}}" placeholder="Select an option">
										  <option value="" selected >Select an option</option>
                                             @for($i=$min;$i<=$max;$i+=$ran)
                                          <option value="{{$i}}" @if($us) @if($us->$unamesmall == $i) selected @endif @endif >{{$i}}</option>
                                             @endfor
                                          </select>
                                          <span class="red {{str_replace(' ','_',$namesmall)}}"></span>
                                       </div>

                                    </div>
                                 </div>
                              </div>

         @endforeach


                           </div>
                        </div>
                        <!--Third Accordion Ends here-->
                        <!--Forth Accordion-->
                        <div class="row theme-row m-b-10">
                           <div class="card-header accordion col-lg-11" data-toggle="collapse" data-target="#section4">
                              <h5 class="card-header-text">Body length</h5>
                           </div>
                           <div class="col-lg-1 m-t-15" data-toggle="collapse" data-target="#section4">
                              <i class="fa fa-caret-down pull-right micro-icons"></i>
                              </button>
                           </div>
                        </div>
                        <div class="card-block collapse show" id="section4">
                           <div class="row">


                  @foreach($body_length as $bl)

                  <?php
            if($mp == 'inches'){
               $min1 = $bl->v_inch_min;
               $max1 = $bl->v_inch_max;
               $ran1 = '0.25';
            }else{
               $min1 = $bl->v_cm_min;
               $max1 = $bl->v_cm_max;
               $ran1 = '0.5';
            }

            $name1 = strtolower($bl->variable_name);
            $namesmall1 = strtolower($bl->variable_name);
            $unamesmall1 = str_replace(' ','_',$namesmall1);
            ?>

                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="int1">{{ucfirst($name1)}}
                                       <span class="mytooltip tooltip-effect-2">
                                       <span class="tooltip-item">?</span>
                                       <span class="tooltip-content clearfix">
                                       <img src="{{$bl->variable_image}}" alt="">
                                       <span class="tooltip-text">{{$bl->variable_description}}</span>
                                       </span>
                                       </span>
                                    </label>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <select class="js-example-basic-single col-sm-12 form-control" id="{{str_replace(' ','_',$namesmall1)}}" name="{{str_replace(' ','_',$namesmall1)}}" placeholder="Select an option">
										  <option value="" selected >Select an option</option>
                                             @for($j=$min1;$j<=$max1;$j+=$ran1)
                                          <option value="{{$j}}" @if($us) @if($us->$unamesmall1 == $j) selected @endif @endif >{{$j}}</option>
                                             @endfor
                                          </select>
                                          <span class="red {{str_replace(' ','_',$namesmall1)}}"></span>
                                       </div>

                                    </div>
                                 </div>
                              </div>
                  @endforeach

                           </div>
                        </div>
                        <!--Forth Accordion Ends here-->
                        <!--Fifth Accordion-->
                        <div class="row theme-row m-b-10">
                           <div class="card-header accordion col-lg-11" data-toggle="collapse" data-target="#section5">
                              <h5 class="card-header-text">Arm size</h5>
                           </div>
                           <div class="col-lg-1 m-t-15" data-toggle="collapse" data-target="#section5">
                              <i class="fa fa-caret-down pull-right micro-icons"></i>
                              </button>
                           </div>
                        </div>
                        <div class="card-block collapse show" id="section5">
                           <div class="row">

                  @foreach($arm_size as $as)


                        <?php
            if($mp == 'inches'){
               $min2 = $as->v_inch_min;
               $max2 = $as->v_inch_max;
               $ran2 = '0.25';
            }else{
               $min2 = $as->v_cm_min;
               $max2 = $as->v_cm_max;
               $ran2 = '0.5';
            }

            $name2 = strtolower($as->variable_name);
            $namesmall2 = strtolower($as->variable_name);
            $unamesmall2 = str_replace(' ','_',$namesmall2);
            ?>

                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="int1">{{ucfirst($name2)}}               <span class="mytooltip tooltip-effect-2">
                                       <span class="tooltip-item">?</span>
                                       <span class="tooltip-content clearfix">
                                       <img src="{{$as->variable_image}}" alt="">
                                       <span class="tooltip-text">{{$as->variable_description}}</span>
                                       </span>
                                       </span>
                                    </label>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <select class="js-example-basic-single col-sm-12 form-control" id="{{str_replace(' ','_',$namesmall2)}}" name="{{str_replace(' ','_',$namesmall2)}}" placeholder="Select an option">
										  <option value="" selected >Select an option</option>
                                             @for($k=$min2;$k<=$max2;$k+=$ran2)
                                          <option value="{{$k}}" @if($us) @if($us->$unamesmall2 == $k) selected @endif @endif >{{$k}}</option>
                                             @endfor
                                          </select>
                                          <span class="red {{str_replace(' ','_',$namesmall2)}}"></span>
                                       </div>

                                    </div>
                                 </div>
                              </div>
                  @endforeach

                           </div>
                        </div>
                        <!--Fifth Accordion Ends here-->
                        <!--Sixth Accordion-->
                        <div class="row theme-row m-b-10">
                           <div class="card-header accordion col-lg-11" data-toggle="collapse" data-target="#section6">
                              <h5 class="card-header-text">Arm length</h5>
                           </div>
                           <div class="col-lg-1 m-t-15" data-toggle="collapse" data-target="#section6">
                              <i class="fa fa-caret-down pull-right micro-icons"></i>
                              </button>
                           </div>
                        </div>
                        <div class="card-block collapse show" id="section6">
                           <div class="row">

                  @foreach($arm_length as $al)

                              <?php
            if($mp == 'inches'){
               $min3 = $al->v_inch_min;
               $max3 = $al->v_inch_max;
               $ran3 = '0.25';
            }else{
               $min3 = $al->v_cm_min;
               $max3 = $al->v_cm_max;
               $ran3 = '0.5';
            }

            $name3 = strtolower($al->variable_name);
            $namesmall3 = strtolower($al->variable_name);
            $unamesmall3 = str_replace(' ','_',$namesmall3);
            ?>

                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="int1">{{ucfirst($name3)}}
                                       <span class="mytooltip tooltip-effect-2">
                                       <span class="tooltip-item">?</span>
                                       <span class="tooltip-content clearfix">
                                       <img src="{{$al->variable_image}}" alt="">
                                       <span class="tooltip-text">{{$al->variable_description}}</span>
                                       </span>
                                       </span>
                                    </label>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <select class="js-example-basic-single col-sm-12 form-control" id="{{str_replace(' ','_',$namesmall3)}}" name="{{str_replace(' ','_',$namesmall3)}}" placeholder="Select an option">
										  <option value="" selected >Select an option</option>
                                             @for($l=$min3;$l<=$max3;$l+=$ran3)
                                          <option value="{{$l}}" @if($us) @if($us->$unamesmall3 == $l) selected @endif @endif >{{$l}}</option>
                                             @endfor
                                          </select>
                                          <span class="red {{str_replace(' ','_',$namesmall3)}}"></span>
                                       </div>

                                    </div>
                                 </div>
                              </div>
                  @endforeach


                           </div>
                        </div>
                        <!--Sixth Accordion Ends here-->
                        <!--Seventh Accordion-->
                        <div class="row theme-row m-b-10">
                           <div class="card-header accordion col-lg-11" data-toggle="collapse" data-target="#section7">
                              <h5 class="card-header-text">Neck and shoulders</h5>
                           </div>
                           <div class="col-lg-1 m-t-15" data-toggle="collapse" data-target="#section7">
                              <i class="fa fa-caret-down pull-right micro-icons"></i>
                              </button>
                           </div>
                        </div>
                        <div class="card-block collapse show" id="section7">
                           <div class="row">

                  @foreach($neck_and_shoulders as $ns)

                                    <?php
            if($mp == 'inches'){
               $min4 = $ns->v_inch_min;
               $max4 = $ns->v_inch_max;
               $ran4 = '0.25';
            }else{
               $min4 = $ns->v_cm_min;
               $max4 = $ns->v_cm_max;
               $ran4 = '0.5';
            }

            $name4 = strtolower($ns->variable_name);
            $namesmall4 = strtolower($ns->variable_name);
            $unamesmall4 = str_replace(' ','_',$namesmall4);
            ?>

                              <div class="col-md-3">
                                 <div class="form-group">
                                    <label for="int1">{{ucfirst($name4)}}
                                       <span class="mytooltip tooltip-effect-2">
                                       <span class="tooltip-item">?</span>
                                       <span class="tooltip-content clearfix">
                                       <img src="{{$ns->variable_image}}" alt="">
                                       <span class="tooltip-text">{{$ns->variable_description}}</span>
                                       </span>
                                       </span>
                                    </label>
                                    <div class="row">
                                       <div class="col-md-12">
                                          <select class="js-example-basic-single col-sm-12 form-control" id="{{str_replace(' ','_',$namesmall4)}}" name="{{str_replace(' ','_',$namesmall4)}}" placeholder="Select an option">
										  <option value="" selected >Select an option</option>
                                             @for($m=$min4;$m<=$max4;$m+=$ran4)
                                          <option value="{{$m}}" @if($us) @if($us->$unamesmall4 == $m) selected @endif @endif >{{$m}}</option>
                                             @endfor
                                          </select>
                                          <span class="red {{str_replace(' ','_',$namesmall4)}}"></span>
                                       </div>

                                    </div>
                                 </div>
                              </div>

                  @endforeach

                           </div>
                        </div>

                         </form>
                        <!--Seventh Accordion Ends here-->
                        <div class="text-center m-b-10">
                           <a href="javascript:;" onclick="if(confirm('Are you sure want to go back from this page ?')){ window.location.assign('{{url("knitter/measurements")}}') }" id="edit-cancel" class="btn btn-default waves-effect m-r-10">Cancel</a>
                           <!-- <button id="savedata" onclick="savedata()" class="btn theme-btn btn-primary waves-effect waves-light">Update</button> -->
                           <button id="savedata"  onclick="getAllData();" class="btn theme-btn btn-primary waves-effect waves-light">Save</button>
                        </div>
                        <!-- end of card-block -->
                     </div>


<style type="text/css">
   .error{
      border: 1px solid red !important;
      border-radius: .25rem !important;
   }
   .select2-results__option{display:block!important}
   .mytooltip{
	   z-index: 9 !important;
   }
</style>
<!--<link rel="stylesheet" type="text/css" href="{{asset('resources/assets/selectize/selectize.css')}}">
<script type="text/javascript" src="{{asset('resources/assets/selectize/selectize.min.js')}}"></script> -->
<link rel="stylesheet" href="{{ asset('resources/assets/rkjs/rkjs.css') }}" >
<script type="text/javascript">
   $(function(){
     /* $('.js-example-basic-single').select2({
        placeholder: 'Select an option',
        searchInputPlaceholder: 'Search from list'
      }); */
	 /*$('.js-example-basic-single').selectize();*/
	 
		$("body").rSelect({
           class: 'js-example-basic-single',
           placeholder: 'Search & select a value',
           min:0,
           errorMsg: 'You have entered a incorrect input.',
           allow : 'numbers' // numbers / alpha or both (*)
        });
		
		$('.myselect').on('click', function() {
            var val = $(this).val();
            if(val == 0){
               $(this).val('');
            }
         });

   });

   function savedata(){
      //var select = $(".js-example-basic-single");
      var er = [];
      var cnt = 0;
      $("#UnsavedChanges").val(0);

      var m_title = $("#m_title").val();
      var m_date = $("#dropper-default").val();
      var measurement_preference = $("input[name='measurement_preference']:checked").val();
      var user_meas_image = $("input#image").val();
      var ext = $("#ext").val();

      var Data = $("#bodymeasurements").serializeArray();


  /*  for (var i = 0; i < Data.length; i++) {
        var data = Data[i].name;
        var var_name = $("#"+data).val();

        if(i > 1){
          if(var_name == 0){
            $("."+var_name).html('This field is required.');
            er+=cnt+1;
          }else{
            $("."+var_name).html('');
          }
        }
    }

    //alert(er);
    if(er != ""){
      alert('Please fill all the measurement variable values.');
      return false;
    } */

                 Data.push({name: 'type', value: 'update'});
                 Data.push({name: 'm_title', value: m_title});
                 Data.push({name: 'm_date', value: m_date});
                 Data.push({name: 'measurement_preference', value: measurement_preference});
                 Data.push({name: 'image', value: user_meas_image});
                 Data.push({name: 'ext', value: ext});
      $.ajax({
          url : '{{url("knitter/update-variables")}}',
          type : 'POST',
          data : Data,
          beforeSend : function(){
            $(".loading").show();
          },
          success : function(res){
            if(res.status == 'success'){
               var pro = localStorage.getItem('project');
               if(pro){
                  setTimeout(function(){ window.location.assign('{{url("knitter/project-library")}}') },2000);
               }else{
                  setTimeout(function(){ window.location.assign('{{url("knitter/measurements")}}') },2000);
               }
            //Notifi('fa-check','Success','Measurement variables updated successfully.','success');

            }else{
               //Notifi('fa-times','Fail','Unable to add Measurement variable, Try again after some time.','danger')
            }
          },
          complete : function(){
            setTimeout(function(){ $(".loading").hide(); },2000)
          }
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
