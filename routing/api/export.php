<?php
require_once dirname($_SERVER['DOCUMENT_ROOT']).'/execute.php';
header('Content-Type: application/json');
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$room_type = $GLOBALS['database']->select('room_type','*');
$room = $GLOBALS['database']->select('room','*');
$extra = $GLOBALS['database']->select('extra','*');
$customer = $GLOBALS['database']->select('customer','*');
$booking = $GLOBALS['database']->select('booking','*');
$booking_room = $GLOBALS['database']->select('booking_room','*');
$booking_extra = $GLOBALS['database']->select('booking_extra','*');

$export = array($room_type,$room,$extra,$customer,$booking,$booking_room,$booking_extra);
echo json_encode($export);
?>
