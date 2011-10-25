<?php

global $tpl;

header('Content-Type: application/json');

$json = $tpl->displayContent('main');

die($json);

?>