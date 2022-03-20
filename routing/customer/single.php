<?php

$customer = $GLOBALS['database']->get('customer','*',[
	'customer_id'=>$id
]);

$bookings = $GLOBALS['database']->select('booking','*',[
	'customer_id'=>$id
]);

foreach ($bookings as $key => $booking) {
	$bookings[$key]['start_date'] = date('jS M Y', strtotime($booking['start_date']));
	$bookings[$key]['end_date'] = date('jS M Y', strtotime($booking['end_date']));
	$bookings[$key]['total_price'] = $booking['total_price'] / 100;
}

echo $GLOBALS['twig']->render('/customer/single.twig', ['customer'=>$customer,'bookings'=>$bookings]);
?>
