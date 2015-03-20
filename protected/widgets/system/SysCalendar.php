<?php

class SysCalendar extends CWidget
{
    //template of widget
    public $templateName;

    public function getViewPath()
    {
        $themeManager = Yii::app()->themeManager;
        return $themeManager->basePath.DIRECTORY_SEPARATOR.Yii::app()->theme->name.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'widgets'.DIRECTORY_SEPARATOR.'calendar';
    }

    public function run()
    {
        $this->render($this->templateName);
    }
}