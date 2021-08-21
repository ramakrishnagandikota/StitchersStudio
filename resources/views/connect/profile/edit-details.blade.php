<p class="text-right">
    <button onclick="getDetails();"  type="button" class="btn btn-sm waves-effect waves-light">
<i class="icofont icofont-close"></i>
</button></p>
<div class="row">
<div class="col-lg-12">
<div class="general-info form-material">
        <form id="updateDetails">
<div class="row">

<div class="col-lg-6 ">
<div class="material-group">
    <div class="material-addone">
        <i class="icofont icofont-user"></i>
    </div>
    <div class="form-group form-primary">
        <input type="text" id="first_name" name="first_name" class="form-control fill" value="{{Auth::user()->first_name}}">
        <input type="hidden" name="first_name_privacy" id="first_name_privacy" value="only-me">
        <span class="red first_name"></span>
        <span class="form-bar"></span>
        <label class="float-label">First name</label>
    </div>
</div>

<div class="material-group">
    <div class="material-addone">
            <i class="icofont icofont-mobile-phone"></i>
    </div>
    <div class="form-group form-primary">
        <input type="text" id="mobile" name="mobile" class="form-control fill" value="{{Auth::user()->mobile}}">
        <span class="red mobile"></span>
        <input type="hidden" name="mobile_privacy" id="mobile_privacy" value="0">
        <span class="form-bar"></span>
        <label class="float-label">Contact Number</label>
        <span class="privacy" data-toggle="modal" data-id="mobile" data-target="#myModal"><i class="icofont icofont-settings-alt"></i></span>
    </div>
</div>

<div class="material-group">
    <div class="material-addone">
        <i class="icofont icofont-location-pin"></i>
    </div>
    <div class="form-group form-primary">
        <input type="text" name="address" class="form-control fill" value="{{Auth::user()->address}}">
        <input type="hidden" name="address_privacy" id="address_privacy" value="0">
        <span class="form-bar"></span>
        <label class="float-label">Postal address</label>
        <span class="privacy" data-toggle="modal" data-id="address" data-target="#myModal"><i class="icofont icofont-settings-alt"></i></span>
    </div>
</div>
</div>
<!-- end of table col-lg-6 -->
<div class="col-lg-6">

<div class="material-group">
    <div class="material-addone">
        <i class="icofont icofont-user"></i>
    </div>
    <div class="form-group form-primary">
        <input type="text" id="last_name" name="last_name" class="form-control fill" value="{{Auth::user()->last_name}}">
        <span class="red last_name"></span>
        <input type="hidden" name="last_name_privacy" id="last_name_privacy" value="0">
        <span class="form-bar"></span>
        <label class="float-label">Last name</label>
    </div>
</div>

<div class="material-group">
<div class="material-addone">
        <i class="icofont icofont-ui-message" style="color:black"></i>
</div>
<div class="form-group form-primary">
    <input type="email" readonly name="email" class="form-control fill" value="{{Auth::user()->email}}">
    <input type="hidden" name="email_privacy" id="email_privacy" value="0">
    <span class="form-bar"></span>
    <label class="float-label">E-mail</label>
    <span class="privacy" data-toggle="modal" data-id="email" data-target="#myModal"><i class="icofont icofont-settings-alt"></i></span>
</div>
</div>
<div class="material-group">
<div class="material-addone">
        <i class="icofont icofont-globe"></i>
</div>
<div class="form-group form-primary">
    <input type="url" id="ontype-textbox" name="website" class="form-control fill" value="{{Auth::user()->profile->website}}">
    <span class="form-bar"></span>
    <label class="float-label">Website</label>
</div>
</div>


<div class="material-group m-t-30">

</div>
<!-- end of table col-lg-6 -->
</div>
</div>
</form>
<!-- end of row -->
<div class="text-center">
<a href="javascript:;" id="saveDetails" class="btn theme-btn btn-primary waves-effect waves-light m-r-20">Save</a>
<a href="javascript:;" onclick="getDetails()" id="edit-cancel" class="btn btn-default waves-effect">Cancel</a>
</div>
</div>
<!-- end of edit info -->
</div>
<!-- end of col-lg-12 -->

</div>

