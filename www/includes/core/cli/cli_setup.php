<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(0);
ini_set('memory_limit', '128M');


define('_DB_HOST', 'ec2-184-72-246-251.compute-1.amazonaws.com');
define('_DB_USER', 'curated');
define('_DB_PASS', 'curated');
define('_DB_NAME', 'old');

function __autoload($class) {
	require '../../classes/class.' . $class . '.php';
}
