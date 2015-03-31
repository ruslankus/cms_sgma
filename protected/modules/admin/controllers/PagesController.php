<?php

class PagesController extends ControllerAdmin
{
    
    
    public function actionIndex($siteLng = null){
        
        $currLng = Yii::app()->language;
        
        if(empty($siteLng)){
            $siteLng = Yii::app()->language; 
        }
        
        $objPages = Page::model()->with(array('pageTrls.lng' => array('condition' => "lng.prefix='{$siteLng}'")))->findall();
        
        //Debug::d($objPages);
                
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
        
        $this->render('new_page', array('model' => $model));
        
    }//create
    
    
    public function actionEditContent($id = null){
        
        $request = Yii::app()->request;
        if($request->isAjaxRequest){
            
            $pageId = $request->getPost('pageId');
            $lngId = $request->getPost('lngId');
            
            $objPage = PageTrl::model()->findByAttributes(array('lng_id' => $lngId, 'page_id' => $pageId));
            
            $this->renderPartial('_page_edit',array('objPage' => $objPage));
            Yii::app()->end();
        }//ajax part
        
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.textarea.js',CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.edit-page-content.js',CClientScript::POS_END);
       
        $objCurrLng = SiteLng::lng()->getCurrLng();  
        
        //$objPage = ExtPage::model()->findByPk($id);
        $arrPage = ExtPage::model()->getPage($id,$objCurrLng->prefix);
        //Debug::d($arrPage);
        
        $this->render('edit_content', array('arrPage' => $arrPage, 'page_id' => $id, 'siteLng' => $objCurrLng->id ));
    }//edit
    
    public function actionDelete(){
        
    }//delete
    
    
    public function actionSaveContent($id = null){
        
    }// save
    
    
    
}//PageController    