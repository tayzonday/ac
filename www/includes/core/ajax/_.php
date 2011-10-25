<?php

validate_included_page();

$tpl = new Template('json');

$json = new Json_Response;

$json->requireLogin();

if(!isset($_POST['text']))        $json->internalError();
if(!isset($_POST['question_id'])) $json->internalError();

$text        = prepare_string_for_validation($_POST['text']);
$question_id = prepare_string_for_validation($_POST['question_id']);

/* Error codes:
   0	Internal error
   1	Success
   101	Empty Answer
   102	Invalid Question
   103	Duplicate Answer
*/

if(empty($text)) $json->addErrorAndForceOutput(101, 'Empty Answer', 'You must enter an answer');

if(empty($question_id)) $json->internalError();

$question = new Question;

if(!$question->selectById($question_id, FALSE)) {
	$json->addErrorAndForceOutput(102, 'Invalid Question', 'This question no longer exists');
}

$answer = new Answer;
if($answer->selectByField('answer_text', '=', $text)) {
	$json->addErrorAndForceOutput(103, 'Duplicate Answer', 'You have already submitted this answer');
}

$answer = new Answer;
$answer->addInsert('answer_id',                0);
$answer->addInsert('user_id',                  $my->id);
$answer->addInsert('question_id',              $question->id);
$answer->addInsert('answer_text',              $text);
$answer->addInsert('answer_slug',              '');
$answer->addInsert('answer_num_upvotes',       0);
$answer->addInsert('answer_num_downvotes',     0);
$answer->addInsert('answer_num_not_helpfuls',  0);
$answer->addInsert('answer_timestamp_created', date('U'));
$answer->addInsert('answer_timestamp_updated', date('U'));
$answer->insert();

$answer->user = $my;

$question->addUpdate('question_num_answers', 'num_answers', $question->num_answers + 1);
$question->addWhereIdIs($question->id);
$question->update();


// Send email
/*$email_template = new Email_Template;
$email_template->subject = $my->full_name . " is now following your updates on curated.by";
$email_template->body = "Hello " . $user->full_name . ",\n\nWe quickly wanted to let you know that " . $my->full_name . " is now following your updates on curated.by.\n\nYou can view their profile here: " . url() . "/" . $my->username . "\n\nThank you\n-curated-by";
$email_template->send($user->email);
*/







$json->type = "success";

$json->response->answer = array(
	'id'   => $answer->id,
	'html' => $answer->display()
);


c(json_encode($json));