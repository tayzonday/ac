<?php

class Sidebar { 

	public $title;
	public $slug;
	public $id;
	
	public $inline_link_text;
	public $inline_link_href;

	public $items = array();


	public function __construct($title) {
	
		$this->title = $title;
		$this->slug = strtolower(str_replace(' ', '-', $this->title));
		$this->id = 0;
		
		$this->inline_button_name = '';
		$this->inline_button_href = '';

	}

	public function addItem($id, $href, $title, $icon, $num, $classname) {
	
		$item = new SidebarItem($id, $href, $title, $icon, $num, $classname);

		$this->items[] = $item;

	}
	
	
	public function display() {
	
		$o = '<h4>' . $this->title . '</h4>';
		
		if(!empty($this->inline_link_text)) {
			$o .= '<a href="' . $this->inline_link_href . '" class="menu-inline-link">' . $this->inline_link_text . '</a>';
		}
	
		if(sizeof($this->items) > 0) {
			$o .= '<ul>';
			foreach($this->items as $item) {
			
//				pprint_r($item);
			
				$o .= '<li id="menu-' . $this->slug . '-' . $item->id . '"><a href="' . $item->href . '"';
				if($item->icon == TRUE) {
					$o .= ' style="background-image:url(\'' . $item->icon . '\');"';
				}
				if($item->classname == TRUE) {
					$o .= ' class="' . $item->classname . '"';
				}
				$o .= '>' . $item->title . '</a><span';
				if($item->num == 0) {
					$o .= ' class="hidden"';
				}
				$o .= '>' . $item->num . '</span></li>';
			}
			$o .= '</ul>';
		}
		
		return $o;

	}

}

