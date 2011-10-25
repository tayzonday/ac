<?php

class DatabaseTable {

	public $alias;
	public $fields;

	public function __construct($alias, $fields) {
	
		$this->alias  = $alias;
    	$this->fields = $fields;

		return TRUE;

    }

}
    
