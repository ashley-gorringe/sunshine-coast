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

$extras = $GLOBALS['database']->select('extra','*');
foreach ($extras as $key => $extra) {
	$extras[$key]['price'] = $extra['price'] / 100;
}

echo $GLOBALS['twig']->render('/booking/add-extra.twig', ['customer'=>$customer,'booking'=>$booking,'extras'=>$extras]);
?>
