           <div class="modal-body">
                <form id="insert-measurements">
                	<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
                	<input type="hidden" id="formtype" value="1">
                	<input type="hidden" name="product_id" id="product_id" value="{{$pid}}">
                	<div class="row">
                		<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 col-xlg-6">
							
            <div class="form-group">
 				<label>Variable Name</label>
 				<select class="form-control select2" id="field_name" name="field_name">
 					<option value="">Please select a varibale</option>
 					@if(count($master) > 0)
 						@foreach($master as $mas)
 						<option value="{{$mas->id}}">{{$mas->var_name}}</option>
 						@endforeach
 					@endif
 				</select>
 			</div>

                		</div>

                		<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 col-xlg-6">
                			
                			<div class="form-group">
 				<label>Step</label>
 				<select class="form-control" name="step" id="step">
 					<option value="">Please select step</option>
 					@for($s=1;$s<=6;$s++)
 					<option value="{{$s}}">{{$s}}</option>
 					@endfor
 				</select>
 				</div>

                		</div>
                	</div>
                	
                </form>
            </div>
            