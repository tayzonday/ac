<?php

validate_included_page();

$tpl = new Template('json');

$json = new JsonResponse;

ajax_session_recheck($json);

/* Error codes:
   0	Internal error
   1	Success
*/


$session->unsetCookie();
$session->addWhere(FALSE, 'session_hash', '=', $session->hash);
$session->delete();
$session = new Session;

$my = new User;

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
		
$json->type = 1;

c(json_encode($json));