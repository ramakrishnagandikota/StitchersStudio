<?php

if(!function_exists('MROUND')){

		function MROUND($number,$multiple) {
    if ((is_numeric($number)) && (is_numeric($multiple))) {
        if ($multiple == 0) {
            return 0;
        }
        if ((SIGNTest($number)) == (SIGNTest($multiple))) {
            $multiplier = 1 / $multiple;
            return round($number * $multiplier) / $multiplier;
        }
        return 'NAN';
    }
    return 'NAN';
} 

function SIGNTest($number) {
    if (is_bool($number))
        return (int) $number;
    if (is_numeric($number)) {
        if ($number == 0.0) {
            return 0;
        }
        return $number / abs($number);
    }
    return 'NAN';
}
    
}


if(!function_exists('evenNumber')){

function evenNumber($num){
	if($num%2==0)
{
	return (int)$num;
}
else
{
 return (int)$num+1;
} 

}
}

if(!function_exists('oddNumber')){

function oddNumber($num){
	if($num%2==1)
{
	return (int)$num;
}
else
{
 return (int)$num+1;
} 

}
}

if( !function_exists('CEILING') )
{
   function CEILING($number, $significance = 1)
   {
       return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
   }
}


if(!function_exists('ROUNDUP')){
	
	function ROUNDUP($num){
		if(is_float($num)){
			return (int) $num+1;
		}else{
           return $num;
       }
	}
}
if(!function_exists('ROUNDDOWN')){
	
	function ROUNDDOWN($num){
		if(is_float($num)){
			return (int) $num;
		}else{
           return $num;
       }
	}
}

if(! function_exists('TRUNC')){
	
function TRUNC($num,$factor){
      if($factor == 0){
             return (int) $num;
       }else{
            return $num;
}

}

}

if( !function_exists('CEILING') )
{
   function CEILING($number, $significance = 1)
   {
       return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
   }
}

