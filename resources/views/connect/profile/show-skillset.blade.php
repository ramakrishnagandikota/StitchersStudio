
@if(Auth::user()->skills->count() > 0)
<ul class="skills-list">
    @foreach (Auth::user()->skills as $skill)
        <li>
            <img class="checked-img" src="{{ asset('resources/assets/files/assets/icon/custom/'.$skill->skills.'.png') }}" />
            <div class="text-center">{{$skill->skills}} </div>
            @for ($j = 1; $j <= $skill->rating; $j++)
            <i class="fa fa-star" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Beginner"></i>
            @endfor

            @while ($j <= 5)
                <i class="fa fa-star-o" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="" data-original-title="Beginner"></i>
                <?php $j++; ?>
            @endwhile
        </li>
    @endforeach
</ul>
<p class="m-l-20"><label>1- Beginner , 2- Advanced beginner, 3- Novice, 4- Proficient, 5-Expert</label></p>
@else
<p><a href="javascript:;" style="text-decoration:underline;" class="editSkillset">Add skills</a></p>
@endif
            <p></p>
            <hr>
            <h5 class="m-l-30 m-b-20">As a knitter I am </h5>
            <div class="form-radio m-l-30">
                @if(Auth::user()->profile->as_a_knitter_i_am)
                <ul>
                    <li><i class="fa fa-check m-r-10"></i>{{Auth::user()->profile->as_a_knitter_i_am}}</li>
                </ul>
                @else
                <p><a href="javascript:;" style="text-decoration:underline;" class="editSkillset">Add</a></p>
                @endif
                </div>
<div class="col-lg-12 text-right">
<button id="editSkillset" type="button" class="btn btn-sm waves-effect waves-light editSkillset">
<i class="fa fa-pencil"></i>
</button>
</div>
                
<style type="text/css">
    .fa-star{
       color: #0d665c !important
    }
</style>

<script type="text/javascript" src="{{asset('resources/assets/files/bower_components/jquery-bar-rating/js/jquery.barrating.js') }}"></script>
<script type="text/javascript" src="{{asset('resources/assets/rating/stars.min.js')}}"></script>