@extends('layouts.app')

@section('content')
<div class="container" style="display: none;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

					<?php
					if(Auth::user()->hasRole('Admin')){
						echo '<input type="hidden" id="role" value="admin"><input type="hidden" id="url" value="'.url("admin").'">';
					}

					if(Auth::user()->hasRole('Knitter')){
						echo '<input type="hidden" id="role" value="knitter"><input type="hidden" id="url" value="'.url("knitter/dashboard").'">';
					}

                    if(Auth::user()->hasRole('Designer')){
                        echo '<input type="hidden" id="role" value="designer"><input type="hidden" id="url" value="'.url("designer/main/dashboard").'">';
                    }
					?>

					{{Auth::user()->id}}

                    You are logged in! <a href="{{url('logout')}}"> LOGOUT</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('footersection')

<script type="text/javascript">
    $(function(){

        $('.loading').show();
		var role = $("#role").val();
		var URL = $("#url").val();
        window.location.assign(URL);
    });
</script>

@endsection
