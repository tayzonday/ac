<?php

class SqlRow implements iSqlRow {

	public $table_name  = '';
	public $join_data   = array();
	public $insert_data = array();
	public $where_data  = array();
	public $update_data = array();
	public $delete_data = array();
	public $extra_data  = array();
	
	public $select_count_field = '';
	
	public $query_debug = '';

	public function __construct($insert_data = array()) {

		global $db;

		$this->table_name = $db->schema->getTableNameFromClassName(get_class($this));

		$this->setup();

		if(sizeof($insert_data) > 0) {
		
			$insert_debug = FALSE;
			foreach($insert_data as $field => $value) {
				if($field == 'debug') {
					$insert_debug = $value;
					continue;
				}
				$this->addInsert($field, $value);
			}
			
			$this->insert($insert_debug);
		
		}

	}

	
	public function setup() {
	
		return TRUE;

	}

	public function addJoin($table_name, $member_name, $field_left, $field_right) {

		global $db;

		$join_data = new SqlJoinData;

		$join_data->table_name  = $table_name;
		$join_data->member_name = $member_name;
		$join_data->class_name  = $db->schema->getClassNameFromTableName($table_name);
		$join_data->field_left  = $field_left;
		$join_data->field_right = $field_right;

		$this->join_data[] = $join_data;

		return TRUE;

	}

	public function addInsert($field, $value) {

		$insert_data = new SqlInsertData;

		$insert_data->field = $field;
		$insert_data->value = prepare_string_for_db($value);

		$this->insert_data[] = $insert_data;

		return TRUE;

	}

	public function addWhere($logical_operator, $field, $comparison_operator, $value) {

		$where_data = new SqlWhereData;
		
		if((isset($logical_operator)) && (!empty($logical_operator))) {
			$where_data->logical_operator = $logical_operator;
		}
		
		$where_data->field = $field;
		if((isset($comparison_operator)) && (!empty($comparison_operator))) {
			$where_data->comparison_operator = $comparison_operator;
		}
		$where_data->value = prepare_string_for_db($value);

		$this->where_data[] = $where_data;

		return TRUE;

	}


	public function addWhereIdIs($id) {

		global $db;
	
		$vars = get_class_vars(get_class($this));
		
		$field = $db->schema->{$this->table_name}->fields[0];
	
		$this->addWhere(FALSE, $field, '=', $id);
		
		return TRUE;

	}


	public function addUpdate($field, $member_name, $value) {

		$update_data = new SqlUpdateData;

		$update_data->field       = $field;
		$update_data->member_name = $member_name;
		$update_data->value       = prepare_string_for_db($value);

		$this->update_data[] = $update_data;

		return TRUE;

	}
	

	public function hasWhereData() {
		return (sizeof($this->where_data) > 0);
	}

	public function hasUpdateData() {
		return (sizeof($this->update_data) > 0);
	}


	public function addDelete($field, $value, $operator = false) {

		$delete_data = new SqlDeleteData;

		$delete_data->field = $field;
		$delete_data->value = prepare_string_for_db($value);
		if((isset($operator)) && (!empty($operator))) {
			$delete_data->operator = $operator;
		}

		$this->delete_data[] = $delete_data;

		return TRUE;

	}

	public function unsetData() {

		$this->join_data   = array();
		$this->insert_data = array();
		$this->where_data  = array();
		$this->update_data = array();
		$this->delete_data = array();

		return TRUE;

	}

	public function insert($debug = FALSE) {

		global $db;
		
		$db->query = "INSERT INTO " . $this->table_name . " (";

		for($n = 0; $n < sizeof($this->insert_data); $n++) {
			$db->query .= mysql_real_escape_string($this->insert_data[$n]->field);
			if(isset($this->insert_data[($n + 1)]->field)) {
				$db->query .= ", ";
			}
		}

		$db->query .= ") VALUES (";

		for($n = 0; $n < sizeof($this->insert_data); $n++) {
			$db->query .= "'" . mysql_real_escape_string($this->insert_data[$n]->value) . "'";
			if(isset($this->insert_data[($n + 1)]->value)) {
				$db->query .= ", ";
			}
		}

		$db->query .= ")";
		
		if(($debug === TRUE) || (_DB_DEBUG_SHOW_ALL_QUERIES === TRUE)) {
			$db->displayNotice($this->query_debug, $db->query);
		}

		if($result = $db->query()) {

			$vars = get_class_vars(get_class($this));

			$n = 0;
			foreach($vars as $member => $value) {

				if($member == '_') break;

				if(is_object($this->$member)) {
					$this->$member->id = $this->insert_data[$n]->value;
				} else {
					$this->$member = $this->insert_data[$n]->value;
				}

				$n++;

			}

			$this->id = $db->insertId();

			$this->unsetData();
			
			$this->postPopulate();

			return TRUE;

		} else {

			$this->unsetData();

			return FALSE;

		}

	}

	public function select($debug = FALSE) {
	
//		echo "selecting from " . $this->table_name;

		global $db;

		$db->query = "SELECT ";

		if(!empty($this->select_count_field)) {
		
			$db->query .= "COUNT(" . $this->select_count_field . ") AS num ";
		
		} else {
		
			foreach($db->schema->{$this->table_name}->fields as $field) {
				if(sizeof($this->join_data) == 0) {
					$fields[] = $field;
				} else {
					$fields[] = db_alias($this->table_name) . "." . $field . " AS " . db_alias($this->table_name) . "_" . $field;		
				}
			}
		
			foreach($this->join_data as $join) {
				foreach($db->schema->{$join->table_name}->fields as $field) {
					$fields[] = db_alias($join->table_name) . "." . $field . " AS " . db_alias($join->table_name) . "_" . $field;
				}
			}

			$db->query .= implode(', ', $fields) . " ";

		}
		
		$db->query .= "FROM " . $this->table_name . " " . $db->schema->{$this->table_name}->alias . " ";

		foreach($this->join_data as $join) {
			$db->query .= "LEFT JOIN " . $join->table_name . " " . db_alias($join->table_name) . " ON " . $join->field_left . " = " . $join->field_right . " ";
		}

		$db->query .= "WHERE ";

		foreach($this->where_data as $data) {
			if((isset($data->logical_operator)) && (!empty($data->logical_operator))) {
				$db->query .= $data->logical_operator . " ";
			}

			if($data->comparison_operator == 'REGEXP') {
				$db->query .= $data->field . " " . $data->comparison_operator . " " . mysql_real_escape_string($data->value) . " ";
			} else {
				$db->query .= $data->field . " " . $data->comparison_operator . " '" . mysql_real_escape_string($data->value) . "' ";			
			}

		}
		
		$db->query .= "LIMIT 1";
		
		if(($debug === TRUE) || (_DB_DEBUG_SHOW_ALL_QUERIES === TRUE)) {
			$db->displayNotice($this->query_debug, $db->query);
		}

		if($result = $db->query()) {
			
			if($db->num_rows > 0) {
			
				if(!empty($this->select_count_field)) {
				
					$row = $db->fetchResult($result);
					
					return $row['num'];
				
				} else {

					while($row = $db->fetchResult($result)) {

						$vars = get_class_vars(get_class($this));

						$n = 0;
						foreach($vars as $member => $value) {
							if($member == '_') break;
							if(sizeof($this->join_data) == 0) {
								$this->$member = stripslashes($row[$db->schema->{$this->table_name}->fields[$n]]);
							} else {
								$this->$member = stripslashes($row[db_alias($this->table_name) . "_" . $db->schema->{$this->table_name}->fields[$n]]);
							}
							$n++;
						}

						foreach($this->join_data as $join) {
							include_class($join->class_name);
							$member_bits = explode('->', $join->member_name);

							if(sizeof($member_bits) == 3) {
								$this->{$member_bits[0]}->{$member_bits[1]}->{$member_bits[2]} = new $join->class_name;
								$vars = get_class_vars(get_class($this->{$member_bits[0]}->{$member_bits[1]}->{$member_bits[2]}));
								$n = 0;
								foreach($vars as $member => $value) {
									if($member == '_') break;
									$this->{$member_bits[0]}->{$member_bits[1]}->{$member_bits[2]}->$member = stripslashes($row[db_alias($join->table_name) . "_" . $db->schema->{$join->table_name}->fields[$n]]);
									$n++;
								}
							} else if(sizeof($member_bits) == 2) {
								$this->{$member_bits[0]}->{$member_bits[1]} = new $join->class_name;
								$vars = get_class_vars(get_class($this->{$member_bits[0]}->{$member_bits[1]}));
								$n = 0;
								foreach($vars as $member => $value) {
									if($member == '_') break;
									$this->{$member_bits[0]}->{$member_bits[1]}->$member = stripslashes($row[db_alias($join->table_name) . "_" . $db->schema->{$join->table_name}->fields[$n]]);
									$n++;
								}
							} else {
								$this->{$join->member_name} = new $join->class_name;
								$vars = get_class_vars(get_class($this->{$join->member_name}));
								$n = 0;
								foreach($vars as $member => $value) {
									if($member == '_') break;
									$this->{$join->member_name}->$member = stripslashes($row[db_alias($join->table_name) . "_" . $db->schema->{$join->table_name}->fields[$n]]);
									$n++;
								}
							}
							
						}

					}

					$this->postPopulate();

				}
			
				$this->unsetData();
			
				return TRUE;

			} else {

				$this->unsetData();
			
				return FALSE;
			
			}

		} else {
		
			return FALSE;
		
		}

	}
	
	public function postPopulate() {
		return TRUE;
	}

	public function update($debug = FALSE) {
    
    	global $db;

		$db->query = "UPDATE " . $this->table_name . " SET ";

		for($n = 0; $n < sizeof($this->update_data); $n++) {

			$db->query .= $this->update_data[$n]->field . " = '" . mysql_real_escape_string($this->update_data[$n]->value) . "'";
			
			if(isset($this->update_data[($n + 1)]->value)) {

				$db->query .= ",";

			}
			
			$db->query .= " ";
		
		}

		$db->query .= "WHERE ";

		foreach($this->where_data as $data) {

			if((isset($data->logical_operator)) && (!empty($data->logical_operator))) {
				$db->query .= $data->logical_operator . " ";
			}

			$db->query .= mysql_real_escape_string($data->field) . " " . $data->comparison_operator . " '" . mysql_real_escape_string($data->value) . "' ";

		}
		
		$db->query .= "LIMIT 1";

		if(($debug === TRUE) || (_DB_DEBUG_SHOW_ALL_QUERIES === TRUE)) {
			$db->displayNotice($this->query_debug, $db->query);
		}
		
		if($result = $db->query()) {

			foreach($this->update_data as $data) {
			
				$this->{$data->member_name} = $data->value;
			
			}

			$this->unsetData();

			$this->postPopulate();

			return TRUE;
		
		} else {

			$this->unsetData();
	
			return FALSE;
	
		}
    
    }
    
    public function delete($debug = FALSE) {

    	global $db;

		$db->query = "DELETE FROM " . $this->table_name . " WHERE ";

		foreach($this->where_data as $data) {
			if((isset($data->logical_operator)) && (!empty($data->logical_operator))) {
				$db->query .= $data->logical_operator . " ";
			}
			$db->query .= mysql_real_escape_string($data->field) . " " . $data->comparison_operator . " '" . mysql_real_escape_string($data->value) . "' ";
		}

		if(($debug === TRUE) || (_DB_DEBUG_SHOW_ALL_QUERIES === TRUE)) {
			$db->displayNotice($this->query_debug, $db->query);
		}

		if($result = $db->query()) {
			$this->unsetData();
			return TRUE;
		} else {
			$this->unsetData();
			return FALSE;
		}
		
		$this->setup();
		
	}
	
	

	public function selectById($id, $debug = FALSE) {
	
		global $db;
	
		$vars = get_class_vars(get_class($this));
		
		$field = $db->schema->{$this->table_name}->fields[0];
	
		if($this->hasWhereData()) {
			$this->addWhere('AND', $field, '=', $id);
		} else {
			$this->addWhere(FALSE, $field, '=', $id);
		}
		
		if($this->select($debug)) {
			return TRUE;
		} else {
			return FALSE;
		}
	
	}


	public function updateById($id, $debug = FALSE) {
	
		global $db;
	
		$vars = get_class_vars(get_class($this));
		
		$field = $db->schema->{$this->table_name}->fields[0];
	
		if($this->hasWhereData()) {
			$this->addWhere('AND', $field, '=', $id);
		} else {
			$this->addWhere(FALSE, $field, '=', $id);
		}
		
		if($this->update($debug)) {
			return TRUE;
		} else {
			return FALSE;
		}
	
	}

	public function deleteById($id, $debug = FALSE) {
	
		global $db;
	
		$vars = get_class_vars(get_class($this));
		
		$field = $db->schema->{$this->table_name}->fields[0];
	
		if($this->hasWhereData()) {
			$this->addWhere('AND', $field, '=', $id);
		} else {
			$this->addWhere(FALSE, $field, '=', $id);
		}
		
		if($this->delete($debug)) {
			return TRUE;
		} else {
			return FALSE;
		}
	
	}



	public function selectByField($field, $comparison_operator, $value, $debug = FALSE) {
	
		global $db;
	
		$vars = get_class_vars(get_class($this));
		
		$this->addWhere(FALSE, $field, $comparison_operator, $value);
		
		if($this->select($debug)) {
			return TRUE;
		} else {
			return FALSE;
		}
	
	}
	
	
	
}

?>