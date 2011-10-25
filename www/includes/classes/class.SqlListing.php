<?php

class SqlListing implements iSqlListing {

	public $table_name;
	public $join_data;
	public $where_data;
	public $extra_data;
	
	public $offset;
	public $limit;
	public $order_by;
	public $order_by_direction;
	
	public $num_rows;
	public $rows;
	
	public $use_cache;
	public $cache_key;
	public $cache_expires;

	public function __construct() {

		global $db;

		$this->join_data  = array();
		$this->where_data = array();
		$this->extra_data = array();
		
		$this->offset             = (int) 0;
		$this->limit              = (int) 0;
		$this->order_by           = (string) '';
		$this->order_by_direction = (string) '';

		$this->num_rows = (int) 0;
		$this->rows     = (array) array();
		
		$this->use_cache     = (BOOL) FALSE;
		$this->cache_key     = (string) '';
		$this->cache_expires = (int) 0;

		$this->table_name = $db->schema->getTableNameFromListingClassName(get_class($this));
		$this->item_class_name = $db->schema->getItemClassNameFromListingClassName(get_class($this));

		$this->setup();

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
		
		return true;

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
		
		if(is_array($value)) { // used for WHERE blah IN (12,3,4,2)
			$new_values = array();
			foreach($value as $v) {
				$new_values[] = prepare_string_for_db($v);
			}
			$where_data->value = $new_values;
		} else {
			$where_data->value = prepare_string_for_db($value);
		}

		$this->where_data[] = $where_data;

		return true;

	}

	public function unsetData() {

		$this->join_data   = array();
		$this->where_data  = array();

		return true;

	}

	public function select($type, $debug = FALSE) {
	
		// type 0 = select all to get the total
		// type 1 = select with results

		global $db, $mc;
		
		$valid_cache = FALSE;
		if($this->use_cache === TRUE) {
			if($cached_results = $mc->get($this->cache_key)) {
				$this->rows = @unserialize($cached_results);
				$valid_cache = TRUE;
			}
		}
		
		if($valid_cache === FALSE) {

			$db->query = "SELECT ";

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
		
			if(!empty($this->matchField)) {
				$fields[] = $this->matchField;
			}

			$db->query .= implode(', ', $fields) . " ";

			$db->query .= "FROM " . $this->table_name . " " . $db->schema->{$this->table_name}->alias . " ";

			foreach($this->join_data as $join) {
				$db->query .= "LEFT JOIN " . $join->table_name . " " . db_alias($join->table_name) . " ON " . $join->field_left . " = " . $join->field_right . " ";
			}

			if(sizeof($this->where_data) > 0) {
				$db->query .= "WHERE ";

				foreach($this->where_data as $data) {
					if((isset($data->logical_operator)) && (!empty($data->logical_operator))) {
						$db->query .= $data->logical_operator . " ";
					}
			
					if($data->comparison_operator == 'AGAINST') {
						$db->query .= mysql_real_escape_string($data->field) . " " . $data->comparison_operator . "('" . mysql_real_escape_string($data->value) . "') ";
					} else if($data->comparison_operator == 'IN') {
						$values = array_map('mysql_real_escape_string', $data->value);
						$db->query .= mysql_real_escape_string($data->field) . " " . $data->comparison_operator . "('" . implode("', '", $values) . "') ";
					} else {
						$db->query .= mysql_real_escape_string($data->field) . " " . $data->comparison_operator . " '" . mysql_real_escape_string($data->value) . "' ";
					}
				}
			}
		
			if($type == 1) {
				if((!empty($this->order_by)) && (!empty($this->order_by_direction))) {
					$db->query .= "ORDER BY " . $this->order_by . " " . $this->order_by_direction . " ";
				}
				if($this->limit > 0) {
					$db->query .= "LIMIT " . $this->offset . ", " . $this->limit;
				}
			}
		
			if($debug === TRUE) {
				$this->htmlError($db->query);
			}

			if($result = $db->query()) {
		
				$this->num_rows = $db->num_rows;

				if($type == 0) {
					if($this->use_cache === TRUE) {
						$mc->set($this->cache_key, $this->num_rows, FALSE, $this->cache_expires);
					}
					$this->unsetData();
					return TRUE;
				}
		
				if($db->num_rows > 0) {
					while($row = $db->fetchResult($result)) {
						$item = new $this->item_class_name;
						$vars = get_class_vars(get_class($item));
						$n = 0;
						foreach($vars as $member => $value) {
							if($member == '_') break;
							if(sizeof($this->join_data) == 0) {
								$item->$member = stripslashes($row[$db->schema->{$this->table_name}->fields[$n]]);
							} else {
								$item->$member = stripslashes($row[db_alias($item->table_name) . "_" . $db->schema->{$item->table_name}->fields[$n]]);
							}
							$n++;
						}

						foreach($this->join_data as $join) {
							$member_bits = explode('->', $join->member_name);
							if(sizeof($member_bits) == 3) {
								$item->{$member_bits[0]}->{$member_bits[1]}->{$member_bits[2]} = new $join->class_name;
								$vars = get_class_vars(get_class($item->{$member_bits[0]}->{$member_bits[1]}->{$member_bits[2]}));
								$n = 0;
								foreach($vars as $member => $value) {
									if($member == '_') break;
									$item->{$member_bits[0]}->{$member_bits[1]}->{$member_bits[2]}->$member = stripslashes($row[db_alias($join->table_name) . "_" . $db->schema->{$join->table_name}->fields[$n]]);
									$n++;
								}
							} else if(sizeof($member_bits) == 2) {
								$item->{$member_bits[0]}->{$member_bits[1]} = new $join->class_name;
								$vars = get_class_vars(get_class($item->{$member_bits[0]}->{$member_bits[1]}));
								$n = 0;
								foreach($vars as $member => $value) {
									if($member == '_') break;
									$item->{$member_bits[0]}->{$member_bits[1]}->$member = stripslashes($row[db_alias($join->table_name) . "_" . $db->schema->{$join->table_name}->fields[$n]]);
									$n++;
								}
							} else {
								$item->{$join->member_name} = new $join->class_name;
								$vars = get_class_vars(get_class($item->{$join->member_name}));
								$n = 0;
								foreach($vars as $member => $value) {
									if($member == '_') break;
									$item->{$join->member_name}->$member = stripslashes($row[db_alias($join->table_name) . "_" . $db->schema->{$join->table_name}->fields[$n]]);
									$n++;
								}
							}
						}
						$this->rows[] = $item;
					}
				}

				if($this->use_cache === TRUE) {
					$mc->set($this->cache_key, serialize($this->rows), FALSE, $this->cache_expires);
				}
			
				$this->afterSelect();
			
				$this->unsetData();
			
				return TRUE;

			} else {

				$this->unsetData();
			
				return FALSE;
			
			}

		}

	}
	
	public function afterSelect() {
		return true;
	}

	public function update() {
    
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

		echo $db->query;
		
		if($result = $db->query()) {

			foreach($this->update_data as $data) {
			
				$this->{$data->member_name} = $data->value;
			
			}
			
			$this->unsetData();		
			
			return true;
		
		} else {

			$this->unsetData();
	
			return false;
	
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

		if($debug === TRUE) {
			var_dump($db->query);
		}


		if($result = $db->query()) {

			$this->unsetData();

			return true;
                
		} else {
            
			$this->unsetData();

           	return false;

        }

	}
	
	public function getLatest($debug = FALSE) {
	
		global $db;
		
		$vars = get_class_vars($this->item_class_name);

		$field = db_alias($this->table_name) . '.' . $db->schema->{$this->table_name}->fields[0];
		
		$this->order_by = $field;
		$this->order_by_direction = 'DESC';
		$this->offset = '0';
		$this->limit = 1;
		
		if($this->select(1, $debug)) {
			return TRUE;
		} else {
			return FALSE;
		}
		
	
	
	}

	public function htmlError($query) {
	
		echo '<div style="margin:5px;border:2px solid #ddd;padding:5px;font-family:Arial;font-size:11px;">' . $query . '</div>';
	
	}


	public function addCache($key, $expires) {
	
		$this->use_cache     = TRUE;
		$this->cache_key     = _MEMCACHED_KEY_PREFIX . $key;
		$this->cache_expires = $expires;
		
		return TRUE;
	
	}


}

?>