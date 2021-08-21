     <?php foreach($measure as $mq); ?>
           <div class="modal-body">
                <form id="update-measurements">
                	<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
                	<input type="hidden" id="formtype" value="2">
                	<input type="hidden" name="id" id="id" value="{{$mq->id}}">
                	<input type="hidden" name="product_id" id="product_id" value="{{$mq->product_id}}">
                	<div class="row">
                		<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 col-xlg-6">
							
                			<div class="form-group">
 				<label>Variable Name</label>
 				<select class="form-control select2" id="field_name" name="field_name">
 					<option value="">Please select a varibale</option>
 					@if(count($master) > 0)
 						@foreach($master as $mas)
 						<option value="{{$mas->id}}" @if($mas->id == $mq->id) selected @endif >{{$mas->var_name}}</option>
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
 					<option value="{{$s}}" @if($s == $mq->id) selected @endif >{{$s}}</option>
 					@endfor
 				</select>
 				</div>

                		</div>
                	</div>
                	
                </form>
            </div>
            