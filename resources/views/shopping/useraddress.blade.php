<section class="regular slider" id="slickSlider">
@if($address)
<?php $i=0; ?>
@foreach($address as $add)
<!-- col-sm-4 col-md-4 col-xs-12 col-lg-4 -->
<div class="" style="width: 100% !important;">
    <div class="box">
        <div class="box-title">
            <h3 class="p-l-10">
<div class="form-radio radio radio-inline" id="radio">
    <label>
        <input type="radio" required @if($add->is_default == 1) checked id="local-pickup"  @endif name="user_address" class="user_address" data-id="{{$i}}"  value="{{$add->id}}">
        <i class="helper"></i>
    </label>
</div>

            <span style="position: relative;top: -9px;right: -25px;"> {{ucwords($add->first_name)}} {{ucwords($add->last_name)}}</span> </h3><a href="{{url('edit-address/'.base64_encode($add->id))}}">Edit</a></div>
        <div class="box-content">
            <h6>{{$add->address}}</h6>
            <h6>{{$add->city}},{{$add->state}},{{$add->country}} {{$add->zipcode}},</h6>
            <h6 style="color: #0d665c;font-weight: bold;">{{ ($add->is_default == 1) ? 'Default' : ''  }}</h6></div>
    </div>
</div>
<?php $i++; ?>
@endforeach
@else
<div style="margin: auto;">No address found. </div>
@endif
</section>

<style type="text/css">
	#radio .helper::after, #radio .helper::before{
		top: -8px !important;
	}
    .slider {
        width: 100% !important;
    }

    @media only screen
and (min-device-width : 375px)
and (max-device-width : 667px) {
    .slider {
        width: 100% !important;
    }
}

    .slick-slide {
      margin: 0px 20px;
    }
.slick-prev, .slick-next{
        background: #0d665c !important;
    border-radius: 13px !important;
}
    .slick-prev:before,
    .slick-next:before {
      color: black;
    }


    .slick-slide {
      transition: all ease-in-out .3s;
      opacity: .2;
    }

    .slick-active {
      opacity: 1;
    }

    .slick-current {
      opacity: 1;
    }
</style>
<script type="text/javascript">
//if (window.matchMedia("(max-width: 768px)").matches){
// if (window.matchMedia("(max-width: 768px)").matches) all kind of mobile screens
/*
$(window).resize(function() {
   var width = $(window).width();

    if (width >= 320 && width <= 425) {
        alert('mobile')
        $("#slickSlider").removeClass('regular');
        $("#slickSlider").addClass('regular');
        $(".regular").slick({
        dots: false,
        infinite: false,
        slidesToShow: 1,
        slidesToScroll: 1
    });

    }else if(width > 425 && width <= 768){
        $("#slickSlider").removeClass('regular');
        alert('tablet');
        $("#slickSlider").addClass('regular');
        $(".regular").slick({
        dots: false,
        infinite: false,
        slidesToShow: 2,
        slidesToScroll: 2
    });

    }else{
        $("#slickSlider").removeClass('regular');
        alert('web')
        $("#slickSlider").addClass('regular');
            $(".regular").slick({
        dots: false,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3
        });


    }
});
*/


if (window.matchMedia("(max-width: 768px)").matches){
    $(".regular").slick({
        dots: false,
        infinite: false,
        slidesToShow: 1,
        slidesToScroll: 1
    });
}else{
    $(".regular").slick({
        dots: false,
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 3
        });
}
</script>
