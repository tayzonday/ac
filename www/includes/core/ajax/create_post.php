<?php

validate_included_page();

$tpl = new Template('json');

$json = new JsonResponse;

ajax_session_recheck($json);

if(!isset($_POST['thread_id'])) $json->internalError();
if(!isset($_POST['parent_post_id'])) $json->internalError();
if(!isset($_POST['body']))           $json->internalError();

$thread_id      = prepare_string_for_validation($_POST['thread_id']);
$parent_post_id = prepare_string_for_validation($_POST['parent_post_id']);
$body           = prepare_string_for_validation($_POST['body']);

/* Error codes:
   0	Internal error
   1	Success
   101
*/

$json->response->context_id = ($parent_post_id == 0) ? 1 : 2;
// Context_ids 
// 1 = Normal post
// 2 = Quoting a post

$thread = new Thread;
if(!$thread->selectById($thread_id)) {
	$json->addErrorAndForceOutput(101, 'Invalid Thread', 'This thread may no longer exist');
}

$topic = new Topic;
if(!$topic->selectById($thread->topic_id)) {
	$json->addErrorAndForceOutput(102, 'Invalid Topic', 'This topic may no longer exist');
}

$post = new Post;
// flood detect - see if a user has already posted in this thread in the last 10 seconds
//$post->addWhere(FALSE, 'session_id', '=', $session->id);
//$post->addWhere('AND', 'thread_id', '=', $thread->id);
//$post->addWhere('AND', 'post_timestamp', '>', time() - 10);
//if($post->select()) {
//	$json->addErrorAndForceOutput(102, 'Flood Detected', 'You are posting too fast. Please wait ' . $post->timestamp - (time() - 10) . ' seconds');
//}


// floor detect- see if a user has already posted the same TEXT in the last 5 minutes
$post->addWhere(FALSE, 'session_id', '=', $session->id);
$post->addWhere('AND', 'thread_id', '=', $thread->id);
$post->addWhere('AND', 'post_body', '=', $body);
$post->addWhere('AND', 'post_timestamp', '>', time() - 300);
if($post->select()) {
	$json->addErrorAndForceOutput(103, 'Flood Detected', 'You have already said this');
}

$post->addInsert('post_id', 0);
$post->addInsert('post_type_id', 1);
$post->addInsert('user_id', 0);
$post->addInsert('session_id', $session->id);
$post->addInsert('thread_id', $thread->id);
$post->addInsert('thread_post_id', $thread->post_id);
$post->addInsert('parent_post_id', $parent_post_id);
$post->addInsert('post_body', $body);
$post->addInsert('post_image_url', '');
$post->addInsert('post_ip', $_SERVER['REMOTE_ADDR']);
$post->addInsert('post_num_replies', 0);
$post->addInsert('post_num_replies_with_images', 0);
$post->addInsert('post_timestamp', time());
$post->insert();

$thread->addUpdate('thread_timestamp_updated', 'timestamp_updated', time());
$thread->updateById($thread->id);

$json->type = 'success';

$json->response->post = new StdClass;
$json->response->post->id = $post->id;
$json->response->post->type_id = $post->type_id;
$json->response->post->thread_id = $post->thread_id;
$json->response->post->thread_post_id = $post->thread_post_id;
$json->response->post->parent_post_id = $post->parent_post_id;
$json->response->post->body = nl2br(stripslashes($post->body));
$json->response->post->image_url = '';
$json->response->post->num_replies = 0;
$json->response->post->num_replies_with_images = 0;
$json->response->post->timestamp = $post->timestamp;

$json->response->topic = new StdClass;
$json->response->topic->id = $topic->id;
$json->response->topic->name = $topic->name;
$json->response->topic->slug = $topic->slug;
$json->response->topic->num_threads = $topic->num_threads;
$json->response->topic->num_posts = $topic->num_posts;


// foreach user who follows this thread, insert a row in followed_thread_updates
$followed_thread_listing = new FollowedThreadListing;
$followed_thread_listing->addWhere(FALSE, 'thread_id', '=', $thread->id);
$followed_thread_listing->addWhere('AND', 'session_id', '!=', $session->id);
$followed_thread_listing->select(1);

foreach($followed_thread_listing->rows as $followed_thread) {

	$followed_thread_update = new FollowedThreadUpdate;
	$followed_thread_update->addInsert('followed_thread_update_id', 0);
	$followed_thread_update->addInsert('followed_thread_id', $followed_thread->id);
	$followed_thread_update->addInsert('followed_thread_update_timestamp', time());
	$followed_thread_update->insert();
	
}





c(json_encode($json));