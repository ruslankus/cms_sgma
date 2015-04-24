<?php

class TestController extends Controller
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

    public function actionCheckClass()
    {
      if(class_exists('CCaptchaAction'))
      {
        $this->renderText('classExist');
      }
    }

/*
    public function actionCaptcha()
    {
      $capt = new CCaptchaAction();
      return $capt;
    }
    */
    public function actionIndex()
    {
    	//$this->layout = "site";

        $model = new SendContactForm();
        //$this->renderText("Hello world");
        $this->render('test',array('model'=>$model));
        
    }

}