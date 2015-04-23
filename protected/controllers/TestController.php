<?php

class TestController extends Controller
{


    public function actionIndex()
    {
    	//$this->layout = "site";
        $this->title = "SIGMA";
        $this->description = "Index Page";
        $model = new SendContactForm();
        //$this->renderText("Hello world");
        $this->render('test',array('model'=>$model));
        
    }

}