<?php
include app_path().'/helpers.php';

function filter($toFilter) {
    $toFilter = preg_replace('/[; ]+/', '', $toFilter);
    if (preg_match('/[bdefghjklmpqruvwxyzBDEFGHJKLMPQRUVWXYZ]+/', $toFilter)) {
        //echo 'error';                                         
    }
    return $toFilter;   //return the filtered input
}

foreach($measu as $me){
	//echo $me->m_name.' = '.$me->m_value."<br>";
	$vn = strtoupper($me->m_name);
	$vv = '[['.$vn.']]';
	$vn1 = $me->m_value;
	define($vn,$vn1);
	$pattern->content=str_replace($vv, $vn1, $pattern->content);
}

//$dd = filter(STITCH_GAUGE * WAIST);
//echo $dd;
foreach ($data as $da) {
	if($da->cal_formula == 'IF'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}


	$ff = DB::table('measurement_calculation')->where('cal_formula','IF')->get();
	if(count($ff) > 2){
		$i=0;
		foreach ($ff as $key) {
			if($i == 0){
				if($da->operator1){
					$cc = eval('return '.$da->operator2.';');
					@define($vn1,$cc);
				}
			}else if($i == count($ff) - 1){
				$cc = eval('return '.$da->operator2.';');
				@define($vn1,$cc);
			}else{
				if($da->operator1){
					$cc = eval('return '.$da->operator2.';');
					@define($vn1,$cc);
				}
			}
		$i++;
		}
	}

	}

	if($da->cal_formula == 'MROUND'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}
		
		
		$input_filter = filter($da->operator1);
		$result = eval('return '.$input_filter.';');
		$cc = MROUND($result,$da->operator2);
		@define($vn1,$cc);
	}

	if($da->cal_formula == 'EVEN'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = evenNumber($result);
		@define($vn1,$cc);
	}

	if($da->cal_formula == 'ROUNDDOWN'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = ROUNDDOWN($result);
		@define($vn1,$cc);
	}

	if($da->cal_formula == 'SUM'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = $result;
		@define($vn1,$cc);
	}

	if($da->cal_formula == 'SQRT'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = sqrt($result);
		@define($vn1,$cc);
	}

	if($da->cal_formula == 'CEILING'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = CEILING($result);
		@define($vn1,$cc);
	}

	if($da->cal_formula == 'FLOOR'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$c1 = floor($result);
		$cc = number_format($c1,2);
		@define($vn1,$cc);
	}

	if($da->cal_formula == 'INT'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = (int)$result;
		@define($vn1,$cc);
	}

	if($da->cal_formula == 'ODD'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = oddNumber($result);
		@define($vn1,$cc);
	}

	if($da->cal_formula == 'ROUND'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}
		
		
		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = round($result);
		@define($vn1,$cc);
	}

	if($da->cal_formula == 'ROUNDUP'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = ROUNDUP($result);
		@define($vn1,$cc);
	}

	if($da->cal_formula == 'TRUNC'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		if(!defined($vn1)){
			define($vn1, $vn1);
		}

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = TRUNC($result,$da->operator2);
		@define($vn1,$cc);
	}else{
		$cc = 0;
	}
	

$pattern->content=str_replace($da->variable_name, $cc, $pattern->content);
}

?>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
{!! $pattern->content !!}
</body>
</html>