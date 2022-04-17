<?php

$booking = $GLOBALS['database']->get('booking','*',[
	'booking_id'=>$id,
]);
$booking['start_date'] = date('D jS F Y', strtotime($booking['start_date']));
$booking['end_date'] = date('D jS F Y', strtotime($booking['end_date']));

$booking['nights'] = strtotime($booking['end_date']) - strtotime($booking['start_date']);
$booking['nights'] = round($booking['nights'] / (60 * 60 * 24));

$booking['people'] = $GLOBALS['database']->sum('booking_room','people',[
	'booking_id'=>$id
]);

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
	'booking_room.people (room_people)',
	'room_type.per_night_price (room_price) [Int]',
],[
	'booking_room.booking_id'=>$id,
]);

foreach ($rooms as $key => $room) {
	$rooms[$key]['room_price'] = $room['room_price'] / 100;
}

$extras = $GLOBALS['database']->select('booking_extra',[
	'[>]extra'=>'extra_id',
],[
	'booking_extra.booking_extra_id',
	'booking_extra.quantity [Int]',
	'booking_extra.purchase_date',
	'extra.name',
	'extra.price [Int]',
],[
	'booking_extra.booking_id' => $id,
	'ORDER'=>[
		'booking_extra.purchase_date'=>'DESC',
	],
]);

foreach ($extras as $key => $extra) {
	$extras[$key]['line_price'] = $extra['price'] * $extra['quantity'];
	$extras[$key]['line_price'] = $extras[$key]['line_price'] / 100;

	$extras[$key]['price'] = $extra['price'] / 100;

	$extras[$key]['purchase_date'] = date('d/m/Y H:i', strtotime($extra['purchase_date']));
}

if(strtotime($booking['end_date']) > time()){
	$booking['tense'] = 'future';
}else{
	$booking['tense'] = 'past';
}

echo $GLOBALS['twig']->render('/booking/invoice.twig', ['customer'=>$customer,'booking'=>$booking,'rooms'=>$rooms,'extras'=>$extras]);
?>
