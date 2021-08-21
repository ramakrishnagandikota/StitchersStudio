
<p class="text-right"><button onclick="getInterest();" type="button" class="btn btn-sm waves-effect waves-light">
<i class="icofont icofont-close"></i>
</button></p>

<form id="UpdateInterest">
<h5 class="m-l-30 m-b-20 m-t-10">I knit for </h5>
<div class="m-l-30">
    <?php $i_knit_for = explode(',',Auth::user()->profile->i_knit_for); ?>
    
    <div class="checkbox-color checkbox-default">
            <input id="checkbox21" type="checkbox" name="i_knit_for[]" @for($i=0;$i<count($i_knit_for);$i++) @if($i_knit_for[$i] == 'Myself') checked @endif @endfor value="Myself" >
            <label for="checkbox21">
                Myself
            </label>
        </div>
        <div class="checkbox-color checkbox-default">
            <input id="checkbox22" type="checkbox" name="i_knit_for[]" @for($i=0;$i<count($i_knit_for);$i++) @if($i_knit_for[$i] == 'Charity') checked @endif @endfor value="Charity" >
            <label for="checkbox22">
                Charity
            </label>
        </div>
        <div class="checkbox-color checkbox-default">
            <input id="checkbox23" type="checkbox" name="i_knit_for[]" @for($i=0;$i<count($i_knit_for);$i++) @if($i_knit_for[$i] == 'Family') checked @endif @endfor value="Family" >
            <label for="checkbox23">
                Family
            </label>
        </div>
    
</div>
<br>
<h5 class="m-l-30 m-b-20">I am here for </h5>
<div class="m-l-30">
    <?php 
$i_am_here_for = explode(',', Auth::user()->profile->i_am_here_for);
    ?>
        <div class="checkbox-color checkbox-default">
                <input id="checkbox24" type="checkbox" name="i_am_here_for[]" @for($j=0;$j<count($i_am_here_for);$j++) @if($i_am_here_for[$j] == 'Knitting') checked @endif @endfor value="Knitting" >
                <label for="checkbox24">
                   Knitting 
                </label>
            </div>
            <div class="checkbox-color checkbox-default">
                    <input id="checkbox25" type="checkbox" name="i_am_here_for[]" @for($j=0;$j<count($i_am_here_for);$j++) @if($i_am_here_for[$j] == 'Learning') checked @endif @endfor value="Learning">
                    <label for="checkbox25">
                       Learning 
                    </label>
                </div>
                <div class="checkbox-color checkbox-default">
                        <input id="checkbox26" type="checkbox" name="i_am_here_for[]" @for($j=0;$j<count($i_am_here_for);$j++) @if($i_am_here_for[$j] == 'Casual Friends') checked @endif @endfor value="Casual friends" >
                        <label for="checkbox26">
                                Casual friends 
                        </label>
                    </div>
</div>
</form>
<!-- end of row --><p></p><p></p>
<div class="text-center">
<a href="javascript:;" id="saveInterest" class="btn btn-primary waves-effect waves-light theme-btn">Save</a>
<a href="javascript:;" id="edit-cancel1" class="btn btn-default waves-effect" onclick="getInterest();" >Cancel</a>
</div>
<p></p>