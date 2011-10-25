<?php

validate_included_page();

$tpl = new Template('json');

$json = new JsonResponse;

ajax_session_recheck($json);

if(!isset($_POST['password']))        $json->internalError();
if(!isset($_POST['verify_password'])) $json->internalError();

$password        = prepare_string_for_validation($_POST['password']);
$verify_password = prepare_string_for_validation($_POST['verify_password']);

/* Error codes:
   0	Internal error
   1	Success
   101	You are already logged in.
   102	You must choose a password.
   103	You must verify your password.
   104	Your password is too short (x characters min)
   105	Your password is too long (x characters max)
   106	Your passwords do not match.

*/

if($my->is_logged_in) {
	$json->addErrorAndForceOutput(101, '', 'You are already logged in.');
}

if(empty($password)) {
	$json->addErrorAndForceOutput(102, '', 'You must choose a password.');
}

if(empty($verify_password)) {
	$json->addErrorAndForceOutput(103, '', 'You must verify your password.');
}

if((strlen($password) < _PASSWORD_MIN_LENGTH) || (strlen($verify_password) < _PASSWORD_MIN_LENGTH)) {
	$json->addErrorAndForceOutput(104, '', 'Your password is too short (' . _PASSWORD_MIN_LENGTH . ' characters min).');
}

if((strlen($password) > _PASSWORD_MAX_LENGTH) || (strlen($verify_password) > _PASSWORD_MAX_LENGTH)) {
	$json->addErrorAndForceOutput(105, '', 'Your password is too long (' . _PASSWORD_MAX_LENGTH . ' characters max).');
}

if($password != $verify_password) {
	$json->addErrorAndForceOutput(106, '', 'Your passwords do not match.');
}


// update user with new password
$my->addUpdate('user_password', 'password', md5($password));
$my->addUpdate('user_timestamp_updated', 'timestamp_updated', time());
$my->updateById($my->id);

// +1 on all followed topics
$followed_topic_listing = new FollowedTopicListing;
$followed_topic_listing->addWhere(FALSE, 'user_id', '=', $my->id);
$followed_topic_listing->order_by = 'followed_topic_id';
$followed_topic_listing->order_by_direction = 'ASC';
$followed_topic_listing->select(1);
		
foreach($followed_topic_listing->rows as $_followed_topic) {

	$topic = new Topic;
	if($topic->selectById($_followed_topic->topic_id)) {
		$topic->addUpdate('topic_num_followers', 'num_followers', $topic->num_followers + 1);
		$topic->updateById($topic->id);
	}

}








$json->type = 'success';

c(json_encode($json));