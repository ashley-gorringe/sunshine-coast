<?php

$customer = $GLOBALS['database']->get('customer','*',[
	'customer_id'=>$id
]);

$bookings_upc = $GLOBALS['database']->select('booking','*',[
	'AND'=>[
		'customer_id'=>$id,
		'start_date[>]'=>date('Y-m-d'),
	],
	'ORDER'=>[
		'start_date'=>'DESC',
	]
]);
foreach ($bookings_upc as $key => $booking) {
	$bookings_upc[$key]['start_date'] = date('jS M Y', strtotime($booking['start_date']));
	$bookings_upc[$key]['end_date'] = date('jS M Y', strtotime($booking['end_date']));
	$bookings_upc[$key]['total_price'] = $booking['total_price'] / 100;
}

$bookings_pas = $GLOBALS['database']->select('booking','*',[
	'AND'=>[
		'customer_id'=>$id,
		'end_date[<]'=>date('Y-m-d'),
	],
	'ORDER'=>[
		'start_date'=>'DESC',
	]

]);
foreach ($bookings_pas as $key => $booking) {
	$bookings_pas[$key]['start_date'] = date('jS M Y', strtotime($booking['start_date']));
	$bookings_pas[$key]['end_date'] = date('jS M Y', strtotime($booking['end_date']));
	$bookings_pas[$key]['total_price'] = $booking['total_price'] / 100;
}

$bookings_cur = $GLOBALS['database']->select('booking','*',[
	'AND'=>[
		'customer_id'=>$id,
		'start_date[<=]'=>date('Y-m-d'),
		'end_date[>=]'=>date('Y-m-d'),
	],
	'ORDER'=>[
		'start_date'=>'DESC',
	]
]);
foreach ($bookings_cur as $key => $booking) {
	$bookings_cur[$key]['start_date'] = date('jS M Y', strtotime($booking['start_date']));
	$bookings_cur[$key]['end_date'] = date('jS M Y', strtotime($booking['end_date']));
	$bookings_cur[$key]['total_price'] = $booking['total_price'] / 100;
}

echo $GLOBALS['twig']->render('/customer/single.twig', ['customer'=>$customer,'bookings_upc'=>$bookings_upc,'bookings_pas'=>$bookings_pas,'bookings_cur'=>$bookings_cur]);
?>
