<?php

class Template {

	public $name;
	public $page_title;
	public $meta_description;
	public $feed_url;
	public $css_includes;
	public $javascript_includes;
	public $pre_inline_javascript;
	public $post_inline_javascript;
	public $inline_css;
	public $content;
	public $vars;

	public function __construct($name) {

		global $sess;

		$this->name                   = $name;
		$this->page_title             = '';
		$this->meta_description       = '';
		$this->feed_url               = '';
		$this->css_includes           = array();
		$this->inline_css             = '';
		$this->pre_inline_javascript  = '';
		$this->post_inline_javascript = '';
		$this->javascript_includes    = array();
		$this->content                = array();
		$this->vars                   = array();

		switch($this->name) {

			case 'index':
				$this->css_includes[] = $this->name . '/common.css';
				$this->content['main'] = '';
				$this->content['sidebar'] = '';

				break;
				
			case 'blank':
				$this->content['main'] = '';
				break;

			case 'iframe_blank':
				$this->javascript_includes[] = 'common.js';
				$this->content['main']       = '';
				break;

			case 'xml':
				$this->content['main'] = '';
				break;
				
			case 'json':
				$this->content['main'] = '';
				break;
		
		}
		
		return true;
	
	}
	
	public function setVar($name, $value) {
		$this->vars[$name] = $value;
		return true;
	}
	
	public function getVar($name) {
		if((isset($this->vars[$name])) && (!empty($this->vars[$name]))) {
			return $this->vars[$name];
		} else {
			return false;
		}
	}

	public function displayCssIncludes() {

		global $tpl;

		$string = '';

		switch(_COMPRESSED_CSS_FILES) {

			case 0: // uncompressed

				foreach($this->css_includes as $file) {
					$string .= '<link rel="stylesheet" href="' . _URL_PATH_CSS . '_uncompressed/' . $file . '?' . _ASSET_RELEASE_TIMESTAMP . '" type="text/css" media="screen" />';
				}

				break;

			case 1: // compressed

					$string = '<link rel="stylesheet" href="' . _URL_PATH_CSS . 'c/' . $tpl->name . '.css?' . _ASSET_RELEASE_TIMESTAMP . '" type="text/css" media="screen" />';

				break;

		}
		
		return $string;

	}


	public function displayPreInlineJavascript() {
		if(!empty($this->pre_inline_javascript)) {
			return '<script>' . $this->pre_inline_javascript . '</script>';
		} else {
			return '';
		}
	}

	public function displayPostInlineJavascript() {
		if(!empty($this->post_inline_javascript)) {
			return '<script>' . $this->post_inline_javascript . '</script>';
		} else {
			return '';
		}
	}
	
	public function displayInlineCSS() {
		return '<style>' . $this->inline_css . '</style>';
	}

	public function displayJavascriptIncludes() {

		global $tpl;

		switch(_COMPRESSED_JS_FILES) {
		
			case 0: // uncompressed

				$js = '<script>';
				
				$js .= file_get_contents(_ABSOLUTE_PATH . _URL_PATH_LIB . '_uncompressed/' . $tpl->name . '/includes/header_and_config.js');

//				foreach($this->javascript_includes as $file) {
//					$js .= file_get_contents(_ABSOLUTE_PATH . _URL_PATH_LIB . '_uncompressed/' . $file);
//				}

//				$js .= file_get_contents(_ABSOLUTE_PATH . _URL_PATH_LIB . '_uncompressed/' . $tpl->name . '/includes/general_functions.js');
//				$js .= file_get_contents(_ABSOLUTE_PATH . _URL_PATH_LIB . '_uncompressed/' . $tpl->name . '/includes/prototype_functions.js');
				$js .= file_get_contents(_ABSOLUTE_PATH . _URL_PATH_LIB . '_uncompressed/' . $tpl->name . '/includes/footer.js');
				
				$js .= '</script>';

				return $js;

				break;
			
			case 1: // semi-compressed
			
				$js = '';
				$js .= file_get_contents(_ABSOLUTE_PATH . _URL_PATH_LIB . '_semicompressed/' . $tpl->name . '/includes/header_and_config.js');

				foreach($this->javascript_includes as $file) {
					$js .= file_get_contents(_ABSOLUTE_PATH . _URL_PATH_LIB . '_semicompressed/' . $file);
				}

				$js .= file_get_contents(_ABSOLUTE_PATH . _URL_PATH_LIB . '_semicompressed/' . $tpl->name . '/includes/general_functions.js');
				$js .= file_get_contents(_ABSOLUTE_PATH . _URL_PATH_LIB . '_semicompressed/' . $tpl->name . '/includes/prototype_functions.js');
				$js .= file_get_contents(_ABSOLUTE_PATH . _URL_PATH_LIB . '_semicompressed/' . $tpl->name . '/includes/footer.js');

				add_post_inline_js($js);

				break;
			
			case 2: // compressed
			
				return '<script src="' . _URL_PATH_LIB . 'c/' . $tpl->name . '.js?' . _ASSET_RELEASE_TIMESTAMP . '"></script>';

				break;	
		}
		
	}
	
	public function displayContent($region) {
		return $this->content[$region];	
	}
	
	public function resetContent($region) {
		$this->content[$region] = '';
	}

	public function addBit($bit) {
		include_once _PATH_TEMPLATES . $this->name . '/template.' . $bit . '.php';
		return $$bit;
	}
	
	public function displayThemeCss()
	{
	
		return true;
	
	}
	

	public function output() {

		include_once _PATH_TEMPLATES . $this->name . '/template.index.php';
		die;

	}



}

