<?php

class ContactsController extends ControllerAdmin
{
    public function actionIndex($page = 1)
    {
        $currLng = Yii::app()->language;
        
        if(empty($siteLng)){
            $siteLng = Yii::app()->language; 
        }
        
        $objContacts = Contacts::model()->with(array('contactsTrls.lng' => array('condition' => "lng.prefix='{$siteLng}'")))->findall();
        
        $pager = CPaginator::getInstance($objContacts,10,$page);
        $this->render('index',array('pager' => $pager, 'currLng' => $currLng));
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

    public function actionEditContent($id = null)
    {
        $model = new SaveContactForm();
        $request = Yii::app()->request;
        $prefix = Yii::app()->language;
        if(isset($_POST['SaveContactForm']))
        {
            $model->attributes=$_POST['SaveContactForm'];
            if($model->validate())
            {
                $siteLng = $_POST['SaveContactForm']['lngId'];
                $langObj = Languages::model()->findByPk($siteLng);
                $curr_prefix = $langObj->prefix;
                $criteria = new CDbCriteria;
                $criteria->condition = "lng_id=':lng_id' AND contacts_id=':contacts_id'";
                $criteria->params = array(':lang_id'=>$siteLng,':contacts_id'=>$id);
                $contactTrlObj = ContactsTrl::model()->find(array('condition'=>'lng_id=:lng_id AND contacts_id=:contacts_id','params'=>array('lng_id'=>$siteLng,'contacts_id'=>$id)));
                $contactTrlObj->text=$_POST['SaveContactForm']['text'];
                $contactTrlObj->title=$_POST['SaveContactForm']['title'];
                $contactTrlObj->meta_description=$_POST['SaveContactForm']['meta'];
                $contactTrlObj->update();
           
            }
        } 

        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/ckeditor/ckeditor.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/ckeditor/adapters/jquery.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-contact.js',CClientScript::POS_END);
       
        
        $objCurrLng = SiteLng::lng()->getCurrLng();  
        


        if(empty($siteLng))
        {
            $siteLng = $objCurrLng->id;
            $curr_prefix = $objCurrLng->prefix;

        }

        //$objPage = ExtPage::model()->findByPk($id);
        $arrPage = ExtContacts::model()->getContact($id,$curr_prefix);
        //Debug::d($arrPage);
        $this->render('editContact', array('arrPage' => $arrPage, 'model' => $model, 'contact_id' => $id, 'siteLng' => $siteLng, 'prefix' => $prefix ));
    }//edit

    public function actionDeleteContact($id=null)
    {
    	$objContact = Contacts::model()->findByPk($id);
    	$objContact->delete();
    	$this->redirect(array('index'));
    }

    /* ----------------------------- ajax section -------------------------------------- */
    public function actionEditContentAjax($id = null)
    {
        
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            
            $lngId = $request->getPost('lngId');
            
            $objPage = ContactsTrl::model()->findByAttributes(array('lng_id' => $lngId, 'contacts_id' => $id));
            $arrJson = array();
            $arrJson['title'] = $objPage->title;
            $arrJson['meta'] = $objPage->meta_description;
            $arrJson['text'] = $objPage->text;

            echo json_encode($arrJson);
            Yii::app()->end();
        }//ajax part
        

    }

    public function actionIndexAjax($page = 1)
    {
    	$request = Yii::app()->request;
        $currLng = Yii::app()->language;
        
        if($request->isAjaxRequest)
        {    
	        $page = $request->getPost('curr_page');
	        if(empty($siteLng)){
	            $siteLng = Yii::app()->language; 
	        }
	        
	        $objContacts = Contacts::model()->with(array('contactsTrls.lng' => array('condition' => "lng.prefix='{$siteLng}'")))->findall();
	        
	        $pager = CPaginator::getInstance($objContacts,10,$page);
	        $this->renderPartial('_index',array('pager' => $pager, 'currLng' => $currLng));

	        Yii::app()->end();
    	}
    }
    
    public function actionDeleteContactAjax($id=null)
    {
    	$request = Yii::app()->request;
        $currLng = Yii::app()->language;
        
        if($request->isAjaxRequest)
        {    

        	$contact_name = $request->getPost('name');

	        $arrJson = array();

	        $arrJson['html'] = $this->renderPartial('_deleteContact',array('id' => $id, 'lang_prefix' => $currLng, 'contact_name' => $contact_name), true);

	        echo json_encode($arrJson);

	        Yii::app()->end();
    	}
    }
}