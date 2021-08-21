
<div class="card addedaddress" style="width: 18rem;">
  <div class="card-body">
  <div class="checkbox-color checkbox-primary">
	   <input id="checkbox18" class="checkme" type="radio" style="opacity: 1;width: 20px;height:20px;">
   </div>
    <h5 class="card-title">Card title</h5>
    <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
  </div>
</div>

<input type="hidden" name="address_id" value="0">

<button type="button" id="addNew">Add New</button>

<div class="row hide" id="addaddress">
    <div class="card col-md-10 offset-lg-1 p-20">
        <div class="checkout-title  text-center">
            <h3>Add new address</h3></div>
        <div class="row check-out">
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">First name</div>
                <input type="text" name="first_name" value="" placeholder="">
                <span class="red">{{$errors->first('first_name')}}</span>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Last name</div>
                <input type="text" name="last_name" value="{{old('last_name')}}" placeholder="">
                <span class="red">{{$errors->first('last_name')}}</span>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Phone</div>
                <input type="text" name="mobile" value="{{old('mobile')}}" placeholder="">
                <span class="red">{{$errors->first('mobile')}}</span>
            </div>
            <div class="form-group col-md-6 col-sm-6 col-xs-12">
                <div class="field-label">Email address</div>
                <input type="text" name="email" value="{{old('email')}}" placeholder="">
                <span class="red">{{$errors->first('email')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Country</div>
                <select name="country">
                    <option value="">Please select country</option>
                    @foreach($country as $cntry)
                    <option value="{{$cntry->nicename}}">{{$cntry->nicename}}</option>
                    @endforeach
                </select>
                <span class="red">{{$errors->first('country')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Address</div>
                <input type="text" name="address" value="{{old('address')}}" placeholder="Street address">
                <span class="red">{{$errors->first('address')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-12 col-xs-12">
                <div class="field-label">Town/City</div>
                <input type="text" name="city" value="{{old('city')}}" placeholder="">
                <span class="red">{{$errors->first('city')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                <div class="field-label">State / County</div>
                <input type="text" name="state" value="{{old('state')}}" placeholder="">
                <span class="red">{{$errors->first('state')}}</span>
            </div>
            <div class="form-group col-md-12 col-sm-6 col-xs-12">
                <div class="field-label">Postal code</div>
                <input type="text" name="zipcode" value="{{old('zipcode')}}" placeholder="">
                <span class="red">{{$errors->first('zipcode')}}</span>
            </div>
            
        </div>
    </div>
    
</div>