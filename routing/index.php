<?php

$test = 'Test';

echo $GLOBALS['twig']->render('index.twig', ['test'=>$test]);
?>
