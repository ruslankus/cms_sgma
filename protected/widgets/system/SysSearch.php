<?php

class SysSearch extends CWidget
{

    /**
     * @var ExtSystemWidget
     */
    public $widgetInfo;
    public $themeName;


    public $default_template = 'search';
    public $use_default_template = true;

    /**
     * Override of getting view dir for widget
     * @param bool $checkTheme
     * @return string
     */
    public function getViewPath($checkTheme=false)
    {

        $path = Yii::app()->getBasePath().DS.'widgets'.DS.'views';

        if(!$this->use_default_template)
        {
            $theme = Yii::app()->themeManager->getTheme($this->themeName);
            $prefix = $this->widgetInfo->type->prefix;
            $path = $theme->getBasePath().DS.'views'.DS.'widgets'.DS.$prefix;
        }

        return $path;
    }

    /**
     * Check if we need use default template
     * @return bool
     */
    public function isDefaultTemplate()
    {
        $theme = Yii::app()->themeManager->getTheme($this->themeName);

        if(!empty($theme))
        {
            if(!empty($this->widgetInfo->template_name))
            {
                $themeViewPath = $theme->getBasePath().DS.'views'.DS.'menus';
                if(file_exists($themeViewPath.DS.$this->widgetInfo->template_name))
                {
                    return false;
                }
            }
        }

        return true;
    }

    /******************************************************************************************************************/



    public function run()
    {
        $this->use_default_template = $this->isDefaultTemplate();

        $template = $this->widgetInfo->template_name;
        $template = str_replace(".php","",$template);

        if($this->use_default_template){
            $template = $this->default_template;
        }

        $this->render($template);
    }
}