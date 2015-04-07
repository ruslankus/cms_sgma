<?php
Yii::import('application.vendor.*');
require_once('phpmailer/class.phpmailer.php');

class Mailer {
/*
	example of params
	array('name'=>'Cms user', 'mail'=>'user@test.com','subject' => 'Test Mail','body' => 'mail text entered by user in textarea');
	link for test: site.root/maxim

*/
	public static function sendMail($params)
	{
		
		$mail = new PHPMailer;
/*
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Host       = "mail.yourdomain.com"; // sets the SMTP server
		$mail->Port       = 26;                    // set the SMTP port for the GMAIL server
		$mail->Username   = "yourname@yourdomain"; // SMTP account username
		$mail->Password   = "yourpassword";        // SMTP account password

*/
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