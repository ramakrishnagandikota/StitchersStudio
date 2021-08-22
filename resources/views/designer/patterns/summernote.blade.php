
<?php $variables = '"TITLE","UOM",'; ?>
@foreach($measurements as $meas)
    <?php
    $variable_name = strtoupper($meas->variable_name);
    $var_name = str_replace(' ','_',$variable_name);
    $variables.= '"'.$var_name.'",';
    ?>
@endforeach
<?php $v=0;?>
@foreach($outputVariables as $ov)
    @php
        if($v == $outputVariables->count() - 1){
            $variables.= '"'.$ov->variable_name.'",';
        }else{
            $variables.= '"'.$ov->variable_name.'",';
        }

    @endphp
    <?php $v++; ?>
@endforeach
<?php
$variables.='';
?>
<script>
    $("#editor{{$condId}}{{$k}}{{$dataCount}}{{$l}}").summernote({
        hint: {
            mentions: [<?php echo $variables; ?>],
            match: /\B@(\w*)$/,
            search: function (keyword, callback) {
                callback($.grep(this.mentions, function (item) {
                    return item.indexOf(keyword) == 0;
                }));
            },
            content: function (item) {
                return '[[' + item + ']]';
            }
        }
    });


    $("#editor{{$condId}}{{$k}}{{$dataCount}}{{$l}}").on('summernote.blur', function(we, contents, $editable) {
        var condid = $(this).attr('data-condid');
        var k = $(this).attr('data-k');
        var sid = $(this).attr('data-sid');
        var l = $(this).attr('data-l');
        var value = $(this).val();
        var len = $(".snippet"+sid).length;

        if((len > 1) && (k == 1)) {

            $(".conditional_statements_id" + sid).each(function (i) {
                var val = $(this).val();
                k = parseInt(i) + 1;
                var checked = $("#sameCond1" + val + '' + k + '' + sid).prop('checked');
                if ((checked == true) && (i > 0)) {
                    var summernote1 = $("#editor" + val + '' + k + '' + sid + '' + l);
                    summernote1.summernote('code','');
                    summernote1.summernote('code', value);
                }
            });

        }

    });


    $("#editor{{$condId}}{{$k}}{{$dataCount}}{{$l}}").on('summernote.focus', function() {
        var condid = $(this).attr('data-condid');
        var k = $(this).attr('data-k');
        var sid = $(this).attr('data-sid');
        var l = $(this).attr('data-l');
        var value = $(this).val();

        var summernote1 = $("#editor" + condid + '' + k + '' + sid + '' + l);

        if(summernote1.summernote('isEmpty')){
            summernote1.summernote('code','');
        }
    });
</script>
