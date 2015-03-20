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

    public function getViewPath()
    {
        $themeManager = Yii::app()->themeManager;
        return $themeManager->basePath.DIRECTORY_SEPARATOR.Yii::app()->theme->name.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'menus';
    }


    public function run()
    {
        $this->render($this->menu->template_name,array('menu' => $this->menu));
    }
}