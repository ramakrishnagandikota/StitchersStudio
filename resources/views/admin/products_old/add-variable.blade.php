 <form id="insert-variable">
                	<input type="hidden" name="_token" id="token" value="{{csrf_token()}}">
					<input type="hidden" id="formtype" value="1">
  <div class="col-md-12">
   <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 col-xlg-6">
                <div class="form-group">
 				<label>Variable Name</label>
 				<input type="text" name="name" id="name" class="form-control" required placeholder="Please enter variable name" >
 			</div>
			</div>
			
			<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12 col-xlg-6">
                			
                			<div class="form-group">
 				<label>Variable Type</label>
 				<select class="form-control" name="identifier" id="identifier">
 					<option value="">Please select step</option>
 					<option value="1">Input Variables</option>
					<option selected value="2" >Calculated Variables</option>
 				</select>
 				</div>

                		</div>
  </div>	
</div>  
</form>