<?php

class Form
{

	public $id;
	public $name;
	public $param; // a photo_id for example
	public $tokens;
	public $captcha;
	public $errors;
	public $success;
	public $fields;

	public function __construct($id, $name, $param = 0) {
	
		$this->id            = $id;
		$this->name          = $name;
		$this->param         = $param;
		$this->tokens        = array();
		$this->errors        = array();
		$this->errors['all'] = array();
		$this->success       = array();
		$this->fields        = array();
		
		return true;
	
	}
	
	public function setTokens($session, $mute) {
		
		$timestamp = date('U');
		
		if($session) {
			$this->tokens['session'] = $session;
			$_SESSION['forms'][$this->id][$this->param]['tokens']['session'][$timestamp] = $this->tokens['session'];
		}

		if($mute) {
			$this->tokens['mute'] = $mute;
			$_SESSION['forms'][$this->id][$this->param]['tokens']['mute'][$timestamp] = $this->tokens['mute'];
		}
		
		return true;
		
	}

	public function displayTokens($show_session, $show_mute) {
		
		global $tpl;
		
		$html = '';
		
		if($show_session) {
			$html .= "<input type=\"hidden\" id=\"token_" . $this->id . "_" . $this->param . "\" name=\"token_" . $this->id . "_" . $this->param . "\" value=\"" . $this->tokens['session'] . "\" />";
		}
		
		if($show_mute) {
			$html .= "<input type=\"text\" id=\"mute_" . $this->id . "_" . $this->param . "\" name=\"" . $this->tokens['mute'] . "\" value=\"\" />";
		}
		
		return $html;
		
	}	
	
	public function setFields($fields = array()) {
		
		foreach($fields as $field => $default_value) {
				
			$this->fields[$field] = $default_value;
				
		}
			
		return true;
		
	}

	public function validCaptcha() {
	
		if((isset($this->captcha)) && (!empty($this->captcha)) && (isset($_SESSION['forms'][$this->id][$this->param]['captcha'])) && (!empty($_SESSION['forms'][$this->id][$this->param]['captcha']))) {
		
			if($this->captcha == $_SESSION['forms'][$this->id][$this->param]['captcha']) {

				return true;
				
			} else {

				return false;
				
			}
			
		} else {

			return false;
			
		}

	}		


	public function validSessionToken() {
		
	//	var_dump($this->id);
	//	var_dump($this->param);
	//	var_dump($_SESSION['forms'][$this->id][$this->param]);
		
		//var_dump($_POST['token']);
		//var_dump($_SESSION['forms'][$this->id][$this->param]['tokens']['session']);
	
		if((isset($this->tokens['session'])) && (!empty($this->tokens['session']))) {
			
			if((isset($_SESSION['forms'][$this->id][$this->param]['tokens']['session'])) && (!empty($_SESSION['forms'][$this->id][$this->param]['tokens']['session']))) {
			
				if(in_array($this->tokens['session'], $_SESSION['forms'][$this->id][$this->param]['tokens']['session'])) {
					
					return true;
					
				} else {
					
					echo 'z1';
					return false;
					
				}
			
			} else {
				
				echo 'z2';
				return false;
				
			}
			
		} else {
			
			echo 'z3';
			return false;
			
		}
	
	}
	
	
	public function validMuteToken() {
		
		if(sizeof($_SESSION['forms'][$this->id][$this->param]['tokens']['mute']) > 0) {
		
			foreach($_SESSION['forms'][$this->id][$this->param]['tokens']['mute'] as $mute) {
	
				if(!empty($_POST[$mute])) {
				
					echo 'aids';
					return false;
				
				}
			
			}
			
		} else {
			echo 'aids2';
			return false;
			
		}
		
		return true;
		
	}


	public function addError($code, $field, $title, $messages = array(), $last = false) {
	
		$add_it = true;
	
		if((isset($this->errors[$field])) && (sizeof($this->errors[$field]) >= 1)) {
		
			foreach($this->errors[$field] as $error) {
			
				if(!empty($error['last'])) {
				
					$add_it = false;
					
				}
				
			}
			
		}
		
		if($add_it == true) {

			$this->errors['all'][] = array(
				'code'     => $code,
				'title'    => $title,
				'messages' => $messages,
				'field'    => $field
			);

			$this->errors[$field][] = array(
				'code'     => $code,
				'title'    => $title,
				'messages' => $messages,
				'last'     => $last
			);
		
		}
		
		return true;	
	
	}
	
	
	public function hasErrors($field = false) {
	
		if($field == true) {
		
			if(isset($this->errors[$field])) {
			
				return (sizeof($this->errors[$field]) >= 1) ? true : false;

			} else {
				
				return false;
				
			}

		} else {
		
			if(isset($this->errors['all'])) {
		
				return (sizeof($this->errors['all']) >= 1) ? true : false;
	
			} else {
			
				return false;
				
			}
			
		}
			
	}
	

	public function display() {
	
		global $conf;
	
		include $conf->pathForms . 'form.' . $this->name . '.php';
		
		return true;
	
	}
		
	public function displayErrors() {

		global $tpl;

		if(sizeof($this->errors['all']) >= 1) {

			$tpl->addContent("<div class=\"fail\">
			<dl>");
	
			foreach($this->errors['all'] as $error) {

				$tpl->addContent("<dt>" . $error['title'] . "</dt>");
	
				if(is_array($error['messages'])) {
		
					foreach($error['messages'] as $error_message) {
				
						$tpl->addContent("<dd>" . $error_message . "</dd>");
	
					}
				
				} else {
				
					$tpl->addContent("<dd>" . $error['messages'] . "</dd>");
					
				}	
	
			}
			
			$tpl->addContent("</dl>
			</div>");
	
		}
	
	}	


	public function addSuccess($code, $field, $title, $messages = array()) {
	
		$this->success[] = array(
				'code'     => $code,
				'title'    => $title,
				'messages' => $messages,
				'field'    => $field
			);
		
		return true;	
	
	}


	public function displaySuccess() {
	
		global $tpl;

		if(sizeof($this->success) >= 1)	{

			$tpl->addContent("<div class=\"win\">
			<dl>");
	
			foreach($this->success as $success) {

				$tpl->addContent("<dt>" . $success['title'] . "</dt>");
	
				if(is_array($success['messages'])) {
		
					foreach($success['messages'] as $success_message) {
				
						$tpl->addContent("<dd>&middot; " . $success_message . "</dd>");
	
					}
				
				} else {
				
					$tpl->addContent("<dd>&middot; " . $success['messages'] . "</dd>");
					
				}	
	
			}
			
			$tpl->addContent("</dl>
			</div>");
	
		}
	
	}
	
	public function unsetErrors($fields) {
	
		if(isset($fields)) {
			if(is_array($fields)) {
				foreach($fields as $field) {
					$this->errors[$field] = array();
				}
			} else {
				$this->errors[$field] = array();
			}
		} else {
			$this->errors = array();
		}
		
		return true;
		
	}
	
	public function unsetTokens() {
	
		if((isset($this->tokens['session'])) && (!empty($this->tokens['session']))) {
			if(isset($_SESSION['forms'][$this->id][$this->param]['tokens']['session'])) {
				foreach($_SESSION['forms'][$this->id][$this->param]['tokens']['session'] as $timestamp => $token) {
					if($token == $this->tokens['session']) {
						unset($_SESSION['forms'][$this->id][$this->param]['tokens']['session'][$timestamp]);
					}
				}
			}
		}

		if((isset($this->tokens['mute'])) && (!empty($this->tokens['mute']))) {
			if(isset($_SESSION['forms'][$this->id][$this->param]['tokens']['mute'])) {
				foreach($_SESSION['forms'][$this->id][$this->param]['tokens']['mute'] as $timestamp => $token) {
					if($token == $this->tokens['mute']) {
						unset($_SESSION['forms'][$this->id][$this->param]['tokens']['mute'][$timestamp]);
					}
				}
			}
		}
	
	}
	
}

?>