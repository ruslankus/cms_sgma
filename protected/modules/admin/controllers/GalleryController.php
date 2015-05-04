<?php

/**
 * Class GalleryController
 * Controller for admin part gallery
 */
class GalleryController extends ControllerAdmin
{
    
    public function actionIndex($page = 1){
        
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.uploaded-images.css');
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.uploaded-images.js',
            CClientScript::POS_END);
        $objImgs = Images::model()->findAll();

        //pagination
        $objPaging = CPaginator::getInstance($objImgs,3,$page);
        $objImgs = $objPaging->getPreparedArray();
        $totalPages = $objPaging->getTotalPages();
        $currentPage = $objPaging->getCurrentPage();
        $showPaginator = $objPaging->showPaginator();
        
        $this->render('image_list',array('objImgs' => $objImgs, 'totalPages'=>$totalPages,
            'currentPage'=>$currentPage,'showPaginator' => $showPaginator));
    }//index
    
    
    
    public function actionUploadFile(){
        $prefix = SiteLng::lng()->getCurrLng()->prefix;
        $request = Yii::app()->request;
        $model = new AddImageFile();
        if($request->isAjaxRequest){
            
            
            $this->renderPartial('_upload_file_form', array('model' => $model));
             
        }else{
            
            $model->attributes = $_POST['AddImageFile'];
            if($model->validate()){
                //gruzim
                $objFile = CUploadedFile::getInstance($model, 'file');
               
                $newFileName = uniqid(). "." . $objFile->extensionName;
                $path  = Yii::getPathOfAlias('webroot').'/uploads/images/';
                $path .= $newFileName;
                //write on disk
                if($objFile->saveAs($path)){
                     //Caption
                   foreach(SiteLng::lng()->getLngs() as $objLng){
                       $arrCaps[$objLng->id] = $model->captions[$objLng->prefix];
                   }
                   
                   if(ExtImages::model()->saveGalleryImage($newFileName,$arrCaps)){
                       //success
                        Yii::app()->user->setFlash('error',"File uploaded successfuly");
                        $this->redirect("/{$prefix}/admin/gallery");
                        Yii::app()->end();
                   }else{
                        //
                        Yii::app()->user->setFlash('error',"Save falie in Db failed");
                        $this->redirect("/{$prefix}/admin/gallery");
                        Yii::app()->end();
                   }
                  
                }else{
                    
                    Yii::app()->user->setFlash('error',$errors);
                    $this->redirect("/{$prefix}/admin/gallery");
                    Yii::app()->end();
                }
              
            }else{
               //errors
               $errors = array_shift($model->errors['file']);
               Yii::app()->user->setFlash('error',$errors);
               $this->redirect("/{$prefix}/admin/gallery");
            }
           
        }
    }//actionUploadFile


    /**
     * @param $id int - image Id
     * @throws CDbException
     * @throws CException
     */
    public function actionDeleteFile($id){
        $links = array();
        $controllers = array(
            'news'              => '/admin/news/edit/',
            'pages'             => '/admin/pages/pagesetting/',
            'contacts'          => '/admin/contacts/contactsettings/',
            'products'          => '/admin/products/edit/',
            'complex_fields'    => '/admin/complex/editpagefields/',
            'complex'           => '/admin/complex/edit/',
            'widgets'           => '/admin/widgets/bannerimages/',
            'product_fields'    => '/admin/products/editprodfields/'
        );

        $prefix = SiteLng::lng()->getCurrLng()->prefix;
        $request = Yii::app()->request;
        if($request->isAjaxRequest){

            //check available in another pages
            $arrCount = ExtImages::model()->checkAvailable($id);
            
            if(!empty($arrCount)){

                foreach($arrCount as $key => $value){
                    if(!empty($value)){
                        foreach($value as $val){
                            $links[] = "/{$prefix}".$controllers[$key].$val['page_id'];
                        }
                    }
                }

                $this->renderPartial('_delete_file_restrict', array('links'=> $links));
            }

            $this->renderPartial('_delete_file');
            Yii::app()->end();
        }elseif($request->isPostRequest){


            $objImg = Images::model()->findByPk($id);
            // if images exist - delete them
            if(!empty($objImg)){
                $fileName = $objImg->filename;
                $path  = Yii::getPathOfAlias('webroot').'/uploads/images/';
                $path .= $fileName;
                
                if($objImg->delete()){
                    
                    @unlink($path);
                    
                    Yii::app()->user->setFlash('error',"File {$fileName} has ben deleted");
                    $this->redirect("/{$prefix}/admin/gallery");
                }
                
            }else{
                //error
                throw new CHttpException('404   ');
            }

        }
    }//actionDeleteFile

    /**
     * Deleting multiple images from gallery
     * @throws CException
     */
    public function actionDelMultFiles(){
        $prefix = SiteLng::lng()->getCurrLng()->prefix;
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            
            if(isset($_POST['image'])){
                $arrKeys = array();
                foreach($_POST['image'] as $key => $value){
                    $arrKeys[] = $key;
                }

                //checking for avialiable in others pages
                /*
                foreach($arrKeys as $key){
                    $arrImg = ExtImages::model()->checkAvailable($key);
                    if(!empty($arrImg)){
                        $this->renderPartial('_delete_mult_file_restrict');
                        Yii::app()->end();
                    }
                }
                */
                
                $objImages = Images::model()->findAllByPk($arrKeys);
                
                $this->renderPartial('_delete_mult_files',array('objImgs' => $objImages));
                Yii::app()->end();
            }
            
        }elseif($request->isPostRequest){
            $arrKeys = array();
            $arrFileNames = array();
            $path  = Yii::getPathOfAlias('webroot').'/uploads/images/';
            foreach($_POST['image'] as $key => $value){
                $arrKeys[] = $key;
            }
            
            
            $result = images::model()->deleteByPk($arrKeys);
             
            if($result){
                foreach($_POST['image'] as $key => $value){
                    $filepath = $path . $value;
                    //deleting file
                    @unlink($filepath);
                    $arrFileNames[] = $value; 
                }
            
                $fileNameString = implode(", ",$arrFileNames);
                Yii::app()->user->setFlash('error',"Files: {$fileNameString} have been deleted");
                $this->redirect("/{$prefix}/admin/gallery");   
                
            }else{
                //error
                throw new CHttpException('404');
            }
          
        }//end: $request->isPostRequest
    }//end: actionDelMultFiles
    
    
}//end class
?>
