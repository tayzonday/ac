<?php

function __autoload($class) {
	require _PATH_CLASSES . 'class.' . $class . '.php';
}

function is_authorized() {
	global $my;
	return $my->is_logged_in;
}


// not needed i dont think
//function json_internal_error() {
//	global $tpl;
//	c(json_encode(array('error' => TRUE)));
//	$tpl->output();
//}

function validate_included_page() {
	if(!defined('_INCLUDED')) redirect_home();
}

function ajax_session_recheck($json) {

	if(defined('_SESSION_CREATED')) {
		$json->addErrorAndForceOutput(-1, '', '');
	}

}

function check_valid_referer_domain() {

	// Check for illegal referer, must come from current domain
	if(!isset($_SERVER['HTTP_REFERER'])) {
		redirect_home();
	} else {
		$referer = parse_url($_SERVER['HTTP_REFERER']);
		if($referer['scheme'] . '://' . $referer['host'] != SITE_URL) {
			redirect_home();
		}
	}

}

function transform_text($text) {

	$text = preg_replace(_REGEX_URL, '<a href="/mask/\\0">\\0</a>', $text);

	$text = preg_replace(_REGEX_WML_LINK, '<a href="\\2">\\1</a>', $text);

	$text = stripslashes($text);

	$text = nl2br($text);

	return $text;

}


function get_images_from_text($text) {

	$images = array();

	preg_match_all(_REGEX_URL, $text, $urls);

	$text = preg_replace(_REGEX_URL, '<a href="\\0">\\0</a>', $text);
	$text = stripslashes($text);


	foreach($urls[0] as $url) {
	
		if(preg_match(_REGEX_IMAGE_EXTENSION, $url)) {
		
			$images[] = $url;
			
			$text = str_replace($url, '', $text);
		
		}
		
	}
	
	$return = array(
		'text'   => $text,
		'images' => $images,
	);
	
	return $return;


}

function force_404() {

	global $core, $tpl;

	$core->target = '404';
	include_once _PATH_CORE . $core->target_folder . 'core.' . $core->target . '.php';

	$tpl->output();

	die;
}


function redirect_to($path = '/') {
	header('Location: ' . $path, TRUE, 301);
	die;
}

function go_to($anchor) {
	header('Location: /#/' . $anchor, TRUE, 301);
	die;
}

function can_access_protected_site() {
	return in_array($_SERVER['REMOTE_ADDR'], unserialize(_ALLOWED_IPS));
}

/*
function str_replace_once($search, $replace, $subject) {
    $first_char = strpos($subject, $search);
    if($first_char !== false) {
        $before_str = substr($subject, 0, $first_char);
        $after_str = substr($subject, $first_char + strlen($search));
        return $before_str . $replace . $afterStr;
    } else {
        return $subject;
    }
}*/


function add_js($files) {

	global $tpl;
	
	$tpl->javascript_includes[] = $tpl->name . '/' . $files;
	
	//print_r($tpl->javascript_includes);
	
	return true;

}

function add_css($files) {
	
	global $tpl;

	if(is_array($files)) {
		$tpl->css_includes = array_merge($tpl->css_includes, $tpl->name . '/' . $files);
	} else {
		$tpl->css_includes[] = $tpl->name . '/' . $files;
	}

	return true;

}

function add_pre_inline_js($html) {
	
	global $tpl;
	
	$tpl->pre_inline_javascript .= $html;

	return true;

}


function add_post_inline_js($html) {
	
	global $tpl;

	$tpl->post_inline_javascript .= $html;

	return true;

}


function add_body_onload($html) {
	global $tpl;
	$tpl->body_onload[] = $html;
	return true;
}

function include_lib($name) {
	include_once _PATH_LIB . $name;
}

function include_interface($name) {
	include_once _PATH_INTERFACES . 'interface.' . $name . '.php';
}

function random_string($length) {
	$string = '';
	$chars = array(
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
	);
	shuffle($chars);
	for($n = 0; $n < $length; $n++) {
		$string .= $chars[array_rand($chars)];
	}
	return $string;
}

function random_istring($length) {
	$string = '';
	$chars = array(
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'
	);
	shuffle($chars);
	for($n = 0; $n < $length; $n++) {
		$string .= $chars[array_rand($chars)];
	}
	return $string;
}

function make_temp_filename($user_id, $extension) {
	global $my;
	return $my->id . '_' . random_string(rand(4,16)) .  '_' . substr(md5(microtime() * rand(0,100)), 0, rand(16, 24)) . '.' . $extension;
}

function make_filename($extension) {
	return random_string(rand(4,16)) . '_' . substr(md5(microtime() * rand(0,100)), 0, rand(16, 24)) . '.' . $extension;
}

function make_session_token() {
	return random_string(rand(24, 32));
}


function make_slug($string) {

	$slug = preg_replace('/[^a-zA-Z0-9 ]/', '', $string);
	$slug = str_replace(' ', '-', $slug);
	$slug = str_replace('--', '-', $slug);
	
	return $slug;

}


function url() {
	return SITE_URL;
}


function has_cookie($name) {
	return ((isset($_COOKIE[$name])) && (!empty($_COOKIE[$name]))) ? TRUE : FALSE;
}

function require_login() {
global $my;
	//pprint_r($my);die;

	if(!is_authorized()) {
		redirect_to('/login?redirect=' . $_SERVER['REQUEST_URI']);
	}
}

function arg($n) {
	
	global $core;
	
	if((isset($core->args[$n])) && (!empty($core->args[$n]))) {
		return $core->args[$n];
	} else {
		return false;
	}

}


function prepare_string_for_xhtml($string) {
	
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	
	return $string;
	
}

function prepare_string_for_validation($string) {

//	$string = urldecode($string);
	$string = trim($string);
	$string = strip_tags($string);
	//$string = replace_double_quotes($string);
	
	return $string;

}


function prepare_string_for_db($string) {

	$string = trim($string);
	//$string = replace_double_quotes($string);
	$string = addslashes($string);

	return $string;

}

function replace_double_quotes($string) {
	$string = str_replace("\"", "'", $string);
	return $string;
}

function c($html) {
	global $tpl;

	$tpl->content['main'] .= $html;

	return true;
}

function sb($html) {
	global $tpl;
	$tpl->content['sidebar'] .= $html;
	return true;
}


function db_alias($table) {
	global $db;
	return $db->schema->$table->alias;
}

function pprint_r($var) {
	echo '<pre>';
	print_r($var);
	echo '</pre>';
}

function strip_whitespace($v) {

	return preg_replace(_REGEX_STRIP_WHITESPACE, '', $v);

}


function time_ago($secs) {
	
	if($secs < 60) {
		return array('num' => $secs, 'units' => 1); // seconds
	} else {
		$num_mins = floor($secs / 60);
		if($num_mins < 60) {
			return array('num' => $num_mins, 'units' => 2); // minutes
		} else {
			$num_hours = floor($secs / 3600);
			if($num_hours < 24) {
				return array('num' => $num_hours, 'units' => 3); // hours
			} else {
				$num_days = floor($secs / 86400);
				if($num_days < 7) {
					return array('num' => $num_days, 'units' => 4); // days
				}
				$num_weeks = floor($secs / 604800);
				return array('num' => $num_weeks, 'units' => 5); // weeks;
			}
		}
	}
}


function format_time_ago($time_ago) {

	switch($time_ago['units']) {

		case 1: $units = ($time_ago['num'] == 1) ? 'sec'  : 'secs';  break;
		case 2: $units = ($time_ago['num'] == 1) ? 'min'  : 'mins';  break;
		case 3: $units = ($time_ago['num'] == 1) ? 'hour' : 'hours'; break;
		case 4: $units = ($time_ago['num'] == 1) ? 'day'  : 'days';  break;
		case 5: $units = ($time_ago['num'] == 1) ? 'week' : 'weeks'; break;

	}

	if(($time_ago['num'] == '0') && ($time_ago['units'] == 1)) {

		$time_ago['num'] = 1;
		$units = 'second';

	}

	return $time_ago['num'] . ' ' . $units;

}