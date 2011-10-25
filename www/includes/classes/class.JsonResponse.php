<?php

class JsonResponse {

	public $type;
	public $response;


	public function __construct() {
	
		$this->type     = (string) '';
		$this->response = (object) new StdClass;
	
	}
	
	public function internalError() {
	
		$this->type = 0;
		$this->response->errors = array(array(
			'code'  => 0,
			'title' => 'Internal Error',
			'text'  => 'There was an internal error.'
		));

		$this->forceOutput();
	
	}

	
	public function forceOutput() {

		global $tpl;
	
		header('Content-Type: application/json');
		
		c(json_encode($this));
		
		$tpl->output();
		
		die;
	
	}
	
	public function addError($code, $title, $text) {
	
		$this->type = 0;
		
		$array = array();
		
		$array['code'] = $code;
		
		if(!empty($title)) {
			$array['title'] = $title;
		}
		
		if(!empty($text)) {
			$array['text'] = $text;
		}
		
		$this->response->errors[] = $array;

	}


	public function addErrorAndForceOutput($code, $title, $text) {
	
		$this->addError($code, $title, $text);
	
		$this->forceOutput();
	
	}
	
	public function hasErrors() {
	
		if($this->type == 0) {
		
			return (sizeof($this->response->errors) > 0);
		
		}
		
		return FALSE;
	
	}

}
