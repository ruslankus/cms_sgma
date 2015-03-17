<?php

class MainController extends ControllerAdmin
{
    /**
     * Index
     */
    public function actionIndex()
	{
        $this->renderText('You in ADMINKA now!!!');
	}


    /**
     * Renders login form and performs login
     */
    public function actionLogin()
    {

        if(!Yii::app()->user->isGuest)
        {
            $this->redirect(Yii::app()->createUrl('/admin/main/index'));
        }

        $form = new LoginForm();

        if($_POST['LoginForm'])
        {
            $form->attributes = $_POST['LoginForm'];

            if($form->validate() && $form->login())
            {
                $this->redirect(Yii::app()->createUrl('/admin/main/index'));
            }
        }

        $this->render('login',array('form_mdl' => $form));
    }
}