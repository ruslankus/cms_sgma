<?php

class SysLanguages extends CWidget
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

    /**
     * Main entry
     */
    public function run()
    {
        $arrayLanguages = array();
        $languages = SiteLng::lng()->getLngs();

        foreach($languages as $index => $language)
        {
            $arrayLanguages[$index] = $language->attributes;
            $arrayLanguages[$index]['url'] = "#"; //TODO: form url for language switching
        }

        $template = $this->widgetInfo->template_name;
        $template = str_replace(".php","",$template);

        $this->render($template,array('languages' => $arrayLanguages));
    }
}