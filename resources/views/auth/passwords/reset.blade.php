@extends('layouts.app')
@section('title','Set New Password')
@section('content')

 <!-- Authentication card start -->
<div class="col-sm-12">
<p class="alert alert-danger hide" id="fail">
 Problem in updating new password , please try again after some time.
</p>

<div class="col-sm-12 col-lg-3 col-md-12 m-b-20" style="margin-top: 50px;position: absolute;z-index: 10;">
                    
                </div>
<div id="validation-errors">

</div>
<!-- id="validate-newpassword"  -->
<form id="defaultForm" class="md-float-material form-material"  >
    @csrf

    <input type="hidden" name="tok" value="{{$email}}">
    <input type="hidden" name="token" id="token" value="{{$token}}">
    <div class="text-center">
        <img src="{{ asset('resources/assets/files/assets/images/logoNew.png') }}" class="theme-logo" alt="logo.png">
    </div>
    <div class="auth-box card">
        <div class="card-block custom-padding">
            <div class="row m-b-20">
                <div class="col-md-12">
                    <h4 class="text-center">Set New Password</h4>
                </div>
            </div>

            <div class="form-group form-primary">
                <input type="password" name="password" id="input-password" class="form-control" >
                <span toggle="#input-password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Your password must be more than 8 characters long, should contain at least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character."></i>
                <span class="form-bar"></span>
                <label class="float-label">Enter New Password</label>
                <span class="red hide" id="pass">Password is required.</span>
                <span class="red hide" id="pass1"></span>


                <div class="" id="password-validation-box">
                      <form class="validate-password" method="post" action="#">
                        <fieldset class="fieldset-password">
                          <div id="password-info">
                            <ul>
                              <li id="length" class="invalid clearfix">
                                <span class="icon-container">
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                </span>
                                At least 8 characters
                              </li>
                              <li id="capital" class="invalid clearfix">
                                <span class="icon-container">
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                </span>
                                At least 1 uppercase letter
                              </li>
                              <li id="lowercase" class="invalid clearfix">
                                <span class="icon-container">
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                </span>
                                At least 1 lowercase letter
                              </li>
                              <li id="number-special" class="invalid clearfix">
                                <span class="icon-container">
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                </span>
                                <span title="&#33; &#64; &#35;  &#92; &#36; &#37; &#94; &#38; &#42; " class="special-characters tip">Special character</span>
                              </li>
                              <li id="number-special1" class="invalid clearfix">
                                <span class="icon-container">
                                  <i class="fa fa-check" aria-hidden="true"></i>
                                </span>
                                At least 1 number or <span title="&#33; &#64; &#35;  &#92; &#36; &#37; &#94; &#38; &#42; " class="special-characters tip"></span>
                              </li>
                            </ul>
                          </div>
                          
                        </fieldset>
                        
                      </form>
                    </div>
            </div>
            <div class="form-group form-primary">
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" >
                <i class="fa fa-info pophover" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="right" data-content="Password and Confirm Passwors should match."></i>
                <span class="form-bar"></span>
                <label class="float-label">Re-Enter New Password</label>
                <span class="red hide" id="cnpass">Confirm Password is required.</span>
                <span class="red hide" id="cnpass1">Password & Confirm Password should match.</span>
            </div>
            <div class="row">
                <div class="col-md-12 m-t-20">
                    <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20 theme-outline-btn">Set Password</button>
                </div>
            </div>
            <!-- <p class="f-w-600 text-right">Back to <a href="sign-in.html" style="color: #0d665c;">Login.</a></p>
            <div class="row">
                <div class="col-md-10">
                    <p class="text-inverse text-left m-b-0">Thank you.</p>
                    <p class="text-inverse text-left"><a href="index.html"><b>Back to website</b></a></p>
                </div>

            </div> -->
</div>
</div>
</form>
            <!-- Modal for popup. This will opped up when password set successfully-->
            <div class="modal fade" id="popup-Modal" role="dialog" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-md">
                  <div class="modal-content">
                    <div class="modal-header">
                          <!-- <h5 class="modal-title">Done</h5> -->
                    </div>
                    <div class="modal-body">
                        <p></p>
                           <p class="text-center"><i class="fa fa-check done"></i></p>
                           <h6 class="text-center">Your password has been changed successfully! Thank you ...</h6>
                           <p></p>
                           <p class="text-center"><a class="f-20" href="{{url('login')}}">Go to Login</a></p>
                    </div>
                    <div class="modal-footer">

                    </div>
                  </div>
                </div>
              </div>


</div>
<a id="popup" data-toggle="modal" data-dismiss="modal" data-target="#popup-Modal"></a>

            <!--Set passwors Pop up Ends here-->
@endsection

@section('footersection')
<link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
<script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>
<style type="text/css">
    .hide{
        display: none;
    }
    .red{
        color: #bc7c8f;
        font-weight: bold;
        font-size: 85%;
    }
    .pophover{
            position: absolute;
    top: 15px;
    right: 0px;
    font-size: 11px;
    }
               #password-validation-box{display: none;} 
      .theme-logo {width: 150px;}
      #page {
   margin: 0 15px;
   padding-top: 30px;
}
 label {
   font-size: 0.875em;
}
 
 .form-group.error input {
   border-color: #ee4141;
   box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(238, 65, 65, .4);
}
 .form-group.error label.error {
   margin-top: 5px;
   color: #ee4141;
}
 .pod {
   padding: 25px;
   background: #fff;
   border: 1px solid #d9d9d9;
   border-radius: 4px;
}
 .pod h3 {
   text-align: center;
   margin: 10px 0 30px;
   font-family: 'Lobster', cursive;
}
 #password-info {
   margin:0 auto;
   overflow: hidden;
   text-shadow: 0 1px 0 #fff;
     padding: 6px;
     border: 1px solid #ddd;
     z-index: 1;
     top: 40px;
     width: 100%;
     position: absolute;
     box-shadow:1px 4px 12px 4px #bdbcbc;
     background-color: #ffffff;
}
 #password-info ul {
   list-style: none;
   margin: 0;
   padding: 0;
}
 #password-info ul li {
   padding: 0px 4px 0px 46px;
   margin-bottom: 1px;
   background: #f4f4f4;
   font-size: 12px;
   transition: 250ms ease;
   position: relative;
}
 #password-info ul li .icon-container {
   display: block;
   width: 40px;
   background: #ddd;
   position: absolute;
   top: 0;
   bottom: 0;
   left: 0;
   text-align: center;
}
 #password-info ul li .icon-container .fa {
    color: white;
    padding-top: 0px;
    position: relative;
    top: 0px;
}
 #password-info ul li .tip {
   color: #5ca6d5;
   text-decoration: underline;
}
 #password-info ul li.valid {
   color: #0d665c;
}
 #password-info ul li.valid .icon-container {
   background-color: #0d665c;
}
 #password-info ul li span.invalid {
   color: #ff642e;
}
.has-error .help-block, .has-error .radio, .has-error .checkbox, .has-error .radio-inline, .has-error .checkbox-inline{
  color: #bc7c8f;
  font-weight: bold;
}
.help-block {
    display: block;
    margin-top: 5px;
    *margin-bottom: 10px;
    color: #bc7c8f;
  font-weight:bold;
}
small, .small {
    font-size: 85%;
}
.has-success .form-control {
    border-color: #0d665c;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
}

.has-feedback .form-control {
    padding-right: 42.5px;
}
.has-success .form-control-feedback {
    color: #0d665c;
}
.has-feedback .form-control-feedback {
    position: absolute;
    top: 0px;
    right: 0;
    display: block;
    width: 34px;
    height: 34px;
    line-height: 34px;
    text-align: center;
}
.has-error > input:focus{
  border-bottom: 1px solid #bc7c8f !important;
}
.has-error > .fa{
  *color : #bc7c8f;
}
.has-success > input:focus{
  border-bottom: 1px solid #0d665c !important;
}
</style>


<script type="text/javascript">
    $(function(){
        $('[data-toggle="popover"]').popover();
       setTimeout(function(){ check(); },1000);
       /*  $(document).on('submit','#validate-newpassword',function(e){
            e.preventDefault();
            var Data = $("#validate-newpassword").serializeArray();
            var password = $("#input-password").val();
            var cnfpassword = $("#confirm_password").val();
            var er = [];
            var cnt = 0;

            if(!password){
                $("#pass").removeClass('hide');
                er+=cnt+1;
            }else{
                $("#pass").addClass('hide');
            }

            if(!cnfpassword){
                $("#cnpass").removeClass('hide');
                er+=cnt+1;
            }else{
                $("#cnpass").addClass('hide');
            }

            if(password != cnfpassword){
                $("#cnpass1").removeClass('hide');
                er+=cnt+1;
            }else{
                $("#cnpass1").addClass('hide');
            }


            if(er != ""){
                return false;
            }

            $(".loading").show();

            $.ajax({
                url: '{{url("validate/newpassword")}}',
                type: 'POST',
                data: Data,
            })
            .done(function(res) {
                //console.log(e);
               // alert(JSON.stringify(e));
                if(res == 0){
                   setTimeout(function(){
                    $("#popup").trigger('click');
                    $(".loading").hide();
                   },1000);
                }else{
                    setTimeout(function(){
                        $("#fail").removeClass('hide');
                    },1000);
                }
            })
            .fail(function(res) {
               var response = JSON.parse(res.responseText);
        var errorString = '';
        $.each( response.errors, function( key, value) {
            errorString += value;
        });

        $("#pass1").removeClass('hide').html(errorString);
        setTimeout(function(){
                    $(".loading").hide();
                   },1000);
            })
            .always(function(res) {
                if(res == 0){
                    setTimeout(function(){ window.location.assign('{{url("login")}}'); },3000);
                }else{
                    setTimeout(function(){
                        $("#fail").addClass('hide');
                        $("#pass1").addClass('hide').html('');
                    },4000);
                }
            });
        }) */
		
		
		$('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: '', //fa fa-check
                invalid: '', //fa fa-exclamation
                validating: 'fa fa-spinner fa-spin'
            },
            fields: {
                password: {
                    validators: {
                        notEmpty: {
                            message: 'The password is required.'
                        },
          stringLength: {
                  min: 8,
                  max: 16,
                  message: '     '
                },
          
          regexp: {
                  regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})/,
                  message: 'Invalid password format.'
                }
                    }
                },
        confirm_password: {
          validators: {
            notEmpty: {
              message: 'The confirm password is required.'
            },
            identical: {
              field: 'password',
        message : 'The password & confirm password should be same.'
            }
          }
        }
                
            }
        }).on('success.form.bv', function(e,data) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            
            $.ajax({
              url : '{{url("validate/newpassword")}}',
              type : 'POST',
              data : $form.serialize(),
              beforeSend : function(){
                $(".loading").show();
              },
              success : function(res){
                if(res == 0){
                   setTimeout(function(){
                    $("#popup").trigger('click');
                    $(".loading").hide();
                   },1000);
                }else{
                    setTimeout(function(){
                        $("#fail").removeClass('hide');
                    },1000);
                }
              },
              complete : function(){
                setTimeout(function(){
                  $(".loading").hide();
                },1000);
              }

            });
          }).on('status.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(false);
          });
		  
		  $(".toggle-password").click(function() {
			$(this).toggleClass("fa-eye fa-eye-slash");
			var input = $($(this).attr("toggle"));
			if (input.attr("type") == "password") {
			  input.attr("type", "text");
			} else {
			  input.attr("type", "password");
			}
		 });
		  
    });

    function check(){
        var token = $("#token").val();
        $.get('{{url("check-validpage")}}/'+token,function(res){
            if(res == 'expired'){
                Swal.fire({
                  icon: 'error',
                  title: 'Oops...',
                  text: 'Your reset link was expired.',
                  showCancelButton: false,
                  showConfirmButton: false,
                  footer: '<a href="{{url("login")}}">Click here to login</a>',
                  allowOutsideClick: false
                })
            }
        });
    }
</script>

<script>
    // Tooltips
    // -----------------------------------------
    
    // Only initialise tooltips if devices is non touch
    if (!('ontouchstart' in window)) {
        $('.tip').tooltip();
    }

    //$('[data-toggle="tooltip"]').tooltip();
    
    // Password Validation
    // -----------------------------------------
    
    $(function passwordValidation() {
    
        var pwdInput = $('#input-password');
        var pwdInputText = $('#input-password-text'); // This is the input type="text" version for showing password
        var pwdValid = false;
    
        function validatePwdStrength() {
    
            var pwdValue = $(this).val(); // This works because when it's called it's called from the pwdInput, see end
    
            // Validate the length
            if (pwdValue.length > 7) {
                $('#length').removeClass('invalid').addClass('valid');
                pwdValid = true;
            } else {
                $('#length').removeClass('valid').addClass('invalid');
            }
    
            // Validate capital letter
            if (pwdValue.match(/[A-Z]/)) {
                $('#capital').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#capital').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }
    
            // Validate lowercase letter
            if (pwdValue.match(/[a-z]/)) {
                $('#lowercase').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#lowercase').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }
    
            // special character
            if (pwdValue.match(/[\!@#$%\^&*\\]/)) {
                $('#number-special').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#number-special').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }

             // Validate number
             if (pwdValue.match(/[\d\\]/)) {
                $('#number-special1').removeClass('invalid').addClass('valid');
                pwdValid = pwdValid && true;
            } else {
                $('#number-special1').removeClass('valid').addClass('invalid');
                pwdValid = false;
            }
        }
    
        function validatePwdValid(form, event) {
            if (pwdValid === true) {
                form.submit();
            } else {
                $('#alert-invalid-password').removeClass('hide');
                event.preventDefault();
            }
        }
    
        pwdInput.bind('change keyup input', validatePwdStrength); // Keyup is a bit unpredictable
        pwdInputText.bind('change keyup input', validatePwdStrength); // This is the input type="text" version for showing password
    
        // jQuery Validation
       /* $(".validate-password").validate({
            // Add error class to parent to use Bootstrap's error styles
            highlight: function (element) {
                $(element).parent('.form-group').addClass('error');
            },
            unhighlight: function (element) {
                $(element).parent('.form-group').removeClass('error');
            },
    
            rules: {
                // Ensure passwords match
                "passwordCheckMasked": {
                    equalTo: "#input-password"
                }
            },
            
            errorPlacement: function (error, element) {
                if (element.attr("name") == "password" || element.attr("name") == "passwordMasked") {
                    error.insertAfter("#input-password");
                } else {
                    error.insertAfter(element);
                }
                if (element.attr("name") == "passwordCheck" || element.attr("name") == "passwordCheckMasked") {
                    error.insertAfter("#input-password-check");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function (form, event) {
                //this runs when the form validated successfully
                validatePwdValid(form, event);
            }
        });*/
    
    }); // END passwordValidation()

    $("#input-password").focusin(function() {
    $("#password-validation-box").show();
}).focusout(function () {
    $("#password-validation-box").hide();
});
    </script>

@endsection
