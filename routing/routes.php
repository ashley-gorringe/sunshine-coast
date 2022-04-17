<?php
use Steampixel\Route;
Route::add('/login', function() {
	echo $GLOBALS['twig']->render('login.twig');
});

Route::add('/', function() {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/index.php';
});

Route::add('/admin-rooms', function() {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/admin/rooms-index.php';
});

Route::add('/monthly-income', function() {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/admin/monthly-income.php';
});

Route::add('/create-customer', function() {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/customer/create.php';
});

Route::add('/customers', function() {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/customer/index.php';
});

Route::add('/customers/([0-9a-zA-Z]*)', function($id) {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/customer/single.php';
});

Route::add('/customers/([0-9a-zA-Z]*)/create-booking', function($id) {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/booking/create.php';
});

Route::add('/bookings', function() {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/booking/index.php';
});

Route::add('/bookings/([0-9a-zA-Z]*)', function($id) {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/booking/single.php';
});

Route::add('/bookings/([0-9a-zA-Z]*)/add-extra', function($id) {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/booking/add-extra.php';
});

Route::add('/bookings/([0-9a-zA-Z]*)/pay', function($id) {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/booking/pay.php';
});

Route::add('/bookings/([0-9a-zA-Z]*)/invoice', function($id) {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/booking/invoice.php';
});

Route::add('/export.json', function() {
	checkAuth();
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/api/export.php';
});

Route::add('/rooms.json', function() {
	require_once dirname($_SERVER['DOCUMENT_ROOT']).'/routing/api/rooms.php';
});

Route::pathNotFound(function() {
  header('HTTP/1.0 404 Not Found');
  echo $GLOBALS['twig']->render('404.twig');
});

Route::run('/');
?>
