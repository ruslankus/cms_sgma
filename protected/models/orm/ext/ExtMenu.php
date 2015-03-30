<?php

/**
 * Class ExtMenu
 */
Class ExtMenu extends Menu
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
     * Gets all items with translations (SQL)
     * @return array|CDbDataReader
     */
    public function getAllItemsWithTrlSQL()
    {
        $sql = "SELECT t1.*, t2.value as trl FROM menu_item t1
                JOIN menu_item_trl t2 ON t2.menu_item_id = t1.id
                JOIN languages t3 ON t2.lng_id = t3.id
                WHERE t3.prefix = :prefix AND t1.menu_id = :id";

        $params[':prefix'] = Yii::app()->language;
        $params[':id'] = $this->id;

        $con = $this->dbConnection;
        $data=$con->createCommand($sql)->queryAll(true,$params);

        return $data;
    }

    /**
     * Build recursive array of menu items (ORM) - use it for admin templates
     * @param int $parent_id
     * @return array
     */
    public function buildObjArrRecursive($parent_id = 0)
    {
        /* @var $all ExtMenuItem[] */
        /* @var $tmp ExtMenuItem[] */

        $arr_result = array();
        $all = ExtMenuItem::model()->findAllByAttributes(array('menu_id' => $this->id, 'parent_id' => $parent_id),array('order' => 'priority DESC'));

        foreach($all as $item)
        {
            $arr_result[] = $item;

            if($item->hasChildren())
            {
                $tmp = $this->buildObjArrRecursive($item->id);

                foreach($tmp as $itemTmp)
                {
                    $arr_result[] = $itemTmp;
                }
            }
        }

        return $arr_result;
    }


    /**
     * Build array which looks like (id => label), special for form-use
     * @param int $parent_id
     * @param bool $appendNestingLines
     * @param bool $add_root
     * @return array
     */
    public function arrayForMenuItemForm($parent_id = 0,$appendNestingLines = true, $add_root = true)
    {
        /* @var $all ExtMenuItem[] */

        $result = array();

        //get all items
        $all = $this->buildObjArrRecursive($parent_id);

        //add root category (name as menu name)
        if($add_root)
        {
            $result[0] = $this->label;
        }
        //pass through all
        foreach($all as $item)
        {
            //lines which shows how deep is item nesting
            $nestingLines = "";

            if($appendNestingLines)
            {
                //append them
                for($i=0; $i < $item->nestingLevel(); $i++)
                {
                    $nestingLines.="-";
                }
            }
            //create label for each id
            $result[$item->id] = $nestingLines.$item->label;
        }

        return $result;
    }

    /**
     * Groups array by root-categories (to build blocks easier in template)
     * @param $array
     * @return array
     */
    public function divideToRootGroups($array)
    {
        /* @var $array ExtMenuItem[] */

        $currentIndex = 0;
        $result = array();

        foreach($array as $item)
        {
            if(!$item->hasParent())
            {
                $currentIndex = $item->id;
            }

            $result[$currentIndex][] = $item;
        }

        return $result;
    }


    /**
     * Returns all items of menu as array (with translations and information of nesting) - use it for site templates
     * @param int $parent_id
     * @return array
     */
    public function buildMenuItemsArrayFromObjArr($parent_id = 0)
    {
        /* @var $arrayOfObj ExtMenuItem[] */

        $result = array();
        $arrayOfObj = $this->buildObjArrRecursive($parent_id);

        foreach($arrayOfObj as $itemObj)
        {
            $itemArr = $itemObj->attributes;
            $itemArr['nesting_level'] = $itemObj->nestingLevel();
            $itemArr['name'] = '';
            $itemArr['children_qnt'] = $itemObj->countOfChildren();
            $itemArr['has_children'] = (int)$itemObj->hasChildren();

            //find translation for this item
            $translations = $itemObj->menuItemTrls;
            foreach($translations as $translation)
            {
                if($translation->lng->prefix == Yii::app()->language)
                {
                    $itemArr['name'] = $translation->value;
                }
            }

            //add to result array
            $result[] = $itemArr;
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