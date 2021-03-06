<?php
class MailController extends Controller
{

    public function actions()
    {
      /**
        * generates captcsas actions for contact widgets
        *
      */
        $captchas = array();
        $arrWidForm = SystemWidget::model()->findAll('type_id=8');  
        foreach($arrWidForm as $wid):
            $captchas['captcha'.$wid->id]=array(
               'class'=>'CCaptchaAction',
               'backColor'=>0xFFFFFF,
               'testLimit'=>1
            );
        endforeach;
        return($captchas); 
    }

	public function actionIndex()
	{
		//$data = Mailer::sendMail(array('name'=>'Cms user', 'mail'=>'user@test.com','subject' => 'Test Mail','body' => 'mail text entered by user in textarea'));
		//$this->renderText('testing mail = '.$data);

		
		$arrSettings = ExtSettings::model()->getSettings(true);
		print_r($arrSettings);
		//$this -> renderText('mail setting');
	}

    public function actionAjaxMailWidgetCheck($id)
    {
        $request = Yii::app()->request;
        $model = new SendContactWidgetForm();
        $model->email = $request->getPost('email');
        $model->text = $request->getPost('text');
        $model->code = $request->getPost('code');
        $model->name = $request->getPost('name');
        $captcha=Yii::app()->getController()->createAction("captcha".$id);
        $code = $captcha->verifyCode;
        $entered_code =  $request->getPost('code');
        $arrJson = array();
        $arrJson['captcha']=$captcha;
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



