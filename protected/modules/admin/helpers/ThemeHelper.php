<?php

class ThemeHelper
{
    /**
     * Returns all menu templates for concrete theme
     * @param $selectedTheme
     * @return array
     */
    public static function getTemplatesForMenu($selectedTheme)
    {
        if(!empty($selectedTheme) && Yii::app()->themeManager->getTheme($selectedTheme) != null)
        {
            $templates = self::getTemplatesFor($selectedTheme,'menus',false,true);
            if(!empty($templates))
            {
                return $templates;
            }
        }
        return array('' => 'default');
    }


    /**
     * Returns all widget templates for concrete theme
     * @param $selectedTheme
     * @param string $prefix
     * @return array|null
     */
    public static function getTemplatesForWidgets($selectedTheme, $prefix = '')
    {

        if(!empty($selectedTheme) && Yii::app()->themeManager->getTheme($selectedTheme) != null)
        {
            $templates = self::getTemplatesFor($selectedTheme,'widgets'.DS.$prefix,false,true);
            if(!empty($templates))
            {
                return $templates;
            }
        }

        return array('' => 'default');
    }


    /**
     * Returns all widget templates for concrete theme
     * @param $selectedTheme
     * @return array
     */
    public static function getTemplatesForPages($selectedTheme)
    {
        return self::getTemplatesFor($selectedTheme,'pages');
    }


    /**
     * Returns all templates in specified dir for concrete theme
     * @param $selectedTheme
     * @param $dir
     * @param bool $returnNullForEmpty
     * @param bool $widgets
     * @return array|null
     */
    public static function getTemplatesFor($selectedTheme,$dir,$returnNullForEmpty = false, $widgets = false)
    {
        if(!empty($selectedTheme) && Yii::app()->themeManager->getTheme($selectedTheme) != null)
        {
            $themeManager = Yii::app()->themeManager;
            $dir = $themeManager->basePath.DS.$selectedTheme.DS.'views'.DS.$dir;
        }
        else
        {
            $dir = !$widgets ? Yii::app()->basePath.DS.'views'.DS.$dir : Yii::app()->basePath.DS.'widgets'.DS.'views';
        }


        $templates = array();

        if(is_dir($dir))
        {
            $files = scandir($dir);
            foreach($files as $fileName)
            {
                if($fileName != ".." && $fileName != ".")
                {
                    $templates[$fileName] = $fileName;
                }
            }
        }
        else
        {
            $templates = $returnNullForEmpty ? null : array('' => ATrl::t()->getLabel('Default'));
        }

        return $templates;
    }
}