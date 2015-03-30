<?php
class TranslationSiteController extends ControllerAdmin
{
 
    public function actionIndex()
    {
        //$this->renderText('index');
        $this->redirect(array('admin'));
    }   

    /**
       *************************** Site translations***************************
     */

    /**
     * Site labels translation
     */
    public function actionAdmin($sel_lng=null)
    {
        $request = Yii::app()->request;
        $lang_prefix = Yii::app()->language;
        $arrSelect = ExtLanguages::model()->selectArray();    
        $curr_page = $request->getPost('curr_page');
        if(empty($curr_page))
        {
            $curr_page=1;
        }
        if(empty($curr_lng)){
           $curr_lng = $lang_prefix; 
        }

        if(!empty($sel_lng)){
            $curr_lng = $sel_lng;   
        }
        $search_label = $request->getPost('search_label');  
        $arrLabel = ExtLabels::model()->getLabelsList($curr_lng, array('search_label' => $search_label));
        $pager = CPaginator::getInstanse($arrLabel,10,$curr_page);

        $this->render('admin_labels',array('arrLabel' => $arrLabel,
                        'arrSelect' => $arrSelect,'lang_prefix' => $lang_prefix,'select_lng' => $curr_lng,
                        'search_val' => $search_label,'pager'=>$pager)); 
        
        
        //$this->render('test_cont'); 
    }

    public function actionAddAdminLabel()
    {
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        $label = $request->getPost('label_name');
        $sel_lng = $request->getPost('sel_lng');
        $arrLng = ExtLanguages::model()->getAllLang();
        ExtLabels::model()->addLabel($label,$arrLng);
        $this->redirect(array('admin','sel_lng'=>$sel_lng)); 
        
    }

    public function actionDelAdminLabel($id = null){
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        $objLabel = Labels::model()->findByPk($id);
        $objLabel->delete();
        ExtLabels::model()->deleteLabel($id);
        $this->redirect(array('admin'));
         
        
    }

    /*-------------- ajax section (Site labels translation) -------------------*/

    public function actionAdminAjax()
    {
        $request = Yii::app()->request;
        $lang_prefix = Yii::app()->language;
        $arrSelect = ExtLanguages::model()->selectArray();    
        $curr_page = $request->getPost('curr_page');
        $select_lng = $request->getPost('lng');
        $search_label = $request->getPost('search_val');
        $arrLabel = ExtLabels::model()->getLabelsList($select_lng,array('search_label' => $search_label));
        $pager = CPaginator::getInstanse($arrLabel,10,$curr_page);
        $retData = $this->renderPartial('_admin_labels',array('arrLabel' => $arrLabel,
                'arrSelect' => $arrSelect,'lang_prefix' => $lang_prefix,'select_lng' => $select_lng,
                'search_val' => $search_label, 'pager'=>$pager)); 
        echo $retData;     
    }

    public function actionUniqueCeckAdminLabelAjax(){
        $label = $_POST['label'];
        $arrJson = array();
        if(!empty($label))
        {
            if($user = Labels::model()->exists('label=:label',array('label'=>$label)))
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

    public function actionAddAdminLabelAjax()
    {
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        $sel_lng = $request->getPost('sel_lng');
        $resArr=array();
        $resArr['html'] = $this->renderPartial('_addLabel',array('lang_prefix'=>$lang_prefix, 'sel_lng'=>$sel_lng),true);
        echo json_encode($resArr);

    }

    public function actionDelAdminLabelAjax($id = null){
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        $id = $request->getPost('id');
        $name = $request->getPost('name');
        $resArr=array();
        $resArr['html'] = $this->renderPartial('_deleteLabel',array('lang_prefix' =>$lang_prefix,
                    'id'=>$id,'label_name' => $name),true);
        echo json_encode($resArr);
    }

    public function actionSaveAdminLabelAjax($id = null){
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            $curr_lng = $request->getPost('curr_lng');
            $value_label = trim($request->getPost('value'));
            
            $objLabel = LabelsTrl::model()->findByPk((int)$id);
           
            $objLabel->value = $value_label;
            $objLabel->save();
             
        }
    }//SaveAdminLabel


    /*-------------- END ajax section (Site labels translation) -------------------*/
    
    /**
     * END Site labels translation
     */


    /**
     * Site messages translation
     */

    public function actionAdminMessages($sel_lng=null)
    {
        $request = Yii::app()->request;
        $lang_prefix = Yii::app()->language;
        $arrSelect = ExtLanguages::model()->selectArray();    
        $curr_page = $request->getPost('curr_page');
        if(empty($curr_page))
        {
            $curr_page=1;
        }
        if(empty($curr_lng)){
           $curr_lng = $lang_prefix; 
        }

        if(!empty($sel_lng)){
            $curr_lng = $sel_lng;   
        }
        $search_label = $request->getPost('search_label');  
        $arrLabel = ExtMessages::model()->getMessagesList($curr_lng, array('search_label' => $search_label));

        $pager = CPaginator::getInstanse($arrLabel,10,$curr_page);
        //$prepPages = $pager->getPreparedArray();

        $this->render('admin_messages',array('arrLabel' => $arrLabel,
                        'arrSelect' => $arrSelect,'lang_prefix' => $lang_prefix,'select_lng' => $curr_lng,
                        'search_val' => $search_label,'pager'=>$pager)); 
            
        
    }

    public function actionDelAdminMessage($id = null){
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        $objLabel = AdminMessages::model()->findByPk($id);
        ExtMessages::model()->deleteMessage($id);
        $this->redirect(array('adminMessages'));
         
        
    }

    public function actionAddAdminMessage()
    {
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        $label = $request->getPost('label_name');
        $sel_lng = $request->getPost('sel_lng');
        $arrLng = ExtLanguages::model()->getAllLang();
        ExtMessages::model()->addMessage($label,$arrLng);
        $this->redirect(array('adminMessages','sel_lng'=>$sel_lng)); 
        
    }


    /*-------------- ajax section (Site messages translation) -------------------*/

    public function actionAdminMessagesAjax()
    {
        $request = Yii::app()->request;
        $lang_prefix = Yii::app()->language;
        $arrSelect = ExtLanguages::model()->selectArray();    
        $curr_page = $request->getPost('curr_page');
        if(empty($curr_page))
        {
            $curr_page=1;
        }
     
        $select_lng = $request->getPost('lng');
        $search_label = $request->getPost('search_val');
        
        $arrLabel = ExtMessages::model()->getMessages($select_lng,array('search_label' => $search_label));

        $pager = CPaginator::getInstanse($arrLabel,10,$curr_page);
        $retData = $this->renderPartial('_admin_messages',array('arrLabel' => $arrLabel,
                'arrSelect' => $arrSelect,'lang_prefix' => $lang_prefix,'select_lng' => $select_lng,
                'search_val' => $search_label, 'pager'=>$pager)); 
        echo $retData;

    }


    public function actionSaveAdminMessageAjax($id = null){
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            $curr_lng = $request->getPost('curr_lng');
            $value_label = trim($request->getPost('value'));
            
            $objLabel = MessagesTrl::model()->findByPk((int)$id);
           
            $objLabel->value = $value_label;
            $objLabel->save();
             
        }
    }//SaveAdminMessage

    public function actionDelAdminMessageAjax($id = null){
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        $id = $request->getPost('id');
        $name = $request->getPost('name');
        $resArr=array();
        $resArr['html'] = $this->renderPartial('_deleteMessage',array('lang_prefix' =>$lang_prefix,
                    'id'=>$id,'label_name' => $name),true);
        echo json_encode($resArr);
    }

    public function actionAddAdminMessageAjax()
    {
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        $sel_lng = $request->getPost('sel_lng');
        $resArr=array();
        $resArr['html'] = $this->renderPartial('_addMessage',array('lang_prefix'=>$lang_prefix, 'sel_lng'=>$sel_lng),true);
        echo json_encode($resArr);

    }

    public function actionUniqueCeckAdminMessageAjax(){
        $label = $_POST['label'];
        $arrJson = array();
        if(!empty($label))
        {
            if($user = AdminMessages::model()->exists('label=:label',array('label'=>$label)))
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

    /*-------------- END ajax section (Site messages translation) -------------------*/

    /**
     * END Site messages translation
     */


    /**
     * Site languages
     */

    public function actionAdminLanguages()
    {
        $request = Yii::app()->request;
        $lang_prefix = Yii::app()->language;
        $arrSelect = ExtLanguages::model()->selectArray();    
        $arrLang = Languages::model()->findAll();
        $curr_page = $request->getPost('curr_page');
        
        if(empty($curr_page))
        {
            $curr_page=1;
        }

        $search_label = $request->getPost('search_label');  
        $arrLabel = ExtLabels::model()->getLabelsList($curr_lng, array('search_label' => $search_label));
        
        $pager = CPaginator::getInstanse($arrLang,10,$curr_page);
        //$prepPages = $pager->getPreparedArray();

        $this->render('admin_languages',array(
                        'lang_prefix' => $lang_prefix,'select_lng' => $curr_lng,
                        'pager'=>$pager)); 
         
    }

    public function actionAddAdminLanguage()
    {
        $request = Yii::app()->request;
        $lang_prefix = Yii::app()->language;
        $new_lang_name = $request->getPost('label_name');
        $new_lang_prefix = $request->getPost('label_prefix');
        ExtLanguages::model()->writeTrl($new_lang_name,$new_lang_prefix);
        $this->redirect(array('AdminLanguages')); 
    }

    public function actionDelAdminLanguage($id = null)
    {
        $model = Languages::model()->findByPk($id);
        $model->delete();
        $this->redirect(array('AdminLanguages'));
         
        
    }

   /*-------------- END ajax section (Site languages) -------------------*/

    public function actionUniqueCeckAdminLanguageAjax(){
        $lang_name = $_POST['lang_name'];
        $lang_prefix = $_POST['lang_prefix'];
        $arrJson = array();
        if(!empty($lang_name)) // check language name
        {
            if($user = Languages::model()->exists('name=:name',array('name'=>$lang_name)))
            {
                $arrJson['status'] = "error";
                $arrJson['err_name_txt'] = Trl::t()->getMsg("Duplicate error");

            }
            else
            {
                $arrJson['status'] = "success";

            }      
        }
        else
        {
            $arrJson['status'] = "error";
            $arrJson['err_name_txt'] = Trl::t()->getMsg("Label empty");
        } // END check language name

        if(!empty($lang_prefix)) // check language prefix
        {
            if($user = Languages::model()->exists('prefix=:prefix',array('prefix'=>$lang_prefix)))
            {
                $arrJson['status'] = "error";
                $arrJson['err_prefix_txt'] = Trl::t()->getMsg("Duplicate error");
 
            }
            else
            {
                $arrJson['status'] = "success";

            }      
        }
        else
        {
            $arrJson['status'] = "error";
            $arrJson['err_prefix_txt'] = Trl::t()->getMsg("Label empty");
           
        } // END check language prefix

        echo json_encode($arrJson);
    }

    public function actionAddAdminLanguageAjax()
    {
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        $resArr=array();
        $resArr['html'] = $this->renderPartial('_addLanguage',array('lang_prefix'=>$lang_prefix),true);
        echo json_encode($resArr);

    }

    public function actionDelAdminLanguageAjax($id = null){
        $lang_prefix = Yii::app()->language;
        $request = Yii::app()->request;
        $lang_name = $request->getPost('lang_name');
        $resArr=array();
        $resArr['html'] = $this->renderPartial('_deleteLanguage',array('lang_prefix' =>$lang_prefix,
                    'id'=>$id,'lang_name'=>$lang_name),true);
        echo json_encode($resArr);
    }

    public function actionSaveAdminLanguageAjax($id = null){
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            $lang_name = $request->getPost('lang_name');
            $lang_prefix = trim($request->getPost('lang_prefix'));
            $objLang = Languages::model()->findByPk((int)$id);
            $objLang->name = $lang_name;
            $objLang->prefix = $lang_prefix;
            $save = $objLang->save();
            $resArr=array();
            $resArr['save'] = $save;
            $resArr['err_txt'] = Trl::t()->getMsg("language or prefix error");
            echo json_encode($resArr);
        }
    }//SaveLabel

   /*-------------- END ajax section (Site languages) -------------------*/

    /**
       * END Site labels languages
     */

    /**
       *************************** END Site translations***************************
     */

}// class Translation    