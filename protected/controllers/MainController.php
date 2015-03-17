<?php

class MainController extends Controller
{
    /**
     * Entry
     */
    public function actionIndex()
    {
        $this->title = "SIGMA";
        $this->description = "Index Page";

//        $val = ;
//        Debug::out(Yii::app()->language);
//        exit('test');

        $this->renderText(Trl::t()->getLabel('label'));

    }
}