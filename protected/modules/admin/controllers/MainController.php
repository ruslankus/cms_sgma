<?php

class MainController extends ControllerAdmin
{
    /**
     * Index
     */
    public function actionIndex()
	{
        $this->render('index');
	}


    /**
     * Renders login form and performs login
     */
    public function actionLogin()
    {
        //use 'login' layout for this action
        $this->layout = '/layouts/login';

        //set page description
        $this->description = "Login";

        
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

    /**
     * Logout - just performs logout and redirects back to login
     */
    public function actionLogout()
    {
        Yii::app()->user->logout(false);
        $this->redirect(Yii::app()->createUrl('/admin/main/login'));
    }
}