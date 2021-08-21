<?php 
 $measurements = App\Models\UserMeasurements::where('id',$project->measurement_profile)->first();
 $stitch_gauge = App\Models\GaugeConversion::where('id',$project->stitch_gauge)->first();
 $row_gauge = App\Models\GaugeConversion::where('id',$project->row_gauge)->first();
 
 if($stitch_gauge && $row_gauge){
	 if($project->uom == 'in' || $project->uom == 'inches'){
		$stitch = ($stitch_gauge->stitch_gauge_inch != 0) ? $stitch_gauge->stitch_gauge_inch : '';
		$row = ($row_gauge->row_gauge_inch != 0) ? $row_gauge->row_gauge_inch : '';
		$uom = 'inch';
		$units = 'Inches';
	}else{
		$stitch = ($stitch_gauge->stitches_10_cm != 0) ? $stitch_gauge->stitches_10_cm : '';
		$row = ($row_gauge->rows_10_cm != 0) ? $row_gauge->rows_10_cm : '';
		$uom = '10 cm';
		$units = 'Centimeters';
	}
 }else{
	 if($project->uom == 'in' || $project->uom == 'inches'){
		$stitch = 0;
		$row = 0;
		$uom = 'inch';
		$units = 'Inches';
	 }else{
		$stitch = 0;
		$row = 0;
		$uom = '10 cm';
		$units = 'Centimeters';
	 }
 }
 
 if($measurements){
	 $m_title = $measurements->m_title;
 }else{
	 $m_title = 'Measurement profile not selected.';
 }

?>
<div class="row m-l-5">
  <div class="col-lg-3 col-sm-3">
  <div class="f-12"><strong>Profile :</strong></div></div>
  <div class="col-lg-8 col-sm-8"><div class="f-12">{{$m_title}}</div></div>
  <div class="col-lg-3 col-sm-3">
  <div class="f-12"><strong>Ease :</strong></div></div>
  <div class="col-lg-8 col-sm-8"><div class="f-12">{{$project->ease}} {{$units}}</div></div>
  <div class="col-lg-3 col-sm-3">
  <div class="f-12"><strong>Stitch gauge :</strong></div></div>
  <div class="col-lg-8 col-sm-8"><div class="f-12">{{$stitch}} sts / {{$uom}}</div></div>
  <div class="col-lg-3 col-sm-3">
  <div class="f-12"><strong>Row gauge :</strong></div></div>
  <div class="col-lg-8 col-sm-8"><div class="f-12">{{$row}} sts / {{$uom}}</div></div>
</div>