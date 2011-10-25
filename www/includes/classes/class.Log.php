<?php

class Log extends Sql_Row {

	public $id;
    public $user_id;
    public $as_user_id;
	public $core_file_id;
	public $action;
	public $param1;
	public $param2;
	public $param3;	
    public $ip;
    public $timestamp;

	public $_;

	public function __construct() {
	
		$this->id           = (int)    0;
		$this->user_id      = (int)    0;
		$this->as_user_id   = (int)    0;
		$this->core_file_id = (int)    0;
		$this->action       = (string) '';
		$this->param_1      = (string) '';
		$this->param_2      = (string) '';
		$this->param_3      = (string) '';
		$this->ip           = (int)    0;
		$this->timestamp    = (int)    0;
		
		$this->_ = (bool) true;
		
		parent::__construct();

	}


	public function log($user_id, $as_user_id, $action, $param_1 = FALSE, $param_2 = FALSE, $param_3 = FALSE) {

		global $core;

		$this->addInsert('log_id', 0);
		$this->addInsert('user_id', $user_id);
		$this->addInsert('as_user_id', $as_user_id);
		$this->addInsert('core_file_id', $core->file_id);
		$this->addInsert('log_action', $action);
		$this->addInsert('log_param_1', $param_1);
		$this->addInsert('log_param_2', $param_2);
		$this->addInsert('log_param_3', $param_3);
		$this->addInsert('log_ip', $_SERVER['REMOTE_ADDR']);
		$this->addInsert('log_timestamp', date('U'));
		
		$this->insert();
	
    	return true;

    }

}

?>