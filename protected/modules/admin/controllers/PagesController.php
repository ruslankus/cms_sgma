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
        Yii::app()->clientScript->registerScriptFile($this->assetsPath.'/js/vendor.add-menu.js',CClientScript::POS_END);
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
    
    
    public function actionEdit($id = null){
        
         if(empty($siteLng)){
            $siteLng = Yii::app()->language; 
        }
        
       
        //$objPage = ExtPage::model()->findByPk($id);
        $arrPage = ExtPage::model()->getPage();
        //Debug::d($objPage->trl);
        
        $this->render('edit', array('arrPage' => $arrPage ));
    }//edit
    
    public function actionDelete(){
        
    }//delete
    
    
    
}//PageController    