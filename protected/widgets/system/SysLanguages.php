<?php

class SysLanguages extends CWidget
{
    /**
     * @var ExtSystemWidget
     */
    public $widgetInfo;

    public function getViewPath()
    {
        $themeManager = Yii::app()->themeManager;
        return $themeManager->basePath.DIRECTORY_SEPARATOR.Yii::app()->theme->name.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'widgets'.DIRECTORY_SEPARATOR.'languages';
    }

    public function run()
    {
        $this->render($this->widgetInfo->template_name);
    }
}