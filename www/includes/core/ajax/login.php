<?php

validate_included_page();

$tpl = new Template('json');

$json = new JsonResponse;

ajax_session_recheck($json);

if(!isset($_POST['key']))      $json->internalError();
if(!isset($_POST['password'])) $json->internalError();

$key      = prepare_string_for_validation($_POST['key']);
$password = prepare_string_for_validation($_POST['password']);

$key = str_replace(' ', '', $key);

/* Error codes:
   0	Internal error
   1	Success
   101	You must enter your key.
   102	Your key is invalid.
   103	You must enter your password.
   104	Incorrect key and password.
*/

if(empty($key)) {
	$json->addErrorAndForceOutput(101, '', 'You must enter your key.');
}
	
if(!preg_match(_REGEX_CARD_KEY, $key)) {
	$json->addErrorAndForceOutput(102, '', 'Your key is invalid.');
}

if(empty($password)) {
	$json->addErrorAndForceOutput(103, '', 'You must enter your password.');
}


$user = new User;
$user->addWhere(FALSE, 'user_card_key', '=', $key);
$user->addWhere('AND', 'user_password', '=', md5($password));
if($user->select()) {

	$session->addUpdate('user_id', 'user_id', $user->id);
	$session->updateById($session->id);

	$my = $user;

} else {
	$json->addErrorAndForceOutput(104, '', 'Incorrect key and password.');
}
		
$json->type = 'success';

c(json_encode($json));