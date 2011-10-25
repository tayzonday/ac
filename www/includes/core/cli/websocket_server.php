<?php

include_once 'cli_setup.php';

$server = new WebSocketServer('www.wirah.com', 8001, false);
$server->run();

