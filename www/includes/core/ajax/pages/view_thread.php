<?php

$json->response->page_id = 3;

$json->response->page_title     = $thread->subject;
$json->response->document_title = $thread->subject;

$json->response->path = '/' . $topic->slug . '/' . $thread->post_id;
if(isset($args[3])) {

	switch($args[3]) {
		case 'unread':
		
			$json->response->path .= '/unread';
			$json->response->scroll_to_unread = TRUE;
			break;
			
		default:
		
			$post = new Post;
			if($post->selectById($args[3])) {
				$json->response->path .= '/' . $post->id;
				$json->response->focus_post = $post->id;
			}
		
			break;
	
	}

}


$json->response->thread = new StdClass;
$json->response->thread->id = $thread->id;
$json->response->thread->type_id = $thread->type_id;
$json->response->thread->user_id = $thread->user_id;
$json->response->thread->topic_id = $thread->topic_id;
$json->response->thread->post_id = $thread->post_id;
$json->response->thread->subject = $thread->subject;
$json->response->thread->body = nl2br(stripslashes($thread->body));
$json->response->thread->image_url = $thread->image_url;
$json->response->thread->num_posts = $thread->num_posts;
$json->response->thread->num_posts_with_images = $thread->num_posts_with_images;
$json->response->thread->timestamp_created = $thread->timestamp_created;
$json->response->thread->timestamp_updated = $thread->timestamp_updated;

// Does the user follow this thread?
$followed_thread = new FollowedThread;
$followed_thread->addWhere(FALSE, 'thread_id', '=', $thread->id);
$followed_thread->addWhere('AND', 'user_id', '=', $my->id);
if($followed_thread->select()) {
	$json->response->thread->user_follows = TRUE;
	
	$followed_thread_update = new FollowedThreadUpdate;
	$followed_thread_update->addWhere(FALSE, 'followed_thread_id', '=', $followed_thread->id);
	$followed_thread_update->delete();
	
} else {
	$json->response->thread->user_follows = FALSE;
}


$json->response->topic = new StdClass;
$json->response->topic->id = $topic->id;
$json->response->topic->name = $topic->name;
$json->response->topic->slug = $topic->slug;
$json->response->topic->icon_small = $topic->icon_small;
//$json->response->topic->icon_large = $topic->icon_large;
$json->response->topic->num_threads = $topic->num_threads;
$json->response->topic->num_posts = $topic->num_posts;

$json->response->thread->posts = array();

$post_listing = new PostListing;
$post_listing->addWhere(FALSE, 'thread_id', '=', $thread->id);
$post_listing->addWhere('AND', 'post_type_id', '=', 1);
$post_listing->order_by = 'post_timestamp';
$post_listing->order_by_direction = 'ASC';
$post_listing->select(1);

foreach($post_listing->rows as $_post) {

	$post = new StdClass;
	$post->id                      = $_post->id;
	$post->type_id                 = $_post->type_id;
	$post->thread_id               = $_post->thread_id;
	$post->thread_post_id          = $_post->thread_post_id;
	$post->parent_post_id          = $_post->parent_post_id;
	$post->body                    = nl2br($_post->body);
	$post->image_url               = '';
	$post->num_replies             = 0;
	$post->num_replies_with_images = 0;
	$post->timestamp               = $_post->timestamp;

	$json->response->thread->posts[] = $post;

}




$json->type = 'success';
