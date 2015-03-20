<?php

class TranslationController extends ControllerAdmin
{
 
    public function actionIndex(){
        echo 'index';
    }   
    
    
    /**
     * Admin panel translation
     */
    public function actionAdmin(){
        echo 'admin';
    }
    
    /**
     * Site core label translation
     */
    public function actionSite(){
        echo 'site';
    }
    
}// class Translation    