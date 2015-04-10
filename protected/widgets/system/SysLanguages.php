<?php

class SysLanguages extends CWidget
{
    /**
     * @var ExtSystemWidget
     */
    public $widgetInfo;
    public $themeName;
    public $defoult_template = 'languages';

    /**
    * Override of getting view dir for widget
    * @param bool $checkTheme
    * @return string
    */
    public function getViewPath($checkTheme=false)
    {
        
        $path = Yii::app()->getBasePath().DS.'widgets'.DS.'views';
        $theme = Yii::app()->themeManager->getTheme($this->themeName);
        $prefix = $this->widgetInfo->type->prefix;
        
        if(!empty($theme) && !empty($this->widgetInfo->template_name))
        {
            $path = $theme->getBasePath().DS.'views'.DS.'widgets'.DS.$prefix;
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
        $template = $this->defoult_template;
        
        foreach($languages as $index => $language)
        {
            $url = Yii::app()->request->url;
            $urlArray = explode('/',$url);
            $urlArray[1] = $language->prefix;
            $url = implode('/',$urlArray);

            $arrayLanguages[$index] = $language->attributes;
            $arrayLanguages[$index]['url'] = $url;
        }

        if(!empty($this->widgetInfo->template_name)){
            $template = $this->widgetInfo->template_name;
            $template = str_replace(".php","",$template);
        }

        $this->render($template,array('languages' => $arrayLanguages));
    }
}