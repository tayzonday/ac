<?php

validate_included_page();

$tpl = new Template('json');

$json = new JsonResponse;

ajax_session_recheck($json);

if(!isset($_POST['topic-id'])) $json->internalError();

$topic_id = prepare_string_for_validation($_POST['topic-id']);

/* Error codes:
   0	Internal error
   1	Success
   101	Invalid Topic
   
*/

$topic = new Topic;
if(!$topic->selectByField('topic_id', '=', $topic_id)) $json->addErrorAndForceOutput(101, 'Invalid Topic', 'This topic may no longer exist');

$followed_topic = new FollowedTopic;
$followed_topic->addWhere(FALSE, 'topic_id', '=', $topic->id);
$followed_topic->addWhere('AND', 'user_id', '=', $my->id);
if(!$followed_topic->select()) {

	$followed_topic = new FollowedTopic(array(
		'followed_topic_id'                => 0,
		'user_id'                          => $my->id,
		'topic_id'                         => $topic->id,
		'topic_name'                       => $topic->name,
		'topic_slug'                       => $topic->slug,
		'topic_icon_small'                 => $topic->icon_small,
		'followed_topic_timestamp_created' => time(),
	));

	$topic->addUpdate('topic_num_followers', 'num_followers', $topic->num_followers + 1);
	$topic->updateById($topic->id);
	
}

$json->response->topic = new StdClass;
$json->response->topic->id            = $topic->id;
$json->response->topic->name          = $topic->name;
$json->response->topic->slug          = $topic->slug;
$json->response->topic->icon_small    = $topic->icon_small;
$json->response->topic->num_followers = $topic->num_followers;

$json->type = 1;

c(json_encode($json));