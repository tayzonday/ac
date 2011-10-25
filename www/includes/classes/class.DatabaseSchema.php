<?php

class DatabaseSchema {

	public $api_log;
	public $pageview_log;
	public $sessions;
	public $users;
	public $websocket_validation_tokens;
	public $topics;
	public $topic_types;
	public $threads;
	public $posts;
	public $post_types;
	public $followed_threads;
	public $followed_thread_updates;
	public $followed_topics;
	public $default_followed_topics;

	public function __construct() {
	
		$this->default_followed_topics = new DatabaseTable('dftp', array(
			'default_followed_topic_id',
			'topic_id',
			'topic_name',
			'topic_slug',
			'topic_icon_small',
			'default_followed_topic_order',
			'default_followed_topic_timestamp_created',
		));
	
		$this->followed_topics = new DatabaseTable('fltp', array(
			'followed_topic_id',
			'user_id',
			'topic_id',
			'topic_name',
			'topic_slug',
			'topic_icon_small',
			'followed_topic_timestamp_created',
		));
	
		$this->followed_thread_updates = new DatabaseTable('fltu', array(
			'followed_thread_update_id',
			'followed_thread_id',
			'followed_thread_update_timestamp',
		));
	
		$this->followed_threads = new DatabaseTable('fltr', array(
			'followed_thread_id',
			'user_id',
			'thread_id',
			'followed_thread_topic_name',
			'followed_thread_topic_slug',
			'followed_thread_thread_post_id',
			'followed_thread_thread_subject',
			'followed_thread_timestamp_created',
		));
	
		$this->post_types = new DatabaseTable('psty', array(
			'post_type_id',
			'post_type_value',		
		));

		$this->posts = new DatabaseTable('psts', array(
			'post_id',
			'post_type_id',
			'user_id',
			'thread_id',
			'thread_post_id',
			'parent_post_id',
			'post_text',
			'post_image_url',
			'post_ip',
			'post_num_replies',
			'post_num_replies_with_images',
			'post_timestamp_created',
			'post_timestamp_updated',
		));
	
		$this->thread_types = new DatabaseTable('trty', array(
			'thread_type_id',
			'thread_type_value',		
		));
	
	
		$this->threads = new DatabaseTable('thrd', array(
			'thread_id',
			'thread_type_id',
			'user_id',
			'topic_id',
			'post_id',
			'thread_subject',
			'thread_text',
			'thread_image_url',
			'thread_ip',
			'thread_num_posts',
			'thread_num_posts_with_images',
			'thread_show_in_my_threads',
			'thread_timestamp_created',
			'thread_timestamp_updated',
		));
	
		$this->topic_types = new DatabaseTable('tpty', array(
			'topic_type_id',
			'topic_type_value',
		));	
	
		$this->topics = new DatabaseTable('tpcs', array(
			'topic_id',
			'topic_type_id',
			'user_id',
			'topic_name',
			'topic_slug',
			'topic_description',
			'topic_icon_small',
			'topic_icon_large',
			'topic_ip',
			'topic_num_threads',
			'topic_num_posts',
			'topic_num_threads_all_time',
			'topic_num_posts_all_time',
			'topic_num_followers',
			'topic_timestamp_created',
			'topic_timestamp_updated',
		));


		$this->api_log = new DatabaseTable('apil', array(
			'api_log_id',
			'user_id',
			'api_log_action',
			'api_log_params',
			'api_log_timestamp',
		));

		$this->pageview_log = new DatabaseTable('pvlg', array(
			'pageview_log_id',
			'server_id',
			'pageview_log_ip',
			'user_id',
			'pageview_log_target',
			'pageview_log_referer',
			'pageview_timestamp',
		));

		$this->sessions = new DatabaseTable('sess', array(
			'session_id',
			'user_id',
			'session_hash',
			'session_latest_ip',
			'session_registrar_ip',
			'session_timestamp_created',
		));

		$this->users = new DatabaseTable('usrs', array(
			'user_id',
			'user_card_key',
			'user_password',
			'user_latest_ip',
			'user_registrar_ip',
			'user_num_thread_replies',
			'user_num_post_mentions',
			'user_timestamp_created',
			'user_timestamp_updated',
		));

		$this->websocket_validation_tokens = new DatabaseTable('wsvt', array(
			'websocket_validation_token_id',
			'user_id',
			'websocket_validation_token_hash',
			'websocket_validation_token_timestamp',
		));
		
		
		
		$this->class_to_table_map = array(
			'ApiLog'                   => 'api_log',
			'PageviewLog'              => 'pageview_log',
			'Session'                  => 'sessions',
			'User'                     => 'users',
			'WebSocketValidationToken' => 'websocket_validation_tokens',
			'Topic'                    => 'topics',
			'Thread'                   => 'threads',
			'Post'                     => 'posts',
			'PostType'                 => 'post_types',
			'FollowedThread'           => 'followed_threads',
			'FollowedThreadUpdate'     => 'followed_thread_updates',
			'FollowedTopic'            => 'followed_topics',
			'DefaultFollowedTopic'     => 'default_followed_topics',
		);

		$this->listing_class_to_table_map = array(
			'ThreadListing'               => 'threads',
			'PostListing'                 => 'posts',
			'TopicListing'                => 'topics',
			'FollowedThreadListing'       => 'followed_threads',
			'FollowedTopicListing'        => 'followed_topics',
			'DefaultFollowedTopicListing' => 'default_followed_topics',
		);

		$this->listing_class_to_item_class_map = array(
			'ThreadListing'               => 'Thread',
			'PostListing'                 => 'Post',
			'TopicListing'                => 'Topic',
			'FollowedThreadListing'       => 'FollowedThread',
			'FollowedTopicListing'        => 'FollowedTopic',
			'DefaultFollowedTopicListing' => 'DefaultFollowedTopic',
		);
		

	}


	public function getTableNameFromClassName($class_name) {
		foreach($this->class_to_table_map as $key => $value) {
			if($class_name == $key) {
				return $value;
			}
		}
	}

	public function getTableNameFromListingClassName($class_name) {
		foreach($this->listing_class_to_table_map as $key => $value) {
			if($class_name == $key) {
				return $value;
			}
		}
	}

	public function getClassNameFromTableName($table_name) {
		foreach($this->class_to_table_map as $key => $value) {
			if($table_name == $value) {
				return $key;
			}
		}
	}
	
	public function getItemClassNameFromListingClassName($class_name) {
		foreach($this->listing_class_to_item_class_map as $key => $value) {
			if($class_name == $key) {
				return $value;
			}
		}	
	}

}

?>