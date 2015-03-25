<?php

class SettingsController extends ControllerAdmin
{
 
    public function actionIndex()
    {
        $arrData = ExtSettings::model()->getSettings();
        
        $this->render('main',array('arrData' => $arrData));
      
    }
    
    
    
    public function actionEdit(){
        
        if(!empty($_POST)){
            Debug::d($_POST);
        }
        
        //$objSet = Settings::model()->findByAttributes(array('value_name' => 'setting2'));
       
        //$objSet->setting = "changed_value";
        
       
        
        $arrData = ExtSettings::model()->getSettings();
        
        $this->render('edit',array('arrData' => $arrData));
    }
    
}//controller       