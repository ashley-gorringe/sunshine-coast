<?php
if(empty($_POST['booking_id'])){
	$response->status = 'error';
	$response->message = 'An error has occured.';
	$response->post = $_POST;
	echo json_encode($response);
	exit;
}

$requiredFields = array('payment_date');
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
		$database->update('booking',[
			'paid_date'=>$_POST['payment_date'],
			'paid'=>1,
		],[
			'booking_id'=>$booking_id
		]);

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
