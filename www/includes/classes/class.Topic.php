<?php

class Topic extends SqlRow {

	public $id;
	public $type_id;
	public $user_id;
	public $name;
	public $slug;
	public $description;
	public $icon_small;
	public $icon_large;
	public $ip;
	public $num_threads;
	public $num_posts;
	public $num_threads_all_time;
	public $num_posts_all_time;
	public $num_followers;
	public $timestamp_created;
	public $timestamp_updated;
	
	public $_;

	public $type;
	public $user;


	public function setup() {
	
		$this->id                   = (int) 0;
		$this->type_id              = (int) 0;
		$this->user_id              = (int) 0;
		$this->name                 = (string) '';
		$this->slug                 = (string) '';
		$this->description          = (string) '';
		$this->icon_small           = (string) '';
		$this->icon_large           = (string) '';
		$this->ip                   = (string) '';
		$this->num_threads          = (int) 0;
		$this->num_posts            = (int) 0;
		$this->num_threads_all_time = (int) 0;
		$this->num_posts_all_time   = (int) 0;
		$this->num_followers        = (int) 0;
		$this->timestamp_created    = (int) 0;
		$this->timestamp_updated    = (int) 0;
	
		$this->_ = (bool) TRUE;
		
		$this->type = (bool) FALSE;
		$this->user = (bool) FALSE;
	
	}
		

}

