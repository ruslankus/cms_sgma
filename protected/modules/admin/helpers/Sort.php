<?php
class Sort
{

    /**
     * Swaps priority of two items and updates
     * @param $id1
     * @param $id2
     * @param $className
     * @param bool $update
     * @return array
     */
    public static function SwapById($id1,$id2,$className,$update = true)
    {
        /* @var $className CActiveRecord */
        /* @var $objItem1 MenuItem | Page | Product | News */
        /* @var $objItem2 MenuItem | Page | Product | News */

        $objItem1 = $className::model()->findByPk($id1);
        $objItem2 = $className::model()->findByPk($id2);

        $p1 = $objItem1->priority;
        $objItem1->priority = $objItem2->priority;
        $objItem2->priority = $p1;

        if($update)
        {
            $objItem1->last_change_by = Yii::app()->user->getState('id');
            $objItem1->time_updated = time();
            $objItem1->update();

            $objItem2->last_change_by = Yii::app()->user->getState('id');
            $objItem2->time_updated = time();
            $objItem2->update();
        }

        return array($objItem1,$objItem2);
    }

    /**
     * Reorders priorities (used for ajax drag-n-drop sequence changing)
     * @param $oldOrder
     * @param $newOrder
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
     * @param $className
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
}