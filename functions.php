<?php
function checkAuth(){
	if($_SESSION['logged_in']){
		return true;
	}else{
		header('Location: /login');
	}
}

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
function validateBasicText($string){
	if(preg_match('/([a-z0-9 \-\'])\w+/i', $string)){
  		return true;
	}else{
		return false;
	}
}
function validatePhone($string){
	if(preg_match('/^0+(\d){10}$/', $string)){
		return true;
	}else{
		return false;
	}
}
function validatePostcode($string){
	if(preg_match('/^\b(GIR ?0AA|SAN ?TA1|(?:[A-PR-UWYZ](?:\d{0,2}|[A-HK-Y]\d|[A-HK-Y]\d\d|\d[A-HJKSTUW]|[A-HK-Y]\d[ABEHMNPRV-Y])) ?\d[ABD-HJLNP-UW-Z]{2})\b$/i', $string)){
		return true;
	}else{
		return false;
	}
}

function updateRoomsPrice($booking_id){
	$dates = $GLOBALS['database']->get('booking',[
		'start_date',
		'end_date',
	],[
		'booking_id'=>$booking_id
	]);

	$rooms = $GLOBALS['database']->select('booking_room',[
		'room_id',
	],[
		'booking_id'=>$booking_id
	]);

	$rooms_price = 0;

	foreach ($rooms as $key => $room) {
		$room_price = $GLOBALS['database']->get('room',[
			'[>]room_type'=>'room_type_id',
		],[
			'room_type.per_night_price [Int]',
		],[
			'room.room_id'=>$room,
		]);

		$rooms_price = $rooms_price + $room_price['per_night_price'];
	}

	$start_date = strtotime($dates['start_date']);
	$end_date = strtotime($dates['end_date']);
	$datediff = $end_date - $start_date;
	$days = round($datediff / (60 * 60 * 24));

	$days_price = $rooms_price * $days;

	$GLOBALS['database']->update('booking',[
		'rooms_price'=>$days_price,
	],[
		'booking_id'=>$booking_id,
	]);
}

function updateExtrasPrice($booking_id){
	$booking_extras = $GLOBALS['database']->select('booking_extra',[
		'[>]extra'=>'extra_id',
	],[
		'booking_extra.booking_extra_id',
		'booking_extra.quantity [Int]',
		'extra.price [Int]',
	],[
		'booking_extra.booking_id' => $booking_id,
	]);

	$extras_price = 0;

	foreach ($booking_extras as $key => $extra) {
		$line_total = $extra['price'] * $extra['quantity'];
		$extras_price = $extras_price + $line_total;
	}

	$GLOBALS['database']->update('booking',[
		'extras_price'=>$extras_price,
	],[
		'booking_id'=>$booking_id,
	]);
}

function updateTotalPrice($booking_id){
	$booking = $GLOBALS['database']->get('booking',[
		'extras_price [Int]',
		'rooms_price [Int]',
	],[
		'booking_id'=>$booking_id,
	]);

	$total_price = $booking['extras_price'] + $booking['rooms_price'];

	$GLOBALS['database']->update('booking',[
		'total_price'=>$total_price,
	],[
		'booking_id'=>$booking_id,
	]);
}
?>
