<?php

class Thread extends SqlRow {

	/* SQL Schema Members */
	public $id                    = 0;
	public $type_id               = 0;
	public $user_id               = 0;
	public $topic_id              = 0;
	public $post_id               = 0;
	public $subject               = '';
	public $text                  = '';
	public $image_url             = '';
	public $ip                    = '';
	public $num_posts             = 0;
	public $num_posts_with_images = 0;
	public $show_in_my_threads    = 0;
	public $timestamp_created     = 0;
	public $timestamp_updated     = 0;
	
	public $_;

	/* Object Members */
	public $type;
	public $user;
	public $topic;
	public $post;



	public function floodDetectedInTopic($user_id, $topic_id) {
	
		$this->addWhere(FALSE, 'topic_id', '=', $topic_id);
		$this->addWhere('AND', 'user_id', '=', $user_id);
		$this->addWhere('AND', 'thread_timestamp_created', '>', time() - _CREATE_THREAD_SAME_TOPIC_FLOOD_DETECTION_SECS);
		return $this->select();

	}
	
	public function floodDetectedInAnyTopic($user_id) {
	
		$this->addWhere(FALSE, 'user_id', '=', $user_id);
		$this->addWhere('AND', 'thread_timestamp_created', '>', time() - _CREATE_THREAD_ANY_TOPIC_FLOOD_DETECTION_SECS);
		return $this->select();

	}


	public function duplicateDetectedInTopic($topic_id, $text) {
	
		$this->addWhere(FALSE, 'topic_id', '=', $topic_id);
		$this->addWhere('AND', 'thread_text', '=', $text);
		$this->addWhere('AND', 'thread_timestamp_created', '>', time() - _CREATE_THREAD_DUPLICATE_SAME_TOPIC_FLOOD_DETECTION_SECS);
		return $this->select();

	}









}

