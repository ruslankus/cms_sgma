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

    /**
     * Override of getting view dir for widget
     * @param bool $checkTheme
     * @return string
     */
    public function getViewPath($checkTheme=false)
    {
        $themeManager = Yii::app()->themeManager;
        return $themeManager->basePath.DS.Yii::app()->theme->name.DS.'views'.DS.'menus';
    }

    public function run()
    {
        $this->render($this->menu->template_name,array('label' => $this->menu->label));
    }
}