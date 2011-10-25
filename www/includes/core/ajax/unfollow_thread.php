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
if($followed_thread->select()) {
	$followed_thread->deleteById($followed_thread->id);
}

$json->response->thread = new StdClass;
$json->response->thread->id = $thread->id;

$json->type = 'success';

c(json_encode($json));