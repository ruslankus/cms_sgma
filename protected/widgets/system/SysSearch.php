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
        return $themeManager->basePath.DS.Yii::app()->theme->name.DS.'views'.DS.'widgets';
    }
    
    public function run()
    {
        $this->render($this->widgetInfo->template_name);
    }
}