<?php

global $tpl;

header('Content-Type: application/javascript');

$json = $tpl->displayContent('main');

die($json);

