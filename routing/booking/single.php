<?php

$booking = $GLOBALS['database']->get('booking','*',[
	'booking_id'=>$id,
]);
$booking['start_date'] = date('D jS F Y', strtotime($booking['start_date']));
$booking['end_date'] = date('D jS F Y', strtotime($booking['end_date']));

$booking['rooms_price'] = $booking['rooms_price'] / 100;
$booking['extras_price'] = $booking['extras_price'] / 100;
$booking['total_price'] = $booking['total_price'] / 100;

$customer = $GLOBALS['database']->get('customer','*',[
	'customer_id'=>$booking['customer_id'],
]);

$rooms = $GLOBALS['database']->select('booking_room',[
	'[>]room'=>'room_id',
	'[>]room_type'=>'room_type_id',
],[
	'room.room_number (room_number)',
	'room_type.name (room_type)',
	'room_type.per_night_price (room_price) [Int]',
],[
	'booking_room.booking_id'=>$id,
]);

foreach ($rooms as $key => $room) {
	$rooms[$key]['room_price'] = $room['room_price'] / 100;
}

echo $GLOBALS['twig']->render('/booking/single.twig', ['customer'=>$customer,'booking'=>$booking,'rooms'=>$rooms]);
?>
