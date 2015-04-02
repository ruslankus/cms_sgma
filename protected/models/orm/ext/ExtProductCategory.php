<?php
/**
 * Class ExtPage
 * @property ExtProduct[] $products
 * @property ExtMenuItem $menuItem
 * @property ProductCategoryTrl $trl
 */
class ExtProductCategory extends ProductCategory
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
        $count = self::model()->countByAttributes(array('id' => $this->parent_id));
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
        $count = self::model()->countByAttributes(array('parent_id' => $this->id));
        return $count;
    }


    /**
     * Build recursive array of categories (ORM) - use it for admin templates
     * @param int $parent_id
     * @param string $order
     * @return array
     */
    public function buildObjArrRecursive($parent_id = 0, $order = 'priority DESC')
    {
        /* @var $all ExtMenuItem[] */
        /* @var $tmp ExtMenuItem[] */

        $arr_result = array();
        $all = self::model()->findAllByAttributes(array('parent_id' => $parent_id),array('order' => $order));

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
     * Groups array by root-categories (to build blocks easier in template)
     * @param int $parent_id
     * @param string $order
     * @return array
     */
    public function rootGroups($parent_id = 0, $order = 'priority DESC')
    {
        /* @var $array self[] */

        $array = $this->buildObjArrRecursive($parent_id,$order);

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
     * Build array which looks like (id => label), special for form-use
     * @param int $parent_id
     * @param bool $appendNestingLines
     * @param bool $add_root
     * @return array
     */
    public function arrayForMenuItemForm($parent_id = 0,$appendNestingLines = true, $add_root = true)
    {
        /* @var $all self[] */

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
     * Updates branch of item (use it after save, don't use if record is new!!!)
     * @return bool
     */
    public function updateBranch()
    {
        if(!$this->getIsNewRecord())
        {
            if($this->parent_id != 0)
            {
                $parent = $this->getParent();
                $arrBranch = !empty($parent) ? explode(":",$parent->branch) : array(0);
            }
            else
            {
                $arrBranch = array(0);
            }

            $arrBranch[] = $this->id;
            $strBranch = implode(":",$arrBranch);
            $this->branch = $strBranch;
            $this->update();

            return true;
        }
        else
        {
            return false;
        }
    }


    /**
     * Returns nesting level
     * @param bool $byBranch
     * @return int
     */
    public function nestingLevel($byBranch = true)
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
        $relations['trl'] = array(self::HAS_ONE, 'ProductCategoryTrl', 'product_category_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}