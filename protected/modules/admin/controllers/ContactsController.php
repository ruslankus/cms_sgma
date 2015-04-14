<?php

class ContactsController extends ControllerAdmin
{

/*************************************************************  Pages ***********************************************/

    public function actionPages($page = 1)
    {
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.trees.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.main-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.news.ext.css');

        $currLng = Yii::app()->language;
        
        if(empty($siteLng)){
            $siteLng = Yii::app()->language; 
        }
        
        //$objContacts = ContactsPage::model()->with(array('contactsPageTrls.lng' => array('condition' => "lng.prefix='{$siteLng}'")))->findall(array('order' => 'priority DESC'));

       $objContacts = ContactsPage::model()->findall(array('order' => 'priority DESC'));    
        
        $pager = CPaginator::getInstance($objContacts,100,$page);

        if(Yii::app()->request->isAjaxRequest)
        {
            $pager = $pager->getPreparedArray();
            $this->renderPartial('_index',array('objContacts' => $pager, 'currLng' => $currLng));
        }
        else
        {

            $this->render('index',array('pager' => $pager, 'currLng' => $currLng));
        }

    }
/*
    public function actionPages_old($page = 1)
    {
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.contacts.js',CClientScript::POS_END);

        $currLng = Yii::app()->language;
        
        if(empty($siteLng)){
            $siteLng = Yii::app()->language; 
        }
        
        $objContacts = ContactsPage::model()->with(array('contactsPageTrls.lng' => array('condition' => "lng.prefix='{$siteLng}'")))->findall();
        
        $pager = CPaginator::getInstance($objContacts,10,$page);
        $this->render('index',array('pager' => $pager, 'currLng' => $currLng));
    }
*/
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
                
                $result = ExtContactsPageTrl::model()->setNewContactPage($model->page_label,$arrTitle);
                if($result){
                    $this->redirect('pages');
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
            $siteLng = $_POST['SaveContactForm']['lngId'];
            $langObj = Languages::model()->findByPk($siteLng);
            $curr_prefix = $langObj->prefix;
            $model->attributes=$_POST['SaveContactForm'];

            if($model->validate())
            {

                $contactTrlObj = ContactsPageTrl::model()->find(array('condition'=>'lng_id=:lng_id AND page_id=:page_id','params'=>array('lng_id'=>$siteLng,'page_id'=>$id)));
                $contactTrlObj->description=$_POST['SaveContactForm']['description'];
                $contactTrlObj->title=$_POST['SaveContactForm']['title'];
                $contactTrlObj->meta_description=$_POST['SaveContactForm']['meta'];
                //$contactTrlObj->email=$_POST['SaveContactForm']['email'];
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
        //$arrPage = ExtContacts::model()->getContact($id,$curr_prefix);
        $arrPage = ContactsPageTrl::model()->find(array('condition'=>'Page_id=:id AND lng_id=:siteLng','params'=>array('id'=>$id,'siteLng'=>$siteLng)));
        //Debug::d($arrPage);
        $this->render('editContact', array('arrPage' => $arrPage, 'model' => $model, 'contact_id' => $id, 'siteLng' => $siteLng, 'prefix' => $prefix ));
    }//edit

    public function actionDeleteContact($id=null){
        ContactsPage::model()->deleteByPk($id);

        if(Yii::app()->request->isAjaxRequest)
        {
            echo "OK";
            Yii::app()->end();
        }
        else
        {
            $this->redirect(Yii::app()->createUrl('admin/contacts/pages'));
        }
    }
/*
    public function actionDeleteContact($id=null)
    {
    	$objContact = ContactsPage::model()->findByPk($id);
    	$objContact->delete();
    	$this->redirect(array('index'));
    }
*/

    public function actionContactSettings($id=null)
    {
        $model = new AddContactFile();
        if(!empty($_POST['AddContactFile'])){
            //Debug::d($_POST);
            $model->attributes = $_POST['AddContactFile'];
            if($model->validate()){
                
                $objFile = CUploadedFile::getInstance($model, 'file');
                
               
                $newFileName = uniqid(). "." . $objFile->extensionName;
                $path  = Yii::getPathOfAlias('webroot').'/uploads/images/';
                $path .= $newFileName;
                
                if($objFile->saveAs($path)){

                    //Caption
                   foreach(SiteLng::lng()->getLngs() as $objLng){
                       $arrCaps[$objLng->id] = $model->captions[$objLng->prefix];
                   }
                   
                   if(ExtImages::model()->saveContactFile($newFileName, $id, $arrCaps)){
                       //success
                       $this->refresh();
                   }else{
                       //
                       $model->addError('file',"Can't save file in DB");
                   }
            
                }
                               
              
            }
        }//if post

        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.delete-contact-image.js',CClientScript::POS_END);      

        $lngObj = SiteLng::lng()->getCurrLng();
      
        $arrPage = ExtContactsPage::model()->getContactPageWithImage($id, $lngObj->prefix);
        
        $arrImages = $arrPage['images'];
       
        $elCount = count($arrImages);
        /*
        if($elCount < 5){          
            $arrComb = array_pad($arrImages,5,'');           
        }        
        */

        // limit for one
        $arrComb = $arrImages;
        if($elCount==0){
            $arrComb[]='';
        }
        //$arrComb = $arrImages;
        //Debug::d($arrComb);
        
        $this->render('contact_setting',array('page_id' => $id, 'arrPage' => $arrPage,
         'arrImages' => $arrComb, 'model' => $model));
         
    }

    public function actionDeleteContactImage()
    {
        $request = Yii::app()->request;
        $image_id = $request->getPost('image_id');
        $contact_id = $request->getPost('contact_id');        
        $model = ImagesOfContacts::model()->find(array('condition'=>'image_id=:image_id AND contact_page_id=:contacts_id','params'=>array('image_id'=>$image_id,'contacts_id'=>$contact_id)));
     
        $model->delete();
        $this->redirect(array('ContactSettings', 'id'=>$contact_id));
    }

    /* ----------------------------- pages ajax section -------------------------------------- */

    public function actionAjaxOrderPages()
    {
        $ordersJson = Yii::app()->request->getParam('orders');
        $orders = json_decode($ordersJson,true);

        $previous = $orders['old'];
        $new = $orders['new'];

        Sort::ReorderItems("ContactsPage",$previous,$new);

        echo "OK";
    }

    public function actionEditContentAjax($id = null)
    {
        
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            
            $lngId = $request->getPost('lngId');
            
            $objPage = ContactsPageTrl::model()->findByAttributes(array('lng_id' => $lngId, 'page_id' => $id));
            $arrJson = array();
            $arrJson['title'] = $objPage->title;
            $arrJson['meta'] = $objPage->meta_description;
            $arrJson['description'] = $objPage->description;
            //$arrJson['email'] = $objPage->email;
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
	        
	        $objContacts = ContactsPage::model()->with(array('contactsPageTrls.lng' => array('condition' => "lng.prefix='{$siteLng}'")))->findall();
	        
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

    public function actionDelImageAjax($id=null)
    {
        $request = Yii::app()->request;
        $currLng = Yii::app()->language;
        $arrJson=array();
        if($request->isAjaxRequest)
        {    
            $contact_id = $request->getPost('contact_id');
            $arrJson['html'] = $this->renderPartial('_deleteContactImage',array('image_id' => $id, 'contact_id' => $contact_id, 'lang_prefix' => $currLng), true);
            echo json_encode($arrJson);
            Yii::app()->end();
        }

    }

    /* ----------------------------- pages ajax section -------------------------------------- */

/************************************************************* End Pages ***********************************************/


/*************************************************************  Blocks ***********************************************/

    public function actionBlocks($page = 1, $group = 0)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.trees.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.main-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.news.ext.css');

        $fieldGroup = ContactsPage::model()->findByPk($group);

        if(!empty($fieldGroup))
        {
            $fields = ContactsBlock::model()->findAllByAttributes(array('page_id' => $group),array('order' => 'priority DESC'));
            $per_page = 100;
        }
        else
        {
            $fields = ContactsBlock::model()->findAll(array('order' => 'priority DESC'));
            $per_page = 10;
        }

        $items = CPaginator::getInstance($fields,$per_page,$page)->getPreparedArray();

        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_listBlocks',array('items' => $items, 'group' => $group));
        }
        else
        {
            $this->render('listBlocks',array('items' => $items, 'group' => $group));
        }       
    }


    public function actionAddBlock($group=0){
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-contact-block.js',CClientScript::POS_END);
        $model = new AddPageBlockForm();
        
        if(isset($_POST['AddPageBlockForm'])){
            //Debug::d($_POST);
            $model->attributes = $_POST['AddPageBlockForm'];
            $arrTitle = array();
            if($model->validate()){
                //get title
                foreach(SiteLng::lng()->getLngs() as $objLng){
                    $lngPrefix = $objLng->prefix;
                    $arrTitle[$objLng->id] = $_POST['AddPageBlockForm']["title_{$lngPrefix}"];
                }
                
                $result = ExtContactsBlockTrl::model()->setNewContactBlock($model->page_label,$arrTitle,$model->page_id);
                if($result){
                    $this->redirect(Yii::app()->createUrl('admin/contacts/blocks',array('group' => $model->page_id)));
                }else{
                    
                }
            }
       
        }
        
        $this->render('new_block', array('model' => $model, 'group_id'=>$group));
        
    }//create

    public function actionDelBlock($id=null)
    {
        ContactsBlock::model()->deleteByPk($id);

        if(Yii::app()->request->isAjaxRequest)
        {
            echo "OK";
            Yii::app()->end();
        }
        else
        {
            $this->redirect(Yii::app()->createUrl('admin/contacts/blocks'));
        }
    }       
    

    public function actionEditBlock($id = null)
    {
        $objBlock = ContactsBlock::model()->findByPk($id);
        $model = new SaveContactBlockForm();
        $request = Yii::app()->request;
        $prefix = Yii::app()->language;
        if(isset($_POST['SaveContactBlockForm']))
        {
            $siteLng = $_POST['SaveContactBlockForm']['lngId'];
            $langObj = Languages::model()->findByPk($siteLng);
            $curr_prefix = $langObj->prefix;
            $model->attributes=$_POST['SaveContactBlockForm'];

            if($model->validate())
            {

                $contactTrlObj = ContactsBlockTrl::model()->find(array('condition'=>'lng_id=:lng_id AND block_id=:block_id','params'=>array('lng_id'=>$siteLng,'block_id'=>$id)));
                $contactTrlObj->text=$_POST['SaveContactBlockForm']['description'];
                 $contactTrlObj->title=$_POST['SaveContactBlockForm']['title'];
                $contactTrlObj->meta_description=$_POST['SaveContactBlockForm']['meta'];
                $contactTrlObj->update(); 

                $objBlock->page_id=$_POST['SaveContactBlockForm']['page_id'];

                $objBlock->update();

            }
        } 

        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/ckeditor/ckeditor.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/ckeditor/adapters/jquery.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-contact-block.js',CClientScript::POS_END);
       
        
        $objCurrLng = SiteLng::lng()->getCurrLng();  
        


        if(empty($siteLng))
        {
            $siteLng = $objCurrLng->id;
            $curr_prefix = $objCurrLng->prefix;

        }

        //$objPage = ExtPage::model()->findByPk($id);
        //$arrPage = ExtContacts::model()->getContact($id,$curr_prefix);
        $arrPage = ContactsPageTrl::model()->find(array('condition'=>'Page_id=:id AND lng_id=:siteLng','params'=>array('id'=>$id,'siteLng'=>$siteLng)));
        //Debug::d($arrPage);
        $this->render('editBlock', array('arrPage' => $arrPage, 'model' => $model, 'contact_id' => $id, 'siteLng' => $siteLng, 'prefix' => $prefix, 'page_id'=>$objBlock->page_id));
    }//edit


    /* ----------------------------- blocks ajax section -------------------------------------- */

    public function actionAjaxOrderBlocks()
    {
         $ordersJson = Yii::app()->request->getParam('orders');
        $orders = json_decode($ordersJson,true);

        $previous = $orders['old'];
        $new = $orders['new'];

        Sort::ReorderItems("ContactsBlock",$previous,$new);

        echo "OK";       
    }

    /* ----------------------------- blocks ajax section -------------------------------------- */

/************************************************************* End Blocks ***********************************************/


/*************************************************************  Fields ***********************************************/

    public function actionFields($page = 1, $group = 0)
    {
        //include js file for AJAX updating
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.trees.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.main-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.news.ext.css');

        $fieldGroup = ContactsBlock::model()->findByPk($group);

        if(!empty($fieldGroup))
        {
            $fields = ContactsFields::model()->findAllByAttributes(array('block_id' => $group));
            $per_page = 100;
        }
        else
        {
            $fields = ContactsFields::model()->findAll();
            $per_page = 10;
        }

        $items = CPaginator::getInstance($fields,$per_page,$page)->getPreparedArray();

        if(Yii::app()->request->isAjaxRequest)
        {
            $this->renderPartial('_listFields',array('items' => $items, 'group' => $group));
        }
        else
        {
            $this->render('listFields',array('items' => $items, 'group' => $group));
        }       
    }

    public function actionAddField($group=0){
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-contact-field.js',CClientScript::POS_END);
        $model = new AddPageFieldForm();
        
        if(isset($_POST['AddPageFieldForm'])){
            //Debug::d($_POST);
            $model->attributes = $_POST['AddPageFieldForm'];
            $arrTitle = array();
            if($model->validate()){
                //get title
                foreach(SiteLng::lng()->getLngs() as $objLng){
                    $lngPrefix = $objLng->prefix;
                    $arrTitle[$objLng->id] = $_POST['AddPageFieldForm']["title_{$lngPrefix}"];
                }

                $result = ExtContactsFieldsTrl::model()->setNewContactField($model->page_label,$arrTitle,$model->block_id);
              
                if($result){
                    $this->redirect(Yii::app()->createUrl('admin/contacts/fields',array('group' => $model->block_id)));
                }else{
                    
                }
            }
       
        }
        
        $this->render('new_field', array('model' => $model, 'group_id'=>$group));
        
    }//create

    public function actionDelField($id=null)
    {
        ContactsFields::model()->deleteByPk($id);

        if(Yii::app()->request->isAjaxRequest)
        {
            echo "OK";
            Yii::app()->end();
        }
        else
        {
            $this->redirect(Yii::app()->createUrl('admin/contacts/fields'));
        }
    }       
    
    public function actionEditField($id = null)
    {
        $objField = ContactsFields::model()->findByPk($id);
        $model = new SaveContactFieldForm();
        $request = Yii::app()->request;
        $prefix = Yii::app()->language;
        if(isset($_POST['SaveContactFieldForm']))
        {
            $siteLng = $_POST['SaveContactFieldForm']['lngId'];
            $langObj = Languages::model()->findByPk($siteLng);
            $curr_prefix = $langObj->prefix;
            $model->attributes=$_POST['SaveContactFieldForm'];

            if($model->validate())
            {

                $contactTrlObj = ContactsFieldsTrl::model()->find(array('condition'=>'lng_id=:lng_id AND contacts_field_id=:contacts_field_id','params'=>array('lng_id'=>$siteLng,'contacts_field_id'=>$id)));
                $contactTrlObj->value=$_POST['SaveContactFieldForm']['value'];
                 $contactTrlObj->name=$_POST['SaveContactFieldForm']['name'];
                $contactTrlObj->update(); 

                $objField->block_id=$_POST['SaveContactFieldForm']['block_id'];

                $objField->update();

            }
        } 

        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/ckeditor/ckeditor.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/ckeditor/adapters/jquery.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-contact-field.js',CClientScript::POS_END);
       
        
        $objCurrLng = SiteLng::lng()->getCurrLng();  
        


        if(empty($siteLng))
        {
            $siteLng = $objCurrLng->id;
            $curr_prefix = $objCurrLng->prefix;

        }

        //$objPage = ExtPage::model()->findByPk($id);
        //$arrPage = ExtContacts::model()->getContact($id,$curr_prefix);
        $arrPage = ContactsFieldsTrl::model()->find(array('condition'=>'contacts_field_id=:id AND lng_id=:siteLng','params'=>array('id'=>$id,'siteLng'=>$siteLng)));
        //Debug::d($arrPage);
        $this->render('editField', array('arrPage' => $arrPage, 'model' => $model, 'contact_id' => $id, 'siteLng' => $siteLng, 'prefix' => $prefix, 'block_id'=>$objField->block_id));
    }//edit
}

