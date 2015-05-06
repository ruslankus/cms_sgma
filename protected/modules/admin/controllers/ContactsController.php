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
        
        $objContacts = ContactsPage::model()->findall(array('order' => 'priority ASC'));
        
       
        
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
    
    }//actionPages

    public function actionCreate(){
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-contact.js',CClientScript::POS_END);
        $prefix = Yii::app()->language;
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
        
        $this->render('new_contact', array('model' => $model, 'prefix' => $prefix));
        
    }//create

    public function actionEditContent($id = null)
    {
              
       
        $model = new SaveContactForm();
        $request = Yii::app()->request;
       
        if(isset($_POST['SaveContactForm']))
        {
            
            
            $siteLng = $_POST['SaveContactForm']['lngId'];
            $langObj = Languages::model()->findByPk($siteLng);
            $curr_prefix = $langObj->prefix;
            $model->attributes=$_POST['SaveContactForm'];

            if($model->validate())
            {

                $contactTrlObj = ContactsPageTrl::model()->find(array(
                    'condition'=>'lng_id=:lng_id AND page_id=:page_id',
                    'params'=>array('lng_id'=>$siteLng,'page_id'=>$id)));
                //if translation exist
                if(empty($contactTrlObj)){
                    $contactTrlObj = new ContactsPageTrl();
                    $contactTrlObj->lng_id = $siteLng;
                    $contactTrlObj->page_id = $id;
                }
                
                $contactTrlObj->description=$_POST['SaveContactForm']['description'];
                $contactTrlObj->title=$_POST['SaveContactForm']['title'];
                $contactTrlObj->meta_description=$_POST['SaveContactForm']['meta'];
                $contactTrlObj->email=$_POST['SaveContactForm']['email'];
                $upd = $contactTrlObj->save(); 
                if($upd) {
                    Yii::app()->user->setFlash('success', Trl::t()->getLabel('Data saved'));
                }

            }
        }//if isset post 

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
        $this->render('editContact', array('arrPage' => $arrPage, 'model' => $model,
         'contact_id' => $id, 'siteLng' => $siteLng, 'prefix' => $prefix
          ));
    }//edit
    
    public function ActionRequests($id = null, $page = 1)
    {
        //Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.contacts-requests.js',CClientScript::POS_END);
        $objPages = ExtLetters::model()->findAllByAttributes(array('page_id'=>$id));
        $objPaging = CPaginator::getInstance($objPages,$this->arrSettings['per_page'],$page);
        $objPages = $objPaging->getPreparedArray();
        $totalPages = $objPaging->getTotalPages();
        $currentPage = $objPaging->getCurrentPage();
        $showPaginator = $objPaging->showPaginator();
        $this->render('requests',array('objPages' => $objPages, 'contact_id' => $id, 'currLng' => $currLng,
           'totalPages' => $totalPages, 'currentPage' => $currentPage,'showPaginator' => $showPaginator));
    }

    public function actionEditSetup($id = null)
    {
        $model = new SaveContactSetupForm();
        $objContactPage = ContactsPage::model()->findByPk($id);
        if ($_POST['SaveContactSetupForm']) {
            if ($model->validate()) {
                $model->attributes=$_POST['SaveContactSetupForm'];
                $objContactPage->attributes=$_POST['SaveContactSetupForm'];
                if(!$objContactPage->template_name) {
                    // if $arrTemplates is empty write default.php
                    $objContactPage->template_name = 'default.php';
                }
                $objContactPage->update();
            }
        }
        
        $currTheme = $this->currentThemeName;
        //getting tempates for page from theme if available
        if (!empty($currTheme)) {
            $arrTemplates = ThemeHelper::getTemplatesFor($currTheme, 'contacts');
            array_unshift($arrTemplates,'--------------');
        } else {
            $arrTemplates = null;
        }
        $this->render('contact_setup', array('model'=>$model, 'objContact'=>$objContactPage, 'contact_id'=>$id, 'arrTemplates' => $arrTemplates));
   } 

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
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');
        
        $lngObj = SiteLng::lng()->getCurrLng();
      
        $arrPage = ExtContactsPage::model()->getContactPageWithImage($id, $lngObj->prefix);
        
        //Debug::d($arrPage);
        
        
        $arrImage = $arrPage['images'];
         
        $this->render('contact_setting',array('page_id' => $id, 'arrPage' => $arrPage,
         'arrImage' => $arrImage, 'model' => $model));
         
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
    
    
    /**
     * 
     * @param int $id 
     */
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
            $arrJson['email'] = $objPage->email;
            echo json_encode($arrJson);
            Yii::app()->end();
        }//ajax part
        

    }//actionEditContentAjax
    
    
    public function actionEditContentBlockAjax($id = null)
    {
        
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            
            $lngId = $request->getPost('lngId');
            
            $objPage = ContactsBlockTrl::model()->findByAttributes(array('lng_id' => $lngId, 'block_id' => $id));
            $arrJson = array();
            $arrJson['title'] = $objPage->title;
            $arrJson['meta'] = $objPage->meta_description;
            $arrJson['text'] = $objPage->text;
            //$arrJson['email'] = $objPage->email;
            echo json_encode($arrJson);
            Yii::app()->end();
        }//ajax part
        

    }//actionEditContentAjax
    

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
    }//actionIndexAjax
    
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
    }//actionDeleteContactAjax

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
    
    /**
     * @param $id int page Id
     */
    public function actionAddLocalImage($id){
        $request = Yii::app()->request;
        $prefix = SiteLng::lng()->getCurrLng()->prefix;
        
        if($request->isAjaxRequest){
            //ajax
            $objPhotos = Images::model()->findAll();
            
            $this->renderPartial('_modal_load_local_files',array('objPhotos' => $objPhotos,
            'page_id' => $id, 'prefix' => $prefix, ));            
            Yii::app()->end();
            
        }elseif($request->isPostRequest){
            //post
            $imgObj = ImagesOfContacts::model()->findByAttributes(array('contact_page_id' => $id));
            if(empty($imgObj)){
                $imgObj = new ImagesOfContacts();
                $imgObj->contact_page_id = $id;
            }
            $imgObj->image_id = key($_POST['image']);
            if($imgObj->save()){
                
                Yii::app()->user->setFlash('error',"File has been added");
                $this->redirect("/{$prefix}/admin/contacts/contactsettings/{$id}");
                Yii::app()->end();
            }else{
                Yii::app()->user->setFlash('error',"Add file was failed");
                $this->redirect("/{$prefix}/admin/contacts/contactsettings/{$id}");
                Yii::app()->end(); 
            }
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
            $fields = ContactsBlock::model()->findAllByAttributes(array('page_id' => $group),array('order' => 'priority ASC'));
            $per_page = 100;
        }
        else
        {
            $fields = ContactsBlock::model()->findAll(array('order' => 'priority ASC'));
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
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-block.js',CClientScript::POS_END);
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
        if($_POST['SaveContactBlockForm'])
        {
            $siteLng = $_POST['SaveContactBlockForm']['lngId'];
            $langObj = Languages::model()->findByPk($siteLng);
            $curr_prefix = $langObj->prefix;
            $model->attributes=$_POST['SaveContactBlockForm'];

            if($model->validate())
            {

                
                $contactTrlObj = ContactsBlockTrl::model()->find(array('condition'=>'lng_id=:lng_id AND block_id=:block_id','params'=>array('lng_id'=>$siteLng,'block_id'=>$id)));
              
                $contactTrlObj->text=$_POST['SaveContactBlockForm']['text'];
                $contactTrlObj->title=$_POST['SaveContactBlockForm']['title'];
                $contactTrlObj->meta_description=$_POST['SaveContactBlockForm']['meta'];

                $contactTrlObj->update(); 

                $objBlock->page_id=$_POST['SaveContactBlockForm']['page_id'];

                $upd = $objBlock->update();

                if($upd) {
                    Yii::app()->user->setFlash('success', Trl::t()->getLabel('Data saved'));
                }
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
        $arrPage = ContactsBlockTrl::model()->find(array('condition'=>'block_id=:id AND lng_id=:siteLng','params'=>array('id'=>$id,'siteLng'=>$siteLng)));
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
    
    public function actionEditField_old($id = null)
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
    
    /**
     * 
     * @param int $id contoct block field Id
     */
    public function actionEditField($id){
        $request = Yii::app()->request;
        $objLng = SiteLng::lng()->getCurrLng();
        
        $model = new SaveContactFieldForm();
        $objBlocks = ExtContactsBlock::model()->findAll();
        
        //$objField = ExtContactsFields::model()->findByPk($id);
        
               
        if($request->isAjaxRequest){
            //ajax
            $siteLng = $request->getPost('lngPrefix');
            
            $arrField = ExtContactsFields::model()->getFieldContent($id,$siteLng); 
            
            //Debug::d($arrField);
            
            $this->renderPartial("_edit_contact_block_field",array('model' => $model,
                'objBlocks'=> $objBlocks,'lngPrefix' => $objLng->prefix, 'arrField' => $arrField));
            Yii::app()->end();
        }
        
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/ckeditor/ckeditor.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/ckeditor/adapters/jquery.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-contact-field.js',CClientScript::POS_END);
        
        $arrField = ExtContactsFields::model()->getFieldContent($id,$objLng->prefix); 
        
        $this->render('editField',array('model' => $model,'objBlocks' => $objBlocks,
            'arrField' => $arrField,'lngPrefix' => $objLng->prefix ));
        
     
    }//actionEditField
    
    
    
    /*--------------------- fields ajax section ----------------------------------------*/
    
    /**
     * 
     * @param int $id contact block filed Id
     * @internal $prefix - admin panel language prefix,
     * used for generete links
     */
    public function actionEditContactFieldAjax($id){
        $request = Yii::app()->request;
         $objBlocks = ExtContactsBlock::model()->findAll();
        
        if($request->isAjaxRequest){
            //Debug::d($_POST);
            $model = new SaveContactFieldForm();
            $model->attributes = $_POST['SaveContactFieldForm'];
            $field_id = $request->getPost('field_id');
            $prefix = $request->getPost('prefix');
            $fieldLng = $request->getPost('language');
            $fieldLngId = SiteLng::lng()->getIdFromPrefix($fieldLng); 
            if($model->validate()){
                
                $objFieldTrl = ContactsFieldsTrl::model()->findByAttributes(array('contacts_field_id' => $field_id,
                'lng_id' => $fieldLngId ));
                if(empty($objFieldTrl)){
                    $objFieldTrl = new ContactsFieldsTrl();
                    $objFieldTrl->lng_id = $fieldLngId;
                    $objFieldTrl->contacts_field_id = $field_id;
                }
                
                $objFieldTrl->attributes = $model->attributes;
                if($objFieldTrl->save()){
                   $this->renderPartial('_edit_contact_block_fields_success', array(
                        'lngPrefix' => $prefix,'field_id' => $field_id));
                }else{
                     $this->renderPartial('_edit_contact_block_fields_failed', array(
                        'lngPrefix' => $prefix,'field_id' => $field_id));    
                }
              
                
            }else{
            //error
                 $this->renderPartial("_edit_contact_block_field_error",array('model' => $model,
                    'objBlocks'=> $objBlocks,'lngPrefix' => $prefix, 'field_id' => $field_id));
                Yii::app()->end();
            }
            
        }else{
            //error
        }
        
        
        
    }//actionEditContactFieldAjax
    
}//end classs

