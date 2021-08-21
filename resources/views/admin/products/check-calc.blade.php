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


$v=0;
foreach ($data as $da) {
	if($da->cal_formula == 'MROUND'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		
		
		$input_filter = filter($da->operator1);
		$result = eval('return '.$input_filter.';');
		$cc = MROUND($result,$da->operator2);
		if(!defined($vn1)){
			define($vn1, $cc);
		}
		
	}else if($da->cal_formula == 'IF'){

		if(!defined('NO_OF_STITCHES_TO_CAST_ON_APPLE')){
			if(EASE == "Shapely"){
				$cc = NO_OF_STITCHES_TO_CAST_ON_NO_EASE_APPLE;
			}else if(EASE == "Standard"){
				$cc = NO_OF_STITCHES_TO_CAST_ON_STANDARD_EASE_APPLE;
			}else{
				$cc = NO_OF_STITCHES_TO_CAST_ON_CASUAL_EASE_APPLE;
			}
			define('NO_OF_STITCHES_TO_CAST_ON_APPLE',$cc);
		}

		if(!defined('NO_OF_STITCHES_TO_CAST_ON_HOURGLASS')){
			if(EASE == "Shapely"){
				$cc = NO_OF_STITCHES_TO_CAST_ON_WITH_NO_EASE;
			}else if(EASE == "Standard"){
				$cc = NO_OF_STITCHES_TO_CAST_ON_WITH_STANDARD_EASE;
			}else{
				$cc = NO_OF_STITCHES_TO_CAST_ON_WITH_CASUAL_EASE;
			}
			define('NO_OF_STITCHES_TO_CAST_ON_HOURGLASS',$cc);
		}
		
		if(!defined('NO_OF_STITCHES_TO_CAST_ON')){
			if(WAIST >= LOWER_EDGE_WIDTH){
				$cc = NO_OF_STITCHES_TO_CAST_ON_APPLE;
			}else{
				$cc = NO_OF_STITCHES_TO_CAST_ON_HOURGLASS;
			}
			define('NO_OF_STITCHES_TO_CAST_ON',$cc);
		}

	}else if($da->cal_formula == 'EVEN'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = evenNumber($result);
		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else if($da->cal_formula == 'ROUNDDOWN'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = ROUNDDOWN($result);
		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else if($da->cal_formula == 'SUM'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = $result;

		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else if($da->cal_formula == 'SQRT'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = sqrt($result);
		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else if($da->cal_formula == 'CEILING'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = CEILING($result);
		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else if($da->cal_formula == 'FLOOR'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$c1 = floor($result);
		$cc = number_format($c1,2);
		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else if($da->cal_formula == 'INT'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = (int)$result;
		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else if($da->cal_formula == 'ODD'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = oddNumber($result);
		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else if($da->cal_formula == 'ROUND'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = round($result);
		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else if($da->cal_formula == 'ROUNDUP'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = ROUNDUP($result);
		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else if($da->cal_formula == 'TRUNC'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = TRUNC($result,$da->operator2);
		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else if($da->cal_formula == 'Others'){
		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' .$input_filter.';');
		$cc = $result;
		if(!defined($vn1)){
			define($vn1, $cc);
		}
	}else{
		$cc = 0;
	}
	

$pattern->content=str_replace($da->variable_name, $cc, $pattern->content);
$v++;
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