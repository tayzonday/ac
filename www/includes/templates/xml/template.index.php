<?php

global $tpl;

header('Content-Type: text/xml');

$xml = $tpl->displayContent('main');

echo $xml;

?>