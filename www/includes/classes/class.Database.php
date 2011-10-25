<?php

class Database {

	public $host;
	public $name;
	public $user;
	public $pass;
	
	public $link_id;
	public $query;
	public $result;
	public $num_rows;
	public $affected_rows;
	public $insert_id;
	public $last_query;
	public $last_error;
	
	public $html_errors;
	
	public $schema;
	
	public function __construct($host, $user, $pass, $name) {

		global $conf;

		$this->schema = new DatabaseSchema;

		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->name = $name;
		
		$this->link_id       = '';
		$this->query         = '';
		$this->result        = '';
		$this->num_rows      = 0;
		$this->affected_rows = 0;
		$this->insert_id     = 0;
		$this->last_query    = '';
		$this->last_error    = '';
		
		$this->html_errors = _DB_SHOW_HTML_ERRORS;
		
	}
	
	public function connect() {
	
		$this->link_id = mysql_connect($this->host, $this->user, $this->pass);
		
		if(!$this->link_id) {

			$this->last_error = mysql_error();
			$this->displayError('MySQL Error:', $this->last_error);
			
			return false;

		}
		
		return true;
			
	}


	public function selectDatabase() {
	
		if(!mysql_select_db($this->name)) {

			$this->last_error = mysql_error();
			$this->displayError($this->last_error);
			
			return FALSE;

      	}
		
		return TRUE;

	}


	public function query() {
	
		if($resource = mysql_query($this->query)) {
			
			if(is_resource($resource)) {
				$this->num_rows = mysql_num_rows($resource);
			}
			
			unset($this->query);
			
			return $resource;
			
		} else {

			$this->num_rows = 0;

			$this->last_error = mysql_error();

			$this->displayNotice('MySQL Error:', $this->last_error);
			
			unset($this->query);
		
			return false;

		}

	}


	public function fetchResult($resource) {
		
		return mysql_fetch_assoc($resource);
		
	}


	public function insertId() {
	
		$this->insert_id = mysql_insert_id();
	
		return $this->insert_id;

	}


	public function numRows($resource) {
		$this->num_rows = mysql_num_rows($resource);
		return $this->affected_rows;
	}

	public function affectedRows() {

		$this->affected_rows = mysql_affected_rows();
	
		return $this->affected_rows;
	
	}
	
	

	public function displayNotice($title, $message) {
	
		if($this->html_errors === TRUE) {
			echo '<div style="margin:5px;border:2px solid #ddd;padding:5px;font-family:Arial;font-size:11px;"><h4>' . $title . '</h4><p>' . $message . '</p></div>';
		} else {
			echo $message;
		}
	
	}


	public function __destruct() {

		mysql_close();

		return true;

	}

}

?>