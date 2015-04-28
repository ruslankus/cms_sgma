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

    public $default_template = 'menu';
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
            $path = $theme->getBasePath().DS.'views'.DS.'menus';
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
            if(!empty($this->menu->template_name))
            {
                $themeViewPath = $theme->getBasePath().DS.'views'.DS.'menus';
                if(file_exists($themeViewPath.DS.$this->menu->template_name))
                {
                    return false;
                }
            }
        }

        return true;
    }


    /*****************************************************************************************************************/

    /**
     * Make nested array from inline by recursive method
     * @param $full_arr
     * @param int $parent_id
     * @return array
     */
    private function makeNested($full_arr,$parent_id = 0)
    {
        $result = array();
        $operableItems = array();

        foreach($full_arr as $item)
        {
            if($item['parent_id'] == $parent_id)
            {
                $operableItems[] = $item;
            }
        }

        foreach($operableItems as $index => $itemIn)
        {
            if($itemIn['has_children'] == 0)
            {
                $result[$index] = $itemIn;
            }
            else
            {
                $result[$index] = $itemIn;
                $result[$index]['children'] = $this->makeNested($full_arr,$itemIn['id']);
            }
        }

        return $result;
    }

    /*****************************************************************************************************************/

    /**
     * Widget entry point
     */
    public function run()
    {

        $this->use_default_template = $this->isDefaultTemplate();

        $template = $this->menu->template_name;
        $template = str_replace(".php","",$template);

        if($this->use_default_template){
            $template = $this->default_template;
        }

        $items_inline = array();
        $items_nested = array();

        if($this->menu->status_id == ExtStatus::VISIBLE)
        {
            $items = $this->menu->buildMenuItemsArrayFromObjArr(0,true);

            foreach($items as $index => $item)
            {
                $items_inline[$index] = $item;
            }

            $items_nested = $this->makeNested($items_inline);
        }

        $params = array(
            'label' => $this->menu->label,
            'items_inline' => $items_inline,
            'items_nested' => $items_nested
        );

        $this->render($template,$params);
    }
}