<?php
class GalleryController extends ControllerAdmin
{
    
    public function actionIndex(){
        
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.uploaded-images.css');
        Yii::app()->clientScript->registerCssFile($this->assetsPath.'/css/vendor.lightbox.css');
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.uploaded-images.js',CClientScript::POS_END);
        $objImgs = Images::model()->findAll();
        
        $this->render('image_list',array('objImgs' => $objImgs));
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
    
    public function actionDeleteFile($id){
        $prefix = SiteLng::lng()->getCurrLng()->prefix;
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            
            $this->renderPartial('_delete_file');
      
        }elseif($request->isPostRequest){
            
            $objImg = Images::model()->findByPk($id);
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
            }
            
                  
        }
    }//actionDeleteFile
    
    
    public function actionDelMultFiles(){
        $prefix = SiteLng::lng()->getCurrLng()->prefix;
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            
            if(isset($_POST['image'])){
                $arrKeys = array();
                foreach($_POST['image'] as $key => $value){
                    $arrKeys[] = $key;
                }
                
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
            }
          
        }//end: $request->isPostRequest
    }//end: actionDelMultFiles
    
    
}//end class
?>
