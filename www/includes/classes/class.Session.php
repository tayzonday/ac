<?php

class Session extends SqlRow {

	public $id;
	public $user_id;
	public $hash;
	public $latest_ip;
	public $registrar_ip;
	public $timestamp_created;

	public $_;

	public function setup() {
	
		$this->id                = (int)    0;
		$this->user_id           = (int)    0;
		$this->hash              = (string) '';
		$this->latest_ip         = (string) '';
		$this->registrar_ip      = (string) '';
		$this->timestamp_created = (int)    0;

		$this->_ = (bool) TRUE;

		if((isset($_COOKIE['session'])) && (!empty($_COOKIE['session']))) {
			
//			echo "has cookie... ";
//			pprint_r($_COOKIE['session']);
			
			$this->hash = $_COOKIE['session'];

		} else {
		
//			echo "no cookie... ";

			$this->hash = random_string(rand(28,32));
			
//			echo "setting value to " . $this->hash;

			setcookie('session', $this->hash, time() + 86400, '/');

//			echo "SETTING COOKIE...";
			
//			echo "value is now " . $_COOKIE['session'] . '...';

			$this->addInsert('session_id', 0);
			$this->addInsert('user_id', 0);
			$this->addInsert('session_hash', $this->hash);
			$this->addInsert('session_latest_ip', $_SERVER['REMOTE_ADDR']);
			$this->addInsert('session_registrar_ip', $_SERVER['REMOTE_ADDR']);
			$this->addInsert('session_timestamp_created', date('U'));
			$this->insert();
			
//			echo "inserted row...";

		}

		return TRUE;

	}


	public function unsetCookie() {

		unset($_COOKIE['session']);
		return TRUE;

	}

}

?>