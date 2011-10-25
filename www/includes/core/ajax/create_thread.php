<?php

validate_included_page();

$tpl = new Template('json');

$json = new JsonResponse;

ajax_session_recheck($json);

if(!isset($_POST['topic-id']))          $json->internalError();
if(!isset($_POST['text']))              $json->internalError();
if(!isset($_POST['go-to-thread']))      $json->internalError();
if(!isset($_POST['add-to-my-threads'])) $json->internalError();

$topic_id          = prepare_string_for_validation($_POST['topic-id']);
$text              = prepare_string_for_validation($_POST['text']);
$go_to_thread      = prepare_string_for_validation($_POST['go-to-thread']);
$add_to_my_threads = prepare_string_for_validation($_POST['add-to-my-threads']);

/* Error codes:
   0	Internal error
   1	Success
   101	Empty Topic
   102	Invalid Topic
   103	Empty Text
   104	Text Too Long
   105	Flood Detected (created thread in same topic too fast)
   106	Flood Detected (created thread in any topic too fast)
   107	Flood Detected (identical thread exists in topic)
   // Image validation
   //
   //
   //
   
   
   
*/

/* If topic is empty */
if(empty($topic_id)) $json->addErrorAndForceOutput(101, 'Empty Topic', 'No topic provided.');

/* Check if topic exists */
$topic = new Topic;
if(!$topic->selectById($topic_id)) $json->addErrorAndForceOutput(102, 'Invalid Topic', 'This topic no longer exists.');

/* If AddToMyThreads is an unrecognised value (anything except 0 or 1) */
if((!is_numeric($add_to_my_threads)) || (!in_array($add_to_my_threads, array(0, 1)))) {
	$add_to_my_threads = 1;
}

if(empty($text)) $json->addErrorAndForceOutput(103, 'Empty Text', 'Your Text can not be empty.');

if(strlen($text) > _THREAD_TEXT_MAX_LENGTH) $json->addErrorAndForceOutput(104, 'Text Too Long', 'Your Text is too long. Keep it under ' . _THREAD_TEXT_MAX_LENGTH . ' characters.');

/* Image validation
	Upload
	Resize
	Store
	etc
*/

$thread = new Thread;

if($thread->floodDetectedInTopic($my->id, $topic->id)) $json->addErrorAndForceOutput(105, 'Flood Detected', 'Please wait ' . (($thread->timestamp_created + _CREATE_THREAD_SAME_TOPIC_FLOOD_DETECTION_SECS) - time()) . ' seconds before creating a new thread in this topic.');

if($thread->floodDetectedInAnyTopic($my->id)) $json->addErrorAndForceOutput(169, 'Flood Detected', 'Please wait ' . (($thread->timestamp_created + _CREATE_THREAD_ANY_TOPIC_FLOOD_DETECTION_SECS) - time()) . ' seconds before creating a new thread.');

if($thread->duplicateDetectedInTopic($topic->id, $text)) $json->addErrorAndForceOutput(107, 'Flood Detected', 'An <a href="/' . $topic->slug . '/' . $thread->id . '">identical thread</a> already exists in this topic.');

$post = new Post;
$post->addInsert('post_id', 0);
$post->addInsert('post_type_id', 2);
$post->addInsert('user_id', $my->id);
$post->addInsert('thread_id', 0);
$post->addInsert('thread_post_id', 0);
$post->addInsert('parent_post_id', 0);
$post->addInsert('post_text', '');
$post->addInsert('post_image_url', '');
$post->addInsert('post_ip', $_SERVER['REMOTE_ADDR']);
$post->addInsert('post_num_replies', 0);
$post->addInsert('post_num_replies_with_images', 0);
$post->addInsert('post_timestamp_created', time());
$post->addInsert('post_timestamp_updated', time());
$post->insert();

$thread->addInsert('thread_id', 0);
$thread->addInsert('thread_type_id', 1);
$thread->addInsert('user_id', $my->id);
$thread->addInsert('topic_id', $topic_id);
$thread->addInsert('post_id', $post->id);
$thread->addInsert('thread_subject', '');
$thread->addInsert('thread_text', $text);
$thread->addInsert('thread_image_url', '');
$thread->addInsert('thread_ip', $_SERVER['REMOTE_ADDR']);
$thread->addInsert('thread_num_posts', 0);
$thread->addInsert('thread_num_posts_with_images', 0);
$thread->addInsert('thread_show_in_my_threads', $add_to_my_threads);
$thread->addInsert('thread_timestamp_created', time());
$thread->addInsert('thread_timestamp_updated', time());
$thread->insert();

$post->addUpdate('thread_id', 'thread_id', $thread->id);
$post->addUpdate('thread_post_id', 'thread_post_id', $thread->post_id);
$post->updateById($post->id);












$json->type = 1;

$json->response->thread          = new StdClass;
$json->response->thread->id      = $thread->id;
$json->response->thread->post_id = $thread->post_id;

$json->response->thread->topic       = new StdClass;
$json->response->thread->topic->id   = $topic->id;
$json->response->thread->topic->name = $topic->name;

$json->response->go_to_thread = $go_to_thread;
$json->response->add_to_my_threads = $add_to_my_threads;

die(json_encode($json));
