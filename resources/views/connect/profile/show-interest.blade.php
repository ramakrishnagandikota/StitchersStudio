
<h5 class="m-l-30 m-b-20 m-t-10">I knit for </h5>
<div class="m-l-30">
	@if(Auth::user()->profile->i_knit_for)
<ul>
<?php 
$i_knit_for = explode(',', Auth::user()->profile->i_knit_for);
?>
@for($i=0;$i<count($i_knit_for);$i++)
<li style="display: list-item;color: #0d665b;"><i class="fa fa-check m-r-10"></i>{{$i_knit_for[$i]}}</li>
@endfor
</ul>
@else
<p><a href="javascript:;" style="text-decoration:underline;" class="editInterest">Add</a></p>
@endif
</div>
<br>
<h5 class="m-l-30 m-b-20">I am here for </h5>
<div class="m-l-30">
	@if(Auth::user()->profile->i_am_here_for)
<ul>
<?php 
$i_am_here_for = explode(',',Auth::user()->profile->i_am_here_for);
?>
@for($j=0;$j<count($i_am_here_for);$j++)
    <li style="display: list-item;color: #0d665b;"><i class="fa fa-check m-r-10"></i> {{$i_am_here_for[$j]}}</li>
@endfor
</ul>
@else
<p><a href="javascript:;" style="text-decoration:underline;" class="editInterest">Add</a></p>
@endif
</div>

<p class="text-right m-b-0">
	<button id="editInterest" type="button" class="btn btn-sm waves-effect waves-light editInterest">
<i class="fa fa-pencil"></i>
</button></p>