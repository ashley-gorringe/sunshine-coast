<?php
require_once dirname($_SERVER['DOCUMENT_ROOT']).'/execute.php';
header('Content-Type: application/json');
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
$rooms = $GLOBALS['database']->select('room',[
	'[>]room_type'=>'room_type_id',
],[
	'room.room_id (room_id)',
	'room.room_number (room_number)',
	'room.wheelchair_access (wheelchair_access)',
	'room_type.name (room_type)',
],[
	'ORDER'=>[
		'room.room_number'=>'ASC',
	]
]);
echo json_encode($rooms);
?>
