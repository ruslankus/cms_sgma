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

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
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
     * @return bool
     */
    public function hasParent()
    {
        $count = self::model()->countByAttributes(array('id' => $this->parent_id, 'menu_id' => $this->menu_id));
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
     * @param bool $byBranch
     * @return int
     */
    public function nestingLevel($byBranch = false)
    {
        if($byBranch)
        {
            $arrBranch = array();
            $branchStr = $this->branch;
            if(!empty($branchStr))
            {
                $arrBranch = explode(":",$branchStr);
            }

            return !empty($arrBranch) ? count($arrBranch) - 1 : 1;
        }
        else
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