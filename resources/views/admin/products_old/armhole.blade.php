@extends('layouts.admin')
@section('breadcrum')
<div class="col-md-12 col-12 align-self-center">
    <h3 class="text-themecolor">Patterns</h3>
    <ol class="breadcrumb" style="position: absolute;right: 0;top: 12px;">
        <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Patterns</li>
    </ol>
</div>
@endsection

@section('section1')
<div class="card col-12">
    <div class="card-body">
<button class="btn-sm btn-primary pull-right" id="addnew">Add New </button>
<br><br><br>
@if(Session::has('message')) 
   <p class="{{Session::get('alert')}}">{{Session::get('message')}}</p> 
@endif

                                  <div class="col-md-12" id="armshaping" style="display:none;" >
                  <div class="row">
                  
  <form action="{{ secure_url('admin/upload-armhole-shaping') }}" method="post">
  
  <input type="hidden" name="subcatid" value="{{$subcatid}}">
      <input type="hidden" name="pid" value="{{$pid}}">
      {{csrf_field()}}
  
  <div class="col-md-7 col-md-offset-4">
    <div class="form-group">
      <label for="email">select stitch gauge & row gauge:</label>
       <select name="armhole_swatch_guage_id" id="armhole_swatch_guage_id" class="form-control col-md-10" required >
     <option value="0" > Please select stitch gauge & row gauge</option>
      @foreach($data as $daw)
     <option value="{{$daw->id}}" @if(old('armhole_swatch_guage_id')) selected @endif > Stitch Gauge : {{$daw->stitch_gauge}} , Row Gauge : {{$daw->row_gauge}} </option>
     @endforeach
     </select>
    </div>
    
</div>

<div class="clearfix"></div>
<br>
<p style="font-weight:bold;" class="text-center">OR</p>

<div class="row">

 <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">Size:</label>
      <input type="number" class="form-control" name="size" required placeholder="size" value="{{old('size')}}" >
    </div>
    </div>
    
      <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">Stitch gauge:</label>
      <input type="text" class="form-control" name="stitch_gauge" required id="stitch_gauge" placeholder="Stitch gauge" value="{{old('stitch_gauge')}}">
    </div>
    </div>
    
      <div class="col-md-4">
    <div class="form-group">
      <label for="row_gauge">Row gauge:</label>
      <input type="text" class="form-control" name="row_gauge" required id="row_gauge" placeholder="Row gauge" value="{{old('row_gauge')}}">
    </div>
</div>
<div class="clearfix"></div>


      <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">#_of_stitches_for_first_decrease_at_armhole:</label>
      <input type="number" class="form-control" name="no_of_stitches_for_first_decrease_at_armhole" placeholder="#_of_stitches_for_first_decrease_at_armhole" value="{{old('no_of_stitches_for_first_decrease_at_armhole')}}">
    </div>
    </div>
    
    <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">#_of_stitches_for_second_decrease_at_armhole:</label>
      <input type="number" class="form-control" name="no_of_stitches_for_second_decrease_at_armhole" placeholder="#_of_stitches_for_second_decrease_at_armhole" value="{{old('no_of_stitches_for_second_decrease_at_armhole')}}">
    </div>
    </div>
    
    <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">#_of_stitches_for_third_decrease_at_armhole:</label>
      <input type="number" class="form-control" name="no_of_stitches_for_third_decrease_at_armhole" placeholder="#_of_stitches_for_third_decrease_at_armhole" value="{{old('no_of_stitches_for_third_decrease_at_armhole')}}">
    </div>
    </div>
    
    
    <div class="clearfix"></div>


      <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">#_of_stitches_for_4th_decrease_at_armhole:</label>
      <input type="number" class="form-control" name="no_of_stitches_for_4th_decrease_at_armhole" placeholder="#_of_stitches_for_4th_decrease_at_armhole" value="{{old('no_of_stitches_for_4th_decrease_at_armhole')}}">
    </div>
    </div>
    
    <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">#_of_times_to_decrease_1_stitch_at_each_end:</label>
      <input type="number" class="form-control" name="no_of_times_to_decrease_1_stitch_at_each_end" placeholder="#_of_times_to_decrease_1_stitch_at_each_end" value="{{old('no_of_times_to_decrease_1_stitch_at_each_end')}}">
    </div>
    </div>
    
    <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">#_of_rows_to_knit_straight:</label>
      <input type="number" class="form-control" name="no_of_rows_to_knit_straight" placeholder="#_of_rows_to_knit_straight" value="{{old('no_of_rows_to_knit_straight')}}">
    </div>
    </div>



    <div class="clearfix"></div>


      <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">Dec_1_stitch_every_other_row_x_times:</label>
      <input type="number" class="form-control" name="dec_1_stitch_every_other_row_x_times" placeholder="Dec_1_stitch_every_other_row_x_times" value="{{old('dec_1_stitch_every_other_row_x_times')}}">
    </div>
    </div>
    
    <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">Bo_2_stitches_beg_next_x_rows:</label>
      <input type="number" class="form-control" name="bo_2_stitches_beg_next_x_rows" placeholder="Bo_2_stitches_beg_next_x_rows" value="{{old('bo_2_stitches_beg_next_x_rows')}}">
    </div>
    </div>
    
    <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">Bo_4_stitches_beg_next_x_rows:</label>
      <input type="number" class="form-control" name="bo_4_stitches_beg_next_x_rows" placeholder="Bo_4_stitches_beg_next_x_rows" value="{{old('bo_4_stitches_beg_next_x_rows')}}">
    </div>
    </div>


    <div class="clearfix"></div>


      <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">Bo_remaining_1:</label>
      <input type="number" class="form-control" name="bo_remaining_1" placeholder="Bo_remaining_1" value="{{old('bo_remaining_1')}}">
    </div>
    </div>
    
    <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">Bo_remaining_2:</label> 
      <input type="number" class="form-control" name="bo_remaining_2" placeholder="Bo_remaining_2" value="{{old('bo_remaining_2')}}">
    </div>
    </div>
    
    <div class="col-md-4">
    <div class="form-group">
      <label for="stitch_gauge">Bo_remaining_3:</label>
      <input type="number" class="form-control" name="bo_remaining_3" placeholder="Bo_remaining_3" value="{{old('bo_remaining_3')}}">
    </div>
    </div>

</div>
<div class="clearfix"></div>

 <br>
 <br>           
 
    <button type="submit" class="btn btn-info pull-right">Upload values</button>
  </form>
  
  <br>
 <br>    
 <br>    
  </div>

  </div>  


 <div class="clearfix"></div>
         
                  
                
                  
                 @if(count($data) > 0)
<div class="table-responsive">
                 
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
    <?php $i=1; ?>
     @foreach($data as $da)
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$i}}">Stitch Gauge : {{$da->stitch_gauge}} , Row Gauge : {{$da->row_gauge}}</a>
        </h4>
      </div>
       <?php $ahs  = DB::table('armhole_shaping')->where('armhole_swatch_guage_id',$da->id)->orderBy('size','asc')->get(); ?>
      <div id="collapse{{$i}}" class="panel-collapse collapse">
        <div class="panel-body">
        <table class="table table-bordered">
            <tr><th>size</th><th>#_of_stitches_for_first_decrease_at_armhole</th><th>#_of_stitches_for_second_decrease_at_armhole</th><th>#_of_stitches_for_third_decrease_at_armhole</th><th>#_of_stitches_for_4th_decrease_at_armhole</th><th>#_of_times_to_decrease_1_stitch_at_each_end</th><th>#_of_rows_to_knit_straight</th><th>dec_1_stitch_every_other_row_x_times</th><th>bo_2_stitches_beg_next_x_rows</th><th>bo_4_stitches_beg_next_x_rows</th><th>bo_remaining_1</th><th>bo_remaining_2</th><th>bo_remaining_3</th></tr>
            
            @foreach($ahs as $ah)
            <tr><td>{{$ah->size}}</td><td>{{$ah->no_of_stitches_for_first_decrease_at_armhole}}</td><td>{{$ah->no_of_stitches_for_second_decrease_at_armhole}}</td><td>{{$ah->no_of_stitches_for_third_decrease_at_armhole}}</td><td>{{$ah->no_of_stitches_for_4th_decrease_at_armhole}}</td><td>{{$ah->no_of_times_to_decrease_1_stitch_at_each_end}}</td><td>{{$ah->no_of_rows_to_knit_straight}}</td><td>{{$ah->dec_1_stitch_every_other_row_x_times}}</td><td>{{$ah->bo_2_stitches_beg_next_x_rows}}</td><td>{{$ah->bo_4_stitches_beg_next_x_rows}}</td><td>{{$ah->bo_remaining_1}}</td><td>{{$ah->bo_remaining_2}}</td><td>{{$ah->bo_remaining_3}}</td></tr>
            @endforeach
                     </table>
        </div>
      </div>
      <?php $i++; ?>
      @endforeach
    </div>


</div> 
                     

</div>
                 
                 @else
                     
                 no data found
                 
                 @endif

    </div>
</div>

@endsection

@section('section2')

@endsection

@section('footerscript')
<style type="text/css">
    h4.panel-title{
        background: #6e9399;
        padding: 10px;
    }
    h4.panel-title a{
        color: #fff;
    }
</style>
<script>
      $(document).ready(function() {
        $(document).on('change','#armhole_swatch_guage_id',function(){
            var valu = $(this).val();
            if(valu != 0){
                $("#stitch_gauge,#row_gauge").attr('readonly',true);
            }else{
                $("#stitch_gauge,#row_gauge").attr('readonly',false);
            }
        });
        
        $(document).on('click','#addnew',function(){
            $("#armshaping").fadeToggle();
        });
      });
   </script>
@endsection