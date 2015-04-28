<?php
class MailController extends Controller
{
    /********************** main section **********************************/

	public function actionIndex()
	{
       // $this->renderText('test mail coontroller');
	}

	/*
	Actions for captcha
	*/

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
	/*
	END Actions for captcha
	*/

    /********************** END main section **********************************/


    /********************** Ajax section **********************************/

    public function actionAjaxContactFormMail()
    {
        $request = Yii::app()->request;
        $model = new SendContactForm();
        $model->name = $request->getPost('name');
        $model->email = $request->getPost('email');
        $model->text = $request->getPost('text');
        $model->code = $request->getPost('code');
        $captcha=Yii::app()->getController()->createAction("captcha");
        $code = $captcha->verifyCode;
        $entered_code =  $request->getPost('code');
        $arrJson = array();
        $arrJson['code']=$code;
        $arrJson['entered_code']=$entered_code;
        // error captcha check
        if($code != $entered_code)
        {
          $arrJson['error']=1;
          $arrJson['result'] = Trl::t()->getLabel('wrong code');
        }
        // error other form fielsd check check
        if(!($model->validate())){
          $arrJson['email']=$model->email;
          $arrJson['text']=$model->text;
          $arrJson['name']=$model->name;
          $arrJson['error']=1;
          $arrJson['result'] = Trl::t()->getLabel('mail or text incorect');
        }
        // if no error send mail
        if(!$arrJson['error']){
		  $params = array(
		  				'name'=> $model->name, 
		  				'mail'=> $model->email,
		  				'subject' => Trl::t()->getLabel('new contact form message'),
		  				'body' =>  $model->text
		  			);

		  $mail_send = Mailer::sendMail($params);

		  // return result message 

		  if($mail_send)
		  {
          	$arrJson['result']=Trl::t()->getLabel('Your message send');
          }
          else
          {
          	$arrJson['result']=Trl::t()->getLabel('Mail server error');
          }
        }       

        echo json_encode($arrJson);
    }
    /********************** END Ajax section **********************************/
}



