<?php

class Core {

	public $path;
	public $tpath;
	public $args;
	public $source;
	public $target;

	public function __construct() {
		
		$this->tpath         = trim($_SERVER['REQUEST_URI']);
		$this->path          = substr($this->tpath, 1, strlen($this->tpath) - 1);
		$this->args          = explode('/', $_SERVER['REQUEST_URI']);
		$this->source        = '';
		$this->target        = '';
		$this->target_folder = 'frontend/';
	
		if(sizeof($_GET) > 1) {
			for($n = 0; $n < sizeof($this->args); $n++) {
				$token = strtok($this->args[$n], '?');
				$this->args[$n] = $token;
			}
		}
	}
	
	public function getAlias() {
	
		$this->target = 'index';
	
		switch(arg(1)) {

			case '':              $this->target = 'index'; break;

			case 'create-thread': $this->target = 'create_thread'; break;

			case 'admin':

				$this->target_folder = 'admin/';

				switch(arg(2)) {
					case 'moderate': $this->target = 'moderate'; break;
	
					default:
						$this->target = 'index'; break;
				}
				
				break;
			
			case 'dev':
			
				$this->target_folder = 'dev/';
				switch(arg(2)) {
					case 'flush_cookies':
						$this->target = 'flush_cookies'; break;
						
					
				
				}
				
				break;
				
				
			case 'ajax':
			
				$this->target_folder = 'ajax/';

				if(!isset($_REQUEST['id'])) {
					$this->target = '404'; break;
				}
				
				switch($_REQUEST['id']) {
					case 1:  $this->target = 'get_path_include'; break;
					case 2:  $this->target = 'follow_thread';    break;
					case 3:  $this->target = 'create_post';      break;
					case 4:  $this->target = 'unfollow_thread';  break;
					case 5:  $this->target = 'follow_topic';     break;
					case 6:  $this->target = 'unfollow_topic';   break;
					case 7:  $this->target = 'logout';           break;
					case 8:  $this->target = 'register';         break;
					case 9:  $this->target = 'login';            break;
					case 10: $this->target = 'modal_create_thread_html'; break; // Modal HTML NOT NEEDED anymore
					case 11: $this->target = 'create_thread';    break;
				
					
				}
				
		
			default:
			
				break;

		}
	}
}

?>