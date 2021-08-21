
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><strong>Account merged</strong></div>

                <div class="card-body">
				{{ $message }}
                   <a href="{{url('login')}}"> Click here to log in</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
