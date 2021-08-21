@extends('layouts.knitterapp')
@section('title','Knitter Project Library')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="error-template">
                <h2>
                    Oops!</h2>
                <div class="error-details">
                    Sorry, Requested page not found!
                </div>
                <div class="error-actions">
                    <a href="{{url('knitter/project-library')}}" class="btn theme-btn">
                        Back to project library </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('footerscript')
<style>
.error-template {padding: 40px 15px;text-align: center;}
.error-actions {margin-top:15px;margin-bottom:15px;}
.error-actions .btn { margin-right:10px; }
</style>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/script.js')}}"></script>
@endsection