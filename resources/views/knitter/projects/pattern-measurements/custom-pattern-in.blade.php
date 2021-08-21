@if($pmeasurements->count() > 0)
                @foreach($pmeasurements as $pm)
                <?php
                $name = strtolower($pm->measurement_name);
                $smallname = Str::slug($name,'_');
                $original_name = str_replace('_', ' ', $pm->measurement_name);
                ?>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="col-form-label"> {{ucfirst($original_name)}}<span class="red">*</span>
                                <span class="mytooltip tooltip-effect-2">
<span class="tooltip-item">?</span>
                                <span class="tooltip-content clearfix">
<img src="{{$pm->measurement_image}}" alt="">
<span class="tooltip-text">{{$pm->measurement_description}}</span>
                                </span>
                                </span>
                            </label>
                            <div class="row">
                                <div class="col-md-12" >
                                    <input type="hidden" class="m_name" name="m_name[]" value="{{$smallname}}">
									<input type='text'
									   placeholder='{{ucfirst($original_name)}}'
									   class='flexdatalist form-control pattern_specific_measurements'
									   data-min-length='1'
									   list='{{$smallname}}'
									   name="{{$smallname}}">
                                    <datalist id="{{$smallname}}">
									<option value="" disabled>Please select a value</option>
                                        @for($i=$pm->min_value_inches;$i<=$pm->max_value_inches;$i+=0.25)
                                        <option value="{{$i}}">{{$i}}</option>
                                        @endfor
                                    </datalist>
                                    <span class="hide red {{$smallname}} markPosition">Please fill this field.</span>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

<style>
.mytooltip{
	z-index: 1 !important;
}
.js-data-example-ajax1{
	border: 0px !important;
}
.flexdatalist-results li{
	width: 100%;
}
</style>
<link href="{{ asset('resources/assets/flexdatalist/jquery.flexdatalist.css') }}" rel="stylesheet" type="text/css">
	<script src="{{ asset('resources/assets/flexdatalist/jquery.flexdatalist.js') }}"></script>