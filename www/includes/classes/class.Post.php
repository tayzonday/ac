<?php

class Post extends SqlRow {

	/* SQL Schema Members */
	public $id                      = 0;
	public $type_id                 = 0;
	public $user_id                 = 0;
	public $thread_id               = 0;
	public $thread_post_id          = 0;
	public $parent_post_id          = 0;
	public $text                    = '';
	public $image_url               = '';
	public $ip                      = '';
	public $num_replies             = '';
	public $num_replies_with_images = '';
	public $timestamp_created       = 0;
	public $timestamp_updated       = 0;
	
	public $_;

	/* Object Members */
	public $type;
	public $user;
	public $session;
	public $thread;
	public $reply_to_post;


}

