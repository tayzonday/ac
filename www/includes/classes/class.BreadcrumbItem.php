<?php

class BreadcrumbItem {

	public $title = '';
	public $href  = '';
	
	public function __construct($title, $href) {
	
		$this->title = $title;
		$this->href  = $href;

		return TRUE;
	
	}

}