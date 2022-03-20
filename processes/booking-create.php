<?php
if(empty($_POST['customer_id'])){
	$response->status = 'error';
	$response->message = 'An error has occured.';
	$response->post = $_POST;
	echo json_encode($response);
	exit;
}

$requiredFields = array('start_date','end_date','rooms[]');
$submitValid = true;
foreach ($_POST as $key => $value) {
	if(in_array($key,$requiredFields)){
		if(empty($value)){
			$errorFields[] = array(
				'field_name'=>$key,
				'error_message'=>'This is required.',
			);
			$submitValid = false;
		}
	}
}

if(!$submitValid){
	$response->status = 'error';
	$response->message = 'There are problems with your submission. Please check the form and try again.';
	$response->errorFields = $errorFields;
	$response->post = $_POST;
	echo json_encode($response);
	exit;
}else{
	try{
		$database->insert('booking',[
			'customer_id'=>$_POST['customer_id'],
			'start_date'=>$_POST['start_date'],
			'end_date'=>$_POST['end_date'],
		]);
		$booking_id = $database->id();

		foreach ($_POST['rooms'] as $key => $room) {
			$database->insert('booking_room',[
				'booking_id'=>$booking_id,
				'room_id'=>$room,
			]);
		}

		updateRoomsPrice($booking_id);
		updateTotalPrice($booking_id);

		$response->status = 'success';
		$response->successRedirect = '/bookings/'.$booking_id;
		echo json_encode($response);
		exit;
	}catch(Exception $e){
		$response->status = 'error';
		$response->message = 'An error occured.';
		echo json_encode($response);
		exit;
	}
}
?>
