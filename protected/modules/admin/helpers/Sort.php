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
}