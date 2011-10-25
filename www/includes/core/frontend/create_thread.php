<?php

validate_included_page();

$tpl = new Template('iframe_blank');

//pprint_r($_POST);

if(!isset($_POST['subject']))  js_error(array('code' => 0.1, 'title' => 'Internal Error', 'message' => 'There was an internal error.'));
if(!isset($_POST['text']))     js_error(array('code' => 0.2, 'title' => 'Internal Error', 'message' => 'There was an internal error.'));
if(!isset($_POST['topic-id'])) js_error(array('code' => 0.3, 'title' => 'Internal Error', 'message' => 'There was an internal error.'));
//if(!isset($_POST['image'])) js_error(); IMAGE

$subject  = prepare_string_for_validation($_POST['subject']);
$text     = prepare_string_for_validation($_POST['text']);
$topic_id = prepare_string_for_validation($_POST['topic-id']);

$goto_after_create = (isset($_POST['goto-after-create']) && (!empty($_POST['goto-after-create']))) ? TRUE : FALSE;

/* Error codes:
   0	Internal error
   1	Success
   101	Empty Topic
   102	Invalid Topic (because it is not numeric)
   103	Invalid Topic ($topic->select() failed)
   104	Empty Subject
   105	Subject Too Long
   106	Empty Text
   107	Text Too Long
   108	Flood Detected (created thread in same topic too fast)
   109	Flood Detected (created thread in any topic too fast)
   110	Flood Detected (identical thread exists in topic)
*/

// If topic is empty
if(empty($topic_id)) js_error(array('code' => 101, 'title' => 'Empty Topic', 'message' => 'No topic provided.'));

// If topic is not numeric
//if(!is_numeric($topic_id)) js_error(array('code' => 102, 'title' => 'Invalid Topic', 'message' => 'This topic is invalid.'));

// Check if topic exists
$topic = new Topic;
if(!$topic->selectById($topic_id)) js_error(array('code' => 103, 'title' => 'Invalid Topic', 'message' => 'This topic no longer exists.'));

//if(empty($subject)) js_error(array('code' => 104, 'title' => 'Empty Subject', 'message' => 'Your Subject can not be empty.'));

//if(strlen($subject) > _THREAD_SUBJECT_MAX_LENGTH) js_error(array('code' => 105, 'title' => 'Subject Too Long', 'message' => 'Your Subject is too long. Keep it under ' . _THREAD_SUBJECT_MAX_LENGTH . ' characters.'));

if(empty($text)) js_error(array('code' => 106, 'title' => 'Empty Text', 'message' => 'Your Text can not be empty.'));

if(strlen($text) > _THREAD_TEXT_MAX_LENGTH) js_error(array('code' => 107, 'title' => 'Text Too Long', 'message' => 'Your Text is too long. Keep it under ' . _THREAD_TEXT_MAX_LENGTH . ' characters.'));


// image validation
//
//
//


// Check if user made a thread in the past 5 minutes in this topic
$thread = new Thread;/*
if($thread->floodDetectedInTopic($my->id, $topic->id)) js_error(array('code' => 108, 'title' => 'Flood Detected', 'message' => 'Please wait ' . (($thread->timestamp_created + _CREATE_THREAD_SAME_TOPIC_FLOOD_DETECTION_SECS) - time()) . ' seconds before creating a new thread in this topic.'));

if($thread->floodDetectedInAnyTopic($my->id)) js_error(array('code' => 109, 'title' => 'Flood Detected', 'message' => 'Please wait ' . (($thread->timestamp_created + _CREATE_THREAD_ANY_TOPIC_FLOOD_DETECTION_SECS) - time()) . ' seconds before creating a new thread.'));

if($thread->duplicateDetectedInTopic($topic->id, $subject, $text)) js_error(array('code' => 110, 'title' => 'Flood Detected', 'message' => 'An <a href="/' . $topic->slug . '/' . $thread->id . '">identical thread</a> already exists in this topic.'));
*/

$post = new Post;
$post->addInsert('post_id', 0);
$post->addInsert('post_type_id', 2);
$post->addInsert('user_id', $my->id);
$post->addInsert('session_id', $session->id);
$post->addInsert('thread_id', 0);
$post->addInsert('thread_post_id', 0);
$post->addInsert('parent_post_id', 0);
$post->addInsert('post_body', '');
$post->addInsert('post_image_url', '');
$post->addInsert('post_ip', $_SERVER['REMOTE_ADDR']);
$post->addInsert('post_num_replies', 0);
$post->addInsert('post_num_replies_with_images', 0);
$post->addInsert('post_timestamp', time());
$post->insert();

$thread->addInsert('thread_id', 0);
$thread->addInsert('thread_type_id', 1);
$thread->addInsert('user_id', $my->id);
$thread->addInsert('session_id', $session->id);
$thread->addInsert('topic_id', $topic_id);
$thread->addInsert('post_id', $post->id);
$thread->addInsert('thread_subject', $subject);
$thread->addInsert('thread_text', $text);
$thread->addInsert('thread_image_url', '');
$thread->addInsert('thread_ip', $_SERVER['REMOTE_ADDR']);
$thread->addInsert('thread_num_posts', 0);
$thread->addInsert('thread_num_posts_with_images', 0);
$thread->addInsert('thread_timestamp_created', time());
$thread->addInsert('thread_timestamp_updated', time());
$thread->insert();

$post->addUpdate('thread_id', 'thread_id', $thread->id);
$post->addUpdate('thread_post_id', 'thread_post_id', $thread->post_id);
$post->updateById($post->id);

$json = new StdClass;
$json->thread = new StdClass;
$json->thread->id                    = $thread->id;
$json->thread->type_id               = $thread->type_id;
$json->thread->user_id               = $thread->user_id;
$json->thread->topic_id              = $thread->topic_id;
$json->thread->post_id               = $thread->post_id;
$json->thread->subject               = $thread->subject;
$json->thread->text                  = nl2br($thread->text);
$json->thread->image_url             = $thread->image_url;
$json->thread->num_posts             = $thread->num_posts;
$json->thread->num_posts_with_images = $thread->num_posts_with_images;
$json->thread->timestamp_created     = $thread->timestamp_created;
$json->thread->timestamp_updated     = $thread->timestamp_updated;
// extra members
$json->thread->goto_after_create = $goto_after_create;

c("parent.page.createThreadSuccess(" . json_encode($json) . ");");





// 

function js_error($data) {
	global $tpl;
	c("parent.page.createThreadModal.form.showError(" . json_encode($data) . ");");
	$tpl->output();
}
