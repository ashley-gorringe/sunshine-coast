<?php
$customer = $GLOBALS['database']->get('customer','*',[
	'customer_id'=>$id
]);
echo $GLOBALS['twig']->render('booking/create.twig', ['customer'=>$customer]);
?>
