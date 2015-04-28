<?php
class MailController extends Controller
{

    public function actions()
    {
        return array(
        // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
             'class'=>'CCaptchaAction',
             'backColor'=>0xFFFFFF,
             'testLimit'=>1
            ),
        );
    }

	public function actionIndex()
	{
		//$data = Mailer::sendMail(array('name'=>'Cms user', 'mail'=>'user@test.com','subject' => 'Test Mail','body' => 'mail text entered by user in textarea'));
		//$this->renderText('testing mail = '.$data);

		
		$arrSettings = ExtSettings::model()->getSettings(true);
		print_r($arrSettings);
		//$this -> renderText('mail setting');
	}

    public function actionAjaxMailCheck()
    {
        $request = Yii::app()->request;
        $model = new SendContactForm();
        $model->email = $request->getPost('email');
        $model->text = $request->getPost('text');
        $model->code = $request->getPost('code');
        $captcha=Yii::app()->getController()->createAction("captcha");
        $code = $captcha->verifyCode;
        $entered_code =  $request->getPost('code');
        $arrJson = array();
        $arrJson['code']=$code;
        $arrJson['entered_code']=$entered_code;
        if($code != $entered_code)
        {
          $arrJson['error']=1;
          $arrJson['result'] = Trl::t()->getLabel('wrong code');
        }
        if(!($model->validate())){
          $arrJson['email']=$model->email;
          $arrJson['text']=$model->text;
          $arrJson['error']=1;
          $arrJson['result'] = Trl::t()->getLabel('mail or text eincorect');
        }

        if(!$arrJson['error']){
         //$data = Mailer::sendMail(array('name'=>'Cms user', 'mail'=>'user@test.com','subject' => 'Test Mail','body' => 'mail text entered by user in textarea'));
          $arrJson['result']=Trl::t()->getLabel('Your message send');
        }       

        echo json_encode($arrJson);
    }

}



