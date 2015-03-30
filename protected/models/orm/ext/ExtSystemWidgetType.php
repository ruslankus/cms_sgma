<?php
/**
 * Class ExtSystemWidgetType
 * @property ExtSystemWidget[] $systemWidgets
 */
Class ExtSystemWidgetType extends SystemWidgetType
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
     * Returns array for using in yii form's drop-downs
     * @param bool $translate
     * @return array
     */
    public function getAllTypesForForm($translate = false)
    {
        /* @var $types self[] */

        $result = array();
        $types = self::model()->findAll();

        foreach($types as $type)
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