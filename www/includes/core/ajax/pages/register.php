<?php

$json->response->page_id = 4;

$json->response->page_title = 'Register';
$json->response->document_title = 'Register';

$json->response->path = '/register';

$json->response->html = '';

if($my->is_logged_in) {

	$json->response->html .= '
	
	<p>You are already logged in with <strong>' . $my->formatted_card_key . '</strong>.</p>
	
	<p><a href="/logout">Click here to logout.</a></p>
	
	';

} else {

	$json->response->html .= '

	<p>You have been assigned the 16 digit key below:</p>

	<p class="px14 bold">' . $my->formatted_card_key . '</p>

	<p><a id="generate-new-key" href="javascript:;">Click here to generate a new key</a> and reset your session (followed topics/threads will be lost).</p>

	<form id="register-form" action="javascript:;">

		<div id="register-console" class="fail hidden">
			<p></p>
		</div>
		
		<div class="clear"></div>
		
		<label for="register-key" class="field">
			Key
		</label>
		<div class="value">
			<p>' . $my->formatted_card_key . '</p>
		</div>
		
		<div class="clear"></div>

		<label for="register-password" class="field">
			Password
		</label>
		<div class="value">
			<input id="register-password" type="password" class="small" maxlength="24" />		
		</div>
		
		<div class="clear"></div>

		<label for="register-verify-password" class="field">
			Verify Password
		</label>
		<div class="value">
			<input id="register-verify-password" type="password" class="small" maxlength="24" />		
		</div>
		
		<div class="clear"></div>

		<button id="register-submit">Register</button>

	</form>

	<p><em>Registration is entirely optional.</em></p>

	<p>After registering and logging in you will still post as Anonymous.</p>

	<p>Your key simply acts as a pointer to which threads and topics you follow so we may remember you on your next visit.</p>

	<p>In the future, login with the details above and your session will be restored.</p>
	
	';
	
}





