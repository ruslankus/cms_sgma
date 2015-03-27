<?php
class Sort
{

    /**
     * Finds two item by PK, swaps priority and updates
     * @param $id1
     * @param $id2
     * @param $className
     * @param bool $update
     * @return  array | bool | MenuItem[] | Page[] | Product[] | News[] | CActiveRecord[]
     */
    public static function SwapById($id1,$id2,$className,$update = true)
    {
        /* @var $className CActiveRecord */
        /* @var $objItem1 MenuItem | Page | Product | News | CActiveRecord*/
        /* @var $objItem2 MenuItem | Page | Product | News | CActiveRecord*/

        $objItem1 = $className::model()->findByPk($id1);
        $objItem2 = $className::model()->findByPk($id2);

        if($objItem1 != null && $objItem2 != null)
        {
            $p1 = $objItem1->priority;
            $objItem1->priority = $objItem2->priority;
            $objItem2->priority = $p1;

            if($update)
            {
                $objItem1->update();
                $objItem2->update();
            }

            return array($objItem1,$objItem2);
        }

        return false;
    }


    /**
     * Swaps priority of two items
     * @param CActiveRecord $object1
     * @param CActiveRecord $object2
     * @param bool $update
     * @return array | bool | MenuItem[] | Page[] | Product[] | News[] | CActiveRecord[]
     */
    public  static function Swap($object1, $object2, $update = true)
    {
        /* @var $object1 MenuItem | Page | Product | News | CActiveRecord */
        /* @var $object2 MenuItem | Page | Product | News | CActiveRecord */

        //if objects not null
        if($object1 != null && $object2 != null)
        {
            //store first object's priority
            $pr1 = $object1->priority;
            //assign to first object priority pf second
            $object1->priority = $object2->priority;
            //assign to second object stored first object's priority
            $object2->priority = $pr1;

            if($update)
            {
                //update both
                $object1->update();
                $object2->update();
            }

            return array($object1,$object2);
        }

        return false;
    }

    /**
     * Reorders priorities (used for ajax drag-n-drop sequence changing)
     * @param array $oldOrder
     * @param array $newOrder
     */
    public static function ReorderMenuItems($oldOrder,$newOrder)
    {
        if(!empty($oldOrder) && !empty($newOrder) && count($oldOrder) == count($newOrder))
        {
            //get all items by old order's ID's and sort them by priority descending
            $items = ExtMenuItem::model()->findAllByAttributes(array('id' => $oldOrder),array('order' => 'priority DESC'));

            if(!empty($items))
            {
                //get max and min priorities
                $maxPriority = $items[0]->priority;
                $minPriority = $items[count($items)-1]->priority;

                //current iteration priority
                $current_priority = $maxPriority;

                //foreach ID in new order sequence
                foreach($newOrder as $id)
                {
                    //set current iteration priority
                    $item = ExtMenuItem::model()->findByPk($id);
                    $item->priority = $current_priority;
                    $item->last_change_by = Yii::app()->user->id;
                    $item->time_updated = time();
                    $item->update();

                    //decrease if not reached min
                    if($current_priority-1 >= $minPriority)
                    {
                        $current_priority--;
                    }
                }
            }

        }
    }

    /**
     * Returns next priority for some item (used in adding)
     * @param string $className
     * @param array $condition
     * @return int
     */
    public static function GetNextPriority($className,$condition = array())
    {
        /* @var $className CActiveRecord */
        /* @var $itemsAll MenuItem[] | Page[] | Product[] | News[] */

        $itemsAll = array();
        if(!empty($condition))
        {
            $itemsAll = $className::model()->findAllByAttributes($condition);
        }
        else
        {
            $itemsAll = $className::model()->findAll();
        }

        $max = 0;
        foreach($itemsAll as $item)
        {
            if($item->priority > $max)
            {
                $max = $item->priority;
            }
        }

        return $max + 1;
    }


    /**
     * Moves item's priority higher or lower
     * @param $movingObject MenuItem | Page | Product | News | CActiveRecord
     * @param string $direction
     * @param string $className
     * @param array $condition
     * @param string $order_by
     */
    public static function Move($movingObject,$direction,$className,$condition = array(),$order_by = 'priority DESC')
    {
        /* @var $className CActiveRecord */
        if(!empty($condition))
        {
            $all = $className::model()->findAllByAttributes($condition,array('order' => $order_by));
        }
        else
        {
            $all = $className::model()->findAll(array('order' => $order_by));
        }

        foreach($all as $index => $obj)
        {
            if($obj == $movingObject)
            {
                if($direction == 'up' && isset($all[$index - 1]))
                {
                    self::Swap($all[$index-1],$obj);
                }

                if($direction == 'down' && isset($all[$index + 1]))
                {
                    self::Swap($all[$index+1],$obj);
                }
            }
        }
    }
}