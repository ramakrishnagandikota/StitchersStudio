@extends('layouts.adminnew')
@section('title','Users')
@section('section1')
<div class="page-body">
    <div class="row">
        <div class="col-lg-6">
            <h5 class="theme-heading p-10">Add User</h5>

        </div>
    </div>
    <div class="card p-20">
        <h5 class="pull-right" style="text-align: right;"><a href="{{ url('adminnew/cususers-view') }}">Back to users</a></h5>
        <div class="col-md-12">
            <br>

            @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif

            @if(Session::has('fail'))
                <div class="alert alert-danger">{{ Session::get('fail') }}</div>
            @endif

            <form class="form form-horizontal" id="insert-user" action="{{url('adminnew/cususers-insert')}}" method="POST">
                @csrf
                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">First Name<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="first_name" id="first-name" class="form-control"  >
                        <span style="color:red">{{ $errors->first('first_name') }}</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Last Name<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="last_name" id="last-name" class="form-control"  >
                        <span style="color:red">{{ $errors->first('last_name') }}</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Email<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="email" name="email" id="email" class="form-control" >
                        <span style="color:red">{{ $errors->first('email') }}</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Username<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" name="username" id="username" class="form-control"  >
                        <span style="color:red">{{ $errors->first('username') }}</span>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12 text-right" for="first-name">Role<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="form-control" name="role" id="role">
                            <option value="">Please select option</option>
                            @foreach($roles as $ro)
                                <option value="{{$ro->id}}">{{$ro->role_name}}</option>
                            @endforeach
                        </select>
                        <span style="color:red">{{ $errors->first('role') }}</span>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="form-group row">
                    <div class="col-md-9 col-sm-9 col-xs-12">
                        <button class="action submit btn theme-btn pull-right" id="submit">Submit</button>

                    </div>
                </div>

            </form>


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

    });
</script>
@endsection
