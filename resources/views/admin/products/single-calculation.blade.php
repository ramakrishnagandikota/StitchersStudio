<tr class="@if($da->cal_formula == 'IF') @if($da->id != $da->ifid) hide @endif @endif">
                                <td><input type="checkbox" name="id[]"></td>
                                <td>{{$da->variable_name}}</td>
                                @if($da->cal_formula == 'MROUND')
                                <td>{{$da->cal_formula}}({{$da->operator1}},{{$da->operator2}})</td>
                                @elseif($da->cal_formula == 'IF')
                                <td>{{$da->cal_formula}}{{$da->operator1}} {{$da->operator2}}
<?php 
    $else = DB::table('measurement_calculation')->where('ifid',$da->id)->where('id','!=',$da->id)->get();
    ?>
    @foreach($else as $el)
    @if($el->operator3 == 'ELSEIF')
        {{$el->operator3}} {{$el->operator1}} {{$el->operator2}}
    @else
        {{$el->operator3}} {{$el->operator2}}
    @endif
    @endforeach

                                </td>
                                @else

                                <td>{{$da->cal_formula}}({{$da->operator1}})</td>
                                @endif
                                <td><a href="javascript:;">Edit<a/></td>
                            </tr>