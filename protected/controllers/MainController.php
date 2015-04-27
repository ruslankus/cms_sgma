<?php

class MainController extends Controller
{
    /*
    public function init(){
        Yii::app()->theme = "new_theme";
    }
    */

    /**
     * Entry
     */

    
    public function actionIndex()
    {
    	//$this->layout = "site";
        $this->title = "SIGMA";
        $this->description = "Index Page";
        $model = new SendContactForm();
        //$this->renderText("Hello world");
        $this->render('main',array('model'=>$model));
        
    }


}