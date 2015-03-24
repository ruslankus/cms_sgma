<?php

class TranslationController extends ControllerAdmin
{
 
    public function actionIndex(){
        $this->renderText('index');
    }   
    
    
    /**
     * Admin panel labels translation
     */
    public function actionAdmin()
    {
        /*
        $langs = AdminLanguages::model()->findAll();
        $currLang = Yii::app()->language;
        $this->render('admin_labels', array('langs'=>$langs, 'currLang' => $currLang));
        */
        $request = Yii::app()->request;
        $lang_prefix = Yii::app()->language;
        $arrSelect = ExtAdminLanguages::model()->selectArray();    
        
        if($request->isAjaxRequest){
            
            $select_lng = $request->getPost('lng');
            $search_label = $request->getPost('search_val');
            
            $arrLabel = ExtAdminLanguages::model()->getLabels($select_lng,array('search_label' => $search_label));
            $retData = $this->renderPartial('_trl_list',array('arrLabel' => $arrLabel,
                    'arrSelect' => $arrSelect,'lang_prefix' => $lang_prefix,'select_lng' => $select_lng,
                    'search_val' => $search_label)); 
            echo $retData;
            exit();
        }else{
            
            if(empty($curr_lng)){
               $curr_lng = $lang_prefix; 
            }
            $search_label = $request->getPost('search_label');  
            $arrLabel = ExtAdminLanguages::model()->getLabels($curr_lng, array('search_label' => $search_label));

           
            $this->render('admin_labels',array('arrLabel' => $arrLabel,
                    'arrSelect' => $arrSelect,'lang_prefix' => $lang_prefix,'select_lng' => $curr_lng,
                    'search_val' => $search_label)); 
            
        }
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