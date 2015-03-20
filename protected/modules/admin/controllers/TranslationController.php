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
        $this->renderText('admin');
    }
    
    /**
     * Site core label translation
     */
    public function actionSite(){
        $this->renderText('site');
    }
    
}// class Translation    