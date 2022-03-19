<?php
//Checks that required form field data has been send to the back-end. If not, end the current process and send back an error message including the missing form fields.

$requiredFields = array('title','first_name','last_name','email_address','phone_number','address_line_1','town_city','post_code');
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
if(!validateAlphabet($_POST['first_name'])){
	$errorFields[] = array(
		'field_name'=>'first_name',
		'error_message'=>'Please enter a valid name.',
	);
	$submitValid = false;
}
if(!validateAlphabet($_POST['last_name'])){
	$errorFields[] = array(
		'field_name'=>'last_name',
		'error_message'=>'Please enter a valid name.',
	);
	$submitValid = false;
}
if(!empty($_POST['business_name'])){
	if(!validateAlphNum($_POST['business_name'])){
		$errorFields[] = array(
			'field_name'=>'business_name',
			'error_message'=>'Please enter a valid business name.',
		);
		$submitValid = false;
	}
}
if(!validateEmail($_POST['email_address'])){
	$errorFields[] = array(
		'field_name'=>'email_address',
		'error_message'=>'Please enter a valid email address.',
	);
	$submitValid = false;
}else{
	$emailCount = $database->count('customer',[
		'email_address'=>$_POST['email_address'],
	]);
	if($emailCount > 0){
		$errorFields[] = array(
			'field_name'=>'email_address',
			'error_message'=>'This email address is already in use.',
		);
		$submitValid = false;
	}
}
if(!validatePhone($_POST['phone_number'])){
	$errorFields[] = array(
		'field_name'=>'phone_number',
		'error_message'=>'Please enter a valid phone number starting with 0 and containing no spaces.',
	);
	$submitValid = false;
}else{
	$phoneCount = $database->count('customer',[
		'phone_number'=>$_POST['phone_number'],
	]);
	if($phoneCount > 0){
		$errorFields[] = array(
			'field_name'=>'phone_number',
			'error_message'=>'This phone number is already in use.',
		);
		$submitValid = false;
	}
}
if(!validateAlphNum($_POST['address_line_1'])){
	$errorFields[] = array(
		'field_name'=>'address_line_1',
		'error_message'=>'Please enter a valid address.',
	);
	$submitValid = false;
}
if(!empty($_POST['address_line_2'])){
	if(!validateAlphNum($_POST['address_line_2'])){
		$errorFields[] = array(
			'field_name'=>'address_line_2',
			'error_message'=>'Please enter a valid address.',
		);
		$submitValid = false;
	}
}
if(!validateAlphNum($_POST['town_city'])){
	$errorFields[] = array(
		'field_name'=>'town_city',
		'error_message'=>'Please enter a valid town or city.',
	);
	$submitValid = false;
}
if(!validatePostcode($_POST['post_code'])){
	$errorFields[] = array(
		'field_name'=>'post_code',
		'error_message'=>'Please enter a valid UK postcode.',
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
	try{
		$database->insert('customer',[
			'title'=>$_POST['title'],
			'first_name'=>$_POST['first_name'],
			'last_name'=>$_POST['last_name'],
			'business_name'=>$_POST['business_name'],
			'email_address'=>$_POST['email_address'],
			'phone_number'=>$_POST['phone_number'],
			'address_line_1'=>$_POST['address_line_1'],
			'address_line_2'=>$_POST['address_line_2'],
			'town_city'=>$_POST['town_city'],
			'post_code'=>$_POST['post_code'],
		]);

		$customer_id = $database->id();

		$response->status = 'success';
		$response->successRedirect = '/customers/'.$customer_id;
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
