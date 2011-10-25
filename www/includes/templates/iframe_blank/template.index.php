<?php

global $tpl, $my;

$o = '';
$o .= '<!DOCTYPE html>';
$o .= '<html>';
$o .= '<head>';
$o .= '<meta charset="UTF-8" />';
$o .= '<meta name="verify-v1" content="' . _GOOGLE_ANALYTICS_VERIFY_KEY . '" />';
$o .= '<title>Create Thread - ' . _SITE_TITLE . '</title>';
$o .= '</head>';

$o .= '<body>' . $tpl->displayContent('main') . '<script>' . $tpl->displayContent('main') . '</script></body></html>';

$o = strip_whitespace($o);

die($o);
