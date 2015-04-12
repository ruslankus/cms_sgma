<?php

class PagesController extends ControllerAdmin
{
    
    public function init(){
        //Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.css'); 
        //Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lighbox.css');  
    }
    
    
    public function actionIndex($siteLng = null){
        
        $currLng = Yii::app()->language;
       
        if(empty($siteLng)){
            $siteLng = Yii::app()->language; 
        }
        
        $objPages = Page::model()->with(array('pageTrls.lng' => array('condition' => "lng.prefix='{$siteLng}'")))->findall();
        
        //Debug::d($currLng);
                
        $this->render('index',array('objPages' => $objPages, 'currLng' => $currLng));
        
    }//index
    
    
    public function actionCreate(){
        
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-page.js',CClientScript::POS_END);
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
                
                $result = ExtPageTrl::model()->setNewPage($model->page_label,$arrTitle);
                if($result){
                    $this->redirect('index');
                }else{
                    
                }
            }
       
        }
        
        $prefix = SiteLng::lng()->getCurrLng()->prefix;
        
        $this->render('new_page', array('model' => $model,'prefix'=> $prefix));
        
    }//create
    
    
    public function actionEditContent($id = null){
        
        $model = new SavePageForm();
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            
            $pageId = $request->getPost('pageId');
            $lngId = $request->getPost('lngId');
            
            $objPage = PageTrl::model()->findByAttributes(array('lng_id' => $lngId, 'page_id' => $pageId));
            
            $this->renderPartial('_page_edit',array('objPage' => $objPage, 'model' => $model));
            Yii::app()->end();
        }//ajax part
        
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');
        
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/ckeditor/ckeditor.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/ckeditor/adapters/jquery.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-page-content.js',CClientScript::POS_END);
       
        $objCurrLng = SiteLng::lng()->getCurrLng();  
        
        //$objPage = ExtPage::model()->findByPk($id);
        $arrPage = ExtPage::model()->getPage($id,$objCurrLng->prefix);
        //Debug::d($arrPage);
        
        $this->render('edit_content', array('arrPage' => $arrPage,'model' =>$model,
         'page_id' => $id, 'siteLng' => $objCurrLng->id, 'lngPrefix' => $objCurrLng->prefix ));
    }//edit
    
    public function actionDelete(){
        
    }//delete
    
    
    public function actionSaveContent($id = null){
        
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            //Debug::d($_POST);
            $model = new SavePageForm();
            $model->attributes = $_POST['SavePageForm'];
            if($model->validate()){
                
                $objData = PageTrl::model()->findByAttributes(array('lng_id' => $model->lngId,
                'page_id' => $model->pageId));
                if(!empty($objData)){
                    
                    $objData->content = strip_tags($model->content);
                    $objData->title = $model->title;
                    if($objData->update()){
                        $this->renderPartial('_success_page_edit',array('model' => $model));
                        Yii::app()->end();    
                    }else{
                        Debug::d($objData);
                    }
                    
                }else{
                    Debug::d($model);
                }
           
            }else{
                $this->renderPartial('_error_page_edit',array('model' => $model));
                Yii::app()->end();
            }
            
        
        }else{
            //excepton    
        }
        
    }// save
    
    
    public function actionPageSetting($id = null){
        
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-page-content.js',CClientScript::POS_END);
        
        //
        //$objPage = Page::model()->findByPk($id);
        $model = new AddPageFile();
        if(!empty($_POST['AddPageFile'])){
            //Debug::d($_POST);
            $model->attributes = $_POST['AddPageFile'];
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
                   
                   if(ExtImages::model()->savePageFile($newFileName, $id, $arrCaps)){
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
        
        $arrPage = ExtPage::model()->getPageWithImage($id, $lngObj->prefix);
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
            $this->render('page_setting',array('page_id' => $id, 'arrPage' => $arrPage,
             'arrImages' => $arrComb, 'model' => $model, 'lngPrefix' => $lngObj->prefix,'elCount' => $elCount));    
        
        }else{
            $prefix = $lngObj->prefix;
            $this->redirect("/{$prefix}/admin/pages/index");
        }
        
        
     
    }//pageSetting
    
    
    
    /**
     * @param $id - int Image-page links id
     */
    public function actionDelImagePage($id = null){
        //Debug::d($_POST);
        $request = Yii::app()->request;
        if($request->isPostRequest){
            $currLng = SiteLng::lng()->getCurrLng()->prefix;
            $pageId = $request->getPost('page_id');
            $objImg = ImagesOfPage::model()->findByPk((int)$id);
            if(!empty($objImg)){
                $objImg->delete();
                $this->redirect("/{$currLng}/admin/pages/pagesetting/{$pageId}");
            } 
            
        }else{
            //exception
        }
        
        
    }
    
    
    
    /*---------------------- AJAX ---------------------- */
    
    /**
     * @param $id - int Image-page links id
     */
    public function actionDelImageAjax($id=null)
    {
        
        $request = Yii::app()->request;
        $currLng = Yii::app()->language;
        $arrJson=array();
        if($request->isAjaxRequest)
        {    
            $page_id = $request->getPost('page_id');
            $arrJson['html'] = $this->renderPartial('_deletePageImage',array('page_id' => $page_id, 'link_id' => $id, 'lang_prefix' => $currLng), true);
            echo json_encode($arrJson);
            Yii::app()->end();
        }

    }
    
    
    /**
     * @param $id int Page id
     */
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
            
            $result = ExtImages::model()->savePageLocalImages($id, $arrImgs);
            
            if($result){
                $this->redirect("/{$prefix}/admin/pages/pagesetting/{$id}");                    
            }else{
                echo 'error';
            }
           
        }
    
    }//end: loadfiles
    
    
    
    
}//PageController    