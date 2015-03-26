<?php

class SettingsController extends ControllerAdmin
{
 
    public function actionIndex()
    {
        $arrData = ExtSettings::model()->getSettings();
        
        $this->render('main',array('arrData' => $arrData));
      
    }
    
    
    
    public function actionEdit(){
        $request = Yii::app()->request;
        
        if(isset($_POST['save'])){
        
            $setName = $request->getPost('setting');
            $setValue = $request->getPost('value');      
            $objSet = Settings::model()->findByAttributes(array('value_name' => $setName)); 
               
            $objSet->setting = $setValue;
            
            if($objSet->save()){
                
            }else{
                //error
            }
        
       }
        
        $arrData = ExtSettings::model()->getSettings();
        
        $this->render('edit',array('arrData' => $arrData));
    }
    
}//controller       