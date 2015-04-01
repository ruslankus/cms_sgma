<?php

class SysMenu extends CWidget
{
    /**
     * @var string|int
     */
    public $current = null;

    /**
     * @var ExtMenu
     */
    public $menu;
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
            $path = $theme->getBasePath().DS.'views'.DS.'menus';
        }
        return $path;

    }

    public function run()
    {
        $template = $this->menu->template_name;
        $template = str_replace(".php","",$template);

        $this->render($template,array('label' => $this->menu->label));
    }
}