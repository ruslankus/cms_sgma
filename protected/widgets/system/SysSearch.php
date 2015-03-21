<?php

class SysSearch extends CWidget
{
    /**
     * @var ExtSystemWidget
     */
    public $widgetInfo;

    /**
     * Override of getting view dir for widget
     * @param bool $checkTheme
     * @return string
     */
    public function getViewPath($checkTheme=false)
    {
        $themeManager = Yii::app()->themeManager;
        return $themeManager->basePath.DIRECTORY_SEPARATOR.Yii::app()->theme->name.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'widgets'.DIRECTORY_SEPARATOR.'search';
    }
    
    public function run()
    {
        $this->render($this->widgetInfo->template_name);
    }
}