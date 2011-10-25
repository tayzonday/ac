<?php

$json->response->page = new StdClass;

$json->response->page->id      = 5;
$json->response->page->title   = 'Topics';
$json->response->page->heading = 'Topics';
$json->response->page->path    = '/topics';

$topic_listing = new TopicListing;

// Get ALL topics
$topic_listing->addWhere(FALSE, 'topic_type_id', '=', '1'); // Actual topics
$topic_listing->select(0);
$num_total = $topic_listing->num_rows;

// Get this page's topics
$per_page = 10;

/*$path_bits = explode('/', $path);
$current_page = 1;
if(isset($path_bits[2])) {
	if(preg_match(_REGEX_PAGE_NUMBER, $args[2])) {
		$current_page = preg_replace(_REGEX_PAGE_NUMBER, '$1', $args[2]);
		$json->response->path .= '/page' . $current_page;
	}
}*/

$topic_listing->addWhere(FALSE, 'topic_type_id', '=', '1');
$topic_listing->offset = 0;
$topic_listing->limit = 10;
$topic_listing->order_by = 'topic_num_followers';
$topic_listing->order_by_direction = 'DESC';
$topic_listing->select(1);

$json->response->topics = array();

foreach($topic_listing->rows as $_topic) {

	$topic = new StdClass;
	$topic->id                    = $_topic->id;
	$topic->name                  = $_topic->name;
	$topic->slug                  = $_topic->slug;
	$topic->description           = $_topic->description;
	$topic->icon_small            = $_topic->icon_small;
	$topic->icon_large            = $_topic->icon_large;
	$topic->num_threads           = $_topic->num_threads;
	$topic->num_posts             = $_topic->num_posts;
	$topic->num_threads_all_time  = $_topic->num_threads_all_time;
	$topic->num_posts_all_time    = $_topic->num_posts_all_time;
	$topic->num_followers         = $_topic->num_followers;
	$topic->timestamp_created     = $_topic->timestamp_created;

	$followed_topic = new FollowedTopic;
	$followed_topic->addWhere(FALSE, 'topic_id', '=', $_topic->id);
	$followed_topic->addWhere('AND', 'user_id', '=', $my->id);
	if($followed_topic->select()) {
		$topic->user_follows = TRUE;
	} else {
		$topic->user_follows = FALSE;
	}
	
	$topic->strings = new StdClass;
	
	$topic->strings->num_threads_posts = '<a href="/' . $topic->slug . '">'. number_format($topic->num_threads) . ' active threads</a> (containing ' . number_format($topic->num_posts) . ' posts). ' . number_format($topic->num_threads_all_time) . ' threads in total.';
	$topic->strings->num_followers     = number_format($topic->num_followers) . ' followers';

	
	
	$json->response->topics[] = $topic;

}
