<?php

class MenuController extends ControllerAdmin
{
    /**
     * Index
     */
    public function actionIndex()
    {
        /* @var $menus ExtMenu[] */
        $menus = ExtMenu::model()->findAll();
        $this->render('index',array('menus' => $menus));
    }
}