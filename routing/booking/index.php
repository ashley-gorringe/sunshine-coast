<?php
$bookings = $GLOBALS['database']->select('booking',[
	'[>]customer'=>'customer_id',
],'*');
foreach ($bookings as $key => $booking) {
	$bookings[$key]['start_date'] = date('d/m/Y', strtotime($booking['start_date']));
	$bookings[$key]['end_date'] = date('d/m/Y', strtotime($booking['end_date']));
}


$bookings_upc = $GLOBALS['database']->select('booking',[
	'[>]customer'=>'customer_id',
],'*',[
	'start_date[>]'=>date('Y-m-d'),
	'ORDER'=>[
		'start_date'=>'DESC',
	]
]);
foreach ($bookings_upc as $key => $booking) {
	$bookings_upc[$key]['start_date'] = date('d/m/Y', strtotime($booking['start_date']));
	$bookings_upc[$key]['end_date'] = date('d/m/Y', strtotime($booking['end_date']));
}

$bookings_cur = $GLOBALS['database']->select('booking',[
	'[>]customer'=>'customer_id',
],'*',[
	'AND'=>[
		'start_date[<=]'=>date('Y-m-d'),
		'end_date[>=]'=>date('Y-m-d'),
	],
	'ORDER'=>[
		'start_date'=>'DESC',
	]
]);
foreach ($bookings_cur as $key => $booking) {
	$bookings_cur[$key]['start_date'] = date('d/m/Y', strtotime($booking['start_date']));
	$bookings_cur[$key]['end_date'] = date('d/m/Y', strtotime($booking['end_date']));
}

$bookings_pas = $GLOBALS['database']->select('booking',[
	'[>]customer'=>'customer_id',
],'*',[
	'end_date[<]'=>date('Y-m-d'),
	'ORDER'=>[
		'start_date'=>'DESC',
	]
]);
foreach ($bookings_pas as $key => $booking) {
	$bookings_pas[$key]['start_date'] = date('d/m/Y', strtotime($booking['start_date']));
	$bookings_pas[$key]['end_date'] = date('d/m/Y', strtotime($booking['end_date']));
}

echo $GLOBALS['twig']->render('/booking/index.twig', ['bookings_upc'=>$bookings_upc,'bookings_pas'=>$bookings_pas,'bookings_cur'=>$bookings_cur]);
?>
