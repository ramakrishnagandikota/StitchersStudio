@extends('layouts.connect')
@section('title','My Profile')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card ">
                <div class="card-header accordion active col-lg-12">The page requested was not found</div>

                <div class="card-body">
                    <p>You may have clicked on expired link or mistyped the address.some web address are case sensitive.</p>
                    <ul>
                        <li><a href="{{url('connect')}}">Return home</a></li>
                        <li><a href="{{url()->previous()}}">Go back to previous page</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footerscript')

@endsection