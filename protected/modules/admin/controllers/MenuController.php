<?php

class MenuController extends ControllerAdmin
{
    /**
     * Index
     */
    public function actionIndex()
    {
        $this->render('index');
    }
}