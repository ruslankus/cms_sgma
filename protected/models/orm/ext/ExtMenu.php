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
    public function getAllItemsSQL()
    {
        $sql = "SELECT t1.*, t2.`value` as trl FROM menu_item t1
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
     * Build recursive array of menu items (ORM)
     * @param int $parent_id
     * @return array
     */
    public function getArrayRecursive($parent_id = 0)
    {
        /* @var $all ExtMenuItem[] */
        /* @var $tmp ExtMenuItem[] */

        $arr_result = array();
        $all = ExtMenuItem::model()->findAllByAttributes(array('menu_id' => $this->id, 'parent_id' => $parent_id),array('order' => 'priority ASC'));

        foreach($all as $item)
        {
            $arr_result[] = $item;

            if($item->hasChildren())
            {
                $tmp = $this->getArrayRecursive($item->id);

                foreach($tmp as $itemTmp)
                {
                    $arr_result[] = $itemTmp;
                }
            }
        }

        return $arr_result;
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