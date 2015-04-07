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
        return self::getTemplatesFor($selectedTheme,'menus');
    }


    /**
     * Returns all widget templates for concrete theme
     * @param $selectedTheme
     * @return array
     */
    public static function getTemplatesForWidgets($selectedTheme)
    {
        return self::getTemplatesFor($selectedTheme,'widgets');
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
     * @return array
     */
    public static function getTemplatesFor($selectedTheme,$dir)
    {
        $themeManager = Yii::app()->themeManager;
        $dir = $themeManager->basePath.DS.$selectedTheme.DS.'views'.DS.$dir;
        $files = scandir($dir);
        $templates = array();

        foreach($files as $fileName)
        {
            if($fileName != ".." && $fileName != ".")
            {
                $templates[$fileName] = $fileName;
            }
        }

        return $templates;
    }
}