 <form id="update-variable">
 
                	<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
					<input type="hidden" name="id" id="id" value="{{$var->id}}">
					<input type="hidden" id="formtype" value="2">
  <div class="col-md-12">
   <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 col-xlg-6">
                <div class="form-group">
 				<label>Variable Name</label>
 				<input type="text" name="name" id="name" class="form-control" required placeholder="Please enter variable name" value="{{$var->var_name}}" >
 			</div>
			</div>
			
			<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 col-xlg-6">
                			
                			<div class="form-group">
 				<label>Variable Type</label>
 				<select class="form-control" name="identifier" id="identifier">
 					<option value="">Please select step</option>
 					<option value="1" @if($var->identifier == 1) selected  @endif >Input Variables</option>
					<option value="2" @if($var->identifier == 2) selected  @endif >Calculated Variables</option>
 				</select>
 				</div>

                		</div>
  </div>	
</div>  
</form>

