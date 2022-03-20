<?php
$customer = $GLOBALS['database']->get('customer','*',[
	'customer_id'=>$id
]);

$rooms = $GLOBALS['database']->select('room',[
	'[>]room_type'=>'room_type_id',
],[
	'room.room_id (room_id)',
	'room.room_number (room_number)',
	'room.wheelchair_access (wheelchair_access)',
	'room_type.name (room_type)',
],[
	'ORDER'=>[
		'room.room_number'=>'ASC',
	]
]);
echo $GLOBALS['twig']->render('booking/create.twig', ['customer'=>$customer,'rooms'=>$rooms]);
?>
