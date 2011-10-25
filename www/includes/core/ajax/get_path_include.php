<?php

validate_included_page();

$tpl = new Template('json');

$json = new JsonResponse;

ajax_session_recheck($json);

if(!isset($_POST['path'])) $json->internalError();

$path = prepare_string_for_validation($_POST['path']);

/* Error codes:
   0	Internal error
   1	Success
   101
*/


$args = explode('/', $path);

global $args;

//pprint_r($args);

switch($args[1]) {

	case 'help': $target = 'help'; break;
	

	case '': $target = 'index'; break;
	
	case 'register':   $target = 'register';   break;
	case 'topics':     $target = 'topics';     break;
	case 'registered': $target = 'registered'; break;
	case 'logout':     $target = 'logout';     break;
	case 'logged-out': $target = 'logged_out'; break;
	case 'login':      $target = 'login';      break;


	default:
	
		$topic = new Topic;
		if($topic->selectByField('topic_slug', '=', $args[1])) {
			$target = 'view_topic';
			
			if(isset($args[2])) {
			
				if(in_array($args[2], array('new', 'create', 'add', 'submit'))) {
					$target = 'create_thread'; break;
				}
			
				$thread = new Thread;
				if($thread->selectByField('post_id', '=', $args[2])) {
					$target = 'view_thread'; break;
				}
				
			}
			
			break;
			
			
		}
		
		
		break;
	
}

if(isset($target)) {
	include_once _PATH_CORE . 'ajax/pages/' . $target . '.php';
} else {
	$json->internalError();
}


$json->type = 1;

c(json_encode($json));