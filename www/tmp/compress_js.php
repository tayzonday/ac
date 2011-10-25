<?php

$lib_path = '../lib-uncompressed/index/';

$files = array(
	'header_and_config.js',

	'classes/class.Template.js',
	'classes/class.DOMElement.js',
	'classes/class.SidebarMenu.js',
	'classes/class.FollowedTopicsSidebarMenu.js',
	'classes/class.SidebarMenuItem.js',
	'classes/class.PageManager.js',
	'classes/class.AjaxRequest.js',
	'classes/Page/class.Page.js',
	'classes/Page/class.TopicListingPage.js',
	'classes/Listing/class.Listing.js',
	'classes/Listing/class.TopicListing.js',
	'classes/Topic/class.Topic.js',
	'classes/Topic/class.TopicForListing.js',

	'general_functions.js',
	'prototype_functions.js',
	'footer.js',
);

$js = '';

/*$js .= '

var a = {a:0,b:"hI8MWt9T3GMsgEQO8Mc7bwRHyUri",c:"jo57iu4gppxf9smcst9x71tmrkrr",d:0,e:0,f:[{"id":"3","title":"Random","href":"Random","icon":"\/assets\/topic-icons\/icon-random-16x16.png","num":0},{"id":"13","title":"Pics","href":"Pics","icon":"\/assets\/topic-icons\/icon-pics-16x16.png","num":0},{"id":"14","title":"Videos","href":"Videos","icon":"\/assets\/topic-icons\/icon-videos-16x16.png","num":0},{"id":"5","title":"Gaming","href":"Gaming","icon":"\/assets\/topic-icons\/icon-gaming-16x16.png","num":0},{"id":"6","title":"Technology","href":"Technology","icon":"\/assets\/topic-icons\/icon-technology-16x16.png","num":0},{"id":"12","title":"Music","href":"Music","icon":"\/assets\/topic-icons\/icon-music-16x16.png","num":0},{"id":"16","title":"World News","href":"World-News","icon":"\/assets\/topic-icons\/icon-world-news-16x16.png","num":0},{"id":"17","title":"WTF","href":"WTF","icon":"\/assets\/topic-icons\/icon-wtf-16x16.png","num":0},{"id":"18","title":"Suggestions","href":"Suggestions","icon":"\/assets\/topic-icons\/icon-suggestions-16x16.png","num":0}],g:[],h:[]};

';*/





foreach($files as $file) {
	$js .= file_get_contents($lib_path . $file);
}

echo '<div style="border:1px solid red;width:49%;overflow:scroll;float:left;">
<pre>';

print_r($js);

echo '</pre>
</div>';

$c_js = $js;

// Remove console.log() statements
$c_js = preg_replace('/console\.log\(.+\);/', '', $c_js);

// Remove // comments
$c_js = preg_replace('/\/\/.*$/m', '', $c_js);

// Remove // comments
$c_js = preg_replace('!/\*.*?\*/!s', '', $c_js);
//$c_js = preg_replace('/\n\s*\n/', "\n", $c_js); // Caused problems. Do not use

// Replace template_settings
$c_js = str_replace('template_settings', '_a', $c_js);

// Replace Wirah
$c_js = str_replace('var Wirah', 'var b', $c_js);
$c_js = str_replace('Wirah.', 'b.', $c_js);

// Replace Wirah.config
$c_js = str_replace('config:{', 'a:{', $c_js);
$c_js = str_replace('b.config', 'b.a', $c_js);

// Replace Wirah.config.template 
$c_js = str_replace('template:{', 'a:{', $c_js);
$c_js = str_replace('b.a.template', 'b.a.a', $c_js);

// Replace Wirah.config.general 
$c_js = str_replace('general:{', 'b:{', $c_js);
$c_js = str_replace('b.a.general', 'b.a.b', $c_js);

// Replace template settings
$c_js = str_replace('userLoggedIn',             'a', $c_js);
$c_js = str_replace('webSocketValidationToken', 'b', $c_js);
$c_js = str_replace('sessionHash',              'c', $c_js);
$c_js = str_replace('numTopicReplies',          'd', $c_js);
$c_js = str_replace('numPostMentions',          'e', $c_js);
$c_js = str_replace('followedTopics',           'f', $c_js);
$c_js = str_replace('myThreads',                'g', $c_js);
$c_js = str_replace('followedThreads',          'h', $c_js);

// Replace general settings
$c_js = str_replace('assetReleaseId',      'a', $c_js);
$c_js = str_replace('documentTitleSuffix', 'b', $c_js);
$c_js = str_replace('shortWeekdays',       'c', $c_js);
$c_js = str_replace('defaultFavicon',      'd', $c_js);
$c_js = str_replace('passwordMinLength',   'e', $c_js);
$c_js = str_replace('passwordMaxLength',   'f', $c_js);
$c_js = str_replace('threadTextMaxLength', 'g', $c_js);

// hasClass prototype
$c_js = str_replace('Node.prototype.hasClass = function (_class_name) {', 'Node.prototype.a = function (_a) {', $c_js);
$c_js = preg_replace('/_class_name/', '_a', $c_js, 1);
$c_js = str_replace('.hasClass(', '.a(', $c_js);

// addClass prototype
$c_js = str_replace('Node.prototype.addClass = function (_class_name) {', 'Node.prototype.b = function (_a) {', $c_js);
$c_js = preg_replace('/_class_name/', '_a', $c_js, 2);
$c_js = str_replace('.addClass(', '.b(', $c_js);

// removeClass prototype
$c_js = str_replace('Node.prototype.removeClass = function (_class_name) {', 'Node.prototype.c = function (_a) {', $c_js);
$c_js = preg_replace('/_class_name/', '_a', $c_js, 2);
$c_js = str_replace('.removeClass(', '.c(', $c_js);

// replaceClass prototype
$c_js = str_replace('Node.prototype.replaceClass = function (_class_name, _replacement_class_name) {', 'Node.prototype.d = function (_a, _b) {', $c_js);
$c_js = preg_replace('/_class_name/', '_a', $c_js, 1);
$c_js = preg_replace('/_replacement_class_name/', '_b', $c_js, 1);
$c_js = str_replace('.replaceClass(', '.d(', $c_js);

// addEvent prototype
$c_js = str_replace('Node.prototype.addEvent = function (_type, _func, _uc) {', 'Node.prototype.e = function (_a, _b, _c) {', $c_js);
$c_js = preg_replace('/_type/', '_a', $c_js, 2);
$c_js = preg_replace('/_func/', '_b', $c_js, 2);
$c_js = preg_replace('/_uc/', '_c', $c_js, 1);
$c_js = str_replace('.addEvent(', '.e(', $c_js);

// removeEvent prototype
$c_js = str_replace('Node.prototype.removeEvent = function (_type, _func) {', 'Node.prototype.f = function (_a, _b) {', $c_js);
$c_js = preg_replace('/_type/', '_a', $c_js, 3);
$c_js = preg_replace('/_func/', '_b', $c_js, 3);
$c_js = str_replace('.removeEvent(', '.f(', $c_js);

// replaceEvent prototype
$c_js = str_replace('Node.prototype.replaceEvent = function (_type, _func, _replacement_func, _uc) {', 'Node.prototype.g = function (_a, _b, _c, _d) {', $c_js);
$c_js = preg_replace('/_type/', '_a', $c_js, 2);
$c_js = preg_replace('/_func/', '_b', $c_js, 1);
$c_js = preg_replace('/_replacement_func/', '_c', $c_js, 1);
$c_js = preg_replace('/_uc/', '_d', $c_js, 1);
$c_js = str_replace('.replaceEvent(', '.g(', $c_js);



// Wirah.init
//$c_js = str_replace('init: function () {', 'b: function () {', $c_js);

// pageManager class
//$c_js = str_replace('function PageManager', 'function b', $c_js);
//$c_js = str_replace('b.pageManager', 'b.b', $c_js);
//$c_js = str_replace('new PageManager', 'new b', $c_js);


echo '<div style="border:1px solid green;width:49%;overflow:scroll;float:right;word-wrap:break-word;">
<pre>';

print_r($c_js);

$s_c_js = preg_replace('/([\t\r\n]|\s{2,})/', '', $c_js);

$s_c_js = str_replace(' {', '{', $s_c_js);
$s_c_js = str_replace('{ ', '{', $s_c_js);
$s_c_js = str_replace(' =', '=', $s_c_js);
$s_c_js = str_replace('= ', '=', $s_c_js);
$s_c_js = str_replace(' :', ':', $s_c_js);
$s_c_js = str_replace(': ', ':', $s_c_js);
$s_c_js = str_replace(' !=', '!=', $s_c_js);
$s_c_js = str_replace('!= ', '!=', $s_c_js);
$s_c_js = str_replace(' &&', '&&', $s_c_js);
$s_c_js = str_replace('&& ', '&&', $s_c_js);


//print_r($s_c_js);

echo '</pre>
</div>';


$fp = fopen('../lib/index/index.js', 'w');
fwrite($fp, $c_js);
fclose($fp);





/*
$js_urlencoded = urlencode($js);


$params = array(
	'http' => array(
		'method' => 'POST',
		'content' => 'output_format=json&output_info=compiled_code&output_info=warnings&output_info=errors&output_info=statistics&compilation_level=ADVANCED_OPTIMIZATIONS&warning_level=verbose&output_file_name=default.js&js_code=' . $js_urlencoded
	)
);

if ($optional_headers !== null) {
	$params['http']['header'] = $optional_headers;
}
$ctx = stream_context_create($params);
$fp = @fopen('http://closure-compiler.appspot.com/compile', 'rb', false, $ctx);
if (!$fp) {
	throw new Exception("Problem with http://closure-compiler.appspot.com/compile, $php_errormsg");
}
$response = @stream_get_contents($fp);
if ($response === false) {
  throw new Exception("Problem reading data from $url, $php_errormsg");
}

$decoded_response = json_decode($response);

echo '<a href="http://closure-compiler.appspot.com/' . $decoded_response->outputFilePath . '">File</a>';

//echo "<br><br><br><br><br><br><br><br>";
//echo "<pre>";
//print_r(json_decode($response));
//echo "</pre>";

//$result = file('?&);

print_r($result);*/



?></pre>