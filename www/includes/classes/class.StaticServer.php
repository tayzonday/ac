<?php

class StaticServer extends SQLRow {

	/* SQL Schema Members */
	public $id;
	public $name;
	public $active;
	public $debug;
	
	public $_;
	
	public function setup() {
	
		$this->id     = (int) 0;
		$this->name   = (string) '';
		$this->active = (int) 0;
		$this->debug  = (string) '';
		
		$this->_  = (bool) TRUE;
		
	}
	
	

	public function getActive($debug = FALSE) {

		global $db;
	
		$this->addWhere(FALSE, db_alias($this->table_name) . '.static_server_active', '=', '1');
		
		if($this->select($debug)) {
			return TRUE;
		} else {
			return FALSE;
		}
	
	}

}

?>