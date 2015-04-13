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
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            
            $model = new AddImageFile();
            $this->renderPartial('_upload_file_form', array('model' => $model));
             
        }else{
            
            Debug::d($_POST);
            
            
        }
    }
    
    
}//end class
?>
