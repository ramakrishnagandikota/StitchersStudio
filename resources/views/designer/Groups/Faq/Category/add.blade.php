<button class="btn btn-sm theme-btn waves-effect waves-light pull-right m-b-10" id="showCategories">Go Back</button>
<form id="addGroupForm">
    @csrf
    <input type="hidden" name="group_id" value="{{ base64_encode($group->id) }}">
    <div class="form-group">
        <label for="exampleInputEmail1">Category name<span class="error">*</span></label>
        <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Enter category name">
        <span class="error categoryName"></span>
    </div>
    <button type="button" id="saveCategory" class="btn theme-btn waves-effect waves-light pull-right">Add</button>
</form>
