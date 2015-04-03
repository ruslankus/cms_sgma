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
        $themeManager = Yii::app()->themeManager;
        $dir = $themeManager->basePath.DS.$selectedTheme.DS.'views'.DS.'menus';
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


    /**
     * Returns all widget templates for concrete theme
     * @param $selectedTheme
     * @return array
     */
    public static function getTemplatesForWidgets($selectedTheme)
    {
        $themeManager = Yii::app()->themeManager;
        $dir = $themeManager->basePath.DS.$selectedTheme.DS.'views'.DS.'widgets';
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


    /**
     * Returns all widget templates for concrete theme
     * @param $selectedTheme
     * @return array
     */
    public static function getTemplatesForPages($selectedTheme)
    {
        $themeManager = Yii::app()->themeManager;
        $dir = $themeManager->basePath.DS.$selectedTheme.DS.'views'.DS.'pages';
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