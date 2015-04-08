<?php
/**
 * Class ExtProductFieldTypes
 * @property ExtProductFields[] $productFields
 */
class ExtProductFieldTypes extends ProductFieldTypes
{

    //all of this constants are correspond to ID's in table 'product_field_types'
    const TYPE_NUMERIC = 1;
    const TYPE_DATE = 2;
    const TYPE_TEXT = 3;
    const TYPE_TRL_TEXT = 4;
    const TYPE_IMAGES = 5;
    const TYPE_SELECTABLE = 6;

    /**
     * @param string $className
     * @return self
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Prepare array special for menu-item form
     * @param bool $translate
     * @return array
     */
    public function arrayForMenuItemForm($translate = false)
    {
        /* @var $all ExtMenuItemType[] */

        $result = array();
        $all = self::model()->findAll();

        foreach($all as $type)
        {
            $result[$type->id] = $translate ? ATrl::t()->getLabel($type->label) : $type->label;
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