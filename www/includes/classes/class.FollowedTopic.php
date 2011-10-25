<?php

class FollowedTopic extends SqlRow {

	public $id;
	public $user_id;
	public $topic_id;
	public $topic_name;
	public $topic_slug;
	public $topic_icon_small;
	public $timestamp_created;
	
	public $_;


	public function setup() {

		$this->id                = (int) 0;
		$this->user_id           = (int) 0;
		$this->topic_id          = (int) 0;
		$this->topic_name        = (string) '';
		$this->topic_slug        = (string) '';
		$this->topic_icon_small  = (string) '';
		$this->timestamp_created = (int) 0;

		$this->_ = (bool) TRUE;

	}







}


