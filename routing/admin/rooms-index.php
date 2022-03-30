<?php

$rooms = $GLOBALS['database']->select('room',[
	'[>]room_type'=>'room_type_id',
],[
	'room.room_number (room_number)',
	'room_type.name (room_type)',
	'room_type.per_night_price (room_price) [Int]',
],[
	'ORDER'=>[
		'room.room_number'=>'ASC'
	]
]);

$room_types = $GLOBALS['database']->select('room_type','*');

foreach ($rooms as $key => $room) {
	$rooms[$key]['room_price'] = $room['room_price'] / 100;
}

foreach ($room_types as $key => $room_type) {
	$room_types[$key]['per_night_price'] = $room_type['per_night_price'] / 100;
}

echo $GLOBALS['twig']->render('admin/rooms-index.twig', ['rooms'=>$rooms,'room_types'=>$room_types]);
?>
