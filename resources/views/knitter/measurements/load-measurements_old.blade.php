

<div class="row users-card">
    @if($measurements->count() > 0)
@foreach($measurements as $ms)


    <div class="col-lg-2 col-xl-2 col-md-6 measurementbox id_{{$ms->id}}" id="id_{{base64_encode($ms->id)}}">
        <div class="card rounded-card custom-card">

            <div class="user-content text-left">
            <div style="background-image: url({{ $ms->user_meas_image ? $ms->user_meas_image : 'https://via.placeholder.com/270X350/?text='.$ms->m_title }});background-size: cover;display: block;height: 240px;"></div>
                <h4 class="m-l-10 text-center"> <a href="{{url('knitter/measurements/edit/'.base64_encode($ms->id))}}">{{ $ms->m_title ? ucwords($ms->m_title) : 'No Name' }}</a></h4>
                <p class="m-b-10 m-l-10 text-muted m-r-10">{{ $ms->m_description ? $ms->m_description : $ms->m_title }}</p>

                <!-- <p class="m-b-0 text-muted">The Boyfriend Sweater is a true classic,it is extremely comfortable and not at all fussy!</p> -->
                <div class="editable-items">
                    <a href="{{url('knitter/measurements/edit/'.base64_encode($ms->id))}}" ><i class="fa fa-pencil"></i></a>
                    <i class="fa fa-trash getId" data-type="measurements" data-id="{{base64_encode($ms->id)}}" data-toggle="modal" data-dismiss="modal" data-target="#child-Modal"></i>
                </div>
            </div>

        </div>
    </div>
@endforeach
@endif

@if($projects->count() > 0)
@foreach ($projects as $pro)
<?php
$image = DB::table('projects_images')->where('project_id',$pro->id)->first();
if($image){
    $imag = $image->image_path;
}else{
    $imag = 'https://via.placeholder.com/270X350/?text='.$pro->name;
}

if($pro->pattern_type == 'custom'){
    $link = 'knitter/generate-custom-pattern/'.$pro->token_key.'/'.Str::slug($pro->name);
}elseif($pro->pattern_type == 'non-custom'){
    $link = 'knitter/generate-noncustom-pattern/'.$pro->token_key.'/'.Str::slug($pro->name);
}else{
    $link = 'knitter/generate-pattern/'.$pro->token_key.'/'.Str::slug($pro->name);
}
?>
<div class="col-lg-2 col-xl-2 col-md-6 projectbox id_{{$pro->id}}" id="id_{{base64_encode($pro->id)}}">
    <div class="card rounded-card custom-card">
        <div class="user-content text-left">
        @if($image->image_ext == 'pdf' || $image->image_ext == 'PDF')
            <div class=" pdf-thumb "><p> PDF </p></div>
		<!--<iframe src="{{$imag}}" height="240" width="170"></iframe> -->
        @else
            <div style="background-image: url({{ $imag }});background-size: cover;display: block;height: 240px;"></div>
        @endif
        <h4 class="m-l-10 text-center"> <a href="{{url($link)}}">{{ $pro->name ? Str::limit(ucwords($pro->name),21) : 'No Name' }}</a></h4>
            <p class="m-b-10 m-l-10 text-muted m-r-10">{!! $pro->description ? Str::limit($pro->description,25) : $pro->name !!}</p>
            <div class="editable-items">
                <i class="fa fa-trash getId" data-type="projects" data-id="{{base64_encode($pro->id)}}" data-toggle="modal" data-dismiss="modal" data-target="#child-Modal"></i>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif

</div>


@if($measurements->count() == 0)
<div class="row">
<!-- round card start -->

<div class="col-lg-12 col-xl-12 col-md-9">
<div class="card custom-card skew-card">
    <div class="row">
        <div class="col-lg-6">
            <h3 class="m-l-20 m-t-10 text-muted"></h3>
        </div>
        <div class="col-lg-6">
            <a href="#" >
                <a href="{{url('knitter/measurements')}}" style="text-transform: none;" class="btn waves-effect m-t-10 m-r-20 pull-right waves-light btn-primary theme-outline-btn" ><i class="icofont icofont-plus"></i>Create a measurement profile</a>
            </a>
        </div>
    </div>
        <div class="user-content card-bg m-l-40 m-r-40 m-b-40">
                <img src="{{asset('resources/assets/files/assets/images/arrow.png') }}" id="arrow-img">
            <h3 class="m-t-40 text-muted">Let's create your first measurement profile!</h3>
            <h4 class="text-muted m-t-10 m-b-30">We'll take your measurements and get you ready to generate a custom pattern!</h4>
          </div>

</div>
</div>

<!-- Round card end -->
</div>

@endif

<style>
.projectbox p{
    color: #868e96!important;
}
</style>
