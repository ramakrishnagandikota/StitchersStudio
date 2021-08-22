@if($section)
        <div class="row theme-row m-b-10 section{{$section->id}}" id="section{{$section->id}}">
            <div class="card-header accordion col-lg-12 col-sm-12" data-toggle="collapse" data-target="#PTsection4{{ $section->id }}">
                <h5 class="card-header-text username" data-type="text" data-pk="{{ $section->id }}_{{$pattern_template_id}}">{{ $section->section_name }}</h5> <a href="javascript:;" data-sections-id="{{ $section->id }}" data-id="{{ $section->id }}" class="pull-right fa fa-trash deleteSection"></a><i class="fa fa-caret-down pull-right micro-icons"></i> </div>
        </div>

        <div class="card-block collapse section{{ $section->id }}" id="PTsection4{{ $section->id }}">
            <!--Starting snippets Box-->
            <div id="addSnippet{{$section->id}}" class="col-md-12"></div>

            <div class="row">
                <div class="col-lg-12 text-center">
                    <button type="button" class="btn theme-btn m-b-20 btn-sm add-snippet" onclick="addSnippet({{$section->id}})" data-id="{{$section->id}}"><i class="fa fa-plus"></i>Add snippet</button>
                </div>
            </div>

            <!--End snippets Box-->
        </div>
@endif
