<?php

class ShortURL extends SqlRow {

	/* SQL Schema Objects */
	public $id;
	public $type_id;
	public $param_1;
	public $value;
	public $timestamp;
	
	public $_;
	
	public $type;

	public $chars;
	public $exclude;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function setup() {

		$this->id           = (int)    0;
		$this->type_id = (int)    0;
		$this->param_1      = (int)    0;
		$this->value        = (string) '';
		$this->timestamp    = (int)    0;
		
		$this->_ = (bool) TRUE;
		
		$this->type = (bool) FALSE;

		$this->chars = array(
			'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '1', '2', '3','4','5','6','7','8','9','0'
		);
		
		// user, link, photo, video, audio, group, poll, event, help, faq, 
		$this->exclude = array(
			'useq'  => 'uses',
			'linj'  => 'linl',
			'photn' => 'photp',
			'viden' => 'videp',
			'audin' => 'audip',
			'grouo' => 'grouq',
			'polk'  => 'polm',
			'evens' => 'evenu'
		);
		

		return TRUE;
	
	}


	function nextChar($char) {
	
		return $this->chars[array_search($char, $this->chars) + 1];
		
	}


	function atEnd($value, $n) {

		return !isset($this->chars[array_search($value[$n], $this->chars) + 1]) ? true : false;

	}

	
	function stringIncrement($value) {

		if(array_key_exists($value, $this->exclude)) {
			return $this->exclude[$value];
		}

		$len = strlen($value);
	
		if($len == 1) {
			if($this->atEnd($value, 0)) {
				$value = $this->chars[0] . $this->chars[0];
				return $value;
			} else {
				$value[0] = $this->nextChar($value[0]);
				return $value;
			}
		}

		if($len == 2) {
			if(($this->atEnd($value, 0)) && ($this->atEnd($value, 1))) {
				$value = $this->chars[0] . $this->chars[0] . $this->chars[0];
				return $value;
			} else {
				if($this->atEnd($value, 1)) {
					$value[0] = $this->nextChar($value[0]);
					$value[1] = $this->chars[0];
					return $value;
				} else {
					$value[0] = $value[0];
					$value[1] = $this->nextChar($value[1]);
					return $value;
				}
			}
		}

		if($len == 3) {
			if(($this->atEnd($value, 0)) && ($this->atEnd($value, 1)) && ($this->atEnd($value, 2))) {
				$value = $this->chars[0] . $this->chars[0] . $this->chars[0] . $this->chars[0];
				return $value;
			} else {
				if(($this->atEnd($value, 1)) && ($this->atEnd($value, 2))) {
					$value[0] = $this->nextChar($value[0]);
					$value[1] = $this->chars[0];
					$value[2] = $this->chars[0];
					return $value;
				}
				if($this->atEnd($value, 2)) {
					$value[0] = $value[0];
					$value[1] = $this->nextChar($value[1]);
					$value[2] = $this->chars[0];
					return $value;
				} else {
					$value[0] = $value[0];
					$value[1] = $value[1];
					$value[2] = $this->nextChar($value[2]);
					return $value;
				}
			}
		}

		if($len == 4) {
			if(($this->atEnd($value, 0)) && ($this->atEnd($value, 1)) && ($this->atEnd($value, 2)) && ($this->atEnd($value, 3))) {
				$value = $this->chars[0] . $this->chars[0] . $this->chars[0] . $this->chars[0] . $this->chars[0];
				return $value;
			} else {
				if(($this->atEnd($value, 1)) && ($this->atEnd($value, 2)) && ($this->atEnd($value, 3))) {
					$value[0] = $this->nextChar($value[0]);
					$value[1] = $this->chars[0];
					$value[2] = $this->chars[0];
					$value[3] = $this->chars[0];
					return $value;
				}
				if(($this->atEnd($value, 2)) && ($this->atEnd($value, 3))) {
					$value[0] = $value[0];
					$value[1] = $this->nextChar($value[1]);
					$value[2] = $this->chars[0];
					$value[3] = $this->chars[0];
					return $value;
				}
				if($this->atEnd($value, 3)) {
					$value[0] = $value[0];
					$value[1] = $value[1];
					$value[2] = $this->nextChar($value[2]);
					$value[3] = $this->chars[0];
					return $value;
				} else {
					$value[0] = $value[0];
					$value[1] = $value[1];
					$value[2] = $value[2];
					$value[3] = $this->nextChar($value[3]);
					return $value;
				}
			}
		}

		if($len == 5) {
			if(($this->atEnd($value, 0)) && ($this->atEnd($value, 1)) && ($this->atEnd($value, 2)) && ($this->atEnd($value, 3)) && ($this->atEnd($value, 4))) {
				$value = $this->chars[0] . $this->chars[0] . $this->chars[0] . $this->chars[0] . $this->chars[0] . $this->chars[0];
				return $value;
			} else {
				if(($this->atEnd($value, 1)) && ($this->atEnd($value, 2)) && ($this->atEnd($value, 3)) && ($this->atEnd($value, 4))) {
					$value[0] = $this->nextChar($value[0]);
					$value[1] = $this->chars[0];
					$value[2] = $this->chars[0];
					$value[3] = $this->chars[0];
					$value[4] = $this->chars[0];
					return $value;
				}
				if(($this->atEnd($value, 2)) && ($this->atEnd($value, 3)) && ($this->atEnd($value, 4))) {
					$value[0] = $value[0];
					$value[1] = $this->nextChar($value[1]);
					$value[2] = $this->chars[0];
					$value[3] = $this->chars[0];
					$value[4] = $this->chars[0];
					return $value;
				}
				if(($this->atEnd($value, 3)) && ($this->atEnd($value, 4))) {
					$value[0] = $value[0];
					$value[1] = $value[1];
					$value[2] = $this->nextChar($value[2]);
					$value[3] = $this->chars[0];
					$value[4] = $this->chars[0];
					return $value;
				}
				if($this->atEnd($value, 4)) {
					$value[0] = $value[0];
					$value[1] = $value[1];
					$value[2] = $value[2];
					$value[3] = $this->nextChar($value[3]);
					$value[4] = $this->chars[0];
					return $value;
				} else {
					$value[0] = $value[0];
					$value[1] = $value[1];
					$value[2] = $value[2];
					$value[3] = $value[3];
					$value[4] = $this->nextChar($value[4]);
					return $value;
				}
			}
		}


		if($len == 6) {
			if((atEnd($value, 0)) && (atEnd($value, 1)) && (atEnd($value, 2)) && (atEnd($value, 3)) && (atEnd($value, 4)) && (atEnd($value, 5))) {
				$value = $chars[0] . $chars[0] . $chars[0] . $chars[0] . $chars[0] . $chars[0] . $chars[0];
				return $value;
			} else {
				if((atEnd($value, 1)) && (atEnd($value, 2)) && (atEnd($value, 3)) && (atEnd($value, 4)) && (atEnd($value, 5))) {
					$value[0] = $this->nextChar($value[0]);
					$value[1] = $chars[0];
					$value[2] = $chars[0];
					$value[3] = $chars[0];
					$value[4] = $chars[0];
					$value[5] = $chars[0];
					return $value;
				}
				if((atEnd($value, 2)) && (atEnd($value, 3)) && (atEnd($value, 4)) && (atEnd($value, 5))) {
					$value[0] = $value[0];
					$value[1] = $this->nextChar($value[1]);
					$value[2] = $chars[0];
					$value[3] = $chars[0];
					$value[4] = $chars[0];
					$value[5] = $chars[0];
					return $value;
				}
				if((atEnd($value, 3)) && (atEnd($value, 4)) && (atEnd($value, 5))) {
					$value[0] = $value[0];
					$value[1] = $value[1];
					$value[2] = $this->nextChar($value[2]);
					$value[3] = $chars[0];
					$value[4] = $chars[0];
					$value[5] = $chars[0];
					return $value;
				}
				if((atEnd($value, 4)) && (atEnd($value, 5))) {
					$value[0] = $value[0];
					$value[1] = $value[1];
					$value[2] = $value[2];
					$value[3] = $this->nextChar($value[3]);
					$value[4] = $chars[0];
					$value[5] = $chars[0];
					return $value;
				}
				if(atEnd($value, 5)) {
					$value[0] = $value[0];
					$value[1] = $value[1];
					$value[2] = $value[2];
					$value[3] = $value[3];
					$value[4] = $this->nextChar($value[4]);
					$value[5] = $chars[0];
					return $value;
				} else {
					$value[0] = $value[0];
					$value[1] = $value[1];
					$value[2] = $value[2];
					$value[3] = $value[3];
					$value[4] = $value[4];
					$value[5] = $this->nextChar($value[5]);
					return $value;
				}
			}
		}

	}
}

?>