<?php

define('_INCLUDED', TRUE);

include_once _PATH_INCLUDES . 'functions.php';

date_default_timezone_set('Europe/London');

if(!_CAN_ACCESS_PROTECTED_SITE_BY_IP) die('<img src="/assets/wrong-ip.gif" />');

if(!_SITE_IS_LIVE) {
	if(in_array(_DOMAIN, unserialize(_PROTECTED_BASIC_AUTH_DOMAINS))) {
		if((isset($_SERVER['PHP_AUTH_USER'])) && (!empty($_SERVER['PHP_AUTH_USER']))) {
			if(($_SERVER['PHP_AUTH_USER'] != _PROTECTED_BASIC_AUTH_USERNAME) && ($_SERVER['PHP_AUTH_PW'] != _PROTECTED_BASIC_AUTH_PASSWORD)) {
				die('Denied');
			}
		} else {
			header('WWW-Authenticate: Basic realm="' . _PROTECTED_BASIC_AUTH_REALM . '"');
			header('HTTP/1.0 401 Unauthorized');
			die('Denied');
		}
	}
}

$db = new Database(_DB_HOST, _DB_USER, _DB_PASS, _DB_NAME);
$db->connect();
$db->selectDatabase();

/*
$mc = new Memcache;
foreach(unserialize(_MEMCACHED_SERVER_POOL) as $server) {
	$mc->addServer($server, 11211);
}
*/

include_interface('iSqlRow');
include_interface('iSqlListing');

$core = new Core;
$core->getAlias();

$my = new User;

$session = new Session;

define('_CAN_ACCESS_PROTECTED_SITE_BY_SESSION', (in_array($session->hash, unserialize(_ALLOWED_SESSIONS))) ? TRUE : FALSE);

$session->addWhere(FALSE, 'session_hash', '=', $session->hash);
$session->query_debug = 'Checking if session hash exists in the sessions table';
if(!$session->select()) {
	$session->unsetCookie();
	unset($session);
	$session = new Session;
}

$my_verified = FALSE;

while($my_verified === FALSE) {

	$my->addWhere(FALSE, 'user_id', '=', $session->user_id);
	$my->query_debug = 'Checking if $session->user_id exists in the users table';

	if(!$my->select()) {
	
		$session->unsetCookie();
		$session->addWhere(FALSE, 'session_hash', '=', $session->hash);
		$session->delete();
		$session = new Session;

		$my->generateUniqueCardKey();
	
		$my = new User(array(
			'user_id'                 => 0,
			'user_card_key'           => $my->card_key,
			'user_password'           => '',
			'user_latest_ip'          => $_SERVER['REMOTE_ADDR'],
			'user_registrar_ip'       => $_SERVER['REMOTE_ADDR'],
			'user_num_thread_replies' => 0,
			'user_num_post_mentions'  => 0,
			'user_timestamp_created'  => time(),
			'user_timestamp_updated'  => time(),
		));

		$session->addUpdate('user_id', 'user_id', $my->id);
		$session->updateById($session->id);
		
		// Insert default followed topics
		$default_followed_topic_listing = new DefaultFollowedTopicListing;
		$default_followed_topic_listing->order_by = 'default_followed_topic_order';
		$default_followed_topic_listing->order_by_direction = 'ASC';
		$default_followed_topic_listing->select(1);
		
		foreach($default_followed_topic_listing->rows as $_default_followed_topic) {
			$followed_topic = new FollowedTopic(array(
				'followed_topic_id'                => 0,
				'user_id'                          => $my->id,
				'topic_id'                         => $_default_followed_topic->topic_id,
				'topic_name'                       => $_default_followed_topic->topic_name,
				'topic_slug'                       => $_default_followed_topic->topic_slug,
				'topic_icon_small'                 => $_default_followed_topic->topic_icon_small,
				'followed_topic_timestamp_created' => time(),
			));
		}
		
		$my_verified = TRUE;
		
		define('_SESSION_CREATED', TRUE);

	} else {
	
		// check if IP has changed...
		// if it has, update latest_ip
	
		$my_verified = TRUE;
	
	}

}

include_once _PATH_CORE . $core->target_folder . $core->target . '.php';

if(isset($tpl)) {
	$tpl->output();
}

