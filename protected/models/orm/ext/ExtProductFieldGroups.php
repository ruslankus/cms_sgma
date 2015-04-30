<?php
/**
 * Class ExtProductFieldGroups
 * @property ExtProductFieldGroupsActive[] $productFieldGroupsActives
 * @property ExtProductFields[] $productFields
 * @property ProductFieldGroupsTrl $trl
 */
class ExtProductFieldGroups extends ProductFieldGroups
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
     * Returns trl or creates it if not found
     * @param $lngId
     * @return ProductFieldGroupsTrl
     */
    public function getOrCreateTrl($lngId)
    {
        $all = $this->productFieldGroupsTrls;

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

        $trl = new ProductFieldGroupsTrl();
        $trl -> group_id = $this;
        $trl -> lng_id = $lngId;

        return $trl;
    }


    /**
     * Build array which looks like (id => label), special for form-use
     * @return array
     */
    public function arrayForMenuItemForm()
    {
        /* @var $all self[] */

        $result = array();

        //get all items
        $all = $this->findAll(array('order' => 'priority ASC'));

        //pass through all
        foreach($all as $item)
        {
            //create label for each id
            $result[$item->id] = $item->label;
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

        //relate with translation
        $lng = Yii::app()->language;
        $relations['trl'] = array(self::HAS_ONE, 'ProductFieldGroupsTrl', 'group_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));
        $relations['productFields'] = array(self::HAS_MANY, 'ExtProductFields', 'group_id','order' => 'priority ASC');

        //return modified relations
        return $relations;
    }
}