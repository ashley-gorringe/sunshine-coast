<?php
if(empty($_POST['booking'])){
	$response->status = 'error';
	$response->message = 'An error has occured.';
	$response->post = $_POST;
	echo json_encode($response);
	exit;
}

try{
	$database->delete('booking',[
		'booking_id'=>$_POST['booking'],
	]);

	$response->status = 'success';
	$response->successRedirect = '/';
	echo json_encode($response);
	exit;
}catch(Exception $e){
	$response->status = 'error';
	$response->message = 'An error occured.';
	echo json_encode($response);
	exit;
}
?>
