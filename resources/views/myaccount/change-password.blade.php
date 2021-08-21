@extends('layouts.shopping')
@section('title','My account')
@section('content')
<!-- section start -->
@if(Session::has('success'))
<div class="alert alert-success">{{Session::get('success')}}</div>
@endif

@if(Session::has('fail'))
<div class="alert alert-danger">{{Session::get('fail')}}</div>
@endif



<section class="section-b-space">
    <div class="container">
        <div class="row">

                <div class="col-sm-12 col-lg-3 col-md-12 m-b-20" style="margin-top: 60px;
    position: absolute;
    z-index: 10;
    left: 167px;">
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


            <div class="col-lg-3">
                <div class="account-sidebar"><a class="popup-btn">my account</a></div>
                <div class="dashboard-left">
                    <div class="collection-mobile-back"><span class="filter-back"><i class="fa fa-angle-left" aria-hidden="true"></i> back</span></div>
                    <div class="block-content card">
					<h4 class="card-header m-b-10" >Account</h4>
                    @include('layouts.myaccount-menu')
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="dashboard-right">
                    <div class="dashboard card">
                        <div class="page-title">

                        <div class="box-account box-info">
                            <div class="box-head">
                                <h2>Account info</h2></div>
                            <div class="row">

<div class="col-sm-12">

<div class="box-content"><br>
    <div class="">
            <form class="theme-form text-center" action="{{url('change-password')}}" method="POST">
            	@csrf
                    <div class="form-row">
                        <div class="col-md-6 offset-lg-3">
                            <input type="password" class="form-control" id="oldPassword" name="old_password" placeholder="Old Password" required=""><br>
                            <input type="password" class="form-control" id="input-password" name="new_password" placeholder="New Password" required="" >
                            <span toggle="#input-password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
							<span>{{$errors->first('new_password')}}</span>
                            <br>
                            <input type="password" class="form-control" id="confirmPassword" name="confirm_new_password" placeholder="Confirm Password" required="">
							<span>{{$errors->first('confirm_new_password')}}</span>
                            <br>
                        </div></div>
                        <button type="submit" class="btn theme-btn waves-effect waves-light" id="mc-submit-password">Change password</button>
                </form>
</div>
</div><br>

</div>


                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>






<!-- section end -->
@endsection
@section('footerscript')
<style type="text/css">
                  #password-validation-box{ display: none; float: right;}
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
     margin: 20px -94px;
     overflow: hidden;
     text-shadow: 0 1px 0 #fff;
     padding: 8px;border: 1px solid #ddd;
}
 #password-info ul {
     list-style: none;
     margin: 0;
     padding: 0;
}
 #password-info ul li {
     padding: 10px 10px 10px 50px;
     margin-bottom: 1px;
     background: #f4f4f4;
     font-size: 12px;
     transition: 250ms ease;
     position: relative;
     display: inherit !important;
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
     padding-top: 10px;
     position: relative;
     top: 2px;
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
.myaccount{
        display: none;
    }
</style>
<script>
$(".toggle-password").click(function() {
$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});
</script>
<script>

$(function(){
    $('#input-password').keypress(function(event){
      var value = $(this).val();

      if(value.length > 15){
        return false;
      }
  });
});

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
                pwdValid = false;
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

            if(pwdValid == false){
              $("#submit").attr('disabled',true);
            }else{
              $("#submit").attr('disabled',false);
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
        $(".validate-password").validate({
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
        });
    
    }); // END passwordValidation()

    $("#input-password").focusin(function() {
    $("#password-validation-box").show();
}).focusout(function () {
    $("#password-validation-box").hide();
});
    </script>
@endsection
