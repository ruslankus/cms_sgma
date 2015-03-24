<?php

class PagesController extends ControllerAdmin
{
    
    
    public function actionIndex($siteLng = null){
        
        $currLng = Yii::app()->language;
        
        if(empty($siteLng)){
            $siteLng = Yii::app()->language; 
        }
        
        $objPages = Page::model()->with(array('pageTrls.lng' => array('condition' => "lng.prefix='{$siteLng}'")))->findall();
        
        //Debug::d($objPages);
                
        $this->render('index',array('objPages' => $objPages, 'currLng' => $currLng));
        
    }//index
    
    
    public function actionCreate(){
        
    }//create
    
    
    public function actionEdit($id = null){
        
         if(empty($siteLng)){
            $siteLng = Yii::app()->language; 
        }
        
       
        $objPage = ExtPage::model()->findByPk($id,"",array(array(':lng' => 'ru')));
        
         //Debug::d($objPage->trl);
        
        $this->render('edit', array('objPage' => $objPage));
    }//edit
    
    public function actionDelete(){
        
    }//delete
    
    
    
}//PageController    