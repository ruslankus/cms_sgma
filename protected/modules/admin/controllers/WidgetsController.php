<?php

class WidgetsController extends ControllerAdmin
{
    /**
     * Listing all widgets (includes creation feature)
     * @param int $page
     */
    public function actionList($page = 1)
    {
        //include necessary scripts and css
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.menu-list.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);


        //menu form
        $form_mdl = new WidgetForm();
        $types = ExtSystemWidgetType::model()->getAllTypesForForm(true);
        

        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'add-form')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
            //if have form
            if($_POST['WidgetForm'])
            {   
               
                $form_mdl->attributes = $_POST['WidgetForm'];

                if($form_mdl->validate())
                {
                    //$objTypes = SystemWidgetType::model()->findByPk($form_mdl->type_id);
                    $widget = new ExtSystemWidget();
                    $widget -> attributes = $form_mdl->attributes;
                    //$widget->template_name = $objTypes->default_template;
                    $widget -> save();
                }
            }
        }

        //special for form with-ajax validation
        $form_params = array('types' => $types, 'form_model' => $form_mdl);

        //widgets
        $widgets = ExtSystemWidget::model()->findAll();
        $array = CPaginator::getInstance($widgets,10,$page)->getPreparedArray();

        $this->render('list_widgets',array('widgets' => $array, 'form_params' => $form_params));
    }


    /**
     * Edit and update widget
     * @param $id
     */
    public function actionEdit($id)
    {   
        
        /* @var $objLanguages Languages[] */

        //include menu necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/menu.edititem.js',CClientScript::POS_END);

        //exclude jquery to avoid conflict between jquery from Yii core
        Yii::app()->clientScript->scriptMap=array('jquery-1.11.2.min.js' => false);

        //all languages
        $objLanguages = SiteLng::lng()->getLngs();
        //get widget
        $objWidget = ExtSystemWidget::model()->findByPk($id);
        $widgetPrefix = $objWidget->type->prefix;
        //types
        $arrTypes = ExtSystemWidgetType::model()->getAllTypesForForm(true);
        
        //currently selected theme
        $selectedTheme = $this->currentThemeName;
        //get all templates for widgets
        $templates = ThemeHelper::getTemplatesForWidgets($selectedTheme,$widgetPrefix);
        
        //form
        $form_mdl = new WidgetForm();

        if(Yii::app()->request->isAjaxRequest)
        {
            //if ajax validation
            if(isset($_POST['ajax']))
            {
                if($_POST['ajax'] == 'edit-widget')
                {
                    echo CActiveForm::validate($form_mdl);
                }
                Yii::app()->end();
            }
        }
        else
        {
            //if have form
            if($_POST['WidgetForm'])
            {
                
                
                //attributes
                $form_mdl->attributes = $_POST['WidgetForm'];

                if($form_mdl->validate())
                {
                    
                    $con = Yii::app()->db;
                    $transaction = $con->beginTransaction();

                    try
                    {
                        //update
                        $objWidget->attributes = $form_mdl->attributes;
                        $objWidget->update();

                        //multi-language fields
                        $customName = $_POST['WidgetForm']['custom_name'];
                        $customHtml = $_POST['WidgetForm']['custom_html'];

                        //update translations
                        foreach($objLanguages as $language)
                        {
                            //try find translation for language
                            $trl = SystemWidgetTrl::model()->findByAttributes(array('lng_id' => $language->id, 'widget_id' => $objWidget->id));

                            //if not found
                            if(empty($trl))
                            {
                                //create translation for this widget and this language
                                $trl = new SystemWidgetTrl();
                                $trl -> widget_id = $objWidget->id;
                                $trl -> lng_id = $language->id;
                            }

                            //set data
                            $trl -> custom_html = $customHtml[$language->id];
                            $trl -> custom_name = $customName[$language->id];

                            //save pr update
                            if($trl->isNewRecord)
                            {
                                $trl->save();
                            }
                            else
                            {
                                $trl->update();
                            }
                        }

                        $transaction->commit();
                    }
                    catch(Exception $ex)
                    {
                        $transaction->rollback();
                    }
                }

                //back to list
                $this->redirect('/admin/widgets/list');
            }
        }

        $this->render('edit_widget',array(
                'languages' => $objLanguages,
                'types' => $arrTypes,
                'form_model' => $form_mdl,
                'templates' => $templates,
                'widget' => $objWidget,
            )
        );
    }


    /**
     * Deletes widget
     * @param $id
     */
    public function actionDelete($id)
    {
        ExtSystemWidget::model()->deleteByPk($id);
        $this->redirect(Yii::app()->createUrl('/admin/widgets/list'));
    }
  
    /**
     * Baners widget images by Maxim
    */

    public function actionBannerImages($id)
    {
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-banner-images.js',CClientScript::POS_END);
        
        //
        //$objPage = Page::model()->findByPk($id);
        $model = new AddBannerFile();
        if(!empty($_POST['AddBannerFile'])){
            //Debug::d($_POST);
            $model->attributes = $_POST['AddBannerFile'];
            $model->page_id = $id;
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
                   
                   if(ExtImages::model()->saveBannerFile($newFileName, $id, $arrCaps)){
                       //success
                       $this->refresh();
                   }else{
                       //
                       $model->addError('file',"Can't save file in DB");
                   }

                }
                               
              
            }
        }//if post
        
        $lngObj = SiteLng::lng()->getCurrLng();
        
        $arrPage = ExtSystemWidget::model()->getBannerImageNoCaption($id);
        //Debug::d($arrPage);
        if(!empty($arrPage)){
        
            $arrImages = $arrPage['images'];
           
            $elCount = count($arrImages);
            if($elCount < 5){          
                $arrComb = array_pad($arrImages,5,'');           
            }else{
                $arrComb = $arrImages;    
            }        
            //Debug::d($arrComb);
            $this->render('banner_images',array('page_id' => $id, 'arrPage' => $arrPage,
             'arrImages' => $arrComb, 'model' => $model, 'lngPrefix' => $lngObj->prefix,'elCount' => $elCount));    
        
        }else{
            $prefix = $lngObj->prefix;
            $this->redirect("/{$prefix}/admin/widgets/list");
        }
        

    } 

    public function actionLoadFiles($id){
        
        
        $prefix = SiteLng::lng()->getCurrLng()->prefix;
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            $objPhotos = Images::model()->findAll();
            $elCount = $request->getPost('el_count');
            $this->renderPartial('_modal_load_local_files',array('objPhotos' => $objPhotos,
            'page_id' => $id, 'prefix' => $prefix, 'elCount' => $elCount));
                
        }else{
            
            //Debug::d($_POST);
            $arrImgs = $_POST['image'];
            
            $result = ExtImages::model()->saveBannerLocalImages($id, $arrImgs);
            
            if($result){
                $this->redirect("/{$prefix}/admin/widgets/bannerimages/{$id}");                    
            }else{
                echo 'error';
            }
           
        }
    
    }//end: loadfiles

    public function actionDelImageBanner($id = null){
        //Debug::d($_POST);
        $request = Yii::app()->request;
        if($request->isPostRequest){
            $currLng = SiteLng::lng()->getCurrLng()->prefix;
            $pageId = $request->getPost('page_id');
            $objImg = ImagesOfWidget::model()->findByPk((int)$id);
            if(!empty($objImg)){
                $objImg->delete();
                $this->redirect("/{$currLng}/admin/widgets/bannerimages/{$pageId}");
            } 
            
        }else{
            //exception
        }
        
        
    }

    public function actionDelImageAjax($id=null)
    {
        
        $request = Yii::app()->request;
        $currLng = Yii::app()->language;
        $arrJson=array();
        if($request->isAjaxRequest)
        {    
            $page_id = $request->getPost('page_id');
            $arrJson['html'] = $this->renderPartial('_deleteBannerImage',array('page_id' => $page_id, 'link_id' => $id, 'lang_prefix' => $currLng), true);
            echo json_encode($arrJson);
            Yii::app()->end();
        }

    }
    

}

