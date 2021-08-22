@extends('layouts.designerapp')
@section('title','Designer Dashboard')
@section('content')

<div class="pcoded-wrapper" id="dashboard">

<div class="pcoded-content">

<div class="pcoded-inner-content">
<div class="main-body">
	<div class="page-wrapper">

		<!-- Page-body start -->
		<div class="page-body">
			<div class="row">
				<div class="col-xl-12">
					<h4>Hi, {{Auth::user()->first_name}} {{Auth::user()->last_name}} </h4>
				</div>
            </div>

            @php
            $menus = App\Models\Menu::where('status','!=',0)->get();

            $num=1;
            @endphp

			<div class="row">
				<div class="col-xl-12 col-sm-12 m-r-20 m-t-20">
					<ul id="menu-container">
						<!--<li>
							<figure class="m-b-5  ">
								<a href="{{url('designer/dashboard') }}"><img class="dashboard-icons " src="https://knitfitnew.test:4434/resources/assets/files/assets/icon/custom-icon/home.png"></a>
								<figcaption class="text-muted text-center">Dashboard</figcaption>
							</figure>

						</li>

						<li>
							<figure class="m-b-5  ">
								<a href="{{url('designer/setup-variables')}}"><img class="dashboard-icons " src="https://knitfitnew.test:4434/resources/assets/files/assets/icon/custom-icon/Projects.png"></a>
								<figcaption class="text-muted text-center">Variable setup</figcaption>
							</figure>

						</li> -->

                            <li>
                                <figure class="m-b-5">
                                    <a href="#"> <img class="dashboard-icons" src="{{ asset('resources/assets/files/assets/icon/custom-icon/Subscription.png') }}" /></a>
                                    <figcaption class="text-muted">Subscribe now</figcaption>
                                </figure>
                            </li>
                            <li>
                                <figure class="m-b-5">
                                    <a href="{{route('my.patterns')}}"> <img class="dashboard-icons" src="{{ asset('resources/assets/files/assets/icon/custom-icon/pattern.png') }}" /></a>
                                    <figcaption class="text-muted">My Patterns</figcaption>
                                </figure>
                            </li>
                            <li>
                                <figure class="m-b-5">
                                    <a href="{{ route('formula.requests') }}"> <img class="dashboard-icons" src="{{ asset('resources/assets/files/assets/icon/custom-icon/Formula-request.png') }}" /></a>
                                    <figcaption class="text-muted">Formula Requests</figcaption>
                                </figure>
                            </li>
                            <li>
                                <figure class="m-b-5">
                                    <a href="{{ route('designer.measurements') }}"> <img class="dashboard-icons" src="{{ asset('resources/assets/files/assets/icon/custom-icon/Measurement.png') }}" /></a>
                                    <figcaption class="text-muted">Measurements</figcaption>
                                </figure>
                            </li>
                            <li>
                                <figure class="m-b-5">
                                    <a href="My sales.html"> <img class="dashboard-icons" src="{{ asset('resources/assets/files/assets/icon/custom-icon/sales.png') }}" /></a>
                                    <figcaption class="text-muted">Sales</figcaption>
                                </figure>
                            </li>
                            <li>
                                <figure class="m-b-5">
                                    <a href="Revenue.html"><img class="dashboard-icons" src="{{ asset('resources/assets/files/assets/icon/custom-icon/Revenue.png') }}" ></a>
                                    <figcaption class="text-muted">Revenue</figcaption>
                                </figure>

                            </li>
                            <li>
                                <figure class="m-b-5">
                                    <a href="New profile.html"> <img class="dashboard-icons" src="{{ asset('resources/assets/files/assets/icon/custom-icon/Timeline.png') }}" /></a>
                                    <figcaption class="text-muted">Connect</figcaption>
                                </figure>
                            </li>
                            <li>
                                <figure class="m-b-5">
                                    <a href="#"> <img class="dashboard-icons" src="{{ asset('resources/assets/files/assets/icon/custom-icon/To-do.png') }}" /></a>
                                    <figcaption class="text-muted">To-Do</figcaption>
                                </figure>
                            </li>
                            <li>
                                <figure class="m-b-5">
                                    <a href="#"> <img class="dashboard-icons" src="{{ asset('resources/assets/files/assets/icon/custom-icon/academy.png') }}" /></a>
                                    <figcaption class="text-muted">Academy</figcaption>
                                </figure>
                            </li>
                            <li>
                                <figure class="m-b-5">
                                    <a href="#"> <img class="dashboard-icons" src="{{ asset('resources/assets/files/assets/icon/custom-icon/Support.png') }}" /></a>
                                    <figcaption class="text-muted">Support</figcaption>
                                </figure>
                            </li>
					</ul>
				</div>

			</div>


            <div class="row">
                <div class="col-xl-12">
                    <h4 class="m-b-30 m-t-30">Patterns </h4>
                </div>
            </div>

            <div class="row users-card">

                @if($patterns->count() > 0)
                    @foreach($patterns as $pat)
                        @php
						$mainPhoto = $pat->patternImages()->get();
						if($mainPhoto->count() > 0){
							$photo = $pat->patternImages()->first()->image_small;
						}else{
							$photo = 'https://via.placeholder.com/150'; 
						}
                        @endphp
                        <div class="col-lg-2 col-xl-2 col-md-2">
                            <div class="rounded-card user-card custom-card">

                                <div class="img-hover">
                                    <!-- <img class="img-fluid img-radius fixed-width-img" src="../../files/assets/images/user-card/The Boyfriend Sweater.jpg" alt="round-img"> -->
                                </div>
                                <div class="user-content card">
                                    <div style="background-image: url({{ $photo }});
                                                    background-size: cover;height: 240px;"></div>
                                    <h4 class="m-t-15 fixed-height m-l-5 m-r-5">{{ ucfirst($pat->name) }}</h4>
                                    <p class="m-b-0 text-muted m-l-5 m-r-5 m-b-10">Status : {{ ($pat->status == 1) ? 'Active' : 'InActive' }}</p>
                                    <div class="editable-items">
                                        <a href="{{ url('designer/edit/pattern/'.$pat->pid.'/'.$pat->slug)}}" class="fa fa-pencil" style="color: #0d665b;font-size: 13px;padding: 0px;background: none;" class="" data-toggle="tooltip" data-placement="top" title="Edit pattern"></a> &nbsp;&nbsp;
                                        <a href="javascript:;" data-id="{{ encrypt($pat->id) }}" class="fa fa-trash deletePattern" data-toggle="tooltip" data-placement="top" title="Delete pattern"></a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                @else
                <div class="col-lg-12 col-xl-12 col-md-9">
                    <div class="card custom-card skew-card">
                        <div class="row">
                            <div class="col-lg-6"><h3 class="m-l-20 m-t-10 text-muted"></h3></div>
                            <div class="col-lg-6"> <button class="btn waves-effect m-t-10 m-r-20 pull-right waves-light btn-primary theme-outline-btn" onclick="window.location.href='{{route('create.pattern')}}'"><i class="icofont icofont-plus"></i>Create Pattern</button></div>
                        </div>
                        <div class="user-content card-bg m-l-40 m-r-40 m-b-40">
                            <img src="{{ asset('resources/assets/files/assets/images/arrow.png') }}" id="arrow-img">
                            <h3 class="m-t-40 text-muted">Let's Create Your First Pattern !</h3>
                            <h4 class="text-muted m-t-10 m-b-30">A better way to manage your Pattern<br>
                                awaits you right here....</h4>
                        </div>

                    </div>
                </div>
                @endif

            </div>


	</div>
	<!-- Page-body end -->
</div>
</div>
</div>
</div>
<!-- Main-body end -->


                <!--Modal will load after pressing delete -->


</div>

@endsection

@section('footerscript')

<!-- Custom js -->
<script type="text/javascript" src="{{asset('resources/assets/jquery.loadingdotdotdot.js')}}"></script>
<style type="text/css">
    .active-menu:hover{
        border-top: 1px solid #0d665c;
        border-bottom: 2px solid #0d665c;
        box-shadow: 1px 1px 1px 1px #0d665c2e;
    }
.pdf-thumb {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    width: 100%;
    height: 240px!important;
    background-color: rgb(189, 127, 145);
    color: white;
    font-weight: 600;
}
.pdf-thumb p{
    color: #fff !important;
    margin-top:100px !important;
}
.disabled{
    opacity: 0.5 !important;
    pointer-events: none !important;
}
</style>

    <script>
        $(function (){
            $(document).on('click','.deletePattern',function (){
                var id = $(this).attr('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Want to delete this pattern.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.value == true) {

                        var Data = 'id='+id;
                        $(".loading").show();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.post('{{ route('delete.pattern') }}',Data)
                            .done(function (res){
                                setTimeout(function (){ location.reload(); },2000);
                                $(".loading").hide();

                                Swal.fire(
                                    'Yeah!',
                                    'Your pattern delete successfully.',
                                    'success'
                                )
                            })
                            .fail(function (xhr, status, error){
                                $(".loading").hide();
                                notification('fa-times','Oops..',error,'danger');
                            });
                    }
                })
            });
        });
    </script>
@endsection
