<button class="btn btn-sm theme-btn waves-effect waves-light pull-right m-b-10" id="addCategory">Add Category</button>
@if($groupCategory->count() > 0)
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Category name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($groupCategory as $gc)
            <tr>
                <td class="text-center">
                    <a href="#" class="category_name" data-type="text" data-pk="{{ $gc->id }}" data-url="{{ url('designer/groups/faq/categories/'.$gc->id.'/update') }}" data-title="Enter category name">{{ $gc->category_name }}</a>
                </td>
                <td class="text-center"><a href="javascript:;" data-id="{{ $gc->id }}" class="fa fa-trash deleteCategory"></a></td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
    <div class="clearfix"></div>
    <div class="text-center">
        There are no categories to show for this group. To add click on Add Category.
    </div>
@endif

<link href="{{ asset('resources/assets/connect/assets/plugins/x-editable/dist/bootstrap-editable/css/bootstrap-editable.css') }}" rel="stylesheet"/>
<script src="{{ asset('resources/assets/connect/assets/plugins/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
<script>
    $(function (){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.fn.editable.defaults.mode = 'inline';
        $('.category_name').editable({
            success: function(response, newValue) {
                //if(response.status == 'error') return response.msg;
                if(response.status == 'error'){
                    notification('fa-times','Yeah..',response.message,'danger');
                }
                notification('fa-check','Yeah..','Category updated successfully..','success');
            },
            error: function (response, newValue){
                notification('fa-times','Yeah..',response.message,'danger');
            }
        });
    });
</script>
