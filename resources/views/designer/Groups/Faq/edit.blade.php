<input type="hidden" name="faq_id" value="{{ $faq->id }}">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="">Enter title</label>
            <input type="text" name="faq_title" id="faq_title" class="form-control" placeholder="Enter title" value="{{ $faq->faq_title }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="">Select category (<small><a href="javascript:;" onclick="openPopup()" style="color: #c14d7d">Show all categories</a></small>)</label>
            <select class="form-control" name="faq_category_id" id="faq_category_id1">
                @foreach($category as $cat)
                    <option value="{{ $cat->id }}" @if($cat->id == $faq->faq_category_id) selected @endif >{{ $cat->category_name }}</option>
                @endforeach
            </select>
            <small><a href="javascript:;" onclick="openPopup()"  style="color: #c14d7d">Click here</a> to add new category</small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <label>Enter description</label>
        <textarea class="form-control summernote" id="faq_description1" name="faq_description">{!! $faq->faq_description !!}</textarea>
    </div>
</div>


<script>
    $(function (){
        $('#faq_category_id1').select2({
            ajax: {
                url: '{{ url("designer/groups/".$faq->group_id."/faq/categories") }}',
                dataType: 'json'
            }
        });
    });
</script>
