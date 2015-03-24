<?php

class PagesController extends ControllerAdmin
{
    
    
    public function actionIndex($siteLng = null){
        
        if(empty($siteLng)){
            $siteLng = Yii::app()->language; 
        }
        
        $objPages = Page::model()->with(array('pageTrls.lng' => array('condition' => "lng.prefix='{$siteLng}'")))->findall();
        
        //Debug::d($objPages);
                
        $this->render('index',array('objPages' => $objPages));
        
    }//index
    
    
    public function actionCreate(){
        
    }//create
    
    
    public function actionEdit($id = null){
        
         if(empty($siteLng)){
            $siteLng = Yii::app()->language; 
        }
        
        //$objPage = Page::model()->with(array('pageTrls.lng' => array('condition' => "lng.prefix='{$siteLng}'")))->find(array(':id'=>array(':id' => $id)));
        $objPage = Page::model()->with('pageTrls.lng')->findByPk($id);
         Debug::d($objPage->pageTrls(array('condition' => "lng.prefix='{$siteLng}'")));
        
        $this->renderText('edit');
    }//edit
    
    public function actionDelete(){
        
    }//delete
    
    
    
}//PageController    