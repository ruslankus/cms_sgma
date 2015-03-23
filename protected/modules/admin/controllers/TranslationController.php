<?php

class TranslationController extends ControllerAdmin
{
 
    public function actionIndex(){
        $this->renderText('index');
    }   
    
    
    /**
     * Admin panel translation
     */
    public function actionAdmin(){
        $this->render('admin');
    }
    
    /**
     * Site core label translation
     */
    public function actionSite(){
        $this->render('site');
    }
    
}// class Translation    