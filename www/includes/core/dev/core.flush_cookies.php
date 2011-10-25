<?php

validate_included_page();

$tpl = new Template('index');

pprint_r($_COOKIE);


setcookie('s', $sess->hash, time() - 10, '/');


pprint_r($_COOKIE);