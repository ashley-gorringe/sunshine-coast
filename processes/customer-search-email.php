<?php
$requiredFields = array('email_address');
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
if(!validateEmail($_POST['email_address'])){
	$errorFields[] = array(
		'field_name'=>'email_address',
		'error_message'=>'Please enter a valid email address.',
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
	$emailCount = $database->count('customer',[
		'email_address'=>$_POST['email_address'],
	]);

	if($emailCount < 1){
		$response->status = 'success';
		$response->message = 'No customers could be found with this email address.';
		$response->post = $_POST;
		echo json_encode($response);
		exit;
	}else{
		$customer_id = $database->get('customer','customer_id',[
			'email_address'=>$_POST['email_address'],
		]);
		$response->status = 'success';
		$response->successRedirect = '/customers/'.$customer_id;
		$response->post = $_POST;
		echo json_encode($response);
		exit;
	}
}
?>
