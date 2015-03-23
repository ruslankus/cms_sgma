<?php

class TranslationController extends ControllerAdmin
{
 
    public function actionIndex(){
        $this->renderText('index');
    }   
    
    
    /**
     * Admin panel labels translation
     */
    public function actionAdmin(){
        $langs = AdminLanguages::model()->findAll();
        $currLang = Yii::app()->language;
        $this->render('admin_labels', array('langs'=>$langs, 'currLang' => $currLang));
    }

    /**
     * Admin panel messages translation
     */
    public function actionAdminMessages(){
        $this->render('admin_messages');
    }    


    /**
     * Site core label translation
     */
    public function actionSite(){
        $this->render('site_labels');
    }
    
}// class Translation    