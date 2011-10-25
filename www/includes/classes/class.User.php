<?php

class User extends SqlRow {

	public $id;
	public $card_key;
	public $password;
	public $latest_ip;
	public $registrar_ip;
	public $num_thread_replies;
	public $num_post_mentions;
	public $timestamp_created;
	public $timestamp_updated;

	public $_;
	
	public $formatted_card_key;
	public $is_logged_in;


	public function setup() {

		$this->id                 = (int) 0;
		$this->card_key           = (int) 0;
		$this->password           = (string) '';
		$this->latest_ip          = (string) '';
		$this->registrar_ip       = (string) 0;
		$this->num_thread_replies = (int) 0;
		$this->num_post_mentions  = (int) 0;
		$this->timestamp_created  = (int) 0;
		$this->timestamp_updated  = (int) 0;

		$this->_ = (bool) TRUE;

		$this->formatted_card_key = (string) '';
		$this->is_logged_in       = (bool) FALSE;
	
	}
	
	public function postPopulate() {
	
		$n = 0;
		
		while(isset($this->card_key{$n})) {
		
			$this->formatted_card_key .= (($n > 0) && ($n % 4 == 0)) ? ' ' . $this->card_key{$n} : $this->card_key{$n};

			$n++;
		
		}

		$this->is_logged_in = (!empty($this->password)) ? TRUE : FALSE;
	}

	public function generateUniqueCardKey() {
	
		$exists = TRUE;

		while($exists === TRUE) {

			$card_key = '';

			for($n = 0; $n < 16; $n++) {

				$card_key .= rand(0,9);

			}
	
			if(!$this->selectByField('user_card_key', '=', $card_key)) {

				$exists = FALSE;

				$this->setup();

			}

		}
		
		$this->card_key = $card_key;
	
	}


//	public function getNumThreadReplies() {
	
		//
		//
		//
		//
//		$this->addWhere('');
	
//	}









}


