<?php

$json->response->page = new StdClass;

$json->response->page->id      = 2;
$json->response->page->title   = $topic->name;
$json->response->page->heading = $topic->name;
$json->response->page->path    = '/' . $topic->slug;

$json->response->breadcrumb = new Breadcrumb;
$json->response->breadcrumb->addItem('Topics', '/topics');
$json->response->breadcrumb->addItem($topic->name, '/' . $topic->slug);

$thread_listing = new ThreadListing;

// Get ALL threads
$thread_listing->addWhere(FALSE, 'topic_id', '=', $topic->id);
$thread_listing->select(0);
$num_total = $thread_listing->num_rows;

// Get this page's threads
$per_page = 10;

$path_bits = explode('/', $path);
$current_page = 1;
if(isset($path_bits[2])) {
	if(preg_match(_REGEX_PAGE_NUMBER, $args[2])) {
		$current_page = preg_replace(_REGEX_PAGE_NUMBER, '$1', $args[2]);
		$json->response->page->path .= '/page' . $current_page;
	}
} 

$thread_listing->addWhere(FALSE, 'topic_id', '=', $topic->id);
$thread_listing->offset = ($current_page - 1) * $per_page;
$thread_listing->limit = $per_page;
$thread_listing->order_by = 'thread_timestamp_updated';
$thread_listing->order_by_direction = 'DESC';
$thread_listing->select(1);

$json->response->pagination = new StdClass;
$json->response->pagination->max_pages = ceil($num_total / $per_page);
$json->response->pagination->current_page = $current_page;

$json->response->topic = new StdClass;
$json->response->topic->id                   = $topic->id;
$json->response->topic->name                 = $topic->name;
$json->response->topic->slug                 = $topic->slug;
$json->response->topic->description          = transform_text($topic->description);
$json->response->topic->icon_small           = $topic->icon_small;
$json->response->topic->icon_large           = $topic->icon_large;
$json->response->topic->num_threads          = $topic->num_threads;
$json->response->topic->num_posts            = $topic->num_posts;
$json->response->topic->num_threads_all_time = $topic->num_threads_all_time;
$json->response->topic->num_posts_all_time   = $topic->num_posts_all_time;
$json->response->topic->num_followers        = $topic->num_followers;


// Does the user follow this topic?
$followed_topic = new FollowedTopic;
$followed_topic->addWhere(FALSE, 'topic_id', '=', $topic->id);
$followed_topic->addWhere('AND', 'user_id', '=', $my->id);
if($followed_topic->select()) {
	$json->response->topic->user_follows = TRUE;
} else {
	$json->response->topic->user_follows = FALSE;
}


foreach($thread_listing->rows as $_thread) {

	$thread = new StdClass;
	$thread->id                    = $_thread->id;
	$thread->type_id               = $_thread->type_id;
	$thread->user_id               = $_thread->user_id;
	$thread->topic_id              = $_thread->topic_id;
	$thread->post_id               = $_thread->post_id;
	$thread->subject               = $_thread->subject;
	$thread->text                  = nl2br(stripslashes($_thread->text));
	$thread->image_url             = $_thread->image_url;
	$thread->num_posts             = $_thread->num_posts;
	$thread->num_posts_with_images = $_thread->num_posts_with_images;
	$thread->timestamp_created     = $_thread->timestamp_created;
	$thread->timestamp_updated     = $_thread->timestamp_updated;

	$followed_thread = new FollowedThread;
	$followed_thread->addWhere(FALSE, 'thread_id', '=', $_thread->id);
	$followed_thread->addWhere('AND', 'user_id', '=', $my->id);
	if($followed_thread->select()) {
		$thread->user_follows = TRUE;
	} else {
		$thread->user_follows = FALSE;
	}

	$thread->posts = array();

	$post_listing = new PostListing;
	$post_listing->addWhere(FALSE, 'thread_id', '=', $_thread->id);
	$post_listing->addWhere('AND', 'post_type_id', '=', 1); // regular post
	$post_listing->limit = 3;
	$post_listing->order_by = 'post_timestamp_created';
	$post_listing->order_by_direction = 'DESC';
	$post_listing->select(1);

	foreach($post_listing->rows as $_post) {

		$post = new StdClass;
		$post->id                      = $_post->id;
//		$post->type_id                 = $_post->type_id;
//		$post->user_id                 = $_post->;
		$post->thread_id               = $_post->thread_id;
		$post->thread_post_id          = $_post->thread_post_id;
		$post->parent_post_id          = $_post->parent_post_id;
		$post->text                    = $_post->text;
		$post->image_url               = $_post->image_url;
//		$post->ip                      = $_post->;
		$post->num_replies             = $_post->num_replies;
		$post->num_replies_with_images = $_post->num_replies_with_images;
		$post->timestamp_created       = $_post->timestamp_created;
		$post->timestamp_updated       = $_post->timestamp_updated;
		
		$thread->posts[] = $post;
		
	}


	// After a bit of calculation
	//$thread->num_posts_omitted = 4;
	//$thread->num_posts_with_images_omitted = 1;
	$thread->num_posts_omitted = 0;
	$thread->num_posts_with_images_omitted = 0;

	$json->response->topic->threads[] = $thread;

}
