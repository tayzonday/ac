<?php

validate_included_page();

if(!isset($_REQUEST['callback'])) {
	$tpl = new Template('json');
} else {
	$tpl = new Template('jsonp');
}

$json = new Json_Response;

if(!isset($_REQUEST['callback']))  $json->internalError();
if(!isset($_REQUEST['username']))  $json->internalError();
if(!isset($_REQUEST['password']))  $json->internalError();

$callback = prepare_string_for_validation($_REQUEST['callback']);
$username = prepare_string_for_validation($_REQUEST['username']);
$password = prepare_string_for_validation($_REQUEST['password']);

$redirect = isset($_REQUEST['redirect']) ? prepare_string_for_validation($_REQUEST['redirect']) : '';
$onsite = isset($_REQUEST['onsite']) ? TRUE : FALSE;

$json->callback = $callback;

/* Error codes:
   0	Internal error
   1	Success
   101	Empty username
   102	Invalid username
   103	Empty password
   104	Invalid password
   105	Invalid username and password
*/

if($onsite === TRUE) {
	if(is_authorized()) {
		$json->addErrorAndForceOutput(100, 'Already Logged In', 'You are already logged in');
	}
}


if(empty($username)) {
	$json->addError(101, 'Empty Username', 'Your username can not be blank.');
} else {
	if(!preg_match(_REGEX_USERNAME, $username)) {
		$json->addErrorAndForceOutput(102, 'Invalid Username', 'Your username is invalid. Usernames must be between ' . _USERNAME_MIN_LENGTH . ' and ' . _USERNAME_MAX_LENGTH . ' alphanumeric characters.');
	}
}

if(empty($password)) {
	$json->addError(103, 'Empty Password', 'Your password can not be blank.');
} else {
	if(!preg_match(_REGEX_PASSWORD, $password)) {
		$json->addErrorAndForceOutput(104, 'Invalid Password', 'Your password is invalid. Passwords must be between ' . _PASSWORD_MIN_LENGTH . ' and ' . _PASSWORD_MAX_LENGTH . ' characters.');
	}
}

if(!$json->hasErrors()) {
	$driver = new Driver;
	$driver->addWhere(FALSE, 'driver_username', '=', $username);
	$driver->addWhere('AND', 'driver_password', '=', md5($password));
	if(!$driver->select()) {
		$json->addErrorAndForceOutput(105, 'Invalid Username and Password', 'Your username and password are incorrect.');
	}
}

if(!$json->hasErrors()) {

	if($onsite === TRUE) {
		$session->addUpdate('driver_id', 'driver_id', $driver->id);
		$session->addWhere(FALSE, 'session_hash', '=', $session->hash);
		$session->update();
	
		$my = $driver;
	}

	$json->type = 'success';
	
	$json->response->redirect = $redirect;
	
}

if(empty($json->callback)) {
	c(json_encode($json));
} else {
	c($json->callback . '(' . json_encode($json) . ');');
}
		
