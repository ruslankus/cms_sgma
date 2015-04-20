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
    }
    
    
}//end class
?>
