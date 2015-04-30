<?php
/**
 * Class ExtPage
 * @property ExtNews[] $news
 * @property ExtMenuItem $menuItem
 * @property NewsCategoryTrl $trl
 */
class ExtNewsCategory extends NewsCategory
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
     * Count of news in this category
     * @return string
     */
    public function countOfItems()
    {
        $count = News::model()->countByAttributes(array('category_id' => $this->id));
        return $count;
    }

    /**
     * Deletes all children of item
     */
    public function deleteChildren()
    {
        /* @var $children self[] */

        $children = $this->buildObjArrRecursive($this->id);

        foreach($children as $child)
        {
            $child->delete();
        }
    }


    /**
     * Build recursive array of categories (ORM) - use it for admin templates
     * @param int $parent_id
     * @param bool $only_active
     * @param string $order
     * @return array
     */
    public function buildObjArrRecursive($parent_id = 0, $only_active = false, $order = 'priority ASC')
    {
        /* @var $all ExtMenuItem[] */
        /* @var $tmp ExtMenuItem[] */

        $arr_result = array();

        $conditions = array();
        $conditions['parent_id'] = $parent_id;

        if($only_active)
        {
            $conditions['status_id'] = ExtStatus::VISIBLE;
        }

        $all = self::model()->findAllByAttributes($conditions,array('order' => $order));

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
     * Returns all items of category as array (with translations and information of nesting) - use it for site templates
     * @param int $parent_id
     * @param bool $only_active
     * @param string $order
     * @return array
     */
    public function buildMenuItemsArrayFromObjArr($parent_id = 0, $only_active = false, $order = 'priority ASC')
    {
        /* @var $arrayOfObj self[] */

        $result = array();
        $arrayOfObj = $this->buildObjArrRecursive($parent_id, $only_active, $order);

        foreach($arrayOfObj as $itemObj)
        {
            $itemArr = $itemObj->attributes;
            $itemArr['nesting_level'] = $itemObj->nestingLevel();
            $itemArr['name'] = $itemObj->trl->header;
            $itemArr['children_qnt'] = $itemObj->countOfChildren();
            $itemArr['has_children'] = (int)$itemObj->hasChildren();

            //add to result array
            $result[] = $itemArr;
        }

        return $result;
    }


    /**
     * All items (news) related with this category
     * @param bool $allFromNested
     * @param bool $only_active
     * @param string $order
     * @return ExtNews[]
     */
    public function allRelatedItems($allFromNested = false, $only_active = false, $order = 'priority ASC')
    {
        $items = array();

        //select just form this category
        if(!$allFromNested)
        {
            $conditions = array();
            $conditions['category_id'] = $this->id;
            if($only_active)
            {
                $conditions['status_id'] = ExtStatus::VISIBLE;
            }

            $items = ExtNews::model()->findAllByAttributes($conditions,array('order' => $order));
        }

        //select all items form this and nested categories
        else
        {
            /* @var $allItems ExtNews[] */

            $conditions = array();
            if($only_active)
            {
                $conditions['status_id'] = ExtStatus::VISIBLE;
            }

            $allItems = ExtNews::model()->findAllByAttributes($conditions);

            foreach($allItems as $item)
            {
                //get branch (path of item)
                $strBranch = $item->branch;
                $arrBranch = explode(':',$strBranch);

                //if path of item includes this category - item must be visible in it
                if(in_array($this->id,$arrBranch))
                {
                    $items[] = $item;
                }
            }
        }

        return $items;
    }


    /**
     * Groups array by root-categories (to build blocks easier in template)
     * @param int $parent_id
     * @param string $order
     * @return array
     */
    public function rootGroups($parent_id = 0, $order = 'priority ASC')
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
     * @param bool $addRoot
     * @param string $rootTitle
     * @return array
     */
    public function arrayForMenuItemForm($parent_id = 0,$appendNestingLines = true, $addRoot = true, $rootTitle = 'Root')
    {
        /* @var $all self[] */

        $result = array();

        //get all items
        $all = $this->buildObjArrRecursive($parent_id);

        //add root category (name as menu name)
        if($addRoot)
        {
            $result[0] = $rootTitle;
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
     * Returns bread-crumbs array
     * @param bool $translatable
     * @param bool $ignoreZero
     * @param string $titleForZero
     * @return array
     */
    public function breadCrumbs($translatable = false, $ignoreZero = true, $titleForZero = 'Root')
    {
        /* @var $category self */

        $crumbs = array();
        $branch = $this->branch;
        $arrBranch = explode(":",$branch);

        foreach($arrBranch as $id)
        {
            $category = self::model()->findByPk($id);

            if(!empty($category))
            {
                $crumbs[$id] = $translatable ? $category->trl->header : $category->label;
            }
            else
            {
                if($id == 0 && !$ignoreZero)
                {
                    $crumbs[$id] = $titleForZero;
                }
            }
        }

        return $crumbs;
    }

    /**
     * Returns trl or creates it if not found
     * @param $lngId
     * @return NewsCategoryTrl
     */
    public function getOrCreateTrl($lngId)
    {
        $all = $this->newsCategoryTrls;

        if(!empty($all))
        {
            foreach($all as $trl)
            {
                if($trl->lng_id == $lngId)
                {
                    return $trl;
                }
            }
        }

        $trl = new NewsCategoryTrl();
        $trl -> news_category_id = $this->id;
        $trl -> lng_id = $lngId;

        return $trl;
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
        $relations['trl'] = array(self::HAS_ONE, 'NewsCategoryTrl', 'news_category_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}