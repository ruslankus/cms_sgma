<?php

class AjaxController extends ControllerAdmin
{
    public function actionAdmin($sel_lng=null)
    {
        /*
        $langs = AdminLanguages::model()->findAll();
        $currLang = Yii::app()->language;
        $this->render('admin_labels', array('langs'=>$langs, 'currLang' => $currLang));
        */
        $request = Yii::app()->request;
        $lang_prefix = Yii::app()->language;
        $arrSelect = ExtAdminLanguages::model()->selectArray();    
        $curr_page = $request->getPost('curr_page');
        if(empty($curr_page))
        {
            $curr_page=1;
        }
        if($request->isAjaxRequest){
            
            $select_lng = $request->getPost('lng');
            $search_label = $request->getPost('search_val');
            
            $arrLabel = ExtAdminLabels::model()->getLabels($select_lng,array('search_label' => $search_label));

            $pager = CPaginator::getInstanse($arrLabel,10,$curr_page);
            $retData = $this->renderPartial('_admin_labels',array('arrLabel' => $arrLabel,
                    'arrSelect' => $arrSelect,'lang_prefix' => $lang_prefix,'select_lng' => $select_lng,
                    'search_val' => $search_label, 'pager'=>$pager)); 
            echo $retData;
            
        }else{
            
            if(empty($curr_lng)){
               $curr_lng = $lang_prefix; 
            }

            if(!empty($sel_lng)){
                $curr_lng = $sel_lng;   
            }
            $search_label = $request->getPost('search_label');  
            $arrLabel = ExtAdminLabels::model()->getLabels($curr_lng, array('search_label' => $search_label));

            $pager = CPaginator::getInstanse($arrLabel,10,$curr_page);
            //$prepPages = $pager->getPreparedArray();

            $this->render('admin_labels',array('arrLabel' => $arrLabel,
                            'arrSelect' => $arrSelect,'lang_prefix' => $lang_prefix,'select_lng' => $curr_lng,
                            'search_val' => $search_label,'pager'=>$pager)); 
            
        }
    }

    public function actionAddAdminLabel()
    {
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        if($request->isAjaxRequest)
        {
            $sel_lng = $request->getPost('sel_lng');
            $resArr=array();
            $resArr['html'] = $this->renderPartial('_addLabel',array('lang_prefix'=>$lang_prefix, 'sel_lng'=>$sel_lng),true);
            echo json_encode($resArr);
        } else{
            $label = $request->getPost('label_name');
            $sel_lng = $request->getPost('sel_lng');
            $arrLng = ExtAdminLanguages::model()->getAllLang();
            ExtAdminLabels::model()->addLabel($label,$arrLng);
            $this->redirect(array('admin','sel_lng'=>$sel_lng)); 
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
}

?>