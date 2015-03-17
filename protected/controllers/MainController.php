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

        $val = Trl::t()->getLabel('label');
        Debug::out(Yii::app()->language);
        exit('test');

        $this->renderText("Hello world!");

    }
}