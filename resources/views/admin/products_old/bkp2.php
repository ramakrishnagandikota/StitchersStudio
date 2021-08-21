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

foreach ($data as $da) {

	switch ($da->cal_formula) {
		/* case 0 start*/
		case 'IF':

		$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		


	$ff = DB::table('measurement_calculation')->where('cal_formula','IF')->get();
	if(count($ff) > 2){
		$i=0;
		foreach ($ff as $key) {
			if($i == 0){
				if($da->operator1){
					$cc = eval('return '.$da->operator2.';');
				}
			}else if($i == count($ff) - 1){
				$cc = eval('return '.$da->operator2.';');
			}else{
				if($da->operator1){
					$cc = eval('return '.$da->operator2.';');
				}
			}
		$i++;
		}
	}
	
	if(!defined($vn1)){
		define($vn1, $cc);
	}

		break;

		/* case 0 start*/

		/* case 1 start*/
		case 'MROUND':
			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		
		
		
		$input_filter = filter($da->operator1);
		$result = eval('return '.$input_filter.';');
		$cc = MROUND($result,$da->operator2);
		if(!defined($vn1)){
			define($vn1, $cc);
		}
			break;
			/* case 1 end*/

			/* case 2 start*/
			case 'EVEN':

			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = evenNumber($result);
		if(!defined($vn1)){
			define($vn1, $cc);
		}

			break;
			/* case 2 end */

			/* case 3 start*/
			case 'ROUNDDOWN':

			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = ROUNDDOWN($result);
		if(!defined($vn1)){
			define($vn1, $cc);
		}

			break;
			/* case 3 end */

			/* case 4 start*/
			case 'SUM':

			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = $result;

		if(!defined($vn1)){
			define($vn1, $cc);
		}

			break;
			/* case 4 end */

			/* case 5 start*/
			case 'SQRT':

			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = sqrt($result);
		if(!defined($vn1)){
			define($vn1, $cc);
		}

			break;
			/* case 5 end */

			/* case 6 start*/
			case 'CEILING':

			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = CEILING($result);
		if(!defined($vn1)){
			define($vn1, $cc);
		}

			break;
			/* case 6 end */

			/* case 7 start*/
			case 'FLOOR':

			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		
		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$c1 = floor($result);
		$cc = number_format($c1,2);

		if(!defined($vn1)){
			define($vn1, $cc);
		}

			break;
			/* case 7 end */

			/* case 8 start*/
			case 'INT':

			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = (int)$result;

		if(!defined($vn1)){
			define($vn1, $cc);
		}

			break;
			/* case 8 end */


			/* case 9 start*/
			case 'ODD':

			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
	
		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = oddNumber($result);

		if(!defined($vn1)){
			define($vn1, $cc);
		}

			break;
			/* case 9 end */

			/* case 10 start*/
			case 'ROUND':

			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		
		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = round($result);

		if(!defined($vn1)){
			define($vn1, $cc);
		}

			break;
			/* case 10 end */

			/* case 11 start*/
			case 'ROUNDUP':

			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = ROUNDUP($result);

		if(!defined($vn1)){
			define($vn1, $cc);
		}

			break;
			/* case 11 end */

			/* case 12 start*/
			case 'TRUNC':

			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc = TRUNC($result,$da->operator2);

		if(!defined($vn1)){
			define($vn1, $cc);
		}

			break;
			/* case 12 end */

		
		default:
			$vn = str_replace('[[', '', $da->variable_name);
		$vn1 = str_replace(']]', '', $vn);
		

		$input_filter = filter($da->operator1);
		$result = eval('return ' . $input_filter . ';');
		$cc =$result;
		if(!defined($vn1)){
			define($vn1, $cc);
		}
			break;
	}
$pattern->content=str_replace($da->variable_name, $cc, $pattern->content);
}
echo NO_OF_STITCHES_TO_CAST_ON_WITH_CASUAL_EASE;
?>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
<!-- {!! $pattern->content !!} -->
</body>
</html>