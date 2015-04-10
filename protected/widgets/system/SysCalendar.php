<?php

class SysCalendar extends CWidget
{
    
        /**
        * @var ExtSystemWidget
        */
        public $widgetInfo;
        public $themeName;
        public $defoult_template = 'calendar';
        
    
    /** Override of getting view dir for widget
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
    
    
    public function run()
    {
       $template = $this->defoult_template;
        if(!empty($this->widgetInfo->template_name)){
            $template = $this->widgetInfo->template_name;
            $template = str_replace(".php","",$template);
        }
        
        

        $this->render($template);
    }
}