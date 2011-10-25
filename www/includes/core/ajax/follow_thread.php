<?php

validate_included_page();

$tpl = new Template('json');

$json = new JsonResponse;

ajax_session_recheck($json);

if(!isset($_POST['thread_id'])) $json->internalError();

$thread_id = prepare_string_for_validation($_POST['thread_id']);

/* Error codes:
   0	Internal error
   1	Success
   101
*/

$thread = new Thread;
if(!$thread->selectByField('thread_id', '=', $thread_id)) $json->addError(101, 'Invalid Thread', 'This thread may no longer exist');

$topic = new Topic;
if(!$topic->selectById($thread->topic_id)) $json->addError(102, 'Invalid Topic', 'This thread may no longer exist');

$followed_thread = new FollowedThread;
$followed_thread->addWhere(FALSE, 'thread_id', '=', $thread->id);
$followed_thread->addWhere('AND', 'user_id', '=', $my->id);
if(!$followed_thread->select()) {

	$followed_thread = new FollowedThread(array(
		'followed_thread_id'             => 0,
		'user_id'                        => 0,
		'thread_id'                      => $thread->id,
		'followed_thread_topic_name'     => $topic->name,
		'followed_thread_topic_slug'     => $topic->slug,
		'followed_thread_thread_post_id' => $thread->post_id,
		'followed_thread_thread_subject' => $thread->subject,
		'followed_thread_timestamp'      => time(),
	));

}

$json->response->thread = new StdClass;
$json->response->thread->id = $thread->id;
$json->response->thread->post_id = $thread->post_id;
$json->response->thread->subject = $thread->subject;

$json->response->topic = new StdClass;
$json->response->topic->name = $topic->name;
$json->response->topic->slug = $topic->slug;
//topic icon, later

$json->type = 'success';

c(json_encode($json));