<?php
/**
 * Class ExtProductFieldGroups
 * @property ExtProductFieldSelectOptions[] $productFieldSelectOptions
 * @property ExtProductFieldValues[] $productFieldValues
 * @property ExtProductFieldTypes $type
 * @property ExtProductFieldGroups $group
 * @property ProductFieldsTrl $trl
 */
class ExtProductFields extends ProductFields
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
     * Get value for dynamic field of specified item
     * @param $itemId
     * @return ExtProductFieldValues
     */
    public function getValueObjForItem($itemId)
    {
        $values = $this->productFieldValues;

        $resultValue = new ExtProductFieldValues();

        foreach($values as $value)
        {
            if($value->product_id == $itemId)
            {
                return $value;
            }
        }

        $resultValue -> field_id = $this->id;
        $resultValue -> product_id = $itemId;
        return $resultValue;
    }


    /**
     * Returns trl or creates it if not found
     * @param $lngId
     * @return ProductFieldsTrl
     */
    public function getOrCreateTrl($lngId)
    {
        $all = $this->productFieldsTrls;

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

        $trl = new ProductFieldsTrl();
        $trl -> product_field_id = $this->id;
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
        $relations['trl'] = array(self::HAS_ONE, 'ProductFieldsTrl', 'product_field_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}