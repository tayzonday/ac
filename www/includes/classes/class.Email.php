<?php

class Email {

	public $subject;
	public $body;
	public $html;
	public $from_name;
	public $from_email;
	public $footer;
	public $variables;
	public $mail_line;
	public $is_html;
	
	public function __construct() {
		
		include_lib('Swift-4.0.6/lib/swift_required.php');
		
		$this->subject    = (string) '';
		$this->body       = (string) '';
		$this->html       = (string) '';
		$this->from_name  = (string) 'AskFanboy';
		$this->from_email = (string) 'feedback@askfanboy.com';
		$this->footer     = (string) '';
		$this->variables  = (array) array();
		$this->mail_line  = (string) '******************************';
		$this->is_html    = (bool) FALSE;

	}

	function send($recipient) {
		
		if($this->is_html) {
			$this->html = $this->body;	
		}

		$this->body = $this->body . "

" . $this->footer;

		$transport = Swift_SmtpTransport::newInstance(_SENDGRID_SERVER, _SENDGRID_PORT);
		$transport->setUsername(_SENDGRID_USER);
		$transport->setPassword(_SENDGRID_PASS);
		$swift = Swift_Mailer::newInstance($transport);

		// Create a message (subject)
		$message = new Swift_Message($this->subject);
 
		// attach the body of the email
		$message->setFrom(array($this->from_email => $this->from_name));
		$message->setBody($this->html, 'text/html');
		$message->setTo(array($recipient));
		$message->addPart($this->body, 'text/plain');
 
		// send message 
		$recipients = $swift->send($message, $failures);
		
		$cc_body = "Originally sent to: $recipient\n\n" . $this->body;
		
		mail('samstr@gmail.com', 'CC via mail(): ' . $this->subject, $cc_body, 'From: ' . $this->from);

		return TRUE;

	}
	
}

?>