<?php

class FollowedThread extends SqlRow {

	public $id;
	public $user_id;
	public $thread_id;
	public $topic_name;
	public $topic_slug;
	public $post_id;
	public $thread_subject;
	public $timestamp_created;
	
	public $_;
	
	
	public function setup() {

		$this->id                = (int) 0;
		$this->user_id           = (int) 0;
		$this->thread_id         = (int) 0;
		$this->topic_name        = (string) '';
		$this->topic_slug        = (string) '';
		$this->post_id           = (int) 0;
		$this->thread_subject    = (string) '';
		$this->timestamp_created = (int) 0;
	
		$this->_ = (bool) TRUE;
	
	}

}

