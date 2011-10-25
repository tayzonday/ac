<?php

validate_included_page();

$tpl = new Template('json');

$json = new JsonResponse;

ajax_session_recheck($json);

if(!isset($_POST['topic-id'])) $json->internalError();

$topic_id = prepare_string_for_validation($_POST['topic-id']);

/* Error codes:
   0	Internal error
   1	Success
   101	Invalid Topic

*/

$topic = new Topic;
if(!$topic->selectByField('topic_id', '=', $topic_id)) $json->addErrorAndForceOutput(101, 'Invalid Topic', 'This topic may no longer exist.');

$json->type = 'success';

$json->response->modal = new StdClass;

$json->response->modal->id = 1;

$json->response->modal->heading = 'Create Thread';

$json->response->modal->html = '
	
<form id="create-thread-form" action="/create-thread" method="POST" enctype="multipart/form-data" target="create-thread-form-target" data-topic-id="' . $topic_id . '">

	<div id="create-thread-form-console" class="fails hidden"></div>

	<iframe id="create-thread-form-target"></iframe>
	
	<input id="create-thread-form-topic-id" type="hidden" name="topic-id" value="' . $topic_id . '"></input>
	
	<div class="row">
		<div class="field">
			<label for="create-thread-form-subject">Subject</label>
		</div>
		<div class="value">
			<input id="create-thread-form-subject" type="text" name="subject" maxlength="' . _THREAD_SUBJECT_MAX_LENGTH . '"></input>
		</div>
	</div>

	<div class="row">
		<div class="field">
			<label for="create-thread-form-text">Text</label>
		</div>
		<div class="value">
			<textarea id="create-thread-form-text" name="text"></textarea>
		</div>
	</div>
	
	<div class="row-double">
		<div class="field">
			<label for="create-thread-form-image">Image</label>
		</div>
		<div class="value">
			<input id="create-thread-form-image" type="file" name="image"></input>
		</div>
	</div>
	
	<div class="row">
		<div class="field"></div>
		<div class="value">
			<input id="create-thread-form-goto-after-create" type="checkbox" name="goto-after-create" checked="checked"> <label for="create-thread-form-goto-after-create">Take me to the thread.</label>
		</div>
	</div>

</form>
	
';

//	var button = document.createElement('button')
//	button.id = 'create-thread-form-submit';
//	button.innerHTML = 'Create Thread';
//	form.appendChild(button);

//	var inner_content = document.getElementById('inner-content');	
//	inner_content.insertBefore(form, inner_content.firstChild);


c(json_encode($json));