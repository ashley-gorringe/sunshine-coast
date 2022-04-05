<?php
if(empty($_POST['booking_id'])){
	$response->status = 'error';
	$response->message = 'An error has occured.';
	$response->post = $_POST;
	echo json_encode($response);
	exit;
}

$requiredFields = array('purchase_date','item','quantity');
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
	$booking_id = $_POST['booking_id'];
	try{
		$database->insert('booking_extra',[
			'purchase_date'=>$_POST['purchase_date'],
			'quantity'=>$_POST['quantity'],
			'extra_id'=>$_POST['item'],
			'booking_id'=>$booking_id,
		]);

		updateExtrasPrice($booking_id);
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
