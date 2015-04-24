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

    public $controllerMatches = array(
        ExtMenuItemType::TYPE_SINGLE_PAGE => 'pages',
        ExtMenuItemType::TYPE_NEWS_CATALOG => 'news',
        ExtMenuItemType::TYPE_PRODUCTS_CATALOG => 'products',
        ExtMenuItemType::TYPE_CONTACT_FORM => 'contacts',
        ExtMenuItemType::TYPE_COMPLEX_PAGE => 'complex'
    );

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
     * Returns URL of menu item by it's type and id
     * @param $type_id
     * @param $content_item_id
     * @param string $default_action
     * @return string
     */
    private function getUrlByType($type_id,$content_item_id,$default_action = 'show')
    {
        $url = Yii::app()->createUrl($this->controllerMatches[$type_id].'/'.$default_action,array('id' => $content_item_id));

        return $url;
    }


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
                $items_inline[$index]['url'] = $this->getUrlByType($item['type_id'],$item['content_item_id']);
                $items_inline[$index]['active'] = $this->controllerMatches[$item['type_id']] == Yii::app()->controller->id ? 1 : 0;
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