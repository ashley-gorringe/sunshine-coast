<?php
$requiredFields = array('booking_id');
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
if(!is_numeric($_POST['booking_id'])){
	$errorFields[] = array(
		'field_name'=>'booking_id',
		'error_message'=>'Please enter a valid booking number.',
	);
	$submitValid = false;
}

if(!$submitValid){
	$response->status = 'error';
	$response->message = 'There are problems with your submission. Please check the form and try again.';
	$response->errorFields = $errorFields;
	$response->post = $_POST;
	echo json_encode($response);
	exit;
}else{
	$bookingCount = $database->count('booking',[
		'booking_id'=>$_POST['booking_id'],
	]);

	if($bookingCount < 1){
		$response->status = 'success';
		$response->message = 'No bookings could be found with this number.';
		$response->post = $_POST;
		echo json_encode($response);
		exit;
	}else{
		$response->status = 'success';
		$response->successRedirect = '/bookings/'.$_POST['booking_id'];
		$response->post = $_POST;
		echo json_encode($response);
		exit;
	}
}
?>
