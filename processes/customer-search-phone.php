<?php
$requiredFields = array('phone_number');
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
if(!validatePhone($_POST['phone_number'])){
	$errorFields[] = array(
		'field_name'=>'phone_number',
		'error_message'=>'Please enter a valid phone number starting with 0 and containing no spaces.',
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
	$phoneCount = $database->count('customer',[
		'phone_number'=>$_POST['phone_number'],
	]);

	if($phoneCount < 1){
		$response->status = 'success';
		$response->message = 'No customers could be found with this phone number.';
		$response->post = $_POST;
		echo json_encode($response);
		exit;
	}else{
		$customer_id = $database->get('customer','customer_id',[
			'phone_number'=>$_POST['phone_number'],
		]);
		$response->status = 'success';
		$response->successRedirect = '/customers/'.$customer_id;
		$response->post = $_POST;
		echo json_encode($response);
		exit;
	}
}
?>
