<?php

/**
 * Class ExtMenuItem
 * @property ExtMenu $menu
 * @property NewsCategory[] $newsCategories
 * @property ProductCategory[] $productCategories
 */
Class ExtMenuItem extends MenuItem
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
        $count = ExtMenuItem::model()->countByAttributes(array('menu_id' => $this->menu_id, 'parent_id' => $this->id));
        return $count > 0;
    }

    /**
     * Has parent or not
     * @return bool
     */
    public function hasParent()
    {
        $count = ExtMenuItem::model()->countByAttributes(array('id' => $this->parent_id, 'menu_id' => $this->menu_id));
        return $count > 0;
    }

    /**
     * Quantity of children
     */
    public function countOfChildren()
    {
        $count = ExtMenuItem::model()->countByAttributes(array('menu_id' => $this->menu_id, 'parent_id' => $this->id));
        return $count;
    }

    /**
     * Returns nesting level
     * @return int
     */
    public function nestingLevel()
    {
        $arrBranch = array();
        $branchStr = $this->branch;
        if(!empty($branchStr))
        {
            $arrBranch = explode(":",$branchStr);
        }

        return !empty($arrBranch) ? count($arrBranch) - 1 : 1;
    }

    /**
     * Get translated name by language ID
     * @param $lngId
     * @return string
     */
    public function trlName($lngId)
    {
        $result = "";
        $arrTrl = $this->menuItemTrls;

        foreach($arrTrl as $trl)
        {
            if($trl->lng_id == $lngId)
            {
                $result = $trl->value;
            }
        }

        return $result;
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

        //return modified relations
        return $relations;
    }
}