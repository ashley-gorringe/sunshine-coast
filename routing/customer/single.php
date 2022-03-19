<?php

$customer = $GLOBALS['database']->get('customer','*',[
	'customer_id'=>$id
]);

echo $GLOBALS['twig']->render('/customer/single.twig', ['customer'=>$customer]);
?>
