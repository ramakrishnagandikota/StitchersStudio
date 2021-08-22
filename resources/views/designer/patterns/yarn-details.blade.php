<form class="form snippets" id="yarn_details{{$did}}" method="POST" action="{{ route("designer.save.snippet.data")}}">
    <div class="form-group row m-b-zero p-10 bordered-box" id="add-function-box">
        <input type="hidden" name="snippet_name" id="snippet_name" value="Snippet{{$dataCount}}" >
		<input type="hidden" name="pattern_template_id" value="{{ $pattern_template_id }}">
        <input type="hidden" name="section_id" value="{{ $section_id }}">
        <div class="col-lg-8 row-bg">
            <h6 class="m-b-5 m-t-5">Snippet {{$dataCount}}</h6>
        </div>
        <div class="col-lg-4 row-bg text-right">
            <a href="javascript:;" class="deleteSnippet fa fa-trash pull-right" data-id="{{$dataCount}}" ></a>
        </div>
        <div class="col-lg-12">
            <div class="row">
                <h5 class="theme-light-row col-md-12">Yarn details</h5>
                <a href="javascript:;" id="add-yarnDetail" data-id="{{$did}}" data-toggle="tooltip" title="Add new yarn url" class="add-yarn-detail add-yarnDetail"><i class="fa fa-plus-circle fa-2x"></i></a>
                <div class="col-md-12" id="functionData{{$did}}">
                    @csrf
                    <input type="hidden" id="is_yarn" name="is_yarn" value="1">
                    <div class="row" id="addYarnData{{$did}}">
                        <div class="col-md-6 allYd m-b-10 m-t-10" id="yd{{$did}}0">
                            <input type="text" class="form-control" name="yarn_title[]" placeholder="Yarn title"><br>
                            <input type="hidden" name="yarn_detail_id[]" value="0">
                            <textarea name="yarn_details[]" class="form-control" required="required" placeholder="Enter yarn url"></textarea>
                            <a href="javascript:;" data-server="false" class="delete-yarn-details" data-id="{{$did}}0"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn theme-btn btn-sm pull-right m-t-10 submityarnDetails" data-id="{{$did}}" >Save</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</form>
