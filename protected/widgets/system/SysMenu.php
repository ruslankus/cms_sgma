<?php

class SysMenu extends CWidget
{
    //template of widget
    public $templateName;

    //current category/page/link
    public $current;

    public function getViewPath()
    {
        $themeManager = Yii::app()->themeManager;
        return $themeManager->basePath.DIRECTORY_SEPARATOR.Yii::app()->theme->name.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'menus';
    }


    public function run()
    {
        $this->render($this->templateName);
    }
}