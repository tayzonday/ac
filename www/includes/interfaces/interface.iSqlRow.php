<?php

interface iSqlRow { 
	
	public function setup();
	
	public function insert($debug = FALSE);

	public function select($debug = FALSE);
	public function selectById($id, $debug = FALSE); 
	public function selectByField($field, $comparison_operator, $value, $debug = FALSE);

	public function update($debug = FALSE);
	public function updateById($id, $debug = FALSE);

	public function delete($debug = FALSE);
	public function deleteById($id, $debug = FALSE);

	public function postPopulate();
    
}

