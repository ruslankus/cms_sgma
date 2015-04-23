<?php
/**
 * Class ExtComplexPageFields
 * @property ExtComplexPageFieldSelectOptions[] $complexPageFieldSelectOptions
 * @property ExtComplexPageFieldValues[] $complexPageFieldValues
 * @property ExtComplexPageFieldTypes $type
 * @property ExtComplexPageFieldGroups $group
 * @property ComplexPageFieldsTrl $trl
 */
class ExtComplexPageFields extends ComplexPageFields
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
     * @return ExtComplexPageFieldValues
     */
    public function getValueObjForItem($itemId)
    {
        $values = $this->complexPageFieldValues;

        $resultValue = new ExtComplexPageFieldValues();

        foreach($values as $value)
        {
            if($value->page_id == $itemId)
            {
                return $value;
            }
        }

        $resultValue -> field_id = $this->id;
        $resultValue -> page_id = $itemId;
        return $resultValue;
    }


    /**
     * Returns trl or creates it if not found
     * @param $lngId
     * @return ComplexPageFieldsTrl
     */
    public function getOrCreateTrl($lngId)
    {
        $all = $this->complexPageFieldsTrls;

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

        $trl = new ComplexPageFieldsTrl();
        $trl -> page_field_id = $this->id;
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
        $relations['trl'] = array(self::HAS_ONE, 'ComplexPageFieldsTrl', 'page_field_id', 'with' => array('lng' => array('condition' => "lng.prefix='{$lng}'")));

        //return modified relations
        return $relations;
    }
}