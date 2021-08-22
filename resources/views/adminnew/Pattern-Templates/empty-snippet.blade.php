<form class="form snippets" id="sectionForm{{$did}}" method="POST" action="{{ route("save.snippet.data")}}">
    <input type="hidden" name="snippet_name" id="snippet_name" value="Snippet{{$dataCount}}" >
	<input type="hidden" name="pattern_template_id" value="{{ $pattern_template_id }}">
    <div class="form-group row m-b-zero p-10 bordered-box" id="add-function-box">
        <div class="col-lg-8 row-bg">
            <h6 class="m-b-5 m-t-5">Snippet {{$dataCount}}</h6>
        </div>
        <div class="col-lg-4 row-bg text-right"><a href="javascript:;" class="deleteSnippet fa fa-trash pull-right" data-id="new{{$dataCount}}"  ></a> </div>
        <div class="col-lg-12">
            <div class="row">

                <div class="col-md-12" id="functionData{{$did}}">
                    @csrf
                    <input type="hidden" id="section_id" name="section_id" value="{{ $section_id }}">
                    <input type="hidden" name="is_empty" value="1">
                    <textarea class="hint2mention summernoteDescription m-b-10" name="snippet_description"></textarea>

                    <div class="row">
                        <div class="col-lg-12">
                            <button type="button" class="btn theme-btn btn-sm pull-right m-t-10 submitSnippet" data-id="sectionForm{{ $did }}" data-snippet-id="{{ $dataCount }}">Save</button>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</form>
