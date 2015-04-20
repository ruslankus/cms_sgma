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
                
                
            }else{
               //errors
               $errors = array_shift($model->errors['file']);
               Yii::app()->user->setFlash('error',$errors);
               $this->redirect("/{$prefix}/admin/gallery");
            }
           
        }
    }
    
    
}//end class
?>
