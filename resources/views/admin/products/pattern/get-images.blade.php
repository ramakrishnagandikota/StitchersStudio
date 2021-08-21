@if(count($images) > 0)

<table class="table table-bordered" width="100%">

    <tr>
    	<?php $i=0; ?>
    	@foreach($images as $im)
         <td style="background:#ffffff;margin:5px">
            <center>
            <img src="{{$im->image_path}}" width="100" height="100" border=0 >
            </center>

            <span style="font-size:11px">{{Str::limit($im->title,10)}}</span>
            <br>
            <a href="javascript:void(0);" onclick="inserisci(this);" class="insert-image" data-image="{{$im->image_path}}"><span class="glyphicon glyphicon-download"></span></a>
            <br>

         </td>

       <?php if($i==3){$i=0;echo"</tr><tr>";}
        $i++;

    ?>
    @endforeach
    </tr>
    </table>

@else
No Images to show for now
@endif

