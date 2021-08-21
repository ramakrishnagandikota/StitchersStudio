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
		 <?php foreach($users as $user); ?>
		<form class="form form-horizontal" id="update-user">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="id" value="{{$user->id}}">


			<hr>

<div id="error"></div><br>

			<div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">First Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="first_name" id="first_name" class="form-control" required
                                 value="{{$user->first_name}}" >
                        </div>
             </div>

			 <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Last Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="last_name" id="last_name" class="form-control" required
                                 value="{{$user->last_name}}">
                        </div>
             </div>

            <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Username<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" name="username" id="username" class="form-control" value="{{ $user->username
                    }}" >
                    <span class="red username"></span>
                </div>
            </div>

			 <div class="form-group row">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Email<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="email" name="email" id="email" class="form-control" required
                                 value="{{$user->email}}" readonly >
                        </div>
             </div>

            <div class="form-group row">
                <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Role<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <?php
                    if($user->hasRole('Knitter')){
                        $role = 2;
                    }else if($user->hasRole('Admin')){
                        $role = 1;
                    }else if($user->hasRole('Designer')){
                        $role = 4;
                    }
                    
                    $roles1 = DB::table('user_role')->where('user_id',$user->id)->get();
                    ?>
                    <select class="form-control" name="role[]" id="role" multiple onchange="changeRole(this.value)">
                        <option value="">Please select option</option>
                        @foreach($roles as $ro)
                            <option value="{{$ro->id}}" 
								@foreach($roles1 as $rol)
									@if($rol->role_id == $ro->id) selected @endif
								@endforeach
                            >{{$ro->role_name}}</option>
                        @endforeach
                    </select>
                    <span class="red email"></span>
                </div>
            </div>


            <div id="paypal_details" class="hide" >
            <input type="hidden" name="paypal_id" value="{{ $paypal ? $paypal->id : 0 }}">
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Store name<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="store_name" id="store_name" class="form-control paypal_credentials"
                               placeholder="Store name" value="{{ $paypal ? $paypal->store_name : '' }}">
                        <span class="red store_name"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Store status<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select name="store_status" id="store_status" class="form-control paypal_credentials" >
                            <option value="" >Please select store status</option>
                            @if($paypal)
                            <option value="1" @if($paypal->store_status == 1) selected @endif >Active</option>
                            <option value="0" @if($paypal->store_status == 0) selected @endif>Inactive</option>
                            @else
                                <option value="1"  >Active</option>
                                <option value="0" >Inactive</option>
                            @endif
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
                            @if($paypal)
                            <option value="personal" @if($paypal->account_type == 'personal') selected @endif
                            >Personal</option>
                            <option value="business" @if($paypal->account_type == 'business') selected @endif
                            >Business</option>
                            @else
                                <option value="personal" >Personal</option>
                                <option value="business" >Business</option>
                            @endif
                        </select>
                        <span class="red account_type"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Paypal email<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="paypal_email" id="paypal_email" class="form-control
                        paypal_credentials" placeholder="Paypal email" value="{{ $paypal ? $paypal->paypal_email : ''
                        }}" >
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

        </form>


 </div>



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
    </style>
    <script type="text/javascript" src="{{asset('node_modules/sweetalert/dist/sweetalert.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
    <script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>
	
	<link href="{{asset('resources/assets/connect/assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('resources/assets/connect/assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{asset('resources/assets/connect/assets/plugins/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('resources/assets/connect/assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>

    <script type="text/javascript">
        $(function(){
            checkRole({{ $user->hasRole('Designer') ? 4 : 0 }});
			
			$("#role").select2({
				placeholder: "Please Select a role",
				allowClear: true
			});
			
			$('#role').on('select2:select', function (e) {
			  var data = e.params.data;
				//console.log(data);
				if(data.id == 4){
					$("#paypal_details").removeClass('hide');
				}
			});
			
			$('#role').on('select2:unselect', function (e) {
			  var data = e.params.data;
				//console.log(data);
				if(data.id == 4){
					$("#paypal_details").addClass('hide');
				}
			});

            $('#update-user')
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
                        url : '{{url("admin/cususers-update")}}',
                        type : 'POST',
                        data : $form.serialize(),
                        beforeSend : function(){
                            $(".loading").show();
                        },
                        success : function(res){
                            if(res == 0){
								$(".loading").hide();
                                
                                //window.location.assign('{{url("login")}}');
                                $("#error").removeClass('alert alert-danger').addClass('alert alert-success').html
                                ('user created successfully.');
                                window.scrollTo({top: 0, behavior: 'smooth'});
                                
                                setTimeout(function(){ location.reload(); },1000);
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

        });

        function checkRole(role){
            if(role == 4){
                $("#paypal_details").removeClass('hide');
            }else{
                $("#paypal_details").addClass('hide');
            }
        }

        function changeRole(val){
            if(val == 4){
                $("#paypal_details").removeClass('hide');
            }
        }
    </script>
@endsection
