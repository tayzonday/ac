<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(0);
session_start();
ini_set('memory_limit', '128M');

$root = './';

include_once './includes/config.php';

include_once _PATH_INCLUDES . 'setup.php';

unset($db);
