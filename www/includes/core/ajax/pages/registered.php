<?php

$json->response->page_id = 6;

$json->response->page_title = 'Registered';
$json->response->document_title = 'Registered';

$json->response->path = '/registered';

$json->response->html = '';


if($my->is_logged_in) {

	$json->response->html .= '

	<p>Thank you for registering. You have been logged in.</p>
	
	<p>Please make a note of your login details.</p>
	
		<form id="registered-form" action="javascript:;">

		<label for="registered-key" class="field">
			Key
		</label>
		<div class="value">
			<p>' . $my->formatted_card_key . '</p>
		</div>
		
		<div class="clear"></div>

		<label for="registered-password" class="field">
			Password
		</label>
		<div class="value">
			<em>(hidden)</em>
		</div>

	</form>
	
	<p>You can now browse the <a href="/topics">Topics</a> listing and follow the boards that interest you.</p>


	';
	
} else {

	$json->response->html .= '
	
	<p>You are not logged in.</p>
	
	<p><a href="/login">Click here to login.</a></p>
	
	';

}