<?php
class MailController extends Controller
{
	public function actionIndex()
	{
		//$data = Mailer::sendMail(array('name'=>'Cms user', 'mail'=>'user@test.com','subject' => 'Test Mail','body' => 'mail text entered by user in textarea'));
		//$this->renderText('testing mail = '.$data);

		
		$arrSettings = ExtSettings::model()->getSettings(true);
		print_r($arrSettings);
		//$this -> renderText('mail setting');
	}
}