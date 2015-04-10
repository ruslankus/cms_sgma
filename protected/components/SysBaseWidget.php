<?php

    abstract class SysBaseWidget extends CWidget
    {
        
         /**
        * @var ExtSystemWidget
        */
        public $widgetInfo;
        public $themeName;
        public $template;
        
        
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
        
        if(!empty($theme))
        {
            $path = $theme->getBasePath().DS.'views'.DS.'widgets'.DS.$prefix;
        }
        return $path;
    }

    public function run()
    {
        $this->template = $this->widgetInfo->template_name;
        $this->template = str_replace(".php","",$template);

    }

        
        
        
    }//class

?>