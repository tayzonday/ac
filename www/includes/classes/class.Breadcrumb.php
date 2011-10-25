<?php

class Breadcrumb {

	public $items = array();
	
	
	public function addItem($title, $href) {
	
		$this->items[] = new BreadcrumbItem($title, $href);
		
		return TRUE;
	
	}

}