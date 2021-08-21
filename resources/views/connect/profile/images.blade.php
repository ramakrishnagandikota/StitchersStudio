<?php 
$time = App\Models\Timeline::where('id',$time_id)->first();
?>
<div class="gg-container">
<div class="gg-box dark" id="horizontal-{{$time_id}}"></div>
<div class="gg-box dark" id="square-{{$time_id}}">
@foreach($images as $img)
<img data-id="{{$img->timeline_id}}" onclick="openPopup({{$img->timeline_id}})" class="" data-cont='@component('connect.timeline.showimageTimeline',['time' => $time]) @endcomponent' src="{{ $img->image_path }}" onclick="openPopup()">
@endforeach
</div>
</div>

<script type="text/javascript">
  $(function(){
    loadImagePlugin();
    gridGallery({
            selector: "#square-{{$time_id}}",
            layout: "square"
        });
  });
</script>