

<div class="row users-card">

@if($projects->count() > 0)
@foreach ($projects as $pro)
<?php
$project = DB::table('projects')->where('user_id',Auth::user()->id)->where('is_archive',0)->where('is_deleted',0)->orderBy('updated_at','ASC')->select('id','name','updated_at')->take(5)->get();
$parray = array();
if(!Auth::user()->isSubscriptionExpired()){
    if($project->count() > 0){
        foreach($project as $p){
            array_push($parray,$p->id);
        }
    }
    
}else{
    $parray = array();
}

if(Auth::user()->hasSubscription('Free')){
    if(in_array($p->id,$parray)){
        $disabled = 0;
    }else{
        $disabled = 1;
    }
    
}else{
    $disabled = 0;
}


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
<div class="col-lg-2 col-xl-2 col-md-6 projectbox id_{{$pro->id}}  @if($disabled == 1) disabled @endif " id="id_{{base64_encode($pro->id)}}">
    <div class="card rounded-card custom-card " >
        <div class="user-content text-left">
        @if($image)
            @if($image->image_ext == 'pdf' || $image->image_ext == 'PDF')
            <div class=" pdf-thumb "><p> PDF </p></div>
            @else
                <div style="background-image: url({{ $imag }});background-size: cover;display: block;height: 240px;"></div>
            @endif
        @else
            <div style="background-image: url({{ $imag }});background-size: cover;display: block;height: 240px;"></div>
        @endif
        
        
        <h4 class="m-l-10 text-center"> 
            @if($disabled == 1)
            <a href="javascript:;">{{ $pro->name ? Str::limit(ucwords($pro->name),21) : 'No Name' }}</a>
            @else
            <a href="{{url($link)}}">{{ $pro->name ? Str::limit(ucwords($pro->name),21) : 'No Name' }}</a>
            @endif
        </h4>
        @if($pro->pattern_type == 'custom')
<img class="img-fluid strip-image" src="{{ asset('resources/assets//files/assets/images/headerLogo-old.png') }}" alt="Theme-Logo" />
@endif
           <!-- <p class="m-b-10 m-l-10 text-muted m-r-10">{!! $pro->description ? Str::limit($pro->description,25) : $pro->name !!}</p> -->
            @if($disabled == 0)
            <div class="editable-items">
                <i class="fa fa-trash getId" data-type="projects" data-id="{{base64_encode($pro->id)}}" data-toggle="modal" data-dismiss="modal" data-target="#child-Modal"></i>
            </div>
            @endif
        </div>
    </div>
</div>
@endforeach
@endif


<?php $measurement = Auth::user()->measurements()->first(); ?>
    @if($measurements->count() > 0)
@foreach($measurements as $ms)
@php
if(!Auth::user()->isSubscriptionExpired()){
    if($measurements){
        if($measurement->id != $ms->id){
            $disabled1 = 1;
        }else{
            $disabled1 = 0;
        }
    }
    
}else{
    $disabled1 = 0;
}
@endphp
    <div class="col-lg-2 col-xl-2 col-md-6 measurementbox id_{{$ms->id}} @if($disabled1 == 1) disabled @endif " id="id_{{base64_encode($ms->id)}}">
        <div class="card rounded-card custom-card">

            <div class="user-content text-left">
            <div style="background-image: url({{ $ms->user_meas_image ? $ms->user_meas_image : 'https://via.placeholder.com/270X350/?text='.$ms->m_title }});background-size: cover;display: block;height: 240px;"></div>
                <h4 class="m-l-10 text-center"> 
                    @if($disabled1 == 0)
                    <a href="{{url('knitter/measurements/edit/'.base64_encode($ms->id))}}">{{ $ms->m_title ? ucwords($ms->m_title) : 'No Name' }}</a>
                    @else
                    <a href="javascript:;">{{ $ms->m_title ? ucwords($ms->m_title) : 'No Name' }}</a>
                    @endif
                </h4>
                <!--<p class="m-b-10 m-l-10 text-muted m-r-10">{{ $ms->m_description ? $ms->m_description : $ms->m_title }}</p> -->

                <!-- <p class="m-b-0 text-muted">The Boyfriend Sweater is a true classic,it is extremely comfortable and not at all fussy!</p> -->
                @if($disabled1 == 0)
                <div class="editable-items">
                    <a href="{{url('knitter/measurements/edit/'.base64_encode($ms->id))}}" ><i class="fa fa-pencil"></i></a>
                    <i class="fa fa-trash getId" data-type="measurements" data-id="{{base64_encode($ms->id)}}" data-toggle="modal" data-dismiss="modal" data-target="#child-Modal"></i>
                </div>
                @endif
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
.strip-image {
    top: 3px;
    position: absolute;
    width: 24px !important;
    margin-left: 0px !important;
    right: 8px;
}
</style>
