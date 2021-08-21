@extends('layouts.app')
@section('title','Reset Password')
@section('content')
<div class="col-sm-12">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('fail'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('fail') }}
                        </div>
                    @endif

                    <form id="defaultForm" class="md-float-material form-material" action="{{url('password-reset')}}" method="POST">
                        @csrf
                    <div class="text-center">
                            <img src="{{ asset('resources/assets/files/assets/images/logoNew.png') }}" class="theme-logo" alt="logo.png">
                        </div>


                        <div class="auth-box card">
                            <div class="card-block">
                                <div class="row m-b-20">
                                    <div class="col-md-12">
                                        <h3 class="text-left">Recover your password</h3>
                                    </div>
                                </div>
                                
                                <div class="form-group form-primary">
                                    <input type="text" name="email" class="form-control" required="">
                                    <span class="form-bar"></span>
                                    <label class="float-label">Enter your email address / username</label>
                                    <span class="red">@if($errors->first('email')) {{$errors->first('email')}} @endif</span>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20 theme-outline-btn">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                                    </div>
                                </div>
                                <p class="f-w-600 text-right">Back to <a href="{{url('login')}}" style="color: #0d665b;">Login.</a></p>
                                <div class="row">
                                    <div class="col-md-10">
                                        <p class="text-inverse text-left m-b-0">Thank you.</p>
                                        <p class="text-inverse text-left"><a href="{{url('/')}}"><b>Back to website</b></a></p>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>

                        

                        
                    </form>

</div>


        

@endsection
@section('footersection')
<link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
<script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>
<style type="text/css">
.red{
    color: red;
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
<script type="text/javascript">
$(function(){
    $('#defaultForm')
        .bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: '', //fa fa-check
                invalid: '', //fa fa-exclamation
                validating: 'fa fa-spinner fa-spin'
            },
            fields: {
                email: {
                    validators: {
                        notEmpty: {
                            message: 'The username / email field is required.'
                        }
                    }
                },
                
            }
        }).on('status.field.bv', function(e, data) {
            data.bv.disableSubmitButtons(false);
        });
    });
</script>
@endsection