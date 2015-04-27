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
            return self::getTemplatesFor($selectedTheme,'menus',true);
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
            return self::getTemplatesFor($selectedTheme,'widgets'.DS.$prefix,true);
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
     * @param bool $widgets
     * @return array
     */
    public static function getTemplatesFor($selectedTheme,$dir,$widgets = false)
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
            $templates = array('' => 'default');
        }

        return $templates;
    }
}