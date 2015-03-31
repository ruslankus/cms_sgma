<?php

class ContactsController extends ControllerAdmin
{
    public function actionList($page = 1)
    {
        $currLng = Yii::app()->language;
        
        if(empty($siteLng)){
            $siteLng = Yii::app()->language; 
        }
        
        $objContacts = Contacts::model()->with(array('contactsTrls.lng' => array('condition' => "lng.prefix='{$siteLng}'")))->findall();
        
        //Debug::d($objContacts);
                
        $this->render('contacts_list',array('objContacts' => $objContacts, 'currLng' => $currLng));
    }

    public function actionCreate(){
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-contact.js',CClientScript::POS_END);
        $model = new AddPageForm();
        
        if(isset($_POST['AddPageForm'])){
            //Debug::d($_POST);
            $model->attributes = $_POST['AddPageForm'];
            $arrTitle = array();
            if($model->validate()){
                //get title
                foreach(SiteLng::lng()->getLngs() as $objLng){
                    $lngPrefix = $objLng->prefix;
                    $arrTitle[$objLng->id] = $_POST['AddPageForm']["title_{$lngPrefix}"];
                }
                
                $result = ExtContactsTrl::model()->setNewContact($model->page_label,$arrTitle);
                if($result){
                    $this->redirect('index');
                }else{
                    
                }
            }
       
        }
        
        $this->render('new_contact', array('model' => $model));
        
    }//create
    
}