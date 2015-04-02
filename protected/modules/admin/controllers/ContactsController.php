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
            $siteLng = $_POST['SaveContactForm']['lngId'];
            $langObj = Languages::model()->findByPk($siteLng);
            $curr_prefix = $langObj->prefix;
            $model->attributes=$_POST['SaveContactForm'];

            if($model->validate())
            {

                $contactTrlObj = ContactsTrl::model()->find(array('condition'=>'lng_id=:lng_id AND contacts_id=:contacts_id','params'=>array('lng_id'=>$siteLng,'contacts_id'=>$id)));
                $contactTrlObj->text=$_POST['SaveContactForm']['text'];
                $contactTrlObj->title=$_POST['SaveContactForm']['title'];
                $contactTrlObj->meta_description=$_POST['SaveContactForm']['meta'];
               /*
                // save image

                $model->image=CUploadedFile::getInstance($model,'image');

                if($model->image){
                    $imageObj = new Images();
                    $imageObj->name = $model->image;
                    $imageObj->save();
                    $img_id = $imageObj->id;
                    $img_name = $img_id.".".$model->image->extensionName;
                    $path = "uploads/images/".$img_name;
                    $thisImgObj = Images::model()->findByPk($img_id);
                    if($model->image->saveAs($path))
                    {
                        $thisImgObj->name=$img_name;
                        $thisImgObj->update();

                        $imageLinkObj = new ContactsLinkImages();
                        $imageLinkObj->image_id = $img_id;
                        $imageLinkObj->contacts_id = $contactTrlObj->id;
                        $imageLinkObj->save();
                        //$contactTrlObj->image_id = $img_name;
                    }
                    else
                    {
                        $thisImgObj->delete();
                    }
                }
            */
                // end save image
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
        $arrPage = ContactsTrl::model()->find(array('condition'=>'contacts_id=:id AND lng_id=:siteLng','params'=>array('id'=>$id,'siteLng'=>$siteLng)));
        //Debug::d($arrPage);
        $this->render('editContact', array('arrPage' => $arrPage, 'model' => $model, 'contact_id' => $id, 'siteLng' => $siteLng, 'prefix' => $prefix ));
    }//edit

    public function actionDeleteContact($id=null)
    {
    	$objContact = Contacts::model()->findByPk($id);
    	$objContact->delete();
    	$this->redirect(array('index'));
    }


    public function actionContactSettings($id=null)
    {
        $this->render('editContactSettings');
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
            if($arrPage->imageLink->image->id){
                $arrJson['image']= array('id'=>$arrPage->imageLink->image->id,'src'=>'/uploads/images/'.$arrPage->imageLink->image->name);
            }
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

    public function actionDelImageAjax($id=null)
    {
        $request = Yii::app()->request;
        $arrJson=array();
        if($request->isAjaxRequest)
        {    
            $objContTrl = ContactsLinkImages::model()->findByAttributes(array('contacts_id' => $id));
            if($objContTrl->delete()){
                $arrJson['status']="deleted";
            }
            else
            {
                $arrJson['status']="error";
            }
            echo json_encode($arrJson);
            Yii::app()->end();
        }

    }
}