<?php


validate_included_page();

$tpl = new Template('index');

$tpl->page_title = '';

add_css('Template.css');
add_css('Sidebar.css');
add_css('Thread.css');
add_css('Form.css');
add_css('Topic.css');
add_css('Page.css');


//add_css('4chan.css');

add_js('classes/User/class.User.js');
add_js('classes/class.Template.js');
add_js('classes/class.DOMElement.js');
add_js('classes/SidebarMenu/class.SidebarMenu.js');
add_js('classes/SidebarMenu/class.FollowedTopicsSidebarMenu.js');
add_js('classes/SidebarMenu/class.SidebarMenuItem.js');
add_js('classes/class.PageManager.js');
add_js('classes/class.AjaxRequest.js');
add_js('classes/Page/class.Page.js');
add_js('classes/Page/class.TopicListingPage.js');
add_js('classes/Listing/class.Listing.js');
add_js('classes/Listing/class.TopicListing.js');
add_js('classes/Topic/class.Topic.js');
add_js('classes/Topic/class.TopicForListing.js');





$websocket_validation_token = new WebSocketValidationToken(array(
	'websocket_validation_token_id'        => 0,
	'user_id'                              => $my->id,
	'websocket_validation_token_hash'      => random_istring(rand(28,32)),
	'websocket_validation_token_timestamp' => time(),
));


/*
 a   = template Settings
 a.a - is logged in
 a.b - websocket validation token
 a.c - session hash
 a.d - num thread replies
 a.e - num post mentioned
 a.f - followed topics
 a.g - my topics
 a.h - followed threads
*/

add_pre_inline_js('var a= {
	a:' . ($my->is_logged_in ? 1 : 0) . ',
	b:"' . $websocket_validation_token->hash . '",
	c:"' . $session->hash . '",
	d:' . $my->num_thread_replies . ',
	e:' . $my->num_post_mentions . ',
	f:');
	
$followed_topics_listing = new FollowedTopicListing;
$followed_topics_listing->addWhere(FALSE, 'user_id', '=', $my->id);
$followed_topics_listing->order_by = 'followed_topic_id';
$followed_topics_listing->order_by_direction = 'ASC';
$followed_topics_listing->select(1);

$followed_topics = array();

if(sizeof($followed_topics_listing->rows) > 0) {
	foreach($followed_topics_listing->rows as $_followed_topic) {
		$followed_topic        = new StdClass;
		$followed_topic->id    = $_followed_topic->topic_id;
		$followed_topic->title = $_followed_topic->topic_name;
		$followed_topic->href  = $_followed_topic->topic_slug;
		$followed_topic->icon  = $_followed_topic->topic_icon_small;
		$followed_topic->num   = 0; // NUM - fix later

		$followed_topics[] = $followed_topic;
	}
}

add_pre_inline_js(json_encode($followed_topics) . ",g:");

$my_threads_listing = new ThreadListing;
$my_threads_listing->addWhere(FALSE, 'user_id', '=', $my->id);
$my_threads_listing->addWhere('AND', 'thread_show_in_my_threads', '=', 1);
$my_threads_listing->order_by = 'thread_timestamp_created';
$my_threads_listing->order_by_direction = 'ASC';
$my_threads_listing->select(1);

$my_threads = array();

if(sizeof($my_threads_listing->rows) > 0) {
	foreach($my_threads_listing->rows as $_thread) {
		$thread        = new StdClass;
		$thread->id    = $_thread->id;
		$thread->title = "Thread X";
		$thread->href  = $_thread->id;
		$thread->icon  = '';
		$thread->num   = 0; // NUM - fix later

		$my_threads[] = $thread;
	}
}


add_pre_inline_js(json_encode($my_threads)  . ",h:");

$followed_threads = array();

add_pre_inline_js(json_encode($followed_threads) . "};");

