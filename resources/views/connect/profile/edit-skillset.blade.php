<div class="col-md-12 col-lg-12 row">
<div class="col-lg-9">
<p style="color: #bc7c8f;">Note : Click on the craft and select your skill level</p>
</div>

<div class="col-lg-3">
<p class="text-right">
    <button id="" onclick="getSkillset();" type="button" class="btn btn-sm waves-effect waves-light">
<i class="icofont icofont-close"></i>
</button></p>
</div>

</div>
<form id="UpdateskillSet">

@if($master_list->count() > 0)
        <ul class="checked-edit-list">
@php $i=1; @endphp
    @foreach($master_list as $ml)
        <li><input type="checkbox" data-id="{{$i}}" class="professional_skills"  id="cb{{$i}}" name="professional_skills[]" @foreach(Auth::user()->skills as $skill) @if($skill->skills == $ml->name) checked @endif @endforeach value="{{$ml->name}}" />
            <label for="cb{{$i}}">
                <img src="{{ asset('resources/assets/files/assets/icon/custom/'.$ml->name.'.png') }}" />
                <div class="text-center">{{$ml->name}} </div>
            </label>
            <div class="stars stars-example-fontawesome text-center example-fontawesome{{$i}}" >
                <select id="example-fontawesome" class="cb{{$i}}" name="rating[]" autocomplete="off">
                    <option value="0" selected >0</option>
                    <option value="1" @foreach(Auth::user()->skills as $skill) @if($skill->skills == $ml->name) @if($skill->rating == 1) selected @endif @endif @endforeach >1</option>
                    <option value="2" @foreach(Auth::user()->skills as $skill) @if($skill->skills == $ml->name) @if($skill->rating == 2) selected @endif @endif @endforeach >2</option>
                    <option value="3" @foreach(Auth::user()->skills as $skill) @if($skill->skills == $ml->name) @if($skill->rating == 3) selected @endif @endif @endforeach >3</option>
                    <option value="4" @foreach(Auth::user()->skills as $skill) @if($skill->skills == $ml->name) @if($skill->rating == 4) selected @endif @endif @endforeach >4</option>
                    <option value="5" @foreach(Auth::user()->skills as $skill) @if($skill->skills == $ml->name) @if($skill->rating == 5) selected @endif @endif @endforeach >5</option>
                </select>
            </div>
        </li>
      
@php $i++; @endphp
    @endforeach
        </ul>
<p class="m-l-20"><label>1- Beginner , 2- Advanced beginner, 3- Novice, 4- Proficient, 5-Expert</label></p>
@endif
        <p></p>
        <hr>
        <h5 class="m-l-30 m-b-20">As a knitter I am </h5>
        <div class="form-radio m-l-30">
                <div class="group-add-on">
                    <div class="radio radiofill radio-inline">
                        <label>
                            <input type="radio" name="as_a_knitter_i_am" checked value="Still learning"><i class="helper"></i> Still learning
                        </label>
                    </div>
                    <div class="radio radiofill radio-inline">
                        <label>
                            <input type="radio" name="as_a_knitter_i_am" value="A Designer"><i class="helper"></i> A designer
                        </label>
                    </div>
                    <div class="radio radiofill radio-inline">
                            <label>
                                <input type="radio" name="as_a_knitter_i_am" value="A Teacher"><i class="helper"></i> A teacher
                            </label>
                        </div>
                </div>
            </div>
            <p></p>
            <hr>


             </form>
<!-- end of row --><p></p><p></p>
<div class="text-center">
<a href="javascript:;" id="saveskillSet" class="btn btn-primary waves-effect waves-light theme-btn">Save</a>
<a href="javascript:;" id="edit-cancel1" class="btn btn-default waves-effect" onclick="getSkillset();" >Cancel</a>
</div>
<p></p>

<script type="text/javascript" src="{{ asset('resources/assets/files/bower_components/jquery-bar-rating/js/jquery.barrating.js') }}"></script>
<script type="text/javascript" src="{{ asset('resources/assets/files/assets/js/rating.js') }}"></script>


<style type="text/css">
    .br-widget a:first-child{
        display: none;
    }
</style>