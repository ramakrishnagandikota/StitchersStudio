<form class="form snippets" id="sectionForm{{$did}}" method="POST" action="{{ route("save.snippet.data")}}">
    <input type="hidden" name="snippet_name" id="snippet_name" value="Snippet{{$dataCount}}" >
    <div class="form-group row m-b-zero p-10 bordered-box" id="add-function-box">
        <div class="col-lg-8 row-bg">
            <h6 class="m-b-5 m-t-5">Snippet {{$dataCount}}</h6>
        </div>
        <div class="col-lg-4 row-bg text-right"><a href="javascript:;" class="deleteSnippet fa fa-trash pull-right" data-id="{{$dataCount}}" ></a> </div>
        <div class="col-lg-12">
            <div class="row">
                <h5 class="theme-light-row col-md-12">Concatinate snippet</h5>
                <div class="col-md-12" id="functionData{{$did}}">
                    @csrf
                    <input type="hidden" id="section_id" name="section_id" value="{{ $section_id }}">
                    <input type="hidden" id="is_concatinate" name="is_concatinate" value="1">
                   <!-- <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Input variable</label>
                            @if($measurements->count() > 0)
                                <select class="form-control" name="input_variable">
                                    <option value="0">Title</option>
                                    @foreach($measurements as $meas)
                                        <option value="{{ $meas->id }}">{{ $meas->variable_name }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                    </div> -->

                    <div class="row m-t-20" id="cond-row">
                        <div class="col-lg-12">
                            <input type="hidden" name="cond_stmt_id[]" value="48">
                            <ul class="list-unstyled m-b-10" style="margin-left: 10px;" id="cond_instruction">
                                @php
                                    $inst = '[[PART-1]][[INPUT_VARIABLE]][[PART-2]]';
$array = array('[[PART-1]]','[[PART-2]]');
$array1 = array('<span class="text-danger">[[PART-1]]</span>','<span class="text-danger">[[PART-2]]</span>');
                                    $res = str_replace($array,$array1,$inst);
                                @endphp
                               <!-- <li class="desc"><b>Instruction :- </b>{!! $res !!}</li> -->
                            </ul>
                            @for($l=1;$l<=1;$l++)
                                <!-- <h5 class="m-t-10 text-danger">PART-{{ $l }}</h5> -->
                                <h5 class="m-t-10 text-danger">Instruction</h5>
                                <input type="hidden" name="conditional_statements_id[]" value="48">
                                <textarea class="hint2mention summernoteDescription m-b-10" name="description[]"></textarea>
                                <span class="summernote-required text-danger"></span>
                                @endfor

                            </ul>
                        </div>
                    </div>

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
