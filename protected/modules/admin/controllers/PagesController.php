<?php

class PagesController extends ControllerAdmin
{
    
    
    public function actionIndex(){
        
        $this->render('index');
        
    }//index
    
    
    public function actionCreate(){
        
    }//create
    
    
    public function actionEdit($id = null){
        $this->renderText('edit');
    }//edit
    
    public function actionDelete(){
        
    }//delete
    
    
    
}//PageController    