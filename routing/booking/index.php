<?php
$bookings = $GLOBALS['database']->select('booking',[
	'[>]customer'=>'customer_id',
],'*');
foreach ($bookings as $key => $booking) {
	$bookings[$key]['start_date'] = date('d/m/Y', strtotime($booking['start_date']));
	$bookings[$key]['end_date'] = date('d/m/Y', strtotime($booking['end_date']));
}
echo $GLOBALS['twig']->render('/booking/index.twig', ['bookings'=>$bookings]);
?>
