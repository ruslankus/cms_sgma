<?php
Yii::import('application.vendor.*');
require_once('phpmailer/class.phpmailer.php');

class Mailer {

	public static function sendMail($params)
	{
		
		$mail = new PHPMailer;

		//$mail->AddReplyTo($to,"Reply toto");
		 
		$mail->SetFrom('cms@cms.com', 'ContactForm');
		 
		//$mail->AddReplyTo("cms@cms.com","reply to me");
		 
		$mail->AddAddress($params['mail'], $params['name']);
		
		$mail->Subject    = $params['subject'];
		$mail->MsgHTML($params['body']);
		 
		if(!$mail->Send()) {
		return "Mailer Error: " . $mail->ErrorInfo;
		} else {
		return "Message sent!";
		}
		//return "mail send to:".$to." subject:".$subject." body:".$body;
	}

}