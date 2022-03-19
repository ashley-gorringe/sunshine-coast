<?php
function randomString($length){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for($i = 0; $i < $length; $i++){
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function randomStringCaps($length){
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for($i = 0; $i < $length; $i++){
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function validateEmail($string){
	if(filter_var($string, FILTER_VALIDATE_EMAIL)){
  		return true;
	}else{
		return false;
	}
}
function validateAlphNum($string){
	if(preg_match('/^[a-z0-9 \-]+$/i', $string)){
  		return true;
	}else{
		return false;
	}
}
function validateAlphabet($string){
	if(preg_match('/^[a-z \-]+$/i', $string)){
  		return true;
	}else{
		return false;
	}
}
function validatePhone($string){
	if(preg_match('/0+(\d){10}/', $string)){
		if(strlen($string) != 11){
			return false;
		}else{
			return true;
		}
	}else{
		return false;
	}
}

function validatePostcode($string){
	if(preg_match('/\b(GIR ?0AA|SAN ?TA1|(?:[A-PR-UWYZ](?:\d{0,2}|[A-HK-Y]\d|[A-HK-Y]\d\d|\d[A-HJKSTUW]|[A-HK-Y]\d[ABEHMNPRV-Y])) ?\d[ABD-HJLNP-UW-Z]{2})\b/i', $string)){
		return true;
	}else{
		return false;
	}
}
?>