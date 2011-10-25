<?php

$json->response->page = new StdClass;

$json->response->page->id      = 9;
$json->response->page->title   = 'Login';
$json->response->page->heading = 'Login';
$json->response->page->path    = '/login';

$json->response->html = '';

if(is_authorized()) {

	$json->response->html .= '<p>You are already logged in with <strong>' . $my->formatted_card_key . '</strong>.</p>
	
	<p><a href="/logout">Click here to logout.</a></p>
	
	';

} else {

	$json->response->html .= '
	
	<p>Please login with your key and password below:</p>
	
	<form class="login" action="javascript:;">
	
		<div class="inner">

		<div class="console fail hidden">
			<p></p>
		</div>

		<div class="clear"></div>

		<label for="login-key" class="field">Key</label>
		<div class="value"><input id="login-key" type="text" class="small key" maxlength="20" /></div>

		<div class="clear"></div>

		<label for="login-password" class="field">Password</label>
		<div class="value"><input id="login-password" type="password" class="small password" maxlength="24" /></div>
		
		<div class="clear"></div>

		<button class="submit">Login</button>
		
		</div>

	</form>';
	
}