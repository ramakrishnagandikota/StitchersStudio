@extends('layouts.shopping')
@section('title','Not found')
@section('content')

    <!--section start-->
    <section class="cart-section section-b-space">
        <div class="container card p-10 m-t-10">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-header accordion active col-lg-12">The page requested was not found</div>

                    <div class="card-body text-center">
                        <p>You may have clicked on expired link or mistyped the address.some web address are case sensitive.</p>
                        <ul class="under">
                            <li><a class="btn theme-btn btn-sm" href="{{url('shop-patterns')}}">Continue
                                    shopping</a> &nbsp;&nbsp;</li>
                            <li><a class="btn theme-btn btn-sm" href="{{url('knitter/dashboard')}}">Go back to
                                    dashboard</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--section end-->
@endsection
@section('footerscript')

@endsection
