<?php

/**
 * Class ExtMenuItem
 * @property ExtMenu $menu
 * @property MenuItemTrl $trl
 * @property NewsCategory[] $newsCategories
 * @property ProductCategory[] $productCategories
 */
class ExtMenuItem extends MenuItem
{

    //types of target (opens in new window or not)
    const LINK_TYPE_TARGET_BLANK = 2;
    const LINK_TYPE_TARGET_NONE = 1;

    //item types matches with controllers
    public $controllerMatches = array(
        ExtMenuItemType::TYPE_SINGLE_PAGE => 'pages',
        ExtMenuItemType::TYPE_NEWS_CATALOG => 'news',
        ExtMenuItemType::TYPE_PRODUCTS_CATALOG => 'products',
        ExtMenuItemType::TYPE_CONTACT_FORM => 'contacts',
        ExtMenuItemType::TYPE_COMPLEX_PAGE => 'complex'
    );

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Returns url to content item (for site - uses current language)
     * @param string $default_action
     * @param bool $abs
     * @param null $type
     * @param null $content_item_id
     * @return string
     */
    public function getUrlForSite($abs = false, $default_action = 'show', $type = null, $content_item_id = null)
    {
        //if type or content item not set
        if($type == null || $content_item_id == null)
        {
            //if this is remote direct link
            if($this->type_id == ExtMenuItemType::TYPE_LINK)
            {
                //just return it
                return $this->link_string;
            }

            //if should return absolute
            if($abs)
            {
                //create absolute url using type and content item of this menu item
                return Yii::app()->createAbsoluteUrl(
                    $this->controllerMatches[$this->type_id].'/'.$default_action,
                    array('id' => $this->content_item_id)
                );
            }

            //create relative url using type and content item of this menu item
            return Yii::app()->createUrl(
                $this->controllerMatches[$this->type_id].'/'.$default_action,
                array('id' => $this->content_item_id)
            );
        }
        //if set content item and type
        else
        {
            //create links using this data
            if($abs)
            {
                return Yii::app()->createAbsoluteUrl(
                    $this->controllerMatches[$type].'/'.$default_action,
                    array('id' => $content_item_id)
                );
            }
            return Yii::app()->createUrl(
                $this->controllerMatches[$type].'/'.$default_action,
                array('id' => $content_item_id)
            );
        }
    }


    /**
     * Returns url to content item (for admin panel - uses first language from site languages)
     * @param bool $abs
     * @param string $default_action
     * @param null $type
     * @param null $content_item_id
     * @return string
     */
    public function getUrl($abs = false, $default_action = 'show', $type = null, $content_item_id = null)
    {
        //get all languages
        $arrSiteLanguages = SiteLng::lng()->getLngs();
        //get first language
        $firstLng = !empty($arrSiteLanguages) ? $arrSiteLanguages[0] : null;
        //empty url
        $url = '';

        if($abs)
        {
            $url = Yii::app()->request->hostInfo.'/';
        }

        if(!empty($firstLng))
        {
            $url.=$firstLng->prefix.'/';
        }

        if($type == null || $content_item_id == null)
        {
            $url.=$this->controllerMatches[$this->type_id].'/'.$default_action.'/'.$this->content_item_id;
        }
        else
        {
            $url.=$this->controllerMatches[$type].'/'.$default_action.'/'.$content_item_id;
        }

        return $url;
    }

    /**
     * Has children or not
     * @return bool
     */
    public function hasChildren()
    {
        return $this->countOfChildren() > 0;
    }


    /**
     * Has parent or not
     * @param int $ignoreParentId
     * @return bool
     */
    public function hasParent($ignoreParentId = 0)
    {
        $count = 0;
        if($this->parent_id != $ignoreParentId)
        {
            $count = self::model()->countByAttributes(array('id' => $this->parent_id, 'menu_id' => $this->menu_id));
        }

        return $count > 0;
    }

    /**
     * Returns parent of this item
     * @return self
     */
    public function getParent()
    {
        $parent = self::model()->findByPk($this->parent_id);
        return $parent;
    }

    /**
     * Quantity of children
     */
    public function countOfChildren()
    {
        $count = self::model()->countByAttributes(array('menu_id' => $this->menu_id, 'parent_id' => $this->id));
        return $count;
    }

    /**
     * Returns nesting level
     * @return int
     */
    public function nestingLevel()
    {
        $level = 1;
        $current = $this;
        while($current->hasParent())
        {
            $current = $current->getParent();
            $level++;
        }

        return $level;
    }

    /**
     * Build array with bread-crumbs path links
     * @param bool $translate
     * @param bool $systemLinks
     * @param bool $includeRoot
     * @param null $rootTitle
     * @param null $rootLink
     * @return array
     */
    public function buildBreadCrumbs($translate = false, $systemLinks = true, $includeRoot = false, $rootTitle = null, $rootLink = null)
    {
        $array = array();
        $current = $this;

        $menu = $this->menu;

        while(!empty($current))
        {
            $link = $systemLinks ? Yii::app()->createUrl('admin/menu/menuitems',array('id' => $current->menu_id, 'pid' => $current->id)) : $current->getUrlForSite();
            $array[$link] = !$translate ? $current->label : $current->trl->value;
            $current = $current->getParent();
        }

        if($includeRoot)
        {
            if($rootTitle == null || $rootLink == null)
            {
                $array[Yii::app()->createUrl('admin/menu/menuitems',array('id' => $menu->id))] = $menu->label;
            }
            else
            {
                $array[$rootLink] = $rootTitle;
            }
        }

        return array_reverse($array);
    }


    /**
     * Deletes all children of item
     */
    public function deleteChildren()
    {
        /* @var $child ExtMenuItem */
        $menu = $this->menu;

        if(!empty($menu))
        {
            $children = $menu->buildObjArrRecursive($this->id);

            foreach($children as $child)
            {
                $child->delete();
            }
        }

    }

    /**
     * Get translation for specified language
     * @param $lngId
     * @return MenuItemTrl
     */
    public function getTrl($lngId)
    {
        //all translations
        $translations = $this->menuItemTrls;

        //select just one by lng id
        foreach($translations as $trl)
        {
            if($trl->lng_id == $lngId)
            {
                return $trl;
            }
        }

        //or return new empty if not found
        return new MenuItemTrl();
    }

    /**
     * Override, relate with extended models
     * @return array relational rules.
     */
    public function relations()
    {
        //get all relations from base class
        $relations = parent::relations();

        //pass through all
        foreach($relations as $name => $relation)
        {
            //if found extended file for this related class
            if(file_exists(dirname(__FILE__).DS.'Ext'.$relation[1].'.php'))
            {
                $relations[$name][1] = 'Ext'.$relation[1];
            }
        }

        //relate with translation
        $lng = Yii::app()->language;
        $relations['trl'] = array(self::HAS_ONE, 'MenuItemTrl', 'menu_item_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}