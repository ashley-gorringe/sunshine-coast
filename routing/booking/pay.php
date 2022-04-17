<?php
$booking = $GLOBALS['database']->get('booking','*',[
	'booking_id'=>$id,
]);
$customer = $GLOBALS['database']->get('customer','*',[
	'customer_id'=>$booking['customer_id'],
]);
echo $GLOBALS['twig']->render('/booking/pay.twig', ['booking'=>$booking,'customer'=>$customer]);
?>
