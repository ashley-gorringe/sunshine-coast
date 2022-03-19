<?php
use Steampixel\Route;
Route::add('/', function() {
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/index.php';
});

Route::add('/create-customer', function() {
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/customer/create.php';
});

Route::add('/customers/([0-9a-zA-Z]*)', function($id) {
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/customer/single.php';
});

Route::add('/customers/([0-9a-zA-Z]*)/create-booking', function($id) {
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/booking/create.php';
});

Route::pathNotFound(function() {
  header('HTTP/1.0 404 Not Found');
  echo $GLOBALS['twig']->render('404.twig');
});

Route::run('/');
?>
