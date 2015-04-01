<?php

class SysCustom extends CWidget
{
    /**
     * @var ExtSystemWidget
     */
    public $widgetInfo;
    public $themeName;

    /**
     * Override of getting view dir for widget
     * @param bool $checkTheme
     * @return string
     */
    public function getViewPath($checkTheme=false)
    {
        $path = Yii::app()->getBasePath().DS.'widgets'.DS.'views';
        $theme = Yii::app()->themeManager->getTheme($this->themeName);
        if(!empty($theme))
        {
            $path = $theme->getBasePath().DS.'views'.DS.'widgets';
        }
        return $path;
    }

    /*****************************************************************************************************************/

    public function run()
    {
        $template = $this->widgetInfo->template_name;
        $template = str_replace(".php","",$template);

        $params = array(
            'label' => $this->widgetInfo->label,
            'title' => $this->widgetInfo->trl->custom_name,
            'text' => $this->widgetInfo->trl->custom_html
        );

        $this->render($template,$params);
    }
}