<?php
$requiredFields = array('password');
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
if(!validateAlphNum($_POST['password'])){
	$errorFields[] = array(
		'field_name'=>'password',
		'error_message'=>'Please enter a valid password.',
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
	if($_ENV['SYSTEM_PASSWORD'] === $_POST['password']){
		$_SESSION['logged_in'] = true;
		$response->status = 'success';
		$response->successRedirect = '/';
		$response->post = $_POST;
		echo json_encode($response);
		exit;
	}else{
		$response->status = 'error';
		$response->message = 'The password you entered is incorrect.';
		$errorFields[] = array(
			'field_name'=>'password',
			'error_message'=>'The password you entered is incorrect.',
		);
		$response->errorFields = $errorFields;
		$response->post = $_POST;
		echo json_encode($response);
		exit;
	}
}
?>
