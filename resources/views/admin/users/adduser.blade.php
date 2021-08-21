@extends('layouts.admin')
@section('breadcrum')
    <div class="col-md-12 col-12 align-self-center">
        <h3 class="text-themecolor">Add User</h3>
        <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
            <li class="breadcrumb-item"><a href="{{url('designer/dashboard')}}">Dashboard</a></li>
        </ol>
    </div>

@endsection

@section('section1')
    <div class="card col-12">
        <div class="card-body">
            <a class="btn waves-effect waves-light btn-success pull-right" href="{{url('admin/cususers-view')}}">Back</a>
            <div class="clearfix"></div>
            <div class="col-md-12">

                <form class="form form-horizontal" id="insert-user" method="POST" action="{{url('admin/cususers-insert')}}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">


                    <hr>

                    <div id="error"></div><br>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">First Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}" >
                            <span class="red first_name"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Last Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}" >
                            <span class="red last_name"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Username<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}" >
                            <span class="red username"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Email<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="email" name="email" id="email" class="form-control" value="">
                            <span class="red email"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right"
                               for="first-name">Password<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                                <div class="form-primary">
                                    <input type="password" id="input-password" maxlength="16" name="password" class="form-control" placeholder="Password">
                                    <span toggle="#input-password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    <span class="form-bar"></span>
                                    <!-- <label class="float-label text-muted">Password</label> -->
                                    <span class="red password">@if($errors->first('password')) {{$errors->first('password')}} @endif</span>
                                </div>
                                <div class="" id="password-validation-box">
                                    <div class="validate-password" method="post" action="#">
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
                                    </div>
                                </div>


                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Role<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" name="role" id="role" onchange="checkRole(this.value)">
                                <option value="">Please select option</option>
                                @foreach($roles as $ro)
                                    <option value="{{$ro->id}}" @if(old('role') == $ro->id) selected @endif >{{$ro->role_name}}</option>
                                @endforeach
                            </select>
                            <span class="red email"></span>
                        </div>
                    </div>


                    <div id="paypal_details" class="hide">
<hr>
                        <h4 class="text-center m-b-20">Paypal Details</h4>
                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Store name<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="store_name" id="store_name" class="form-control paypal_credentials" placeholder="Store name" value="{{ old('store_name') }}">
                                <span class="red store_name"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Store status<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="store_status" id="store_status" class="form-control paypal_credentials" >
                                    <option value="" >Please select store status</option>
                                    <option value="1" @if(old('store_status') == 1) selected @endif >Active</option>
                                    <option value="0" @if(old('store_status') == 0) selected @endif>Inactive</option>
                                </select>
                                <span class="red store_status"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Account type<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="account_type" id="account_type" class="form-control paypal_credentials" >
                                    <option value="">Please select account type</option>
                                    <option value="personal" @if(old('account_type') == 'personal') selected @endif >Personal</option>
                                    <option value="business" @if(old('account_type') == 'personal') selected @endif >Business</option>
                                </select>
                                <span class="red account_type"></span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Paypal email<span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="paypal_email" id="paypal_email" class="form-control paypal_credentials" placeholder="Paypal email" value="{{ old('paypal_email') }}" >
                                <span class="red paypal_email"></span>
                            </div>
                        </div>
                    </div>



                    <div class="clearfix"></div>

                    <div class="form-group row">
                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <button class="action submit btn btn-success pull-right" type="submit" id="submit">Submit</button>

                        </div>
                    </div>
            </div>

            </form>

        </div>
    </div>
@endsection

@section('section2')

@endsection

@section('footerscript')
    <style>
        .hide{
            display:none;
        }
        .red{
            color: #bc7c8f;
            font-weight:bold;
            font-size: 12px;
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
        #password-validation-box{display: none;}
        #password-info {
            margin:0 auto;
            overflow: hidden;
            text-shadow: 0 1px 0 #fff;
            padding: 6px;
            border: 1px solid #ddd;
            z-index: 9;
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
        .toggle-password {
            position: absolute;
            top: 10px;
            right: -10px;
        }
    </style>
    <script type="text/javascript" src="{{asset('node_modules/sweetalert/dist/sweetalert.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
    <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

    <script type="text/javascript">
        $(function(){

            $('#insert-user')
                .bootstrapValidator({
                    message: 'This value is not valid',
                    feedbackIcons: {
                        valid: '', //fa fa-check
                        invalid: '', //fa fa-exclamation
                        validating: 'fa fa-spinner fa-spin'
                    },
                    fields: {
                        first_name: {
                            message: 'The first name is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The first name is required.'
                                },
                                stringLength: {
                                    min: 2,
                                    message: 'First name must contain atleast 2 characters'
                                },

                                /*remote: {
                                    url: 'remote.php',
                                    message: 'The first name is not available'
                                },*/
                                regexp: {
                                    regexp: /^[a-zA-Z]+$/,
                                    message: 'The first name can only consist of alphabets'
                                }
                            }
                        },
                        last_name: {
                            message: 'The last name is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The last name is required.'
                                },
                                stringLength: {
                                    min: 2,
                                    message: 'Last name must contain atleast 2 characters'
                                },
                                /*remote: {
                                    url: 'remote.php',
                                    message: 'The last name is not available'
                                },*/
                                regexp: {
                                    regexp: /^[a-zA-Z]+$/,
                                    message: 'The last name can only consist of alphabets'
                                }
                            }
                        },
                        username: {
                            message: 'The username is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The username is required.'
                                },
                                stringLength: {
                                    min: 5,
                                    max: 25,
                                    message: 'Username must contain atleast 5 characters.'
                                },
                                remote: {
                                    url: '{{url("check-username")}}',
                                    message: 'The username is already in use. Please enter another one.'
                                },
                                regexp: {
                                    regexp: /^[a-zA-Z0-9]+$/,
                                    message: 'The username can only consist of alphabets and numbers'
                                }
                            }
                        },
                        email: {
                            validators: {
                                notEmpty: {
                                    message: 'The email address is required.'
                                },
                                emailAddress: {
                                    message: ''
                                },
                                remote: {
                                    url: '{{url("check-email")}}',
                                    message: 'The email is already in use. Please enter another one.'
                                },
                            }
                        },
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
                        role: {
                            message: 'The role is not valid',
                            validators: {
                                notEmpty: {
                                    message: 'The role is required.'
                                }
                            },
                            callback: {
                                message: "Close time should be greater than end time",
                                callback: function(value, validator, $field) {
                                    return checkDates();
                                }
                            }
                        },
                        paypal_email: {
                            //enabled: false,
                            validators: {
                                emailAddress: {
                                    message: 'Please enter a valid email address.'
                                },
                                remote: {
                                    url: '{{route("admin.check.paypal.email")}}',
                                    message: 'The email is already used in another paypal account. Please enter ' +
                                        'another one.'
                                }
                            }
                        }

                    }
                })
                .on('success.form.bv', function(e) {
                    // Prevent form submission
                    e.preventDefault();

                    // Get the form instance
                    var $form = $(e.target);

                    // Get the BootstrapValidator instance
                    var bv = $form.data('bootstrapValidator');

                    $.ajax({
                        url : '{{url("admin/cususers-insert")}}',
                        type : 'POST',
                        data : $form.serialize(),
                        beforeSend : function(){
                            $(".loading").show();
                        },
                        success : function(res){
                            if(res == 0){
                                $("#insert-user")[0].reset();
                                //window.location.assign('{{url("login")}}');
                                $("#error").removeClass('alert alert-danger').addClass('alert alert-success').html
                                ('user created successfully.');
                                //window.scrollTo(0);
                                setTimeout(function(){ location.reload(); },2000);
                            }else{
                                $("#error").removeClass('alert alert-success').addClass('alert alert-danger').html('you have some errors while uploading a user,please check and try again.');
                            }
                        },
                        complete : function(){
                            $(".loading").hide();
                        },
                        error: function (jqXHR, exception) {
                            var err = eval("(" + jqXHR.responseText + ")");

                            console.log(err)

                            if(err.errors.first_name){
                                $('.first_name').html(err.errors.first_name);
                            }

                            if(err.errors.last_name){
                                $('.last_name').html(err.errors.last_name);
                            }

                            if(err.errors.username){
                                $('.username').html(err.errors.username);
                            }

                            if(err.errors.email){
                                $('.email').html(err.errors.email);
                            }

                            if(err.errors.store_name){
                                $('.store_name').html(err.errors.store_name);
                            }

                            if(err.errors.store_status){
                                $('.store_status').html(err.errors.store_status);
                            }

                            if(err.errors.account_type){
                                $('.account_type').html(err.errors.account_type);
                            }

                            if(err.errors.paypal_email){
                                $('.paypal_email').html(err.errors.paypal_email);
                            }


                        }
                    });
                }).on('status.field.bv', function(e, data) {
                if (data.bv.getSubmitButton()) {
                    data.bv.disableSubmitButtons(false);
                }
            });

            /*$(document).on("change", "#role", function () {
                var role = $("#role").val();
                var isEmpty = $(this).val() == '';
                if(role == 4){
                    $("#paypal_details").removeClass('hide');
                    $('#insert-user').bootstrapValidator('enableFieldValidators', 'store_name', !isEmpty).bootstrapValidator
                    ('validateField', 'store_name');
                    $('#insert-user').bootstrapValidator('enableFieldValidators', 'store_status', !isEmpty).bootstrapValidator
                    ('validateField', 'store_status');
                    $('#insert-user').bootstrapValidator('enableFieldValidators', 'account_type', !isEmpty).bootstrapValidator
                    ('validateField', 'account_type');
                    $('#insert-user').bootstrapValidator('enableFieldValidators', 'paypal_email', !isEmpty).bootstrapValidator('validateField', 'paypal_email');
                    console.log('coming here');
                } else {
                    $('#insert-user').bootstrapValidator('enableFieldValidators','store_name', false, 'notEmpty').bootstrapValidator('enableFieldValidators','store_status', false, 'notEmpty').bootstrapValidator('enableFieldValidators','account_type', false, 'notEmpty').bootstrapValidator('enableFieldValidators','paypal_email', false, 'notEmpty');
                }
                $("#submit").prop('disabled',false);
            });*/

            /*
                $(document).on('click','#submit',function(e){
                    e.preventDefault();
                    var Data = $("#insert-user").serializeArray();



                    $.ajax({
                        url : '{{url("admin/cususers-insert")}}',
				type : 'POST',
				data : Data,
				beforeSend : function(){

				},
				success : function(res){
					if(res == 0){
						$("#error").removeClass('alert alert-danger').addClass('alert alert-success').html('user created successfully.');
						setTimeout(function(){ window.location.assign('{{url("admin/cususers-view")}}')},2000);
					}else{
						$("#error").removeClass('alert alert-success').addClass('alert alert-danger').html('you have some errors while uploading a user,please check and try again.');
					}
				},
				complete : function(){}
			});
		});*/

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




        function checkRole(val){
            if(val == 4){
                $("#paypal_details").removeClass('hide');
            }
        }

    </script>

    <script>
        // Tooltips
        // -----------------------------------------

        // Only initialise tooltips if devices is non touch
        if (!('ontouchstart' in window)) {
            //$('.tip').tooltip();
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
        }); // END passwordValidation()

        $("#input-password").focusin(function() {
            $("#password-validation-box").show();
        }).focusout(function () {
            $("#password-validation-box").hide();
        });
    </script>
@endsection
