<?php

class SidebarItem { 

	public $id;
	public $href;
	public $title;
	public $icon;
	public $num;
	public $classname;


	public function __construct($id, $href, $title, $icon, $num, $classname) {

		$this->id        = $id;
		$this->href      = $href;
		$this->title     = $title;
		$this->icon      = $icon;
		$this->num       = $num;
		$this->classname = $classname;

	}



}





