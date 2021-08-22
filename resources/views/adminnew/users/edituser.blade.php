@extends('layouts.adminnew')
@section('title','Users')
@section('section1')
<div class="page-body">
    <div class="row">
        <div class="col-lg-6">
            <h5 class="theme-heading p-10">Users</h5>
        </div>
    </div>
    <div class="card p-20">

        <div class="col-md-12">
            <form class="form form-horizontal" id="update-user">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" value="{{$user->id}}">


                <hr>

                <div id="error"></div><br>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">First Name<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="first_name" id="first-name" class="form-control" required value="{{$user->first_name}}" >
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Last Name<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="last_name" id="last-name" class="form-control" required  value="{{$user->last_name}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Email<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="email" id="email" class="form-control" readonly value="{{$user->email}}">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Username<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="username" id="username" class="form-control" required value="{{ $user->username }}">
                    </div>
                </div>




            </form>

            <div class="clearfix"></div>

            <div class="form-group row">
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <button class="action submit btn btn-success pull-right" id="submit">Submit</button>

                </div>
            </div>
        </div>

    </div>
</div>


@endsection
@section('footerscript')
<style>
    .dataTables_filter .form-control{margin-top: 0px;}
    .radio-btn{display: table;margin: 0 auto;top: -7px;}
    .table td, .table th {
        padding: 0.55rem 0.75rem;
        font-size: 14px;
    }
    .hide{
        display: none;
    }
    .modal-footer{
        padding: 0px !important;
        padding-top:1rem !important;
        border:0px !important;
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
</style>
<link rel="stylesheet" type="text/css" href="{{ asset('resources/assets/files/assets/css/pages.css') }}">
<link rel="stylesheet" href="{{ asset('resources/assets/validator/css/bootstrapValidator.css')}}"/>
<script type="text/javascript" src="{{ asset('resources/assets/validator/js/bootstrapValidator.js') }}"></script>

<link rel="stylesheet" href="{{ asset('resources/assets/select2/select2.min.css') }}" >
<script src="{{ asset('resources/assets/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('resources/assets/select2/select2-searchInputPlaceholder.js') }}"></script>

<script>
    $(function(){
        $(document).on('click','#submit',function(e){
            e.preventDefault();
            var Data = $("#update-user").serializeArray();



            $.ajax({
                url : '{{url("adminnew/cususers-update")}}',
                type : 'POST',
                data : Data,
                beforeSend : function(){
                    $(".loading").show();
                },
                success : function(res){
                    if(res == 0){
                        $("#error").removeClass('alert alert-danger').addClass('alert alert-success').html('user created successfully.');
                        setTimeout(function(){ window.location.assign('{{url("adminnew/cususers-view")}}')},2000);
                    }else{
                        $("#error").removeClass('alert alert-success').addClass('alert alert-danger').html('you have some errors while uploading a user,please check and try again.');
                    }
                },
                complete : function(){
                    $(".loading").hide();
                }
            });
        });
    });
</script>
@endsection
