<?php
$customers = $GLOBALS['database']->select('customer','*');
echo $GLOBALS['twig']->render('/customer/index.twig', ['customers'=>$customers]);
?>
