<?php

class TranslationController extends ControllerAdmin
{
 
    public function actionIndex()
    {
        //$this->renderText('index');
        $this->redirect(array('admin'));
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
            $retData = $this->renderPartial('_admin_labels',array('arrLabel' => $arrLabel,
                    'arrSelect' => $arrSelect,'lang_prefix' => $lang_prefix,'select_lng' => $select_lng,
                    'search_val' => $search_label)); 
            echo $retData;
            
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
    public function actionAdminMessages()
    {
        $this->render('admin_messages');
    }    


    /**
     * Site core label translation
     */
    public function actionSite()
    {
        $this->render('site_labels');
    }
    
    public function actionAddAdminLabel()
    {
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        if($request->isAjaxRequest)
        {
            $resArr=array();
            $resArr['html'] = $this->renderPartial('_addLabel',array('lang_prefix'=>$lang_prefix),true);
            echo json_encode($resArr);
        } else{
            $label = $request->getPost('label_name');
            $arrLng = ExtAdminLanguages::model()->getAllLang();
            ExtAdminLabels::model()->addLabel($label,$arrLng);
            $this->redirect(array('admin')); 
        }
    }

    public function actionUniqueCeckAdminLabel(){
        $label = $_POST['label'];
        $arrJson = array();
        if(!empty($label))
        {
            if($user = AdminLabels::model()->exists('label=:label',array('label'=>$label)))
            {
                $arrJson['status'] = "error";
                $arrJson['err_txt'] = Trl::t()->getMsg("Duplicate error");
                echo json_encode($arrJson);
            }
            else
            {
                $arrJson['status'] = "success";
                echo json_encode($arrJson);
            }      
        }
        else
        {
            $arrJson['status'] = "error";
            $arrJson['err_txt'] = Trl::t()->getMsg("Label empty");
            echo json_encode($arrJson);
        }  
    }

    public function actionDelAdminLabel($id = null){
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        
         if($request->isAjaxRequest){
            $id = $request->getPost('id');
            $name = $request->getPost('name');
            $resArr=array();
            $resArr['html'] = $this->renderPartial('_deleteLabel',array('lang_prefix' =>$lang_prefix,
                        'id'=>$id,'label_name' => $name),true);
            echo json_encode($resArr);
         }else{
            $objLabel = AdminLabels::model()->findByPk($id);
            $objLabel->delete();
            ExtAdminLabels::model()->deleteLabel($id);
            $this->redirect(array('admin'));
         }
        
    }

    public function actionSaveAdminLabel($id = null){
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            $curr_lng = $request->getPost('curr_lng');
            $value_label = trim($request->getPost('value'));
            
            $objLabel = AdminLabelsTrl::model()->findByPk((int)$id);
           
            $objLabel->value = $value_label;
            $objLabel->save();
             
        }
    }//SaveAdminLabel

}// class Translation    